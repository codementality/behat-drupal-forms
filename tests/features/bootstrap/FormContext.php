<?php

/**
 * @file
 * FeatureContext file for tests.
 */

use Drupal\DrupalExtension\Context\RawDrupalContext;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;

/**
 * Defines application features from the specific context.
 */
class FormContext extends RawDrupalContext implements SnippetAcceptingContext {

    private $minkContext;
    protected $forms;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct(array $parameters = array()) {
        $forms = array();
        if (!empty($parameters)) {
            $forms = $parameters['forms'];
        }
        $this->forms = $forms;
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
     * Clean forms.
     *
     * @AfterScenario
     */
    public function cleanForms() {
        // Stubbed method is needed to make Behat happy.
    }

    /**
     * @Then I should see the :form form in the :region region
     */
    public function iShouldSeeTheFormInTheRegion($form, $region)
    {
        $form_id = $this->forms[$form];
        $regionObj = $this->minkContext->getRegion($region);
        $selectElement = $regionObj->findAll('css', $form_id);
        if (empty($selectElement)) {
            throw new \Exception(sprintf("No form '%s' is present in the '%s' region", $form, $region));
        }
    }

    /**
     * @Then I should not see the :form form in the :region region
     */
    public function iShouldNotSeeTheFormInTheRegion($form, $region)
    {
        $form_id = $this->forms[$form];
        $regionObj = $this->minkContext->getRegion($region);
        $selectElement = $regionObj->findAll('css', $form_id);
        if (!empty($selectElement)) {
            throw new \Exception(sprintf("The form '%s' is present in the '%s' region", $form, $region));
        }
    }

}