FROM php:8.1-fpm

COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN apt-get update -y &&  \
    apt-get install -y  \
    libbz2-dev \
    libzip-dev  \
    zip \
    libpng-dev \
    libicu-dev \
    libxml2-dev \
    libxslt-dev \
    libsodium-dev \
    php-xdebug
RUN docker-php-ext-install bcmath bz2 calendar exif gd gettext intl mysqli pcntl pdo_mysql soap sockets sysvmsg sysvsem sysvshm opcache zip xsl sodium
RUN apt-get upgrade -y
RUN apt-get install git -y
