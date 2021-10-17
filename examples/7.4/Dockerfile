FROM nhalstead00/php-apache-core:7.4-latest

ENV APACHE_DOCUMENT_ROOT /home/app

RUN mkdir -p /home/app
WORKDIR /home/app

COPY . /home/app
RUN mv /home/app/run-start /usr/sbin

# Change the location of where Apache if serving the files from
RUN sed -ri -e "s!/var/www(/html|)!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf /etc/apache2/sites-enabled/000-default.conf

RUN chmod +x /usr/sbin/run-start

RUN composer install
RUN chmod -R 777 /home/app/vendor/mpdf/mpdf/tmp

CMD ["run-start"]