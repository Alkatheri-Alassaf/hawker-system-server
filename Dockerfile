# Use an official PHP runtime as a parent image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install dependencies (including PostgreSQL support)
RUN apt-get update && apt-get install -y \
    nginx \
    libpq-dev \
    php8.2-pgsql \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_pgsql gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy Laravel project files
COPY . .

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chmod -R 775 storage bootstrap/cache

# Copy Nginx configuration
COPY nginx.conf /etc/nginx/nginx.conf

# Expose HTTP port
EXPOSE 80

# Start Nginx and PHP-FPM together
CMD service nginx start && php-fpm -F
