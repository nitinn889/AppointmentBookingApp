<?php
header("Content-Type: application/json");

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Doctorly";  // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Database connection failed"]));
}

// Get PatientID from request
if (!isset($_GET["patientID"])) {
    echo json_encode(["success" => false, "message" => "No Patient ID provided"]);
    exit();
}

$patientID = $_GET["patientID"];

// Query to fetch medicine details along with doctor name and department
$sql = "SELECT m.DoctorID, d.DoctorName, d.Department, 
               m.Medicine, m.Dosage, m.Morning, m.Afternoon, m.Night 
        FROM newmedicine m 
        JOIN doctor d ON m.DoctorID = d.DoctorID
        WHERE m.PatientID = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $patientID);
$stmt->execute();
$result = $stmt->get_result();

$medicines = [];

while ($row = $result->fetch_assoc()) {
    $medicines[] = $row;
}

if (count($medicines) > 0) {
    echo json_encode(["success" => true, "medicines" => $medicines]);
} else {
    echo json_encode(["success" => false, "message" => "No medicines found"]);
}

$stmt->close();
$conn->close();
?>
