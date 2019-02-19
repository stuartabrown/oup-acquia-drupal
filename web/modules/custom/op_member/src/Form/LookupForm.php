<?php

namespace Drupal\op_member\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\op_member\MemberManager;

/**
 * Implements an example form.
 */
class LookupForm extends FormBase {

  private $memberManager;

  public function __construct(MemberManager $memberManager){
    $this->memberManager = $memberManager;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'lookup_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['memberId'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Member Id'),
    ];
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Lookup'),
      '#button_type' => 'primary',
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (strlen($form_state->getValue('memberId')) < 1) {
      $form_state->setErrorByName('memberId', $this->t('Please provide non empty member id.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    try {
      $memberId = $form_state->getValue('memberId');
      $result = $this->memberManager->loadMemberFromSalesforce($memberId);
      if ($result) {
        if($result->result && $result->result->membershipNo){
          $memberInfo = array(
            'effectiveDate' => $result->result->effectiveDate,
            'expiryDate' => $result->result->expiryDate,
            'member' => $result->result->member,
            'membershipNo' => $result->result->membershipNo
          );
          drupal_set_message(json_encode($memberInfo));
          $users = \Drupal::entityTypeManager()->getStorage('user')->loadByProperties(['field_member_id'=> $memberId]);
          if(is_array($users) && count($users) > 0){
            if(count($users) > 1){
              $email_list = array();
              foreach($users as $user){
                $email_list[] = $user->mail?$user->name->value:$user->mail->value;
              }
              drupal_set_message(t('More than 1 user (@list) are found with provided member id.', array(
                '@list' => implode(', ', $email_list)
              )), 'error');
            }else{
              try {
                $user = reset($users);
                $expiryDate = $result->result->expiryDate?$result->result->expiryDate:NULL;
                if($expiryDate) {
                  $jsDateTS = strtotime($expiryDate);
                  $expiryDate = date('Y-m-d', $jsDateTS);
                }else{
                  $expiryDate = '';
                }
                $effectiveDate = $result->result->effectiveDate?$result->result->effectiveDate:NULL;
                if($effectiveDate) {
                  $jsDateTS = strtotime($effectiveDate);
                  $effectiveDate = date('Y-m-d', $jsDateTS);
                }else{
                  $effectiveDate = '';
                }
                $user->field_member_expiry_date = $expiryDate;
                $user->field_member_effective_date = $effectiveDate;
                $user->save();
                drupal_set_message(t('The user (@list) with provided member id is updated.', array(
                  '@list' => $user->mail?$user->name->value:$user->mail->value
                )), 'status');
              }catch(\Exception $x){
                drupal_set_message(t('Unable to update the user (@list) with provided member id. (Error: @error)', array(
                  '@list' => $user->mail?$user->name->value:$user->mail->value,
                  '@error' => $x->getMessage()
                )), 'error');
              }
            }
          }else{
            drupal_set_message('No user with provided member id found, no update will be executed.', 'error');
          }
        }else{
          drupal_set_message('No result is found.', 'error');
        }
      }
      else {
        drupal_set_message('No result is found.', 'error');
      }
    }catch(\Exception $x){
      drupal_set_message($x->getMessage(), 'error');
    }
  }

}