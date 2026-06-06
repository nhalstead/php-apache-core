# Normal Operations for setup of Apache and ENV Vars
# Allow building different PHP versions from build args (CI uses PHP_VERSION)
ARG PHP_VERSION=8.3
ARG PHP_TAG=${PHP_VERSION}-apache
FROM php:${PHP_TAG} AS base

# Configure OPCache
ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS=0
ENV PHP_OPCACHE_MAX_ACCELERATED_FILES=10000
ENV PHP_OPCACHE_MEMORY_CONSUMPTION=192
ENV PHP_OPCACHE_MAX_WASTED_PERCENTAGE=10

COPY common/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

RUN apt-get update -y; \
	apt-get install -y openssl zip unzip git wget iputils-ping libpng-dev libzip-dev libmagickwand-dev --no-install-recommends; \
	docker-php-ext-install gd zip pdo mysqli pdo_mysql opcache; \
	pecl install redis; \
	pecl install imagick; \
	docker-php-ext-enable redis; \
	docker-php-ext-enable imagick; \
	apt autoremove -y; \
	curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer; \
	rm -rf /var/lib/apt/lists/*;

FROM base

# Configure Apache and combine many small RUN steps into a single layer to
# reduce image size and improve caching.
# This groups enabling modules, adding configs, making files executable and adjusting Apache settings.
COPY common/remoteip-env /usr/sbin
COPY common/remoteip-clear /usr/sbin
COPY common/opcache-preload /usr/sbin
COPY common/opcache-status /usr/sbin

RUN set -eux; \
	a2enmod rewrite remoteip; \
	touch /etc/apache2/conf-available/remoteip.conf; \
	ln -s /etc/apache2/conf-available/remoteip.conf /etc/apache2/conf-enabled/remoteip.conf || true; \
	chmod +x /usr/sbin/remoteip-* /usr/sbin/opcache-* || true; \
	sed -ri -e 's!AllowOverride None!AllowOverride All!g' /etc/apache2/apache2.conf; \
	sed -ri -e 's!Listen 80!Listen 8181!g' /etc/apache2/ports.conf; \
	sed -ri -e 's!VirtualHost \*:80!VirtualHost \*:8181!g' /etc/apache2/sites-enabled/000-default.conf; \
	echo "ServerSignature off" >> /etc/apache2/apache2.conf; \
	echo "ServerTokens Prod" >> /etc/apache2/apache2.conf; \
	sed -ri -e 's!#LoadModule remoteip_module!LoadModule remoteip_module!g' /etc/apache2/apache2.conf; \
	sed -ri -e 's/LogFormat .* combined/LogFormat "%a %{c}a %l %u %t \\\"%r\\\" %>s %b \\\"%{Referer}i\\\" \\\"%{User-Agent}i\\\" %I %O" combined/g'  /etc/apache2/apache2.conf

EXPOSE 8181