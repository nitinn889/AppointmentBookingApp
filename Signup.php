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
$patientid = $_POST['patientID'];
$fullname = $_POST['fullname'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];  // ❌ Plain text password (Not recommended)

// Check if username or email already exists
$sql_check = "SELECT * FROM Patient WHERE Username = ? OR EmailID = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ss", $username, $email);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    echo "<script>alert('Username or Email already exists. Please choose a different one.'); window.location.href='signup.html';</script>";
    exit();
}

// Insert data into the database using prepared statement (storing plain password)
$sql = "INSERT INTO Patient (PatientID, FullName, EmailID, Username, Password) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issss", $patientid, $fullname, $email, $username, $password);

if ($stmt->execute()) {
    echo "<script>alert('Signup successful! Redirecting to login page.'); window.location.href='LoginPage.html';</script>";
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$stmt_check->close();
$conn->close();

?>
