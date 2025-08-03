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

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
error_reporting(0);
 
global $dbc;
$send_msg_file = "/var/www/html/itswe_panel/controller/classes/sent_call/".$argv[1];

$jsonString = file_get_contents($send_msg_file);
$data = json_decode($jsonString, true);
/*print_r($data);*/
$query_data=$data['query_data'];
$msg_job_id=$data['msg_job_id'];
$call_send=$data['call_send'];
$multimedia_id=$data['multimedia_id'];
$retryatmpt=$data['retry_attempt'];
$caller_id=$data['caller_id'];
$vsms=$data['vsms'];
$userid=$data['userid'];
$parent_id=$data['parent_id'];
$file_name=$data['file_name'];
$msg_id=$data['msg_id'];
$call_method=$data['call_method'];
$wait_duration=$data['wait_duration'];
$msgcredit=$data['msgcredit'];
$retryduration=$data['retry_duration'];
$end_point=$data['end_point'];
$campaign_name=$data['campaign_name'];
$gateway_name=$data['gateway_name'];
$voice_id=$data['voice_id'];
$sender_id=$data['sender_id'];
$template_id=$data['template_id'];
$sendtable = SENDCALL . CURRENTMONTH;
$sendtabledetals = SENDCALLDETAILS ;


foreach($query_data as $values) {
                        
                        $insert_val=implode(",",$values);
                        $count_val=count($values);
                    
                        /*  $msg_arr[]=$values;*/
                       
                        $query_master_tbl_insert= "INSERT INTO $sendtabledetals (`id`, `message_id`,  `mobile_number`, `created_dt`,  `is_scheduled`, `scheduled_time`, `msgcredit`, `userid`,  `status`, `err_code`,`route`,`msg_job_id`,`schedule_sent`,`parent_id`,`sent_at`,`cut_off`,`master_job_id`,`multimedia_id`,`file_name`,`caller_id`,`trans_id`,`retry_duration`) VALUES $insert_val";
                        $rs1 = mysqli_query($dbc, $query_master_tbl_insert) or die(mysqli_error($dbc));


                        }


          
           
                if($call_method=='Simple' || $call_method=='DTMF')
                {

                $api_key="Aed59a77bef0e925830004dfe238965b7";
                $call_send_arr=array_chunk($call_send, 100);
                $url = $end_point;
                foreach($call_send_arr as $mob_num_arr)
                {     

                    $data = array(
                        'play' => $voice_id.'.ivr',
                        'call' => array_map(function ($number) use ($msg_job_id) {
                            return array('to' => $number ,'custom'=>$msg_job_id);
                        }, $mob_num_arr)
                    );

                    $dataString = json_encode($data);

                    $headers = array(
                        'Content-Type: application/json',
                        'x-api-key: ' . $api_key
                    );
                    
                    $ch = curl_init($url);

                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                    $response = curl_exec($ch);

                        $filename="kaleyra.json";
       
                        $file_path="/var/log/voice/".$filename;
                        $fp = fopen($file_path, 'a+');
                        fwrite($fp, $response);   // here it will print the array pretty
                        fclose($fp);

                        $json_data="";
                        $json_data = json_decode($response,true);

                        
                    }
                


            }

         if($rs1)
        {
            $update_job_tbl="update $sendtable set schedule_sent=1 where job_id='$msg_job_id'";
            $rs_job = mysqli_query($dbc, $update_job_tbl) or die(mysqli_error($dbc));
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



        function random_num($length_of_string)
        {
         
            // String of all alphanumeric character
            $str_result = '0123456789';
         
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