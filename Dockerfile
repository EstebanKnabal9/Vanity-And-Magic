FROM php:8.2-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    libpq-dev \
    libmcrypt-dev \
    libssl-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Establecer el directorio de trabajo
WORKDIR /var/www

# Copiar archivos del proyecto (opcional si ya lo haces con bind mount)
# COPY . .

# Establecer permisos correctos (puedes hacerlo también desde docker-compose)
RUN chown -R www-data:www-data /var/www && chmod -R 775 /var/www

# Exponer el puerto si quieres correr php built-in server (no necesario con nginx)
EXPOSE 9000