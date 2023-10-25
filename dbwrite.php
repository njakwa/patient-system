

<?php



//     $host = "localhost";		         // host = localhost because database hosted on the same server where PHP files are hosted
//     $dbname = "firstdb";              // Database name
//     $username = "yash";		// Database username
//     $password = "India@Yash123";	        // Database password


// // Establish connection to MySQL database
// $conn = new mysqli($host, $username, $password, $dbname);


// // Check if connection established successfully
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// else { echo "Connected to mysql database. "; }

   
// // Get date and time variables
//     date_default_timezone_set('Asia/Kolkata');  
//     $d = date("Y-m-d");
//     $t = date("H:i:s");
    
// // If values send by NodeMCU are not empty then insert into MySQL database table

//   if(!empty($_POST['sendval']) && !empty($_POST['sendval2']) )
//     {
// 		$val = $_POST['sendval'];
//                 $val2 = $_POST['sendval2'];


// // Update your tablename here
// 	        $sql = "INSERT INTO nodemcu_table (val, val2, Date, Time) VALUES ('".$val."','".$val2."', '".$d."', '".$t."')"; 
 


// 		if ($conn->query($sql) === TRUE) {
// 		    echo "Values inserted in MySQL database table.";
// 		} else {
// 		    echo "Error: " . $sql . "<br>" . $conn->error;
// 		}
// 	}


// // Close MySQL connection
// $conn->close();


$servername = "localhost";
$username = "root";
$password = "";
$database = "patient";

// Get the temperature value from the POST request
if (isset($_POST['temperature'])) {
    $temperature = $_POST['temperature'];
    $deviceName = "ThermistorDevice1";

    // Create a connection to the database
    $conn = new mysqli($servername, $username, $password, $database);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $get_device_id = mysqli_query($conn, "SELECT device_id FROM devices WHERE device_name='$deviceName'");
    $row = mysqli_fetch_assoc($get_device_id);
    $dId = $row['device_id'];

    $getPatientId = mysqli_query($conn, "SELECT patient_id FROM allocation  WHERE device_id ='$dId' AND status= 'assigned'");
    $rowId = mysqli_fetch_assoc($getPatientId);
    $patientId = $rowId['patient_id'];

    // Check if the new temperature is different from the last recorded temperature for the patient
    $lastTemperatureQuery = mysqli_query($conn, "SELECT temperature FROM patient_data WHERE patient_id = '$patientId' ORDER BY date DESC LIMIT 1");
    $lastTemperatureRow = mysqli_fetch_assoc($lastTemperatureQuery);
    $lastTemperature = $lastTemperatureRow['temperature'];

    if ($lastTemperature != $temperature) {
        // Insert the new temperature value
        $sql = "INSERT INTO patient_data (temperature, patient_id, date) VALUES ('$temperature','$patientId', CURRENT_TIMESTAMP)";

        if ($conn->query($sql) === TRUE) {
            echo "Temperature data inserted successfully";
            echo $patientId;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Duplicate temperature, not inserted.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "No temperature data received";
}


// Get the temperature value from the POST request
// if (isset($_POST['temperature'])) {
//     $temperature = $_POST['temperature'];

//     $deviceName="ThermistorDevice1";


//     // Create a connection to the database
//     $conn = new mysqli($servername, $username, $password, $database);

//     // Check the connection
//     if ($conn->connect_error) {
//         die("Connection failed: " . $conn->connect_error);
//     }

//     $get_device_id= mysqli_query($conn,"SELECT device_id FROM devices WHERE device_name='$deviceName'");
//     $row=mysqli_fetch_assoc($get_device_id);
//     $dId=$row['device_id'];

//     $getPatientId=mysqli_query($conn,"SELECT patient_id FROM allocation  WHERE device_id ='$dId' AND status= 'assigned'");
//     $rowId=mysqli_fetch_assoc($getPatientId);
//     $patientId=$rowId['patient_id'];


//     $patientId;



    


    
//     $sql = "INSERT INTO patient_data (temperature,patient_id,date) VALUES ('$temperature','$patientId',CURRENT_TIMESTAMP)";

//     if ($conn->query($sql) === TRUE) {
//         echo "Temperature data inserted successfully";
       
//     } else {
//         echo "Error: " . $sql . "<br>" . $conn->error;
//     }

//     // Close the database connection
//     $conn->close();
// } else {
//     echo "No temperature data received";
// }
?>





