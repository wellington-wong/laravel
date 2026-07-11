FROM php:7.3-apache

# Install system packages and PHP extensions

RUN apt-get update && apt-get install -y \
	git \
	unzip \

	zip \
	curl \
	libzip-dev \

	libpng-dev \

	libjpeg62-turbo-dev \
	libfreetype6-dev \
	libxml2-dev \

	libonig-dev \
	&& docker-php-ext-configure gd \
		--with-freetype-dir=/usr/include \

		--with-jpeg-dir=/usr/include \

	&& docker-php-ext-install \
		pdo_mysql \
		mysqli \

		mbstring \
		zip \
		gd \

		bcmath \

		xml \
	&& a2enmod rewrite \
	&& rm -rf /var/lib/apt/lists/*

# Configure Apache to serve Laravel's public directory

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public





RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
	/etc/apache2/sites-available/*.conf \
	/etc/apache2/apache2.conf \

	/etc/apache2/conf-available/*.conf

# Install Composer 1

COPY --from=composer:1 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html


# Copy composer files first for better Docker layer caching
COPY composer.json composer.lock* ./

RUN composer install \

	--no-dev \
	--prefer-dist \
	--no-interaction \

	--optimize-autoloader

# Copy application
COPY . .


# Permissions
RUN mkdir -p storage bootstrap/cache && \
	chown -R www-data:www-data storage bootstrap/cache && \

	chmod -R 775 storage bootstrap/cache

EXPOSE 80

CMD ["apache2-foreground"]