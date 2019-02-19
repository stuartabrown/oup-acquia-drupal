<?php

// Forcibly uninstall Lightning Dev, switch the installation profile from
// Standard to Minimal, and delete defunct config objects.

Drupal::configFactory()
  ->getEditable('core.extension')
  ->clear('module.lightning_dev')
  ->clear('module.standard')
  ->set('module.minimal', 1000)
  ->set('profile', 'minimal')
  ->save();

Drupal::keyValue('system.schema')->deleteMultiple(['lightning_dev']);

entity_load('node_type', 'landing_page')
  ->unsetThirdPartySetting('lightning_workflow', 'workflow')
  ->save();
