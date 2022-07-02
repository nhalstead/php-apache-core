# PHP Apache Docker Image

## Why

The images formed from this repo is to help minimize the extra steps needed to get up and running with a PHP Image with apache to serve traffic. All docker images are built in a CI pipeline and run every 2 days to ensure all dependencies are up-to-date with the source they are installed from.

After using this docker image in other pipelines I was able to cut build times down by 4-5 minutes per build.

## Changes

This image is the PHP 7.4 (and 8.0, 8.1) packaged with the following changes:
- PHP (version 7.4 or 8.0)
- Apache
- OPCache (and configured)
- OpenSSL
- ZIP (with libzip-dev and php extension)
- git
- iputils
- Redis Extension
- GD and imagick Extensions
- PDO
- MYSQL / PDO MYSQLI Extensions
- Apache Mod Rewrite Module
- Apache Mod Remote IP Module
- Apache Signatures Off
- Apache Allow htaccess overrides
- Apache Logs Updated to include the remote ips

---

# [Images](https://hub.docker.com/r/nhalstead00/php-apache-core)

- nhalstead00/php-apache-core:8.1-latest
- nhalstead00/php-apache-core:8.1-headless-latest
  - Extra resources for headless browsers
  - Use this image if using chromium.
- nhalstead00/php-apache-core:8.0-latest
- nhalstead00/php-apache-core:8.0-headless-latest
  - Extra resources for headless browsers
  - Use this image if using chromium.
- nhalstead00/php-apache-core:7.4-latest
