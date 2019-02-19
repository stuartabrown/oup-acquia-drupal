<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 2019-02-15
 * Time: 00:59
 */

namespace Drupal\op_member\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class SalesforceMemberForm extends ConfigFormBase {
  public static $adminSettingKey = 'salesforce_member.adminsettings';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'salesforce_member_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'salesforce_member.adminsettings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Form constructor.
    $form = parent::buildForm($form, $form_state);
    // Default settings.
    $config = $this->config('salesforce_member.adminsettings');
    // Username
    $form['magic_member_id'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Salesforce Magic Member ID'),
      '#default_value' => $config->get('salesforce_member.magic_member_id'),
      '#description' => $this->t('This magic member ID will be used by admin only, and allowed to exist across multiple accounts.'),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('salesforce_member.adminsettings');
    $config->set('salesforce_member.magic_member_id', strtolower(trim($form_state->getValue('magic_member_id'))));
    $config->save();
    return parent::submitForm($form, $form_state);
  }
}