<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "Doctorly";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch unique departments from Doctor table
$sql = "SELECT DISTINCT Department FROM Doctor";
$result = $conn->query($sql);

$departments = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $departments[] = $row;
    }
}

// Return departments as JSON
echo json_encode($departments);

$conn->close();
?>
