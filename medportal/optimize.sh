#!/bin/bash
/etc/init.d/nginx restart;/etc/init.d/php5-fpm restart;php artisan view:clear;php artisan config:clear;php artisan route:clear;php artisan cache:clear;php artisan clear-compiled;php artisan optimize;php artisan config:cache;php artisan route:cache;