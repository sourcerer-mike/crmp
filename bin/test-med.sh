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

for composerFile in $(ls -1 src/Crmp/*/composer.json); do
    assert composer validate --strict ${composerFile}
done

# unit tests
assert vendor/bin/phpunit

# behat tests
assert vendor/bin/behat


exit ${finalStatus}