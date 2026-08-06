FROM php:8.2-cli

WORKDIR /app

# Install package yang dibutuhkan
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    && docker-php-ext-install mysqli zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy project
COPY . .

# Install dependency
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN composer install --no-dev --optimize-autoloader

EXPOSE 8080

CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-8080}"]