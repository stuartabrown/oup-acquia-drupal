<?php

namespace Drupal\layout_builder_fix_multilingual\Plugin\SectionStorage;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\FieldableEntityInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Plugin\Context\EntityContext;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Url;
use Drupal\layout_builder\Entity\LayoutBuilderEntityViewDisplay;
use Drupal\layout_builder\OverridesSectionStorageInterface;
use Drupal\layout_builder\SectionListInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\RouteCollection;
use Drupal\Core\Language\LanguageInterface;
use Drupal\layout_builder\Plugin\SectionStorage\OverridesSectionStorage;
use Drupal\layout_builder\Plugin\SectionStorage\SectionStorageLocalTaskProviderInterface;

/**
 * Defines the 'overrides' section storage type.
 *
 * @SectionStorage(
 *   id = "overrides",
 * )
 *
 * @internal
 *   Layout Builder is currently experimental and should only be leveraged by
 *   experimental modules and development releases of contributed modules.
 *   See https://www.drupal.org/core/experimental for more information.
 */
class OverridesSectionStorageExtended extends OverridesSectionStorage implements ContainerFactoryPluginInterface, OverridesSectionStorageInterface, SectionStorageLocalTaskProviderInterface {

  /**
   * The field name used by this storage.
   *
   * @var string
   */
  const FIELD_NAME = 'layout_builder__layout';

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The entity field manager.
   *
   * @var \Drupal\Core\Entity\EntityFieldManagerInterface
   */
  protected $entityFieldManager;

  /**
   * {@inheritdoc}
   *
   * @var \Drupal\layout_builder\SectionListInterface|\Drupal\Core\Field\FieldItemListInterface
   */
  protected $sectionList;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager, EntityFieldManagerInterface $entity_field_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $entity_type_manager, $entity_field_manager);

    $this->entityTypeManager = $entity_type_manager;
    $this->entityFieldManager = $entity_field_manager;
  }

  /**
   * {@inheritdoc}
   */
  public function getStorageId() {
    $entity = $this->getEntity();
    return $entity->getEntityTypeId() . '.' . $entity->id();
  }

  /**
   * {@inheritdoc}
   */
  public function getSectionListFromId($id) {
    if (strpos($id, '.') !== FALSE) {
      list($entity_type_id, $entity_id) = explode('.', $id, 2);
      $entity = $this->entityTypeManager->getStorage($entity_type_id)->load($entity_id);
      if ($entity instanceof FieldableEntityInterface && $entity->hasField(static::FIELD_NAME)) {
        $langcode = \Drupal::languageManager()->getCurrentLanguage(LanguageInterface::TYPE_URL);
        $translation = $entity->getTranslation($langcode->getId());
        if($translation->hasField(static::FIELD_NAME)){
          return $translation->get(static::FIELD_NAME);
        }
      }
    }
    throw new \InvalidArgumentException(sprintf('The "%s" ID for the "%s" section storage type is invalid', $id, $this->getStorageType()));
  }

}
