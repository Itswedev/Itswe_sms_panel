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


/*$send_msg_file = "/var/www/html/itswe_panel/controller/classes/schedule_sms/".$argv[1];*/
$msg_id=$argv[1];
/*$jsonString = file_get_contents($send_msg_file);
$data = json_decode($jsonString, true);
/*print_r($data);
$queryInsert=$data['sent_sms_insert_query'];*/
//$job_id=$data['job_id'];

 $sendtable = SENDSMS . CURRENTMONTH;
  $sendtabledetals = SENDSMSDETAILS ;
/*$send_sms_data=$data['send_sms_data'];*/
$sql="select id from $sendtable where job_id='$msg_id'";
$result=mysqli_query($dbc,$sql);
$count_job=mysqli_num_rows($result);
if($count_job>0)
{
        $i=0;
        $sql_master="select id,senderid,mobile_number,send_msg,service_id,unicode_type,metadata from $sendtabledetals where msg_job_id='$msg_id' and is_scheduled=1 and schedule_sent=0 and status='Scheduled' and cut_off='No'";

        $result_master=mysqli_query($dbc,$sql_master);
        $count_job_master=mysqli_num_rows($result_master);

        if($count_job_master>0)
        {
            $queryInsert=array();
             $momt='MT';
                $sms_type='2';
                $dlr_mask='19';
                $charset='utf8';
                $boxc_id='sqlbox';
                $udh=0;
            while($row_master=mysqli_fetch_array($result_master))
            {

                $dlr_url=$row_master['id'];
                $sender=$row_master['senderid'];
                $receiver=$row_master['mobile_number'];
                $msgdata=$row_master['send_msg'];
                $smsc_id=$row_master['service_id'];
                 $meta_data=$row_master['metadata'];
                $char_set=$row_master['unicode_type'];
                if($char_set==0)
                {
                    $coding=0;

                }
                else if($char_set==1)
                {
                    $coding=2;
                }

            $queryInsert[]="('$momt','$sender','$receiver','$msgdata','$smsc_id',$sms_type,$coding,$dlr_mask,'$dlr_url','$charset','$boxc_id','$udh','$meta_data')";
               
            }


            $sent_values=array_chunk($queryInsert, 2000);

            foreach($sent_values as $values1)
            {
                 $insert_val=implode(",",$values1);
                
                 $query_sent_sms = "INSERT INTO `send_sms` (`momt`, `sender`, `receiver`, `msgdata`, `smsc_id`,`sms_type`, `coding`, `dlr_mask`, `dlr_url`, `charset`, `boxc_id`, `udh`,`meta_data`) values $insert_val";

                $rs3 = mysqli_query($dbc, $query_sent_sms) or die(mysqli_error($dbc));
                sleep(1);
               
            }

            if($rs3>=1)
            {
                mysqli_query($dbc, "update $sendtabledetals set schedule_sent=1,status='Submitted',is_picked=1 where msg_job_id='$msg_id'") or die(mysqli_error($dbc));

                 mysqli_query($dbc, "update $sendtable set schedule_sent=1,is_picked=1 where job_id='$msg_id'") or die(mysqli_error($dbc));


               
            }

        }
       

}
?>