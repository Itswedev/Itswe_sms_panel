<?php
session_start();
$log_file = "/var/log/php_errors.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);

include('/var/www/html/include/connection.php');
include('/var/www/html/include/config.php');
 

$send_msg_file = "/var/www/html/controller/classes/sent_sms/".$argv[1];

$jsonString = file_get_contents($send_msg_file);
$data = json_decode($jsonString, true);
/*print_r($data);*/
$query_data=$data['query_data'];
$msg_job_id=$data['msg_job_id'];
$userid=$data['userid'];
$msgcredit=$data['msgcredit'];
$routeid=$data['routeid'];
$pass_dtls=$data['pass_dtls'];
$sendtabledetals=$pass_dtls[0];  
$v_num=$pass_dtls[1]; 
$dnd_num=$pass_dtls[9]; 
$blockNum=$pass_dtls[10]; 
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

        $sql_cut_off="select * from cut_off_dtls where userid='".$userid."' and cut_off_route='".$routeid."'";
        $rs_cutoff = mysqli_query($dbc, $sql_cut_off) or die(mysqli_error($dbc));
        $count_cutoff=mysqli_num_rows($rs_cutoff);
        if($count_cutoff>0)
        {
            while($row_cutoff=mysqli_fetch_array($rs_cutoff)) {
                $cut_off_throughput=$row_cutoff['throughput'];
                $min_cut_value=$row_cutoff['min_cut_value'];
            } 

            $cut_off_throughput_withcomma=str_replace("-", ",", $cut_off_throughput);
            $throughput_vals=explode(",",$cut_off_throughput_withcomma);

            $random_cutoff=rand($throughput_vals[0],$throughput_vals[1]);

        }


        $sql_whitelist="select * from az_blocknumbers where userid='".$userid."' and status='1'";
        $rs_whitelist= mysqli_query($dbc, $sql_whitelist) or die(mysqli_error($dbc));
        $count_whitelist=mysqli_num_rows($rs_whitelist);
        if($count_whitelist>0)
        {
            while ($row_whitelist=mysqli_fetch_array($rs_whitelist)) {
                $whitelist_num[]=trim($row_whitelist['numbers']);
               
            } 
        }

        $total_num=count($v_num);


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

            $k=0;
        foreach($query_data as $values) {    
            $insert_val=implode(",",$values);
            $count_val=count($values);   

            $msg_arr[]=$values;
           $query_master_tbl_insert= "INSERT INTO $sendtabledetals (`id`, `message_id`, `msgdata`, `mobile_number`, `created_at`, `senderid`, `service_id`, `request_code`, `is_picked`, `priority`, `is_scheduled`, `scheduled_time`, `msgcredit`, `userids`, `operator_status_id`, `status`, `err_code`,`status_id`,`route`,`char_count`,`msg_job_id`,`schedule_sent`,`parent_id`,`sent_at`) VALUES $insert_val";
            $rs1 = mysqli_query($dbc, $query_master_tbl_insert) or die(mysqli_error($dbc));


             $last_insert_id = mysqli_fetch_array(mysqli_query($dbc,"select LAST_INSERT_ID() as id"));

             $last_id=$last_insert_id['id'];

             $last_dlr_url=$last_id;
             $query_sent_sms = "INSERT INTO `send_sms` (`momt`, `sender`, `receiver`, `msgdata`, `smsc_id`,`sms_type`, `coding`, `dlr_mask`, `dlr_url`, `charset`, `boxc_id`, `udh`,`meta_data`) values";
                 $len=count($values);
                 $j=0;

            foreach($values as $val)
            {

                  $msg_arr=explode(")(",$val);
               // print_r($msg_arr);
                $msg=explode(', "',$msg_arr[0]);
               
               $msgdata=str_replace('"','',$msg[2]);
              
                 
                 if($char_set=='Unicode')
                {
                    $msgdata=urlencode($msgdata);
                }
                $k++;
                $job_id=random_strings(20);
                
                $num_send=$v_num[$i];

                $i++;
                $j++;
            
                $dlr_url=$last_id++;
                    
                mysqli_query($dbc,"update az_sendnumbers set master_job_id='".$job_id."' where id='$dlr_url'");
   
                $receiver=$num_send;

               if(isset($dnd_num)&&!empty($dnd_num))
                {
                    $mob_num=str_replace("+91","",trim($num_send));
                    if(in_array($mob_num,$dnd_num))
                    {
                        //continue;
                    }
                    else
                    {
                        if(isset($whitelist_num) && !empty($whitelist_num))
                        {
                            $mob_num=str_replace("+91","",trim($num_send));
                            if(in_array($num_send, $whitelist_num) || in_array($mob_num, $whitelist_num))
                            {
                                $receiver=$num_send;
                                $queryInsert[]="('$momt','$sender','$receiver','$msgdata','$smsc_id',$sms_type,$coding,$dlr_mask,'$dlr_url','$charset','$boxc_id','$udh','$meta_data')";
                            }
                            else
                            {
                                 $queryInsert2[]="('$momt','$sender','$receiver','$msgdata','$smsc_id',$sms_type,$coding,$dlr_mask,'$dlr_url','$charset','$boxc_id','$udh','$meta_data')";
                            }
                            
                        }
                        else
                        {
                            $receiver=$num_send;
                            $queryInsert2[]="('$momt','$sender','$receiver','$msgdata','$smsc_id',$sms_type,$coding,$dlr_mask,'$dlr_url','$charset','$boxc_id','$udh','$meta_data')";
                        }
                       
                    }
                }
                else if(isset($blockNum)&&!empty($blockNum))
                {
                    $mob_num=str_replace("+91","",trim($num_send));
                    if(in_array($num_send,$blockNum) || in_array($mob_num,$blockNum))
                    {
                        //continue;
                    }
                    else
                    {
                                $receiver=$num_send;
                                $queryInsert[]="('$momt','$sender','$receiver','$msgdata','$smsc_id',$sms_type,$coding,$dlr_mask,'$dlr_url','$charset','$boxc_id','$udh','$meta_data')";
                           
                    }
                       
                    
                }
                else
                {
                       if(!empty($whitelist_num))
                        {
                            $mob_num=str_replace("+91","",trim($num_send));
                            if(in_array($num_send, $whitelist_num) || in_array($mob_num, $whitelist_num))
                            {
                                $receiver=$num_send;
                                $queryInsert[]="('$momt','$sender','$receiver','$msgdata','$smsc_id',$sms_type,$coding,$dlr_mask,'$dlr_url','$charset','$boxc_id','$udh','$meta_data')";
                            }
                            else
                            {
                                 $queryInsert2[]="('$momt','$sender','$receiver','$msgdata','$smsc_id',$sms_type,$coding,$dlr_mask,'$dlr_url','$charset','$boxc_id','$udh','$meta_data')";
                            }
                            
                        }
                        else
                        {
                            $receiver=$num_send;
                            $queryInsert2[]="('$momt','$sender','$receiver','$msgdata','$smsc_id',$sms_type,$coding,$dlr_mask,'$dlr_url','$charset','$boxc_id','$udh','$meta_data')";
                        }
                }



                    /*$queryInsert[]="('$momt','$sender','$receiver','$msgdata','$smsc_id',$sms_type,$coding,$dlr_mask,'$dlr_url','$charset','$boxc_id','$udh','$meta_data')";*/
            }            
        }

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

                     /*refund credit to admin*/
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
        }

        if(!empty($queryInsert3) && !empty($queryInsert))
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
        }
       
        $sent_values=array_chunk($queryInsert_final, 2000);

     /* $array = array('sent_values' => $sent_values);
        $sent_sms_filename="sent_sms_".time().".json";
        $file_path="/var/www/html/controller/classes/".$sent_sms_filename;
        $fp = fopen($file_path, 'w+');
        fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
        fclose($fp);
        $sent_tbl_file = "/var/www/html/controller/classes/".$sent_sms_filename;
        $jsonString = file_get_contents($sent_tbl_file);
        $data = json_decode($jsonString, true);
        /*print_r($data);
        $sent_val_arr=$data['sent_values'];*/
        foreach($sent_values as $values1)
        {
             $insert_val=implode(",",$values1);
            
             $query_sent_sms = "INSERT INTO `send_sms` (`momt`, `sender`, `receiver`, `msgdata`, `smsc_id`,`sms_type`, `coding`, `dlr_mask`, `dlr_url`, `charset`, `boxc_id`, `udh`,`meta_data`) values $insert_val";

            $rs3 = mysqli_query($dbc, $query_sent_sms) or die(mysqli_error($dbc));
            sleep(1);
           
        }

        function random_strings($length_of_string)
        {
         
            // String of all alphanumeric character
            $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
         
            // Shuffle the $str_result and returns substring
            // of specified length
            return substr(str_shuffle($str_result),
                               0, $length_of_string);
        }

        function getOverSeelingUserids($userid) {
        global $dbc;
        $qry = "SELECT `userid`, `parent_id` FROM `az_user` WHERE userid = '{$userid}'";
        $rs = mysqli_query($dbc, $qry);
        static $ids = array();
        $per = false;
        if (mysqli_num_rows($rs) > 0) {
            $rows = mysqli_fetch_assoc($rs);
            if ($rows['userid'] == 1) {
                return $ids;
            } else {
                $ids[] = $rows['userid'];
                if (!empty($ids)) {
                    return getOverSeelingUserids($rows['parent_id']);
                } else {
                    if ($userid == $rows['userid']) {
                        $ids[] = $rows['userid'];
                        return getOverSeelingUserids($rows['parent_id']);
                    }
                }
            }
        } else {
            return $ids;
        }
    }



    function adminRefund($userid, $routeid, $credit) {
        global $dbc;
        if (!empty($userid)) {
            $ids = trim(implode(',', $userid));

            $sql_user="select userid from az_user where userid in ($ids) and user_role='mds_ad'";
            $result_user=mysqli_query($dbc,$sql_user);
            while($row_user=mysqli_fetch_array($result_user))
            {
                $ids1[]=$row_user['userid'];
            }

            $idss=trim(implode(',', $ids1));
            $sql="select `user_role`,`userid` from az_user where userid in ($idss)";
            $result=mysqli_query($dbc,$sql);
            while($row=mysqli_fetch_array($result))
            {
                
                $userid=$row['userid'];
                $result = mysqli_query($dbc, "UPDATE `az_credit_manage` SET balance = (balance + $credit) WHERE userid = '{$userid}' AND az_routeid = '{$routeid}'");
                
            }
            return 1;

        } else {
            return false;
        }
    }



    function fetch_admin_ids($userid) {
        global $dbc;
        if (!empty($userid)) {
            //$ids = trim(implode(',', $userid));

            $sql_user="select userid from az_user where userid in ($userid) and user_role='mds_ad'";
            $result_user=mysqli_query($dbc,$sql_user);
            while($row_user=mysqli_fetch_array($result_user))
            {
                $ids1[]=$row_user['userid'];
            }


        /*    if(count($ids1)>1)
            {*/
                $idss=trim(implode(',', $ids1));
           /* }
            else
            {
                $idss=$ids1;
            }*/
            
      
            return $idss;

        } else {
            return false;
        }
    }

?>