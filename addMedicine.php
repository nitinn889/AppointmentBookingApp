<?php
$servername = "localhost"; // Change if needed
$username = "root";        // Change if needed
$password = "";            // Change if needed
$dbname = "Doctorly"; // Change to actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctorID = $conn->real_escape_string($_POST['doctorID']);
    $patientID = $conn->real_escape_string($_POST['patientID']);
    $medicine = $conn->real_escape_string($_POST['medicine']);
    $dosage = $conn->real_escape_string($_POST['dosage']);
    $morning = isset($_POST['morning']) ? $_POST['morning'] : 0;
    $afternoon = isset($_POST['afternoon']) ? $_POST['afternoon'] : 0;
    $night = isset($_POST['night']) ? $_POST['night'] : 0;

    $sql = "INSERT INTO newmedicine (DoctorID, PatientID, Medicine, Dosage, Morning, Afternoon, Night) 
            VALUES ('$doctorID', '$patientID', '$medicine', '$dosage', '$morning', '$afternoon', '$night')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Medicine details added successfully!');
                window.location.href = 'AddMedicine.html';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . $conn->error . "');
              </script>";
    }
}

$conn->close();
?>
