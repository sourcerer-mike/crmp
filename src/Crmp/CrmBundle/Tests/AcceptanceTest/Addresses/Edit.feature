Feature: Edit an address
  As a salesman
  I like to change the details of an address
  because sometimes contact details do change.

  Background: Edit address form
    Given I am logged in as "Mike"
    And I am on "/crm/address/2/edit"
    And the "Name" field should not contain ""
    And the "Customer" field should not contain ""
    And the "Mail" field should not contain ""

  Scenario: Breadcrumb to address list
    When I click on "Address"
    
    Then I should be on "/crm/address/"
    And the response status code should be 200

  Scenario: Breadcrumb to dashboard
    When I click on "Dashboard"

    Then I should be on "/"
    And the response status code should be 200

  Scenario: Edit with valid data
    When fill in "Mail" with some email
    And I press "Save"

    Then I should be on "/crm/address/2"
    And the response status code should be 200

  Scenario: Delete address
    Given I am on "/crm/address/new"
    And fill in "Name" with "Some name"
    And fill in "Mail" with some email

    When I press "Create"
    Then the URL should match "crm/address/[0-9]*"
    And the response status code should be 200

    When I click on "Edit address"
    And I press "Delete"

    Then I should be on "/crm/address/"