<?php
// Use environment variables from Render for security
$host = getenv('DB_HOST') ?: 'dpg-d45of3ruibrs73fan6h0-a'; // replace with your Render DB host
$port = getenv('DB_PORT') ?: '5432';
$dbname = getenv('DB_NAME') ?: 'bdms';
$user = getenv('DB_USER') ?: 'bdmsuser';
$password = getenv('DB_PASSWORD') ?: 'PCbF8Ybzrq04GIWz7c9UXyOf6KekAaKe';

// Connect to PostgreSQL
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}
?>
