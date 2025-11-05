$servername = "localhost";
$username = "root";     // default XAMPP user
$password = "";         // default password
$database = "blood_donation; // updated database name
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
