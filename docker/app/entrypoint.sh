#!/bin/sh

if [ ! -f /app/.env ]; then
    echo "No .env file found. Copying from .env.example..."
    cp /app/.env.example /app/.env
    
    echo "Generating APP_KEY..."
    php artisan key:generate --ansi
fi

echo "Caching files..."
php artisan optimize

echo "Running migrations..."
php artisan migrate --force

exec "$@"
