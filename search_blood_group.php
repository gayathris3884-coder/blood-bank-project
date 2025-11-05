<?php

$bg = $_POST['blood'];
include 'conn.php';
$sql = "SELECT * FROM donor_details JOIN blood ON donor_details.donor_blood = blood.blood_id WHERE donor_blood = $1 ORDER BY random() LIMIT 5";
$result = pg_query_params($conn, $sql, array($bg));
if ($result === false) {
  echo '<div class="alert alert-danger">Query failed: ' . htmlspecialchars(pg_last_error($conn)) . '</div>';
} else if(pg_num_rows($result) > 0)   {
  while($row = pg_fetch_assoc($result)) {
    ?>
    <div class="row">
    <div class="col-lg-4 col-sm-6 portfolio-item" ><br>
    <div class="card" style="width:300px">
        <img class="card-img-top" src="image\blood_drop_logo.jpg" alt="Card image" style="width:100%;height:300px">
        <div class="card-body">
          <h3 class="card-title"><?php echo $row['donor_name']; ?></h3>
          <p class="card-text">
            <b>Blood Group : </b> <b><?php echo $row['blood_group']; ?></b><br>
            <b>Mobile No. : </b> <?php echo $row['donor_number']; ?><br>
            <b>Gender : </b><?php echo $row['donor_gender']; ?><br>
            <b>Age : </b> <?php echo $row['donor_age']; ?><br>
            <b>Address : </b> <?php echo $row['donor_address']; ?><br>
          </p>

        </div>
      </div>
</div>

<?php
  }
}
  else
  {

      echo '<div class="alert alert-danger">No Donor Found For your search Blood group </div>';

  } ?>
</div>
