<?php

error_reporting(0);
include_once('include/connection.php');

/*include('controller/classes/last_activities.php');*/
include('include/config1.php');



$invalid_number=0;

$ip_address = $_SERVER['REMOTE_ADDR'];
$sendtable = SENDSMS_API . CURRENTMONTH;
$sendtabledetals = SENDSMSDETAILS;
$status="Submitted";
$username = (isset($_REQUEST['username'])) ? $_REQUEST['username'] : '';

$apikey = (isset($_REQUEST['apikey'])) ? $_REQUEST['apikey'] : '';
$vsms = (isset($_REQUEST['vsms'])) ? $_REQUEST['vsms'] : 'No';

$senderid = (isset($_REQUEST['senderid']) && ctype_alpha($_REQUEST['senderid'])) ? $_REQUEST['senderid'] : '';

$unicode = isset($_REQUEST['msgtype']) ? $_REQUEST['msgtype'] : '';
$time = isset($_REQUEST['time']) ? $_REQUEST['time'] : '';

$format = isset($_REQUEST['format']) ? $_REQUEST['format'] : '';
$route = (isset($_REQUEST['route'])) ? $_REQUEST["route"] : '';
$template_id = (isset($_REQUEST['TID']) && is_numeric($_REQUEST["TID"])) ? $_REQUEST["TID"] : 0;
$pe_id = (isset($_REQUEST['PEID']) && is_numeric($_REQUEST["PEID"])) ? $_REQUEST["PEID"] : 0;
$schdate = (isset($_REQUEST['schedule'])) ? $_REQUEST["schedule"] : NULL;

$campaign_id=0;
if($schdate!=NULL)
{
    $is_schedule=1;
    //$schdate=NULL;
}
else
{
    $is_schedule=0;
    //$schdate = (isset($_REQUEST['scheduleDateTime'])) ? $_REQUEST["scheduleDateTime"] : 0;
}

if(isset($_REQUEST['group']))
{
    $method='group';
    $group_name=$_REQUEST['group'];


}
else
{
    $method='numbers';
    $group_name='';
}




$form_type='API';

if ($username == '' || $apikey == '') {
    $msg2 = array("message" => "Please provide username and api key.");
    show_msg($msg2,$format,$invalid_number);
    exit();
} else {
    $query = "select * from az_user where user_name='$username' AND api_key='$apikey' and user_status=1 limit 0,1";
    $response = mysqli_query($dbc, $query);
    $record = mysqli_num_rows($response);
    $result = mysqli_fetch_assoc($response);
    if ($record > 0) {
        $userid = $result["userid"];
      //  get_last_activities($userid,'SMS Send through api','','');
    } else {
        $msg2 = array("message" => "Invalid username and API Key.");
        show_msg($msg2,$format,$invalid_number);
        exit();
    }
}

$mobile_numbers='';
 if (isset($_REQUEST['mobile']) && !empty($_REQUEST['mobile']) && $group_name=='') 
 {
    $mobile_numbers=$_REQUEST['mobile'];
 }
 else if(!empty($group_name)|| $group_name!='')
 {
    $mobile_numbers=fetch_mobile_number($group_name,$userid);

        if($mobile_numbers==0)
        {
            $msg2 = array("message" => "No contacts available in this group");
             show_msg($msg2,$format,$invalid_number);
            exit();
        }
 }
 else
 {
    $msg2 = array("message" => "Please Assign Mobile Number");
         show_msg($msg2,$format,$invalid_number);
        exit();
 }

 
 if ($mobile_numbers!='') {

        $numbers = explode(",", trim(str_replace(array(' ', "\r\n", "\r", "\n"), "",$mobile_numbers)));
        $total_num_count=count($numbers);
        $numbers = array_unique($numbers, TRUE);
        $count_unique_num=count($numbers);

        validate_number($numbers);
         $duplicate_count=$total_num_count-$count_unique_num;

        $num_count = array();
        $blockNum = array();
        $udh = 153;
        $SMS = 160;
        $msgcredit = 1;  

        if (isset($_REQUEST['route'])) {
                      
            $route_name= trim($route);

            $routeid= fetch_route_id($route);
            if($routeid=='')
            {
                $msg2 = array("message" => "Undefined Route");
                show_msg($msg2,$format,$invalid_number);
                exit(); 
            }

            
            $dnd_status=fetch_dnd_status($routeid);
            $senderid_name=$_REQUEST['senderid'];
            $sid=fetch_sender_id($senderid_name,$userid);
          
            if($sid=='')
            {
                $msg2 = array("message" => "Sender ID Wrong!!");
                show_msg($msg2,$format,$invalid_number);
                exit();
            }
            else
            {
                    $gateway_id=fetch_sender_routing($sid,$userid);

                    if($gateway_id==0)
                    {
                        $planid=fetch_plan($routeid,$userid);
                        if($planid==0)
                        {
                            $msg2 = array("message" => "Plan Not assign to this user");
                            show_msg($msg2,$format,$invalid_number);
                            exit(); 
                        }

                        $service_name=fetch_gateway_name($planid,$routeid);
                        if($service_name=='')
                        {
                            $msg2 = array("message" => "Incorrect route entered");
                            show_msg($msg2,$format,$invalid_number);
                            exit();
                        }


                    }
                    else
                    {
                        $service_name =fetch_gateway_name_byid($gateway_id);
                        if($service_name=='')
                        {
                            $msg2 = array("message" => "Incorrect route entered");
                            show_msg($msg2,$format,$invalid_number);
                            exit();
                        }
                    }


            }

          /*  $planid=fetch_plan($routeid,$userid);
            //$service_name =fetch_gateway_name($planid,$routeid);


           
            $service_name =fetch_gateway_name($planid,$routeid);*/
            
        }
        else
        {
             $msg2 = array("message" => "Provide Route");
                show_msg($msg2,$format,$invalid_number);
                exit(); 
        }
        if ($_REQUEST['route'] == '') {
             $msg2 = array("message" => "Kindly provide route");
                show_msg($msg2,$format,$invalid_number);
                exit(); 
        }
        if ($_REQUEST['mobile'] == '') {
             $msg2 = array("message" => "Mobile number should not be an empty");
                show_msg($msg2,$format,$invalid_number);
                exit(); 
        }

        if ($_REQUEST['text'] == '') {
             $msg2 = array("message" => "Text should not be an empty");
                show_msg($msg2,$format,$invalid_number);
                exit(); 
        }

        $blockNum = getBlockNumbers($userid);
        

        foreach ($numbers as $value) {
            if (strlen(trim($value)) > 12 || strlen(trim($value)) < 10 || (strlen(trim($value)) == 11)) {
               
                $invalid_number++;
                 continue;

            } else {
                if (strlen(trim($value)) == 12) {
                    $value = trim($value) - 910000000000;
                }
                if (trim($value) < 6000000000 || trim($value) > 9999999999) {
                    
                    $invalid_number++;
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
        $num_count=array_unique($num_count);
        $v_num=array_unique($v_num);
        $num_split=array_chunk($v_num, 2000);
        if($dnd_status=='1')
        {
            require_once('include/dnd_dbconnection.php');
            foreach($num_split as $mob_numbers)
            {

              $dnd_num[] = getDNDNumbers($mob_numbers);
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

         $whitelistnum = getWhitelistNumbers($userid);  

        $sql_cut_off="select `throughput`,`min_cut_value` from cut_off_dtls where userid='".$userid."' and cut_off_route='".$routeid."'";
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

         $total_num=count($v_num);
         $submitted_mob_num=count($numbers);

        $count = count($v_num);
        $msg = trim($_REQUEST['text']);
    
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
         /*$msg = str_replace("'", "\'", $msg);*/
        $msg_len = strlen($msg);
       /* $msg = str_replace('"', '""', $msg);*/
        if ($msg_len > $SMS) {
            $msgcredit = ceil($msg_len / $udh);
        }

        /* $msg = str_replace('"', '\"', $msg);*/
       // $msg = str_replace('"', '%22', $msg);
        $credit = count($v_num) * $msgcredit;
        
      

         $date = date('Y-m-d H:i:s');

            if (isset($is_schedule) && $is_schedule != 0) {
                    $today_time=time();
                    $date = explode(' ', $_REQUEST['schedule']);
                    $date1 = explode('/', $date[0]);
                    $time = $date[1] . " " . $date[2];
                    $time = date("H:i:s", strtotime($time));
                    $date2 = $date1[2] . '-' . $date1[1] . '-' . $date1[0] . " " . $time;

            $schedule_time=strtotime($date2);
            if($schedule_time<$today_time)
            {
                $msg2 = array("message" => "Please check schedule date & time");
                show_msg($msg2,$format,$invalid_number);
                exit(); 
            }
            $is_schedule = 1;
            $schedule_sent=0;

            $schdate1 = scheduleDateTime($schdate);
            $schdate = scheduleDateTime2($schdate);
            $req = "#1";
            $sent_at = scheduleDateTime2($schdate);
           // echo $sendtable = "az_sendmessages" . getScheduleDateTimeMonth($schdate1);
             $sendtable = "az_sendmessages" . $schdate1;


            $sendtabledetals = SENDSMSDETAILS ;


        } else {
            $is_schedule = 0;
             $schedule_sent=1;
            $schdate = '0000-00-00 00:00:00';
            $req = '';
            $sent_at=date('Y-m-d H:i:s');
            $sendtable = SENDSMS_API . CURRENTMONTH;
            $sendtabledetals = SENDSMSDETAILS;
        }


        /*testing done upto this section*/
     $idss = getOverSeelingUserids($userid);

     $ids = implode(',', $idss);
                    $userids = $ids;
                    $out = checkBalance($idss, $routeid, $credit);

                    if($out!='')
                    {
                        if ($out == false) {
                            
                            $msg2 = array("message" => "Less Parent Balance");
                            show_msg($msg2,$format,$invalid_number);
                            exit(); 
                                        }
                                     else {
                                        $usrcredit = userCreditBalance($userid, $routeid);
                                        if (($usrcredit <= $credit) && $credit > 0) {
                                            $msg2 = array("message" => "You Don't have enough credit. Please check!");
                                            show_msg($msg2,$format,$invalid_number);
                                            exit(); 
                                            }
                                        }
                    }
                    else
                    {
                           $usrcredit = userCreditBalance($userid, $routeid);
                            if (($usrcredit <= $credit) && $credit > 0) {
                                $msg2 = array("message" => "You Don't have enough credit. Please check!");
                                show_msg($msg2,$format,$invalid_number);
                                exit(); 
                            }
                            $userids = $userid;
                    }

/*            $usrcredit =userCreditBalance($userid, $routeid);
            if (($usrcredit <= $credit) && $credit > 0) {
                 $msg2 = array("message" => "Less Balance");
                if ($format == "json") {
                    echo json_encode($msg2);
                }else if($format == "xml") {

                    header('Content-type: text/xml');
                    header('Pragma: public');
                    header('Cache-control: private');
                    header('Expires: -1');
                    echo '<?xml version="1.0" encoding="utf-8"';
                    echo '<xml>';
                    echo '<response>
                            <message>Less Balance</message>
                          </response>';
                    echo '</xml>';
           
                } else {
                    echo "Less Balance";
                }
                exit(); 
            }*/

         if (isset($_REQUEST['senderid']))
         {
           
            $senderid_name=$_REQUEST['senderid'];
           $sid=fetch_sender_id($senderid_name,$userid);
           // $senderid_name = fetch_sender_name($senderid);
            if($sid=='')
            {
                $msg2 = array("message" => "Sender ID Wrong!!");
                show_msg($msg2,$format,$invalid_number);
                exit();
            }
            else
            {
                $pe_id = '';
                $pe_id = getSingleData('az_senderid', "sid = '{$sid}'", 'pe_id');
                
                    if($template_id=="" || $template_id==0)
                    {


                        $template_msg = str_replace('""', '"', $msg);
                       
                        $check_template = checkTemplate($userid, $template_msg,$unicode,$sid);
                        
                        if ($check_template['status']) {
                            $template_id = $check_template['template_id'];
                        } else {
                            $msg2 = array("message" => "Template Mismatch!!");
                            show_msg($msg2,$format,$invalid_number);
                            exit();
                            }
                    }
                    else
                    {

                     
                        $template_msg = str_replace('""', '"', $msg);
                        
                        // $check_template = checkTemplate_withtemplateId($userid, $template_msg,$template_id);
                       
                        // if ($check_template['status']) {
                        //     $template_id = $check_template['template_id'];
                        // } else {
                        //    $msg2 = array("message" => "Template Mismatch!!");
                        //     show_msg($msg2,$format,$invalid_number);
                        //         exit();
                        //     }

                    }

                    
            }

             
            
         }
         else {
           
            $msg2 = array("message" => "Sender id can not be blank");
            show_msg($msg2,$format,$invalid_number);
            exit();
            
        }



        if($vsms=='vsms')
            {
               $gvsms='Yes';
            }
            else
            {
                $gvsms='No';
            }


            if($_REQUEST['msgtype']=='text' || $_REQUEST['msgtype']=='')
                {
                   $text_type=0;  
                   $char_set="Text";
                }
            else if($_REQUEST['msgtype']=='unicode')
                {
                   $text_type=1;
                   $char_set="Unicode";
                }


$is_refund=0;
$low_price=0;
$is_flash="";
$url_status=0;
$campaign_id=0;
$campaign_name=(isset($_REQUEST['campaign_name'])) ? $_REQUEST['campaign_name'] : '';

   

$job_id=random_strings(15);

if($submitted_mob_num==$invalid_number)
{
    $msg2 = array("message" => "Failed");
    show_msg($msg2,$format,$invalid_number);
    exit(); 
}

  $msg=str_replace("'","\'",$msg);
    $q = "INSERT INTO  $sendtable (`id`, `message`, `userid`, `campaign_id`, `is_scheduled`, `scheduled_time`, `created_at`, `updated_at`, `unicode_type`, `senderid`, `service_id`, `sms_type`, `is_refund`, `other_operator`, `request_code`, `campaign_name`, `is_picked`, `numbers_count`, `msg_credit`, `custway`, `charset`, `senderid_name`, `low_price`, `original_url`, `url_status`, `pe_id`, `template_id`,`gvsms`,`ip_address`,`method`,`form_type`,`cut_off_value`,`route`,`job_id`,`schedule_sent`,`sent_at`) VALUES (NULL, '" . $msg . "', '" . $userid . "','" . $campaign_id . "', '" . @$is_schedule . "', '" . $schdate . "', NOW(), NOW(), '".$text_type."', '" .$sid . "' , '" . $routeid . "', 'API','" . @$is_refund . "', NULL, '', '" . @$campaign_name . "', 0, '" . $count . "', '" . $msgcredit . "', '" . $is_flash . "', 'utf-8', '" . $senderid_name . "','" . $low_price . "', '','" . $url_status . "', '" . $pe_id . "', '" . $template_id . "', '" . $gvsms . "', '" . $ip_address . "', '" . $method . "', '" . $form_type . "', '0','".$route."','".$job_id."','".$schedule_sent."','".$sent_at."')";
        mysqli_set_charset($dbc, 'utf8');
        $rs = mysqli_query($dbc, $q)or die(mysqli_error($dbc));
         $msg=str_replace("\'","'",$msg);
                
        if (!$rs) {
             $msg2 = array("message" => "Failed");
               show_msg($msg2,$format,$invalid_number);
                exit(); 
        }

        $rId = mysqli_insert_id($dbc);
        $parent_id=fetch_parent_id($userid);
        
        $str = array();
        $priority = 0;
        $cntr = 0;
        $numcount = count($v_num);
        $err_code = '';
        $status   = 'Submitted';
        $circle = '';
        $operator = '';
        $delivered_date = '';
        $status_id      = 0;
        $subRandNo = '';
        if ($url_status == 1) {
            $subRandNo = subRandomNumGen(3);
        }

          if($is_schedule!='1')
        {
            $status   = 'Submitted';
        }
        else
        {
            $status   = 'Scheduled';
        }


         $tracking_key = ((strpos(trim($_REQUEST['text']), TRACKINGURL) !== false) ? TRACKINGURL : '');

      $meta_data="?smpp?PEID=$pe_id&TID=$template_id";
            foreach ($v_num as $value) {
                if ($cntr == 50) {
                    $priority = 1;
                } else if ($cntr % 50 == 0) {
                    $priority++;
                }
                $cntr++;
                if ($numcount < 10) {
                    $priority = 0;
                }
                /*if ($isPic == false) {
                    $is_picked = 0;
                } else {
                    $is_picked = 1;
                }*/
                $is_picked = 0;
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
                        } else {
                            $original_url = $orig_url;
                        }
                    $randNo = randomNumGen(7);
                    $combRandNo = $subRandNo . '/' . $randNo;
                    $msg1 = str_replace('xyz/xxxxxxx', $combRandNo, $msg);
                    $strTrack[] = '(NULL, "' . $userid . '", "' . $rId . '", 0, "' . $num . '", "' . $subRandNo . '", "' . $randNo . '",  "' . $original_url . '",  0, NOW())';
                } else {
                    $msg1 = $msg;
                    $original_url = $orig_url;
                }
/*
                if ($pe_id == '') {
                    $is_picked = 1;
                    $status = 'Failed';
                    $err_code = 'PID';
                    $status_id = 2;
                }*/


                    if(!empty($dnd_num))
                    {
                       
                              if(in_array($num_without, $dnd_num) || in_array($num_with, $dnd_num))
                                {
                                    $status="DND Preference";
                                    $is_picked=1;
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
                                    $is_picked=0;
                                }
                        
                    }
                    else if(!empty($blockNum))
                    {
                       
                             if(in_array($num_without, $blockNum) || in_array($num_with, $blockNum))
                                {
                                    $status="Number Block";
                                    $is_picked=1;
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
                                    $is_picked=0;
                                }
                        
                    }
                    
                    if(!empty($cut_off_data))
                    {
                        if(in_array($num, $cut_off_data))
                                {
                                    $cut_off_status="Yes";
                                    $is_picked=1;
                                }
                                else
                                {
                                    $cut_off_status="No";
                                    //$is_picked=0;
                                }
                    }
                    else
                    {
                         $cut_off_status="No";
                         //$is_picked=0;
                    }


                if($char_set=='Unicode')
                {  
                    $unicode_type=1;
                    $msgdata=rawurlencode($msg1);
                }
                else
                {
                    $unicode_type=0;
                    if(strpos($msg1, '%') !== false || strpos($msg1, "'") !== false || strpos($msg1, "+") !== false){

                        $msg_send=$msg1;

                         /*$msg_send = str_replace('\"', '"', $msg_send);*/
                        // $msg_send = str_replace('%22', '"', $msg_send);
                         //$msgdata = $msg_send;
                            $msgdata=rawurlencode($msg_send);
                           //$msgdata=rawurlencode($msg1);
                        }
                        else
                        {
                            $msgdata=$msg1;
                        }
                }
                
                $master_job_id=random_strings(20);
               if($method=='groups')
                    {
                        $group_name=get_contact_group($num_without,$num_with);
                        if(empty($campaign_name))
                        {
                            $cam_dt=date("dmy");
                            if(!empty($group_name))
                            {
                                
                                    $operator_name=$cam_dt."_".$group_name;
                                
                            }
                            
                        }
                        else
                        {
                            if(!empty($group_name))
                            {
                               
                                    $operator_name=$campaign_name."_".$group_name;
                                
                            }
                        }

                    }

                //$service_name='LIVE';
                
            /*    $str[] = '(NULL, "' . $rId . '", "' . $msg1 . '","'.$num.'", NOW(), "' . $senderid_name . '", "' . $service_name . '", "", "' . $is_picked . '", "' . $priority . '", "' . $is_schedule . '", "' . $schdate . '", "' . $msgcredit . '", "' . $userid . '", "' . $is_flash . '","' . $status . '", "' . $err_code . '","' . $status_id . '","'.$route.'","'.$msg_len.'")';*/
                    $circle='API';
                    $msg1=str_replace('"', '\"', $msg1);
                $str[] = '(NULL, "' . $rId . '", "' . $msg1 . '", "'.$num.'", NOW(), "' . $senderid_name . '", "' . $service_name . '", "", "' . $is_picked . '", "' . $priority . '", "' . $is_schedule . '", "' . $schdate . '", "' . $msgcredit . '", "' . $userid . '", "' . $is_flash . '","' . $status . '", "' . $err_code . '","' . $status_id . '","'.$route.'","'.$msg_len.'","'.$job_id.'","'.$schedule_sent.'","'.$parent_id.'","'.$sent_at.'","'.$cut_off_status.'","'.$master_job_id.'","'.$msgdata.'","'.$unicode_type.'","'.$meta_data.'","'.$operator_name.'","'.$circle.'")';
            
        }
 $query_data = array_chunk($str, 2000);
      
        if($is_schedule != '1')
        {


             $insert_values="";
            foreach($query_data as $values)
            {
                $insert_values=implode(",", $values);

                $queryInsert="insert into $sendtabledetals(`id`, `message_id`, `msgdata`, `mobile_number`, `created_at`, `senderid`, `service_id`, `request_code`, `is_picked`, `priority`, `is_scheduled`, `scheduled_time`, `msgcredit`, `userids`, `operator_status_id`, `status`, `err_code`,`status_id`,`route`,`char_count`,`msg_job_id`,`schedule_sent`,`parent_id`,`sent_at`,`cut_off`,`master_job_id`,`send_msg`,`unicode_type`,`metadata`,`operator_name`,`circle`) VALUES ".$insert_values;


                $result1 = mysqli_query($dbc, $queryInsert);
                 

            }

            /*$array = array('query_data' => $query_data,'msg_job_id'=>$job_id);
            $filename=$job_id."_send_".time().".json";
            $file_path="/var/www/html/sms_app/controller/classes/sent_sms/".$filename;
            $fp = fopen($file_path, 'w+');
            fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
            fclose($fp);*/

            /*$new_send_file="test_sent_sms_".time().".php";
            copy("/var/www/html/sms_app/controller/classes/test_sent_sms.php", "/var/www/html/sms_app/controller/classes/sent_sms/".$new_send_file);
       
            exec("php /var/www/html/sms_app/controller/classes/sent_sms/$new_send_file $filename > /dev/null 2>/dev/null &"); */


           // $pyout = exec("/var/www/html/sms_app/python-venv/bin/python /var/www/html/sms_app/controller/rnd/message_sending_master.py $filename  &");

                   

        }
         else
        {
                   /* foreach($query_data as $values) {
                       
                        $insert_val=implode(",",$values);
                        $count_val=count($values);
                       
                      /*  $msg_arr[]=$values;
                        $query_master_tbl_insert= "INSERT INTO $sendtabledetals (`id`, `message_id`, `msgdata`, `mobile_number`, `created_at`, `senderid`, `service_id`, `request_code`, `is_picked`, `priority`, `is_scheduled`, `scheduled_time`, `msgcredit`, `userids`, `operator_status_id`, `status`, `err_code`,`status_id`,`route`,`char_count`,`msg_job_id`,`schedule_sent`,`parent_id`,`sent_at`,`cut_off`,`master_job_id`,`send_msg`,`unicode_type`,`metadata`,`operator_name`) VALUES $insert_val";
                         $rs1 = mysqli_query($dbc, $query_master_tbl_insert) or die(mysqli_error($dbc));
                          }
                    */

                $array = array('query_data' => $query_data,'msg_job_id'=>$job_id);
                $filename=$job_id."_schedule_".time().".json";
                $file_path="classes/schedule_sms/".$filename;
                $fp = fopen($file_path, 'w+');
                fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
                fclose($fp);


                $pyout = exec("/var/www/html/sms_app/python-venv/bin/python /var/www/html/sms_app/controller/rnd/insert_schedule_master.py $filename > /dev/null 2>/dev/null &");


                    $new_send_file="run_schedule_sms_".time().".php";
                    copy("/var/www/html/sms_app/controller/classes/run_schedule_sms.php", "/var/www/html/sms_app/controller/classes/schedule_sms/".$new_send_file);

                    $array_schedule = array('php_file' => $new_send_file,'schedule_time' =>$schdate,'message_id' =>$job_id);
                    $schedule_filename="scheduler.json";
                    $file_path2="/var/www/html/sms_app/controller/classes/".$schedule_filename;

                     $data_results = file_get_contents($file_path2);
                    $tempArray = json_decode($data_results);

                    //append additional json to json file
                    $tempArray[] = $array_schedule ;
                    $jsonData = json_encode($tempArray);

                    file_put_contents($file_path2, $jsonData);

        }


            /*if($vsms=='vsms')
            {
                $verified_sms=vsms($v_num,$msg1);
               
            } */


        //print_r($v_num);
/*        $query_data = array_chunk($str, 2000);
         
        foreach ($query_data as $values) {
            
            $i=0;
            foreach($values as $val)
            {

                
                $num_send=$v_num[$i];
                $i++;
                $rs1 = mysqli_query($dbc, "INSERT INTO $sendtabledetals (`id`, `message_id`, `msgdata`, `mobile_number`, `created_at`, `senderid`, `service_id`, `request_code`, `is_picked`, `priority`, `is_scheduled`, `scheduled_time`, `msgcredit`, `userids`, `operator_status_id`, `status`, `err_code`,`status_id`,`route`,`char_count`) VALUES " . $val);
                 $dlr_url= mysqli_insert_id($dbc);
               


                $meta_data="?smpp?PEID=$pe_id&TID=$template_id";


                if($_REQUEST['msgtype']=='text' || $_REQUEST['msgtype']=='')
                {
                    $msg_send=$msg;
                   $send_sms_data[]=['MT',$senderid_name,$num_send,$msg_send,$service_name,2,0,19,$dlr_url,'utf8','sqlbox','0',$meta_data];
                   $text_type=0;
                   
                }
                elseif($_REQUEST['msgtype']=='unicode')
                {

                    $msg_send=urlencode($msg);
                   
                    $send_sms_data[]=['MT',$senderid_name,$num_send,$msg_send,$service_name,2,2,19,$dlr_url,'utf8','sqlbox','0',$meta_data];
                   $text_type=1;
                }


            }

            
        }



        $send_sms_status=send_sms($send_sms_data);*/

        if ($tracking_key != '') {
            $track_data = array_chunk($strTrack, 2000);
            foreach ($track_data as $value) {
                $tqr = "INSERT INTO `az_temp_trackingkey`(`id`, `userid`, `msgid`, `numid`, `number`, `sub_track_key`, `tracking_key`, `original_url`, `status`, `create_date`) VALUES " . implode(',', $value);
                $rst = mysqli_query($dbc, $tqr);
            }
        }


           // $reupdate = mysqli_query($dbc, "UPDATE $sendtable SET  `is_picked` = 0 WHERE id = {$rId}");

            $rs2 = mysqli_query($dbc, "UPDATE `az_credit_manage` SET balance = (balance - $credit) WHERE userid = '{$userid}' AND az_routeid = '{$routeid}'");

            
        //}
        if ($rs) {
            mysqli_commit($dbc);
             $msg2 = array("status" => "OK", "data" => $data, "msg-id" => $job_id, "message" => "Message Submitted successfully");
             show_msg($msg2,$format,$invalid_number);
           /* if ($format == "json") {
                echo json_encode($msg2);
            }else if($format == "xml") {

                    header('Content-type: text/xml');
                    header('Pragma: public');
                    header('Cache-control: private');
                    header('Expires: -1');
                    echo '<?xml version="1.0" encoding="utf-8"';
                    echo '<xml>';
                    echo '<response>
                            <message>Message Submitted successfully</message>
                            <msgid>"'.$job_id.'"</msgid>
                          </response>';
                    echo '</xml>';
           
                } else {

                echo "Message Submitted Successfully";
                echo '<pre>';
                echo "msg-id : " . $job_id;
            }*/

             exit();
        } else {
            mysqli_rollback($dbc);
               $msg2 = array("message" => "Message Failed");
            show_msg($msg2,$format,$invalid_number);
            exit();
        }
      

          /*  $rs2 = mysqli_query($dbc, "UPDATE `az_credit_manage` SET balance = (balance - $credit) WHERE userid = '{$userid}' AND az_routeid = '{$routeid}'");
        //}
        if ($rs1 && $rs) {
            mysqli_commit($dbc);
            $job_id=random_strings(15);

           /* $job_id=base64_encode($rId . '##' . CURRENTMONTH);
          $msg2 = array("status" => "OK", "data" => $data, "msg-id" => $job_id, "message" => "Message Submitted successfully");
            if ($format == "json") {
                echo json_encode($msg2);
            }else if($format == "xml") {

                    header('Content-type: text/xml');
                    header('Pragma: public');
                    header('Cache-control: private');
                    header('Expires: -1');
                    echo '<?xml version="1.0" encoding="utf-8"';
                    echo '<xml>';
                    echo '<response>
                            <message>Message Submitted successfully</message>
                            <msgid>"'.$job_id.'"</msgid>
                          </response>';
                    echo '</xml>';
           
                } else {

                echo "Message Submitted Successfully";
                echo '<pre>';
                echo "msg-id : " . $job_id;
            }

              $reupdate = mysqli_query($dbc, "UPDATE $sendtable SET  `is_picked` = 0,`job_id`='".$job_id."' WHERE id = {$rId}");
            exit();
        } else {
            mysqli_rollback($dbc);
            $msg2 = array("message" => "Message Failed");
            if ($format == "json") {
                echo json_encode($msg2);
            }else if($format == "xml") {

                    header('Content-type: text/xml');
                    header('Pragma: public');
                    header('Cache-control: private');
                    header('Expires: -1');
                    echo '<?xml version="1.0" encoding="utf-8"';
                    echo '<xml>';
                    echo '<response>
                            <message>Message Failed</message>
                            
                          </response>';
                    echo '</xml>';
           
                }  else {
                echo "Message Failed";
            }
            exit();
        }*/

    }
    else
    {
        $msg2 = array("message" => "Please Assign Mobile Number");
        show_msg($msg2,$format,$invalid_number);
        exit();
    }

mysqli_close($dbc);




/*end*/
/*all functions starts*/
function validate_number($phone_numbers){


    foreach($phone_numbers as $phone_number)
    {
      
       
       
                
        if(preg_match('/^[0-9]{10,13}+$/', $phone_number)) {
            
        }   else{
           $msg2 = array("message" => "Invalid Mobile Number");
                show_msg($msg2,$format,$invalid_number);
                exit();
            }
        }
    }

       function getWhitelistNumbers($userid=null) {
        global $dbc;
        
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

    function get_contact_group($num_without,$num_with) {
        global $dbc;
        
        $q = "SELECT g_id FROM az_group_contactlist WHERE cont_number ='".$num_without."' or cont_number = '".$num_with."'";
        $rs = mysqli_query($dbc, $q);
        while ($row = mysqli_fetch_assoc($rs)) {
            $id = $row['g_id'];
            $q1 = "SELECT  g_name  FROM az_group  WHERE g_id=$id ";
            $rs1 = mysqli_query($dbc, $q1);
            while ($row1 = mysqli_fetch_assoc($rs1)) {
            $g_name = $row1['g_name'];
            return $g_name;
            }
        }
        
    }

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

function random_strings($length_of_string)
    {
     
        // String of all alphanumeric character
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
     
        // Shuffle the $str_result and returns substring
        // of specified length
        return substr(str_shuffle($str_result),0, $length_of_string);
    }


function getScheduleDateTimeMonth($datetime) {
        global $dbc;
        $date = explode(' ', $datetime);
        $date1 = explode('-', $date[0]);
        $time = $date[1] . " " . $date[2];
        $time = date("H:i:s", strtotime($time));
        $date2 = $date1[2] . '' . $date1[1];
        //$new_time = date("Y-m-d H:i:s", strtotime($date2.'+28 minute'));
        //$new_time1 = date("Y-m-d H:i:s", strtotime($new_time.'+4 hours'));
        return $date2;
    }

 function scheduleDateTime($datetime) {
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


     function scheduleDateTime2($datetime) {
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

 function vsms($num_count,$msg)
    {
        global $dbc;
        $array = array('mobile_number' => $num_count,'msg' => $msg);
        $filename="results_".time().".json";
        $fp = fopen($filename, 'w+');
        fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
        fclose($fp);


       $pyout = exec("python -tt controller/vsms/create_hashes_example.py $filename");
        return $pyout;
    }

           function fetch_gateway_name_byid($gateway_id=null) {
        global $dbc;

          
                 $q = "SELECT * FROM az_sms_gateway WHERE gateway_id='$gateway_id'";
                $rs = mysqli_query($dbc, $q);
                $row = mysqli_fetch_assoc($rs);

                $gateway_name=$row['smsc_id'];
                return $gateway_name;
            
        
    }


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
      
/*echo count($send_sms_data);*/
           if(mysqli_query($dbc,$queryInsert))
           {
                return 1;
           }
           else
           {
            return mysqli_error($dbc);
             
           }
        
    }


function randomNumGen($length) {
        return substr(str_shuffle(str_repeat('ABCghijDEFGH0123IJKLMNOPtuvwxQRSopqrsTUVW459XYZabcdefklmn678yz', 5)), 0, $length);
    }
 function subRandomNumGen($length) {
        global $dbc;
        $str = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz', 2)), 0, $length);
        $sql = "SELECT (1) AS cnt FROM `az_temp_trackingkey` WHERE `sub_track_key` = '{$str}' LIMIT 1;";
        $res = mysqli_query($dbc, $sql);
        if (mysqli_num_rows($res) > 0) {
            subRandomNumGen($length);
        }
        return $str;
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

 function fetch_sender_name($sid)
{
    global $dbc;

    $sql="select * from az_senderid where sid='".$sid."' limit 1";
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

 function fetch_sender_id($senderid_name,$userid)
{
    global $dbc;

    $sql="select * from az_senderid where senderid='".$senderid_name."' and userid='".$userid."' limit 1";
    $result=mysqli_query($dbc,$sql);
    $count=mysqli_num_rows($result);

    if($count>0)
    {
            while($row=mysqli_fetch_array($result))
            {
                $sid=$row['sid'];

                return $sid;
            }
    }
    else
    {
        return '';
    }

}           
function fetch_sender_routing($sender_id,$userid)
{
    global $dbc;
    
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

function fetch_gateway_name($planid=null,$routeid = null) {
        global $dbc;
        if (!empty($routeid)) {
            $out = array();
            $q = "SELECT * FROM az_route_plan WHERE `plan_id`='$planid' and `route_id`='$routeid' and rp_status = 1";
            $rs = mysqli_query($dbc, $q);
            $row = mysqli_fetch_assoc($rs);

            $gatewayid=$row['gateway_id'];

            if(!empty($gatewayid))
            {
                 $q = "SELECT * FROM az_sms_gateway WHERE gateway_id='$gatewayid'";
                $rs = mysqli_query($dbc, $q);
                $row = mysqli_fetch_assoc($rs);

                $gateway_name=$row['smsc_id'];
                return $gateway_name;
            }
            
        } else {
            return '';
        }
    }


     function fetch_route_name($routeid = null) {
        global $dbc;
        if (!empty($routeid)) {
            $out = array();
            $q = "SELECT * FROM az_routetype WHERE  `az_routeid`='$routeid' and status = 1";
            $rs = mysqli_query($dbc, $q);
            $row = mysqli_fetch_assoc($rs);

            $route_name=$row['az_rname'];

            return $route_name;
            
        } else {
            return '';
        }
    }

     function fetch_route_id($route = null) {
        global $dbc;
        if (!empty($route)) {
            $out = array();
            $q = "SELECT * FROM az_routetype WHERE  `az_rname`='$route' and status = 1";
            $rs = mysqli_query($dbc, $q);
            $row = mysqli_fetch_assoc($rs);

            $routeid=$row['az_routeid'];

            return $routeid;
            
        } else {
            return '';
        }
    }


     function fetch_dnd_status($routeid = null) {
        global $dbc;
        if (!empty($routeid)) {
            $out = array();
            $q = "SELECT * FROM az_routetype WHERE  `az_routeid`='$routeid' and status = 1";
            $rs = mysqli_query($dbc, $q);
            $row = mysqli_fetch_assoc($rs);

            $dnd_enable=$row['dnd_enable'];

            return $dnd_enable;
            
        } else {
            return '';
        }
    }


function fetch_plan($routeid,$userid)
{
    global $dbc;

    $sql="select * from az_plan_assign where userid='".$userid."' limit 1";
    $result=mysqli_query($dbc,$sql);
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



    function getBlockNumbers($userid=null) {
        global $dbc;
        $q = "SELECT numbers FROM `az_blocknumbers` where userid='$userid' and status=0";
        $rs = mysqli_query($dbc, $q);
        $numbers = array();
        if (mysqli_num_rows($rs)) {
            while ($row = mysqli_fetch_assoc($rs)) {
                $numbers[] = $row['numbers'];
            }
        }
        return $numbers;
    }


       function fetch_mobile_number($group_name = null,$userid) {
        global $dbc;
        if (!empty($group_name)) {
            $out = array();
            $q = "SELECT * FROM az_group WHERE `g_name`='$group_name' and `userid`='$userid'";
            $rs = mysqli_query($dbc, $q);
            $row = mysqli_fetch_assoc($rs);

            $g_id=$row['g_id'];


            $q1 = "SELECT * FROM `az_group_contactlist` WHERE `g_id`='$g_id'";
            $rs_cont = mysqli_query($dbc, $q1);
            $count_contact=mysqli_num_rows($rs_cont);
            if($count_contact>0)
            {
                while($row = mysqli_fetch_assoc($rs_cont))
                {
                    $mobile_numbers.=$row['cont_number'].",";
                }
                return $mobile_numbers;
            }
            else
            {
                return 0;
            }  
            
        } else {
            return '';
        }
    }

   function checkTemplate($userid = null, $message = null,$unicode=null,$sid=null) {
        global $dbc;
        $qry = "SELECT REPLACE(REPLACE(template_data, '\r', ''), '\n', 'PRTss1bKuIj2lJMW') AS template_data, `pe_id`, `template_id`,`char_type` FROM `az_template` WHERE `userid` = {$userid} and senderid like '%\"$sid\"%'";
   
        if (!empty($userid) && !empty($message)) {
             /*echo $qry = "SELECT REPLACE(REPLACE(template_data, '\r', ''), '\n', 'PRTss1bKuIj2lJMW') AS template_data, `pe_id`, `template_id` FROM `az_template` WHERE `userid` = {$userid} and template_data='".$message."'";*/

            $res = mysqli_query($dbc, $qry);

            if (mysqli_num_rows($res)) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $template = trim($row['template_data']);

                       $char_type1=$row['char_type'];
                    if($char_type1=="Unicode")
                    {   
                    
                       //$message=urlencode($message);
                         $template=urldecode($template);                      
                    }
                    $template = str_replace(array("&#039;", "&amp;", "&gt;", "&lt;", "&quot;", "/", "+"), array("'", "&", "<", ">", '"', "b", 'b'),        $template);
                    $template = str_replace(array('.', '?', '$', '^', '!', '[', ']', '(', ')', '*', '-', '+', '=', '|', '/', '<', '>'), 'b', $template);
                    $template = preg_replace('/\s*{#\s*([^#]*)\s*#}\s*/', '(.{0,40})', $template);
                    //$template = preg_replace('/{#(.*?)#}/', '(.{0,40})', $template);
                    $template = str_replace(array('(.{0,40}) (.{0,40})'), '(.{0,40})(.{0,40})', $template);
                    $template = str_replace('PRTss1bKuIj2lJMW', '(.{0,1})', $template);

                    $template = str_replace(array('(.{0,40})(.{0,40})(.{0,40})(.{0,40})(.{0,40})(.{0,40})(.{0,40})(.{0,40})', '(.{0,40})(.{0,40})(.{0,40})(.{0,40})(.{0,40})(.{0,40})(.{0,40})', '(.{0,40})(.{0,40})(.{0,40})(.{0,40})(.{0,40})(.{0,40})', '(.{0,40})(.{0,40})(.{0,40})(.{0,40})(.{0,40})', '(.{0,40})(.{0,40})(.{0,40})(.{0,40})', '(.{0,40})(.{0,40})(.{0,40})', '(.{0,40})(.{0,40})'), array('(.{0,320})', '(.{0,320})', '(.{0,240})', '(.{0,200})', '(.{0,160})', '(.{0,120})', '(.{0,80})'), $template);
                    $template = preg_replace('/\s+/', ' ', $template);
                    $template = trim($template);

                    $message = trim($message);
                     $message = str_replace(' \n', '', $message);
                    $message = str_replace('\n', '', $message);

                    $message = str_replace(array('.', '?', '$', '^', '!', '[', ']', '(', ')', '*', '-', '+', '=', '|', '/', '<', '>'), 'b', $message);
                    $message = preg_replace('/\s+/', ' ', $message);
                    $message = trim($message);
                    $regexMatched = (bool) preg_match("/^" . $template . "$/mi", $message, $matches);

                    if ($regexMatched) {
                        return array("status" => true, "pe_id" => $row['pe_id'], "template_id" => $row['template_id']);
                        exit();
                    }

                   // }
                  
                   
                  
                }
                // die;
            }
        }
        return array("status" => false, "pe_id" => "", "template_id" => "");
        exit();
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
                $numbers[] = "+91".$row['mobile_no'];
            }
        }
        return $numbers;
    }

        function checkTemplate_withtemplateId($userid = null, $message = null,$template_id=null) {
        global $dbc;

        if (!empty($userid) && !empty($message)) {
            $qry = "SELECT  `pe_id`, `template_id` FROM `az_template` WHERE `userid` = {$userid} and `template_id`='$template_id'";
            $res = mysqli_query($dbc, $qry);

            if (mysqli_num_rows($res)) {
                while ($row = mysqli_fetch_assoc($res)) {
                    // $template = trim($row['template_data']);
                    // $template = str_replace(array("&#039;", "&amp;", "&gt;", "&lt;", "&quot;", "/", "+"), array("'", "&", "<", ">", '"', "b", 'b'), $template);
                    // $template = str_replace(array('.', '?', '$', '^', '!', '[', ']', '(', ')', '*', '-', '+', '=', '|', '/', '<', '>'), 'b', $template);
                    // $template = preg_replace('/\s+/', ' ', preg_replace('/{#(.*?)#}/', '(.{0,30})', $template));
                    // $template = str_replace(array('(.{0,30}) (.{0,30})'), '(.{0,30})(.{0,30})', $template);
                    // $template = str_replace('PRTss1bKuIj2lJMW', '(.{0,1})', $template);

                    // $template = str_replace(array('(.{0,30})(.{0,30})(.{0,30})(.{0,30})(.{0,30})(.{0,30})(.{0,30})(.{0,30})', '(.{0,30})(.{0,30})(.{0,30})(.{0,30})(.{0,30})(.{0,30})(.{0,30})', '(.{0,30})(.{0,30})(.{0,30})(.{0,30})(.{0,30})(.{0,30})', '(.{0,30})(.{0,30})(.{0,30})(.{0,30})(.{0,30})', '(.{0,30})(.{0,30})(.{0,30})(.{0,30})', '(.{0,30})(.{0,30})(.{0,30})', '(.{0,30})(.{0,30})'), array('(.{0,240})', '(.{0,210})', '(.{0,180})', '(.{0,150})', '(.{0,120})', '(.{0,90})', '(.{0,60})'), $template);
                    // $template = trim($template);

                    // $message = trim($message);
                    // $message = str_replace(' \n', '', $message);
                    // $message = str_replace('\n', '', $message);
                    // $message = str_replace(array('.', '?', '$', '^', '!', '[', ']', '(', ')', '*', '-', '+', '=', '|', '/', '<', '>'), 'b', $message);
                    // $message = preg_replace('/\s+/', ' ', $message);
                    // $message = trim($message);
                    // $regexMatched = (bool) preg_match("/^" . $template . "$/mi", $message, $matches);

                    // if ($regexMatched) {
                        return array("status" => true, "pe_id" => $row['pe_id'], "template_id" => $row['template_id']);
                        exit();
                    //}
                }
                // die;
            }
           
        }
        return array("status" => false, "pe_id" => "", "template_id" => "");
        exit();
    }



function show_msg($msg=null,$format=null,$invalid_number=null)
{

    $message=$msg['message'];
    if($invalid_number>0)
    {
         $msg['invalid_number']="Total Invalid numbers  = ".$invalid_number;
    }
   

    if($message=="Message Submitted successfully")
    {
        $job_id=$msg['msg-id'];
         if ($format == "json") {
                echo json_encode($msg);
            }else if($format == "xml") {

                    header('Content-type: text/xml');
                    header('Pragma: public');
                    header('Cache-control: private');
                    header('Expires: -1');
                    echo '<?xml version="1.0" encoding="utf-8"?>';
                    echo '<xml>';
                    echo "<response>
                            <message>$message</message>
                            <msgid>$job_id</msgid>
                            <msgid>Total Invalid Numbers: $invalid_number</msgid>
                          </response>";
                    echo '</xml>';
           
                } else {

                echo $message;
                echo '<pre>';
                echo "msg-id : " . $job_id;
                echo '<pre>';
                echo "Total Invalid Numbers : " . $invalid_number;
            }
    }
    else
    {

        if ($format == "json") {
                echo json_encode($msg);
            }
            else if($format == "xml") {

        header('Content-type: text/xml');
        header('Pragma: public');
        header('Cache-control: private');
        header('Expires: -1');
        echo '<?xml version="1.0" encoding="utf-8"?>';
        echo '<xml>';
        echo "<response>
                <message>$message</message>
                 <msgid>Total Invalid Numbers: $invalid_number</msgid>
              </response>";
        echo '</xml>';
                   
            }
            else {
                echo $message;
                 echo '<pre>';
                echo "Total Invalid Numbers : " . $invalid_number;
            }
    }
}

?>
