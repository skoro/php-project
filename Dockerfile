FROM php:8.2-fpm

RUN apt-get update \
    && apt-get install --no-install-recommends -y \
      unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-enable opcache

WORKDIR /var/www/html

COPY docker/php/docker-php-entrypoint.sh /usr/local/bin/docker-php-entrypoint
RUN chmod +x /usr/local/bin/docker-php-entrypoint

# copy sources to work dir
COPY . ./

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

ENTRYPOINT ["docker-php-entrypoint"]
CMD ["php-fpm"]
