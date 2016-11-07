Feature: Creating new offer
  As a salesmen
  I want to create a new offer
  so that I can serve them to my customers.
  
  Background: Creating new offer
    Given I am logged in as "Mike"
    And I am on "acquisition/offer/new"
    And the "Title" field should contain ""
    # Select fields could not be checked for no value / to be empty
    # And the "Customer" option is set to ""
    # And the "Inquiry" option is set to ""
    # And the "Price" option is set to ""
    # And the "Offer description" option is set to ""


  Scenario: Entering valid data
    When I fill in "Title" with "Some title"
    And I select "John Doe" from "Customer"
    And I fill in "Price" with "1300"
    And fill in "Offer description" with:
      """
      HELLO STONEHENGE!!

      Who takes The Pandorica takes the universe!
      But, bad news, everyone — Except, you lot.
      The question of the hour is, who’s got The Pandorica.
      Answer: I do.
      Next question! Who’s coming to take it from me?
      C’MMMONN, look at me! No plan, no backup, no weapons worth a damn, OH, and — something else — I.
      Don’t. Have. Anything TO LOSE. So, if you’re sitting up there in your silly little spaceship
      with all your silly little guns and you’ve got any plans on taking The Pandorica TONIGHT,
      just REMEMBER who’s standing in your way.
      REMEMBER every black day I ever stopped you, and then, and then dO the smart thing:

      Let somebody else try first.
      """

    And I press "Create"

    Then the URL should match "acquisition/offer/[0-9]*"
    And I should see "HELLO STONEHENGE!!"