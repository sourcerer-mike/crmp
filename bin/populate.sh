#!/usr/bin/env bash

bin/console hautelook_alice:doctrine:fixtures:load -n --purge-with-truncate

exit $?