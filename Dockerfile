FROM php:8.1-fpm

# Install necessary dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    libonig-dev \
    && docker-php-ext-install -j$(nproc) iconv mbstring gd zip

# Create a new PHP-FPM configuration file with the required settings
RUN echo "listen = 0.0.0.0:9000\n\
listen.owner = www-data\n\
listen.group = www-data\n\
listen.mode = 0660" > /usr/local/etc/php-fpm.d/zz-docker.conf

# Copy NGINX configuration file
COPY nginx.conf /etc/nginx/nginx.conf

# Copy your application files
COPY . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Ensure proper permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80

# Start NGINX and PHP-FPM
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]
