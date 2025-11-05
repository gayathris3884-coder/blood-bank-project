<?php
$host = "YOUR_RENDER_DB_HOST";
$port = "5432";
$dbname = "bdms";
$user = "bdmsuser";
$password = "PCbF8Ybzrq04GIWz7c9UXyOf6KekAaKe";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}
?>
