Feature: Editing an inquiry
  As an Administrator
  I want to edit inquiries
  so that they contain correct and up to date data.

  Scenario: Store without changes
    Given I am logged in as "Mike"
    And go to "/acquisition/inquiry/9/edit"

    When I press "Save"

    Then I should be on "/acquisition/inquiry/9"