<?php
/**
 * import_sql.php
 * Small helper to import a SQL dump into a PostgreSQL database using PHP's pg_* functions.
 *
 * Usage (env vars):
 *   Set DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASSWORD in your environment then run:
 *     php import_sql.php
 *
 * Usage (CLI args):
 *   php import_sql.php --host=HOST --port=PORT --dbname=DBNAME --user=USER --password=PASSWORD --file=./sql/blood_bank_database.sql
 *
 * Notes:
 * - This runs the file contents through pg_query(). Complex dumps (COPY, large multiline function bodies,
 *   or psql-specific commands) may not run perfectly via this script. Prefer psql CLI for a faithful import.
 * - This script is intended for local use and convenience. Do not expose it on public servers.
 */

$options = getopt('', ['host::','port::','dbname::','user::','password::','file::']);

$host = getenv('DB_HOST') ?: ($options['host'] ?? 'localhost');
$port = getenv('DB_PORT') ?: ($options['port'] ?? '5432');
$dbname = getenv('DB_NAME') ?: ($options['dbname'] ?? 'bdms');
$user = getenv('DB_USER') ?: ($options['user'] ?? 'bdmsuser');
$password = getenv('DB_PASSWORD') ?: ($options['password'] ?? '');
$file = $options['file'] ?? __DIR__ . '/../sql/blood_bank_database.sql';

if (!file_exists($file)) {
    fwrite(STDERR, "SQL file not found: $file\n");
    exit(2);
}

$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";
$conn = pg_connect($conn_string);
if (!$conn) {
    fwrite(STDERR, "Failed to connect to PostgreSQL: " . pg_last_error() . "\n");
    exit(3);
}

$sql = file_get_contents($file);
if ($sql === false) {
    fwrite(STDERR, "Failed to read SQL file: $file\n");
    pg_close($conn);
    exit(4);
}

// Attempt to run the entire file in one query. For many dumps this will work.
$result = @pg_query($conn, $sql);
if ($result === false) {
    // Try a safer fallback splitting by ";\n" which may handle many simple dumps.
    fwrite(STDOUT, "Initial import failed: " . pg_last_error($conn) . "\nTrying line-by-line fallback (may still fail for complex dumps)...\n");
    $parts = preg_split('/;\s*\n/', $sql);
    $failed = false;
    foreach ($parts as $i => $part) {
        $part = trim($part);
        if ($part === '') continue;
        $res = @pg_query($conn, $part);
        if ($res === false) {
            fwrite(STDERR, "Failed at chunk #" . ($i+1) . ": " . pg_last_error($conn) . "\n");
            $failed = true;
            break;
        }
    }
    if ($failed) {
        fwrite(STDERR, "Import failed. Please use the psql CLI for complex dumps.\n");
        pg_close($conn);
        exit(5);
    }
} else {
    fwrite(STDOUT, "Import completed successfully (single-query mode).\n");
}

pg_close($conn);
exit(0);
