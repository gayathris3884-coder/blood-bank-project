<?php
include 'conn.php';
  $donor_id = $_GET['id'];
$sql = "DELETE FROM donor_details WHERE donor_id = $1";
$result = pg_query_params($conn, $sql, array($donor_id)) or die("Query failed: " . pg_last_error());

header("Location: donor_list.php");

pg_close($conn);

 ?>
