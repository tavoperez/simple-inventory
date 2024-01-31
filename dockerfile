FROM php:8.2-apache

# Instala las dependencias necesarias para el controlador PDO para MySQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_mysql
# RUN docker-php-ext-install pdo pdo_mysql

# Copiar archivos de configuración de Apache
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Reiniciar Apache
RUN service apache2 restart

# Copia el contenido de tu directorio de trabajo al directorio /var/www/html del contenedor
COPY . /var/www/html

# Establece los permisos de lectura y escritura en el directorio /var/www/html
RUN chown -R 777 /var/www/html