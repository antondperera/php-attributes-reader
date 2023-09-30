# Use the Alpine Linux 3.14 base image
FROM php:8.1-cli-alpine3.14

# Set the working directory
WORKDIR /app

# Copy your application files into the image
COPY ./ /app

# Install required PHP extensions, Composer, and Supervisor
RUN apk add --no-cache --update \
    php8-cli \
    php8-json \
    php8-mbstring \
    php8-xml \
    php8-xdebug \
    composer

RUN composer install

# Making sure Vendor folder is available within the image (to avoid missing it within Docker image build process)
COPY ./vendor /app/vendor