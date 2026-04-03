# ---------- Stage 1: Composer ----------
FROM composer:2.9 AS composer-stage

WORKDIR /app

COPY src/composer.json src/composer.lock ./

RUN composer install \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts

# ---------- Stage 2: Node ----------
FROM node:25 AS node-stage

WORKDIR /app

COPY src/package.json src/package-lock.json ./

RUN npm ci

COPY src/ ./

RUN npm run build

# ---------- Stage 3: PHP ----------
FROM php:8.5-fpm

WORKDIR /app

RUN apt-get update && apt-get install -y \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    unzip \
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

COPY src/ /app

COPY --from=composer-stage /app/vendor /app/vendor

COPY --from=node-stage /app/public/build /app/public/build

COPY docker/app/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]

CMD ["php-fpm"]
