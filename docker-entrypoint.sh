#!/bin/sh

# Create database directory if it doesn't exist
mkdir -p /app/database

# Create SQLite database file if it doesn't exist
if [ ! -f /app/database/database.sqlite ]; then
    echo "📁 Creating database file..."
    touch /app/database/database.sqlite
    chmod 664 /app/database/database.sqlite
fi

# Check if database needs initialization (check if users table exists)
TABLE_EXISTS=$(sqlite3 /app/database/database.sqlite "SELECT name FROM sqlite_master WHERE type='table' AND name='users';" 2>/dev/null)

if [ -z "$TABLE_EXISTS" ]; then
    echo "🔧 First run detected - initializing database..."
    php artisan migrate --force
    php artisan db:seed --force
    echo "✅ Database initialized successfully"
else
    echo "✅ Database already exists - running migrations only..."
    php artisan migrate --force
fi

# Clear and cache configuration
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start the application
echo "🚀 Starting Laravel application..."
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
