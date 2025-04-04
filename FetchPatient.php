<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database configuration
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

// Validate and sanitize input
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patientID = filter_input(INPUT_POST, 'patientID', FILTER_VALIDATE_INT);

    if (!$patientID) {
        echo "<p style='color:white;text-align:center;'>Invalid Patient ID. Please enter a valid integer.</p>";
        exit();
    }

    // Query appointment details
    $appointmentQuery = "SELECT Name, doctordid, Time 
                        FROM Appointment 
                        WHERE PatientID = ?";
    
    $stmt = $conn->prepare($appointmentQuery);
    $stmt->bind_param("i", $patientID); // 'i' for integer type
    $stmt->execute();
    $appointmentResult = $stmt->get_result();

    if ($appointmentResult->num_rows > 0) {
        echo '<div style="background:#0a0d14;color:#d0d0d0;padding:20px;border-radius:12px;text-align:center;width:auto;margin:auto;">
                <h3>Appointment Details</h3>';
        
        echo '<table style="margin:auto;border-collapse:collapse;width:auto;color:#d0d0d0;">
                <tr style="background-color:#4CAF50;color:white;">
                    <th style="padding:10px;">Patient Name</th>
                    <th style="padding:10px;">Appointment Time</th>
                    <th style="padding:10px;">Doctor Name</th>
                    <th style="padding:10px;">Department</th>
                </tr>';

        while ($appointmentRow = $appointmentResult->fetch_assoc()) {
            // Fetch doctor details using doctordid
            $doctorQuery = "SELECT DoctorName, Department 
                           FROM Doctor 
                           WHERE DoctorID = ?";
            
            $doctorStmt = $conn->prepare($doctorQuery);
            $doctorStmt->bind_param("s", $appointmentRow['doctordid']);
            $doctorStmt->execute();
            $doctorResult = $doctorStmt->get_result();
            
            // Handle missing doctor data gracefully
            $doctorData = $doctorResult->fetch_assoc() ?? ['DoctorName' => 'N/A', 'Department' => 'N/A'];

            echo '<tr style="text-align:center;">
                    <td style="padding:10px;">'.htmlspecialchars($appointmentRow['Name']).'</td>
                    <td style="padding:10px;">'.htmlspecialchars($appointmentRow['Time']).'</td>
                    <td style="padding:10px;">'.htmlspecialchars($doctorData['DoctorName']).'</td>
                    <td style="padding:10px;">'.htmlspecialchars($doctorData['Department']).'</td>
                  </tr>';
            
            $doctorStmt->close();
        }
        
        echo '</table></div>';
    } else {
        echo '<p style="color:white;text-align:center;">No appointments found for Patient ID '.$patientID.'</p>';
    }
    
    $stmt->close();
}
$conn->close();
?>
