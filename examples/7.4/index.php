<?php

header("Content-Type: text/plain");

echo "HTTP_X_FORWARDED_BY: " . $_SERVER["HTTP_X_FORWARDED_BY"];
echo PHP_EOL;
echo "REMOTE_ADDR: " . $_SERVER["REMOTE_ADDR"];

?>