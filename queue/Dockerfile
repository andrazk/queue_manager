FROM php:5.6-cli

RUN apt-get update && \
    apt-get install -y \
    git \
    curl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

COPY . /usr/src/

WORKDIR /usr/src/

RUN composer install --prefer-source --no-interaction

EXPOSE 8000
