<?php
/**
 * Created by PhpStorm.
 * User: eric_
 * Date: 13/2/2019
 * Time: 21:11
 */

namespace Drupal\op_member;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\ConfigFactoryOverrideInterface;
use Drupal\Core\Config\StorageInterface;

class ConfigOverrides implements ConfigFactoryOverrideInterface
{
  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs the object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
    $this->authConfig = $this->configFactory->get('op_member.authentication');
  }

  /**
   * The settings of the factory taxonomy configuration.
   *
   * @var \Drupal\Core\Config\Config
   */
  protected $authConfig;

  /**
   * {@inheritdoc}
   */
  public function loadOverrides($names) {
    $overrides = array();

    // disable flood control, Login Security module will take care of blocking
    if (in_array('user.flood', $names)) {
      // Login security uses flood control's log table to track login attempts, (table name = 'flood')
      // but we do not want flood control to actually lock out the account,
      // on the other hand Login Security respects flood control's `window` settings,
      // so we set window to 1 year to allow counting to work,
      // while setting limit to very large so that the limit is never really hit from flood control's perspective
      if(\Drupal::moduleHandler()->moduleExists('login_security')) {
        $overrides['user.flood'] = [
          'ip_limit'    => 2147483647, // DB INT MAX
          'ip_window'   => 31536000,   // 1year
          'user_limit'  => 2147483647, // DB INT Max
          'user_window' => 31536000,   // 1year
        ];
      }
    }

    if (in_array('user.settings', $names)) {
      $overrides['user.settings'] = [];

      // disable built in password strength if `password_policy` module is enabled
      if(\Drupal::moduleHandler()->moduleExists('password_policy')) {
        $overrides['user.settings']['password_strength'] = false;
      }

      // apply custom password reset timeout
      $password_reset_timeout = $this->authConfig->get('user_settings_password_reset_timeout');
      if(!empty($password_reset_timeout)) {
        $overrides['user.settings']['password_reset_timeout'] = $password_reset_timeout;
      }
    }

    return $overrides;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheSuffix() {
    return 'ModifyFloodConfig';
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheableMetadata($name) {
    return new CacheableMetadata();
  }

  /**
   * {@inheritdoc}
   */
  public function createConfigObject($name, $collection = StorageInterface::DEFAULT_COLLECTION) {
    return NULL;
  }
}