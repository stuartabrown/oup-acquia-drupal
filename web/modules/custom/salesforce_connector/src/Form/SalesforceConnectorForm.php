<?php
/**
 * @file
 * Contains Drupal\salesforce_connector\Form\SalesforceConnectorForm.
 */
namespace Drupal\salesforce_connector\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class SalesforceConnectorForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'salesforce_connector_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'salesforce_connector.adminsettings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Form constructor.
    $form = parent::buildForm($form, $form_state);
    // Default settings.
    $config = $this->config('salesforce_connector.adminsettings');
    // Username
    $form['username'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Salesforce Login Username'),
      '#default_value' => $config->get('salesforce_connector.username'),
      '#description' => $this->t('The username used to login the Salesforce API'),
    );
    // Password
    $form['password'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Salesforce Login Password'),
      '#default_value' => $config->get('salesforce_connector.password'),
      '#description' => $this->t('The password used to login the Salesforce API'),
    );
    // Session Key
    $form['session_key'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Salesforce Session Key'),
      '#default_value' => $config->get('salesforce_connector.session_key'),
      '#description' => $this->t('The session key retrieved during login, and it is used to access the Salesforce API'),
    );

    $form['session_key'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Salesforce Session Key'),
      '#default_value' => $config->get('salesforce_connector.session_key'),
      '#description' => $this->t('The session key retrieved during login, and it is used to access the Salesforce API'),
    );

    $form['login_soap_location'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Salesforce Login Soap Location'),
      '#default_value' => $config->get('salesforce_connector.login_soap_location'),
      '#description' => $this->t('The Login Soap Location for login, and it is used to access the Salesforce API'),
    );

    $form['login_soap_uri'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Salesforce Login Soap Uri'),
      '#default_value' => $config->get('salesforce_connector.login_soap_uri'),
      '#description' => $this->t('The Login Soap Uri for login, and it is used to access the Salesforce API'),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('salesforce_connector.adminsettings');
    $config->set('salesforce_connector.username', $form_state->getValue('username'));
    $config->set('salesforce_connector.password', $form_state->getValue('password'));
    $config->set('salesforce_connector.session_key', $form_state->getValue('session_key'));
    $config->set('salesforce_connector.login_soap_location', $form_state->getValue('login_soap_location'));
    $config->set('salesforce_connector.login_soap_uri', $form_state->getValue('login_soap_uri'));
    $config->save();
    return parent::submitForm($form, $form_state);
  }
}