FROM php:8.2-cli
RUN apt-get update -y && apt-get install -y \
    git \
    libpq-dev
RUN docker-php-ext-install pdo_pgsql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sS https://get.symfony.com/cli/installer | bash

WORKDIR /app
COPY . /app

CMD tail -f /dev/null

EXPOSE 80