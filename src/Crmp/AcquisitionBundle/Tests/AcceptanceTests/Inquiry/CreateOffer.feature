Feature: Creating offer from inquiry
  As an Administrator
  I want to create an offer directly from the inquiry
  to fasten up my workflow and have all related data.

  Scenario: Offer with customer
    Given I am logged in as "Mike"
    And go to "acquisition/inquiry/1"
    And I should see "John Doe"

    When I click on "New offer"

    Then I should see "New offer"
    And the "Inquiry" option is set to "Make the logo bigger"
    And the "Customer" option is set to "John Doe"