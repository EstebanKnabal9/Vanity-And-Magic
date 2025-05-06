#!/bin/bash

# Esperar a que MySQL esté listo
until mysqladmin ping -h"$DB_HOST" --silent; do
    echo "Esperando la base de datos..."
    sleep 2
done

# Instalar dependencias de PHP si no existen
if [ ! -d "vendor" ]; then
    composer install
fi

# Instalar Breeze si no está instalado
if [ ! -d "resources/js" ]; then
    php artisan breeze:install
    npm install && npm run build
fi

# Publicar y migrar Spatie Permission si no está ya configurado
if ! php artisan migrate:status | grep "Create permission tables"; then
    php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --force
    php artisan migrate
fi

# Asegurar permisos correctos
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Levantar PHP-FPM
exec php-fpm
