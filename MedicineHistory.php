<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database credentials
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

// Get form data securely
$patientID = isset($_POST['patientID']) ? $conn->real_escape_string($_POST['patientID']) : die("Error: Patient ID missing.");
$medicine = isset($_POST['medicine']) ? $conn->real_escape_string($_POST['medicine']) : die("Error: Medicine missing.");
$dosage = isset($_POST['dosage']) ? intval($_POST['dosage']) : die("Error: Dosage missing.");
$morning = isset($_POST['morning']) ? $_POST['morning'] : "0";
$afternoon = isset($_POST['afternoon']) ? $_POST['afternoon'] : "0";
$night = isset($_POST['night']) ? $_POST['night'] : "0";

// Generate time format like 1-0-1
$time = $morning . "-" . $afternoon . "-" . $night;

// Insert data into Medicine table
$sql = "INSERT INTO Medicine (PatientID, Medicine, Dosage, Time) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isss", $patientID, $medicine, $dosage, $time);

if ($stmt->execute()) {
    echo "
    <script>
        alert('Prescription added successfully!');
        window.location.href = 'MedicineHistory.html?patientID=$patientID';
    </script>";
} else {
    echo "<script>alert('Error: " . $conn->error . "');</script>";
}

// Close connection
$stmt->close();
$conn->close();
?>
