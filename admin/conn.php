<?php
// Reuse environment-aware connection if available (for cloud deploy). Fallback to local defaults.
$host = getenv('DB_HOST') ?: 'dpg-d45of3ruibrs73fan6h0-a';
$user = getenv('DB_USER') ?: 'bdmsuser';
$pass = getenv('DB_PASSWORD') ?: 'PCbF8Ybzrq04GIWz7c9UXyOf6KekAaKe';
$name = getenv('DB_NAME') ?: 'bdms';
$port = getenv('DB_PORT') ?: 5432;

$conn_string = "host=$host port=$port dbname=$name user=$user password=$pass";
$conn = pg_connect($conn_string) or die("Connection error: " . pg_last_error());
?>
