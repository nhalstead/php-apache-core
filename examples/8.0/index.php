<?php

require_once __DIR__ . '/vendor/autoload.php';

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

$val = array(
	"HTTP_X_FORWARDED_BY" => $_SERVER["HTTP_X_FORWARDED_BY"] ?? "",
	"REMOTE_ADDR" => $_SERVER["REMOTE_ADDR"],
	"opcache.enable" => ini_get("opcache.enable") === "1",
	"opcache.validate_timestamps" => (int) ini_get("opcache.validate_timestamps"),
	"opcache.max_accelerated_files" => (int) ini_get("opcache.max_accelerated_files"),
	"opcache.memory_consumption" => (int) ini_get("opcache.memory_consumption"),
	"opcache.max_wasted_percentage" => (int) ini_get("opcache.max_wasted_percentage"),
);

$format = strtolower($_GET["format"] ?? null);

switch ($format) {
	case "json":
		header("Content-Type: application/json");
		echo json_encode($val);
		exit();

	case "txt":
		header("Content-Type: text/plain");
		foreach ($val as $key => $value) {
			echo "$key: $value" . PHP_EOL;
		}
		exit();

	case "pdf":

		$html = "<table>";
		$html .= "<thead>";
		$html .= "<tr><th>Key</th><th>Value</th></tr>";
		$html .= "</thead>";
		$html .= "<tbody>";
		foreach ($val as $key => $value) {
			$html .= "<tr><td>$key</td><td>$value</td></tr>";
		}
		$html .= "</tbody>";
		$html .= "</table>";

        $output = (new \Beganovich\Snappdf\Snappdf())
            ->setHtml($html)
            ->generate();
        header("Content-Type: application/pdf");
        echo $output;
        exit();

    case "html":
	default:
		header("Content-Type: text/html");
		echo "<table>";
		echo "<thead>";
		echo "<tr><th>Key</th><th>Value</th></tr>";
		echo "</thead>";
		echo "<tbody>";
		foreach ($val as $key => $value) {
			echo "<tr><td>$key</td><td>$value</td></tr>";
		}
		echo "</tbody>";
		echo "</table>";
		exit();
}
