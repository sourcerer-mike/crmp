Feature: List all invoices
  As an accountant
  I want to list all invoices
  to have quick overview over pending and payed invoices.

  Background: Logged in as accountant
    Given I am logged in as "Mike"
    And I am on "/accounting/invoice"

  Scenario: Simple list
    Then I should see "Invoices"
    And I should see "Create Invoice"

  Scenario: Open invoice
    When I click on "1.337,00 EUR"

    Then the response status code should be 200
    And I should see "1.337,00 EUR John Doe"