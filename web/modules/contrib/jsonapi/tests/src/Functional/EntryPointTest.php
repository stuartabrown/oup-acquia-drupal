<?php

namespace Drupal\Tests\jsonapi\Functional;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Url;
use Drupal\Tests\BrowserTestBase;
use GuzzleHttp\RequestOptions;

/**
 * Makes assertions about the JSON:API behavior for internal entities.
 *
 * @group jsonapi
 *
 * @internal
 */
class EntryPointTest extends BrowserTestBase {

  use JsonApiRequestTestTrait;

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'node',
    'jsonapi',
  ];

  /**
   * Test GETing the entry point.
   */
  public function testEntryPoint() {
    $response = $this->request('GET', Url::fromUri('base://jsonapi'), [RequestOptions::HEADERS => ['Accept' => 'application/vnd.api+json']]);
    $document = Json::decode((string) $response->getBody());
    $expected_cache_contexts = [
      // @todo: remove the `url.query_args` cache contexts in https://www.drupal.org/project/jsonapi/issues/2992673.
      'url.query_args:fields',
      'url.query_args:include',
      'url.site',
      'user.roles:authenticated',
    ];
    $this->assertTrue($response->hasHeader('X-Drupal-Cache-Contexts'));
    $optimized_expected_cache_contexts = \Drupal::service('cache_contexts_manager')->optimizeTokens($expected_cache_contexts);
    $this->assertSame($optimized_expected_cache_contexts, explode(' ', $response->getHeader('X-Drupal-Cache-Contexts')[0]));
    $links = $document['links'];
    $this->assertRegExp('/.*\/jsonapi/', $links['self']['href']);
    $this->assertRegExp('/.*\/jsonapi\/user\/user/', $links['user--user']['href']);
    $this->assertRegExp('/.*\/jsonapi\/node_type\/node_type/', $links['node_type--node_type']['href']);
    $this->assertArrayNotHasKey('meta', $document);
  }

}
