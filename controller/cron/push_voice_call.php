<?php
session_start();
$log_file = "/var/log/php_errors.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);

include('/var/www/html/itswe_panel/include/connection.php');
include('/var/www/html/itswe_panel/include/config.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
global $dbc;
$send_msg_file = "/var/www/html/itswe_panel/controller/classes/sent_call/".$argv[1];

$jsonString = file_get_contents($send_msg_file);
$data = json_decode($jsonString, true);

/*$query_data=$data['query_data'];*/
$msg_job_id=$data['msg_job_id'];
$call_send=$data['call_send'];
$multimedia_id=$data['multimedia_id'];
$retryatmpt=$data['retry_attempt'];
$caller_id=$data['caller_id'];
$vsms=$data['vsms'];
$userid=$data['userid'];
$parent_id=$data['parent_id'];
$file_name=$data['file_name'];
$msg_id=$data['msg_id'];
$call_method=$data['call_method'];
$wait_duration=$data['wait_duration'];
$msgcredit=$data['msgcredit'];
$retryduration=$data['retry_duration'];
$end_point=$data['end_point'];
$gateway_name=$data['gateway_name'];
$sendtable = SENDCALL . CURRENTMONTH;
$sendtabledetals = SENDCALLDETAILS ;


 $serviceno="4473955";
 $sql_multimedia="select original_filename,get_response,sender_id,template_id,voice_id,ivr_id from `multimedia` where id='$multimedia_id'";

        $result=mysqli_query($dbc,$sql_multimedia);
        while($row=mysqli_fetch_array($result))
        {   
         
            $voice_file=$row['original_filename'];
            $voice_id=$row['voice_id'];
             $ivr_id=$row['ivr_id'];
            $parts = explode('.', $voice_file);
            $filename=$parts[0];
            $voice_file = $filename.".wav";

            $get_response=$row['original_filename'];
            $sender_id=$row['sender_id'];
            $template_id=$row['template_id'];
     
        }

         $username="sr1261";
                $token="hu9kWO";
                $announcement_id=$voice_id;
                $plan_id="24597";
                $caller_id="91";
                $ivr_id=$ivr_id;
                $i=0;
          foreach($call_send as $mob_num)
          {
          	$mob_num="0".$mob_num;
          	$master_job_id=random_strings(20);
          	$status='Submitted';
            $route='VOICE';
            $schedule_sent='1';
            $str[]='(NULL, NOW(),"'.$msgcredit.'","'.$userid.'","'.$status.'","'.$route.'","'.$msg_job_id.'","'.$schedule_sent.'","'.$parent_id.'",NOW(),"No","'.$master_job_id.'","'.$multimedia_id.'","'.$file_name.'","'.$serviceno.'","'.$msg_id.'","'.$vsms.'","'.$retryduration.'","'.$mob_num.'","'.$call_method.'")';
          	$i++;

          }

           $query_data = array_chunk($str, 5000);

           foreach($query_data as $values) {    
            $insert_val=implode(",",$values);           
             $query_master_tbl_insert= "INSERT INTO voice_call (`id`, `created_dt`, `msgcredit`, `userid`, `status`, `route`,`msg_job_id`,`schedule_sent`,`parent_id`,`sent_at`,`cut_off`,`master_job_id`,`multimedia_id`,`file_name`,`caller_id`,`message_id`,`vsms`,`retry_duration`,`mobile_number`,`method`) VALUES $insert_val";
          

            $rs1 = mysqli_query($dbc, $query_master_tbl_insert) or die(mysqli_error($dbc));
            unset($insert_val);
           // sleep(1);          
        }

          echo $i;


        function random_strings($length_of_string)
        {
         
            // String of all alphanumeric character
            $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
         
            // Shuffle the $str_result and returns substring
            // of specified length
            return substr(str_shuffle($str_result),
                               0, $length_of_string);
        }
 			


?>