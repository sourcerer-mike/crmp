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

# unit tests
assert vendor/bin/phpunit --colors=never --coverage-clover var/phpunit/coverage.xml

# behat tests
assert vendor/bin/behat --no-colors

exit $finalStatus