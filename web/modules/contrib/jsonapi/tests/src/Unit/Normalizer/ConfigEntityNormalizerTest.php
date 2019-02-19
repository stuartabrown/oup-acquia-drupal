<?php

namespace Drupal\Tests\jsonapi\Unit\Normalizer;

use Drupal\Core\Config\Entity\ConfigEntityInterface;
use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Field\FieldTypePluginManagerInterface;
use Drupal\jsonapi\ResourceType\ResourceType;
use Drupal\jsonapi\ResourceType\ResourceTypeRepository;
use Drupal\jsonapi\Normalizer\ConfigEntityNormalizer;
use Drupal\jsonapi\LinkManager\LinkManager;
use Drupal\Tests\UnitTestCase;
use Prophecy\Argument;

/**
 * @coversDefaultClass \Drupal\jsonapi\Normalizer\ConfigEntityNormalizer
 * @group jsonapi
 *
 * @internal
 */
class ConfigEntityNormalizerTest extends UnitTestCase {

  /**
   * The normalizer under test.
   *
   * @var \Drupal\jsonapi\Normalizer\ConfigEntityNormalizer
   */
  protected $normalizer;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $link_manager = $this->prophesize(LinkManager::class);

    $field_mapping = array_fill_keys([
      'lorem',
      'ipsum',
      'dolor',
      'sid',
      'amet',
      'ra',
      'foo',
    ], TRUE);
    $resource_type = new ResourceType('dolor', 'sid', NULL, FALSE, TRUE, TRUE, $field_mapping);
    $resource_type->setRelatableResourceTypes([]);
    $resource_type_repository = $this->prophesize(ResourceTypeRepository::class);
    $resource_type_repository->get(Argument::type('string'), Argument::type('string'))
      ->willReturn($resource_type);

    $this->normalizer = new ConfigEntityNormalizer(
      $link_manager->reveal(),
      $resource_type_repository->reveal(),
      $this->prophesize(EntityTypeManagerInterface::class)->reveal(),
      $this->prophesize(EntityFieldManagerInterface::class)->reveal(),
      $this->prophesize(FieldTypePluginManagerInterface::class)->reveal()
    );
  }

  /**
   * @covers ::normalize
   * @dataProvider normalizeProvider
   */
  public function testNormalize($input, $expected) {
    $entity = $this->prophesize(ConfigEntityInterface::class);
    $entity->uuid()->willReturn('foo');
    $entity->toArray()->willReturn(['amet' => $input]);
    $entity->getCacheContexts()->willReturn([]);
    $entity->getCacheTags()->willReturn([]);
    $entity->getCacheMaxAge()->willReturn(-1);
    $entity->getEntityTypeId()->willReturn('');
    $entity->bundle()->willReturn('');
    $normalized = $this->normalizer->normalize($entity->reveal(), 'api_json', []);
    $this->assertSame($expected, $normalized->getNormalization()['attributes']['amet']);
  }

  /**
   * Data provider for the normalize test.
   *
   * @return array
   *   The data for the test method.
   */
  public function normalizeProvider() {
    return [
      ['lorem', 'lorem'],
      [
        ['ipsum' => 'dolor', 'ra' => 'foo'],
        ['ipsum' => 'dolor', 'ra' => 'foo'],
      ],
      [
        ['ipsum' => 'dolor'],
        ['ipsum' => 'dolor'],
      ],
      [
        ['lorem' => ['ipsum' => ['dolor' => 'sid', 'amet' => 'ra']]],
        ['lorem' => ['ipsum' => ['dolor' => 'sid', 'amet' => 'ra']]],
      ],
    ];
  }

}
