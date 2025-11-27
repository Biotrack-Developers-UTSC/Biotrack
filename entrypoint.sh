#!/bin/bash

# Nombre del servicio de BD y puerto (según tu docker-compose.yml)
DB_HOST="db"
DB_PORT="3306"

echo "Waiting for database connection..."
# Espera (hasta 30 segundos) a que el puerto 3306 de MySQL esté abierto
while ! nc -z $DB_HOST $DB_PORT; do
  sleep 1
done
echo "Database connection established. Starting migrations..."

# 1. Aseguramos permisos de Laravel (lo que arreglamos antes)
chown -R www-data:www-data /var/www/storage
chown -R www-data:www-data /var/www/bootstrap/cache

# 2. Ejecutar la migración y siembra
php artisan migrate:fresh --seed --force

echo "Migrations and seeding completed successfully."

# 3. Iniciar el proceso principal del contenedor (PHP-FPM)
exec "$@"