# Imagen base
FROM php:8.2-fpm

# Actualizar paquetes e instalar dependencias necesarias
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
    gnupg \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Configurar directorio de trabajo
WORKDIR /var/www

# Exponer puerto para PHP
EXPOSE 9000

# Comando por defecto
CMD ["php-fpm"]
