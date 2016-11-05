Feature: Create new inquiries
  As a salesmen
  I want to create new inquiries
  to store information about what the customer wants from me.

  Background: Creating inquiries
    Given I am logged in as "Mike"
    And I am on "/acquisition/inquiry/new"
    And the "Title" field should contain ""
    And the "Customer" field should contain ""
    And the "Inquired at" field should not contain ""
    And the "Predicted value" field should contain ""
    And the choice "Pending" should be checked
    And the "Inquiry description" field should contain ""

  Scenario: Breadcrumb to the list of inquiries
    When I click on "Inquiries"

    Then I should be on "/acquisition/inquiry/"
    And the response status code should be 200

  Scenario: Breadcrumb to dashboard
    When I click on "Dashboard"

    Then I should be on "/"
    And the response status code should be 200

  # Coming from some other context can fill in the customer.
  Scenario: Fill in the customer via URL
    When I am on "/acquisition/inquiry/new?customer=1"

    Then the "Customer" option is set to "John Doe"