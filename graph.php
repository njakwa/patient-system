<?php   include ('connection.php'); 

$device_id = 1; // Device ID you want to query
$status = 'assigned';
                                      $sql_patient_id = "SELECT patient_id FROM allocation WHERE device_id = $device_id AND status = '$status'";
                                      $result_patient_id = $conn->query($sql_patient_id);

                                      $get_row=mysqli_fetch_assoc($result_patient_id);
                                       echo $get_row['patient_id'];

                                       





?>



