<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 2019-01-20
 * Time: 21:40
 */

namespace Drupal\op_events\ParamConverter;

use Drupal\Core\ParamConverter\ParamConverterInterface;
use Symfony\Component\Routing\Route;
use Drupal\node\Entity\Node;

class CampaignConverter implements ParamConverterInterface {
  public function convert($value, $definition, $name, array $defaults) {
    $query = \Drupal::entityTypeManager()
      ->getStorage('node')->getQuery();
    $query->condition('type', 'campaign')
      ->range(0, 1)
      ->condition('field_campaign_id', $value)

      ->sort('field_version', 'DESC');
    $nids = $query->execute();
    if(is_array($nids) && count($nids) > 0){
      $nid = reset($nids);
      return Node::load($nid);
    }else{
      return NULL;
    }
  }

  public function applies($definition, $name, Route $route) {
    return (!empty($definition['type']) && $definition['type'] == 'campaign_id');
  }
}