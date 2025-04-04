<?php
// Database Connection
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'Doctorly';

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// Get Patient ID from the AJAX request
$patientID = isset($_POST['patientID']) ? $_POST['patientID'] : '';

$response = [];

if (!empty($patientID)) {
    // Prepare the SQL query to fetch data
    $query = "SELECT PatientID, Medicine, Dosage, Time FROM Medicine WHERE PatientID = ?";

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $patientID);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if data is found
    if ($result->num_rows > 0) {
        $records = [];
        while ($row = $result->fetch_assoc()) {
            $records[] = [
                'PatientID' => $row['PatientID'],
                'Medicine'  => $row['Medicine'],
                'Dosage'    => $row['Dosage'],
                'Time'      => $row['Time']
            ];
        }
        // Return success and records
        $response = ['success' => true, 'records' => $records];
    } else {
        // No records found
        $response = ['success' => false, 'message' => 'No records found for Patient ID: ' . htmlspecialchars($patientID)];
    }

    // Close the statement
    $stmt->close();
} else {
    // Invalid or empty Patient ID
    $response = ['success' => false, 'message' => 'Please enter a valid Patient ID.'];
}

// Close connection
$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
