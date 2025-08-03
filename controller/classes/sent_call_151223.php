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

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
error_reporting(0);
 
global $dbc;
$send_msg_file = "/var/www/html/controller/classes/sent_call/".$argv[1];

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
$sendtable = SENDCALL . CURRENTMONTH;
$sendtabledetals = SENDCALLDETAILS ;
 if($vsms=='Yes')
            {
               /* $pyout = exec("/var/www/html/python-venv/bin/python /var/www/html/controller/vcalls/setup.py $send_msg_file >> /var/www/html/controller/vcalls/test_calls.log");*/
                 $serviceno=$caller_id;
            }
            else
            {
                 $serviceno="4473955";
            }

 $serviceno="4473955";
 $sql_multimedia="select original_filename,get_response,sender_id,template_id,voice_id,ivr_id from `multimedia` where id='$multimedia_id'";

        $result=mysqli_query($dbc,$sql_multimedia);
        while($row=mysqli_fetch_array($result))
        {   
            /*
            $sourcetype=$row['sourcetype'];
            $campaign_type=$row['campaign_type'];
            $filetype=$row['filetype'];*/
            $voice_file=$row['original_filename'];
            $voice_id=$row['voice_id'];
             $ivr_id=$row['ivr_id'];
            $parts = explode('.', $voice_file);
            $filename=$parts[0];
            $voice_file = $filename.".wav";

            $get_response=$row['original_filename'];
            $sender_id=$row['sender_id'];
            $template_id=$row['template_id'];
           /* $ukey=$row['ukey'];
            $serviceno=$row['serviceno'];
            $ivrtemplateid=$row['ivrtemplateid'];
            $retryatmpt=$row['retryatmpt'];
            $retryduration=$row['retryduration'];*/
        }
             if($gateway_name=='PRP')
             {
     
                if($call_method=='Simple')
                {
                    $sourcetype="0";
                            $campaign_type="4";
                            $filetype="2";           
                            $ukey="CwRrBiT5UdKZF4wMQJZkvBDFp"; 
                            $ivrtemplateid="1";
                           
                            $url = "http://125.16.147.178/VoicenSMS/webresources/CreateOBDCampaignPost";

                            $curl = curl_init();
                            curl_setopt($curl, CURLOPT_URL, $url);
                            curl_setopt($curl, CURLOPT_POST, true);
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                            $headers = array(
                               "Accept: application/json",
                               "Content-Type: application/json",
                            );
                            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                            $mob_num='"'.implode('","', $call_send).'"';
                           /* echo $mob_num;*/
                            $data = <<<DATA
                             {
                                 "sourcetype": "$sourcetype",
                                 "campaigntype": "$campaign_type",
                                 "filetype": "$filetype",
                                 "voicefile": "$voice_file",
                                 "ukey": "$ukey",
                                 "serviceno": "$serviceno",
                                 "ivrtemplateid": "$ivrtemplateid",
                                 "retryatmpt": "$retryatmpt",
                                 "retryduration": "$retryduration",
                                 "isrefno":"True",
                                 "msisdn": [$mob_num]
                             }
                            DATA;
                }
                else if($call_method=='DTMF')
                {



                    $sourcetype="0";
                            $campaign_type="4";
                            $filetype="2";           
                            $ukey="CwRrBiT5UdKZF4wMQJZkvBDFp"; 
                            $ivrtemplateid="2";
                           
                            $url = "http://125.16.147.178/VoicenSMS/webresources/CreateOBDCampaignPost";

                            $curl = curl_init();
                            curl_setopt($curl, CURLOPT_URL, $url);
                            curl_setopt($curl, CURLOPT_POST, true);
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                            $headers = array(
                               "Accept: application/json",
                               "Content-Type: application/json",
                            );
                            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                            $mob_num='"'.implode('","', $call_send).'"';
                           /* echo $mob_num;*/


                            $data = <<<DATA
                             {
                                 "sourcetype": "$sourcetype",
                                 "campaigntype": "$campaign_type",
                                 "filetype": "$filetype",
                                 "voicefile": "$voice_file",
                                 "ukey": "$ukey",
                                 "serviceno": "$serviceno",
                                 "ivrtemplateid": "$ivrtemplateid",
                                 "retryatmpt": "$retryatmpt",
                                 "retryduration": "$retryduration",
                                 "dtmflength":"1",
                                 "waitduration":$wait_duration,
                                 "isrefno":"True",
                                 "msisdn": [$mob_num]
                             }
                            DATA;


                            echo $data;
                }
                  curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                        $resp = curl_exec($curl);
                        curl_close($curl);

                        $json_data = json_decode($resp,true);

                        $refNo=$json_data['refno'];

                         /*print_r($json_data);*/

                        $refNo_keys=array_keys($refNo);
                        unset($str);
                        foreach ($refNo as $key=>$trans_id_arr) {
                            $num_arr=$trans_id_arr;
                            foreach($num_arr as $num_key=>$trans_id_val)
                            {
                                $trans_id=$trans_id_val;
                                $master_job_id=random_strings(20);
                                $status='Submitted';
                                $route='VOICE';
                                $schedule_sent='1';
                                $str[]='(NULL, NOW(),"'.$msgcredit.'","'.$userid.'","'.$status.'","'.$route.'","'.$msg_job_id.'","'.$schedule_sent.'","'.$parent_id.'",NOW(),"No","'.$master_job_id.'","'.$multimedia_id.'","'.$file_name.'","'.$serviceno.'","'.$trans_id.'","'.$msg_id.'","'.$vsms.'","'.$retryduration.'")';
                                /*print_r($str);*/
                            }
                           
                           // print_r($num_arr);
                        }

                         $query_data = array_chunk($str, 5000);

            foreach($query_data as $values) {    
            $insert_val=implode(",",$values);           
            $query_master_tbl_insert= "INSERT INTO $sendtabledetals (`id`, `created_dt`, `msgcredit`, `userid`, `status`, `route`,`msg_job_id`,`schedule_sent`,`parent_id`,`sent_at`,`cut_off`,`master_job_id`,`multimedia_id`,`file_name`,`caller_id`,`trans_id`,`message_id`,`vsms`,`retry_duration`) VALUES $insert_val";
          
            $rs1 = mysqli_query($dbc, $query_master_tbl_insert) or die(mysqli_error($dbc));
            unset($insert_val);
           // sleep(1);          
        }





            }
            else
            {
                if($call_method=='Simple' || $call_method=='DTMF')
                {

                $username="sr1261";
                $token="hu9kWO";
                $announcement_id=$voice_id;
                //$plan_id="24597";
                $plan_id="29902";
                //$caller_id="07447120331";
                $caller_id="07447120711";
                 if($vsms=='Yes')
                {
                    $caller_id = $data['caller_id'];
                }

                $call_send_arr=array_chunk($call_send, 40);

                foreach($call_send_arr as $mob_num_arr)
                {     
                    $mob_num=implode(',', $mob_num_arr);

                    if($call_method=='Simple')
                    {
                         $parameters="username=$username&token=$token&announcement_id=$announcement_id&plan_id=$plan_id&contact_numbers=$mob_num&caller_id=$caller_id&retry_json={'FNA':'1','FBZ':0,'FCG':'2','FFL':'1'}";
                    }
                      else if($call_method=='DTMF')
                    {
                        $parameters="username=$username&token=$token&announcement_id=$announcement_id&plan_id=$plan_id&contact_numbers=$mob_num&caller_id=$caller_id&retry_json={'FNA':'1','FBZ':0,'FCG':'2','FFL':'1'}&dtmf_wait_time=$wait_duration";
                    }

                     /*http://103.255.103.28/api/voice/voice_broadcast.php?username=sr1261&token=hu9kWO&plan_id=29902&announcement_id=389422&caller_id=07447120331&contact_numbers=XXXXXXXXXX&retry_json={"FNA":0,"FBZ":0,"FCG":0,"FFL":0}&dtmf_wait=5&dtmf_wait_time=5*/
                    $url = $end_point.$parameters;
                    /*echo $url."\n";*/

                            $curl = curl_init();
                            curl_setopt($curl, CURLOPT_URL, $url);
                            curl_setopt($curl, CURLOPT_POST, true);
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                            $headers = array(
                               "Accept: application/json",
                               "Content-Type: application/json",
                            );
                            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                            $mob_num='"'.implode('","', $call_send).'"';
                           /* echo $mob_num;*/
                        /*curl_setopt($curl, CURLOPT_POSTFIELDS, $data);*/
                        $resp = curl_exec($curl);
                        curl_close($curl);
    
                        $filename="nexG_resp.json";
       
                        $file_path="/var/log/voice/".$filename;
                        $fp = fopen($file_path, 'a+');
                        fwrite($fp, $resp);   // here it will print the array pretty
                        fclose($fp);

                        $json_data="";
                        $json_data = json_decode($resp,true);

                        $data=$json_data['data'];
                        unset($refNo);
                        unset($contact_no);
                        foreach($data as $data_val)
                        {
                           $refNo[]=$data_val['system_api_uniqueid'];
                           $contact_no[]=$data_val['contact_number'];
                        }

                         /*print_r($json_data);*/

                        $refNo_keys=array_keys($refNo);
                        
                        $i=0;
                        unset($str);
                        unset($trans_id_arr);
                        foreach ($refNo as $key=>$trans_id_arr) {
                            $num_arr=$trans_id_arr;
                            $contact_num=$contact_no[$i];
                           /* print_r($num_arr);*/
                            
                                $trans_id=$num_arr;
                                $master_job_id=random_strings(20);
                                $status='Submitted';
                                $route='VOICE';
                                $schedule_sent='1';
                                $str[]='(NULL, NOW(),"'.$msgcredit.'","'.$userid.'","'.$status.'","'.$route.'","'.$msg_job_id.'","'.$schedule_sent.'","'.$parent_id.'",NOW(),"No","'.$master_job_id.'","'.$multimedia_id.'","'.$file_name.'","'.$serviceno.'","'.$trans_id.'","'.$msg_id.'","'.$vsms.'","'.$retryduration.'","'.$contact_num.'")';
                               


                            $i++;
                           
                           // print_r($num_arr);
                        }

                         print_r($str);
                        unset($refNo);
         
                         $query_data = array_chunk($str, 5000);

                            foreach($query_data as $values) {    
                            $insert_val=implode(",",$values);           
                            $query_master_tbl_insert= "INSERT INTO $sendtabledetals (`id`, `created_dt`, `msgcredit`, `userid`, `status`, `route`,`msg_job_id`,`schedule_sent`,`parent_id`,`sent_at`,`cut_off`,`master_job_id`,`multimedia_id`,`file_name`,`caller_id`,`trans_id`,`message_id`,`vsms`,`retry_duration`,`mobile_number`) VALUES $insert_val";
                          
                            $rs1 = mysqli_query($dbc, $query_master_tbl_insert) or die(mysqli_error($dbc));
                            unset($insert_val);
                           // sleep(1);          
                        }
                    }
                }
                else if($call_method=='call latching')
                {


                $username="sr1261";
                $token="hu9kWO";
                $announcement_id=$voice_id;
                $plan_id="24597";
                $caller_id="91";
                 if($vsms=='Yes')
                {
                    $caller_id = $data['caller_id'];
                    $plan_id = "29902";
                    $call_send_arr=array_chunk($call_send, 50);
                    $end_point="http://103.255.103.28/api/voice/v1.0/voice_broadcast_ivr.php";

                }
                else
                {
                    $call_send_arr=array_chunk($call_send, 5000);
                    $end_point="http://103.255.103.28/api/voice/bulkSubmissionApi/CreateCampaign.php";
                }
                $ivr_id=$ivr_id;
                $count_mob_num=count($call_send);
               
                $camp_id=random_num(5);                
                foreach($call_send_arr as $mob_num_arr)
                {     
                    $mob_num=implode(',', $mob_num_arr);
                if($vsms=='Yes')
                {
                    $parameters="username=$username&token=$token&plan_id=$plan_id&ivr_id=$ivr_id&contact_numbers=$mob_num&caller_id=$caller_id&data={}";
                }
                else
                {
                     $parameters="user_id=$username&token=$token&voiceid=$announcement_id&campaignname=$campaign_name&campaignid=$camp_id&campaigndata=$mob_num&retrylevel=1&campretrystatus=yes";
                }
                    $url = $end_point.$parameters;
                    echo $url."\n";

                            $curl = curl_init();
                            curl_setopt($curl, CURLOPT_URL, $end_point);
                            curl_setopt($curl, CURLOPT_POST, true);
                            curl_setopt($curl, CURLOPT_POSTFIELDS,$parameters);
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
                            $mob_num='"'.implode('","', $call_send).'"';
                           /* echo $mob_num;*/
                        /*curl_setopt($curl, CURLOPT_POSTFIELDS, $data);*/
                        $resp = curl_exec($curl);
                        curl_close($curl);


                        $filename="test_url.text";
       
                        $file_path="/var/log/voice/".$filename;
                        $fp = fopen($file_path, 'a+');
                        fwrite($fp, $resp);   // here it will print the array pretty
                        fclose($fp);

                        
                        $filename="nexG_resp.json";
       
                        $file_path="/var/log/voice/".$filename;
                        $fp = fopen($file_path, 'a+');
                        fwrite($fp, $resp);   // here it will print the array pretty
                        fclose($fp);


                        $json_data = json_decode($resp,true);
                       /* print_r($json_data);*/
                        //$unique_id = $json_data['uniqe_id'];
                        /*echo "\nunique id \n";*/
                        if($vsms=='Yes')
                        {
                            $unique_id = $json_data['data'][0]['system_api_uniqueid'];
                        
                        }
                        else
                        {
                          $unique_id = $json_data['uniqe_id'];   
                        }
                        
                        
                        $i=0;
                        unset($str);
                        unset($trans_id_arr);
                        foreach ($mob_num_arr as $contact_num) {
                                                       
                                 if($vsms=='Yes')
                                {
                                    $unique_id = $json_data['data'][$i]['system_api_uniqueid'];
                                
                                }
                                $trans_id=$unique_id;
                                $master_job_id=random_strings(20);
                                $status='Submitted';
                                $route='VOICE';
                                $schedule_sent='1';
                                $str[]='(NULL, NOW(),"'.$msgcredit.'","'.$userid.'","'.$status.'","'.$route.'","'.$msg_job_id.'","'.$schedule_sent.'","'.$parent_id.'",NOW(),"No","'.$master_job_id.'","'.$multimedia_id.'","'.$file_name.'","'.$serviceno.'","'.$trans_id.'","'.$msg_id.'","'.$vsms.'","'.$retryduration.'","'.$contact_num.'")';
                               


                            $i++;
                           
                           // print_r($num_arr);
                        }

                     /*    print_r($str);*/
                        unset($refNo);
                        $query_data = array_chunk($str, 5000);

                foreach($query_data as $values) {    
                    $insert_val=implode(",",$values);           
                   echo $query_master_tbl_insert= "INSERT INTO $sendtabledetals (`id`, `created_dt`, `msgcredit`, `userid`, `status`, `route`,`msg_job_id`,`schedule_sent`,`parent_id`,`sent_at`,`cut_off`,`master_job_id`,`multimedia_id`,`file_name`,`caller_id`,`trans_id`,`message_id`,`vsms`,`retry_duration`,`mobile_number`) VALUES $insert_val";
                  
                    $rs1 = mysqli_query($dbc, $query_master_tbl_insert) or die(mysqli_error($dbc));
                    unset($insert_val);
                   // sleep(1);          
                }

                        unset($refNo);
                    }



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