Feature: Create a new address
  As a salesmen
  I want to create new addresses
  so that I can manage my customers and call them later.

  Background: Fields for creating an address
    Given I am logged in as "Mike"
    And I am on "/crm/address/new"
    And the "Name" field should contain ""
    And the "Customer" field should contain ""
    And the "Mail" field should contain ""

  Scenario: Quicklink to abort
    When I click on "Abort"

    Then I should be on "/crm/address/"
    And the response status code should be 200

  Scenario: Bradcrumb to dashboard
    When I click on "Dashboard"

    Then I should be on "/"
    And the response status code should be 200

  Scenario: Fill form with valid data
    When I fill in "Name" with "Hopefully unique"
    And select "John Doe" from "Customer"
    And fill in "Mail" with some email
    And I press "Create"

    Then the URL should match "/crm/address/[0-9]*"
    And the response status code should be 200
    And should see "Edit address"