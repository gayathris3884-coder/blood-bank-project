<?php
include 'conn.php';

$sql = "SHOW TABLES";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Connected! Tables in database:<br>";
    while($row = $result->fetch_assoc()) {
        echo $row["Tables_in_railway"] . "<br>";
    }
} else {
    echo "No tables found or connection failed.";
}
?>
