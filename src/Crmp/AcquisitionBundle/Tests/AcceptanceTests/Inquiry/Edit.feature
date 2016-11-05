Feature: Editing an inquiry
  As an Administrator
  I want to edit inquiries
  so that they contain correct and up to date data.

  Background: Edit an inquiry
    Given I am logged in as "Mike"
    And go to "/acquisition/inquiry/1/edit"
    And the "Title" field should contain "Make the logo bigger"
    And the "Customer" option is set to "John Doe"
    And the "Inquired at" field should contain "28.10.2016"
    And the "Predicted value" field should contain "0"
    And the choice "Done" should be checked
    And text for "Inquiry description" should be:
      """
      And let it look sexy.
      """

  Scenario: Breadcrumb link to inquiry
    When I click on "Make the logo bigger"
    
    Then I should be on "/acquisition/inquiry/1"
    And the response status code should be 200

  Scenario: Breadcrumb link to list of inquiries
    When I click on "Inquiries"

    Then I should be on "/acquisition/inquiry/"
    And the response status code should be 200

  Scenario: Breadcrumb link to dashboard
    Given I click on "Dashboard"

    Then I should be on "/"
    And the response status code should be 200