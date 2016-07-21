<?php

use Drupal\DrupalExtension\Context\RawDrupalContext;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Mink\Exception\UnsupportedDriverActionException;

/**
 * Defines application features from the specific context.
 */
class PageContext extends RawDrupalContext implements SnippetAcceptingContext {

  private $minkContext;
  protected $pages;

  /**
   * Initializes context.
   *
   * Every scenario gets its own context instance.
   * You can also pass arbitrary arguments to the
   * context constructor through behat.yml.
   */
  public function __construct(array $parameters = array()) {
    $pages = array();
    if (!empty($parameters)) {
      $pages = $parameters['pages'];
    }
    $this->pages = $pages;
  }

  /**
   * Populate minkContext variable.
   *
   * @BeforeScenario
   */
  public function gatherContexts(BeforeScenarioScope $scope) {
    $environment = $scope->getEnvironment();
    $this->minkContext = $environment->getContext('Drupal\DrupalExtension\Context\MinkContext');
  }

  /**
   * @Given I am on the :page page
   */
  public function iAmOnThePage($page) {
    $page_path = $this->pages[$page];
    $this->minkContext->assertAtPath($page_path);
  }
}
