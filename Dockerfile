# Użyj oficjalnego obrazu PHP z Apache
FROM php:8.2.0-apache

# Ustaw zmienną środowiskową APP_HOME na katalog, w którym chcesz umieścić swoją aplikację w kontenerze
ENV APP_HOME /var/www/html/

# Włącz rozszerzenie intl
RUN apt-get update && apt-get install -y \
    libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

# Utwórz katalog dla aplikacji
RUN mkdir -p $APP_HOME
RUN mkdir -p /var/www/html/logs /var/www/html/tmp && chown -R www-data:www-data /var/www/html/logs /var/www/html/tmp
RUN docker-php-ext-install mysqli pdo pdo_mysql
# Ustaw katalog roboczy na katalog aplikacji
WORKDIR $APP_HOME

# Skopiuj zawartość twojego katalogu xampp/htdocs/cinkciarzSchool do katalogu aplikacji w kontenerze
COPY . $APP_HOME

# Udostępnij port 80, aby można było połączyć się z Apache
EXPOSE 80