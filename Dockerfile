FROM php:8.1-fpm-alpine as php-stage

RUN apk add --no-cache \
    libpng-dev \
    libjpeg-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    zlib-dev \
    git \
    bash \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

FROM node:16-alpine as node-stage

WORKDIR /app

COPY package*.json ./

RUN npm install

FROM nginx:alpine as nginx-stage

COPY ./nginx/default.conf /etc/nginx/conf.d/default.conf

COPY --from=node-stage /app/public /usr/share/nginx/html

FROM php:8.1-fpm-alpine

WORKDIR /var/www

COPY . .

RUN composer install --optimize-autoloader --no-dev

COPY --from=node-stage /app /var/www

RUN npm run prod

EXPOSE 9000

CMD ["sh", "-c", "php-fpm & nginx -g 'daemon off;'"]
