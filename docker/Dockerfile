FROM php:8.1-fpm

COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN apt update -y
RUN apt upgrade -y
RUN apt-get install git -y