# Use a imagem base PHP 8.3 com FPM
FROM php:8.3-fpm

# Definir o diretório de trabalho
WORKDIR /var/www/html

# Instalar dependências do sistema
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

# Instalar extensões do PHP
RUN docker-php-ext-install gd pdo_mysql mbstring exif pcntl bcmath zip

# Instalar a extensão Redis via PECL
RUN pecl install redis && docker-php-ext-enable redis

# Instalar o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar os arquivos do projeto
COPY . /var/www/html

# Instalar dependências do Composer
RUN composer install --no-dev --prefer-dist --optimize-autoloader

# Definir permissões corretas
RUN chown -R www-data:www-data /var/www/html

# Expor a porta (configurada via docker-compose)
EXPOSE 9000

# Iniciar o servidor PHP-FPM
CMD ["php-fpm"]
