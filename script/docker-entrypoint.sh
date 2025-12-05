#!/bin/sh
set -e

# Ensure storage and cache directories exist and are writable
# We use /var/www/core because that is where the app is located
mkdir -p /var/www/core/storage/logs
mkdir -p /var/www/core/storage/framework/views
mkdir -p /var/www/core/storage/framework/cache
mkdir -p /var/www/core/storage/framework/sessions
mkdir -p /var/www/core/bootstrap/cache

# Fix permissions
# Using 777 to ensure host mounted volumes are writable regardless of user ID mismatch
chmod -R 777 /var/www/core/storage
chmod -R 777 /var/www/core/bootstrap/cache

# Execute the main container command
exec "$@"
