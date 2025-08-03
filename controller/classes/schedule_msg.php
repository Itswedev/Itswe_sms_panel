<?php
session_start();
$log_file = "/var/www/html/itswe_panel/error/logfiles/schedule_msg.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);

include('/var/www/html/itswe_panel/include/connection.php');


$send_msg_file = "/var/www/html/itswe_panel/controller/classes/".$argv[1];

$jsonString = file_get_contents($send_msg_file);
$data = json_decode($jsonString, true);
/*print_r($data);*/
$query_data=$data['query_data'];
$pass_dtls=$data['pass_dtls'];
$sendtabledetals=$pass_dtls[0];  
$v_num=$pass_dtls[1]; 
$pe_id=$pass_dtls[2]; 
$template_id=$pass_dtls[3];        
$char_set=$pass_dtls[4]; 
$msg=$pass_dtls[5]; 
$senderid_name=$pass_dtls[6]; 
$service_name=$pass_dtls[7]; 
$is_schedule=$pass_dtls[8]; 
 $meta_data="?smpp?PEID=$pe_id&TID=$template_id";
     $i=0;
        foreach($query_data as $values) {
           
        
           
            $insert_val=implode(",",$values);
            $count_val=count($values);
           
           

           $query_master_tbl_insert= "INSERT INTO $sendtabledetals (`id`, `message_id`, `msgdata`, `mobile_number`, `created_at`, `senderid`, `service_id`, `request_code`, `is_picked`, `priority`, `is_scheduled`, `scheduled_time`, `msgcredit`, `userids`, `operator_status_id`, `status`, `err_code`,`status_id`,`route`,`char_count`,`schedule_sent`) VALUES $insert_val";
            $rs1 = mysqli_query($dbc, $query_master_tbl_insert) or die(mysqli_error($dbc));


             $last_insert_id = mysqli_fetch_array(mysqli_query($dbc,"select LAST_INSERT_ID() as id"));

             $last_id=$last_insert_id['id'];




            foreach($values as $val)
            {

                
                $num_send=$v_num[$i];
                $i++;
              /* $query_master_tbl_insert= "INSERT INTO $sendtabledetals (`id`, `message_id`, `msgdata`, `mobile_number`, `created_at`, `senderid`, `service_id`, `request_code`, `is_picked`, `priority`, `is_scheduled`, `scheduled_time`, `msgcredit`, `userids`, `operator_status_id`, `status`, `err_code`,`status_id`,`route`,`char_count`) VALUES $val";*/
               /* $rs1 = mysqli_query($dbc, "INSERT INTO $sendtabledetals (`id`, `message_id`, `msgdata`, `mobile_number`, `created_at`, `senderid`, `service_id`, `request_code`, `is_picked`, `priority`, `is_scheduled`, `scheduled_time`, `msgcredit`, `userids`, `operator_status_id`, `status`, `err_code`,`status_id`,`route`,`char_count`) VALUES " . $val);
                 $dlr_url= mysqli_insert_id($dbc);
               

                */
               
                 $dlr_url=$last_id++;

                if($char_set=='Text')
                {
                    $msg_send=$msg;
                   $send_sms_data[]=['MT',$senderid_name,$num_send,$msg_send,$service_name,2,0,19,$dlr_url,'utf8','sqlbox','0',$meta_data];
                   $text_type=0;
                   
                }
                elseif($char_set=='Unicode')
                {

                    $msg_send=urlencode($msg);
                   
                    $send_sms_data[]=['MT',$senderid_name,$num_send,$msg_send,$service_name,2,2,19,$dlr_url,'utf8','sqlbox','0',$meta_data];
                   $text_type=1;
                }

           

            }

       

            
        }


      /* print_r($send_sms_data);*/

         if($is_schedule != '1')
            {
                $send_sms_status=send_sms($send_sms_data);
            }


/*unlink($send_sms_file);*/


function send_sms($send_sms_data)
    {
        global $dbc;
        $queryInsert = "INSERT INTO `send_sms` (`momt`, `sender`, `receiver`, `msgdata`, `smsc_id`,`sms_type`, `coding`, `dlr_mask`, `dlr_url`, `charset`, `boxc_id`, `udh`,`meta_data`) values";
        //echo count($send_sms_data);
        for($i=0;$i<count($send_sms_data);$i++)
        {

            $momt=$send_sms_data[$i][0];
            $sender=$send_sms_data[$i][1];
            $receiver=$send_sms_data[$i][2];
            $msgdata=$send_sms_data[$i][3];

            $smsc_id=$send_sms_data[$i][4];
            $sms_type=$send_sms_data[$i][5];
            $coding=$send_sms_data[$i][6];
            $dlr_mask=$send_sms_data[$i][7];
            $dlr_url=$send_sms_data[$i][8];
            $charset=$send_sms_data[$i][9];
            $boxc_id=$send_sms_data[$i][10];
            $udh=$send_sms_data[$i][11];
            $meta_data=$send_sms_data[$i][12];

            if(count($send_sms_data)>1 && ($i!=(count($send_sms_data)-1)))
            {
                $queryInsert.="('$momt','$sender','$receiver','$msgdata','$smsc_id',$sms_type,$coding,$dlr_mask,'$dlr_url','$charset','$boxc_id','$udh','$meta_data'),";
            }
            else
            {
                $queryInsert.="('$momt','$sender','$receiver','$msgdata','$smsc_id',$sms_type,$coding,$dlr_mask,'$dlr_url','$charset','$boxc_id','$udh','$meta_data')";
            }
  
        }
        
      
           if(mysqli_query($dbc,$queryInsert))
           {
                return 1;
           }
           else
           {
            return mysqli_error($dbc);
             
           }
        
    }

?>