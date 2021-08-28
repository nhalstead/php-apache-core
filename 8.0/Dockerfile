# Normal Operations for setup of Apache and ENV Vars
FROM php:8.0-apache

# Configure OPCache
ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS 0
ENV PHP_OPCACHE_MAX_ACCELERATED_FILES 10000
ENV PHP_OPCACHE_MEMORY_CONSUMPTION 192
ENV PHP_OPCACHE_MAX_WASTED_PERCENTAGE 10

RUN apt-get update -y
RUN apt-get install -y openssl zip unzip git iputils-ping libpng-dev libzip-dev
RUN docker-php-ext-install gd zip pdo mysqli pdo_mysql opcache
RUN pecl install redis
RUN docker-php-ext-enable redis
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

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
RUN a2econf remoteip

RUN sed -ri -e 's!AllowOverride None!AllowOverride All!g' /etc/apache2/apache2.conf
RUN sed -ri -e 's!Listen 80!Listen 8181!g' /etc/apache2/ports.conf
RUN sed -ri -e 's!VirtualHost \*:80!VirtualHost \*:8181!g' /etc/apache2/sites-enabled/000-default.conf
RUN echo "ServerSignature off" >> /etc/apache2/apache2.conf
RUN echo "ServerTokens Prod" >> /etc/apache2/apache2.conf

RUN sed -ri -e 's!#LoadModule remoteip_module!LoadModule remoteip_module!g' /etc/apache2/apache2.conf
RUN sed -ri -e 's/LogFormat .* combined/LogFormat \"%h %a %l %u %t \\\"%r\\\" %>s %b \\\"%{Referer}i\\\" \\\"%{User-Agent}i\\\" %I %O\" combined/g'  /etc/apache2/apache2.conf
