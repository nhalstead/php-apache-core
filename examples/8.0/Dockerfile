FROM nhalstead00/php-apache-core:8.0-headless-latest as builder

ENV APACHE_DOCUMENT_ROOT /home/app

RUN mkdir -p /home/app
WORKDIR /home/app

COPY composer.json /home/app

# Change the location of where Apache if serving the files from
RUN sed -ri -e "s!/var/www(/html|)!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf /etc/apache2/sites-enabled/000-default.conf

RUN composer install

# Download Chromium if snappdf is installed
RUN test -e ./vendor/bin/snappdf && ./vendor/bin/snappdf download

FROM builder

COPY . /home/app
RUN mv /home/app/run-start /usr/sbin
RUN chmod +x /usr/sbin/run-start

RUN chmod +x /home/app/vendor/beganovich/snappdf/versions/*-Linux_x64/chrome-linux/chrome
RUN chmod +x /home/app/vendor/beganovich/snappdf/versions/*-Linux_x64/chrome-linux/chrome_crashpad_handler

CMD ["run-start"]