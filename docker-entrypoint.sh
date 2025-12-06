#!/bin/sh

# Wait for PostgreSQL to be ready
echo "⏳ Waiting for database connection..."
until php artisan migrate:status > /dev/null 2>&1; do
    echo "⏳ Database not ready, waiting 2 seconds..."
    sleep 2
done

echo "✅ Database connection established!"

# Check if database needs initialization (check if users table has data)
USER_COUNT=$(php artisan tinker --execute="echo \App\Models\User::count();" 2>/dev/null | tail -n 1)

if [ "$USER_COUNT" = "0" ] || [ -z "$USER_COUNT" ]; then
    echo "🔧 First run detected - initializing database..."
    php artisan migrate --force
    php artisan db:seed --force
    echo "✅ Database initialized successfully"
else
    echo "✅ Database already exists with $USER_COUNT users - running migrations only..."
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
