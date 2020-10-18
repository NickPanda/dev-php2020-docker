#!/usr/bin/env bash

composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist

# Execute tests
vendor/bin/phpunit ./tests/GenerateTest.php