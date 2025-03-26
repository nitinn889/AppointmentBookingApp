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

// Get form data
$patientID = $_POST['patientID'];
$name = $_POST['name'];
$age = $_POST['age'];
$sex = $_POST['sex'];
$address = $_POST['address'];

// Corrected Insert query
$sql = "INSERT INTO Appointment (PatientID, Name, sex, Age, Address) 
        VALUES ('$patientID', '$name', '$sex', '$age', '$address')";

// Execute query and redirect
if ($conn->query($sql) === TRUE) {
    header("Location: selectdoctor.html");
    exit(); // Ensure script stops execution after redirection
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
