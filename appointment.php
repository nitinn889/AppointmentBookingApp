<?php
// Database connection
$servername = "localhost";
$username = "root";  // Change if using a different username
$password = "";      // Change if you have a database password
$dbname = "Doctorly"; // Database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user input
$doctorID = $_POST['doctorID'];
$appointmentTime = $_POST['appointmentTime'];

// Check if the doctor has an appointment at the given time
$sql = "SELECT * FROM Appointment WHERE DoctordID = ? AND Time = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $doctorID, $appointmentTime);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Slot is occupied, show alert
    echo "<script>
            alert('Slot occupied! Please choose a different time.');
            window.history.back();
          </script>";
} else {
    // Slot is available, stay on the same page
    echo "<script>
            alert('Slot available! You may proceed with the booking.');
            window.history.back();
          </script>";
}

// Close the database connection
$stmt->close();
$conn->close();
?>
