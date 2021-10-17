<?php

$val = array(
	"HTTP_X_FORWARDED_BY" => $_SERVER["HTTP_X_FORWARDED_BY"],
	"REMOTE_ADDR" => $_SERVER["REMOTE_ADDR"],
	"opcache.enable" => ini_get("opcache.enable"),
	"opcache.validate_timestamps" => ini_get("opcache.validate_timestamps"),
	"opcache.max_accelerated_files" => ini_get("opcache.max_accelerated_files"),
	"opcache.memory_consumption" => ini_get("opcache.memory_consumption"),
	"opcache.max_wasted_percentage" => ini_get("opcache.max_wasted_percentage"),
);

switch (strtolower($_GET["format"])) {
	case "json":
		header("Content-Type: application/json");
		echo json_encode($val);
		exit();

	case "txt":
		header("Content-Type: text/plain");
		foreach ($val as $key => $value) {
			echo "$key:$value" . PHP_EOL;
		}
		exit();

	case "pdf":
		require_once __DIR__ . '/vendor/autoload.php';
		$mpdf = new \Mpdf\Mpdf(['mode' => 'c']);
		$mpdf->SetTitle("PHP Apache Config");
		$mpdf->SetSubject("PHP Apache Core Docker Image Config");

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
		$mpdf->WriteHTML($html);
		$mpdf->Output();

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

?>