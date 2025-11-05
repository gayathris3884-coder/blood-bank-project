<?php
// Database connection helper
// Supports explicit env vars or hardcoded values

// Local PostgreSQL credentials
$host = 'localhost';
$port = '5432';
$dbname = 'bdms';
$user = 'postgres';
$password = 'gayu@126'; // Your PostgreSQL password

$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";

// Connect to PostgreSQL
$conn = @pg_connect($conn_string);
if (!$conn) {
    // Avoid calling pg_last_error() without a connection resource
    error_log('pg_connect failed: ' . var_export(error_get_last(), true));
    die("Database connection failed. Please check your connection settings and database server.");
}
?>
