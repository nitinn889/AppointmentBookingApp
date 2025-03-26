<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background-color: #0f0f0f;
            font-family: Arial, sans-serif;
            color: #d0d0d0;
            text-align: center;
            margin-top: 100px;
        }
        .container {
            width: 60%;
            margin: auto;
            background-color: #1e1e1e;
            padding: 20px;
            border-radius: 8px;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            border: 1px solid #444;
        }
        th {
            background-color: #1e40af;
            color: #fff;
        }
        td {
            background-color: #333;
        }
        button {
            margin-top: 20px;
            padding: 12px 20px;
            font-size: 16px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Appointment Confirmation</h2>

    <?php
    // Database connection
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

    // Get latest appointment details
    $sql = "SELECT A.PatientID, D.Doctordid, D.DoctorName, D.Department, A.Time 
            FROM Appointment A 
            JOIN Doctor D ON A.Doctordid = D.Doctordid
            ORDER BY A.PatientID DESC 
            LIMIT 1";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $appointmentData = $result->fetch_assoc();
    } else {
        die("No appointment data found.");
    }

    $conn->close();
    ?>

    <!-- Displaying appointment details -->
    <table>
        <tr>
            <th>Doctor ID</th>
            <th>Doctor Name</th>
            <th>Department</th>
            <th>Appointment Time</th>
        </tr>
        <tr>
            <!-- Corrected the keys here -->
            <td><?php echo $appointmentData['Doctordid']; ?></td>
            <td><?php echo $appointmentData['DoctorName']; ?></td>
            <td><?php echo $appointmentData['Department']; ?></td>
            <td><?php echo $appointmentData['Time']; ?></td>
        </tr>
    </table>

    <!-- Confirm button redirects to home page -->
    <form action="Homepage.html" method="GET">
        <button type="submit">Confirm</button>
    </form>
</div>

</body>
</html>
