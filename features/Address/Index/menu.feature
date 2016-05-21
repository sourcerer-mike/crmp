Feature: Menu
  In order to fast create new entities
  As a user
  I need a menu with related links

  Scenario: Add new address
    Given I am logged in as "Mike"
    And I am on "/crm/address"
    And I should see "Aktionen"

    When I click on "Neue Adresse"

    Then I am on "/crm/address/new"
    And I should see "Neue Addresse"
    And I should see "Erstellen"