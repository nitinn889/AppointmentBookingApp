<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

// Ensure DoctorID is an integer
$doctorID = intval($_POST['doctorID']);

// Fetch DoctorName securely using prepared statements
$sql = "SELECT DoctorName FROM Doctor WHERE DoctorID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $doctorID);  // If DoctorID is still VARCHAR, use 's' (string)
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $doctorName = $row['DoctorName'];
} else {
    die("Error: Doctor not found.");
}

// Generate unique random time between 9 AM and 5 PM in HHMM format as string
$maxAttempts = 100; // Prevent infinite loop
$attempt = 0;

do {
    $hour = rand(9, 16); // 9 AM to 4 PM (last valid start hour for appointments)
    $minutes = rand(0, 59);
    $appointmentTime = sprintf("%02d%02d", $hour, $minutes); // Format as HHMM (string)

    // Check if time already exists
    $checkTimeSql = "SELECT * FROM Appointment WHERE Time = ?";
    $timeStmt = $conn->prepare($checkTimeSql);
    $timeStmt->bind_param("s", $appointmentTime);
    $timeStmt->execute();
    $checkResult = $timeStmt->get_result();

    $attempt++;
    if ($attempt > $maxAttempts) {
        die("Error: Unable to find a unique appointment time.");
    }
} while ($checkResult->num_rows > 0);

// Close the time check statement
$timeStmt->close();


// Update DoctorID and Time in the latest Appointment record
$sql = "UPDATE Appointment 
        SET DoctordID = ?, Time = ?
        WHERE PatientID = (SELECT PatientID FROM Appointment ORDER BY PatientID DESC LIMIT 1)";


$updateStmt = $conn->prepare($sql);
$updateStmt->bind_param("is", $doctorID, $appointmentTime);

if ($updateStmt->execute()) {
    // Redirect to Confirm.html with a success message
    echo "
    <script>
        alert('Your appointment has been confirmed!');
        window.location.href = 'ConfirmPage.html?doctorID=$doctorID&doctorName=" . urlencode($doctorName) . "&time=$appointmentTime';
    </script>";
    exit();
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
