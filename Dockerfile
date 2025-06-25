# Imagen base oficial de PHP con Apache
FROM php:8.2-apache

# Activar mod_rewrite (opcional si usas rutas limpias)
RUN a2enmod rewrite

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiar todo al contenedor
COPY . /var/www/html/

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Instalar dependencias de Composer
RUN composer install

# Dar permisos adecuados
RUN chown -R www-data:www-data /var/www/html
