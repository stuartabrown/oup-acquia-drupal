<?php

namespace Drupal\jsonapi\Normalizer;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\jsonapi\LabelOnlyEntity;
use Drupal\jsonapi\LinkManager\LinkManager;
use Drupal\jsonapi\Normalizer\Value\CacheableNormalization;
use Drupal\jsonapi\ResourceType\ResourceType;
use Drupal\jsonapi\ResourceType\ResourceTypeRepositoryInterface;

/**
 * Pretends that the entity only has a single field: the label field.
 *
 * @see \Drupal\jsonapi\Normalizer\EntityNormalizer::normalize()
 *
 * @internal
 */
class LabelOnlyEntityNormalizer extends NormalizerBase {

  /**
   * {@inheritdoc}
   */
  protected $supportedInterfaceOrClass = LabelOnlyEntity::class;

  /**
   * {@inheritdoc}
   */
  protected $formats = ['api_json'];

  /**
   * The link manager.
   *
   * @var \Drupal\jsonapi\LinkManager\LinkManager
   */
  protected $linkManager;

  /**
   * The JSON:API resource type repository.
   *
   * @var \Drupal\jsonapi\ResourceType\ResourceTypeRepositoryInterface
   */
  protected $resourceTypeRepository;

  /**
   * Constructs an LabelOnlyEntityNormalizer object.
   *
   * @param \Drupal\jsonapi\LinkManager\LinkManager $link_manager
   *   The link manager.
   * @param \Drupal\jsonapi\ResourceType\ResourceTypeRepositoryInterface $resource_type_repository
   *   The JSON:API resource type repository.
   */
  public function __construct(LinkManager $link_manager, ResourceTypeRepositoryInterface $resource_type_repository) {
    $this->linkManager = $link_manager;
    $this->resourceTypeRepository = $resource_type_repository;
  }

  /**
   * {@inheritdoc}
   */
  public function normalize($label_only_entity, $format = NULL, array $context = []) {
    assert($label_only_entity instanceof LabelOnlyEntity);
    $entity = $label_only_entity->getEntity();

    $context['resource_type'] = $this->resourceTypeRepository->get(
      $entity->getEntityTypeId(),
      $entity->bundle()
    );

    // Determine the (internal) label field name.
    $label_field_name = $label_only_entity->getLabelFieldName();

    // Determine the public alias for the label field name.
    assert($context['resource_type'] instanceof ResourceType);
    $resource_type = $context['resource_type'];
    $public_field_label_name = $resource_type->getPublicName($label_field_name);

    // Perform the default entity normalization, extract all values from the
    // resulting CacheableNormalization object.
    // @see \Drupal\jsonapi\Normalizer\EntityNormalizer::normalize()
    $normalized = $this->serializer->normalize($entity, $format, $context);
    assert($normalized instanceof CacheableNormalization);
    $rasterized = $normalized->getNormalization();

    // Reconstruct a CacheableNormalization object, this time with only the
    // label field.
    $label_only_attributes = [$public_field_label_name => $rasterized['attributes'][$public_field_label_name]];
    $rasterized['attributes'] = $label_only_attributes;
    // This associates the cacheability of all normalized fields with the
    // returned CacheableNormalization. This is not necessary and can result in
    // unwanted cache invalidations. Only the cacheability of the entity and its
    // label field is truly required.
    // @todo: ensure precise and correct cacheability is returned in https://www.drupal.org/project/jsonapi/issues/3015438.
    return new CacheableNormalization(CacheableMetadata::createFromObject($normalized), $rasterized);
  }

}
