Feature: Menu
  In order to fast create new entities
  As a user
  I need a menu with related links

  Scenario: Add new address
    Given I am logged in as "Mike"
    And I am on "/crm/address"
    And I should see "Addressen"
    And I should see "Neue Addresse"
    And I click on "Neue Addresse"

    Then I should see "Neue Adresse"
    And I should see "Erstellen"