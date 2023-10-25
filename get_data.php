<?php
// Connect to your database (replace with your actual database connection code)
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "patient";

// $conn = new mysqli($servername, $username, $password, $dbname);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// // Define the time range (adjust as needed)
// $timeIntervals = array(
//     "1 hour" => 3600,        // 1 hour in seconds
//     "45 minutes" => 2700,   // 45 minutes in seconds
//     "30 minutes" => 1800,   // 30 minutes in seconds
//     "15 minutes" => 900,    // 15 minutes in seconds
//     "5 minutes" => 300,     // 5 minutes in seconds
//     "1 minute" => 60        // 1 minute in seconds
// );

// $temperatureData = array();
// $timestampData = array();

// foreach ($timeIntervals as $intervalName => $intervalSeconds) {
//     // Calculate the start time
//     $startTime = date("H:i:s", strtotime("-$intervalName"));

//     // Fetch temperature data and timestamps within the time range
//     $sql = "SELECT temperature, TIME(date) as timestamp_time FROM patient_data WHERE TIME(date) >= '$startTime' ORDER BY date DESC LIMIT 1";
//     $result = $conn->query($sql);

//     if ($result->num_rows > 0) {
//         while ($row = $result->fetch_assoc()) {
//             $temperatureData[] = $row["temperature"];
//             $timestampData[] = $row["timestamp_time"]; // Store time only
//         }
//     }
// }

// $conn->close();

// // Create an array with the data
// $data = array(
//     'temperatureData' => $temperatureData,
//     'timestampData' => $timestampData
// );

// // Send the data as JSON
// header('Content-Type: application/json');
// echo json_encode($data);


// Connect to your database (replace with your actual database connection code)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "patient";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define time intervals
$timeIntervals = array(
    "1 hour" => 3600,        // 1 hour in seconds
    "45 minutes" => 2700,   // 45 minutes in seconds
    "30 minutes" => 1800,   // 30 minutes in seconds
    "15 minutes" => 900,    // 15 minutes in seconds
    "5 minutes" => 300,     // 5 minutes in seconds
    "1 minute" => 60        // 1 minute in seconds
);

$temperatureData = array();
$timestampData = array();

foreach ($timeIntervals as $intervalName => $intervalSeconds) {
    // Calculate the start time for the interval
    $startTime = date("Y-m-d H:i:s", strtotime("-$intervalName"));

    // Calculate the end time as the current time
    $endTime = date("Y-m-d H:i:s");

    // Fetch temperature data and timestamps within the time range
    $sql = "SELECT temperature, date, id FROM patient_data WHERE date >= '$startTime' AND date <= '$endTime' ORDER BY date DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $temperatureData[] = $row["temperature"];
            $timestampData[] = $row["date"] . " (ID: " . $row["id"] . ")";
        }
    }
}

$conn->close();

// Create an array with the data
$data = array(
    'temperatureData' => $temperatureData,
    'timestampData' => $timestampData
);

// Send the data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
