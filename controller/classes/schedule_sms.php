<?php
session_start();
$log_file = "/var/www/html/itswe_panel/error/logfiles/schedule_sms.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);

include('/var/www/html/itswe_panel/include/connection.php');
include('/var/www/html/itswe_panel/include/config.php');


$send_msg_file = "/var/www/html/itswe_panel/controller/classes/schedule_sms/".$argv[1];
$msg_id=$argv[2];
$jsonString = file_get_contents($send_msg_file);
$data = json_decode($jsonString, true);
/*print_r($data);*/
$queryInsert=$data['sent_sms_insert_query'];
$job_id=$data['job_id'];

 $sendtable = SENDSMS . CURRENTMONTH;
/*$send_sms_data=$data['send_sms_data'];*/
$sql="select * from $sendtable where job_id='$job_id'";
$result=mysqli_query($dbc,$sql);
$count_job=mysqli_num_rows($result);
if($count_job>0)
{
     $i=0;
    

        $sent_values=array_chunk($queryInsert, 25000);

        foreach($sent_values as $values1)
        {
             $insert_val=implode(",",$values1);
            
             $query_sent_sms = "INSERT INTO `send_sms` (`momt`, `sender`, `receiver`, `msgdata`, `smsc_id`,`sms_type`, `coding`, `dlr_mask`, `dlr_url`, `charset`, `boxc_id`, `udh`,`meta_data`) values $insert_val";

            $rs3 = mysqli_query($dbc, $query_sent_sms) or die(mysqli_error($dbc));
            sleep(1);
           
        }

        if($rs3>=1)
        {
            mysqli_query($dbc, "update az_sendnumbers set schedule_sent=1,status='Submitted' where msg_job_id='$msg_id'") or die(mysqli_error($dbc));

             mysqli_query($dbc, "update $sendtable set schedule_sent=1 where job_id='$msg_id'") or die(mysqli_error($dbc));


          /*   echo $result=mysqli_query($dbc, "select * from az_sendnumbers where schedule_sent=1 and message_id='$msg_id' limit 1") or die(mysqli_error($dbc));
             $count=mysqli_num_rows($result);

             if($count>0)
             {
                while($row1=mysqli_fetch_array($result))
                {
                    $record_created_dt=$row1['created_at'];
                }

                $report_yr=date("Y",strtotime($record_created_dt));
                $report_mt=date("m",strtotime($record_created_dt));
                $sendtable=SENDSMS.$report_yr.$report_mt;

                echo mysqli_query($dbc, "update $sendtable set schedule_sent=1 where id='$msg_id'") or die(mysqli_error($dbc));
             }
*/


           
        }


}
?>