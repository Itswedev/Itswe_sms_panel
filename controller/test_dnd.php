<?php
session_start();
include_once('../include/connection.php');

include_once('../include/config.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

global $dbc;

$sql="select id,mobile_number from az_sendnumbers where msg_job_id='QHVMhCq3nzPK159' and status='Scheduled'";

$result=mysqli_query($dbc,$sql);

$job_id='QHVMhCq3nzPK159';
while($row=mysqli_fetch_array($result))
{
     $receiver=$row['mobile_number'];
     $momt='MT';
     $sender='FRMGRU';
     $msgdata='\u092d\u0947\u0902\u0921\u0940-\u092c\u093f\u092f\u093e\u0923\u0947 \u096a\u0966 \u0926\u093f\u0935\u0938\u093e\u092a\u093e\u0938\u0942\u0928 \u092d\u0930\u0918\u094b\u0938 \u0909\u0924\u094d\u092a\u0928\u094d\u0928- \u092b\u093e\u0930\u094d\u092e\u0917\u0941\u0930\u0942 +919021280000';
     $smsc_id='CAMPIN';
     $sms_type=2;
     $coding=2;
     $dlr_mask=19;
     $dlr_url=$row['id'];
     $charset='utf8';
     $boxc_id='sqlbox';
     $udh='0';
     $meta_data='?smpp?PEID=110200001405&TID=1107163247782961958';
    $queryInsert[]="('$momt','$sender','$receiver','$msgdata','$smsc_id',$sms_type,$coding,$dlr_mask,'$dlr_url','$charset','$boxc_id','$udh','$meta_data')";
   
}

 $array = array('sent_sms_insert_query' => $queryInsert,'job_id'=>$job_id);
        $filename="send_schedule_msg_".time().".json";
        $file_path="classes/schedule_sms/".$filename;
        $fp = fopen($file_path, 'w+');
       echo fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
        fclose($fp);


?>