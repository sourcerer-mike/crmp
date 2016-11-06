Feature: Login into CRMP
  As a user
  I need an interface to login
  so that I can start using CRMP.

  Background: Login page
    Given I am on "/login"
    And the "Username" field should contain ""
    And the "Password" field should contain ""

  Scenario: Quicklink to register
    When I click on "Register"

    Then I should be on "/register/"
    And the response status code should be 200

  Scenario: Correct credentials
    When I fill in "Username" with "Mike"
    And I fill in "Password" with "letmein"
    And I press "Login"

    Then I should see "Dashboard"

  Scenario: Wrong credentials
    When I fill in "Username" with "Mike"
    And I fill in "Password" with "Obey!"
    And I press "Login"

    Then I should see "Invalid credentials."