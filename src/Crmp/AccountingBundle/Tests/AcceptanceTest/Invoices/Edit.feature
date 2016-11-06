Feature: Edit details for a single invoice
  As an accountant
  I want to change a single invoice
  to correct minor mistakes made by the system or others.

  Background:
    Given I am logged in as "Mike"
    And I am on "/accounting/invoice/1/edit"

  Scenario: No change
    Given the "Invoice total" field should contain "1337"
    And the "Customer" option is set to "John Doe (1)"
    
    When I click on "Save"

    Then I should be on "accounting/invoice/1"

  Scenario: Invalid total shows warning
    When I fill in "Invoice total" with "-1"
    And I click on "Save"

    Then I should see "Please fix the problems shown below."
    And I should see "This value should be greater than 0."