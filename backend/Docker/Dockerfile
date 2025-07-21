FROM php:8.2-fpm

# Define build arguments with default values
ARG user=markrusselbaral
ARG uid=1000


# Update and install dependencies
RUN apt update && apt install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    libzip-dev \
    zip \
    unzip \
    default-mysql-client


# Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    intl \
    zip

# Clean up to reduce image size
RUN apt clean && rm -rf /var/lib/apt/lists/*

# Add Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set up user
# Use shell format to expand ARG variables correctly
RUN useradd -m -u ${uid} -G www-data,root ${user}
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set the working directory
WORKDIR /var/www

# Switch to the created user
USER $user
