FROM php:8.2-apache

RUN apt-get update && apt-get upgrade -y && apt-get install -y --no-install-recommends \
    ca-certificates \
    && apt-get autoremove -y && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN apt-get update && apt-get install -y \
    zip unzip git curl gnupg2 libxml2-dev libzip-dev \
    libpng-dev libonig-dev libmcrypt-dev libssl-dev \
    libpq-dev libcurl4-openssl-dev \
    libfreetype6-dev libjpeg62-turbo-dev \
    apt-transport-https lsb-release software-properties-common

RUN docker-php-ext-install pdo pdo_mysql zip

RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
    && curl https://packages.microsoft.com/config/debian/11/prod.list > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get update && ACCEPT_EULA=Y apt-get install -y msodbcsql17 unixodbc-dev gcc g++ make autoconf libc-dev pkg-config \
    && apt-get install -y libltdl-dev \
    && pecl install pdo_sqlsrv \
    && docker-php-ext-enable pdo_sqlsrv

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN a2enmod rewrite
COPY apache/000-default.conf /etc/apache2/sites-available/000-default.conf
WORKDIR /var/www/html