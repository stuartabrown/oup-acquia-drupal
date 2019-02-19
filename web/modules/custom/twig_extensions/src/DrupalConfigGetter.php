<?php
/**
 * Created by PhpStorm.
 * User: eric_
 * Date: 15/2/2019
 * Time: 14:12
 */

// REF: https://medium.com/@thihathit/extending-custom-twig-extension-to-drupal-8-twig-extension-class-d4b99c2177ae

namespace Drupal\twig_extensions;


class DrupalConfigGetter extends \Twig_Extension {
  public function getFunctions() {
    return [
      new \Twig_SimpleFunction('get_drupal_config', [$this, 'get_drupal_config']),
    ];
  }

  public static function get_drupal_config($name, $key) {
    return \Drupal::config($name)->get($key);
  }
}
