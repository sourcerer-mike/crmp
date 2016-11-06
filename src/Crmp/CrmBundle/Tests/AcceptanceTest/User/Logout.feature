Feature: Logout from CRMP
  As an user
  I want to logout from the app
  so that my data can stay a bit more safe.

  Background: Logged in as someone
    Given I am logged in as "Mike"
    And I am on "/"
    And I should see "Dashboard"
    
  Scenario: Simple logout
    When I click on "Mike"
    And I click on "Logout"

    Then I should be on "/login"
    And I should see "Login"
    And the "Username" field should contain ""