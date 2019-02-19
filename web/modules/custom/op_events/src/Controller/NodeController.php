<?php
namespace Drupal\op_events\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\op_events\EventManager;

/**
 * Provides route responses for the op_events module.
 */
class NodeController extends ControllerBase {

    /**
   * Returns a summary page.
   *
   * @return array
   *   A simple renderable array.
   */
  public function summaryPage() {
    $element = array(
      '#type' => 'container',
      'description' => [
        '#type' => 'container',
        '#weight' => 50,
        'paragraph' => [
          '#type' => 'html_tag',
          '#tag' => 'p',
          '#value' => 'Manually purge the local events cache, download the events form Salesforce, and then store in local database.',
        ]
      ],
      'link' => [
        '#type' => 'inline_template',
        '#template' => '<a class="button button--primary" href="/admin/op_events/download_events">Download Events From Salesforce</a>',
        '#weight' => 99
      ]
    );
    return $element;
  }

}