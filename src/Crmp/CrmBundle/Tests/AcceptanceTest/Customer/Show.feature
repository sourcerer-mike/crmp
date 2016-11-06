Feature: Show single customer
  As a salesman
  I want to look up single customer
  so that I can manage them and inform myself.

  Background: Single customer
    Given I am logged in as "Mike"
    And I am on "/crm/customer/1"
    And I should see "John Doe"

  Scenario: Quicklink to edit customer
    When I click on "Edit customer"

    Then I should be on "/crm/customer/1/edit"
    And the response status code should be 200

  Scenario: Quicklink to create address
    When I click on "New address"

    Then the URL should match "crm/address/new"
    And the "Customer" option is set to "John Doe"
