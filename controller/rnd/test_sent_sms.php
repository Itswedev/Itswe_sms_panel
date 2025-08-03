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
 

$send_msg_file = "/var/www/html/itswe_panel/controller/rnd/".$argv[1];

$jsonString = file_get_contents($send_msg_file);
$data = json_decode($jsonString, true);
/*print_r($data);*/
$query_data=$data['query_data'];
$msg_job_id=$data['msg_job_id'];
/*$sendtable = SENDSMS . CURRENTMONTH;
$sendtabledetals = SENDSMSDETAILS ;*/
/*
$sendtable = SENDSMS . CURRENTMONTH;*/
$sendtable = SENDSMS . CURRENTMONTH;
$sendtabledetals = 'az_sendnumbers_test' ;
echo "start time".date("i:s");
echo "<br>";
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

    $select_master_table="select id,mobile_number,senderid,msgcredit,unicode_type,userids,service_id,is_scheduled,request_code,send_msg,metadata from az_sendnumbers_test where is_picked=0 and msg_job_id='".$msg_job_id."'";
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

    $query_sent_sms = "INSERT INTO `send_sms_test` (`momt`, `sender`, `receiver`, `msgdata`, `smsc_id`,`sms_type`, `coding`, `dlr_mask`, `dlr_url`, `charset`, `boxc_id`, `udh`,`meta_data`) values $insert_sms_val";

    $rs3 = mysqli_query($dbc, $query_sent_sms) or die(mysqli_error($dbc));
    unset($insert_sent_sms_val);


    $update_master_tbl="update az_sendnumbers_test set is_picked=1 where msg_job_id='".$msg_job_id."'";
    $rs4 = mysqli_query($dbc, $update_master_tbl) or die(mysqli_error($dbc));

}


         if($rs)
        {
            $update_job_tbl="update $sendtable set schedule_sent=1 where job_id='$msg_job_id'";
            $rs_job = mysqli_query($dbc, $update_job_tbl) or die(mysqli_error($dbc));
        }


/*

        if($count_cutoff>0 && ($total_num>$min_cut_value))
        {
            
               if(!empty($queryInsert2))
               {
                    shuffle($queryInsert2);
                   
                    $sendval = ceil(($total_num * $random_cutoff)/100);
                  
                    $count_arr_val=count($queryInsert2);
                    $count_arr=$count_arr_val-1;
                    $cut_off_data=array_slice($queryInsert2,0,$sendval);
                  
                    $queryInsert3=array_slice($queryInsert2,$sendval,$count_arr);
                    
                    for($j=0;$j<count($cut_off_data);$j++)
                    {
                        $cut_off_datarow=explode(",", $cut_off_data[$j]);
                       // $cut_off_no[]=str_replace("'","",$cut_off_datarow[2]);
                        $dlr_url_cutoff[]=str_replace("'","",$cut_off_datarow[8]);
                    }

                    if(!empty($dlr_url_cutoff))
                    {
                        for($j=0;$j<count($dlr_url_cutoff);$j++)
                        {
                            $update_cutoff="update az_sendnumbers set cut_off='Yes' where id='".$dlr_url_cutoff[$j]."'";
                            $rs_cutoff_update=mysqli_query($dbc,$update_cutoff);
                        }

                     $count_cutoff_data=count($cut_off_data);
                     $sendtable = SENDSMS . CURRENTMONTH;
                     $update_job_tbl="update $sendtable set cut_off='Yes',cut_off_throughput='$random_cutoff',total_cutting='$count_cutoff_data' where job_id='".$msg_job_id."'";

                     $rs_update_job_tbl=mysqli_query($dbc,$update_job_tbl);

                     /*refund credit to admin
                     $credit_refund=$count_cutoff_data*$msgcredit;
                     $idss = getOverSeelingUserids($userid);

                     $ids = implode(',', $idss);
                     
                     
                     $userids = $ids;
                    
                     $admin_ids=fetch_admin_ids($userids);
            
                     //checkBalance($idss, $az_routeid, $credit);

                     $refund=adminRefund($idss, $routeid, $credit_refund);

                     $sql_insert_smart_cutoff="insert into smart_cutoff(`userid`,`created_date`,`job_id`,`msg_count`,`throughput`,`cut_off`,`percent`,`routeid`,`min_value`,`parent_id`) values('".$userid."',now(),'$msg_job_id','$total_num','$cut_off_throughput','$credit_refund','$random_cutoff','$routeid','$min_cut_value','$admin_ids')";

                     $rs_insert=mysqli_query($dbc,$sql_insert_smart_cutoff);
                    }
                     

               }
            
        }
        else
        {
            $queryInsert3=$queryInsert2;
        }*/

       /* if(!empty($queryInsert3) && !empty($queryInsert))
        {
            $queryInsert_final=array_merge($queryInsert,$queryInsert3);
        }
        else if(!empty($queryInsert3))
        {
            $queryInsert_final=$queryInsert3;
        }
        else
        {
            $queryInsert_final=$queryInsert;
        }*/
       
        //$sent_values=array_chunk($queryInsert_final, 2000);

     /* $array = array('sent_values' => $sent_values);
        $sent_sms_filename="sent_sms_".time().".json";
        $file_path="/var/www/html/itswe_panel/controller/classes/".$sent_sms_filename;
        $fp = fopen($file_path, 'w+');
        fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
        fclose($fp);
        $sent_tbl_file = "/var/www/html/itswe_panel/controller/classes/".$sent_sms_filename;
        $jsonString = file_get_contents($sent_tbl_file);
        $data = json_decode($jsonString, true);
        /*print_r($data);
        $sent_val_arr=$data['sent_values'];*/
/*        foreach($sent_values as $values1)
        {
             $insert_val=implode(",",$values1);
            
             $query_sent_sms = "INSERT INTO `send_sms` (`momt`, `sender`, `receiver`, `msgdata`, `smsc_id`,`sms_type`, `coding`, `dlr_mask`, `dlr_url`, `charset`, `boxc_id`, `udh`,`meta_data`) values $insert_val";

            $rs3 = mysqli_query($dbc, $query_sent_sms) or die(mysqli_error($dbc));
            sleep(1);
           
        }*/

   
?>