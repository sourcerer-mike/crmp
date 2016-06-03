# CRMP Accounting

> Accountign extension for your CRMP.

**Warning!**
Neither this branch nor one of the others is ment for production use!
<br />
Either you are a pro in PHP/Symfony and can handle that,
or you come back later.
Thanks ;)

- Invoices


## Installation

This is an extension for `crmp/crmp`.
Install it via composer:

    composer require crmp/accounting

Easy as that.
Now you need the routing which is just two lines for your *app/config/routing.yml*:

    crmp_accounting:
      resource: "@CrmpAccountingBundle/Resources/config/routing.yml"


The database it built automagically too but if you like to rebuild it on your own:

    bin/console doctrine:schema:update

Now you're good to go.


[Read on in the docs](Resources/doc).