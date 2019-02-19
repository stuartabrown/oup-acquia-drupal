<?php
namespace Drupal\op_events\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\op_events\Form\SalesforceCampaignForm;
use Drupal\op_events\EventManager;
use Drupal\node\Entity\Node;
use mysql_xdevapi\Exception;

/**
 * Provides route responses for the op_events module.
 */
class DownloadController extends ControllerBase {

  private $eventManager;

  protected $formAssemblyUrl = 'https://app.formassembly.com/rest/forms/view/';

  public function __construct(EventManager $eventManager){
    $this->eventManager = $eventManager;
  }

  /**
   * Returns a summary page.
   *
   * @return array
   *   A simple renderable array.
   */

  public function createNewEvent(){

  }

  public function download() {
    try {
      $config = \Drupal::config(SalesforceCampaignForm::$adminSettingKey);
      $form_id_mapping = $config->get('salesforce_campaign.form_id_mapping');

      if($form_id_mapping){
        $form_id_mapping = json_decode($form_id_mapping, true);
        if(!$form_id_mapping){
          throw new Exception('Mapping is probably not a valid JSON');
        }
      }else{
        throw new Exception('Mapping is not found.');
      }


      $timestamp = time();
      $result = $this->eventManager->loadEventsFromSalesforce();
      // 1. Download
      if ($result === NULL) {
        $element = [
          '#type' => 'container',
          'status' => [
            '#type' => 'html_tag',
            '#value' => 'Failed! Somehow',
            '#tag' => 'p'
          ]
        ];
      }
      else {
        if ($result->result && is_array($result->result)) {
          foreach($result->result as $event){
            $node = Node::create(['type' => 'campaign']);
            $node->set('title', $event->campaignName);

            $node->set('field_campaign_code', $event->campaignCode);
            $node->set('field_campaign_id', $event->campaignId);
            $node->set('field_charge_for_child', $event->chargeforChild);
            $node->set('field_charge_for_parent', $event->chargeforParent);
            $node->set('field_charge_paid', $event->chargePaid);

            if($event->eventCategory !== NULL && $event->eventCategory !== ''){
              $eventCategories = explode(';', $event->eventCategory);
              $node->set('field_event_category', $eventCategories);
            }

            if($event->displayDate !== NULL){
              $datetime = \DateTime::createFromFormat('Y-m-d\TH:i:s+', $event->displayDate);
              $node->set('field_display_date', $datetime->getTimestamp());
            }

            if($event->endDate !== NULL){
              $datetime = \DateTime::createFromFormat('Y-m-d\TH:i:s+', $event->endDate);
              $node->set('field_end_date', $datetime->getTimestamp());
            }

            $node->set('field_event_end_time', $event->eventEndTime);
            $node->set('field_event_start_time', $event->eventStartTime);

            $node->set('field_location', $event->location);
            $node->set('field_max_capacity', $event->maxCapacity);
            $node->set('field_max_child_capacity', $event->maxChildCapacity);
            $node->set('field_max_parent_capacity', $event->maxParentCapacity);
            $node->set('field_member', $event->member);
            $node->set('field_need_charge', $event->needCharge);
            $node->set('field_parent_campaign_id', $event->parentCampaignId);
            $node->set('field_playground_type', $event->playgroupType);
            $node->set('field_product_dimension', $event->productDimension);
            $node->set('field_registration', $event->registration);

            if($event->registrationEndDate !== NULL){
              $datetime = \DateTime::createFromFormat('Y-m-d\TH:i:s+', $event->registrationEndDate);
              $node->set('field_registration_end_date', $datetime->getTimestamp());
            }

            if($event->registrationStartDate !== NULL){
              $datetime = \DateTime::createFromFormat('Y-m-d\TH:i:s+', $event->registrationStartDate);
              $node->set('field_registration_start_date', $datetime->getTimestamp());
            }

            $node->set('field_speaker', $event->speaker);
            if($event->startDate !== NULL){
              $datetime = \DateTime::createFromFormat('Y-m-d\TH:i:s+', $event->startDate);
              $node->set('field_start_date', $datetime->getTimestamp());
            }
            $node->set('field_target_audience', $event->targetAudience);
            $node->set('field_target_audience_max', $event->targetAudienceMax);
            $node->set('field_version', $timestamp);
            $node->set('field_displaying', true);

            // Find corresponding IDs for the form
            $targetAudienceMax = strtolower($event->targetAudienceMax);
            if($event->member){
              // Member Event
              if($targetAudienceMax === 'parent'){
                // assumed is parent
                $form_ids = $form_id_mapping['parent']['member'];
              }else{
                // assumed is parent and child
                $form_ids = $form_id_mapping['parent and child']['member'];
              }
            }else{
              // Public Event
              if($targetAudienceMax === 'parent'){
                // assumed is parent
                $form_ids = $form_id_mapping['parent']['public'];
              }else{
                // assumed is parent and child
                $form_ids = $form_id_mapping['parent and child']['public'];
              }
            }
            // Because form_id has more than 2 versions, e.g. zh-hant, en
            $node->set('field_form_id', json_encode($form_ids));

            // TODO uid = 1 is admin?
            $node->set('uid', 1);
            $node->status = 1;
            $node->enforceIsNew();
            $node->save();
          }
        }

        // changed the field_version to timestamp first
        // delete the old events ( using timestamp not equal to this batch )

        // 2. Delete old campaigns
        $query = \Drupal::entityTypeManager()
          ->getStorage('node')->getQuery();
        $query->condition('type', 'campaign')
          ->condition('field_version', $timestamp, '<>');
        $nids = $query->execute();
        if($nids && is_array($nids)  && count($nids) > 0) {
          $storage_handler = \Drupal::entityTypeManager()->getStorage('node');
          $entities = $storage_handler->loadMultiple($nids);
          $storage_handler->delete($entities);
        }

        // Success, no matter need to add or empty events detected

        $element = array(
          '#type' => 'container',
          'status' => [
            '#type' => 'html_tag',
            '#value' => 'Success',
            '#tag' => 'p'
          ]
        );
      }
    }catch(Exception $x){
      $element = array(
        '#type' => 'container',
        'status' => [
          '#type' => 'html_tag',
          '#value' => 'Failed! Error: '.$x->getMessage(),
          '#tag' => 'p'
        ]
      );
    }
    return $element;
  }
}