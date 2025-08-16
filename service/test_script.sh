#!/bin/bash
cd /var/www/html
cp .env.ci .env
composer install
php artisan db:seed
./vendor/bin/phpunit ./tests/
