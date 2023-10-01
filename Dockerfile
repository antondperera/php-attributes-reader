# Use the Alpine Linux 3.14 base image
FROM php:8.1-cli-alpine3.14

# Set the working directory
WORKDIR /app

# Install required PHP extensions, Composer, and Supervisor
RUN apk add --no-cache --update \
    php8-cli \
    php8-json \
    php8-mbstring \
    php8-xml \
    php8-xdebug \
    composer

# Copy docker-entrypoint.sh into the image
COPY ./docker-entrypoint.sh /app/docker-entrypoint.sh

# Set the permissions for docker-entrypoint.sh
RUN chmod +x /app/docker-entrypoint.sh

# Set the entry point to docker-entrypoint.sh
ENTRYPOINT ["/app/docker-entrypoint.sh"]

# Keep the container running without exiting
CMD ["tail", "-f", "/dev/null"]
