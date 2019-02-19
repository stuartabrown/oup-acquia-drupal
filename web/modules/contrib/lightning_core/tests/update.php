<?php

// Forcibly uninstall Lightning Dev.
Drupal::configFactory()
  ->getEditable('core.extension')
  ->clear('module.lightning_dev')
  ->save();

Drupal::keyValue('system.schema')->deleteMultiple(['lightning_dev']);

// Remove Workflow-related settings from the Page content type.
entity_load('node_type', 'page')
  ->unsetThirdPartySetting('lightning_workflow', 'workflow')
  ->save();
