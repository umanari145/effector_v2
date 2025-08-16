#!/bin/bash
cd /var/www/html
apt-get install libsqlite3-dev  && apt-get install sqlite3
cp .env.ci .env
composer install
touch database/database.sqlite
php artisan migrate
php artisan db:seed
./vendor/bin/phpunit ./tests/
