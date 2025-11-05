<?php
// Database connection helper
// Support explicit env vars (DB_HOST/DB_PORT/DB_NAME/DB_USER/DB_PASSWORD)
// or a single DATABASE_URL (eg. postgres://user:pass@host:port/dbname) as provided by many PaaS providers.

$databaseUrl = getenv('DATABASE_URL');
if ($databaseUrl) {
    $parts = parse_url($databaseUrl);
    $host = $parts['host'] ?? 'localhost';
    $port = $parts['port'] ?? '5432';
    $user = $parts['user'] ?? '';
    $password = $parts['pass'] ?? '';
    $path = $parts['path'] ?? '';
    $dbname = ltrim($path, '/');
    // prefer sslmode=require for remote hosts unless explicitly disabled
    $sslmode = getenv('DB_SSLMODE') ?: 'require';
    $conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password sslmode=$sslmode";
} else {
    // fall back to individual env vars (use sensible local defaults)
    $host = getenv('DB_HOST') ?: 'localhost';
    $port = getenv('DB_PORT') ?: '5432';
    $dbname = getenv('DB_NAME') ?: 'bdms';
    $user = getenv('DB_USER') ?: 'bdmsuser';
    $password = getenv('DB_PASSWORD') ?: '';
    $conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";
}

// Connect to PostgreSQL
$conn = @pg_connect($conn_string);
if (!$conn) {
    // Provide a developer-friendly message; avoid exposing credentials in production logs
    die("Database connection failed: " . htmlspecialchars(pg_last_error()));
}
?>
