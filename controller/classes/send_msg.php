<?php
session_start();
$log_file = "/var/www/html/itswe_panel/error/logfiles/send_msg.log";
 
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
     /*$dlr_url_arr[]="";$num_send_arr[]="";*/




        if($char_set=='Text')
                {
                    $msg_send=$msg;
                   $send_sms_data=['MT',$senderid_name,$msg_send,$service_name,2,0,19,'utf8','sqlbox','0',$meta_data];
                   $text_type=0;
                   
                }
                elseif($char_set=='Unicode')
                {

                    $msg_send=urlencode($msg);
                   
                    $send_sms_data=['MT',$senderid_name,$msg_send,$service_name,2,2,19,'utf8','sqlbox','0',$meta_data];
                   $text_type=1;
                }


                 $momt=$send_sms_data[0];
            $sender=$send_sms_data[1];
           /* $receiver=$send_sms_data[$i][2];*/
            $msgdata=$send_sms_data[2];

            $smsc_id=$send_sms_data[3];
            $sms_type=$send_sms_data[4];
            $coding=$send_sms_data[5];
            $dlr_mask=$send_sms_data[6];
           /* $dlr_url=$send_sms_data[$i][8];*/
            $charset=$send_sms_data[7];
            $boxc_id=$send_sms_data[8];
            $udh=$send_sms_data[9];
            $meta_data=$send_sms_data[10];


        foreach($query_data as $values) {
           
        
           
            $insert_val=implode(",",$values);
            $count_val=count($values);
           
           

           $query_master_tbl_insert= "INSERT INTO $sendtabledetals (`id`, `message_id`, `msgdata`, `mobile_number`, `created_at`, `senderid`, `service_id`, `request_code`, `is_picked`, `priority`, `is_scheduled`, `scheduled_time`, `msgcredit`, `userids`, `operator_status_id`, `status`, `err_code`,`status_id`,`route`,`char_count`,`msg_job_id`,`schedule_sent`,`parent_id`,`sent_at`) VALUES $insert_val";
			$rs1 = mysqli_query($dbc, $query_master_tbl_insert) or die(mysqli_error($dbc));


             $last_insert_id = mysqli_fetch_array(mysqli_query($dbc,"select LAST_INSERT_ID() as id"));

             $last_id=$last_insert_id['id'];

             $last_dlr_url=$last_id;
                 $queryInsert = "INSERT INTO `send_sms` (`momt`, `sender`, `receiver`, `msgdata`, `smsc_id`,`sms_type`, `coding`, `dlr_mask`, `dlr_url`, `charset`, `boxc_id`, `udh`,`meta_data`) values";
                 $len=count($values);
                 $j=0;
            foreach($values as $val)
            {

                
                $num_send=$v_num[$i];
                $i++;
                $j++;
              /* $query_master_tbl_insert= "INSERT INTO $sendtabledetals (`id`, `message_id`, `msgdata`, `mobile_number`, `created_at`, `senderid`, `service_id`, `request_code`, `is_picked`, `priority`, `is_scheduled`, `scheduled_time`, `msgcredit`, `userids`, `operator_status_id`, `status`, `err_code`,`status_id`,`route`,`char_count`) VALUES $val";*/
               /* $rs1 = mysqli_query($dbc, "INSERT INTO $sendtabledetals (`id`, `message_id`, `msgdata`, `mobile_number`, `created_at`, `senderid`, `service_id`, `request_code`, `is_picked`, `priority`, `is_scheduled`, `scheduled_time`, `msgcredit`, `userids`, `operator_status_id`, `status`, `err_code`,`status_id`,`route`,`char_count`) VALUES " . $val);
                 $dlr_url= mysqli_insert_id($dbc);
               

				*/
               
                 /*$dlr_url_arr[]=$last_id++;
                 $num_send_arr[]=$num_send;*/
                    $dlr_url=$last_id++;
                
             
        //echo count($send_sms_data);
       /* for($i=0;$i<count($send_sms_data);$i++)
        {*/

           
            
            /*	$dlr_url=$dlr_url_arr[$i];*/
            	$receiver=$num_send;

	            if($j!=$len)
	            {
	                $queryInsert.="('$momt','$sender','$receiver','$msgdata','$smsc_id',$sms_type,$coding,$dlr_mask,'$dlr_url','$charset','$boxc_id','$udh','$meta_data'),";
	            }
	            else
	            {
	                $queryInsert.="('$momt','$sender','$receiver','$msgdata','$smsc_id',$sms_type,$coding,$dlr_mask,'$dlr_url','$charset','$boxc_id','$udh','$meta_data')";
	            }
	  
  			

        
     /*  echo $queryInsert;*/
      
          
      
                // $send_sms_status=send_sms($send_sms_data,$dlr_url_arr,$num_send_arr);
            
               /* if($char_set=='Text')
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
                }*/

           

            }
          
       	 if(mysqli_query($dbc,$queryInsert))
           {
                echo 1;
           }
           else
           {
            echo mysqli_error($dbc);
             
           }

            
        }

      /*  $array = array('dlr_url' => $dlr_url_arr,'num_send' => $num_send_arr);
        $sent_sms_filename="sent_sms_".time().".json";
        $file_path="/var/www/html/itswe_panel/controller/classes/".$sent_sms_filename;
        $fp = fopen($file_path, 'w+');
        fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
        fclose($fp);
*/
      /* print_r($send_sms_data);*/
/*
         if($is_schedule != '1')
            {
                 $send_sms_status=send_sms($send_sms_data,$sent_sms_filename);
            }*/


/*unlink($send_sms_file);*/


function send_sms($send_sms_data,$dlr_url_arr,$num_send_arr)
    {
        global $dbc;

		$sent_tbl_file = "/var/www/html/itswe_panel/controller/classes/".$sent_sms_filename;

		$jsonString = file_get_contents($sent_tbl_file);
		$data = json_decode($jsonString, true);
		/*print_r($data);*/
		$dlr_url_arr=$data['dlr_url'];
		$num_send_arr=$data['num_send'];
		
        $queryInsert = "INSERT INTO `send_sms` (`momt`, `sender`, `receiver`, `msgdata`, `smsc_id`,`sms_type`, `coding`, `dlr_mask`, `dlr_url`, `charset`, `boxc_id`, `udh`,`meta_data`) values";
        //echo count($send_sms_data);
       /* for($i=0;$i<count($send_sms_data);$i++)
        {*/

            $momt=$send_sms_data[0];
            $sender=$send_sms_data[1];
           /* $receiver=$send_sms_data[$i][2];*/
            $msgdata=$send_sms_data[2];

            $smsc_id=$send_sms_data[3];
            $sms_type=$send_sms_data[4];
            $coding=$send_sms_data[5];
            $dlr_mask=$send_sms_data[6];
           /* $dlr_url=$send_sms_data[$i][8];*/
            $charset=$send_sms_data[7];
            $boxc_id=$send_sms_data[8];
            $udh=$send_sms_data[9];
            $meta_data=$send_sms_data[10];

            for($i=0;$i<count($dlr_url_arr); $i++)
            {
            	$dlr_url=$dlr_url_arr[$i];
            	$receiver=$num_send_arr[$i];

	            if($i<(count($dlr_url_arr)-1))
	            {
	                $queryInsert.="('$momt','$sender','$receiver','$msgdata','$smsc_id',$sms_type,$coding,$dlr_mask,'$dlr_url','$charset','$boxc_id','$udh','$meta_data'),";
	            }
	            else
	            {
	                $queryInsert.="('$momt','$sender','$receiver','$msgdata','$smsc_id',$sms_type,$coding,$dlr_mask,'$dlr_url','$charset','$boxc_id','$udh','$meta_data')";
	            }
	  
  			}

        
       /* echo $queryInsert;*/
      
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