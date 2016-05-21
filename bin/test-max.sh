#!/usr/bin/env bash

function assert() {
    echo "$@"
    echo ""
    "$@"

    local status=$?

    if [ $status -ne 0 ]; then
        echo "error with $1" >&2
    fi

    return $status
}

# create dummy data
assert bin/console hautelook_alice:doctrine:fixtures:load -n

# unit tests
assert vendor/bin/phpunit --colors=never

# behat tests
assert vendor/bin/behat --no-colors