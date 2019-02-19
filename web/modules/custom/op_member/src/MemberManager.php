<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 2019-01-09
 * Time: 22:37
 */

namespace Drupal\op_member;

use Drupal\salesforce_connector\Connector;
use \SoapClient;
use \SoapHeader;

class MemberManager {

  protected $connector;

  protected $soapHeader = 'http://soap.sforce.com/schemas/class/OPEventService';

  public function __construct(
    Connector $connector
  ) {
    $this->connector = $connector;
  }

  public function loadMemberFromSalesforce($memberId){
    if(is_null($memberId) || trim($memberId) === '') return NULL;
    $memberId = trim($memberId);

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
      $result = $client->getMemberInfo(array(
        'pMemberId' => $memberId,
      ));
      return $result;
    } catch (\Exception $e){
      return NULL;
    }

  }

}