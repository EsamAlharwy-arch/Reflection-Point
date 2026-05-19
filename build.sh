#!/usr/bin/env bash
# exit on error
set -o errexit

# Install PHP dependencies
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Install Node dependencies and build assets
if [ -f package.json ]; then
    npm install
    npm run build
fi

# Optimize Laravel cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
