# Dockerfile
FROM php:8.3-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libpq-dev

RUN docker-php-ext-install gd
# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy existing application directory contents
COPY . /var/www/html

# Change current user to www-data
RUN chown -R www-data:www-data /var/www/html
# Change current user to www-data
RUN chown -R www-data:www-data /var/www/html

# Expose port (configured via docker-compose)
EXPOSE 9000

# Start php-fpm server
CMD ["php-fpm"]
