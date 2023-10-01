#!/bin/sh

cd /app

# Run composer install
composer install

# Run the CMD from the Dockerfile (e.g., tail -f /dev/null)
exec "$@"