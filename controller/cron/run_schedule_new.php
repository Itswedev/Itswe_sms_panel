<?php 
$log_file = "/var/www/html/itswe_panel/error/logfiles/run_schedule.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);


include('/var/www/html/itswe_panel/include/connection.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$send_msg_file = "/var/www/html/itswe_panel/controller/classes/scheduler.json";

$jsonString = file_get_contents($send_msg_file);
$data = json_decode($jsonString, true);
/*print_r($data);*/





if(isset($data))
{



 $count_data=count($data);
foreach($data as $d)
{
	/*$json_file[]=$d['json_file'];
*/	$php_file[]=$d['php_file'];
	$schedule_time_arr[]=$d['schedule_time'];
	$message_id[]=@$d['message_id'];
}

}
$today_dt=date("Y-m-d H:i");
/*print_r($schedule_time_arr);*/
if(isset($schedule_time_arr))
{
	for($i=0;$i<count($schedule_time_arr);$i++) {
		$schedule_check=$schedule_time_arr[$i];
		$schedule_time= date("Y-m-d H:i",strtotime($schedule_check));
		// $executable_php=$php_file[$i];
		// 	/*$executable_json=$json_file[$i];*/
		// 	$msg_id=$message_id[$i];
		// echo "php /var/www/html/itswe_panel/controller/classes/schedule_sms/$executable_php $executable_json $msg_id";
		if($schedule_time==$today_dt)
		{
			$executable_php=$php_file[$i];
			/*$executable_json=$json_file[$i];*/
			$msg_id=$message_id[$i];
			//echo "php /var/www/html/itswe_panel/controller/classes/schedule_sms/$executable_php $executable_json $msg_id > /dev/null 2>/dev/null &";
			exec("php /var/www/html/itswe_panel/controller/classes/schedule_sms/$executable_php $msg_id > /dev/null 2>/dev/null & > /var/www/html/itswe_panel/controller/classes/schedule_sms/log.txt"); 
		}
		else
		{
			echo 0;
			//echo "waiting to send sms";
		}
	}
}
