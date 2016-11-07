#!/usr/bin/env bash

composer install

bin/console cache:clear -e prod
bin/console assets:install web --symlink --relative
bin/console doctrine:schema:update -f

bin/populate.sh

bin/console assetic:dump -e prod web
