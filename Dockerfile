FROM php:8.1-cli
RUN apt update && apt install -y unzip git
COPY . /usr/src/myapp
WORKDIR /usr/src/myapp
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer
RUN /usr/bin/composer install

CMD [ "vendor/bin/phpunit", "./tests" ]
