<?php
session_start();
include('last_activities.php');
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
error_reporting(0);
class pushsms extends common{

    /* --- sendQuickSMSSave --- */
    function sendQuickSMSSave($userid) {
        
        global $dbc;
        ini_set('date.timezone', 'Asia/Kolkata');
        ini_set('max_execution_time', 300);
        header('Content-type: text/html; charset=utf-8');

        $u_id=$_SESSION['user_id'];
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $method=$_REQUEST['msg_format'];
        $form_type='Bulk';
        $credit_refund=0;
        $numbers = explode(",", trim(str_replace(array(' ', "\r\n", "\r", "\n"), ",",$_POST['numbers'])));
        $total_num_count=count($numbers);
        $numbers = array_unique($numbers, TRUE);
        $count_unique_num=count($numbers);
        $duplicate_count=$total_num_count-$count_unique_num;
        $num_count = array();
        $blockNum = array();
        $cut_off_data=array();
        $whitelistnum=array();
        $udh = 153;
        $SMS = 160;
        $msgcredit = 1;  

        $az_routeid = $service_name = "";
        if (isset($_POST['az_routeid'])) {
            $routedata = $_POST['az_routeid'];
            $az_routeid = trim($routedata);
            $route_time= $this->fetch_route_time($az_routeid);
             if($route_time!=1)
                {
                     return array('status' => false, 'msg' => 'Unreliable message sending time');
                    exit;
                }
            $route_name= $this->fetch_route_name($az_routeid);
            $dnd_status= $this->fetch_dnd_status($az_routeid);
            $sender_id=$_POST['sid'];
          //  $service_name=trim($routedata[1]);
            $gateway_id=$this->fetch_sender_routing($sender_id);

            if($gateway_id==0)
            {
                $planid=$this->fetch_plan($az_routeid);
                $service_name =$this->fetch_gateway_name($planid,$az_routeid);
            }
            else
            {
                $service_name =$this->fetch_gateway_name_byid($gateway_id);
            }
          
        }

         if($service_name=='')
        {
            return array('status' => false, 'msg' => 'Incorrect route selection','plan'=>$planid,'service_name'=>$service_name);
            exit;
        }

        if ($_POST['az_routeid'] == '' || $_POST['numbers'] == '' || $_POST['message'] == '') {
            return array('status' => false, 'msg' => 'EmptyField');
            exit;
        }

        foreach ($numbers as $value) {
            if (strlen(trim($value)) > 12 || strlen(trim($value)) < 10 || (strlen(trim($value)) == 11)) {
                continue;
            } else {
                if (strlen(trim($value)) == 12) {
                    $value = trim($value) - 910000000000;
                }
                if (trim($value) < 6000000000 || trim($value) > 9999999999) {
                    continue;
                }
            }
            if (!empty($value)) {
                
                $num_count[] = "$value";
                $v_num[]="+91$value";
            }
        }
        $num_count=array_unique($num_count);
        $v_num=array_unique($v_num);
        $num_split=array_chunk($num_count, 2000);
        if($dnd_status=='1')
        {
            foreach($num_split as $mob_numbers)
            {

              $dnd_num = $this->getDNDNumbers($mob_numbers);
            }

        }

        $blockNum = $this->getBlockNumbers();  
        if(!empty($blockNum))
        {
            $blockNum=array_unique($blockNum);
        }

        if(!empty($dnd_num))
        {
            $dnd_num=array_unique($dnd_num);
           
        }
       $whitelistnum = $this->getWhitelistNumbers();  

         $total_num=count($v_num);



//$random_cutoff=$this->getCutOffRandom($az_routeid);
$sql_cut_off="select `throughput`,`min_cut_value` from cut_off_dtls where userid='".$userid."' and cut_off_route='".$az_routeid."'";
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


        if($random_cutoff!=0)
        {
            /* */
            if($count_cutoff>0 && ($total_num>$min_cut_value))
            {

                $cutoff_num=$v_num;
                
                 if(!empty($whitelistnum))
                    {
                        $cutoff_num_count=count($cutoff_num);
                        $whitelistnum_count=count($whitelistnum);
                        if($whitelistnum_count>$cutoff_num_count)
                        {
                            $cutoff_num=array_diff($whitelistnum,$cutoff_num);
                        }
                        else
                        {
                            $cutoff_num=array_diff($cutoff_num,$whitelistnum);
                        }
                        
                        $cutoff_num=array_values($cutoff_num);
                    }

                 /*  return array('status' => false, 'idss'=>$cutoff_num);
                                exit;*/

                if(!empty($blockNum))
                    {
                        $cutoff_num_count=count($cutoff_num);
                        $blocknum_count=count($blockNum);

                        if($blocknum_count>$cutoff_num_count)
                        {
                            $cutoff_num=array_diff($blockNum,$cutoff_num);
                        }
                        else
                        {
                            $cutoff_num=array_diff($cutoff_num,$blockNum);
                        }
                         
                         $cutoff_num=array_values($cutoff_num);
                    }

                    if($dnd_status=='1')
                    {

                        if(!empty($dnd_num))
                        {
                            $cutoff_num_count=count($cutoff_num);
                            $dnd_num_count=count($dnd_num);
                            if($dnd_num_count>$cutoff_num_count)
                            {
                                $cutoff_num=array_diff($dnd_num,$cutoff_num);
                            }
                            else
                            {
                                $cutoff_num=array_diff($cutoff_num,$dnd_num);
                            }
                             $cutoff_num=array_values($cutoff_num);   
                        }
                    }

                    shuffle($cutoff_num); 
                    $count_cutoff_no=count($cutoff_num);
                    $sendval = ceil(($total_num * $random_cutoff)/100);
                    $count_arr_val=count($cutoff_num);
                    $count_arr=$count_arr_val-1;
                    $cut_off_data=array_slice($cutoff_num,0,$sendval);
                    $count_cutoff_data=count($cut_off_data);
                    $insert_data=array_slice($cutoff_num,$sendval,$count_arr); 
            }
        }

        $count = count($v_num);
        $msg = trim($_POST['message']);
        $key1 = 'outlook';
        $key2 = 'U/K';
        $key3 = 'United Kingdom';
        $key4 = 'outlook';
        $key5 = 'USD';
        $key6 = 'usd';
        $key7 = 'hotmail';
        if (strpos($msg, $key1) == true || strpos($msg, $key2) == true || strpos($msg, $key3) == true || strpos($msg, $key4) == true || strpos($msg, $key5) == true || strpos($msg, $key6) == true || strpos($msg, $key7) == true) {
            $isPic = true;
        }else {
            $isPic = false;
        }
        $msg = str_replace("\r\n", "\n", $msg);
        $msg = str_replace(array("\xE2\x80\x99", "\xE2\x80\x98", "\xEF\xBF\xBD"), '\'', $msg);
        $msg = str_replace(array("\xEF\x82\xA7", "\xE2\x80\x8B", "Ã¢", "\xC2\x80", "\xC2\x98", "\xC2\x99"), '', $msg);
        $msg = str_replace('“', '"', $msg);
        $msg = str_replace('”', '"', $msg);
        $msg = str_replace("amp;", "", $msg);
         $msg = str_replace('"', '\"', $msg);
         //$msg = str_replace("%", "\%", $msg);
        /* $msg = str_replace("'", "\'", $msg);*/
           /*$msg = str_replace("%", "\%", $msg);*/
        $msg_len = strlen($msg);
        /*$msg = str_replace('"', '""', $msg);*/
        if ($msg_len > $SMS) {
            $msgcredit = ceil($msg_len / $udh);
        }

        $credit = count($v_num) * $msgcredit;
        
      
        $template_id = '';

    
        $temp_id=$_POST['template'];
        $template_id=$this->fetch_template_id($temp_id);
   
        //$obj_user = new usermanagment();
        $userids = '';
       /* $userid = $_SESSION['user_id']; //Added by Azizur Rahman*/
       $userid = $_SESSION['user_id'];
            $idss = $this->getOverSeelingUserids($_SESSION['user_id']);
            
                    $ids = implode(',', $idss);
                    $userids = $ids;
                    $out = $this->checkBalance($idss, $az_routeid, $credit);
                    if($out!='')
                    {
                            if ($out == false) {
                                return array('status' => false, 'msg' => 'Parent Less Balance','out'=>$out);
                                exit;
                            }
                         else {
                            $usrcredit = $this->userCreditBalance($userid, $az_routeid);
                            if (($usrcredit <= $credit) && $credit > 0) {
                                return array('status' => false, 'msg' => 'Less Balance','user'=>$usrcredit,'credit'=>$credit,'idss'=>$idss);
                                exit;
                            }
                            $userids = $userid;
                        }
                    }
                    else
                    {
                           $usrcredit = $this->userCreditBalance($userid, $az_routeid);
                            if (($usrcredit <= $credit) && $credit > 0) {
                                return array('status' => false, 'msg' => 'Less Balance','user'=>$usrcredit,'credit'=>$credit,'idss'=>$idss);
                                exit;
                            }
                            $userids = $userid;
                    }
          

         $is_refund = 0;

        $date = date('Y-m-d H:i:s');
       
        if (isset($_POST['is_schedule']) && $_POST['is_schedule'] != '') {
            $today_time=time();
                    $date = explode(' ', $_POST['scheduleDateTime']);
                    $date1 = explode('/', $date[0]);
                    $time = $date[1] . " " . $date[2];
                    $time = date("H:i:s", strtotime($time));
                    $date2 = $date1[2] . '-' . $date1[1] . '-' . $date1[0] . " " . $time;

            $schedule_time=strtotime($date2);
            if($schedule_time<$today_time)
            {
                return array('status' => false, 'msg' => 'Back Time');
                exit;
            }

            $is_schedule = 1;
            $schedule_sent=0;
            $schdate = $this->scheduleDateTime($_POST['scheduleDateTime']);
            $req = "#1";
            $sent_at=$schdate;
            $sendtable = "az_sendmessages" . $this->getScheduleDateTimeMonth($_POST['scheduleDateTime']);
            $sendtabledetals = SENDSMSDETAILS ;
        } else {
            $is_schedule = 0;
            $schedule_sent=1;
            $sent_at=date('Y-m-d H:i:s');
            $schdate = '0000-00-00 00:00:00';
            $req = '';
            $sendtable = SENDSMS . CURRENTMONTH;
            $sendtabledetals = SENDSMSDETAILS ;
        }
 
        if (isset($_POST['sid']) && trim($_POST['checkroutetype']) == 1) {
            $sender =  $_POST['sid'];
            //$sid = trim($sender[0]);
            $sid=$_POST['sid'];
            $senderid_name = $this->fetch_sender_name($sid);
            if (isset($sender[2]) && !empty($sender[2])) {
                $service_name = trim($sender[2]);
            }
        } else {
            $senderid_name = '';
            $sid = '';
        }

         if (isset($_POST['sid']))
         {
            $sender = $_POST['sid'];
            $sid = $_POST['sid'];
            $senderid_name = $this->fetch_sender_name($sid);
         }
         else {
            $senderid_name = '';
            $sid = '';
        }
       
     
        $pe_id = '';
        $pe_id = $this->getSingleData('az_senderid', "sid = '{$sid}'", 'pe_id');
        


        mysqli_query($dbc, "START TRANSACTION");
     /*   $checklowpr = $this->getLowPriceServiceData($_SESSION['user_id'], $az_routeid);
        $isstopmsg = (isset($_SESSION['stop_sending_msg']) && $_SESSION['stop_sending_msg'] == 1) ? true : false;
        $low_service_recredit = $low_price = 0;
        $url_status = $low_service_data = NULL;
        if (isset($checklowpr['start_from']) && (count($v_num) > $checklowpr['start_from'])) {
            $low_price = 1;
            $low_service_recredit = 1;
            $low_service_data = serialize($checklowpr);
            $low_service_data = str_replace('"', '""', $low_service_data);
        }*/
        if (isset($_POST['original_url']) && !empty($_POST['original_url'])) {
            $orig_url = trim($_POST['original_url']);
            $url_status = 1;
        } else {
            $orig_url = '';
            $url_status = 0;
        }




        $campaign_id = 0;
        $campaign_name = "";
       // $campaign_type = isset($_POST['campaign_name']) && !empty($_POST['campaign_name']) ? $_POST['campaign_name'] : "";
         $campaign_name = isset($_POST['campaign_name']) && !empty($_POST['campaign_name']) ? $_POST['campaign_name'] : "";
        /*if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 16) {
            $campArr = explode('##', $campaign_type);
            $campaign_id = $campArr[0];
            $campaign_name = $campArr[1];
        } else {
            $campaign_name = $campaign_type;
        }*/
    /*    $is_flash = isset($_POST['is_flash']) && !empty($_POST['is_flash']) ? $_POST['is_flash'] : 0;*/
        $url_status = (($_POST['original_url'] != '') ? '1' : '0');
       $vsms=$_POST['vsms'];
       

            if($vsms=='vsms')
            {
               $gvsms='Yes';
            }
            else
            {
                $gvsms='No';
            }


                if($_POST['char_set']=='Text')
                {
                   $text_type=0;  
                }
                elseif($_POST['char_set']=='Unicode')
                {
                   $text_type=1;
                   /*$msg=urlencode($msg);*/
                }
      // $az_routeid='LIVE';
                $job_id=$this->random_strings(15);

        if($count_cutoff>0)
        {
            $cutstatus="Yes";
            $q = 'INSERT INTO ' . $sendtable . ' (`id`, `message`, `userid`, `campaign_id`, `is_scheduled`, `scheduled_time`, `created_at`, `updated_at`, `unicode_type`, `senderid`, `service_id`, `sms_type`, `is_refund`, `other_operator`, `request_code`, `campaign_name`, `is_picked`, `numbers_count`, `msg_credit`,  `charset`, `senderid_name`,  `original_url`, `url_status`, `pe_id`, `template_id`,`gvsms`,`ip_address`,`method`,`form_type`,`cut_off_value`,`route`,`job_id`,`schedule_sent`,`sent_at`,`cut_off`,`cut_off_throughput`,`total_cutting`) VALUES (NULL, "' . $msg . '", "' . $userid. '", "' . $campaign_id . '", "' . $is_schedule . '", "' . $schdate . '", NOW(), NOW(), "'.$text_type.'", "' . $sid . '" , "' . $az_routeid . '", "' . $_POST['send_type'] . '", ' . $is_refund . ', NULL, "", "' . $campaign_name . '", 1, "' . $count . '", "' . $msgcredit . '",  "utf-8", "' . $senderid_name . '",  "' . $_POST['original_url'] . '", ' . $url_status . ', "' . $pe_id . '", "' . $template_id . '", "' . $gvsms . '", "' . $ip_address . '"
            , "' . $method . '", "' . $form_type . '", "0","'.$route_name.'","'.$job_id.'","'.$schedule_sent.'","'.$sent_at.'","'.$cutstatus.'","'.$random_cutoff.'","'.$count_cutoff_data.'")';

             $credit_refund=$count_cutoff_data*$msgcredit;
        }
        else
        {
            $q = 'INSERT INTO ' . $sendtable . ' (`id`, `message`, `userid`, `campaign_id`, `is_scheduled`, `scheduled_time`, `created_at`, `updated_at`, `unicode_type`, `senderid`, `service_id`, `sms_type`, `is_refund`, `other_operator`, `request_code`, `campaign_name`, `is_picked`, `numbers_count`, `msg_credit`,  `charset`, `senderid_name`,  `original_url`, `url_status`, `pe_id`, `template_id`,`gvsms`,`ip_address`,`method`,`form_type`,`cut_off_value`,`route`,`job_id`,`schedule_sent`,`sent_at`) VALUES (NULL, "' . $msg . '", "' . $userid. '", "' . $campaign_id . '", "' . $is_schedule . '", "' . $schdate . '", NOW(), NOW(), "'.$text_type.'", "' . $sid . '" , "' . $az_routeid . '", "' . $_POST['send_type'] . '", ' . $is_refund . ', NULL, "", "' . $campaign_name . '", 1, "' . $count . '", "' . $msgcredit . '",  "utf-8", "' . $senderid_name . '", "' . $_POST['original_url'] . '", ' . $url_status . ', "' . $pe_id . '", "' . $template_id . '", "' . $gvsms . '", "' . $ip_address . '"
            , "' . $method . '", "' . $form_type . '", "0","'.$route_name.'","'.$job_id.'","'.$schedule_sent.'","'.$sent_at.'")';
        }
      
        mysqli_set_charset($dbc, 'utf8');
        $rs = mysqli_query($dbc, $q)or die(mysqli_error($dbc));
                //echo "<pre>"; print_r($_POST); echo "</pre>"; echo "2";exit();
        if (!$rs) {
            return array('status' => false, 'msg' => 'Failed');
        }

       
        $rId = mysqli_insert_id($dbc);
       // return array('status' => false, 'rid' => $rId);
         $parent_id=$this->fetch_parent_id($userid);


        $str = array();
        $priority = 0;
        $cntr = 0;
        $numcount = count($v_num);
        $err_code = '';
        if($_REQUEST['is_schedule']!='1')
        {
            $status   = 'Submitted';
        }
        else
        {
            $status   = 'Scheduled';
        }
        $circle = '';
        $operator = '';
        $delivered_date = '';
        $status_id      = 0;
        $subRandNo = '';
        if ($url_status == 1) {
            $subRandNo = $this->subRandomNumGen(3);
        }
        $tracking_key = ((strpos(trim($_POST['message']), TRACKINGURL) !== false) ? TRACKINGURL : '');
      $char_set=$_REQUEST['char_set'];
      $meta_data="?smpp?PEID=$pe_id&TID=$template_id";
            foreach ($v_num as $value) 
            {
                    if ($cntr == 50) {
                        $priority = 1;
                    } else if ($cntr % 50 == 0) {
                        $priority++;
                    }
                    $cntr++;
                    if ($numcount < 10) {
                        $priority = 0;
                    }
                    if ($isPic == false) {
                        $is_picked = 0;
                    } else {
                        $is_picked = 1;
                    }
                    $value = trim($value);
                    $num_count[] = "$value";
                    $num = "$value";
                      $num_without = str_replace("+91","",trim($value));
                        $num_with="$value";
                    $mob_num[]=$num;
                    if ($tracking_key != '') {
                        if (strpos($orig_url, '{mobile}') !== false) {
                            $original_url = str_replace('{mobile}', "?mobile=".$value, $orig_url);
                        } 
                        else if (strpos($orig_url, '{m}') !== false) {
                                $original_url = str_replace('{m}', "&mobile=".$value, $orig_url);
                            }
                        else {
                            $original_url = $orig_url;
                        }

                    $randNo = $this->randomNumGen(7);
                    $combRandNo = $subRandNo . '/' . $randNo;
                    $msg1 = str_replace('xyz/xxxxxxx', $combRandNo, $msg);
                    $strTrack[] = '(NULL, "' . $userid . '", "' . $rId . '", 0, "' . $num . '", "' . $subRandNo . '", "' . $randNo . '",  "' . $original_url . '",  0, NOW(),"'.$job_id.'","'.$campaign_name.'")';
                    } else {
                    $msg1 = $msg;
                    $original_url = $orig_url;
                    }

                    if ($pe_id == '') {
                        $is_picked = 1;
                        $status = 'Failed';
                        $err_code = 'PID';
                        $status_id = 2;
                    }
                    //$service_name='LIVE';
                     if(!empty($dnd_num))
                        {
                           
                                  if(in_array($num_without, $dnd_num) || in_array($num_with, $dnd_num))
                                    {
                                        $status="DND Preference";
                                    }
                                    else
                                    {
                                        if($_REQUEST['is_schedule']!='1')
                                        {
                                            $status   = 'Submitted';
                                        }
                                        else
                                        {
                                            $status   = 'Scheduled';
                                        }
                                    }
                            
                        }
                        else if(!empty($blockNum))
                        {
                           
                                 if(in_array($num_without, $blockNum) || in_array($num_with, $blockNum))
                                    {
                                        $status="Number Block";
                                    }
                                    else
                                    {
                                        if($_REQUEST['is_schedule']!='1')
                                        {
                                            $status   = 'Submitted';
                                        }
                                        else
                                        {
                                            $status   = 'Scheduled';
                                        }
                                    }
                            
                        }


                        if(!empty($cut_off_data))
                        {
                            if(in_array($num, $cut_off_data))
                                    {
                                        $cut_off_status="Yes";
                                    }
                                    else
                                    {
                                        $cut_off_status="No";
                                    }
                        }
                        else
                        {
                             $cut_off_status="No";
                        }
                 
                if($char_set=='Unicode')
                {  
                    $unicode_type=1;
                    $msgdata=rawurlencode($msg1);
                }
                else
                {
                    $unicode_type=0;
                    if(strpos($msg1, '%') !== false || strpos($msg1, "'") !== false){
                        $msg_send=$msg1;

                         $msg_send = str_replace('\"', '"', $msg_send);
                            $msgdata=rawurlencode($msg_send);
                        }
                        else
                        {

                            $msgdata=$msg1;
                        }
                }
                
                $master_job_id=$this->random_strings(20);
                $str[] = '(NULL, "' . $rId . '", "' . $msg1 . '", "'.$num.'", NOW(), "' . $senderid_name . '", "' . $service_name . '", "", "' . $is_picked . '", "' . $priority . '", "' . $is_schedule . '", "' . $schdate . '", "' . $msgcredit . '", "' . $userids . '", "' . $is_flash . '", "' . $status . '", "' . $err_code . '", "' . $status_id . '", "'.$route_name.'", "'.$msg_len.'", "'.$job_id.'", "'.$schedule_sent.'", "'.$parent_id.'", "'.$sent_at.'","'.$cut_off_status.'","'.$master_job_id.'","'.$msgdata.'","'.$unicode_type.'","'.$meta_data.'")';
            }
        

        $vsms=$_POST['vsms'];
       
            if($vsms=='vsms' && $_POST['is_schedule'] != '1')
            {
                $verified_sms=$this->vsms($v_num,$msgdata);
               
            }
           $query_data = array_chunk($str, 5000);
        if($_POST['is_schedule'] != '1')
        {
        
        get_last_activities($u_id,"Bulk SMS Send. Job Id: $job_id",@$login_date,@$logout_date);
       

        $char_set=$_REQUEST['char_set'];
        $is_schedule=$_REQUEST['is_schedule'];

        $array = array('query_data' => $query_data,'msg_job_id'=>$job_id);
        $filename="send_msg_".time().".json";
        $file_path="classes/sent_sms/".$filename;
        $fp = fopen($file_path, 'w+');
        fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
        fclose($fp);

        $new_send_file="test_sent_sms_".time().".php";
        copy("/var/www/html/controller/classes/test_sent_sms.php", "/var/www/html/controller/classes/sent_sms/".$new_send_file);
   
           exec("php /var/www/html/controller/classes/sent_sms/$new_send_file $filename > /dev/null 2>/dev/null &"); 

        /*insert into master tbl*/
        /* foreach($query_data as $values) {    
            $insert_val=implode(",",$values);
          
           $query_master_tbl_insert= "INSERT INTO $sendtabledetals (`id`, `message_id`, `msgdata`, `mobile_number`, `created_at`, `senderid`, `service_id`, `request_code`, `is_picked`, `priority`, `is_scheduled`, `scheduled_time`, `msgcredit`, `userids`, `operator_status_id`, `status`, `err_code`,`status_id`,`route`,`char_count`,`msg_job_id`,`schedule_sent`,`parent_id`,`sent_at`,`cut_off`,`master_job_id`,`send_msg`,`unicode_type`,`metadata`) VALUES $insert_val";
           unset($insert_val);
            $rs1 = mysqli_query($dbc, $query_master_tbl_insert) or die(mysqli_error($dbc));
        }

        //update job table
        if($rs1)
        {
            $update_job_tbl="update $sendtable set schedule_sent=1 where job_id='$job_id'";
            $rs_job = mysqli_query($dbc, $update_job_tbl) or die(mysqli_error($dbc));
        }*/
       
        /*insert into master tbl end*/

        /*if(!empty($dnd_num))
        {
            if(!empty($blockNum))
            {

             $pass_dtls=[$sendtabledetals,$v_num,$pe_id,$template_id,$char_set,$msg1,$senderid_name,$service_name,$is_schedule,$dnd_num,$blockNum,$cut_off_data];
            }
            else
            {
                  $pass_dtls=[$sendtabledetals,$v_num,$pe_id,$template_id,$char_set,$msg1,$senderid_name,$service_name,$is_schedule,$dnd_num,$cut_off_data];
            }
        }
        else
        {
            if(!empty($blockNum))
            {
             $pass_dtls=[$sendtabledetals,$v_num,$pe_id,$template_id,$char_set,$msg1,$senderid_name,$service_name,$is_schedule,$blockNum,$cut_off_data];
            }
            else
            {
                 $pass_dtls=[$sendtabledetals,$v_num,$pe_id,$template_id,$char_set,$msg1,$senderid_name,$service_name,$is_schedule,$cut_off_data];
            }

        }*/
       
      /*  $array = array('query_data' => $query_data,'pass_dtls' => $pass_dtls,'userid'=>$userids,'routeid'=>$az_routeid,'msg_job_id'=>$job_id,'msgcredit'=>$msgcredit,'cut_off_data'=>$cut_off_data);
        $filename="send_msg_".time().".json";
        $file_path="classes/sent_sms/".$filename;
        $fp = fopen($file_path, 'w+');
        fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
        fclose($fp);

        $new_send_file="test_sent_sms_".time().".php";
        copy("/var/www/html/controller/classes/test_sent_sms.php", "/var/www/html/controller/classes/sent_sms/".$new_send_file);
   
           exec("php /var/www/html/controller/classes/sent_sms/$new_send_file $filename > /dev/null 2>/dev/null &"); */
            

        }
        else
        {
/*
                $char_set=$_REQUEST['char_set'];
                $is_schedule=$_REQUEST['is_schedule'];
                if(!empty($dnd_num))
                {
                     $pass_dtls=[$sendtabledetals,$v_num,$pe_id,$template_id,$char_set,$msg,$senderid_name,$service_name,$is_schedule,$dnd_num,$cut_off_data];
                }
                else
                {
                     $pass_dtls=[$sendtabledetals,$v_num,$pe_id,$template_id,$char_set,$msg,$senderid_name,$service_name,$is_schedule,$cut_off_data];
                }
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
                get_last_activities($u_id,"Bulk SMS Scheduled for Date:$schdate and Job Id: $job_id",@$login_date,@$logout_date);
                $query_data = array_chunk($str, 2);
                  if($char_set=='Text')
                    {
                        $msg_send=$msg;
                       $send_sms_data=['MT',$senderid_name,$msg_send,$service_name,2,0,19,'utf8','sqlbox','0',$meta_data];
                       $text_type=0;

                       
                    }
                    else if($char_set=='Unicode')
                    {

                        $msg_send=urlencode($msg);
                       
                        $send_sms_data=['MT',$senderid_name,$msg_send,$service_name,2,2,19,'utf8','sqlbox','0',$meta_data];
                       $text_type=1;
                    }*/
/*
                    $momt=$send_sms_data[0];
                    $sender=$send_sms_data[1];
                   /* $receiver=$send_sms_data[$i][2];
                    $msgdata=$send_sms_data[2];

                    $smsc_id=$send_sms_data[3];
                    $sms_type=$send_sms_data[4];
                    $coding=$send_sms_data[5];
                    $dlr_mask=$send_sms_data[6];
                   /* $dlr_url=$send_sms_data[$i][8];
                    $charset=$send_sms_data[7];
                    $boxc_id=$send_sms_data[8];
                    $udh=$send_sms_data[9];
                    $meta_data=$send_sms_data[10];

                    $i=0;*/
                   /*  $queryInsert=array();*/
                    foreach($query_data as $values) {
                       
                        $insert_val=implode(",",$values);
                        $count_val=count($values);
                       
                      /*  $msg_arr[]=$values;*/
                        $query_master_tbl_insert= "INSERT INTO $sendtabledetals (`id`, `message_id`, `msgdata`, `mobile_number`, `created_at`, `senderid`, `service_id`, `request_code`, `is_picked`, `priority`, `is_scheduled`, `scheduled_time`, `msgcredit`, `userids`, `operator_status_id`, `status`, `err_code`,`status_id`,`route`,`char_count`,`msg_job_id`,`schedule_sent`,`parent_id`,`sent_at`,`cut_off`,`master_job_id`,`send_msg`,`unicode_type`,`metadata`) VALUES $insert_val";
                         $rs1 = mysqli_query($dbc, $query_master_tbl_insert) or die(mysqli_error($dbc));

                        /* return array('status' => true, 'msg' => 'Success','vsms'=>$verified_sms,'send_sms'=>$send_sms_status,'query_master_tbl_insert'=>$query_master_tbl_insert);
                         exit;*/
                         //$last_insert_id = mysqli_fetch_array(mysqli_query($dbc,"select LAST_INSERT_ID() as id"));

                        /* $last_id=$last_insert_id['id'];

                         $last_dlr_url=$last_id;*/
                           
                 /*       foreach($values as $val)
                        {

                            $num_send=$v_num[$i];
                            $i++;

                              $msg_arr=explode(")(",$val);
                           // print_r($msg_arr);
                            $msg=explode(', "',$msg_arr[0]);
                           
                           /*$msgdata=str_replace('"','',$msg[2]);
                           $msgdata=trim($msg[2],'"');*/
                    /*
                            if($char_set=='Unicode')
                            {
                                /*$msgdata=urldecode($msgdata);
                                
                                $msgdata=urlencode($msgdata);
                            }
                            else
                            {
                                if(strpos($msgdata, '%') !== false || strpos($msgdata, "'") !== false){
                                        $msgdata=urlencode($msgdata);
                                    }
                            }
                    */
                           
                               // $dlr_url=$last_id++;

                                /*$master_job_id=$this->random_strings(20); 
                                mysqli_query($dbc,"update az_sendnumbers set master_job_id='".$master_job_id."' where id='$dlr_url'");*/
                               // $mob_num=str_replace("+91","",trim($num_send));
                              /*   if((isset($dnd_num) && !empty($dnd_num))||(isset($blockNum) && !empty($blockNum)))
                                {
                                  
                                    if((in_array($mob_num,$dnd_num) || in_array($num_send,$dnd_num))||((in_array($num_send,$blockNum)) || (in_array($mob_num,$blockNum))))
                                        {
                                            //continue;
                                           // return array('status' => true, 'msg' => 'Schedule1','queryInsert'=>$queryInsert);
                                        }
                                        else
                                        {
                                           if((in_array($num_send,$cut_off_data)) || (in_array($mob_num,$cut_off_data))) 
                                           {
                                               // continue;
                                            // return array('status' => true, 'msg' => 'Schedule2','queryInsert'=>$queryInsert);

                                           }
                                           else
                                           {
                                            // return array('status' => true, 'msg' => 'Schedule3','queryInsert'=>$queryInsert);
                                            $receiver=$num_send;
                                               $queryInsert[]="('$momt','$sender','$receiver','$msgdata','$smsc_id',$sms_type,$coding,$dlr_mask,'$dlr_url','$charset','$boxc_id','$udh','$meta_data')";
                                           }
                                        }

                                }
                                else
                                {

                                    if(in_array($num_send,$cut_off_data)) 
                                       {

                                            //continue;
                                        // return array('status' => true, 'msg' => 'Schedule3','queryInsert'=>$queryInsert);
                                       }
                                       else
                                       {
                                            
                                            $receiver=$num_send;
                                                $queryInsert[]="('$momt','$sender','$receiver','$msgdata','$smsc_id',$sms_type,$coding,$dlr_mask,'$dlr_url','$charset','$boxc_id','$udh','$meta_data')";
                                       }
                                }*/

                         
                            //}

                        }

                    $new_send_file="run_schedule_sms_".time().".php";
                    copy("/var/www/html/controller/classes/run_schedule_sms.php", "/var/www/html/controller/classes/schedule_sms/".$new_send_file);

                    $array_schedule = array('php_file' => $new_send_file,'schedule_time' =>$schdate,'message_id' =>$job_id);
                    $schedule_filename="scheduler.json";
                    $file_path2="classes/".$schedule_filename;


                     $data_results = file_get_contents($file_path2);
                    $tempArray = json_decode($data_results);

                    //append additional json to json file
                    $tempArray[] = $array_schedule ;
                    $jsonData = json_encode($tempArray);

                    file_put_contents($file_path2, $jsonData);


                        // return array('status' => true, 'msg' => 'Schedule4','queryInsert'=>$queryInsert);
                   /* $array = array('sent_sms_insert_query' => $queryInsert,'job_id'=>$job_id);
                    $filename="send_schedule_msg_".time().".json";
                    $file_path="classes/schedule_sms/".$filename;
                    $fp = fopen($file_path, 'w+');
                    fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
                    fclose($fp);

                  
                    $new_send_file="schedule_sms_".time().".php";
                    copy("/var/www/html/controller/classes/schedule_sms.php", "/var/www/html/controller/classes/schedule_sms/".$new_send_file);
               
                   
                    $array_schedule = array('json_file' => $filename,'php_file' => $new_send_file,'schedule_time' =>$schdate,'message_id' =>$job_id);
                    $schedule_filename="scheduler.json";
                    $file_path2="classes/".$schedule_filename;


                     $data_results = file_get_contents($file_path2);
                    $tempArray = json_decode($data_results);

                    //append additional json to json file
                    $tempArray[] = $array_schedule ;
                    $jsonData = json_encode($tempArray);

                    file_put_contents($file_path2, $jsonData);   */

        }
        

/*query data 
send table and master table entry in background process*/
        if ($tracking_key != '') {
            $track_data = array_chunk($strTrack, 5000);
            foreach ($track_data as $value) {
                $tqr = "INSERT INTO `az_temp_trackingkey`(`id`, `userid`, `msgid`, `numid`, `number`, `sub_track_key`, `tracking_key`, `original_url`, `status`, `create_date`,`job_id`,`campaign_name`) VALUES " . implode(',', $value);
                $rst = mysqli_query($dbc, $tqr);
            }
        }

        /*$reupdate = mysqli_query($dbc, "UPDATE $sendtable SET  `is_picked` = 0 WHERE id = {$rId}");*/

            $rs2 = mysqli_query($dbc, "UPDATE `az_credit_manage` SET balance = (balance - $credit) WHERE userid = '{$_SESSION['user_id']}' AND az_routeid = '{$az_routeid}'")or die(mysqli_error($dbc));
 
            $this->update_adminbalance($idss,$credit,$az_routeid);

            if($credit_refund!=0)
            {

                     $ids3 = implode(',', $idss); 
                     $admin_ids_val = $ids3;
                    
                     $admin_ids=$this->fetch_admin_ids($admin_ids_val);

                $refund=$this->adminRefund($idss,$az_routeid,$credit_refund);
                $sql_insert_smart_cutoff="insert into smart_cutoff(`userid`,`created_date`,`job_id`,`msg_count`,`throughput`,`cut_off`,`percent`,`routeid`,`min_value`,`parent_id`) values('".$userid."',now(),'$job_id','$total_num','$cut_off_throughput','$credit_refund','$random_cutoff','$az_routeid','$min_cut_value','$admin_ids')";

                     $rs_insert=mysqli_query($dbc,$sql_insert_smart_cutoff);

            }
            

            /*low balance alert start*/
            $sql_settings="select s.`userid`,s.`low_bal_limit`,s.`low_bal_mobile`,sum(c.balance) as balance from settings as s join az_credit_manage as c on s.userid=c.userid where s.low_balance='Yes' and  s.userid='{$_SESSION['user_id']}'";

            $result_settings=mysqli_query($dbc,$sql_settings) or die(mysqli_error($dbc));
            $count_users=mysqli_num_rows($result_settings);

            if($count_users>0)
            {
                   while($row_settings=mysqli_fetch_array($result_settings)) 
                    {

                            $user_ids[]=$row_settings['userid'];    
                            $bal_limit[]=$row_settings['low_bal_limit'];    
                            $mobile_no[]=$row_settings['low_bal_mobile'];   
                            $current_balance[]=$row_settings['balance'];    
                    }

            if(!empty($user_ids))
            {

                for($i=0;$i<count($user_ids);$i++)
                {

                                if($current_balance[$i]<$bal_limit[$i])
                                {
                                    $sql_user="select client_name,mobile_no from az_user where userid='".$user_ids[$i]."' limit 1";

                                        $result_user=mysqli_query($dbc,$sql_user) or die(mysqli_error($dbc));
                                        $row=mysqli_fetch_array($result_user);
                                        $client_name=$row['client_name'];
                                        if($mobile_no[$i]=='' || empty($mobile_no[$i]))
                                        {
                                            $mobile_nos=$row['mobile_no'];
                                        }
                                        else
                                        {
                                            $mobile_nos= $mobile_no[$i];
                                        }
                                        
                                        $sql_credit_route="select `az_routeid`,`balance` from az_credit_manage where userid='".$user_ids[$i]."'";
                                        $result_credit_route=mysqli_query($dbc,$sql_credit_route) or die(mysqli_error($dbc));

                                        while($row_credit_route=mysqli_fetch_array($result_credit_route))
                                        {
                                                $route_id=$row_credit_route['az_routeid'];
                                                $route_name=$this->fetch_route_name($route_id);
                                                $route_bal=$row_credit_route['balance'];
                                                $route_dtls.=$route_name ."  ".$route_bal." \n";
                                                
                                        }
                                        
                                     
                                       // $route_dtlss=implode(" , ", $route_dtls);
                                       /* unset($route_name);
                                        unset($route_dtls);
                                        unset($route_bal);*/
                                        $msg="Hello $client_name , Your account balance is low .\n Please recharge your account.";
                                        $msg=$msg." ".$route_dtls;
                                        
                $msg=str_replace(' ', '%20', $msg);
                $url = "https://vapio.in/api.php?username=sam&apikey=m3Sr9ufrPDaj&senderid=MDSACC&route=TRANS&mobile=$mobile_nos&text=$msg";
                              
         
                  $ch  = curl_init($url);
                  curl_setopt($ch, CURLOPT_HTTPGET, "POST");
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                  $result = curl_exec($ch);
                 // echo $result;     

                    }
                        
                }


            }

    
                //end of alert
            }

            /*low balance alert start*/
            


        //}
        if ($rs) {
            mysqli_commit($dbc);

            return array('status' => true, 'msg' => 'Success','vsms'=>$verified_sms,'send_sms'=>$send_sms_status,'duplicate_count'=>$duplicate_count);
        } else {
            mysqli_rollback($dbc);
            return array('status' => false, 'msg' => 'Failed');
        }
    }
    /* /. --- sendQuickSMSSave --- ./ */

    function get_cut_off($userid)
    {
        global $dbc;
        $sql="select * from az_user where userid='".$userid."'";

        $result=mysqli_query($dbc,$sql);
        while($row=mysqli_fetch_array($result))
        {
            $cut_off=$row;
        }
    }

    function fetch_route_time($routeid = null) {
        global $dbc;
        $sent_time=0;
        if (!empty($routeid)) {
            $out = array();
            $q = "SELECT `start_time`,`end_time` FROM az_routetype WHERE  `az_routeid`='$routeid' and status = 1";
            $rs = mysqli_query($dbc, $q);
            $row = mysqli_fetch_assoc($rs);

            $curr_time=date('H:i');
            $start_time=date('H:i',$row['start_time']);
            $end_time=date('H:i',$row['end_time']);

            if($curr_time>=$start_time && $curr_time<=$end_time)
            {
                $sent_time=1;
            }
            else
            {
                $sent_time=0;
            }
           

            return $sent_time;
            
        } else {
            $sent_time=0;
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


    function getCutOffRandom($az_routeid)
    {
        global $dbc;
        $userid=$_SESSION['user_id'];
        $sql_cut_off="select `throughput`,`min_cut_value` from cut_off_dtls where userid='".$userid."' and cut_off_route='".$az_routeid."'";
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

            return $random_cutoff;
        }
        else
        {
            return 0;
        }
    }


       function update_adminbalance($idss,$credit,$routeid)
    {
        global $dbc;
        $ids=implode(",", $idss);
        $sql="select `user_role`,`userid` from az_user where userid in ($ids)";

        $result=mysqli_query($dbc,$sql);
        while($row=mysqli_fetch_array($result))
        {
            $user_role=$row['user_role'];
            $userid=$row['userid'];
            if($user_role=='mds_ad')
            {
                 $result = mysqli_query($dbc, "UPDATE `az_credit_manage` SET balance = (balance - $credit) WHERE userid = '{$userid}' AND az_routeid = '{$routeid}'");
            }
        }
    }



    function sendRCSSMSSave($userid) {
        
        global $dbc;
        ini_set('date.timezone', 'Asia/Kolkata');
        ini_set('max_execution_time', 300);
        header('Content-type: text/html; charset=utf-8');


        $u_id=$_SESSION['user_id'];

        $message_type=$_REQUEST['suggestion'];  
    
        if($message_type=='standalone' || $message_type=='carousel')
        {
            $card_title=implode(",",$_REQUEST['card_title']);
            $image_url=implode(",",$_REQUEST['image_url']);
            $thumbnail_url=implode(",",$_REQUEST['thumbnail_url']);
            $card_content=implode(",,",$_REQUEST['card_content']);
            $url=implode(",",$_REQUEST['web_url']);
            $dial_numbers=$_REQUEST['rich_dial_number'];

             if($dial_numbers[0]!="")
             {
                  foreach($dial_numbers as $dial)
                 {
                    $dial_no[]="+91$dial";
                 }
                 $dial_number=implode(",",$dial_no);
             }
           

            /* if($dial_number!='')
             {
                $dial_number="+91".$dial_number;
             }*/
            $url_title=implode(",",$_REQUEST['url_title']);
            $dial_title=implode(",",$_REQUEST['dial_title']);
        }
        else if($message_type=='open_url')
        {
           
            $url=$_REQUEST['open_web_url'];
            
            $url_title=$_REQUEST['open_url_title'];
           
        }
          else if($message_type=='dial')
        {
           
            $dial_title=$_REQUEST['dial_title1'];
            
            $dial_number=$_REQUEST['dial_number'];
           
        }
        else if($message_type=='location')
        {
           
           
           
        }
        $msg_title=$_REQUEST['message_title'];    
        get_last_activities($u_id,'RCS SMS Send',@$login_date,@$logout_date);
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $method=$_REQUEST['msg_format'];
        $form_type='RCS';
        $numbers = explode(",", trim(str_replace(array(' ', "\r\n", "\r", "\n"), ",",$_POST['numbers'])));
        $numbers = array_unique($numbers, TRUE);
        $num_count = array();
        $blockNum = array();
        $msgcredit = 1;  

        foreach ($numbers as $value) {
            if (strlen(trim($value)) > 12 || strlen(trim($value)) < 10 || (strlen(trim($value)) == 11)) {
                continue;
            } else {
                if (strlen(trim($value)) == 12) {
                    $value = trim($value) - 910000000000;
                }
                if (trim($value) < 6000000000 || trim($value) > 9999999999) {
                    continue;
                }
            }
            if (!empty($value)) {
                if (!empty($blockNum)) {
                    if (in_array($value, $blockNum))
                        continue;
                }
                $num_count[] = "$value";
                $v_num[]="+91$value";
            }
        }
        $count = count($num_count);
        $msg = trim($_POST['message']);
        if($message_type=='carousel')
        {
            $msg=$card_content;
        }
        $key1 = 'outlook';
        $key2 = 'U/K';
        $key3 = 'United Kingdom';
        $key4 = 'outlook';
        $key5 = 'USD';
        $key6 = 'usd';
        $key7 = 'hotmail';
        if (strpos($msg, $key1) == true || strpos($msg, $key2) == true || strpos($msg, $key3) == true || strpos($msg, $key4) == true || strpos($msg, $key5) == true || strpos($msg, $key6) == true || strpos($msg, $key7) == true) {
            $isPic = true;
        }else {
            $isPic = false;
        }
        $msg = str_replace("\r\n", "\n", $msg);
        $msg = str_replace(array("\xE2\x80\x99", "\xE2\x80\x98", "\xEF\xBF\xBD"), '\'', $msg);
        $msg = str_replace(array("\xEF\x82\xA7", "\xE2\x80\x8B", "Ã¢", "\xC2\x80", "\xC2\x98", "\xC2\x99"), '', $msg);
        $msg = str_replace('“', '"', $msg);
        $msg = str_replace('”', '"', $msg);
        $msg = str_replace("amp;", "", $msg);
        $msg = str_replace("'", "\'", $msg);
        $msg_len = strlen($msg);
        $msg = str_replace('"', '""', $msg);
        if ($msg_len > $SMS) {
            //$msgcredit = ceil($msg_len / $udh);
        }
        $credit = count($num_count) * $msgcredit;
        

        if ((isset($_SESSION['deduct']) && $_SESSION['deduct'] == 1) || (isset($_SESSION['OverSelling']) && $_SESSION['OverSelling'] == 'OverSelling')) {
            $idss = $this->getOverSeelingUserids($_SESSION['user_id']);
            $ids = implode(',', $idss);
            $userids = $ids;
            $out = $this->rcscheckBalance($idss, $credit);
            if ($out == false) {
                return array('status' => false, 'msg' => 'Parent Less Balance');
                exit;
            }
        } else {
            $usrcredit = $this->rcsuserCreditBalance($userid);
            if (($usrcredit <= $credit) && $credit > 0) {
                return array('status' => false, 'msg' => 'Less Balance','user'=>$usrcredit,'credit'=>$credit);
                exit;
            }
            $userids = $userid;
        }

          $date = date('Y-m-d H:i:s');
       
        if (isset($_POST['is_schedule']) && $_POST['is_schedule'] != '') {
            $today_time=time();
                    $date = explode(' ', $_POST['scheduleDateTime']);
                    $date1 = explode('/', $date[0]);
                    $time = $date[1] . " " . $date[2];
                    $time = date("H:i:s", strtotime($time));
                    $date2 = $date1[2] . '-' . $date1[1] . '-' . $date1[0] . " " . $time;

            $schedule_time=strtotime($date2);
            if($schedule_time<$today_time)
            {
                 return array('status' => false, 'msg' => 'Back Time');
                exit;
            }
            $is_schedule = 1;
            $schedule_sent=0;
            $schdate = $this->scheduleDateTime($_POST['scheduleDateTime']);
            $req = "#1";
            $sendtable = RCSSMS . $this->getScheduleDateTimeMonth($_POST['scheduleDateTime']);


            $rcstabledetals = RCSDETAILS ;


        } else {
            $is_schedule = 0;
             $schedule_sent=1;
            $schdate = '0000-00-00 00:00:00';
            $req = '';
            $sendtable = RCSSMS . CURRENTMONTH;
            $rcstabledetals = RCSDETAILS ;
        }

        $text_type=0;
        $job_id=$this->random_strings(15);

        if($message_type=='text')
        {
             $q = 'INSERT INTO ' . $sendtable . ' (`id`, `message`, `userid`, `is_scheduled`, `scheduled_time`, `created_at`, `updated_at`, `unicode_type`, `other_operator`, `request_code`, `campaign_name`, `is_picked`, `numbers_count`, `msg_credit`, `charset`,`ip_address`,`method`,`form_type`,`cut_off_value`,`job_id`,`message_title`,`schedule_sent`) VALUES (NULL, "' . $msg . '", "' . $u_id. '", "' . $is_schedule . '", "' . $schdate . '", NOW(), NOW(), "'.$text_type.'", NULL, "", "' . $campaign_name . '", 1, "' . $count . '", "' . $msgcredit . '", "utf-8", "' . $ip_address . '" , "' . $method . '", "' . $form_type . '", "0","'.$job_id.'","'.$msg_title.'","'.$schedule_sent.'")';

        }
        else if($message_type=='standalone' || $message_type=='carousel')
        {
             $q = 'INSERT INTO ' . $sendtable . ' (`id`, `message`, `userid`, `is_scheduled`, `scheduled_time`, `created_at`, `updated_at`, `unicode_type`, `other_operator`, `request_code`, `campaign_name`, `is_picked`, `numbers_count`, `msg_credit`, `charset`,`ip_address`,`method`,`form_type`,`cut_off_value`,`job_id`,`message_title`,`card_title`,`image_url`,`thumbnail_url`,`url`,`url_title`,`dial_number`,`dial_title`,`schedule_sent`) VALUES (NULL, "' . $msg . '", "' . $u_id. '", "' . $is_schedule . '", "' . $schdate . '", NOW(), NOW(), "'.$text_type.'", NULL, "", "' . $campaign_name . '", 1, "' . $count . '", "' . $msgcredit . '", "utf-8", "' . $ip_address . '" , "' . $method . '", "' . $form_type . '", "0","'.$job_id.'","'.$msg_title.'","'.$card_title.'","'.$image_url.'","'.$thumbnail_url.'","'.$url.'","'.$url_title.'","'.$dial_number.'","'.$dial_title.'","'.$schedule_sent.'")';

        }
          else if($message_type=='open_url')
        {
             $q = 'INSERT INTO ' . $sendtable . ' (`id`, `message`, `userid`, `is_scheduled`, `scheduled_time`, `created_at`, `updated_at`, `unicode_type`, `other_operator`, `request_code`, `campaign_name`, `is_picked`, `numbers_count`, `msg_credit`, `charset`,`ip_address`,`method`,`form_type`,`cut_off_value`,`job_id`,`message_title`,`url`,`url_title`,`schedule_sent`) VALUES (NULL, "' . $msg . '", "' . $u_id. '", "' . $is_schedule . '", "' . $schdate . '", NOW(), NOW(), "'.$text_type.'", NULL, "", "' . $campaign_name . '", 1, "' . $count . '", "' . $msgcredit . '", "utf-8", "' . $ip_address . '" , "' . $method . '", "' . $form_type . '", "0","'.$job_id.'","'.$msg_title.'","'.$url.'","'.$url_title.'","'.$schedule_sent.'")';

        }
           else if($message_type=='dial')
        {
             $q = 'INSERT INTO ' . $sendtable . ' (`id`, `message`, `userid`, `is_scheduled`, `scheduled_time`, `created_at`, `updated_at`, `unicode_type`, `other_operator`, `request_code`, `campaign_name`, `is_picked`, `numbers_count`, `msg_credit`, `charset`,`ip_address`,`method`,`form_type`,`cut_off_value`,`job_id`,`message_title`,`dial_number`,`dial_title`,`schedule_sent`) VALUES (NULL, "' . $msg . '", "' . $u_id. '", "' . $is_schedule . '", "' . $schdate . '", NOW(), NOW(), "'.$text_type.'", NULL, "", "' . $campaign_name . '", 1, "' . $count . '", "' . $msgcredit . '", "utf-8", "' . $ip_address . '" , "' . $method . '", "' . $form_type . '", "0","'.$job_id.'","'.$msg_title.'","'.$dial_number.'","'.$dial_title.'","'.$schedule_sent.'")';

        }
       
        mysqli_set_charset($dbc, 'utf8');
        $rs = mysqli_query($dbc, $q)or die(mysqli_error($dbc));
                //echo "<pre>"; print_r($_POST); echo "</pre>"; echo "2";exit();
        if (!$rs) {
            return array('status' => false, 'msg' => 'Failed');
        }
        $rId = mysqli_insert_id($dbc);



        $str = array();
        $priority = 0;
        $cntr = 0;
        $numcount = count($num_count);
        $err_code = '';
        if($_REQUEST['is_schedule']!='1')
        {
            $status   = 'Submitted';
        }
        else
        {
            $status   = 'Scheduled';
        }
       
        $circle = '';
        $operator = '';
        $delivered_date = '';
        $status_id      = 0;
        $subRandNo = '';
        /* $job_id=$this->random_strings(20);*/
        if ($url_status == 1) {
            $subRandNo = $this->subRandomNumGen(3);

        }
        $tracking_key = ((strpos(trim($_POST['message']), TRACKINGURL) !== false) ? TRACKINGURL : '');
        if (isset($checklowpr) && !empty($checklowpr)) {
            $start_from = $checklowpr['start_from'];
            $cuttingper = $checklowpr['percentage'];
            if (count($num_count) > $start_from) {
              /*  $whitelistnum = $this->getWhiteListNum($_SESSION['user_id'], $az_routeid);
*/
                $len = count($num_count);
                $remaining = 100 - $cuttingper;
                $remstart = $remlast = $remaining / 2;
                $sendIndex = ceil(($len * $remstart) / 100);
                $dropvalue = ceil(($len * $cuttingper) / 100);
              
                $endIndex = $dropvalue + $sendIndex;
            
                $x = 1;
                $persentage = $checklowpr['percentage'];
                $totnum = count($num_count);
                $per = ceil($totnum * $persentage / 100);
                $mod = ceil($totnum / $per);
                foreach ($num_count as $value) {
                    if ($tracking_key != '') {
                        if (strpos($orig_url, '{mobile}') !== false) {
                            $original_url = str_replace('{mobile}', "?mobile=".$value, $orig_url);
                        }
                        else if (strpos($orig_url, '{m}') !== false) {
                            $original_url = str_replace('{m}', "&mobile=".$value, $orig_url);
                        } else {
                            $original_url = $orig_url;
                        }

                      
                    } else {
                        $msg1 = $msg;
                        $original_url = $orig_url;
                    }
                    if ($cntr == 50) {
                        $priority = 1;
                    } else if ($cntr % 50 == 0) {
                        $priority++;
                    }
                    $cntr++;
                    if ($numcount < 10) {
                        $priority = 0;
                    }
                    $value = trim($value);
                    $num_count[] = "91$value";
                    $num = "91$value";
                    $mob_num[]=$num;

                    $master_job_id=$this->random_strings(20);
                    $str[] = '(NULL, "' . $rId . '", "' . $msg1 . '","'.$num.'", NOW(), "' . $is_schedule . '", "' . $schdate . '", "' . $msgcredit . '", "' . $u_id . '", "' . $status . '", "' . $err_code . '","'.$msg_len.'","'.$master_job_id.'","'.$job_id.'")';
                    
                    /*$str[] = '(NULL, "' . $job_id . '", NOW(),"'.$schdate.'", 0, "' . $message_type . '", "' . $num . '", "'.$msg.'",  "' . $status . '", "", "", "", "", "", "", "", "", "", "", "", "' . $msgcredit . '", "", "' . $u_id . '","' . $msg_title . '")';*/
                    $x++;
                }
            } else {
          /*      foreach ($num_count as $value) {
                    if ($tracking_key != '') {
                        if (strpos($orig_url, '{mobile}') !== false) {
                            $original_url = str_replace('{mobile}', $num, $orig_url);
                        } else {
                            $original_url = $orig_url;
                        }

                        $randNo = $this->randomNumGen(7);
                        $combRandNo = $subRandNo . '/' . $randNo;
                        $msg1 = str_replace('xyz/xxxxxxx', $combRandNo, $msg);
                        $strTrack[] = '(NULL, "' . $u_id . '", "' . $rId . '", 0, "' . $num . '", "' . $subRandNo . '", "' . $randNo . '",  "' . $original_url . '",  0, NOW())';
                    } else {
                        $msg1 = $msg;
                        $original_url = $orig_url;
                    }
                    if ($cntr == 50) {
                        $priority = 1;
                    } else if ($cntr % 50 == 0) {
                        $priority++;
                    }
                    $cntr++;
                    if ($numcount < 10) {
                        $priority = 0;
                    }
                  
                    $value = trim($value);
                    $num_count[] = "91$value";
                    $num = "91$value";
                    
                    
                    
                    $str[] = '(NULL, "' . $rId . '", "' . $msg1 . '","'.$num.'", NOW(), "' . $senderid_name . '", "' . $service_name . '", "", "' . $is_picked . '", "' . $priority . '", "' . $is_schedule . '", "' . $schdate . '", "' . $msgcredit . '", "' . $userids . '", "' . $is_flash . '","' . $status . '", "' . $err_code . '","' . $status_id . '","'.$route_name.'","'.$msg_len.'")';
                }*/
            }
        } else {
            foreach ($num_count as $value) {
                if ($cntr == 50) {
                    $priority = 1;
                } else if ($cntr % 50 == 0) {
                    $priority++;
                }
                $cntr++;
                if ($numcount < 10) {
                    $priority = 0;
                }
               
                $value = trim($value);
                $num_count[] = "91$value";
                $num = "91$value";
                $mob_num[]=$num;
                if ($tracking_key != '') {
                    if (strpos($orig_url, '{mobile}') !== false) {
                         $original_url = str_replace('{mobile}', "?mobile=".$value, $orig_url);
                    }
                    else if (strpos($orig_url, '{m}') !== false) {
                            $original_url = str_replace('{m}', "&mobile=".$value, $orig_url);
                        }
                    else {
                        $original_url = $orig_url;
                    }

                    $randNo = $this->randomNumGen(7);
                    $combRandNo = $subRandNo . '/' . $randNo;
                    $msg1 = str_replace('xyz/xxxxxxx', $combRandNo, $msg);
                    $strTrack[] = '(NULL, "' . $userid . '", "' . $rId . '", 0, "' . $num . '", "' . $subRandNo . '", "' . $randNo . '",  "' . $original_url . '",  0, NOW(),"'.$job_id.'","'.$campaign_name.'")';
                } else {
                    $msg1 = $msg;
                    $original_url = $orig_url;
                }

                
               $master_job_id=$this->random_strings(20);
                    $str[] = '(NULL, "' . $rId . '", "' . $msg1 . '","'.$num.'", NOW(), "' . $is_schedule . '", "' . $schdate . '", "' . $msgcredit . '", "' . $u_id . '", "' . $status . '", "' . $err_code . '","'.$msg_len.'","'.$master_job_id.'","'.$job_id.'")';
                
                /* $str[] = '(NULL, "' . $job_id . '", NOW(),"'.$schdate.'", 0, "' . $message_type . '", "' . $num . '", "'.$msg.'", "' . $status . '",  "", "", "", "", "", "", "", "", "", "", "", "' . $msgcredit . '", "", "' . $u_id . '","' . $msg_title . '")';*/
            }
        }

        $query_data = array_chunk($str, 5000);


        foreach($query_data as $values) {
           
            $insert_val=implode(",",$values);
            $count_val=count($values);
           
            $query_master_tbl_insert= "INSERT INTO $rcstabledetals (`id`, `message_id`, `msgdata`, `mobile_number`, `created_at`, `is_scheduled`, `scheduled_time`, `msgcredit`, `userids`, `status`, `err_code`,`char_count`,`master_job_id`,`msg_job_id`) VALUES $insert_val";
            $rs1 = mysqli_query($dbc, $query_master_tbl_insert) or die(mysqli_error($dbc));

            $last_insert_id = mysqli_fetch_array(mysqli_query($dbc,"select LAST_INSERT_ID() as id"));

            $last_id=$last_insert_id['id'];

            $i=0;
            foreach($values as $val)
            {

                $num_send=$v_num[$i];
                $i++;
               
                $dlr_url=$last_id++;
                  
                $receiver=$num_send;
                $dlr_url_arr[]=$dlr_url;
                $mob_num_arr[]=$num_send;
             
            }

        }
        

         $rs2 = mysqli_query($dbc, "UPDATE `az_credit_manage` SET balance = (balance - $credit) WHERE userid = '{$_SESSION['user_id']}'");
        if($message_type=='text')
        {
            $array = array('dlr_url_arr' => $dlr_url_arr,'mob_num_arr' => $mob_num_arr,'message_type'=>$message_type,'msg'=>$msg1);
            $filename="send_rcs_msg_".time().".json";
            $file_path="classes/rcs_messages/".$filename;
            $fp = fopen($file_path, 'w+');
            fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
            fclose($fp);

          

            $new_send_file="send_rcs_msg".time().".php";
            copy("/var/www/html/controller/classes/send_rcs_msg.php", "/var/www/html/controller/classes/rcs_messages/".$new_send_file);  
            if($_POST['is_schedule'] != '1')
              {     
                  $res=exec("php /var/www/html/controller/classes/rcs_messages/$new_send_file $filename $u_id > /dev/null 2>/dev/null & "); 
                  return array('status' => true, 'msg' => 'Success','rcs'=>$res,'send_sms'=>'rcs');
                  exit;
              }
        }
        else if($message_type=='standalone' || $message_type=='carousel')
        {
            $array = array('dlr_url_arr' => $dlr_url_arr,'mob_num_arr' => $mob_num_arr,'message_type'=>$message_type,'msg'=>$msg1,'card_title'=>$card_title,'image_url'=>$image_url,'thumbnail_url'=>$thumbnail_url,'web_url'=>$url,'url_title'=>$url_title,'dial_title'=>$dial_title,'dial_number'=>$dial_number);
            $filename="send_rcs_msg_standalone_".time().".json";
            $file_path="classes/rcs_messages/".$filename;
            $fp = fopen($file_path, 'w+');
            fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
            fclose($fp);

            $new_send_file="send_rcs_msg_standalone_".time().".php";
            copy("/var/www/html/controller/classes/send_rcs_msg_standalone.php", "/var/www/html/controller/classes/rcs_messages/".$new_send_file);  
            if($_POST['is_schedule'] != '1')
              {     
                  $res=exec("php /var/www/html/controller/classes/rcs_messages/$new_send_file $filename $u_id > /dev/null 2>/dev/null & "); 
                  return array('status' => true, 'msg' => 'Success','rcs'=>$res,'send_sms'=>'rcs');
                  exit;
              }
        }
        else if($message_type=='open_url')
        {
            $array = array('dlr_url_arr' => $dlr_url_arr,'mob_num_arr' => $mob_num_arr,'message_type'=>$message_type,'msg'=>$msg1,'web_url'=>$url,'url_title'=>$url_title);
            $filename="send_rcs_msg_open_url".time().".json";
            $file_path="classes/rcs_messages/".$filename;
            $fp = fopen($file_path, 'w+');
            fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
            fclose($fp);
            $new_send_file="send_rcs_msg_open_url".time().".php";
            copy("/var/www/html/controller/classes/send_rcs_msg_open_url.php", "/var/www/html/controller/classes/rcs_messages/".$new_send_file);  
            if($_POST['is_schedule'] != '1')
              {     
    $res=exec("php /var/www/html/controller/classes/rcs_messages/$new_send_file $filename $u_id > /dev/null 2>/dev/null & "); 
                  return array('status' => true, 'msg' => 'Success','rcs'=>$res,'send_sms'=>'rcs');
                  exit;
              }
        }
        else if($message_type=='dial')
        {
            $array = array('dlr_url_arr' => $dlr_url_arr,'mob_num_arr' => $mob_num_arr,'message_type'=>$message_type,'msg'=>$msg1,'dial_number'=>$dial_number,'dial_title'=>$dial_title);
            $filename="send_rcs_msg_dial_action".time().".json";
            $file_path="classes/rcs_messages/".$filename;
            $fp = fopen($file_path, 'w+');
            fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
            fclose($fp);

          

            $new_send_file="send_rcs_msg_dial_action".time().".php";
            copy("/var/www/html/controller/classes/send_rcs_msg_dial_action.php", "/var/www/html/controller/classes/rcs_messages/".$new_send_file);  
            if($_POST['is_schedule'] != '1')
              {     
    $res=exec("php /var/www/html/controller/classes/rcs_messages/$new_send_file $filename $u_id > /dev/null 2>/dev/null & "); 
                  return array('status' => true, 'msg' => 'Success','rcs'=>$res,'send_sms'=>'rcs');
                  exit;
              }
        }

    }

    function advCustomizeSmsSave($userid) {
        global $dbc;
        ini_set('date.timezone', 'Asia/Kolkata');
        header('Content-type: text/html; charset=utf-8');
        /*mb_internal_encoding("UTF-8");*/
        $u_id=$_SESSION['user_id'];
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $method='csv_xls_txt';
        $form_type='Dynamic';
         
        $original_msg=$_POST['message'];
        $num_count = array();
        $blockNum = array();
        $cut_off_data=array();
        $whitelistnum=array();

        $udh = 153;
        $SMS = 160;
        $msgcredit = 1;  
        $vsms=$_POST['vsms'];
            if($vsms=='vsms')
            {
               $gvsms='Yes';
            }
            else
            {
                $gvsms='No';
            }


        $az_routeid = $service_name = "";
        if (isset($_POST['az_routeid'])) {
            //$routedata = explode('<$$>', $_POST['az_routeid']);
            $routedata = $_POST['az_routeid'];
            $az_routeid = trim($routedata);
            $route_time= $this->fetch_route_time($az_routeid);
             if($route_time!=1)
                {
                     return array('status' => false, 'msg' => 'Unreliable message sending time');
                    exit;
                }
            $route_name= $this->fetch_route_name($az_routeid);
            $dnd_status= $this->fetch_dnd_status($az_routeid);
            $sender_id=$_POST['sid'];
          //  $service_name=trim($routedata[1]);
            $gateway_id=$this->fetch_sender_routing($sender_id);

            if($gateway_id==0)
            {
                 $planid=$this->fetch_plan($az_routeid);
          
                $service_name =$this->fetch_gateway_name($planid,$az_routeid);
            }
            else
            {
                $service_name =$this->fetch_gateway_name_byid($gateway_id);
            }
          
        }

        if($service_name=='')
        {
             return array('status' => false, 'msg' => 'Incorrect route selection','plan'=>$planid,'service_name'=>$service_name);
            exit;
        }

        if ($_POST['az_routeid'] == '' ||  $_POST['message'] == '' ) {
            return array('status' => false, 'msg' => 'EmptyField');
            exit;
        }

       // $blockNum = $this->getBlockNumbers();
       
        $preview = explode("*****", $_POST['txtpreview']);
        $cntr = $priority = 0;
        $date = date('Y-m-d H:i:s');
        /*if (isset($_POST['is_schedule']) && $_POST['is_schedule'] != '') {
            $is_schedule = 1;
            $schdate = $this->scheduleDateTime($_POST['scheduleDateTime']);
            $req = "#1";
            $sendtable = "az_sendmessages" . $this->getScheduleDateTimeMonth($_POST['scheduleDateTime']);
            $sendtabledetals= SENDSMSDETAILS;
        } else {
            $is_schedule = 0;
            $schdate = '0000-00-00 00:00:00';
            $req = '';
            $sendtable = SENDSMS . CURRENTMONTH;
            $sendtabledetals = SENDSMSDETAILS;
        }*/
  
    $credit = 1;
   /* $preview = array_unique($preview);*/
    
    for ($i = 0; $i < count($preview) - 1; $i++) {
            $text = explode("||", $preview[$i]);
            $msg = trim($text[1]);
            $no = trim($text[0]);
            $numbers[] = trim($text[0]);
            $messages[]=trim($text[1]);
        
        $key1 = 'outlook';
        $key2 = 'U/K';
        $key3 = 'United Kingdom';
        $key4 = 'outlook';
        $key5 = 'USD';
        $key6 = 'usd';
        $key7 = 'hotmail';
        if (strpos($msg, $key1) == true || strpos($msg, $key2) == true || strpos($msg, $key3) == true || strpos($msg, $key4) == true || strpos($msg, $key5) == true || strpos($msg, $key6) == true || strpos($msg, $key7) == true) {
            $isPic = true;
        }else {
            $isPic = false;
        }
        $msg = str_replace("\r\n", "\n", $msg);
        $msg = str_replace(array("\xE2\x80\x99", "\xE2\x80\x98", "\xEF\xBF\xBD"), '\'', $msg);
        $msg = str_replace(array("\xEF\x82\xA7", "\xE2\x80\x8B", "Ã¢", "\xC2\x80", "\xC2\x98", "\xC2\x99"), '', $msg);
        $msg = str_replace('“', '"', $msg);
        $msg = str_replace('”', '"', $msg);
        $msg = str_replace("amp;", "", $msg);
        /* $msg = str_replace("'", "\'", $msg);*/
           /*$msg = str_replace("%", "\%", $msg);*/
        $msg_len = strlen($msg);
        $msg = str_replace('"', '""', $msg);
        if ($msg_len > $SMS) {
            $credit_arr[] = ceil($msg_len / $udh);
        }else
        {
            $credit_arr[]=$credit;
        }
        $charcount_arr[]=$msg_len;
        /*if(strpos($msg, '%') !== false || strpos($msg, "'") !== false){
                $msg=urlencode($msg);
            } */
            $msgdata[] = $msg;
        }
        
        $total_credit=array_sum($credit_arr);

        if (count($numbers) == 0) {
            return array('status' => false, 'msg' => 'Select File');
            exit;
        }
        $count = count($numbers);
        $total_num_count=count($numbers);

       /* $numbers = array_unique($numbers, TRUE);*/
        $count_unique_num=count($numbers);

        $duplicate_count=$total_num_count-$count_unique_num;

         foreach ($numbers as $value) {
            if (strlen(trim($value)) > 12 || strlen(trim($value)) < 10 || (strlen(trim($value)) == 11)) {
                continue;
            } else {
                if (strlen(trim($value)) == 12) {
                    $value = trim($value) - 910000000000;
                }
                if (trim($value) < 6000000000 || trim($value) > 9999999999) {
                    continue;
                }
            }
            if (!empty($value)) {
               /* if (!empty($blockNum)) {
                    if (in_array($value, $blockNum))
                        continue;
                }*/
                $num_count[] = "$value";
                $v_num[]="+91$value";
            }
        }

        $num_count=$num_count;
        $v_num=$v_num;
        $num_split=array_chunk($num_count, 5000);
        if($dnd_status=='1')
        {
            foreach($num_split as $mob_numbers)
            {

              $dnd_num= $this->getDNDNumbers($mob_numbers);
            }

        }
        if(!empty($blockNum))
        {
            $blockNum=array_unique($blockNum);
        }

        if(!empty($dnd_num))
        {
            $dnd_num=array_unique($dnd_num);
           
        }


           $whitelistnum = $this->getWhitelistNumbers();  

         $total_num=count($v_num);

$blockNum = $this->getBlockNumbers();  

//$random_cutoff=$this->getCutOffRandom($az_routeid);
$sql_cut_off="select `throughput`,`min_cut_value` from cut_off_dtls where userid='".$userid."' and cut_off_route='".$az_routeid."'";
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


        if($random_cutoff!=0)
        {
            /* */
            if($count_cutoff>0 && ($total_num>$min_cut_value))
            {

               
               
                $cutoff_num=$v_num;
                
                 if(!empty($whitelistnum))
                    {
                        $cutoff_num_count=count($cutoff_num);
                        $whitelistnum_count=count($whitelistnum);
                        if($whitelistnum_count>$cutoff_num_count)
                        {
                            $cutoff_num=array_diff($whitelistnum,$cutoff_num);
                        }
                        else
                        {
                            $cutoff_num=array_diff($cutoff_num,$whitelistnum);
                        }
                        
                        $cutoff_num=array_values($cutoff_num);
                    }

                 /*  return array('status' => false, 'idss'=>$cutoff_num);
                                exit;*/

                if(!empty($blockNum))
                    {
                        $cutoff_num_count=count($cutoff_num);
                        $blocknum_count=count($blockNum);

                        if($blocknum_count>$cutoff_num_count)
                        {
                            $cutoff_num=array_diff($blockNum,$cutoff_num);
                        }
                        else
                        {
                            $cutoff_num=array_diff($cutoff_num,$blockNum);
                        }
                         
                         $cutoff_num=array_values($cutoff_num);
                    }

                   


                     if(!empty($dnd_num))
                    {
                        $cutoff_num_count=count($cutoff_num);
                        $dnd_num_count=count($dnd_num);
                        if($dnd_num_count>$cutoff_num_count)
                        {
                            $cutoff_num=array_diff($dnd_num,$cutoff_num);
                        }
                        else
                        {
                            $cutoff_num=array_diff($cutoff_num,$dnd_num);
                        }
                         $cutoff_num=array_values($cutoff_num);
                       
                    }



                    shuffle($cutoff_num);
                    
                    $count_cutoff_no=count($cutoff_num);
                    $sendval = ceil(($total_num * $random_cutoff)/100);
                    $count_arr_val=count($cutoff_num);
                    $count_arr=$count_arr_val-1;
                    $cut_off_data=array_slice($cutoff_num,0,$sendval);
                    $count_cutoff_data=count($cut_off_data);
                    $insert_data=array_slice($cutoff_num,$sendval,$count_arr); 
            }
        }

        $count = count($v_num);
        $template_id = '';
    
        $temp_id=$_POST['template'];
        $template_id=$this->fetch_template_id($temp_id);

        $userids = '';
        $userid = $_SESSION['user_id'];
            $idss = $this->getOverSeelingUserids($_SESSION['user_id']);
            
                    $ids = implode(',', $idss);
                    $userids = $ids;
                    $out = $this->checkBalance($idss, $az_routeid, $total_credit);
                    if($out!='')
                    {
                            if ($out == false) {
                                return array('status' => false, 'msg' => 'Parent Less Balance','out'=>$out);
                                exit;
                            }
                         else {
                            $usrcredit = $this->userCreditBalance($userid, $az_routeid);
                            if (($usrcredit <= $total_credit) && $total_credit > 0) {
                                return array('status' => false, 'msg' => 'Less Balance','user'=>$usrcredit,'credit'=>$total_credit,'idss'=>$idss);
                                exit;
                            }
                            $userids = $userid;
                        }
                    }
                    else
                    {
                           $usrcredit = $this->userCreditBalance($userid, $az_routeid);
                            if (($usrcredit <= $total_credit) && $total_credit > 0) {
                                return array('status' => false, 'msg' => 'Less Balance','user'=>$usrcredit,'credit'=>$total_credit,'idss'=>$idss);
                                exit;
                            }
                            $userids = $userid;
                    }

                     $is_refund = 0;

        $date = date('Y-m-d H:i:s');

                if (isset($_POST['is_schedule']) && $_POST['is_schedule'] != '') {
            $today_time=time();
                    $date = explode(' ', $_POST['scheduleDateTime']);
                    $date1 = explode('/', $date[0]);
                    $time = $date[1] . " " . $date[2];
                    $time = date("H:i:s", strtotime($time));
                    $date2 = $date1[2] . '-' . $date1[1] . '-' . $date1[0] . " " . $time;

            $schedule_time=strtotime($date2);
            if($schedule_time<$today_time)
            {
                return array('status' => false, 'msg' => 'Back Time');
                exit;
            }

            $is_schedule = 1;
            $schedule_sent=0;
            $schdate = $this->scheduleDateTime($_POST['scheduleDateTime']);
            $req = "#1";
            $sent_at=$schdate;
            $sendtable = "az_sendmessages" . $this->getScheduleDateTimeMonth($_POST['scheduleDateTime']);
            $sendtabledetals = SENDSMSDETAILS ;
        } else {
            $is_schedule = 0;
             $schedule_sent=1;
             $sent_at=date('Y-m-d H:i:s');
            $schdate = '0000-00-00 00:00:00';
            $req = '';
            $sendtable = SENDSMS . CURRENTMONTH;
            $sendtabledetals = SENDSMSDETAILS ;
        }
        
        if (isset($_POST['sid']) && trim($_POST['checkroutetype']) == 1) {
            $sender =  $_POST['sid'];
            //$sid = trim($sender[0]);
            $sid=$_POST['sid'];
            $senderid_name = $this->fetch_sender_name($sid);
            if (isset($sender[2]) && !empty($sender[2])) {
                $service_name = trim($sender[2]);
            }
        } else {
            $senderid_name = '';
            $sid = '';
        }

         if (isset($_POST['sid']))
         {
            $sender = $_POST['sid'];
            $sid = $_POST['sid'];
            $senderid_name = $this->fetch_sender_name($sid);
         }
         else {
            $senderid_name = '';
            $sid = '';
        }
       
     
        $pe_id = '';
        $pe_id = $this->getSingleData('az_senderid', "sid = '{$sid}'", 'pe_id');
        
           mysqli_query($dbc, "START TRANSACTION");

            if (isset($_POST['original_url']) && !empty($_POST['original_url'])) {
            $orig_url = trim($_POST['original_url']);
            $url_status = 1;
        } else {
            $orig_url = '';
            $url_status = 0;
        }
        $campaign_id = 0;
        $campaign_name = "";
       // $campaign_type = isset($_POST['campaign_name']) && !empty($_POST['campaign_name']) ? $_POST['campaign_name'] : "";
         $campaign_name = isset($_POST['campaign_name']) && !empty($_POST['campaign_name']) ? $_POST['campaign_name'] : "";


     /*   $checklowpr = $this->getLowPriceServiceData($_SESSION['user_id'], $az_routeid);
        $isstopmsg = (isset($_SESSION['stop_sending_msg']) && $_SESSION['stop_sending_msg'] == 1) ? true : false;
        $low_service_recredit = $low_price = 0;
        $url_status = $low_service_data = NULL;
        if (isset($checklowpr['start_from']) && (count($v_num) > $checklowpr['start_from'])) {
            $low_price = 1;
            $low_service_recredit = 1;
            $low_service_data = serialize($checklowpr);
            $low_service_data = str_replace('"', '""', $low_service_data);
        }
        if (isset($_POST['original_url']) && !empty($_POST['original_url'])) {
            $orig_url = trim($_POST['original_url']);
            $url_status = 1;
        } else {
            $orig_url = '';
            $url_status = 0;
        }*/
/*        $campaign_id = 0;
        $campaign_name = "";
        $campaign_type = isset($_POST['campaign_name']) && !empty($_POST['campaign_name']) ? $_POST['campaign_name'] : "";
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 16) {
            $campArr = explode('##', $campaign_type);
            $campaign_id = $campArr[0];
            $campaign_name = $campArr[1];
        } else {
            $campaign_name = $campaign_type;
        }
        $is_flash = isset($_POST['is_flash']) && !empty($_POST['is_flash']) ? $_POST['is_flash'] : 0;*/
        $url_status = (($_POST['original_url'] != '') ? '1' : '0');

        $vsms=$_POST['vsms'];
       

            if($vsms=='vsms')
            {
               $gvsms='Yes';
            }
            else
            {
                $gvsms='No';
            }


                if($_POST['char_set']=='Text')
                {
                   $text_type=0;  
                }
                elseif($_POST['char_set']=='Unicode')
                {
                   $text_type=1;
                   /*$msg=urlencode($msg);*/
                }

        
        $is_flash = isset($_POST['is_flash']) && !empty($_POST['is_flash']) ? $_POST['is_flash'] : 0;
        $job_id=$this->random_strings(15);

        /* $q = 'INSERT INTO ' . $sendtable . ' (`id`, `message`, `userid`, `campaign_id`, `is_scheduled`, `scheduled_time`, `created_at`, `updated_at`, `unicode_type`, `senderid`, `service_id`, `sms_type`, `is_refund`, `other_operator`, `request_code`, `campaign_name`, `is_picked`, `numbers_count`, `msg_credit`, `custway`, `charset`, `senderid_name`, `low_price`, `original_url`, `url_status`, `pe_id`, `template_id`,`gvsms`,`ip_address`,`method`,`form_type`,`cut_off_value`,`route`,`job_id`,`schedule_sent`,`sent_at`) VALUES (NULL, "' . $original_msg . '", "' . $userid. '", "' . $campaign_id . '", "' . $is_schedule . '", "' . $schdate . '", NOW(), NOW(), "'.$text_type.'", "' . $sid . '" , "' . $az_routeid . '", "' . $_POST['send_type'] . '", ' . $is_refund . ', NULL, "", "' . $campaign_name . '", 1, "' . $count . '", "' . $total_credit . '", ' . $is_flash . ', "utf-8", "' . $senderid_name . '", ' . $low_price . ', "' . $_POST['original_url'] . '", ' . $url_status . ', "' . $pe_id . '", "' . $template_id . '", "' . $gvsms . '", "' . $ip_address . '"
            , "' . $method . '", "' . $form_type . '", "0","'.$route_name.'","'.$job_id.'","'.$schedule_sent.'","'.$sent_at.'")';*/

     if($count_cutoff>0)
        {
            $cutstatus="Yes";
           $q = 'INSERT INTO ' . $sendtable . ' (`id`, `message`, `userid`, `campaign_id`, `is_scheduled`, `scheduled_time`, `created_at`, `updated_at`, `unicode_type`, `senderid`, `service_id`, `sms_type`, `is_refund`, `other_operator`, `request_code`, `campaign_name`, `is_picked`, `numbers_count`, `msg_credit`,  `charset`, `senderid_name`,  `original_url`, `url_status`, `pe_id`, `template_id`,`gvsms`,`ip_address`,`method`,`form_type`,`cut_off_value`,`route`,`job_id`,`schedule_sent`,`sent_at`,`cut_off`,`cut_off_throughput`,`total_cutting`) VALUES (NULL, "' . $msg . '", "' . $userid. '", "' . $campaign_id . '", "' . $is_schedule . '", "' . $schdate . '", NOW(), NOW(), "'.$text_type.'", "' . $sid . '" , "' . $az_routeid . '", "' . $_POST['send_type'] . '", ' . $is_refund . ', NULL, "", "' . $campaign_name . '", 1, "' . $count . '", "' . $msgcredit . '",  "utf-8", "' . $senderid_name . '",  "' . $orig_url . '", ' . $url_status . ', "' . $pe_id . '", "' . $template_id . '", "' . $gvsms . '", "' . $ip_address . '"
            , "' . $method . '", "' . $form_type . '", "0","'.$route_name.'","'.$job_id.'","'.$schedule_sent.'","'.$sent_at.'","'.$cutstatus.'","'.$random_cutoff.'","'.$count_cutoff_data.'")';


             $credit_refund=$count_cutoff_data*$msgcredit;
        }
        else
        {
           $q = 'INSERT INTO ' . $sendtable . ' (`id`, `message`, `userid`, `campaign_id`, `is_scheduled`, `scheduled_time`, `created_at`, `updated_at`, `unicode_type`, `senderid`, `service_id`, `sms_type`, `is_refund`, `other_operator`, `request_code`, `campaign_name`, `is_picked`, `numbers_count`, `msg_credit`,  `charset`, `senderid_name`,  `original_url`, `url_status`, `pe_id`, `template_id`,`gvsms`,`ip_address`,`method`,`form_type`,`cut_off_value`,`route`,`job_id`,`schedule_sent`,`sent_at`) VALUES (NULL, "' . $msg . '", "' . $userid. '", "' . $campaign_id . '", "' . $is_schedule . '", "' . $schdate . '", NOW(), NOW(), "'.$text_type.'", "' . $sid . '" , "' . $az_routeid . '", "' . $_POST['send_type'] . '", ' . $is_refund . ', NULL, "", "' . $campaign_name . '", 1, "' . $count . '", "' . $msgcredit . '",  "utf-8", "' . $senderid_name . '", "' . $orig_url . '", ' . $url_status . ', "' . $pe_id . '", "' . $template_id . '", "' . $gvsms . '", "' . $ip_address . '"
            , "' . $method . '", "' . $form_type . '", "0","'.$route_name.'","'.$job_id.'","'.$schedule_sent.'","'.$sent_at.'")';
        }
        mysqli_set_charset($dbc, 'utf8');
        $rs = mysqli_query($dbc, $q)or die(mysqli_error($dbc));
                //echo "<pre>"; print_r($_POST); echo "</pre>"; echo "2";exit();
        if (!$rs) {
            return array('status' => false, 'msg' => 'Failed');
        }


        $rId = mysqli_insert_id($dbc);
       // return array('status' => false, 'rid' => $rId);
         $parent_id=$this->fetch_parent_id($userid);


        $str = array();
        $priority = 0;
        $cntr = 0;
        $numcount = count($v_num);
        $err_code = '';

        
       if($_REQUEST['is_schedule']!='1')
        {
            $status   = 'Submitted';
        }
        else
        {
            $status   = 'Scheduled';
        }
        $circle = '';
        $operator = '';
        $delivered_date = '';
        $status_id      = 0;
        $subRandNo = '';
        if ($url_status == 1) {
            $subRandNo = $this->subRandomNumGen(3);
        }

        $tracking_key = ((strpos(trim($_POST['message']), TRACKINGURL) !== false) ? TRACKINGURL : '');
        $char_set=$_REQUEST['char_set'];
        $meta_data="?smpp?PEID=$pe_id&TID=$template_id";

            $c=0;
            foreach ($v_num as $value) {
                 $msg=$msgdata[$c];
                 $msgcredit=$credit_arr[$c];
                 $msg_len=$charcount_arr[$c];
                 $c++;
                if ($cntr == 50) {
                    $priority = 1;
                } else if ($cntr % 50 == 0) {
                    $priority++;
                }
                $cntr++;
                if ($numcount < 10) {
                    $priority = 0;
                }
                if ($isPic == false) {
                    $is_picked = 0;
                } else {
                    $is_picked = 1;
                }
                $value = trim($value);
                $num_count[] = "$value";
                $num = "$value";
                $mob_num[]=$num;
                if ($tracking_key != '') {
                    if (strpos($orig_url, '{mobile}') !== false) {
                         $original_url = str_replace('{mobile}', "?mobile=".$value, $orig_url);
                    }
                    else if (strpos($orig_url, '{m}') !== false) {
                            $original_url = str_replace('{m}', "&mobile=".$value, $orig_url);
                        } else {
                        $original_url = $orig_url;
                    }

                    $randNo = $this->randomNumGen(7);
                    $combRandNo = $subRandNo . '/' . $randNo;
                    $msg1 = str_replace('xyz/xxxxxxx', $combRandNo, $msg);
                    $strTrack[] = '(NULL, "' . $userid . '", "' . $rId . '", 0, "' . $num . '", "' . $subRandNo . '", "' . $randNo . '",  "' . $original_url . '",  0, NOW(),"'.$job_id.'","'.$campaign_name.'")';
                } else {
                    $msg1 = $msg;
                    $original_url = $orig_url;
                }

                if ($pe_id == '') {
                    $is_picked = 1;
                    $status = 'Failed';
                    $err_code = 'PID';
                    $status_id = 2;
                }
                //$service_name='LIVE';
                 if(!empty($dnd_num))
                    {
                       
                             if(in_array($num, $dnd_num))
                                {
                                    $status="DND Preference";
                                }
                                else
                                {
                                    if($_REQUEST['is_schedule']!='1')
                                    {
                                        $status   = 'Submitted';
                                    }
                                    else
                                    {
                                        $status   = 'Scheduled';
                                    }
                                }
                        
                    }

                         if(!empty($blockNum))
                    {
                       
                             if(in_array($num, $blockNum))
                                {
                                    $status="Number Block";
                                }
                                else
                                {
                                    if($_REQUEST['is_schedule']!='1')
                                    {
                                        $status   = 'Submitted';
                                    }
                                    else
                                    {
                                        $status   = 'Scheduled';
                                    }
                                }
                        
                    }

                     if(!empty($cut_off_data))
                    {
                        if(in_array($num, $cut_off_data))
                                {
                                    $cut_off_status="Yes";
                                }
                                else
                                {
                                    $cut_off_status="No";
                                }
                    }
                    else
                    {
                         $cut_off_status="No";
                    }


                if($char_set=='Unicode')
                {  
                    $unicode_type=1;
                    $send_msg=rawurlencode($msg1);
                }
                else
                {
                    $unicode_type=0;
                    if(strpos($msg1, '%') !== false || strpos($msg1, "'") !== false){
                        $msg_send=$msg1;

                         $msg_send = str_replace('\"', '"', $msg_send);
                            $send_msg=rawurlencode($msg_send);
                           // $send_msg=rawurlencode($msg1);
                        }
                        else
                        {
                            $send_msg=$msg1;
                        }
                }
                
                $master_job_id=$this->random_strings(20);
                
                $str[] = '(NULL, "' . $rId . '", "' . $msg1 . '", "'.$num.'", NOW(), "' . $senderid_name . '", "' . $service_name . '", "", "' . $is_picked . '", "' . $priority . '", "' . $is_schedule . '", "' . $schdate . '", "' . $msgcredit . '", "' . $userids . '", "' . $is_flash . '", "' . $status . '", "' . $err_code . '", "' . $status_id . '", "'.$route_name.'", "'.$msg_len.'", "'.$job_id.'", "'.$schedule_sent.'", "'.$parent_id.'", "'.$sent_at.'","'.$cut_off_status.'","'.$master_job_id.'","'.$send_msg.'","'.$unicode_type.'","'.$meta_data.'")';
            }
        

        $vsms=$_POST['vsms'];
       
            if($vsms=='vsms' && $_POST['is_schedule'] != '1')
            {
                $verified_sms=$this->vsms_dynamic($v_num,$messages);
               
            }


         if($_POST['is_schedule'] != '1')
        {
        
        get_last_activities($u_id,"Dynamic SMS Send. Job Id: $job_id",@$login_date,@$logout_date);
        $query_data = array_chunk($str, 5000);
        $char_set=$_REQUEST['char_set'];
        $is_schedule=$_REQUEST['is_schedule'];

     /*   if(!empty($dnd_num))
        {
            if(!empty($blockNum))
            {

             $pass_dtls=[$sendtabledetals,$v_num,$pe_id,$template_id,$char_set,$msg1,$senderid_name,$service_name,$is_schedule,$dnd_num,$blockNum,$cut_off_data];
            }
            else
            {
                  $pass_dtls=[$sendtabledetals,$v_num,$pe_id,$template_id,$char_set,$msg1,$senderid_name,$service_name,$is_schedule,$dnd_num,$cut_off_data];
            }
        }
        else
        {
            if(!empty($blockNum))
            {
             $pass_dtls=[$sendtabledetals,$v_num,$pe_id,$template_id,$char_set,$msg1,$senderid_name,$service_name,$is_schedule,$blockNum,$cut_off_data];
            }
            else
            {
                 $pass_dtls=[$sendtabledetals,$v_num,$pe_id,$template_id,$char_set,$msg1,$senderid_name,$service_name,$is_schedule,$cut_off_data];
            }

        }*/
        /*$pass_dtls=[$sendtabledetals,$v_num,$pe_id,$template_id,$char_set,$msg,$senderid_name,$service_name,$is_schedule];*/

           $array = array('query_data' => $query_data,'msg_job_id'=>$job_id);
        $filename="send_msg_".time().".json";
        $file_path="classes/sent_sms/".$filename;
        $fp = fopen($file_path, 'w+');
        fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
        fclose($fp);

        $new_send_file="test_sent_sms_".time().".php";
        copy("/var/www/html/controller/classes/test_sent_sms.php", "/var/www/html/controller/classes/sent_sms/".$new_send_file);
   
           exec("php /var/www/html/controller/classes/sent_sms/$new_send_file $filename > /dev/null 2>/dev/null &"); 


       /* $array = array('query_data' => $query_data,'pass_dtls' => $pass_dtls,'userid'=>$userids,'routeid'=>$az_routeid,'msg_job_id'=>$job_id,'msgcredit'=>$total_credit,'cut_off_data'=>$cut_off_data);
        $filename="send_msg_".time().".json";
        $file_path="classes/sent_sms/".$filename;
        $fp = fopen($file_path, 'w+');
        fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
        fclose($fp);

        $new_send_file="test_sent_sms_".time().".php";
        copy("/var/www/html/controller/classes/test_sent_sms.php", "/var/www/html/controller/classes/sent_sms/".$new_send_file);
   /* $output=shell_exec("ls -l & exec php /var/www/html/controller/classes/test_sent_sms.php $filename > /dev/null 2>&1 & echo $ ");
           exec("php /var/www/html/controller/classes/sent_sms/$new_send_file $filename > /dev/null 2>/dev/null &"); */
            //$output=exec("nohup php /var/www/html/controller/classes/$new_send_file $filename &> /dev/null &");

        }
        else
        {

        $char_set=$_REQUEST['char_set'];
        $is_schedule=$_REQUEST['is_schedule'];
         /* if(!empty($dnd_num))
            {
                 $pass_dtls=[$sendtabledetals,$v_num,$pe_id,$template_id,$char_set,$msg,$senderid_name,$service_name,$is_schedule,$dnd_num,$cut_off_data];
            }
            else
            {
                 $pass_dtls=[$sendtabledetals,$v_num,$pe_id,$template_id,$char_set,$msg,$senderid_name,$service_name,$is_schedule,$cut_off_data];
            }
                $sendtabledetals=$pass_dtls[0];  
                $v_num=$pass_dtls[1]; 
                $pe_id=$pass_dtls[2]; 
                $template_id=$pass_dtls[3];        
                $char_set=$pass_dtls[4]; 
                $msg=$pass_dtls[5]; 
                $senderid_name=$pass_dtls[6]; 
                $service_name=$pass_dtls[7]; 
                $is_schedule=$pass_dtls[8]; 
                $meta_data="?smpp?PEID=$pe_id&TID=$template_id";*/
            get_last_activities($u_id,"Dynamic SMS Scheduled for Date:$schdate and Job Id: $job_id",@$login_date,@$logout_date);
             $query_data = array_chunk($str, 5000);
            /*  if($char_set=='Text')
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
                }*/

        /*    $momt=$send_sms_data[0];
            $sender=$send_sms_data[1];
           /* $receiver=$send_sms_data[$i][2];
            $msgdata=$send_sms_data[2];

            $smsc_id=$send_sms_data[3];
            $sms_type=$send_sms_data[4];
            $coding=$send_sms_data[5];
            $dlr_mask=$send_sms_data[6];
           /* $dlr_url=$send_sms_data[$i][8];
            $charset=$send_sms_data[7];
            $boxc_id=$send_sms_data[8];
            $udh=$send_sms_data[9];
            $meta_data=$send_sms_data[10];*/

             $i=0;
        foreach($query_data as $values) {
           
            $insert_val=implode(",",$values);
            $count_val=count($values);
            
            $query_master_tbl_insert= "INSERT INTO $sendtabledetals (`id`, `message_id`, `msgdata`, `mobile_number`, `created_at`, `senderid`, `service_id`, `request_code`, `is_picked`, `priority`, `is_scheduled`, `scheduled_time`, `msgcredit`, `userids`, `operator_status_id`, `status`, `err_code`,`status_id`,`route`,`char_count`,`msg_job_id`,`schedule_sent`,`parent_id`,`sent_at`,`cut_off`,`master_job_id`,`send_msg`,`unicode_type`,`metadata`) VALUES $insert_val";
            $rs1 = mysqli_query($dbc, $query_master_tbl_insert) or die(mysqli_error($dbc));

/*
             $last_insert_id = mysqli_fetch_array(mysqli_query($dbc,"select LAST_INSERT_ID() as id"));

             $last_id=$last_insert_id['id'];

             $last_dlr_url=$last_id;
               */
            /*
            */

                /*$num_send=$v_num[$i];
                $i++;
               */
                 // $msg_arr=explode(")(",$val);
               // print_r($msg_arr);
                //$msg=explode(', "',$msg_arr[0]);
               
              /* $msgdata=str_replace('"','',$msg[2]);*/
             // $msgdata=trim($msg[2],'"');
/*
               
                            if($char_set=='Unicode')
                            {
                                /*$msgdata=urldecode($msgdata);
                                
                                $msgdata=urlencode($msgdata);
                            }
                            else
                            {
                                if(strpos($msgdata, '%') !== false || strpos($msgdata, "'") !== false){
                                        $msgdata=urlencode($msgdata);
                                    }
                            }
                    $dlr_url=$last_id++;

                    $master_job_id=$this->random_strings(20); 
                    mysqli_query($dbc,"update az_sendnumbers set master_job_id='".$master_job_id."' where id='$dlr_url'");*/
/*
                 if(!empty($dnd_num))
                {
                    if(in_array($num_send,$dnd_num))
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
                     $receiver=$num_send;
                    $queryInsert[]="('$momt','$sender','$receiver','$msgdata','$smsc_id',$sms_type,$coding,$dlr_mask,'$dlr_url','$charset','$boxc_id','$udh','$meta_data')";
                }*/


             /*    if((isset($dnd_num)&&!empty($dnd_num))||(isset($blockNum)&&!empty($blockNum)))
                {
                    if((in_array($num_send,$dnd_num))||(in_array($num_send,$blockNum)))
                    {
                        //continue;
                    }
                    else
                    {
                       if(in_array($num_send,$cut_off_data)) 
                       {
                           // continue;

                       }
                       else
                       {
                            $receiver=$num_send;
                           $queryInsert[]="('$momt','$sender','$receiver','$msgdata','$smsc_id',$sms_type,$coding,$dlr_mask,'$dlr_url','$charset','$boxc_id','$udh','$meta_data')";
                       }
                    }
                }*/
               /* else
                {

                    if(in_array($num_send,$cut_off_data)) 
                       {

                            //continue;
                       }
                       else
                       {
                            $receiver=$num_send;
                                $queryInsert[]="('$momt','$sender','$receiver','$msgdata','$smsc_id',$sms_type,$coding,$dlr_mask,'$dlr_url','$charset','$boxc_id','$udh','$meta_data')";
                       }
                }*/
             
           // }

        }


        
                    $new_send_file="run_schedule_sms_".time().".php";
                    copy("/var/www/html/controller/classes/run_schedule_sms.php", "/var/www/html/controller/classes/schedule_sms/".$new_send_file);

                    $array_schedule = array('php_file' => $new_send_file,'schedule_time' =>$schdate,'message_id' =>$job_id);
                    $schedule_filename="scheduler.json";
                    $file_path2="classes/".$schedule_filename;


                     $data_results = file_get_contents($file_path2);
                    $tempArray = json_decode($data_results);

                    //append additional json to json file
                    $tempArray[] = $array_schedule ;
                    $jsonData = json_encode($tempArray);

                    file_put_contents($file_path2, $jsonData);

       /* $array = array('sent_sms_insert_query' => $queryInsert,'job_id'=>$job_id);
        $filename="send_schedule_msg_".time().".json";
        $file_path="classes/schedule_sms/".$filename;
        $fp = fopen($file_path, 'w+');
        fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
        fclose($fp);

      
        $new_send_file="schedule_sms_".time().".php";
        copy("/var/www/html/controller/classes/schedule_sms.php", "/var/www/html/controller/classes/schedule_sms/".$new_send_file);
        $array_schedule = array('json_file' => $filename,'php_file' => $new_send_file,'schedule_time' =>$schdate,'message_id' =>$job_id);
        $schedule_filename="scheduler.json";
        $file_path2="classes/".$schedule_filename;


         $data_results = file_get_contents($file_path2);
        $tempArray = json_decode($data_results);

        //append additional json to json file
        $tempArray[] = $array_schedule ;
        $jsonData = json_encode($tempArray);

        file_put_contents($file_path2, $jsonData);   

*/        }

        if ($tracking_key != '') {
            $track_data = array_chunk($strTrack, 5000);
            foreach ($track_data as $value) {
                $tqr = "INSERT INTO `az_temp_trackingkey`(`id`, `userid`, `msgid`, `numid`, `number`, `sub_track_key`, `tracking_key`, `original_url`, `status`, `create_date`,`job_id`,`campaign_name`) VALUES " . implode(',', $value);
                $rst = mysqli_query($dbc, $tqr);
            }
        }

          $reupdate = mysqli_query($dbc, "UPDATE $sendtable SET  `is_picked` = 0 WHERE id = {$rId}");
         
            $rs2 = mysqli_query($dbc, "UPDATE `az_credit_manage` SET balance = (balance - $total_credit) WHERE userid = '{$_SESSION['user_id']}' AND az_routeid = '{$az_routeid}'")or die(mysqli_error($dbc));
 
            $this->update_adminbalance($idss,$credit,$az_routeid);
            /*low balance alert start*/

 

            if($credit_refund!=0)
            {

                     $ids3 = implode(',', $idss); 
                     $admin_ids_val = $ids3;
                    
                     $admin_ids=$this->fetch_admin_ids($admin_ids_val);

                $refund=$this->adminRefund($idss,$az_routeid,$credit_refund);
                $sql_insert_smart_cutoff="insert into smart_cutoff(`userid`,`created_date`,`job_id`,`msg_count`,`throughput`,`cut_off`,`percent`,`routeid`,`min_value`,`parent_id`) values('".$userid."',now(),'$job_id','$total_num','$cut_off_throughput','$credit_refund','$random_cutoff','$az_routeid','$min_cut_value','$admin_ids')";

                     $rs_insert=mysqli_query($dbc,$sql_insert_smart_cutoff);

            }

            $sql_settings="select s.`userid`,s.`low_bal_limit`,s.`low_bal_mobile`,sum(c.balance) as balance from settings as s join az_credit_manage as c on s.userid=c.userid where s.low_balance='Yes' and  s.userid='{$_SESSION['user_id']}'";

            $result_settings=mysqli_query($dbc,$sql_settings) or die(mysqli_error($dbc));
            $count_users=mysqli_num_rows($result_settings);


            if($count_users>0)
            {
                   while($row_settings=mysqli_fetch_array($result_settings)) 
                    {

                            $user_ids[]=$row_settings['userid'];    
                            $bal_limit[]=$row_settings['low_bal_limit'];    
                            $mobile_no[]=$row_settings['low_bal_mobile'];   
                            $current_balance[]=$row_settings['balance'];    
                    }

            if(!empty($user_ids))
            {

                for($i=0;$i<count($user_ids);$i++)
                {

                                if($current_balance[$i]<$bal_limit[$i])
                                {
                                    $sql_user="select client_name,mobile_no from az_user where userid='".$user_ids[$i]."' limit 1";

                                        $result_user=mysqli_query($dbc,$sql_user) or die(mysqli_error($dbc));
                                        $row=mysqli_fetch_array($result_user);
                                        $client_name=$row['client_name'];
                                        if($mobile_no[$i]=='' || empty($mobile_no[$i]))
                                        {
                                            $mobile_nos=$row['mobile_no'];
                                        }
                                        else
                                        {
                                            $mobile_nos= $mobile_no[$i];
                                        }
                                        
                                        $sql_credit_route="select `az_routeid`,`balance` from az_credit_manage where userid='".$user_ids[$i]."'";
                                        $result_credit_route=mysqli_query($dbc,$sql_credit_route) or die(mysqli_error($dbc));

                                        while($row_credit_route=mysqli_fetch_array($result_credit_route))
                                        {
                                                $route_id=$row_credit_route['az_routeid'];
                                                $route_name=$this->fetch_route_name($route_id);
                                                $route_bal=$row_credit_route['balance'];
                                                $route_dtls.=$route_name ."  ".$route_bal." \n";
                                                
                                        }
                                        
                                     
                                       // $route_dtlss=implode(" , ", $route_dtls);
                                       /* unset($route_name);
                                        unset($route_dtls);
                                        unset($route_bal);*/
                                        $msg="Hello $client_name , Your account balance is low .\n Please recharge your account.";
                                        $msg=$msg." ".$route_dtls;
                                        
                $msg=str_replace(' ', '%20', $msg);
                $url = "https://vapio.in/api.php?username=sam&apikey=m3Sr9ufrPDaj&senderid=MDSACC&route=TRANS&mobile=$mobile_nos&text=$msg";
                              
         
                  $ch  = curl_init($url);
                  curl_setopt($ch, CURLOPT_HTTPGET, "POST");
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                  $result = curl_exec($ch);
                 // echo $result;


                                }
                        
                }


            }

    
                //end of alert
            }


              if ($rs) {
            mysqli_commit($dbc);

            return array('status' => true, 'msg' => 'Success','vsms'=>$verified_sms,'send_sms'=>$send_sms_status,'duplicate_count'=>$duplicate_count);
        } else {
            mysqli_rollback($dbc);
            return array('status' => false, 'msg' => 'Failed');
        }
    }


    
/*     function userCreditBalance($userid, $routeid) {
        global $dbc;
        $qry = "SELECT total_balance as Balance FROM `az_balance` WHERE userid = '{$userid}' AND routeid = '{$routeid}'";
        $rs = mysqli_query($dbc, $qry);
        $out = 0;
        if (mysqli_num_rows($rs)) {
            $row = mysqli_fetch_assoc($rs);
            $out = $row['Balance'];
            return $out;
        }
        return $out;
    }*/

function fetch_plan($routeid)
{
    global $dbc;

   $sql="select `pid` from az_plan_assign where userid='".$_SESSION['user_id']."' ";
    $result=mysqli_query($dbc,$sql) or die(mysqli_error($dbc));
    $count=mysqli_num_rows($result);

    if($count>0)
    {
            while($row=mysqli_fetch_array($result))
            {
                $pid=$row['pid'];

                return $pid;
            }
    }
    else
    {
        return 0;
    }

}


function fetch_sender_routing($sender_id)
{
    global $dbc;
    $userid=$_SESSION['user_id'];
   $sql="select gateway_id from sender_routing where userid='".$userid."' and  sender_id='".$sender_id."'";
    $result=mysqli_query($dbc,$sql) or die(mysqli_error($dbc));
    $count=mysqli_num_rows($result);

    if($count>0)
    {
            while($row=mysqli_fetch_array($result))
            {
                $gateway_id=$row['gateway_id'];

                return $gateway_id;
            }
    }
    else
    {
        return 0;
    }

}

function fetch_sender_name($sid)
{
    global $dbc;

    $sql="select `senderid` from az_senderid where sid='".$sid."' limit 1";
    $result=mysqli_query($dbc,$sql);
    $count=mysqli_num_rows($result);

    if($count>0)
    {
            while($row=mysqli_fetch_array($result))
            {
                $sender_name=$row['senderid'];

                return $sender_name;
            }
    }
    else
    {
        return '';
    }

}


    function userCreditBalance($userid, $routeid) {
        global $dbc;
                 $qry = "SELECT `balance` as Balance FROM `az_credit_manage` WHERE userid = '$userid'  and az_routeid='$routeid'";
                $rs = mysqli_query($dbc, $qry);
                $out = 0;
                if (mysqli_num_rows($rs)) {
                    $row = mysqli_fetch_assoc($rs);
                    $out = $row['Balance'];
                    return $out;
                }
                return $out;  
    }


        function rcsuserCreditBalance($userid) {
        global $dbc;
         $qry = "SELECT `balance` as Balance FROM `az_credit_manage` WHERE userid = '$userid' and az_routeid='5' ";
        $rs = mysqli_query($dbc, $qry);
        $out = 0;
        if (mysqli_num_rows($rs)) {
            $row = mysqli_fetch_assoc($rs);
            $out = $row['Balance'];
            return $out;
        }
        return $out;
    }

        // global $dbc;
        // ini_set('date.timezone', 'Asia/Kolkata');
        // header('Content-type: text/html; charset=utf-8');
        // mb_internal_encoding("UTF-8");
        
        // if ($_SESSION['token'] != $_POST['token']) {
        //     unset($_POST);
        //     return array('status' => false, 'msg' => 'InvalidToken');
        //     exit();
        // }
        
        // $preview = explode("*****", $_POST['txtpreview']);
        // $cntr = $priority = 0;
        // $date = date('Y-m-d H:i:s');
        // if (isset($_POST['is_schedule']) && $_POST['is_schedule'] != '') {
        //     $is_schedule = 1;
        //     $schdate = $this->scheduleDateTime($_POST['scheduleDateTime']);
        //     $req = "#1";
        //     $sendtable = "az_sendmessages" . $this->getScheduleDateTimeMonth($_POST['scheduleDateTime']);
        //     $sendtabledetals = "az_sendnumbers" . $this->getScheduleDateTimeMonth($_POST['scheduleDateTime']);
        // } else {
        //     $is_schedule = 0;
        //     $schdate = '0000-00-00 00:00:00';
        //     $req = '';
        //     $sendtable = SENDSMS . CURRENTMONTH;
        //     $sendtabledetals = SENDSMSDETAILS . CURRENTMONTH;
        // }
        /* if(isset($_POST['is_schedule']) && $_POST['is_schedule'] != '' ) {
          $is_schedule = 1;
          $schdate = $this->scheduleDateTime($_POST['scheduleDateTime']);
          $req = "#1";
          } else {
          $is_schedule = 0;
          $schdate ='';
          $req = "";
          } */
        // $creditval = $qry = $qrynum = $requestcodeArr = $num_count = array();
        // $blockNum = array();
        // if (isset($_SESSION['BlockNum']) && $_SESSION['BlockNum'] == 'BlockNum') {
        //     $blockNum = $this->getBlockNumbers();
        // }


        // for ($i = 0; $i < count($preview) - 1; $i++) {
        //     $text = explode("||", $preview[$i]);
        //     $sms = trim($text[1]);
        //     $no = trim($text[0]);
        //     if ((strlen($no) == 10) and ( is_numeric($no))) {
        //         $sms = trim($sms);
        //         $sms = str_replace("\r\n", "\n", $sms);
        //         $sms = str_replace(array("\xE2\x80\x99", "\xE2\x80\x98"), '\'', $sms);
        //         $sms = str_replace("amp;", "", $sms);
        //         $sms = str_replace('"', '""', $sms);


        //         $credit = 1;
        //         if (strlen($sms) != strlen(utf8_decode($sms))){
        //             $msg_len = mb_strlen($sms);
        //             if ($msg_len > 70) {
        //                 $credit = ceil($msg_len / 67);
        //             }
        //             $unicode_type = 2;
        //         }else{
        //             $msg_len = strlen($sms);
        //             if ($msg_len > 160) {
        //                 $credit = ceil($msg_len / 153);
        //             }
        //             $unicode_type = 0;
        //         }
        //         $tbl = substr($no, 0, 3);
        //         if ($tbl >= 700 && $tbl <= 999) {
        //             if (!empty($blockNum)) {
        //                 if (in_array($no, $blockNum))
        //                     continue;
        //             }
        //             $creditval[] = $credit;
        //             $msgdata[] = $sms;
        //             $num_count[] = "91$no";
        //             $unicode_typeArr[] = $unicode_type;
        //         }
        //     }
        // }
        // if (count($num_count) == 0) {
        //     return array('status' => false, 'msg' => 'Select File');
        //     exit;
        // }
        // $count = count($num_count);
        // $crval = array_sum($creditval);
        // $az_routeid = $service_name = "";
        // if (isset($_POST['az_routeid'])) {
        //     $routedata = explode('<$$>', $_POST['az_routeid']);
        //     $az_routeid = trim($routedata[0]);
        //     $service_name = trim($routedata[1]);
        // }
        // $userids = '';
        // $obj_user = new usermanagment();
        // if ((isset($_SESSION['deduct']) && $_SESSION['deduct'] == 1) || (isset($_SESSION['OverSelling']) && $_SESSION['OverSelling'] == 'OverSelling')) {
        //     $idss = $this->getOverSeelingUserids($_SESSION['user_id']);
        //     $ids = implode(',', $idss);
        //     $userids = $ids . '-' . $az_routeid;
        //     $out = $this->checkBalance($idss, $az_routeid, $crval);
        //     if ($out == false) {
        //         return array('status' => false, 'msg' => 'Parent Less Balance');
        //         exit;
        //     }
        // } else {
        //     $usrcredit = $obj_user->userCreditBalance($_SESSION['user_id'], $az_routeid);
        //     if (($usrcredit <= $crval) && $crval > 0) {
        //         return array('status' => false, 'msg' => 'Less Balance');
        //         exit;
        //     }
        //     $userids = $_SESSION['user_id'] . '-' . $az_routeid;
        // }
        // if (isset($_SESSION['DND_OR_NOT']) && $_SESSION['DND_OR_NOT'] == 'DND_OR_NOT') {
        //     $is_refund = 1;
        // } else {
        //     $is_refund = 0;
        // }
        // if (isset($_POST['sid']) && trim($_POST['checkroutetype']) == 1) {
        //     $sender = explode('<$>', $_POST['sid']);
        //     $sid = trim($sender[0]);
        //     $senderid_name = trim($sender[1]);
        //     if (isset($sender[2]) && !empty($sender[2])) {
        //         $service_name = trim($sender[2]);
        //     }
        // } else {
        //     $senderid_name = '';
        //     $sid = '';
        // }
        
        // //Added by Azizur Rahman for template verification
        // $template_id = '';
        // if (! $_SESSION['OpenTemplate']) {
        //     $template_msg = str_replace('""', '"', $msgdata[0]);
        //     $check_template = $this->checkTemplate($_SESSION['user_id'], $template_msg);

        //     if ($check_template['status']) {
        //         $template_id = $check_template['template_id'];
        //     } else {
        //         return array('status' => false, 'msg' => 'Template mismatch');
        //         exit();
        //     }
        // }
        
        // //Added by Azizur Rahman for getting PE_ID 
        // $pe_id = '';
        // $pe_id = $this->getSingleData('az_senderid', "sid = '{$sid}'", 'pe_id');
        
        // $low_price = 0;
        // $campaign_id = "";
        // $campaign_name = "";
        // $campaign_type = isset($_POST['campaign_name']) && !empty($_POST['campaign_name']) ? $_POST['campaign_name'] : "";
        // $checklowpr = $this->getLowPriceServiceData($_SESSION['user_id'], $az_routeid);
        // if (isset($checklowpr['start_from']) && (count($num_count) > $checklowpr['start_from'])) {
        //     $low_price = 1;
        //     $low_service_recredit = 1;
        //     $low_service_data = serialize($checklowpr);
        //     $low_service_data = str_replace('"', '""', $low_service_data);
        // }

        // if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 16) {
        //     $compArr = explode('##', $campaign_type);
        //     $campaign_id = $compArr[0];
        //     $campaign_name = $compArr[1];
        // } else {
        //     $campaign_name = $campaign_type;
        // }
        // $is_flash = isset($_POST['is_flash']) && !empty($_POST['is_flash']) ? $_POST['is_flash'] : 0;
        // $q = 'INSERT INTO ' . $sendtable . ' (`id`, `message`, `userid`, `campaign_id`, `is_scheduled`, `scheduled_time`, `created_at`, `updated_at`, `is_queue`, `unicode_type`, `senderid`, `service_id`, `sms_type`, `is_refund`, `other_operator`, `request_code`, `campaign_name`, `is_picked`, `numbers_count`, `msg_credit`, `custway`, `charset`, `senderid_name`, `low_price`, `pe_id`, `template_id`) VALUES (NULL, "Personalize SMS", "' . $_SESSION['user_id'] . '", "' . $campaign_id . '", "' . $is_schedule . '", "' . $schdate . '", NOW(), NOW(), "0", "0", "' . $sid . '" , "' . $az_routeid . '", "' . $_POST['send_type'] . '", ' . $is_refund . ', NULL, "", "' . $campaign_name . '", "1", "' . $count . '", "' . $crval . '", ' . $is_flash . ', "utf-8", "' . $senderid_name . '", ' . $low_price . ', "' . $pe_id . '", "' . $template_id . '")';
        // mysqli_set_charset($dbc, 'utf8');
        // $rs = mysqli_query($dbc, $q);
        // $rId = mysqli_insert_id($dbc);
        // $numcount = count($num_count);
        
        // $err_code = '';
        // $status   = 'Submitted'; 
        // $status_id = 0;
        
        // if (isset($checklowpr) && !empty($checklowpr)) {
        //     $start_from = $checklowpr['start_from'];
        //     $cuttingper = $checklowpr['percentage'];
        //     if (count($num_count) > $start_from) {
        //         $len = count($num_count);
        //         $remaining = 100 - $cuttingper;
        //         $remstart = $remlast = $remaining / 2;
        //         $sendIndex = ceil(($len * $remstart) / 100);
        //         $dropvalue = ceil(($len * $cuttingper) / 100);
        //         //$ssendArray = array_slice($num_count, 0, $sendval);
        //         //$dropArray = array_slice($num_count, $sendval, $dropvalue);
        //         $endIndex = $dropvalue + $sendIndex;
        //         //$esendArray = array_slice($num_count, $endfrom, $len);
        //         $x = 1;
        //         $persentage = $checklowpr['percentage'];
        //         $totnum = count($num_count);
        //         $per = ceil($totnum * $persentage / 100);
        //         $mod = ceil($totnum / $per);
        //         foreach ($num_count as $key => $num) {
        //             if ($cntr == 50) {
        //                 $priority = 1;
        //             } else if ($cntr % 100 == 0) {
        //                 $priority++;
        //             }
        //             $cntr++;
        //             if ($numcount < 10) {
        //                 $priority = 0;
        //             }

        //             if (isset($_SESSION['stop_sending_msg']) && $_SESSION['stop_sending_msg'] == 1) {
        //                 $is_picked = 5;
        //             } else {
        //                 if ($x % $mod == 0) {
        //                     $is_picked = 3;
        //                 } else {
        //                     $is_picked = 0;
        //                 }
        //             }

        //             $msg = $msgdata[$key];
        //             $credit = $creditval[$key];
        //             $unicode_type = $unicode_typeArr[$key];
                    
        //             if ($pe_id == '') {
        //                 $is_picked = 1;
        //                 $status = 'Failed';
        //                 $err_code = 'PID';
        //                 $status_id = 2;
        //             }
                    
        //             $qry[] = '(NULL, "' . $rId . '", "' . $msg . '", "' . $num . '", NOW(), "' . $senderid_name . '", "' . $service_name . '", "", "' . $is_picked . '", "' . $priority . '", "' . $is_schedule . '", "' . $schdate . '", "' . $credit . '", "' . $userids . '", "' . $is_flash . '", "'.$unicode_type.'", "' . $status . '", "' . $err_code . '","' . $status_id . '")';
        //             $x++;
        //         }
        //     } else {
        //         foreach ($num_count as $key => $num) {
        //             if ($cntr == 50) {
        //                 $priority = 1;
        //             } else if ($cntr % 100 == 0) {
        //                 $priority++;
        //             }
        //             $cntr++;
        //             if ($numcount < 10) {
        //                 $priority = 0;
        //             }

        //             if (isset($_SESSION['stop_sending_msg']) && $_SESSION['stop_sending_msg'] == 1) {
        //                 $is_picked = 5;
        //             } else {
        //                 $is_picked = 0;
        //             }
        //             $msg = $msgdata[$key];
        //             $credit = $creditval[$key];
        //             $unicode_type = $unicode_typeArr[$key];
                    
        //             if ($pe_id == '') {
        //                 $is_picked = 1;
        //                 $status = 'Failed';
        //                 $err_code = 'PID';
        //                 $status_id = 2;
        //             }
                    
        //             $qry[] = '(NULL, "' . $rId . '", "' . $msg . '", "' . $num . '", NOW(), "' . $senderid_name . '", "' . $service_name . '", "", "' . $is_picked . '", "' . $priority . '", "' . $is_schedule . '", "' . $schdate . '", "' . $credit . '", "' . $userids . '", "' . $is_flash . '", "'.$unicode_type.'", "' . $status . '", "' . $err_code . '","' . $status_id . '")';
        //         }
        //     }
        // } else {
        //     foreach ($num_count as $key => $num) {

        //         $num = 

        //         if ($cntr == 50) {
        //             $priority = 1;
        //         } else if ($cntr % 100 == 0) {
        //             $priority++;
        //         }
        //         $cntr++;
        //         if ($numcount < 10) {
        //             $priority = 0;
        //         }

        //         if (isset($_SESSION['stop_sending_msg']) && $_SESSION['stop_sending_msg'] == 1) {
        //             $is_picked = 5;
        //         } else {
        //             $is_picked = 0;
        //         }
        //         $msg = $msgdata[$key];
        //         $credit = $creditval[$key];
        //         $unicode_type = $unicode_typeArr[$key];
                
        //         if ($pe_id == '') {
        //             $is_picked = 1;
        //             $status = 'Failed';
        //             $err_code = 'PID';
        //             $status_id = 2;
        //         }
                
        //         $qry[] = '(NULL, "' . $rId . '", "' . $msg . '", "' . $num . '", NOW(), "' . $senderid_name . '", "' . $service_name . '", "", "' . $is_picked . '", "' . $priority . '", "' . $is_schedule . '", "' . $schdate . '", "' . $credit . '", "' . $userids . '", "' . $is_flash . '", "'.$unicode_type.'", "' . $status . '", "' . $err_code . '","' . $status_id . '","'.$az_routeid.'")';
        //     }
        // }
        // $query_data = array_chunk($qry, 2000);
        // $rs1 = $rs2 = false;
        // foreach ($query_data as $values) {
        //     $rs1 = mysqli_query($dbc, "INSERT INTO $sendtabledetals (`id`, `message_id`, `msgdata`, `mobile_number`, `created_at`, `senderid`, `service_id`, `request_code`, `is_picked`, `priority`, `is_scheduled`, `scheduled_time`, `msgcredit`, `userids`, `operator_status_id`, `unicode_type`,`status`, `err_code`,`status_id`,`route`) VALUES " . implode(',', $values));
        //     mysqli_set_charset($dbc, 'utf8');
        // }

        // $reupdate = mysqli_query($dbc, "UPDATE $sendtable SET  `is_picked` = 0 WHERE id = {$rId}");

        // if ($rs1) {
        //     if ((isset($_SESSION['deduct']) && $_SESSION['deduct'] == 1) || (isset($_SESSION['OverSelling']) && $_SESSION['OverSelling'] == 'OverSelling')) {
        //         $rs2 = mysqli_query($dbc, "UPDATE `az_balance` SET total_balance = (total_balance - $crval) WHERE userid IN($ids) AND routeid = '{$az_routeid}'");
        //     } else {
        //         $rs2 = mysqli_query($dbc, "UPDATE `az_balance` SET total_balance = (total_balance - $crval) WHERE userid = '{$_SESSION['user_id']}' AND routeid = '{$az_routeid}'");
        //     }
        //     if ($rs2) {
        //         mysqli_commit($dbc);
        //         return array('status' => true, 'msg' => 'Success');
        //     } else {
        //         mysqli_rollback($dbc);
        //         return array('status' => false, 'msg' => 'Failed');
        //     }
        // } else {
        //     return array('status' => false, 'msg' => 'Failed');
        // }
    // }
    /* /.--- advCustomizeSmsSave ---./ */

    function utf8_to_unicode($str) {
        $unicode = array();
        $values = array();
        $lookingFor = 1;
        for ($i = 0; $i < strlen($str); $i++) {
            $thisValue = ord($str[$i]);
            if ($thisValue < 128) {
                $number = dechex($thisValue);
                $unicode[] = (strlen($number) == 1) ? '%u000' . $number : "%u00" . $number;
            } else {
                if (count($values) == 0)
                    $lookingFor = ( $thisValue < 224 ) ? 2 : 3;
                $values[] = $thisValue;
                if (count($values) == $lookingFor) {
                    $number = ( $lookingFor == 3 ) ?
                            ( ( $values[0] % 16 ) * 4096 ) + ( ( $values[1] % 64 ) * 64 ) + ( $values[2] % 64 ) :
                            ( ( $values[0] % 32 ) * 64 ) + ( $values[1] % 64
                            );
                    $number = dechex($number);
                    $unicode[] = (strlen($number) == 3) ? "%u0" . $number : "%u" . $number;
                    $values = array();
                    $lookingFor = 1;
                } // if
            } // if
        }
        return implode("", $unicode);
    }

     //Added by Azizur Rahman for template verification
    function checkTemplate($userid = null, $message = null) {
        global $dbc;
        if (!empty($userid) && !empty($message)) {
            $qry = "SELECT REPLACE(REPLACE(template_data, '\r', ''), '\n', 'PRTss1bKuIj2lJMW') AS template_data, `pe_id`, `template_id` FROM `az_template` WHERE `userid` = {$userid};";
            $res = mysqli_query($dbc, $qry);
            if (mysqli_num_rows($res)) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $template = trim($row['template_data']);
                    $template = str_replace(array("&#039;", "&amp;", "&gt;", "&lt;", "&quot;", "/", "+"), array("'", "&", "<", ">", '"', "b", 'b'), $template);
                    $template = str_replace(array('.', '?', '$', '^', '!', '[', ']', '(', ')', '*', '-', '+', '=', '|', '/', '<', '>'), 'b', $template);
                    $template = preg_replace('/\s+/', ' ', preg_replace('/{#(.*?)#}/', '(.{0,30})', $template));
                    $template = str_replace(array('(.{0,30}) (.{0,30})'), '(.{0,30})(.{0,30})', $template);
                    $template = str_replace('PRTss1bKuIj2lJMW', '(.{0,1})', $template);

                    $template = str_replace(array('(.{0,30})(.{0,30})(.{0,30})(.{0,30})(.{0,30})(.{0,30})(.{0,30})(.{0,30})', '(.{0,30})(.{0,30})(.{0,30})(.{0,30})(.{0,30})(.{0,30})(.{0,30})', '(.{0,30})(.{0,30})(.{0,30})(.{0,30})(.{0,30})(.{0,30})', '(.{0,30})(.{0,30})(.{0,30})(.{0,30})(.{0,30})', '(.{0,30})(.{0,30})(.{0,30})(.{0,30})', '(.{0,30})(.{0,30})(.{0,30})', '(.{0,30})(.{0,30})'), array('(.{0,240})', '(.{0,210})', '(.{0,180})', '(.{0,150})', '(.{0,120})', '(.{0,90})', '(.{0,60})'), $template);
                    $template = trim($template);

                    $message = trim($message);
                    $message = str_replace(' \n', '', $message);
                    $message = str_replace('\n', '', $message);
                    $message = str_replace(array('.', '?', '$', '^', '!', '[', ']', '(', ')', '*', '-', '+', '=', '|', '/', '<', '>'), 'b', $message);
                    $message = preg_replace('/\s+/', ' ', $message);
                    $message = trim($message);

                    //echo "Template: ".$template."<br>Message: ".$message."<br><br>"; die;

                    $regexMatched = (bool) preg_match("/^" . $template . "$/mi", $message, $matches);

                    if ($regexMatched) {
                        return array("status" => true, "pe_id" => $row['pe_id'], "template_id" => $row['template_id']);
                        exit();
                    }
                }
                // die;
            }
        }
        return array("status" => false, "pe_id" => "", "template_id" => "");
        exit();
    }
    
    function getGroupList() {
        global $dbc;
        $out = array();
        //echo $_SESSION['user_id'];
        $q = "SELECT g_id, g_name  FROM az_group  WHERE userid = {$_SESSION['user_id']} ORDER BY g_name ASC";
        $rs = mysqli_query($dbc, $q);
        if (mysqli_num_rows($rs) > 0) {
            while ($row = mysqli_fetch_assoc($rs)) {
                $id = $row['g_id'];
                $qry = "SELECT COUNT(gcl_id) as totnum FROM az_group_contactlist WHERE g_id = $id";
                $rs1 = mysqli_query($dbc, $qry);
                $row1 = mysqli_fetch_assoc($rs1);
                $out[$id]['g_id'] = $row['g_id'];
                $out[$id]['g_name'] = $row['g_name'];
                $out[$id]['totnum'] = $row1['totnum'];
            }
        }
        return $out;
    }

    function getGroupNumber($gids) {
        global $dbc;
        if (!empty($gids)) {
            $gids = rtrim($gids, ',');
        } else {
            $gids = 0;
        }
        $out = array();
        $q = "SELECT cont_number  FROM az_group_contactlist WHERE g_id IN($gids)";
        $rs = mysqli_query($dbc, $q);
        while ($row = mysqli_fetch_assoc($rs)) {
            $out[]['cont_number'] = $row['cont_number'];
        }
        return $out;
    }

    function getGroupNumbers($gid) {
        global $dbc;
        $out = array();
        $q = "SELECT gcl_id, cont_name, cont_number FROM az_group_contactlist WHERE g_id = $gid";
        $rs = mysqli_query($dbc, $q);
        while ($row = mysqli_fetch_assoc($rs)) {
            $id = $row['gcl_id'];
            $out[$id] = $row;
        }
        return $out;
    }

    function getSenderId() {
        global $dbc;
        $out = array();
        $q = "SELECT sid, senderid, is_default, gatewayid FROM az_senderid WHERE userid = {$_SESSION['user_id']} AND status = 1 ORDER BY senderid ASC";
        $rs = mysqli_query($dbc, $q);
        while ($row = mysqli_fetch_assoc($rs)) {
            $id = $row['sid'];
            $out[$id] = $row;
        }
        return $out;
    }

    function getSenderIdName($sid = null) {
        global $dbc;
        if (!empty($sid)) {
            $out = array();
            $q = "SELECT sid, senderid, is_default FROM az_senderid WHERE userid = {$_SESSION['user_id']} AND status = 1 AND sid = {$sid}";
            $rs = mysqli_query($dbc, $q);
            $row = mysqli_fetch_assoc($rs);
            return $row['senderid'];
        } else {
            return '';
        }
    }

        function fetch_gateway_name($planid=null,$routeid = null) {
        global $dbc;
        if (!empty($routeid)) {
            $out = array();
            $q = "SELECT `gateway_id` FROM az_route_plan WHERE  `plan_id`='$planid' and `route_id`='$routeid' and rp_status = 1";
            $rs = mysqli_query($dbc, $q);
            $row = mysqli_fetch_assoc($rs);

            $gatewayid=$row['gateway_id'];

            if(!empty($gatewayid))
            {
                 $q = "SELECT `smsc_id` FROM az_sms_gateway WHERE gateway_id='$gatewayid'";
                $rs = mysqli_query($dbc, $q);
                $row = mysqli_fetch_assoc($rs);

                $gateway_name=$row['smsc_id'];
                return $gateway_name;
            }
            
        } else {
            return '';
        }
    }

       function fetch_gateway_name_byid($gateway_id=null) {
        global $dbc;

          
                 $q = "SELECT `smsc_id` FROM az_sms_gateway WHERE gateway_id='$gateway_id'";
                $rs = mysqli_query($dbc, $q);
                $row = mysqli_fetch_assoc($rs);

                $gateway_name=$row['smsc_id'];
                return $gateway_name;
            
        
    }


     function fetch_route_name($routeid = null) {
        global $dbc;
        if (!empty($routeid)) {
    
            $q = "SELECT `az_rname` FROM az_routetype WHERE `az_routeid`='".$routeid."' and status = 1";
            $rs = mysqli_query($dbc, $q);
           while($row = mysqli_fetch_assoc($rs))
           {
                $route_name=$row['az_rname'];
           }

            return $route_name;
            
        } else {
            return '';
        }
    }


     function fetch_dnd_status($routeid = null) {
        global $dbc;
        if (!empty($routeid)) {
            $out = array();
            $q = "SELECT `dnd_enable` FROM az_routetype WHERE  `az_routeid`='$routeid' and status = 1";
            $rs = mysqli_query($dbc, $q);
            $row = mysqli_fetch_assoc($rs);

            $dnd_enable=$row['dnd_enable'];

            return $dnd_enable;
            
        } else {
            return '';
        }
    }


    function setAaDefault($sid) {
        global $dbc;
        $rs = mysqli_query($dbc, "UPDATE  az_senderid set is_default = 0 WHERE userid = {$_SESSION['user_id']}");
        $rs1 = mysqli_query($dbc, "UPDATE  az_senderid set is_default = $sid WHERE sid = $sid AND userid = {$_SESSION['user_id']}");
        if ($rs1) {
            return true;
        } else {
            return false;
        }
    }
    
    function getLowPriceServiceData($userid = null, $routeid = null) {
        global $dbc;
        $cond = "WHERE 1 ";
        if (isset($_POST['userid']) && !empty($_POST['userid'])) {
            $cond .= " AND userid = {$_POST['userid']}";
        }
        if (isset($userid) && !empty($userid)) {
            $cond .= " AND userid = {$userid}";
        }
        if (isset($routeid) && !empty($routeid)) {
            $cond .= " AND routeid = {$routeid}";
        }
        $qry = "SELECT `id`, `parent_id`, `userid`, `current_level`, `level_of_assign_user`, `routeid`, `is_low`, `start_from`, `low_price_per` FROM `az_low_price` $cond ORDER BY level_of_assign_user ASC";
        $rs = mysqli_query($dbc, $qry);
        $out = $start_from = array();
        $per = 0;
        $count = mysqli_num_rows($rs);
        if (mysqli_num_rows($rs) > 0) {
            $r_percal = 100;
            $i = 1;
            static $a, $c;
            while ($rows = mysqli_fetch_assoc($rs)) {
                $start_from[] = $rows['start_from'];
                if ($rows['is_low'] == 1) {
                    if ($i == 1) {
                        $a = $rows['low_price_per'];
                        $b = 100 - $a;
                        $c = $b;
                    } else {
                        $b = ($b * $rows['low_price_per']) / 100;
                        $c = $c - $b;
                        $b = $c;
                    }
                    $per += $rows['low_price_per'];
                    $userwiseper[$rows['parent_id']] = $rows['low_price_per'];
                }
                $i++;
            }
            $perdrop = ceil(100 - $c);
            $out = array('start_from' => min($start_from), 'percentage' => $perdrop, 'userwiseper' => $userwiseper);
        }
        return $out;
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

    function getWhiteListNum($userid = null, $routeid = null) {
        global $dbc;
        $cond = "WHERE 1 ";
        if (!empty($userid) && !empty($routeid)) {
            $cond .= " AND userid = {$userid}";
            //$cond .= " OR is_global = 1";
            $qry = "SELECT `numbers` FROM `az_whilelabel_nums` $cond";
            $rs = mysqli_query($dbc, $qry);
            $out = array();
            if (mysqli_num_rows($rs) > 0) {
                while ($rows = mysqli_fetch_assoc($rs)) {
                    $out[] = $rows['numbers'];
                }
            }
            return $out;
        }
    }


    function vsms($num_count,$msg)
    {
        $user_id=$_SESSION['user_id'];
        $msg=urldecode($msg);
        $array = array('mobile_number' => $num_count,'msg' => $msg);
        $filename="vsms.json";
        $file_path="vsms.json";
        $fp = fopen($filename, 'w+');
        fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
        fclose($fp);


       $pyout = exec("/var/www/html/python-venv/bin/python /var/www/html/controller/vsms/create_hashes_example.py $filename $user_id >> /var/www/html/controller/vsms/test_vsms.log");
        return $pyout;
    }


    function vsms_dynamic($num_count,$msg)
    {
        $user_id=$_SESSION['user_id'];
       // $msg=urldecode($msg);
        $array = array('mobile_number' => $num_count,'msg' => $msg);
        $filename="vsms".time().".json";
        $file_path="vsms".time().".json";
        $fp = fopen($filename, 'w+');
        fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
        fclose($fp);


       $pyout = exec("/var/www/html/python-venv/bin/python /var/www/html/controller/vsms/create_hashes_example1.py $filename $user_id >> /var/www/html/controller/vsms/test_vsms.log");
        return $pyout;
    }


    function send_rcs_msg($num_count,$msg,$message_type)
    {
        global $dbc;
        $array = array('mobile_number' => $num_count,'msg' => $msg);
       
        //$filename="rcs_send_msg_".time().".json";
        $filename="/var/www/html/rcs_send_sms1.json";
        $file_path="rcs/".$filename;
        $fp = fopen($filename, 'w+');
        
        fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
        fclose($fp);
        
        if($message_type=='text')
        {

         $pyout = exec("/var/www/html/python-venv/bin/python /var/www/html/rcs/send_simple_text.py rcs_send_sms1.json", $outp, $return);
        }
        else if($message_type=='standalone' || $message_type=='carousel')
        {
        $pyout = exec("/var/www/html/python-venv/bin/python /var/www/html/rcs/rich_card.py rcs_send_sms1.json", $outp, $return);
        }
        return $pyout;
   
       
    }
    
    function checkRoute($id) {
        global $dbc;
        $output = array();
        $qry = "SELECT az_issenderid FROM az_routetype WHERE az_routeid = '{$id}'";
        $response = mysqli_query($dbc, $qry);
        $row = mysqli_fetch_assoc($response);
        if ($row['az_issenderid'] != 0 && $row['az_issenderid'] != '') {
            return 1;
        } else {
            return 0;
        }
    }

    public function scheduleDateTime($datetime) {
        global $dbc;
        $date = explode(' ', $datetime);
        $date1 = explode('/', $date[0]);
        $time = $date[1] . " " . $date[2];
        $time = date("H:i:s", strtotime($time));
        $date2 = $date1[2] . '-' . $date1[1] . '-' . $date1[0] . " " . $time;
        //$new_time = date("Y-m-d H:i:s", strtotime($date2.'+28 minute'));
        //$new_time1 = date("Y-m-d H:i:s", strtotime($new_time.'+4 hours'));
        return $date2;
    }

    function pre($value) {
        if (is_array($value)) {
            echo'<pre>';
            print_r($value);
            echo'</pre>';
        } else {
            die('<strong>pre function</strong> takes an <strong>array as argument</strong> the value it got is <b>' . $value . '</b>');
        }
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
                    return $this->getOverSeelingUserids($rows['parent_id']);
                } else {
                    if ($userid == $rows['userid']) {
                        $ids[] = $rows['userid'];
                        return $this->getOverSeelingUserids($rows['parent_id']);
                    }
                }
            }
        } else {
            return $ids;
        }
    }
/*
    function checkBalance($userid, $routeid, $credit) {
        global $dbc;
        if (!empty($userid)) {
            $ids = trim(implode(',', $userid));
            $qry = "SELECT SUM(total_balance) balance, routeid FROM `az_balance` WHERE userid IN($ids) AND `routeid` = $routeid  GROUP BY userid";
            $rs = mysqli_query($dbc, $qry);
            if (mysqli_num_rows($rs) > 0) {
                while ($rows = mysqli_fetch_assoc($rs)) {
                    $usrcredit = $rows['balance'];
                    if (($usrcredit <= $credit) && $credit > 0) {
                        return false;
                    }
                }
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }*/


    function checkBalance($userid, $routeid, $credit) {
        global $dbc;
        if (!empty($userid)) {
            $ids = trim(implode(',', $userid));

            $sql_user="select userid from az_user where userid in ($ids) and user_role='mds_ad'";
            $result_user=mysqli_query($dbc,$sql_user);
            while($row_user=mysqli_fetch_array($result_user))
            {
                $ids1[]=$row_user['userid'];
            }

            $ids2=trim(implode(',', $ids1));
            $qry = "SELECT SUM(balance) balance, az_routeid FROM `az_credit_manage` WHERE userid IN($ids2) AND `az_routeid` = $routeid  GROUP BY userid";
            $rs = mysqli_query($dbc, $qry);
            if (mysqli_num_rows($rs) > 0) {
                while ($rows = mysqli_fetch_assoc($rs)) {
                    $usrcredit = $rows['balance'];
                    if (($usrcredit <= $credit) && $credit > 0) {
                        return false;
                    }
                }
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


        function rcscheckBalance($userid, $credit) {
        global $dbc;
        if (!empty($userid)) {
            $ids = trim(implode(',', $userid));
            $qry = "SELECT SUM(balance) balance FROM `az_credit_manage` WHERE userid IN($ids)  GROUP BY userid";
            $rs = mysqli_query($dbc, $qry);
            if (mysqli_num_rows($rs) > 0) {
                while ($rows = mysqli_fetch_assoc($rs)) {
                    $usrcredit = $rows['balance'];
                    if (($usrcredit <= $credit) && $credit > 0) {
                        return false;
                    }
                }
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function getBlockNumbers() {
        global $dbc;
        $userid=$_SESSION['user_id'];
        $q = "SELECT `numbers` FROM `az_blocknumbers` where ((userid='$userid')||(userid='-1')) and status=0";
        $rs = mysqli_query($dbc, $q);
        $numbers = array();
        if (mysqli_num_rows($rs)) {
            while ($row = mysqli_fetch_assoc($rs)) {
                $numbers[] = $row['numbers'];
            }
        }
        return $numbers;
    }



        function getWhitelistNumbers() {
        global $dbc;
        $userid=$_SESSION['user_id'];
        $q = "SELECT numbers FROM `az_blocknumbers` where userid='$userid' and status=1";
        $rs = mysqli_query($dbc, $q);
        $numbers = array();
        if (mysqli_num_rows($rs)) {
            while ($row = mysqli_fetch_assoc($rs)) {
                $numbers[] = $row['numbers'];
            }
        }
        return $numbers;
    }




        function fetch_parent_id($userid) {
        global $dbc;
      
        $q = "SELECT parent_id FROM `az_user` where userid='$userid'";
        $rs = mysqli_query($dbc, $q);
      
        if (mysqli_num_rows($rs)) {
            while ($row = mysqli_fetch_assoc($rs)) {
                $parent_id = $row['parent_id'];
            }
        }
        return $parent_id;
    }

       function getDNDNumbers($mob_num) {
        global $dbc2;
        $mobile_nos=implode(",",$mob_num);
      //  $q = "SELECT `mobile_no` FROM `mobile` where `mobile_no` in ($mobile_nos)";
        $q = "SELECT `mobile_no` FROM `mobile` where `mobile_no` in ($mobile_nos)";
        $rs = mysqli_query($dbc2, $q);
        $numbers = array();
        if (mysqli_num_rows($rs)) {
            while ($row = mysqli_fetch_assoc($rs)) {
                $numbers[] = trim($row['mobile_no']);
            }
        }
        return $numbers;
    }

    public function randomNumGen($length) {
        return substr(str_shuffle(str_repeat('ABCghijDEFGH0123IJKLMNOPtuvwxQRSopqrsTUVW459XYZabcdefklmn678yz', 5)), 0, $length);
    }

    public function subRandomNumGen($length) {
        global $dbc;
        $str = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz', 2)), 0, $length);
        $sql = "SELECT (1) AS cnt FROM `az_temp_trackingkey` WHERE `sub_track_key` = '{$str}' LIMIT 1;";
        $res = mysqli_query($dbc, $sql);
        if (mysqli_num_rows($res) > 0) {
            $this->subRandomNumGen($length);
        }
        return $str;
    }

    //For parents with overselling Added by Azizur
    function getDNDParentOverselingId($userid = null) {
        global $dbc;
        if (!empty($userid)) {
            $Qry = "SELECT `parent_id` FROM `az_user` WHERE userid = {$userid} LIMIT 1;";
            $Res = mysqli_query($dbc, $Qry);
            if (mysqli_num_rows($Res) > 0) {
                $row = mysqli_fetch_assoc($Res);
                $parent_id = $row['parent_id'];

                if ($parent_id == 1) {
                    $Query = "SELECT `userid` FROM `az_user` WHERE `permissions` LIKE '%OverSelling%' AND `userid` = {$userid} LIMIT 1;";
                    $Result = mysqli_query($dbc, $Query);
                    if (mysqli_num_rows($Result) > 0) {
                        $rows = mysqli_fetch_assoc($Result);
                        return $rows['userid'];
                    } else {
                        return '';
                    }
                }
                return $this->getDNDParentOverselingId($parent_id);
            }
        }
    }

    function refundDNDParentId($userid = null) {
        global $dbc;
        if (!empty($userid)) {
            $Qry = "SELECT `parent_id` FROM `az_user` WHERE `userid` = {$userid} LIMIT 1;";
            $Res = mysqli_query($dbc, $Qry);

            if (mysqli_num_rows($Res) > 0) {
                $row = mysqli_fetch_assoc($Res);
                $parent_id = $row['parent_id'];
                if ($parent_id == 1) {
                    return '';
                }
                $Query = "SELECT `userid`, `parent_id` FROM `az_user` WHERE `permissions` LIKE '%DND_OR_NOT%' AND `userid` = {$parent_id} LIMIT 1;";
                $Result = mysqli_query($dbc, $Query);
                if (mysqli_num_rows($Result) > 0) {
                    return $parent_id;
                } else {
                    $this->refundDNDParentId($parent_id);
                }
            }
        }
    }

    public function getScheduleDateTimeMonth($datetime) {
        global $dbc;
        $date = explode(' ', $datetime);
        $date1 = explode('/', $date[0]);
        $time = $date[1] . " " . $date[2];
        $time = date("H:i:s", strtotime($time));
        $date2 = $date1[2] . '' . $date1[1];
        //$new_time = date("Y-m-d H:i:s", strtotime($date2.'+28 minute'));
        //$new_time1 = date("Y-m-d H:i:s", strtotime($new_time.'+4 hours'));
        return $date2;
    }

    function getSingleData($table, $where, $select_field) {

        global $dbc;
        $data = '';
        $query = "SELECT $select_field FROM $table WHERE $where LIMIT 1";

        $result = mysqli_query($dbc, $query);
        //echo "Count sid".mysqli_num_rows($result);
        if (mysqli_num_rows($result) > 0) {

            while ($row = mysqli_fetch_assoc($result)) {

                $data = $row[$select_field];
            }
        }

        return $data;
    }

    public function send_sms($send_sms_data)
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
        
        //echo $queryInsert;

        //echo $queryInsert = "INSERT INTO `send_sms` (`momt`, `sender`, `receiver`, `msgdata`, `smsc_id`,`sms_type`, `coding`, `dlr_mask`, `dlr_url`, `charset`, `boxc_id`, `udh`,`meta_data`) values('$send_sms_data[0]','$send_sms_data[1]','$send_sms_data[2]','$send_sms_data[3]','$send_sms_data[4]',$send_sms_data[5],$send_sms_data[6],$send_sms_data[7],'$send_sms_data[8]','$send_sms_data[9]','$send_sms_data[10]','$send_sms_data[11]','$send_sms_data[12]')";

           if(mysqli_query($dbc,$queryInsert))
           {
                return 1;
           }
           else
           {
            return mysqli_error($dbc);
             
           }
        
    }

    public function fetch_template_id($temp_id)
    {
         global $dbc;
        if (!empty($temp_id)) {
           
            $q = "SELECT `template_id` FROM az_template WHERE `tempid`='$temp_id'";
            $rs = mysqli_query($dbc, $q);
            $row = mysqli_fetch_assoc($rs);

            $template_id=$row['template_id'];

            return $template_id;
            
        } else {
            return '';
        }
    }

    public function random_strings($length_of_string)
    {
     
        // String of all alphanumeric character
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
     
        // Shuffle the $str_result and returns substring
        // of specified length
        return substr(str_shuffle($str_result),
                           0, $length_of_string);
    }

    
}

?>
