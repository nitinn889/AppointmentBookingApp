<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection credentials
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

// Ensure doctorID and appointmentTime are passed correctly
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['doctorID']) || !isset($_POST['appointmentTime'])) {
        die("Error: Missing doctorID or appointment time.");
    }

    // Get doctorID and appointment time from the POST request
    $doctorID = $conn->real_escape_string($_POST['doctorID']);
    $appointmentTime = $conn->real_escape_string($_POST['appointmentTime']);

    // Fetch the latest PatientID (assuming the latest patient is booking the appointment)
    $sql = "SELECT PatientID, Name, Sex, Age FROM appointment ORDER BY PatientID DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $patientData = $result->fetch_assoc();
        $patientID = $patientData['PatientID'];
        $patientName = $patientData['Name'];
        $patientSex = $patientData['Sex'];
        $patientAge = $patientData['Age'];
    } else {
        die("Error: No patient data found.");
    }

    // Fetch Doctor Name and Department using DoctorID
    $sql = "SELECT DoctorName, Department FROM Doctor WHERE DoctorID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $doctorID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $doctorData = $result->fetch_assoc();
        $doctorName = $doctorData['DoctorName'];
        $department = $doctorData['Department'];
    } else {
        die("Error: Doctor not found.");
    }

   

    // Update Appointment table with DoctorID and Time for the existing PatientID
    $updateSql = "UPDATE Appointment SET DoctordID = ?, Time = ? WHERE PatientID = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("sss", $doctorID, $appointmentTime, $patientID);

    if (!$updateStmt->execute()) {
        die("Error updating appointment: " . $conn->error);
    }

    // Close connection
    $conn->close();
} else {
    die("Error: Invalid request method.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmation</title>
    <style>
        body {
            background-color: #0f0f0f;
            font-family: Arial, sans-serif;
        }
        .container {
            width: 40%;
            margin: 100px auto;
            background-color: #1e1e1e;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: #d0d0d0;
        }
        h2 {
            text-align: center;
            color: #ffffff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #444;
        }
        th {
            background-color: #1e40af;
            color: white;
        }
        tr:hover {
            background-color: #333;
        }
        .next-button {
          margin-top: 20px;
          text-align:center;
          display:block;
      }
      .next-button a {
          display:inline-block;
          background-color:#28a745;
          color:white;
          padding:12px;
          border-radius:6px;
          text-decoration:none;
      }
      .next-button a:hover {
          background-color:#218838;
      }
    </style>
</head>
<body>
<div class="container">
    <h2>Appointment Confirmation</h2>
    <table>
        <tr><th>Detail</th><th>Information</th></tr>
        <tr><td>Patient ID</td><td><?php echo isset($patientID) ? htmlspecialchars($patientID) : "N/A"; ?></td></tr>
<tr><td>Patient Name</td><td><?php echo isset($patientName) ? htmlspecialchars($patientName) : "N/A"; ?></td></tr>
<tr><td>Sex</td><td><?php echo isset($patientSex) ? htmlspecialchars($patientSex) : "N/A"; ?></td></tr>
<tr><td>Age</td><td><?php echo isset($patientAge) ? htmlspecialchars($patientAge) : "N/A"; ?></td></tr>
<tr><td>Doctor Name</td><td><?php echo isset($doctorName) ? htmlspecialchars($doctorName) : "N/A"; ?></td></tr>
<tr><td>Department</td><td><?php echo isset($department) ? htmlspecialchars($department) : "N/A"; ?></td></tr>
<tr><td>Appointment Time</td><td><?php echo isset($appointmentTime) ? htmlspecialchars($appointmentTime) : "N/A"; ?></td></tr>

    </table>

    <div class="next-button">
       <a href="MedicineHistory.html">Next</a> <!-- Link to the next step -->
    </div>
</div>
</body>
</html>
