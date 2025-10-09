# Use PHP 8.4 with FPM
FROM php:8.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Create a user with UID 1000
RUN groupadd -g 1000 developer && \
    useradd -u 1000 -g developer -m -s /bin/bash developer

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory contents
COPY . /var/www

# Fix ownership and permissions (run as root)
RUN chown -R developer:developer /var/www && \
    chmod -R 755 /var/www && \
    mkdir -p /var/www/.cache && \
    chown -R developer:developer /var/www/.cache

# Install Laravel if not already present
RUN if [ ! -f composer.json ]; then \
        composer create-project laravel/laravel:^12.0 . --prefer-dist --no-interaction; \
    fi

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install PEST for testing
RUN composer require pestphp/pest --dev --no-interaction --with-all-dependencies

# Install Node.js dependencies
RUN npm install

# Install frontend dependencies (Vue.js, TypeScript, Tailwind, etc.)
RUN npm install vue@latest @vitejs/plugin-vue typescript @types/node tailwindcss postcss autoprefixer --save-dev

# Generate Laravel application key only if not already set
RUN if [ -z "$(grep 'APP_KEY=' .env | cut -d'=' -f2)" ] || [ "$(grep 'APP_KEY=' .env | cut -d'=' -f2)" = "" ]; then \
        php artisan key:generate --no-interaction; \
    fi

# Build frontend assets
RUN npm run build

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
