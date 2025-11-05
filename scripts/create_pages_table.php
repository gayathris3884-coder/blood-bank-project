<?php
// scripts/create_pages_table.php
// Safe helper to create a minimal `pages` table and seed default rows if missing.
// Usage:
//   php .\scripts\create_pages_table.php
// It uses the project's `conn.php` to connect (RESPECT env vars or DATABASE_URL).

require_once __DIR__ . '/../conn.php'; // provides $conn (pg_connect)

if (!isset($conn) || !$conn) {
    fwrite(STDERR, "No database connection available. Check conn.php and environment variables.\n");
    exit(2);
}

// Create table if not exists
$createSql = <<<SQL
CREATE TABLE IF NOT EXISTS pages (
  page_id SERIAL PRIMARY KEY,
  page_name VARCHAR(255) NOT NULL,
  page_type VARCHAR(100) NOT NULL UNIQUE,
  page_data TEXT,
  created_at TIMESTAMP WITH TIME ZONE DEFAULT now(),
  updated_at TIMESTAMP WITH TIME ZONE DEFAULT now()
);
SQL;

$res = pg_query($conn, $createSql);
if ($res === false) {
    fwrite(STDERR, "Failed to create 'pages' table: " . pg_last_error($conn) . "\n");
    exit(3);
}

fwrite(STDOUT, "Table 'pages' exists or was created successfully.\n");

// Seed minimal rows if not present
$defaults = [
    ['About Us', 'aboutus', '<h3>About Us</h3><p>Welcome to our blood bank. This content was auto-created.</p>'],
    ['Why Donate', 'donor', '<h3>Why Donate Blood?</h3><p>Your donation saves lives.</p>'],
    ['Need for Blood', 'needforblood', '<h3>The Need for Blood</h3><p>Donors needed.</p>']
];

foreach ($defaults as $row) {
    list($name, $type, $data) = $row;
    $check = pg_query_params($conn, 'SELECT 1 FROM pages WHERE page_type = $1 LIMIT 1', array($type));
    if ($check !== false) {
        if (pg_num_rows($check) === 0) {
            $ins = pg_query_params($conn, 'INSERT INTO pages (page_name, page_type, page_data) VALUES ($1, $2, $3)', array($name, $type, $data));
            if ($ins === false) {
                fwrite(STDERR, "Failed to insert default row for type={$type}: " . pg_last_error($conn) . "\n");
            } else {
                fwrite(STDOUT, "Inserted default page: {$type}\n");
            }
        } else {
            fwrite(STDOUT, "Page already exists: {$type}\n");
        }
    } else {
        fwrite(STDERR, "Failed to check existing pages: " . pg_last_error($conn) . "\n");
    }
}

fwrite(STDOUT, "Done. If you were seeing 'relation pages does not exist' errors, reload the page now.\n");
pg_close($conn);
exit(0);
