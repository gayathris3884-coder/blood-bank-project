<?php
/*
 * DB connection that supports both local XAMPP and cloud (Render) via environment variables.
 * Priority: explicit DB_* env vars -> DATABASE_URL style -> local defaults.
 * Expected env vars (set these on Render under your service's Environment):
 *   DB_HOST, DB_PORT, DB_USER, DB_PASS, DB_NAME
 */

// Local defaults (used when env vars aren't provided)
$default_host = 'localhost';
$default_port = '3306';
$default_user = 'root';
$default_pass = '';
$default_db   = 'blood_donation';

// Read explicit environment variables
$db_host = getenv('DB_HOST') ?: null;
$db_port = getenv('DB_PORT') ?: null;
$db_user = getenv('DB_USER') ?: null;
$db_pass = getenv('DB_PASS') ?: null;
$db_name = getenv('DB_NAME') ?: null;

// If a single DATABASE_URL (or CLEARDB_DATABASE_URL) is provided (mysql://user:pass@host:port/db)
$database_url = getenv('DATABASE_URL') ?: getenv('CLEARDB_DATABASE_URL') ?: '';
if ($database_url && !$db_host) {
    $parts = parse_url($database_url);
    if ($parts !== false) {
        $db_user = $parts['user'] ?? $db_user;
        $db_pass = $parts['pass'] ?? $db_pass;
        $db_host = $parts['host'] ?? $db_host;
        $db_port = $parts['port'] ?? $db_port;
        $db_name = ltrim($parts['path'] ?? $db_name, '/');
    }
}

// Final values with fallbacks
$host = $db_host ?: $default_host;
$port = $db_port ?: $default_port;
$user = $db_user ?: $default_user;
$pass = $db_pass !== null ? $db_pass : $default_pass; // allow empty password
$name = $db_name ?: $default_db;

// Create mysqli connection
$conn = new mysqli($host, $user, $pass, $name, (int)$port);
if ($conn->connect_errno) {
    die("Connection failed: (" . $conn->connect_errno . ") " . $conn->connect_error);
}

// Optionally enable exceptions (uncomment if you prefer exceptions)
// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
?>
