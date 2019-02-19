<?php

namespace Drupal\jsonapi\Normalizer;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\jsonapi\Normalizer\Value\CacheableNormalization;
use Drupal\jsonapi\ResourceType\ResourceTypeRepositoryInterface;

/**
 * Converts the Drupal entity reference item object to a JSON:API structure.
 *
 * @internal
 */
class RelationshipItemNormalizer extends FieldItemNormalizer {

  /**
   * The interface or class that this Normalizer supports.
   *
   * @var string
   */
  protected $supportedInterfaceOrClass = RelationshipItem::class;

  /**
   * The JSON:API resource type repository.
   *
   * @var \Drupal\jsonapi\ResourceType\ResourceTypeRepositoryInterface
   */
  protected $resourceTypeRepository;

  /**
   * Instantiates a RelationshipItemNormalizer object.
   *
   * @param \Drupal\jsonapi\ResourceType\ResourceTypeRepositoryInterface $resource_type_repository
   *   The JSON:API resource type repository.
   */
  public function __construct(ResourceTypeRepositoryInterface $resource_type_repository) {
    $this->resourceTypeRepository = $resource_type_repository;
  }

  /**
   * {@inheritdoc}
   */
  public function normalize($relationship_item, $format = NULL, array $context = []) {
    assert($relationship_item instanceof RelationshipItem);
    $values = $relationship_item->getValue();
    if (isset($context['langcode'])) {
      $values['lang'] = $context['langcode'];
    }

    $value = static::rasterizeValueRecursive(count($values) == 1 ? reset($values) : $values);
    if (!$value) {
      $normalized = $value;
    }
    else {
      $normalized = [
        'type' => $relationship_item->getTargetResourceType()->getTypeName(),
        'id' => empty($value['target_uuid']) ? $value : $value['target_uuid'],
      ];

      if (!empty($value['meta'])) {
        $normalized['meta'] = $value['meta'];
      }
    }

    return new CacheableNormalization(new CacheableMetadata(), $normalized);
  }

}
