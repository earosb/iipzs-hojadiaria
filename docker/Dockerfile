FROM php:5.6-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libmcrypt-dev \
    libzip-dev

RUN docker-php-ext-install mysqli \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mcrypt \
    && docker-php-ext-install pcntl \
    && docker-php-ext-install zip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Get latest Composer
COPY --from=composer:1.4.3 /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

USER $user
