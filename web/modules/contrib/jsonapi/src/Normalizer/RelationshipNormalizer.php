<?php

namespace Drupal\jsonapi\Normalizer;

use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\jsonapi\JsonApiResource\ResourceIdentifier;
use Drupal\jsonapi\Normalizer\Value\CacheableNormalization;
use Drupal\jsonapi\ResourceType\ResourceType;
use Drupal\jsonapi\LinkManager\LinkManager;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Normalizes a Relationship according to the JSON:API specification.
 *
 * Normalizer class for relationship elements. A relationship can be anything
 * that points to an entity in a JSON:API resource.
 *
 * @internal
 */
class RelationshipNormalizer extends NormalizerBase implements DenormalizerInterface {

  /**
   * The interface or class that this Normalizer supports.
   *
   * @var string
   */
  protected $supportedInterfaceOrClass = Relationship::class;

  /**
   * The formats that the Normalizer can handle.
   *
   * @var array
   */
  protected $formats = ['api_json'];

  /**
   * The link manager.
   *
   * @var \Drupal\jsonapi\LinkManager\LinkManager
   */
  protected $linkManager;

  /**
   * The entity field manager.
   *
   * @var \Drupal\Core\Entity\EntityFieldManagerInterface
   */
  protected $fieldManager;

  /**
   * RelationshipNormalizer constructor.
   *
   * @param \Drupal\jsonapi\LinkManager\LinkManager $link_manager
   *   The link manager.
   * @param \Drupal\Core\Entity\EntityFieldManagerInterface $field_manager
   *   The entity field manager.
   */
  public function __construct(LinkManager $link_manager, EntityFieldManagerInterface $field_manager) {
    $this->linkManager = $link_manager;
    $this->fieldManager = $field_manager;
  }

  /**
   * {@inheritdoc}
   */
  public function denormalize($data, $class, $format = NULL, array $context = []) {
    // If we get here, it's via a relationship POST/PATCH.
    /** @var \Drupal\jsonapi\ResourceType\ResourceType $resource_type */
    $resource_type = $context['resource_type'];
    $entity_type_id = $resource_type->getEntityTypeId();
    $field_definitions = $this->fieldManager->getFieldDefinitions(
      $entity_type_id,
      $resource_type->getBundle()
    );
    if (empty($context['related']) || empty($field_definitions[$context['related']])) {
      throw new BadRequestHttpException('Invalid or missing related field.');
    }
    /* @var \Drupal\field\Entity\FieldConfig $field_definition */
    $field_definition = $field_definitions[$context['related']];
    // This is typically 'target_id'.
    $item_definition = $field_definition->getItemDefinition();
    $property_key = $item_definition->getMainPropertyName();
    $target_resource_types = $resource_type->getRelatableResourceTypesByField($resource_type->getPublicName($context['related']));
    $target_resource_type_names = array_map(function (ResourceType $resource_type) {
      return $resource_type->getTypeName();
    }, $target_resource_types);

    $is_multiple = $field_definition->getFieldStorageDefinition()->isMultiple();
    $data = $this->massageRelationshipInput($data, $is_multiple);
    $resource_identifiers = array_map(function ($value) use ($property_key, $target_resource_type_names) {
      // Make sure that the provided type is compatible with the targeted
      // resource.
      if (!in_array($value['type'], $target_resource_type_names)) {
        throw new BadRequestHttpException(sprintf(
          'The provided type (%s) does not mach the destination resource types (%s).',
          $value['type'],
          implode(', ', $target_resource_type_names)
        ));
      }
      return new ResourceIdentifier($value['type'], $value['id'], isset($value['meta']) ? $value['meta'] : []);
    }, $data['data']);
    if (!ResourceIdentifier::areResourceIdentifiersUnique($resource_identifiers)) {
      throw new BadRequestHttpException('Duplicate relationships are not permitted. Use `meta.arity` to distinguish resource identifiers with matching `type` and `id` values.');
    }
    return $resource_identifiers;
  }

  /**
   * Validates and massages the relationship input depending on the cardinality.
   *
   * @param array $data
   *   The input data from the body.
   * @param bool $is_multiple
   *   Indicates if the relationship is to-many.
   *
   * @return array
   *   The massaged data array.
   */
  protected function massageRelationshipInput(array $data, $is_multiple) {
    if ($is_multiple) {
      if (!is_array($data['data'])) {
        throw new BadRequestHttpException('Invalid body payload for the relationship.');
      }
      // Leave the invalid elements.
      $invalid_elements = array_filter($data['data'], function ($element) {
        return empty($element['type']) || empty($element['id']);
      });
      if ($invalid_elements) {
        throw new BadRequestHttpException('Invalid body payload for the relationship.');
      }
    }
    else {
      // For to-one relationships you can have a NULL value.
      if (is_null($data['data'])) {
        return ['data' => []];
      }
      if (empty($data['data']['type']) || empty($data['data']['id'])) {
        throw new BadRequestHttpException('Invalid body payload for the relationship.');
      }
      $data['data'] = [$data['data']];
    }
    return $data;
  }

  /**
   * Helper function to normalize field items.
   *
   * @param \Drupal\jsonapi\Normalizer\Relationship|object $relationship
   *   The field object.
   * @param string $format
   *   The format.
   * @param array $context
   *   The context array.
   *
   * @return \Drupal\jsonapi\Normalizer\Value\CacheableNormalization
   *   The array of normalized field items.
   */
  public function normalize($relationship, $format = NULL, array $context = []) {
    /* @var \Drupal\jsonapi\Normalizer\Relationship $relationship */
    $normalizer_items = [];
    foreach ($relationship->getItems() as $relationship_item) {
      // If the relationship points to a disabled resource type, do not add the
      // normalized relationship item.
      if (!$relationship_item->getTargetResourceType()) {
        continue;
      }
      $normalizer_items[] = $this->serializer->normalize($relationship_item, $format, $context);
    }
    $cardinality = $relationship->getCardinality();
    assert($context['resource_type'] instanceof ResourceType);
    $resource_type = $context['resource_type'];
    $field_name = $resource_type->getPublicName($relationship->getPropertyName());
    $links = $this->getLinks($resource_type, $field_name, $relationship->getHostEntity()->uuid());
    $data = CacheableNormalization::aggregate($normalizer_items);
    $rasterized = $data->getNormalization();
    return (new CacheableNormalization($relationship, [
      // Empty 'to-one' relationships must be NULL.
      // Empty 'to-many' relationships must be an empty array.
      // @link http://jsonapi.org/format/#document-resource-object-linkage
      'data' => $cardinality === 1 ? array_shift($rasterized) : static::ensureUniqueResourceIdentifierObjects($rasterized),
      'links' => $links,
    ]))->withCacheableDependency($data);
  }

  /**
   * Ensures each resource identifier object is unique.
   *
   * The official JSON:API JSON-Schema document requires that no two resource
   * identifier objects are duplicated.
   *
   * This adds an @code arity @endcode member to each object's
   * @code meta @endcode member. The value of this member is an integer that is
   * incremented by 1 (starting from 0) for each repeated resource identifier
   * sharing a common @code type @endcode and @code id @endcode.
   *
   * @param array $resource_identifier_objects
   *   A list of JSON:API resource identifier objects.
   *
   * @return array
   *   A set of JSON:API resource identifier objects, with those having multiple
   *   occurrences getting [meta][arity].
   *
   * @see http://jsonapi.org/format/#document-resource-object-relationships
   * @see https://github.com/json-api/json-api/pull/1156#issuecomment-325377995
   * @see https://www.drupal.org/project/jsonapi/issues/2864680
   */
  public static function ensureUniqueResourceIdentifierObjects(array $resource_identifier_objects) {
    if (count($resource_identifier_objects) <= 1) {
      return $resource_identifier_objects;
    }

    // Count each repeated resource identifier and track their array indices.
    $analysis = [];
    foreach ($resource_identifier_objects as $index => $rio) {
      $composite_key = $rio['type'] . ':' . $rio['id'];

      $analysis[$composite_key]['count'] = isset($analysis[$composite_key])
        ? $analysis[$composite_key]['count'] + 1
        : 0;

      // The index will later be used to assign an arity to repeated resource
      // identifier objects. Doing this in two phases prevents adding an arity
      // to objects which only occur once.
      $analysis[$composite_key]['indices'][] = $index;
    }

    // Assign an arity to objects whose type + ID pair occurred more than once.
    foreach ($analysis as $computed) {
      if ($computed['count'] > 0) {
        foreach ($computed['indices'] as $arity => $index) {
          $resource_identifier_objects[$index]['meta']['arity'] = $arity;
        }
      }
    }

    return $resource_identifier_objects;
  }

  /**
   * Gets the links for the relationship.
   *
   * @param \Drupal\jsonapi\ResourceType\ResourceType $resource_type
   *   The JSON:API resource type on which the relationship being normalized
   *   resides.
   * @param string $field_name
   *   The field name for the relationship.
   * @param string $host_entity_id
   *   The ID of the entity on which the relationship resides.
   *
   * @return array
   *   An array of links to be rasterized.
   */
  protected function getLinks(ResourceType $resource_type, $field_name, $host_entity_id) {
    $relationship_field_name = $resource_type->getPublicName($field_name);
    $route_parameters = [
      'related' => $relationship_field_name,
    ];
    $links['self']['href'] = $this->linkManager->getEntityLink(
      $host_entity_id,
      $resource_type,
      $route_parameters,
      "$relationship_field_name.relationship.get"
    );
    $resource_types = $resource_type->getRelatableResourceTypesByField($field_name);
    if (static::hasNonInternalResourceType($resource_types)) {
      $links['related']['href'] = $this->linkManager->getEntityLink(
        $host_entity_id,
        $resource_type,
        $route_parameters,
        "$relationship_field_name.related"
      );
    }
    return $links;
  }

  /**
   * Determines if a given list of resource types contains a non-internal type.
   *
   * @param \Drupal\jsonapi\ResourceType\ResourceType[] $resource_types
   *   The JSON:API resource types to evaluate.
   *
   * @return bool
   *   FALSE if every resource type is internal, TRUE otherwise.
   */
  protected static function hasNonInternalResourceType(array $resource_types) {
    foreach ($resource_types as $resource_type) {
      if (!$resource_type->isInternal()) {
        return TRUE;
      }
    }
    return FALSE;
  }

}
