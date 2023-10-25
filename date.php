<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "patient";

// Get the temperature value from the POST request

    $temperature = 78;

    // Create a connection to the database
    $conn = new mysqli($servername, $username, $password, $database);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $update_query=$conn->query("UPDATE temp_data SET temp='$temperature'    WHERE id='1' ");

    if($update_query){
        echo "done";
    }
    else {
        echo "eror";
    }



?>