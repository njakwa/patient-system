

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

    // Create a connection to the database
    $conn = new mysqli($servername, $username, $password, $database);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert the temperature value into the patient_data table
    $sql = "INSERT INTO patient_data (temperature) VALUES ('$temperature')";

    if ($conn->query($sql) === TRUE) {
        echo "Temperature data inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    echo "No temperature data received";
}

?>
