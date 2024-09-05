#!/bin/bash

php bin/console doctrine:fixtures:load --no-interaction
echo "Fixtures loaded successfully"