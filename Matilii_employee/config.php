<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = ""; // default password for XAMPP
$dbname = "employee_time_tracking"; // make sure the database name is correct

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
