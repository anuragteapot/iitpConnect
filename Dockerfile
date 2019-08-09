FROM php:7.3-apache 
RUN a2enmod rewrite
RUN apt-get update \
    && apt-get install -y \
        nmap \
        vim
RUN docker-php-ext-install mysqli