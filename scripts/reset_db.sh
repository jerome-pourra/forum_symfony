#!/bin/bash

php bin/console doctrine:database:drop --force --if-exists
php bin/console doctrine:database:create

# Remove all migration files
rm -rf migrations/Version*.php

php bin/console make:migration --no-interaction
php bin/console doctrine:migrations:migrate --no-interaction