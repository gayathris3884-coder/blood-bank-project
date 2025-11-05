
<?php
$name = $_POST['fullname'];
$number = $_POST['mobileno'];
$email = $_POST['emailid'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$blood_group = $_POST['blood'];
$address = $_POST['address'];
include 'conn.php';
$sql = "INSERT INTO donor_details(donor_name, donor_number, donor_mail, donor_age, donor_gender, donor_blood, donor_address) VALUES ($1, $2, $3, $4, $5, $6, $7)";
$result = pg_query_params($conn, $sql, array($name, $number, $email, $age, $gender, $blood_group, $address));
if ($result === false) {
	die("Insert failed: " . pg_last_error($conn));
}
header("Location: http://localhost/BDMS/admin/donor_list.php");

pg_close($conn);
 ?>
