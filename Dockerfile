FROM php:8.2-apache 

# Required packages
RUN apt-get update && apt-get install -y \
    curl \
    g++ \
    git \
    libbz2-dev \
    libfreetype6-dev \
    libicu-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libpng-dev \
    libonig-dev \
    libreadline-dev \
    libzip-dev \
    sudo \
    unzip \
    zip \
    && rm -rf /var/lib/apt/lists/*

# Apache configuration
RUN echo "ServerName web-app.local" >> /etc/apache2/apache2.conf

ENV APACHE_WWW_APP_PATH=/var/www/html
ENV APACHE_DOCUMENT_ROOT=${APACHE_WWW_APP_PATH}/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Mod_rewrite for URL rewrite and mod_headers for .htaccess extra headers like Access-Control-Allow-Origin-
RUN a2enmod rewrite headers

# Use development PHP initialization file
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# Add PHP extensions
RUN docker-php-ext-install \
    bcmath \
    bz2 \
    calendar \
    iconv \
    intl \
    mbstring \
    opcache \
    pdo_mysql \
    zip

# Install Composer (just copy it from the latest composer image)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configure local user
ARG uid
ARG username
RUN useradd -G www-data,root -u ${uid} -d /home/${username} ${username}
RUN mkdir -p /home/${username}/.composer && \
    chown -R ${username}:${username} /home/${username}
USER ${username}

# Set current path to the project folder
ENV USER_APP_PATH=/home/${username}/project
WORKDIR ${USER_APP_PATH}