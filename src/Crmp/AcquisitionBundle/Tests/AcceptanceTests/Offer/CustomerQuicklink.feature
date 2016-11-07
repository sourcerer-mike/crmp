Feature: Quicklinks on customer level
  As a salesmen
  I want to create an offer while looking at a customer
  which should speed up my workflow.

  Background: Looking at a customer
    Given I am logged in as "Mike"
    And I am on "/crm/customer/1"

  Scenario: Create offer
    When I click on "New offer"

    Then the URL should match "acquisition/offer/new"
    And the "Customer" option is set to "John Doe"