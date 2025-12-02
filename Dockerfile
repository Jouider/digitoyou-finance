FROM php:8.4-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    sqlite3 \
    libsqlite3-dev \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Create SQLite database
RUN touch database/database.sqlite

# Set permissions
RUN chmod -R 755 storage bootstrap/cache && \
    chmod 664 database/database.sqlite

# Create .env file from .env.example
RUN if [ -f .env.example ]; then cp .env.example .env; else \
    echo "APP_NAME=DigiFinance" > .env && \
    echo "APP_ENV=production" >> .env && \
    echo "APP_DEBUG=false" >> .env && \
    echo "APP_URL=https://digitoyou-finance.onrender.com" >> .env && \
    echo "DB_CONNECTION=sqlite" >> .env && \
    echo "DB_DATABASE=/app/database/database.sqlite" >> .env; fi

# Generate application key
RUN php artisan key:generate --force

# Run migrations and seed
RUN php artisan migrate --force && \
    php artisan db:seed --force

# Cache configuration
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Expose port
EXPOSE 8080

# Start the application
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
