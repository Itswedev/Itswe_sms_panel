<?php
session_start();
include_once('../../include/connection.php');


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
global $dbc;

$sql="select id,mobile_number from az_sendnumbers where msg_job_id='9biH1mxEthaLCof' and status='Submitted' limit 50000,10000";

$result=mysqli_query($dbc,$sql) or die(mysqli_error());

$job_id='9biH1mxEthaLCof';
while($row=mysqli_fetch_array($result))
{
    $receiver=$row['mobile_number'];
     $momt='MT'; $sender='ZNKLDN'; $msgdata='Hey! Your favourite brand Zink London is now on App. Download now & get Exclusive Deals, Daily Discounts & more.\nAndroid: bit.ly\/3JY5Gpy\nIOS: apple.co\/3rkGpOZ';
     $smsc_id='CAMPIN';
     $sms_type=2;
     $coding=0;
     $dlr_mask=19;
     $dlr_url=$row['id'];
     $charset='utf8';
     $boxc_id='sqlbox';
     $udh='0';
     $meta_data='?smpp?PEID=1001639506685348138&TID=1507165959253268359';
    $queryInsert[]="('$momt','$sender','$receiver','$msgdata','$smsc_id',$sms_type,$coding,$dlr_mask,'$dlr_url','$charset','$boxc_id','$udh','$meta_data')";
   
}
/*print_r($queryInsert);*/
 $array = array('sent_sms_insert_query' => $queryInsert,'job_id'=>$job_id);
 echo   $filename="send_schedule_msg_".time().".json";
        $file_path="schedule_sms/".$filename;
        $fp = fopen($file_path, 'w+');
        fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
        fclose($fp);


?>