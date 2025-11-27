# Usa una imagen base oficial de PHP con Composer
FROM php:8.2-fpm

# Instala extensiones necesarias para Laravel
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev zip curl libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql zip bcmath gd

# Instala Composer desde otra imagen oficial
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Define el directorio de trabajo
WORKDIR /var/www/html

# Copia todos los archivos del proyecto
COPY . .

# Instala las dependencias de Laravel (solo producción)
RUN composer install --no-dev --optimize-autoloader

# Copia el .env (puedes crear uno nuevo o usar variables en Cloud Run)
# RUN cp .env.example .env

# Genera la key de la aplicación
RUN php artisan key:generate --force

# Ajusta permisos para storage y bootstrap
RUN chmod -R 777 storage bootstrap/cache

# Expone el puerto que usará la app
EXPOSE 8080

# Usa el servidor embebido de Laravel
CMD php artisan serve --host=0.0.0.0 --port=8080
