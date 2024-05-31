FROM nginx:latest

RUN apt-get update && apt-get install -y php-fpm

COPY nginx.conf /etc/nginx/nginx.conf

COPY public /var/www/html
COPY app /var/www/html/app
COPY views /var/www/html/views

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD service php7.4-fpm start && nginx -g "daemon off;"
