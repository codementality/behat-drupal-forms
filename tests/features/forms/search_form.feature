Feature: The search forms should be on the appropriate pages

  Scenario:  Test for the Search Block form in the sidebar
    Given I am on the homepage
    Then I should see the "Search Block" form in the "left sidebar" region

  @api
  Scenario:  Test for the Search form on the Node Search page as an anonymous user
    Given I am an anonymous user
    When I am on the "Node Search" page
    Then I should see the "Search" form in the "content" region
    But I should not see the "Advanced Search" form in the "content" region

  @api
  Scenario:  Test for the Search form on the Node Search page as an authenticated user
    Given I am logged in as a user with the "authenticated" role
    When I am on the "Node Search" page
    Then I should see the "Search" form in the "content" region
    And I should see the "Advanced Search" form in the "content" region

  @api
  Scenario:  Test for the Search form on the Node Search page as an administrator
    Given I am logged in as a user with the "administrator" role
    When I am on the "Node Search" page
    Then I should see the "Search" form in the "content" region
    And I should see the "Advanced Search" form in the "content" region

  @api
  Scenario:  Test for the Search form on the User Search page as an administrator
    Given I am logged in as a user with the "administrator" role
    When I am on the "User Search" page
    Then I should see the "Search" form in the "content" region
    But I should not see the "Advanced Search" form in the "content" region

  @api
  Scenario:  Test for the Search form on the User Search page as an authenticated user
    Given I am logged in as a user with the "authenticated" role
    When I am on the "User Search" page
    Then I should see the "Search" form in the "content" region
    But I should not see the "Advanced Search" form in the "content" region