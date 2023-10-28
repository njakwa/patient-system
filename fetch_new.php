<?php
// $host = "localhost";
// $username = "root";
// $password = "";
// $database = "patient";

// $conn = new mysqli($host, $username, $password, $database);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// // Fetch temperature data for active patients and devices within the last 1 hour
// // Adjust the SQL query to match your database schema
// $device_id = 1; // Device ID you want to query
// $status = 'assigned';

// $sql_patient_id = "SELECT patient_id FROM allocation WHERE device_id = $device_id AND status = '$status'";
// $result_patient_id = $conn->query($sql_patient_id);

// if ($result_patient_id->num_rows > 0) {
//     $row = $result_patient_id->fetch_assoc();
//     $patient_id = $row['patient_id'];

//     $sql_temperature = "SELECT temperature, date FROM patient_data WHERE patient_id = $patient_id";
//     $result_temperature = $conn->query($sql_temperature);

//     $temperatureData = [];
//     $timestampData = [];

//     if ($result_temperature->num_rows > 0) {
//         while ($row = $result_temperature->fetch_assoc()) {
//             $temperatureData[] = $row['temperature'];
//             $timestampData[] = $row['date'];
//         }
//     }

//     $response = [
//         'temperatureData' => $temperatureData,
//         'timestampData' => $timestampData
//     ];

//     echo json_encode($response);
// } else {
//     // Handle the case where no patient with the specified device and status was found
// }

// $conn->close();

$host = "localhost";
$username = "root";
$password = "";
$database = "patient";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch temperature data for active patients and devices within the last 1 hour
// Adjust the SQL query to match your database schema
$device_id = 1; // Device ID you want to query
$status = 'assigned';

$sql_patient_id = "SELECT patient_id FROM allocation WHERE device_id = $device_id AND status = '$status'";
$result_patient_id = $conn->query($sql_patient_id);

if ($result_patient_id->num_rows > 0) {
    $row = $result_patient_id->fetch_assoc();
    $patient_id = $row['patient_id'];

    // Modify the SQL query to retrieve temperature data for the last hour
    $oneHourAgo = date('Y-m-d H:i:s', strtotime('-1 hour'));
    $sql_temperature = "SELECT temperature, date FROM patient_data WHERE patient_id = $patient_id AND date >= '$oneHourAgo'";
    
    $result_temperature = $conn->query($sql_temperature);

    $temperatureData = [];
    $timestampData = [];

    if ($result_temperature->num_rows > 0) {
        while ($row = $result_temperature->fetch_assoc()) {
            $temperatureData[] = $row['temperature'];
            $timestampData[] = $row['date'];
        }
    }

    $response = [
        'temperatureData' => $temperatureData,
        'timestampData' => $timestampData
    ];

    echo json_encode($response);
} else {
    // Handle the case where no patient with the specified device and status was found
}

$conn->close();


?>
