FROM php:8.4.10-apache-bookworm

WORKDIR /var/www/html

RUN apt-get update && apt-get install --no-install-recommends --no-install-suggests -y \
      apt-transport-https \
      libicu-dev \
      libzip-dev \
      unzip \
      libsqlite3-dev \
      nano \
    && rm -r /var/lib/apt/lists/* \
    && docker-php-ext-install \
      pdo_sqlite \
      bcmath \
      zip \
      intl \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer \
    && apt-get clean \
    && rm -r /var/lib/apt/lists/* \
    && rm -rf /tmp/*

RUN a2enmod rewrite