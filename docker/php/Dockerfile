FROM php:7.4-fpm

WORKDIR /var/www/html

RUN apt-get -y update && apt-get install -y libicu-dev libzip-dev zip libjpeg-dev libpng-dev libfreetype6-dev git libpq-dev imagemagick libmagickwand-dev --no-install-recommends gsfonts
RUN docker-php-ext-configure intl
RUN docker-php-ext-configure gd '--with-jpeg' '--with-freetype'
RUN docker-php-ext-install intl opcache zip gd pdo pdo_mysql pdo_pgsql pgsql iconv ctype

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sS https://get.symfony.com/cli/installer | bash && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

RUN pecl install mongodb redis imagick && docker-php-ext-enable mongodb redis imagick
COPY . .

EXPOSE 9000

CMD ["php-fpm"]
