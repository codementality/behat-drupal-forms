Feature: The contact page should display the appropriate form

  Scenario:  The contact form should be found on the 'Contact' page
    Given I am on the "Contact" page
    Then I should see the "Website feedback" form in the "content" region
