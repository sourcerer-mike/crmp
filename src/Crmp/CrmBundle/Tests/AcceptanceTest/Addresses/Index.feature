Feature: Enlist all addresses
  As a salesman
  I want to have a look on all addresses
  so that I can quickly contact them.

  Background: Logged in as salesman
    Given I am logged in as "Mike"
    And I am on "/crm/address"

  # On the top left corner you'll see "New address".
  # With this actions you are able to quickly create a new address.
  Scenario: Quicklink to new address
    When I click on "New address"

    Then I should be on "/crm/address/new"
    And the response status code should be 200

  # On the top there is always a breadcrumb.
  # This allows a quick navigation to the upper level like the "Dashboard".
  Scenario: Back to dashboard
    When I click on "Dashboard"

    Then I should be on "/"
    And the response status code should be 200

  Scenario: Look at a single address
    When I click on "Who"

    Then I should see "allons-y@tardis.time"
    And I should see "Updated by"

  Scenario: Simple list
    Then I should see "Addresses"
    And I should see "Name"
    And should see "Customer"
    And should see "Mail"


