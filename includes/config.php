<?php
// Database credentials
$servername = "localhost"; // or the server name where MySQL is hosted
$username = "root"; // MySQL username
$password = ""; // MySQL password
$dbname = "travel_reimbursment"; // MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";
?>
