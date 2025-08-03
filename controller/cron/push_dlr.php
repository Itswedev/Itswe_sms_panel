<?php 

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
$log_file = "/var/log/php_errors.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);

error_reporting(0);
include('/var/www/html/itswe_panel/include/connection.php');

// include("/var/www/html/itswe_panel/include/config.php");


 error_reporting(0);

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

while(true)
{
    push_dlr();
    push_dlr_avon();
    sleep(2);
}

    function push_dlr()
    {

        global $dbc;
        //$sent_sms='sent_sms';
        $sendtabledetals = "az_sendnumbers";
        
        
        $QuerySelect= "SELECT id,msg_job_id,mobile_number,`status`,unicode_type,err_code,delivered_date,send_msg,msgdata FROM $sendtabledetals WHERE status_id=0 and `status`!='Submitted' and userids=29 and schedule_sent=1 and is_picked=1 limit 100";
     
                $result = mysqli_query($dbc, $QuerySelect);
                
                 if (mysqli_num_rows($result) > 0) {
                    echo "\n\n Log started......";
                    echo "\n started at".date("Y-m-d h:i:s");
                    echo "\n";
                    
                    
                        $id=[];
                      while ($row = mysqli_fetch_array($result)) {
                            $id[]=$row['id'];
                            $mid=$row['msg_job_id'];
                            $status=$row['status'];
                            $err_code=$row['err_code'];
                            $mob_num=$row['mobile_number'];
                            $delivered_date=$row['delivered_date'];
                            $msg=$row['send_msg'];
                            $unicode_type=$row['unicode_type'];
                            if($unicode_type=='1')
                            {
                                
                                $msg=$row['msgdata'];
                                $url = 'https://api-03.moengage.com/sms/dlr/custom/1977878862';
                                //$url = 'https://api-03.moengage.com/sms/dlr/custom/3274443791';
                            }
                            else{
                                $url = 'https://api-03.moengage.com/sms/dlr/custom/1383991214';
                                //$url = 'https://api-03.moengage.com/sms/dlr/custom/2495744623';

                            }
                       
                            // The data you want to send in the JSON body
                            $data = [
                                "MID" => "$mid",
                                "StatusFlag" => "$status",
                                "status" => "$err_code",
                                "DEST" => "$mob_num",
                                "Type" => "1",
                                "SplitMsgPartNo" => "1",
                                "SplitMsgPart" => "1",
                                "message" => $msg,
                                "Reason" => "$status",
                                "Operator" => "xyz"
                            ];
                          
                            $jsonData = json_encode($data);
                            echo $jsonData;
                            // Initialize cURL
                            $ch = curl_init($url);

                            // Set the cURL options
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                                'Content-Type: application/json', // Set the content type to application/json
                                'Content-Length: ' . strlen($jsonData) // Set the content length
                            ]);

                            // Execute the request and store the response
                            $response = curl_exec($ch);

                            // Check for errors
                            if (curl_errno($ch)) {
                                $error_msg = curl_error($ch);
                                echo "cURL error: $error_msg";
                            } else {
                                // Output the response
                                echo "Response: $response";
                            }


                      }

                      $ids=implode(",",$id);
                      $sql_update="update az_sendnumbers set status_id=1 where id in ($ids)";
                      
                $result = mysqli_query($dbc, $sql_update);
                echo "\n";
                echo "ends at".date("Y-m-d h:i:s");

                    }
                    else
                    {
                        echo "\n 0 \n";
                    }
                    

        
    }


    function push_dlr_avon()
    {

        global $dbc;
        //$sent_sms='sent_sms';
        $sendtabledetals = "az_sendnumbers";
        
        
        $QuerySelect= "SELECT id,msg_job_id,mobile_number,`status`,unicode_type,err_code,delivered_date,send_msg,msgdata FROM $sendtabledetals WHERE status_id=0 and `status`!='Submitted' and userids=38 and schedule_sent=1 and is_picked=1 limit 100";
     
                $result = mysqli_query($dbc, $QuerySelect);
                
                 if (mysqli_num_rows($result) > 0) {
                    echo "\n\n Log started......";
                    echo "\n started at".date("Y-m-d h:i:s");
                    echo "\n";
                    
                    
                        $id=[];
                      while ($row = mysqli_fetch_array($result)) {
                            $id[]=$row['id'];
                            $mid=$row['msg_job_id'];
                            $status=$row['status'];
                            $err_code=$row['err_code'];
                            $mob_num=$row['mobile_number'];
                            $delivered_date=$row['delivered_date'];
                            $msg=$row['send_msg'];
                            $unicode_type=$row['unicode_type'];
                            if($unicode_type=='1')
                            {
                                
                                $msg=$row['msgdata'];
                                $url="";
                                //$url = 'https://api-03.moengage.com/sms/dlr/custom/1977878862';
                                //$url = 'https://api-03.moengage.com/sms/dlr/custom/3274443791';
                            }
                            else{
                                $url = 'https://api-03.moengage.com/sms/dlr/custom/1943144760';
                                //$url = 'https://api-03.moengage.com/sms/dlr/custom/2495744623';

                            }
                       
                            // The data you want to send in the JSON body
                            $data = [
                                "MID" => "$mid",
                                "StatusFlag" => "$status",
                                "status" => "$err_code",
                                "DEST" => "$mob_num",
                                "Type" => "1",
                                "SplitMsgPartNo" => "1",
                                "SplitMsgPart" => "1",
                                "message" => $msg,
                                "Reason" => "$status",
                                "Operator" => "xyz"
                            ];
                          
                            $jsonData = json_encode($data);
                            echo $jsonData;
                            // Initialize cURL
                            $ch = curl_init($url);

                            // Set the cURL options
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                                'Content-Type: application/json', // Set the content type to application/json
                                'Content-Length: ' . strlen($jsonData) // Set the content length
                            ]);

                            // Execute the request and store the response
                            $response = curl_exec($ch);

                            // Check for errors
                            if (curl_errno($ch)) {
                                $error_msg = curl_error($ch);
                                echo "cURL error: $error_msg";
                            } else {
                                // Output the response
                                echo "Response: $response";
                            }


                      }

                          $ids=implode(",",$id);
                          $sql_update="update az_sendnumbers set status_id=1 where id in ($ids)";
                          
                        $result = mysqli_query($dbc, $sql_update);
                        echo "\n";
                        echo "ends at".date("Y-m-d h:i:s");

                    }
                    else
                    {
                        echo "\n 0 \n";
                    }
                    

        
    }



 ?>
