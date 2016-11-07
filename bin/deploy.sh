#!/usr/bin/env bash

crmp_env=${crmp_env-prod}

composer install

bin/console cache:clear -e ${crmp_env}
bin/console assets:install web -e ${crmp_env} --symlink --relative
bin/console doctrine:schema:update -e ${crmp_env} -f

bin/populate.sh

bin/console assetic:dump -e ${crmp_env} web
