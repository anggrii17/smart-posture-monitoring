FROM php:8.2-cli

WORKDIR /app

# Install extension yang dibutuhkan
RUN docker-php-ext-install mysqli

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy project
COPY . .

# Install dependency Composer
RUN composer install --no-dev --optimize-autoloader

EXPOSE 8080

CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-8080}"]