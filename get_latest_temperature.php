<?php
// Define your database connection credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "patient";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get the latest temperature record
$sql = "SELECT temperature FROM patient_data ORDER BY date DESC LIMIT 1";
$result = $conn->query($sql);

$latestTemperature = "N/A"; // Default value if no records are found

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $latestTemperature = $row["temperature"];
}

// Close the database connection
$conn->close();

echo $latestTemperature;
?>