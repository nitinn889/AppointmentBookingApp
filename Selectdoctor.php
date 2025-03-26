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

// Fetch doctors from Doctor table
$sql = "SELECT DoctorID, DoctorName, Department FROM Doctor";
$result = $conn->query($sql);

$doctors = array();

if ($result->num_rows > 0) {
    // Fetch each row as an associative array
    while ($row = $result->fetch_assoc()) {
        $doctors[] = $row;
    }
}

// Return doctors as JSON
echo json_encode($doctors);

$conn->close();
?>
