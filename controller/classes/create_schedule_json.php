<?php 
	session_start();
	error_reporting(0);
	$log_file = "../error/logfiles/mis_report_controller.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);

include('../../include/connection.php');
include("../../include/config.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

global $dbc;
$job_id='3VKDuOJU2Sd8TzM';
$sql="select mobile_number,id from az_sendnumbers where msg_job_id='$job_id' and status='Scheduled' and cut_off='No' ";

$result=mysqli_query($dbc,$sql);
while($row=mysqli_fetch_array($result))
{
	$receiver=$row['mobile_number'];
	$dlr_url=$row['id'];

	$queryInsert[]="('MT','WOMOMO','$receiver','Baarish+matlab+Garma+garam+Momo%21+Try+Wow%21+Momo%27s+new+Baarish+Combo%2C+starting+at+just+Rs.+259%2F-+Tap+to+order.+bit.ly%2Fwmzmtlnk+T%26C+apply.','CAMPIN',2,0,19,'$dlr_url','utf8','sqlbox','0','?smpp?PEID=1001254135871384786&TID=1707165649360901791')";
	
}
/*echo count($queryInsert);*/

$array = array('sent_sms_insert_query' => $queryInsert,'job_id'=>$job_id);
                   echo $filename="send_schedule_msg_".time().".json";
                    $file_path="schedule_sms/".$filename;
                    $fp = fopen($file_path, 'w+');
                    fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
                    fclose($fp);

                  
                  
?>