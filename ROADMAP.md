Version 0.1

- All views have the same capabilities
	- ..._show breadcrumbe
		- As a user
		  I always see where I am in the breadcrumb
		  so that I can navigate to meta-views.
    - ..._show sub-entities are shown
        - As a user
          I see only a button when the sub-list is empty
          so that I can add a new sub-entity.
	- ..._show filter are enabled
		- As a user
		  I can use filter via parent-entities
		  so that I can see all entities related to that parent.
- Nothing is messed up
- Sample Data

Version 0.2

- Backend configuration per user
- User-Level
	- Intern
	- Staff
	- Manager
	- Director
	- President
- Admin-Panel to assign user groups
- Admin-Panel to create accounts
- UnitTests for all "indexAction"

Version 0.3

- All delete Buttons are links
- All delete actions are just a flag in the database
- Duplicate entries (in ..._show)
- Date to all entities
- Order recent items by date desc
- UnitTests for "showAction"

Version 0.4

- UnitTests for "newAction"

Version 0.5

- UnitTests for "editAction"

Version 0.6

- CodeCoverage 50%

Version 0.7

- CodeCoverage 60%

Version 0.8

- CodeCoverage 70%

Version 0.9

- CodeCoverage 80%

Version 0.10

- CodeCoverage >90% - keep it there from now on!
  - Add hints to CONTRIBUTE.md