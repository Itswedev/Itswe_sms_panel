<?php 
$log_file = "/var/www/html/itswe_panel/error/logfiles/run_schedule.log";
 
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

$today_dt=date("Y-m-d");
$sendtable = SENDSMS . CURRENTMONTH;
$select_schedule="select job_id,sent_at from $sendtable where is_scheduled=1 and schedule_sent=0 and date(sent_at)='".$today_dt."'";
$result_schedule=mysqli_query($dbc,$select_schedule);


$count_schedule=mysqli_num_rows($result_schedule);

if($count_schedule>0)
{
    while($row_schedule=mysqli_fetch_array($result_schedule))
    {
        $data['schedule_time'][]=$row_schedule['sent_at'];
        $data['message_id'][]=$row_schedule['job_id'];
    }
}

if(isset($data['schedule_time']))
{
  $today_dt=date("Y-m-d H:i");
  $count_data=count($data['schedule_time']);
  $schedule_time_arr=$data['schedule_time'];
  $message_id=$data['message_id'];

  if($count_data>0)
  {
    for($i=0;$i<count($schedule_time_arr);$i++) {
        $schedule_check=$schedule_time_arr[$i];
		$schedule_time= date("Y-m-d H:i",strtotime($schedule_check));
		
		if($schedule_time==$today_dt)
		{

            echo "time comparison";
			$executable_php="run_schedule_sms.php";
			echo $msg_id=$message_id[$i];
            echo "\n";
			//echo "php /var/www/html/itswe_panel/controller/classes/schedule_sms/$executable_php $executable_json $msg_id > /dev/null 2>/dev/null &";
			exec("php /var/www/html/itswe_panel/controller/classes/$executable_php $msg_id > /dev/null 2>/dev/null & > /var/www/html/itswe_panel/controller/classes/schedule_sms/log.txt"); 
		}
		else
		{
			//echo 0;
			
		}

    }
  }




}