FROM php:8.3-apache

# Extensión PDO para MySQL y mod_rewrite (lo usa .htaccess)
RUN docker-php-ext-install pdo_mysql \
    && a2enmod rewrite \
    && sed -ri 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

WORKDIR /var/www/html
COPY . /var/www/html
RUN rm -f .env && chown -R www-data:www-data /var/www/html

# Render (y otros servicios) indican el puerto en la variable PORT; por defecto 80.
ENV PORT=80
EXPOSE 80
CMD ["sh", "-c", "sed -ri \"s/^Listen .*/Listen ${PORT}/\" /etc/apache2/ports.conf && sed -ri \"s/<VirtualHost \\*:[0-9]+>/<VirtualHost *:${PORT}>/\" /etc/apache2/sites-available/000-default.conf && apache2-foreground"]
