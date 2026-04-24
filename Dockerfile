FROM php:8.2-cli

# Install system dependencies and image tools for QR codes
RUN apt-get update -y && apt-get install -y \
    unzip \
    libpq-dev \
    libcurl4-gnutls-dev \
    nodejs \
    npm \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo pdo_mysql bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy all project files into the server
COPY . .

# Install PHP and Node dependencies
RUN composer install --optimize-autoloader --no-dev
RUN npm install
RUN npm run build

# Give permission to Laravel to save files
RUN chmod -R 777 storage bootstrap/cache

# Start the server
# CMD php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}