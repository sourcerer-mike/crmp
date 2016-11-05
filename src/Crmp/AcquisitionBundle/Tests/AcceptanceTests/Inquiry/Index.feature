Feature: List of inquiries
  As a salesmen
  I want to enlist all inquiries
  so that I can manage them.

  Background: Inquiry list
    Given I am logged in as "Mike"
    And I am on "/acquisition/inquiry/"

  Scenario: Quicklink for new inquiry
    When I click on "New inquiry"
    
    Then I should be on "/acquisition/inquiry/new"
    And the response status code should be 200
    
  Scenario: Breadcrumb to dashboard
    When I click on "Dashboard"

    Then I should be on "/"
    And the response status code should be 200

  Scenario: Open inquiry from list
    When I click on "Open inquiry"

    Then the URL should match "inquiry/1"
    And the response status code should be 200
    
  Scenario: Edit inquiry shown in the list
    When I click on "Edit inquiry"

    Then the URL should match "inquiry/1/edit"
    And the response status code should be 200