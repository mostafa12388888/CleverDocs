#!/bin/bash

php artisan cache:clear
php artisan route:clear
php artisan config:clear
php artisan migrate
php artisan storage:link
