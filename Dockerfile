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

# Install PCOV for code coverage (faster than Xdebug)
RUN pecl install pcov \
    && docker-php-ext-enable pcov

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

# Avoid git "dubious ownership" warnings during composer scripts
RUN git config --global --add safe.directory /var/www

# Install Laravel if not already present
RUN if [ ! -f composer.json ]; then \
        composer create-project laravel/laravel:^12.0 . --prefer-dist --no-interaction; \
    fi

# Install PHP dependencies (dev image; runtime uses mounted volume)
RUN composer install --optimize-autoloader --no-interaction

# Install Node dependencies and build frontend assets for the image layer
RUN npm ci && npm run build

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
