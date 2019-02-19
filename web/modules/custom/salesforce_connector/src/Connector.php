<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 2019-01-09
 * Time: 21:06
 */

namespace Drupal\salesforce_connector;

use \SoapClient;

class Connector {

  private $soapClient;
  private $sessionId;
  private $settingKey = 'salesforce_connector.adminsettings';

  public function __construct() {
  }

  public function retrieveSessionKey(){
    $config = \Drupal::config($this->settingKey);
    if(!$config) throw new \Exception('setting_missing');

    try {
      // Is it good enough to open the wsdl file?
      $this->soapClient = new SoapClient(dirname(__FILE__) . '/../salesforce.wsdl', [
        'location' => $config->get('salesforce_connector.login_soap_location'),
        'uri' => $config->get('salesforce_connector.login_soap_uri'),
        'trace' => 1,
      ]);
    }catch(\Exception $x){
      throw $x;
    }

    try {
      $result = $this->soapClient->login(array(
        'username' => $config->get('salesforce_connector.username'),
        'password' => $config->get('salesforce_connector.password'),
      ));
    } catch (\Exception $x){
      throw $x;
    }

    try {
      $sessionId = $result->result->sessionId;
      $config_factory = \Drupal::configFactory();
      $config = $config_factory->getEditable($this->settingKey);
      $config->set('salesforce_connector.session_key', $sessionId);
      $config->save(TRUE);
      return $sessionId;
    }catch(\Exception $x){
      throw $x;
    }
  }

}