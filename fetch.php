<?php
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
// Retrieve patient_id from allocations where device_id is 1 and status is 'assigned'
$device_id = 1; // Device ID you want to query
$status = 'assigned';

$sql_patient_id = "SELECT patient_id FROM allocation WHERE device_id = $device_id AND status = '$status'";
$result_patient_id = $conn->query($sql_patient_id);

if ($result_patient_id->num_rows > 0) {
    $row = $result_patient_id->fetch_assoc();
    echo $patient_id = $row['patient_id'];

    // Use the retrieved patient_id to get temperature values from patient_data
    $sql_temperature = "SELECT temperature, date FROM patient_data WHERE patient_id = $patient_id";
    $result_temperature = $conn->query($sql_temperature);

    $temperatureData = [];
    $timestampData = [];

    if ($result_temperature->num_rows > 0) {
        while ($row = $result_temperature->fetch_assoc()) {
            $temperatureData[] = $row['temperature'];
            $timestampData[] = $row['date'];
        }
    }

    // Now you have temperature data for the specified patient
} else {
    // Handle the case where no patient with the specified device and status was found
}


$response = [
    'temperatureData' => $temperatureData,
    'timestampData' => $timestampData
];

echo json_encode($response);

$conn->close();


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
// Retrieve patient_id from allocations where device_id is 1 and status is 'assigned'
$device_id = 1; // Device ID you want to query
$status = 'assigned';
echo$currentTime = time();

$sql_patient_id = "SELECT patient_id FROM allocation WHERE device_id = $device_id AND status = '$status'";
$result_patient_id = $conn->query($sql_patient_id);

if ($result_patient_id->num_rows > 0) {
    $row = $result_patient_id->fetch_assoc();
    $patient_id = $row['patient_id'];

    // Use the retrieved patient_id to get temperature values from patient_data
    $sql_temperature = "SELECT temperature, date FROM patient_data WHERE patient_id = $patient_id AND date >= DATE_SUB(NOW(), INTERVAL 1 HOUR) ORDER BY date";
    $result_temperature = $conn->query($sql_temperature);

    $temperatureData = [];
    $timestampData = [];

    if ($result_temperature->num_rows > 0) {
        while ($row = $result_temperature->fetch_assoc()) {
            $temperatureData[] = $row['temperature'];
            $timestampData[] = $row['date'];
        }

        // Organize temperature data into specific time intervals
        $filteredData = filterTemperatureData($temperatureData, $timestampData);

        $response = [
            'temperatureData' => $filteredData,
        ];

        echo json_encode($response);
    } else {
        // Handle the case where no temperature data was found for the specified patient
    }
} else {
    // Handle the case where no patient with the specified device and status was found
}

$conn->close();

// Filter the temperature data into specific time intervals
// Filter the temperature data into specific time intervals
function filterTemperatureData($temperatureData, $timestampData) {
    $filteredData = [
        '1 Hour Ago' => [],
        '45 Minutes Ago' => [],
        '30 Minutes Ago' => [],
        '15 Minutes Ago' => [],
        '5 Minutes Ago' => [],
        '1 Minute Ago' => [],
    ];

    $currentTime = time();

    for ($i = count($timestampData) - 1; $i >= 0; $i--) {
        $timestamp = strtotime($timestampData[$i]);

        $timeDifference = $currentTime - $timestamp;

        if ($timeDifference <= 3600) {
            $filteredData['1 Hour Ago'][] = $temperatureData[$i];
        } else {
            $filteredData['1 Hour Ago'][] = 0;
        }
        if ($timeDifference <= 2700) {
            $filteredData['45 Minutes Ago'][] = $temperatureData[$i];
        } else {
            $filteredData['45 Minutes Ago'][] = 0;
        }
        if ($timeDifference <= 1800) {
            $filteredData['30 Minutes Ago'][] = $temperatureData[$i];
        } else {
            $filteredData['30 Minutes Ago'][] = 0;
        }
        if ($timeDifference <= 900) {
            $filteredData['15 Minutes Ago'][] = $temperatureData[$i];
        } else {
            $filteredData['15 Minutes Ago'][] = 0;
        }
        if ($timeDifference <= 300) {
            $filteredData['5 Minutes Ago'][] = $temperatureData[$i];
        } else {
            $filteredData['5 Minutes Ago'][] = 0;
        }
        if ($timeDifference <= 60) {
            $filteredData['1 Minute Ago'][] = $temperatureData[$i];
        } else {
            $filteredData['1 Minute Ago'][] = 0;
        }
    }

    return $filteredData;
}

?>
