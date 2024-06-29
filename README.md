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

# Images

## [Github Images](https://github.com/nhalstead/php-apache-core/pkgs/container/php-apache-core)

> ghcr.io/nhalstead/php-apache-core
> #### Automatically built every 2 days

| PHP Version | Tag: Apache | Tag: Apache + Chrome |
|:------------|:------------|:---------------------|
| 8.3         | 8.3         | 8.3-headless         |
| 8.1         | 8.1         | 8.1-headless         |
| 8.0         | 8.0         | 8.0-headless         |
| 7.4         | 7.4         |                      |


## [Docker Hub Images](https://hub.docker.com/r/nhalstead00/php-apache-core)

> nhalstead00/php-apache-core
> #### Automatically built every 2 days

| PHP Version | Tag: Apache | Tag: Apache + Chrome |
|:------------|:------------|:---------------------|
| 8.3         | 8.3-latest  | 8.3-headless-latest  |
| 8.1         | 8.1-latest  | 8.1-headless-latest  |
| 8.0         | 8.0-latest  | 8.0-headless-latest  |
| 7.4         | 7.4-latest  |                      |


