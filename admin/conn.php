<?php
// Reuse environment-aware connection if available (for cloud deploy). Fallback to local defaults.
$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';
$name = getenv('DB_NAME') ?: 'blood_donation';
$port = getenv('DB_PORT') ?: 3306;

$conn = mysqli_connect($host, $user, $pass, $name, (int)$port) or die("Connection error: " . mysqli_connect_error());
?>
