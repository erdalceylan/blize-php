FROM php:8.2-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y libicu-dev libzip-dev zip libjpeg-dev libpng-dev libfreetype6-dev git libpq-dev imagemagick libmagickwand-dev --no-install-recommends gsfonts

# Install php extensions
RUN docker-php-ext-configure intl
RUN docker-php-ext-configure gd --with-jpeg --with-freetype
RUN docker-php-ext-install intl opcache zip gd pdo pdo_mysql pdo_pgsql pgsql iconv ctype

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

# Install additional extensions (if needed)
RUN pecl install mongodb redis imagick && docker-php-ext-enable mongodb redis imagick

# Copy project files
COPY . .

EXPOSE 9000

CMD ["php-fpm"]