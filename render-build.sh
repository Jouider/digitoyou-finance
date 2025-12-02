#!/usr/bin/env bash
# Render Build Script

echo "🚀 Starting build process..."

# Install Composer dependencies
echo "📦 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# Create SQLite database if it doesn't exist
echo "🗄️ Setting up database..."
touch database/database.sqlite

# Set proper permissions
echo "🔒 Setting permissions..."
chmod -R 755 storage bootstrap/cache
chmod 664 database/database.sqlite

# Generate application key if not set
if [ -z "$APP_KEY" ]; then
    echo "🔑 Generating application key..."
    php artisan key:generate --force
fi

# Run database migrations
echo "🔄 Running migrations..."
php artisan migrate --force --no-interaction

# Seed database if empty
echo "🌱 Checking if seeding is needed..."
TABLE_COUNT=$(php artisan tinker --execute="echo \DB::table('users')->count();")
if [ "$TABLE_COUNT" -eq "0" ]; then
    echo "🌱 Seeding database..."
    php artisan db:seed --force --no-interaction
fi

# Clear and cache config
echo "⚡ Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Build completed successfully!"
