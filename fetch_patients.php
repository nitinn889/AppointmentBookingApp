<?php
header("Content-Type: application/json");

$servername = "localhost"; // Change if necessary
$username = "root";        // Change if necessary
$password = "";            // Change if necessary
$dbname = "Doctorly"; // Change to your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

if (isset($_GET['doctorID'])) {
    $doctorID = $conn->real_escape_string($_GET['doctorID']);

    $sql = "SELECT PatientID, Name, sex, Age, Address, Time FROM appointment WHERE DoctordID = '$doctorID'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $patients = [];
        while ($row = $result->fetch_assoc()) {
            $patients[] = $row;
        }
        echo json_encode(["success" => true, "patients" => $patients]);
    } else {
        echo json_encode(["success" => false, "message" => "No patients found."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Doctor ID not provided."]);
}

$conn->close();
?>
