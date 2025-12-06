#!/bin/sh

# Display environment variables for debugging (without sensitive data)
echo "🔍 Environment check:"
echo "DB_CONNECTION: ${DB_CONNECTION}"
echo "DB_HOST: ${DB_HOST}"
echo "DB_PORT: ${DB_PORT}"
echo "DB_DATABASE: ${DB_DATABASE}"
echo "DB_USERNAME: ${DB_USERNAME}"
echo "DB_PASSWORD: [HIDDEN]"

# Wait for PostgreSQL to be ready with timeout
echo "⏳ Waiting for database connection..."
MAX_TRIES=30
TRY_COUNT=0

until php artisan migrate:status > /dev/null 2>&1; do
    TRY_COUNT=$((TRY_COUNT + 1))
    
    if [ $TRY_COUNT -ge $MAX_TRIES ]; then
        echo "❌ Database connection failed after $MAX_TRIES attempts"
        echo "🔍 Testing connection manually..."
        php artisan tinker --execute="try { DB::connection()->getPdo(); echo 'Connected!'; } catch (Exception \$e) { echo 'Error: ' . \$e->getMessage(); }"
        exit 1
    fi
    
    echo "⏳ Database not ready, attempt $TRY_COUNT/$MAX_TRIES..."
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
