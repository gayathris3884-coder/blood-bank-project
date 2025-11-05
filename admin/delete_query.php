<?php
include 'conn.php';

  $que_id = $_GET['id'];
 $sql = "DELETE FROM contact_query WHERE query_id = $1";
 $result = pg_query_params($conn, $sql, array($que_id)) or die("Query failed: " . pg_last_error());
 pg_close($conn);

 ?>
