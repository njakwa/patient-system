<?php
// Database connection setup (assuming you already have a connection established)

include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the form
    $patientId = $_POST["patient"];
    $date = $_POST["date"];
    $startTime = $_POST["start_time"];
    $endTime = $_POST["end_time"];

    // Prepare the SQL query to retrieve temperature data
    $sql = "SELECT temperature, DATE_FORMAT(date, '%h:%i %p') AS formatted_date
            FROM patient_data
            WHERE patient_id = ?
            AND DATE_FORMAT(date, '%Y-%m-%d') = ?
            AND DATE_FORMAT(date, '%H:%i') >= ?
            AND DATE_FORMAT(date, '%H:%i') <= ?";

    // Prepare and bind the parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $patientId, $date, $startTime, $endTime);
    $stmt->execute();
    $result = $stmt->get_result();

    // Display the report
    echo "<h2>Temperature Report for Patient ID: $patientId</h2>";
    echo "<p>Date: $date, Time Interval: $startTime - $endTime</p>";
    echo "<table border='1'>";
    echo "<tr><th>Time</th><th>Temperature</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['formatted_date'] . "</td>";
        echo "<td>" . $row['temperature'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    // Handle the case where the form has not been submitted
    echo "Form not submitted.";
}

// Close the database connection (if necessary)
$conn->close();
?>
