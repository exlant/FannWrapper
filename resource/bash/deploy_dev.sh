#!/bin/bash

# Clear cache
rm -rf var/cache/dev
rm -rf var/cache/prod
rm -rf var/cache/test
echo -e "Clearing the cache was successfully done."

# Clear logs
rm -rf var/logs/dev.log
rm -rf var/logs/prod.log
rm -rf var/logs/test.log
echo -e "Clearing the logs was successfully done."

# Clear sessions
rm -rf var/sessions/dev
rm -rf var/sessions/prod
echo -e "Clearing the session data was successfully done."

# Composer install
composer install > /dev/null 2>&1
echo -e "Composer install done."

# Update DB
#php bin/console doctrine:migration:migrate --no-interaction
#echo -e "Database was updated successfully."