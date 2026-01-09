FROM php:8.4-fpm

# ==============================
# Set working directory
# ==============================
WORKDIR /var/www

# ==============================
# Install system dependencies
# ==============================
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        bcmath \
        gd \
        zip

# ==============================
# Clean apt cache
# ==============================
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# ==============================
# Install Composer
# ==============================
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ==============================
# Copy Laravel source
# ==============================
COPY --chown=www-data:www-data . /var/www

# ==============================
# Install PHP dependencies
# ==============================
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

# ==============================
# Prepare Laravel directories
# ==============================
RUN mkdir -p \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# ==============================
# Use non-root user
# ==============================
USER www-data

# ==============================
# Expose PHP-FPM port
# ==============================
EXPOSE 9000

# ==============================
# Start PHP-FPM (FOREGROUND)
# ==============================
CMD ["php-fpm", "-F"]
