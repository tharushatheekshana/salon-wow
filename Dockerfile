# Base PHP 8.4 CLI image
FROM php:8.4-cli-alpine

# Set working directory
WORKDIR /var/www/html

# Install system dependencies, PHP extensions, and Node.js
RUN apk add --no-cache \
    curl \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    icu-dev \
    oniguruma-dev \
    sqlite-dev \
    nodejs \
    npm \
    bash \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_sqlite \
        pdo_mysql \
        mbstring \
        bcmath \
        intl \
        zip \
        gd \
        opcache

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Set environment variables for production
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PORT=8080

# Install PHP dependencies
RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction

# Install Node dependencies and build frontend assets
RUN npm ci || npm install
RUN npm run build

# Prepare storage, bootstrap cache and database directory
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database \
    && chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# Expose the port (Render passes dynamic PORT env)
EXPOSE 8080

# Start script: create sqlite db if missing, run migrations, and serve
CMD ["sh", "-c", "touch /var/www/html/database/database.sqlite && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]
