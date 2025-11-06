#!/bin/sh

if [ ! -f .env ]; then
  echo "Creando archivo .env a partir de .env.example"
  cp .env.example .env
fi

if [ ! -d vendor ]; then
  echo "Ejecutando composer install..."
  composer install --prefer-dist --optimize-autoloader --no-scripts
fi

# ELIMINACIÓN MANUAL DE CACHÉ (Para resolver el error "Class not found")
echo "Eliminando directorios de caché y configuración obsoletos..."
rm -rf bootstrap/cache/*.php
rm -rf storage/framework/cache/data/*

# ESPERA A LA BASE DE DATOS
/usr/local/bin/wait-for-it.sh db:3306 --timeout=30 --strict -- echo "Base de datos lista, ejecutando setup."

# SETEO DE PERMISOS
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# LIMPIEZA Y OPTIMIZACIÓN DE CONFIGURACIÓN
echo "Limpiando y configurando Laravel..."
php artisan config:cache
php artisan optimize:clear
php artisan key:generate
# MIGRACIONES
echo "Ejecutando migraciones y seeders..."
php artisan migrate:fresh --seed --force

# INICIA APACHE
echo "Iniciando servidor Apache..."
exec apache2-foreground