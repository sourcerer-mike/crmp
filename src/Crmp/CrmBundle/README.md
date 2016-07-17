# CRMP

> An CRM tool written with Symfony 3.

**Warning!**
Neither this branch nor one of the others is ment for production use!
<br />
Either you are a pro in PHP/Symfony and can handle that,
or you come back later.
Thanks ;)


## Installation

This is the major app / bundle of the CRMP.
Create it as a new project using composer:

    composer create-project sourcerer-mike/crm crmp

You can install other bundles.

Easy as that.
You will be asked for database credentials - this is important!
Besides that you will be asked for mail support - if you like.
If you were **not asked** for database credentials, then you can still do it by hand:
    
    cp app/config/parameters.yml.dist app/config/parameters.yml
    # edit app/config/parameters.yml now!

The database it built automagically too but if you like to rebuild it on your own:

    bin/console doctrine:schema:update

Now you're good to go.

# Serve the CRM

This command works on some machines and is very easy:

    bin/console server:run &

The server runs in the background as long as you keep the terminal open.
Some systems accept `bin/console server:start` so you can close the terminal
and the server still runs.

The URL to the CRMP will be shown in the output.
Call that in your favorite browser.

**Note: The first call will take some time!**
It will compile all the assets like SCSS or Coffee scripts etc.


## Start working

Go to http://127.0.0.1:8000/register/ and create an account by clicking "Register".