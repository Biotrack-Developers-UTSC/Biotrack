FROM php:8.2-fpm

# --- 1. INSTALACIÓN DE DEPENDENCIAS DEL SISTEMA ---
# Necesario para extensiones PHP y para Git/Unzip (para Composer)
RUN apt-get update && apt-get install -y \
    netcat-openbsd \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    libpng-dev \
    libxml2-dev \
    # Dependencias de GD y otras comunes en Laravel
    && rm -rf /var/lib/apt/lists/*

# --- 2. INSTALACIÓN DE EXTENSIONES PHP ---
# Instalamos las extensiones necesarias
RUN docker-php-ext-install pdo pdo_mysql zip opcache
# Extensiones comunes para Laravel que a menudo faltan:
RUN docker-php-ext-install mbstring exif pcntl bcmath gd sockets dom

# --- 3. INSTALACIÓN DE COMPOSER ---
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# --- 4. CONFIGURACIÓN DEL PROYECTO ---
COPY . /var/www
WORKDIR /var/www

# --- 5. PASO CRUCIAL (CON FIX DE MEMORIA) ---
# Ejecutamos Composer con la memoria ilimitada (memory_limit=-1) para evitar el error 'exit code: 2'
# También usamos COMPOSER_ALLOW_SUPERUSER=1 para evitar errores de permisos.
RUN php -d memory_limit=-1 /usr/bin/composer install --no-dev --optimize-autoloader --no-interaction

# --- 6. PERMISOS Y CMD ---
# Establecer permisos para el usuario www-data, esencial para el volumen /storage
RUN chown -R www-data:www-data /var/www

ENTRYPOINT [ "/var/www/entrypoint.sh" ]
EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]