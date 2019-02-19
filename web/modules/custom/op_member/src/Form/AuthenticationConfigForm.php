<?php
/**
 * Created by PhpStorm.
 * User: eric_
 * Date: 15/2/2019
 * Time: 13:30
 */

namespace Drupal\op_member\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;

class AuthenticationConfigForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'op_member_authentication_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'op_member.authentication',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Form constructor.
    $form = parent::buildForm($form, $form_state);

    // Default settings.
    $config = $this->config('op_member.authentication');

    // Fields
    $form['user_settings_password_reset_timeout'] = array(
      '#type' => 'number',
      '#title' => $this->t('Password Reset Link Validity (seconds)'),
      '#default_value' => $config->get('user_settings_password_reset_timeout'),
      '#description' => $this->t('The validity of password reset link in seconds. Applies to reset password and first time user login link. Drupal default is 1 day (86400).'),
    );
    $form['logout_destination_node_id'] = array(
      '#type' => 'entity_autocomplete',
      '#title' => $this->t('Logout Destination Node ID'),
      '#target_type' => 'node',
      '#default_value' => $config->get('logout_destination_node_id') ? Node::load($config->get('logout_destination_node_id')) : NULL,
      '#description' => $this->t('User will be redirected to this node after logout. Defaults to front page if not set.'),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('op_member.authentication');
    $config->set('user_settings_password_reset_timeout', $form_state->getValue('user_settings_password_reset_timeout'));
    $config->set('logout_destination_node_id', $form_state->getValue('logout_destination_node_id'));
    $config->save();

    parent::submitForm($form, $form_state);
  }
}