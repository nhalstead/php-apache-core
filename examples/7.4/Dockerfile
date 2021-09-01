FROM nhalstead00/php-apache-core:7.4-latest

COPY index.php /var/www/html
COPY run-start /usr/sbin

RUN chmod +x /usr/sbin/run-start

CMD ["run-start"]