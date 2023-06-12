# Use the official PHP with Apache image
FROM php:8.2.0-apache

# Set the APP_HOME environment variable to the directory where you want to place your application in the container
ENV APP_HOME /var/www/html/

# Set the user to "root" during installation
USER root

# Enable necessary Apache modules
RUN a2enmod headers
RUN a2enmod rewrite

# Enable the intl extension
RUN apt-get update && apt-get install -y \
    libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

# Create directories for the application and set proper permissions
RUN mkdir -p /var/www/html/logs /var/www/html/tmp
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 /var/www/html/logs /var/www/html/tmp

# Install required PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Switch to "www-data" user before copying files
USER www-data

# Set the working directory to the application directory
WORKDIR $APP_HOME

# Copy the contents of your path/school directory to the application directory in the container
COPY --chown=www-data:www-data . $APP_HOME

# Expose port 80 to allow connection with Apache (this should be done as the root user)
USER root
EXPOSE 80