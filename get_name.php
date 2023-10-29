<?php   include ('connection.php'); 

$device_id = 1; // Device ID you want to query
$status = 'assigned';

                                       

                                    $sql = "SELECT p.first_name, p.last_name 
                                    FROM allocation AS a
                                    JOIN patient AS p ON a.patient_id = p.patient_id
                                    WHERE a.device_id = ? AND a.status = ?";
                            
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("is", $device_id, $status);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $full_name = $row['first_name'] . " " . $row['last_name'];
                                echo $full_name;
                            } else {
                                echo "Patient not found";

                            }
                            



?>



