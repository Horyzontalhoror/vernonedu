FROM php:8.4-fpm

# package
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    nodejs \
    npm

# php ext
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    zip \
    exif \
    pcntl \
    bcmath \
    intl \
    gd

# composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# workdir
WORKDIR /var/www

# copy
COPY . .

# env
RUN cp .env.docker .env || true

# composer
RUN composer install --no-interaction --prefer-dist

# vite
RUN npm install

# key
RUN php artisan key:generate

# permission
RUN chmod -R 777 storage bootstrap/cache

# expose
EXPOSE 8000
EXPOSE 5173
EXPOSE 8080
