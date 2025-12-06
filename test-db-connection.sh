#!/bin/sh

echo "================================"
echo "🔍 Database Connection Diagnostic"
echo "================================"
echo ""

echo "📋 Environment Variables:"
echo "DB_CONNECTION: ${DB_CONNECTION:-NOT SET}"
echo "DB_HOST: ${DB_HOST:-NOT SET}"
echo "DB_PORT: ${DB_PORT:-NOT SET}"
echo "DB_DATABASE: ${DB_DATABASE:-NOT SET}"
echo "DB_USERNAME: ${DB_USERNAME:-NOT SET}"
echo "DB_PASSWORD: ${DB_PASSWORD:+******* (SET)}"
[ -z "$DB_PASSWORD" ] && echo "DB_PASSWORD: NOT SET"
echo ""

echo "🔧 Testing PostgreSQL connection..."
if command -v psql > /dev/null 2>&1; then
    PGPASSWORD="${DB_PASSWORD}" psql -h "${DB_HOST}" -p "${DB_PORT}" -U "${DB_USERNAME}" -d "${DB_DATABASE}" -c "SELECT version();" 2>&1
else
    echo "⚠️  psql command not found"
fi
echo ""

echo "🐘 Testing PHP PDO connection..."
php -r "
try {
    \$dsn = 'pgsql:host=${DB_HOST};port=${DB_PORT};dbname=${DB_DATABASE}';
    \$pdo = new PDO(\$dsn, '${DB_USERNAME}', '${DB_PASSWORD}');
    echo '✅ PHP PDO Connection successful!\n';
    echo 'Server version: ' . \$pdo->getAttribute(PDO::ATTR_SERVER_VERSION) . '\n';
} catch (PDOException \$e) {
    echo '❌ PHP PDO Connection failed: ' . \$e->getMessage() . '\n';
}
"
echo ""

echo "🎯 Testing Laravel connection..."
php artisan tinker --execute="
try {
    \$pdo = DB::connection()->getPdo();
    echo '✅ Laravel DB Connection successful!\n';
    echo 'Driver: ' . DB::connection()->getDriverName() . '\n';
} catch (Exception \$e) {
    echo '❌ Laravel DB Connection failed: ' . \$e->getMessage() . '\n';
}
"
