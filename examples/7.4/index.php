<?php

header("Content-Type: text/plain");

echo "HTTP_X_FORWARDED_BY: " . $_SERVER["HTTP_X_FORWARDED_BY"] . PHP_EOL;
echo "REMOTE_ADDR: " . $_SERVER["REMOTE_ADDR"] . PHP_EOL;
echo  PHP_EOL;

echo "----------------" . PHP_EOL;
echo "OPCache Options:" . PHP_EOL;
echo "opcache.enable=" .ini_get("opcache.enable") . PHP_EOL;
echo "opcache.validate_timestamps=" .ini_get("opcache.validate_timestamps") . PHP_EOL;
echo "opcache.max_accelerated_files=" .ini_get("opcache.max_accelerated_files") . PHP_EOL;
echo "opcache.memory_consumption=" .ini_get("opcache.memory_consumption") . PHP_EOL;
echo "opcache.max_wasted_percentage=" .ini_get("opcache.max_wasted_percentage") . PHP_EOL;

?>