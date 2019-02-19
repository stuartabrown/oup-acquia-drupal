<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 2019-01-09
 * Time: 22:37
 */

namespace Drupal\op_events;

use Drupal\salesforce_connector\Connector;
use \SoapClient;
use \SoapHeader;

class EventManager {

  protected $connector;

  protected $soapHeader = 'http://soap.sforce.com/schemas/class/OPEventService';

  public function __construct(
    Connector $connector
  ) {
    $this->connector = $connector;
  }

  public function loadEventsFromSalesforce(){
    $sessionId = $this->connector->retrieveSessionKey();

    $client = new SoapClient(dirname(__FILE__) . '/../OPEventService.wsdl', array(
      'trace' => 1
    ));

    $header = new SoapHeader(
      $this->soapHeader,
      'SessionHeader',
      array(
        'sessionId' => $sessionId
      )
    );

    $client->__setSoapHeaders($header);

    try {
      $result = $client->getCampaignInfo(array(
        'pType' => '',
        'pIsActive' => 'True',
        'pEndDate' => '',
        'pProductDimension' => ''
      ));
      return $result;
    } catch (\Exception $e){
      return NULL;
//      var_dump($e);
//      echo "REQUEST HEADERS:\n" .  $client2->__getLastRequestHeaders()  . "\n";
//      echo "REQUEST:\n" .          $client2->__getLastRequest()         . "\n";
//      echo "RESPONSE HEADERS:\n" . $client2->__getLastResponseHeaders() . "\n";
//      echo "Response:\n" .         $client2->__getLastResponse()        . "\n";
//      die("getCampaignInfo failed\n");
    }

//    echo "getCampaignInfo result:\n";
//    echo '<pre>';
//    var_dump($result);
//    echo '</pre>';
//    die;
  }

}