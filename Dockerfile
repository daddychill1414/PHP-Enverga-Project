FROM php:8.4-cli-alpine

# Install system dependencies and PHP extensions for Laravel & SQLite
RUN apk add --no-cache \
    curl \
    git \
    nodejs \
    npm \
    sqlite-dev \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_sqlite pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy project files
COPY enverga-pass/ .

# Install PHP and Node dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN npm install && npm run build

# Setup SQLite database and permissions
RUN touch database/database.sqlite \
    && chmod -R 777 storage bootstrap/cache database

# Run migrations and seed data
RUN php artisan migrate --force && php artisan db:seed --force

EXPOSE 8080

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
