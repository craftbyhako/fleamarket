FROM php:7.4.9-fpm

COPY php.ini /usr/local/etc/php/

RUN echo "deb http://archive.debian.org/debian buster main contrib non-free" > /etc/apt/sources.list \
  && echo "deb http://archive.debian.org/debian buster-updates main contrib non-free" >> /etc/apt/sources.list \
  && echo "deb http://archive.debian.org/debian-security buster/updates main contrib non-free" >> /etc/apt/sources.list \
  && echo 'Acquire::Check-Valid-Until "false";' > /etc/apt/apt.conf.d/99no-check-valid-until \
  && apt-get update \
  && apt-get install -y default-mysql-client zlib1g-dev libzip-dev unzip \
  && docker-php-ext-install pdo_mysql zip


# RUN sed -i 's/deb.debian.org/archive.debian.org/g' /etc/apt/sources.list \
#   && sed -i 's|security.debian.org|archive.debian.org/debian-security|g' /etc/apt/sources.list \
#   && echo 'Acquire::Check-Valid-Until "false";' > /etc/apt/apt.conf.d/99no-check-valid-until \
#   && apt update \
#   && apt install -y default-mysql-client zlib1g-dev libzip-dev unzip \
#   && docker-php-ext-install pdo_mysql zip

RUN curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/composer \
  && composer self-update

WORKDIR /var/www