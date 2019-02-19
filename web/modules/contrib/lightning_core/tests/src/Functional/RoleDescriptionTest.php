<?php

namespace Drupal\Tests\lightning_core\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * @group lightning_core
 */
class RoleDescriptionTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'block',
    'lightning_core',
  ];

  public function testRoleDescription() {
    $this->drupalPlaceBlock('local_tasks_block');

    $account = $this->drupalCreateUser([
      'access administration pages',
      'administer users',
      'administer permissions',
    ]);
    $this->drupalLogin($account);

    $this->drupalGet("/admin/people/roles/add");
    $this->assertSession()->statusCodeEquals(200);
    $this->assertSession()->fieldExists('Role name')->setValue('Foobaz');
    $this->assertSession()->fieldExists('id')->setValue('foobaz');
    $this->assertSession()->fieldExists('Description')->setValue('I am godd here');
    $this->assertSession()->buttonExists('Save')->press();
    $this->drupalGet('/user');
    $this->assertSession()->statusCodeEquals(200);
    $this->assertSession()->elementExists('named', ['link', 'Edit'])->click();
    $this->assertSession()->buttonExists('Save')->press();
    $this->assertSession()->pageTextContains('I am godd here');
  }

}
