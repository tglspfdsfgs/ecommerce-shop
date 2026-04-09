# --- APP STAGE ---

FROM php:8.5-fpm AS app-stage

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        zip \
        exif \
        pcntl \
        bcmath \
        xml \
    && rm -rf /var/lib/apt/lists/*
    
COPY ./docker/app/php-fpm.conf /usr/local/etc/php-fpm.d/zzz-custom.conf
COPY ./docker/app/php.ini /usr/local/etc/php/conf.d/zzz-custom.ini

COPY --from=composer:2.9 /usr/bin/composer /usr/bin/composer

COPY --from=node:25 /usr/local/bin/node /usr/local/bin/node
COPY --from=node:25 /usr/local/lib/node_modules /usr/local/lib/node_modules
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

COPY ./src /app

RUN composer install --optimize-autoloader --no-interaction \
    && npm ci \
    && npm run build

RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache \
    && chmod -R 775 /app/storage /app/bootstrap/cache

COPY docker/app/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm"]

# --- NGINX STAGE ---

FROM nginx:alpine AS nginx-stage

RUN rm -f /var/log/nginx/access.log /var/log/nginx/error.log \
    && touch /var/log/nginx/access.log /var/log/nginx/error.log \
    && chmod 666 /var/log/nginx/*.log

COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

COPY --from=app-stage /app/public /app/public

CMD ["nginx", "-g", "daemon off;"]
