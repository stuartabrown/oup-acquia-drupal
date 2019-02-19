<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 2019-01-21
 * Time: 08:29
 */

namespace Drupal\op_events\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class SalesforceCampaignForm extends ConfigFormBase {

  public static $adminSettingKey = 'salesforce_campaign.adminsettings';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'salesforce_campaign_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'salesforce_campaign.adminsettings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Form constructor.
    $form = parent::buildForm($form, $form_state);
    // Default settings.
    $config = $this->config('salesforce_campaign.adminsettings');
    // Username
    $form['form_id_mapping'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Salesforce Campaign Form ID mapping in JSON format'),
      '#default_value' => $config->get('salesforce_campaign.form_id_mapping'),
      '#description' => $this->t('In JSON format, e.g. {"parent and child":{"public":{"zh-hant":4715732,"en":4716308},"member":{"zh-hant":4715731,"en":4716307}},"parent":{"public":{"zh-hant":4715733,"en":4716309},"member":{"zh-hant":4715730,"en":4716306}}}'),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('salesforce_campaign.adminsettings');
    $config->set('salesforce_campaign.form_id_mapping', $form_state->getValue('form_id_mapping'));
    $config->save();
    return parent::submitForm($form, $form_state);
  }
}