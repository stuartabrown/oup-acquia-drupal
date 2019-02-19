<?php

namespace Drupal\Tests\lightning_api;

use Drupal\Tests\lightning_core\FixtureBase;

/**
 * Performs set-up and tear-down tasks before and after each test scenario.
 */
final class FixtureContext extends FixtureBase {

  /**
   * @BeforeScenario
   */
  public function setUp() {
    $this->config('lightning_api.settings')
      ->set('entity_json', TRUE)
      ->set('bundle_docs', TRUE)
      ->save();

    // Lightning Core's FixtureContext installs modules, so we'll want to get
    // the current container to be sure we don't run into weird errors.
    /** @var \Symfony\Component\DependencyInjection\ContainerInterface $container */
    $container = $this->container->get('kernel')->getContainer();
    $this->setContainer($container);

    // Clear important caches to expose the new content type as needed.
    $container->get('router.builder')->rebuild();
    $container->get('entity_type.bundle.info')->clearCachedBundles();
  }

  /**
   * @AfterScenario
   */
  public function tearDown() {
    parent::tearDown();
  }

}
