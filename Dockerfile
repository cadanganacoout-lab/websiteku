FROM php:8.2-apache

# Instal dependensi untuk MongoDB
RUN apt-get update && apt-get install -y \
    libssl-dev \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

# Aktifkan mod_rewrite Apache (penting untuk routing PHP)
RUN a2enmod rewrite

# Salin semua file proyek ke folder web server
COPY . /var/www/html/

# Ubah root direktori Apache ke folder 'public'
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

EXPOSE 80
