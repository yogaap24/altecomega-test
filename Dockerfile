FROM php:8.3

RUN apt-get update -y && apt-get install -y zip unzip git cron libzip-dev zlib1g-dev libpng-dev libjpeg-dev libfreetype6-dev clamav clamav-daemon libpq-dev
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.3.3
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www
COPY . /var/www

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install gd \
    && docker-php-ext-install zip
RUN composer install --optimize-autoloader --no-dev
RUN php artisan key:generate
RUN php artisan config:clear

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www
COPY --chown=www:www . /var/www

USER www

CMD bash -c "php artisan serve --host=0.0.0.0 --port=9000"
EXPOSE 9000
