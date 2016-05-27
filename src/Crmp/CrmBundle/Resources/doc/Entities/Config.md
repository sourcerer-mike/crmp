# Configuration in CRMP

The general configuration is manages with the Config-Entity.
It provides a flat structure for simple data.


## Properties

- Configuration path.
- Configuration per user.
- Configuration value itself.

Every configuration is grouped in bundles followed by the identifier itself.
So each bundle can have it's own configuration when it's written like "crmp_crm.sessionTimeout".
It prevents the identifier of the config data from colliding with identifier from other bundles.
Usually a configuration path with bundle alias and identifier is short
but here it can go up to 255 characters.

Each configuration can be changed by the user.
Bundles may provide a default configuration but the user can override this.

The most important thing about configuration is the value itself.
It should only store flat data because values are limited to 255 characters.
Other data that needs more space shall be managed by the bundles.
