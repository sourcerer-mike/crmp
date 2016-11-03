Feature: Show details for a single invoice
  As an accountant
  I want to have a look at a single invoice
  to see more details and quickly change its status.

  Scenario: Look at invoice
    Given I am logged in as "Mike"

    When I am on "accounting/invoice/1"

    # Data
    Then I should see "1.337,00"

    # Actions
    And I should see "Edit invoice"