<?php
$conn = pg_connect("host=dpg-d45of3ruibrs73fan6h0-a port=5432 dbname=bdms user=bdmsuser password=PCbF8Ybzrq04GIWz7c9UXyOf6KekAaKe sslmode=require");

$sql = "
CREATE TABLE pages (
    id SERIAL PRIMARY KEY,
    page_type VARCHAR(255) NOT NULL,
    page_data TEXT
);
CREATE TABLE blood (
    blood_id SERIAL PRIMARY KEY,
    blood_group VARCHAR(10) NOT NULL
);
CREATE TABLE donor_details (
    donor_id SERIAL PRIMARY KEY,
    donor_name VARCHAR(255) NOT NULL,
    donor_blood INT REFERENCES blood(blood_id),
    donor_number VARCHAR(20),
    donor_gender VARCHAR(10),
    donor_age INT,
    donor_address TEXT
);
";

pg_query($conn, $sql) or die("Error creating tables: " . pg_last_error());

echo "Tables created successfully!";
?>
