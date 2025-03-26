<?php

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$host = "localhost";
$username = "root";  // Default XAMPP username
$password = "";      // Default XAMPP password is empty
$database = "Doctorly";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$patientid = $_POST['patientID'];  // Corrected missing semicolon
$fullname = $_POST['fullname'];
$username = $_POST['username'];
$password = $_POST['password'];

// Check if any field is empty
//if (empty($patientid) || empty($fullname) || empty($username) || empty($password)) {
   // echo "<script>alert('All fields are required!'); window.location.href='signup.html';</script>";
    //exit();
//}

// Check if username already exists
$sql_check = "SELECT * FROM PatientDetails WHERE Username='$username'";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
    echo "<script>alert('Username already exists. Please choose a different one.'); window.location.href='signup.html';</script>";
    exit();
}

// Insert data into the database
$sql = "INSERT INTO PatientDetails (PatientID, FullName, Username, Password) VALUES ('$patientid', '$fullname', '$username', '$password')";

// Check if the query was successful
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Signup successful! Redirecting to login page.'); window.location.href='LoginPage.html';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
