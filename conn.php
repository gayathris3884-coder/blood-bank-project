<?php
$servername = "db"; // Docker service name if using docker-compose
$username = "bdmsuser";
$password = "bdms123";
$dbname = "bdms";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
