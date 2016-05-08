crmp
====

> An CRM tool written with Symfony 3.


## Install your CRM

Just do it!
But please create the target database before installation
or as it still exists assert that there is no table in it.

    git clone https://github.com/sourcerer-mike/crmp.git
    
    # hump in and install dependencies
    composer install --no-dev

Easy as that.
You will be asked for database credentials - this is important!
Besides that you will be asked for mail support - if you like.

### When things didn't go well

If you were **not asked** for database credentials, then you can still do it by hand:
    
    cp app/config/parameters.yml.dist app/config/parameters.yml
    # edit app/config/parameters.yml now!

The database it built automagically too but if you like to rebuild it on your own:

    bin/console doctrine:schema:update

Now you're good to go.

## Serve the CRM

Let's see how cool you are. Newer PHP will eat this:

    bin/console server:start

And it runs in the background.
If that did not work you are not very cool and need old shoes:

    bin/console server:run

The URL to the CRMP will be shown in the output.
Call that in your favorite browser.

**Note: The first call will take some time - leave him alone!**

It will compile all the assets like SCSS or Coffee scripts etc.

## Start working

Create your own user on the register page: http://127.0.0.1:8000/register/