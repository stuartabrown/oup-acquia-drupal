<?php

// Forcibly uninstall Lightning Dev switch the installation profile from
// Standard to Minimal, and delete defunct config objects.

Drupal::configFactory()
  ->getEditable('core.extension')
  ->clear('module.lightning_dev')
  ->clear('module.standard')
  ->set('module.minimal', 1000)
  ->set('profile', 'minimal')
  ->save();

Drupal::keyValue('system.schema')->deleteMultiple(['lightning_dev']);

Drupal::configFactory()
  ->getEditable('entity_browser.browser.media_browser')
  ->delete();

Drupal::configFactory()->getEditable('lightning_api.settings')->delete();
Drupal::configFactory()->getEditable('media.type.tweet')->delete();
