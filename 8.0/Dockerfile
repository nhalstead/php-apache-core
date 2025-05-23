# Normal Operations for setup of Apache and ENV Vars
FROM --platform=linux/amd64 php:8.0-apache

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

# Configure Apache
#  - Enables Modrerite
#  - Enables RemoteIP (Used for Load Balancer and RProxies)
#  - Allow htaccess overrides
#  - Changes Listen port to 8181
#  - Hides Apache Server Version Information
#  - Load Module RemoteIP
#  - Reconfigure Logging to include X-Forward-For Header
RUN a2enmod rewrite
RUN a2enmod remoteip
RUN touch /etc/apache2/conf-available/remoteip.conf
RUN ln -s /etc/apache2/conf-available/remoteip.conf /etc/apache2/conf-enabled/remoteip.conf

COPY common/remoteip-env /usr/sbin
COPY common/remoteip-clear /usr/sbin
RUN chmod +x /usr/sbin/remoteip-*

COPY common/opcache-preload /usr/sbin
COPY common/opcache-status /usr/sbin
RUN chmod +x /usr/sbin/opcache-*

RUN sed -ri -e 's!AllowOverride None!AllowOverride All!g' /etc/apache2/apache2.conf
RUN sed -ri -e 's!Listen 80!Listen 8181!g' /etc/apache2/ports.conf
RUN sed -ri -e 's!VirtualHost \*:80!VirtualHost \*:8181!g' /etc/apache2/sites-enabled/000-default.conf
RUN echo "ServerSignature off" >> /etc/apache2/apache2.conf
RUN echo "ServerTokens Prod" >> /etc/apache2/apache2.conf

RUN sed -ri -e 's!#LoadModule remoteip_module!LoadModule remoteip_module!g' /etc/apache2/apache2.conf
RUN sed -ri -e 's/LogFormat .* combined/LogFormat \"%a %{c}a %l %u %t \\\"%r\\\" %>s %b \\\"%{Referer}i\\\" \\\"%{User-Agent}i\\\" %I %O\" combined/g'  /etc/apache2/apache2.conf

EXPOSE 8181