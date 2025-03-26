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

// Get selected DoctorID securely from the form and explicitly cast as integer
$doctorID = (int) $_POST['doctorID'];

// Check if DoctorID is a valid positive integer
if ($doctorID <= 0) {
    die("Error: Invalid DoctorID.");
}

// Fetch DoctorName using a prepared statement
$sql = "SELECT DoctorName FROM Doctor WHERE DoctorID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $doctorID);
$stmt->execute();
$result = $stmt->get_result();
$doctorName = "";

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $doctorName = $row['DoctorName'];
} else {
    die("Error: Doctor not found.");
}

// Set time as "1130" (11:30 AM) in string format for testing
$appointmentTime = "1130";

// Get the latest PatientID where DoctorID or Time is NULL
$sql = "SELECT PatientID FROM Appointment WHERE DoctorID IS NULL OR Time IS NULL ORDER BY PatientID DESC LIMIT 1";
$patientResult = $conn->query($sql);

if ($patientResult->num_rows > 0) {
    $row = $patientResult->fetch_assoc();
    $patientID = $row['PatientID'];

    // Update DoctorID and Time in the latest Appointment record
    $updateSql = "UPDATE Appointment 
                  SET DoctorID = ?, Time = ?
                  WHERE PatientID = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("isi", $doctorID, $appointmentTime, $patientID);

    if ($updateStmt->execute()) {
        // Redirect to Confirm.html with a success message using JavaScript
        echo "
        <script>
            alert('Your appointment has been confirmed with a test time of 11:30 AM!');
            window.location.href = 'Confirm.html?doctorID=$doctorID&doctorName=" . urlencode($doctorName) . "&time=$appointmentTime';
        </script>";
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "Error: No patient found to update.";
}

$conn->close();
?>
