#!/usr/bin/env bash

finalStatus=0

function assert() {
    echo "$@"
    echo ""
    "$@"

    local status=$?

    if [ $status -ne 0 ]; then
        echo "error with $1" >&2
    fi

    finalStatus+=$status
}


# create dummy data
assert bin/populate.sh

# coding standards
vendor/bin/phpcs --config-set installed_paths vendor/escapestudios/symfony2-coding-standard
assert vendor/bin/phpcs --standard=phpcs.xml src

# unit tests
assert vendor/bin/phpunit --colors=never --coverage-clover var/phpunit/coverage.xml

# behat tests
assert vendor/bin/behat --no-colors

exit ${finalStatus}