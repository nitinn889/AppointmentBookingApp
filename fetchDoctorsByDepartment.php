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

// Get department from query parameter
$department = $_GET['department'];

// Fetch doctors from selected department
$sql = "SELECT DoctorID, DoctorName FROM Doctor WHERE Department='$department'";
$result = $conn->query($sql);

$doctors = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $doctors[] = $row;
    }
}

// Return doctors as JSON
echo json_encode($doctors);

$conn->close();
?>
