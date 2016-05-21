#!/usr/bin/env bash

bin/console hautelook_alice:doctrine:fixtures:load -n
vendor/bin/phpunit --group small