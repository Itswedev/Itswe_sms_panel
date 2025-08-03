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
$send_msg_file = "/var/www/html/itswe_panel/controller/rnd/".$argv[1];

$jsonString = file_get_contents($send_msg_file);
$data = json_decode($jsonString, true);
/*print_r($data);*/
$query_data=$data['query_data'];
echo count($query_data);
echo "<br>";
$msg_job_id=$data['msg_job_id'];
/*$sendtable = SENDSMS . CURRENTMONTH;
$sendtabledetals = SENDSMSDETAILS ;*/
/*
$sendtable = SENDSMS . CURRENTMONTH;*/
/*$sendtable = SENDSMS . CURRENTMONTH;*/
$sendtabledetals = 'az_sendnumbers' ;
echo "start time".date("i:s");
echo "<br>";
/*$data_arr=array_chunk($query_data, 2000);*/

        foreach($query_data as $values) {    
            $insert_val=implode(",",$values);
           
            $query_master_tbl_insert= "INSERT INTO $sendtabledetals (`id`, `message_id`, `msgdata`, `mobile_number`, `created_at`, `senderid`, `service_id`, `request_code`, `is_picked`, `priority`, `is_scheduled`, `scheduled_time`, `msgcredit`, `userids`, `operator_status_id`, `status`, `err_code`,`status_id`,`route`,`char_count`,`msg_job_id`,`schedule_sent`,`parent_id`,`sent_at`,`cut_off`,`master_job_id`,`send_msg`,`unicode_type`,`metadata`,`operator_name`) VALUES $insert_val";
          
            $rs= mysqli_query($dbc, $query_master_tbl_insert) or die(mysqli_error($dbc));

           /* echo mysql_num_rows($rs1);

            echo "<br>";*/

            unset($insert_val);

            insert_send_sms($msg_job_id);
          
            usleep(10000);          
        }
        echo "<br>";
        echo "end time".date("i:s");


function insert_send_sms($msg_job_id)
{
    global $dbc;

    $select_master_table="select id,mobile_number,senderid,msgcredit,unicode_type,userids,service_id,is_scheduled,request_code,send_msg,metadata from az_sendnumbers where is_picked=0 and msg_job_id='".$msg_job_id."'";
    $rs1 = mysqli_query($dbc, $select_master_table) or die(mysqli_error($dbc));

    while($row=mysqli_fetch_array($rs1))
    {
        $dlr_url = $row['id'];
        $mobile_number = $row['mobile_number'];
        $senderid = $row['senderid'];
        $send_msg=$row['send_msg'];
        $service_id =$row['service_id'];
        $unicode_type = $row['unicode_type'];
        $metadata=$row['metadata'];
        if($unicode_type == 0)
        {
            $boxc_id=0;
        }
        else
        {
            $boxc_id=2;
        }
        $momt='MT';
        $insert_sent_sms_val[]="('".$momt."','".$senderid."','".$mobile_number."','".$send_msg."','".$service_id."',2,19,'".$dlr_url."','sqlbox',".$boxc_id.",'utf8',0,'".$metadata."')";
            
    }

     $insert_sms_val=implode(",",$insert_sent_sms_val);

    $query_sent_sms = "INSERT INTO `send_sms` (`momt`, `sender`, `receiver`, `msgdata`, `smsc_id`,`sms_type`, `coding`, `dlr_mask`, `dlr_url`, `charset`, `boxc_id`, `udh`,`meta_data`) values $insert_sms_val";

    $rs3 = mysqli_query($dbc, $query_sent_sms) or die(mysqli_error($dbc));
    unset($insert_sent_sms_val);


    $update_master_tbl="update az_sendnumbers set is_picked=1 where msg_job_id='".$msg_job_id."'";
    $rs4 = mysqli_query($dbc, $update_master_tbl) or die(mysqli_error($dbc));

}


         /*if($rs)
        {
            $update_job_tbl="update $sendtable set schedule_sent=1 where job_id='$msg_job_id'";
            $rs_job = mysqli_query($dbc, $update_job_tbl) or die(mysqli_error($dbc));
        }
*/



   
?>