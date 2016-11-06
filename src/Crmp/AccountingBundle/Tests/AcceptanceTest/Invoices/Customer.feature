Feature: Quicklink in when viewing single customer
  As a salesman
  I want to quickly create an invoice
  so that I get payed.

  Background:
    Given I am logged in as "Mike"
    And I am on "/crm/customer/1"
    And I should see "John Doe"
    
  Scenario: Create new invoice
    When I click on "Create invoice"

    Then the URL should match "accounting/invoice/new"
    And the "Customer" option is set to "John Doe"
