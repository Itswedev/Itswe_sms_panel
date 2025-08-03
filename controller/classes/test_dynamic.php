  <?php
  foreach ($scheduleData as $schedule_date => $preview) 
    {
    
        for ($i = 0; $i < count($preview) - 1; $i++) {

        
            if($check_track_btn=='dynamic_tracking_url_btn')
            {

                $separate_url = explode("*|*|*|", $preview[$i]);
                $text = explode("||", $separate_url[0]);
            
            
                
                $msg = trim($text[1]);
                $no = str_replace("*","",trim($text[0]));
                $numbers[] = str_replace("*","",trim($text[0]));
                $messages[]=trim($text[1]);
                $url_data=explode("-|-|-|",$separate_url[1]);
                
                $original_url_dynamic[$no]=$url_data[0];
                $url_keys=explode("|comb|",$url_data[1]);
                
                $subRandNo_arr[$no]=$url_keys[0];
                $randNo_arr[$no]=$url_keys[1];
                // return array('status' => false, 'msg' => 'Incorrect route selection','text'=>$original_url_dynamic);
                // exit;
            
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
                    $credit_arr[str_replace("*","",$text[0])] = ceil($msg_len / $udh);
                }else
                {
                    $credit_arr[str_replace("*","",$text[0])]=$credit;
                }
                $charcount_arr[str_replace("*","",$text[0])]=$msg_len;
            
                    $msgdata[str_replace("*","",$text[0])] = $msg;

                // return array('status' => false, 'msg' => 'Less Balance','text'=>$text);
                // exit;
            }
            else{
                    $text = explode("||", $preview[$i]);
                    $msg = trim($text[1]);
                    $no = str_replace("*","",trim($text[0]));
                    $numbers[] = str_replace("*","",trim($text[0]));
            //             return array('status' => false, 'msg' => 'Less Balance','text'=>$numbers);
            // exit;
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
                    $credit_arr[str_replace("*","",$text[0])] = ceil($msg_len / $udh);
                }else
                {
                    $credit_arr[str_replace("*","",$text[0])]=$credit;
                }
                $charcount_arr[str_replace("*","",$text[0])]=$msg_len;
            
                    $msgdata[str_replace("*","",$text[0])] = $msg;
            }
        }
           
        
            $total_credit=array_sum($credit_arr);
            
            if (count($numbers) == 0) {
                return array('status' => false, 'msg' => 'Select File1');
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
            $num_split=array_chunk($v_num, 5000);
            if($dnd_status=='1')
            {
                foreach($num_split as $mob_numbers)
                {

                $dnd_num= $this->getDNDNumbers($mob_numbers);
                }

            }

            foreach($num_split as $mob_numbers)
                {

                $blockNum = $this->getBlockNumbers($mob_numbers);  
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

        
            $sql_cut_off="select `throughput`,`min_cut_value`,`cut_off_status` from cut_off_dtls where userid='".$userid."' and cut_off_route='".$az_routeid."'";
            $rs_cutoff = mysqli_query($dbc, $sql_cut_off) or die(mysqli_error($dbc));
            $count_cutoff=mysqli_num_rows($rs_cutoff);
            if($count_cutoff>0)
            {
                while($row_cutoff=mysqli_fetch_array($rs_cutoff)) {
                    $cut_off_throughput=$row_cutoff['throughput'];
                    $min_cut_value=$row_cutoff['min_cut_value'];
                    $new_cut_off_status=$row_cutoff['cut_off_status'];
                } 

                $cut_off_throughput_withcomma=str_replace("-", ",", $cut_off_throughput);
                $throughput_vals=explode(",",$cut_off_throughput_withcomma);

                $random_cutoff=rand($throughput_vals[0],$throughput_vals[1]);

            }


            if($random_cutoff!=0)
            {
                if($count_cutoff>0 && ($total_num>$min_cut_value))
                {
                    $cutoff_num=$v_num;
            
                    if(!empty($whitelistnum))
                        {
                            $cutoff_num_count=count($cutoff_num);
                            $whitelistnum_count=count($whitelistnum);
                            if($whitelistnum_count>$cutoff_num_count)
                            {
                                $whitelistnul_list=array_intersect($cutoff_num,$whitelistnum);
                                $cutoff_num=array_diff($whitelistnum,$cutoff_num);
                            }
                            else
                            {
                                $whitelistnul_list=array_intersect($cutoff_num,$whitelistnum);
                                $cutoff_num=array_diff($cutoff_num,$whitelistnum);
                            }
                            
                            $cutoff_num=array_values($cutoff_num);
                        }
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

            if(!empty($whitelistnul_list))
            {
                $insert_data=array_merge($insert_data,$whitelistnul_list);
            }
            

            $count = count($v_num);
            $template_id = '';
        
            $temp_id=$_REQUEST['template'];
            $template_id=$this->fetch_template_id($temp_id);

            $userids = '';
            $userid = $_SESSION['user_id'];
            // $idss = $this->getOverSeelingUserids($_SESSION['user_id']);
            
            //         $ids = implode(',', $idss);
            //         $userids = $ids;
            //         $out = $this->checkBalance($idss, $az_routeid, $total_credit);
            //         if($out!='')
            //         {
            //                 if ($out == false) {
            //                     return array('status' => false, 'msg' => 'Parent Less Balance','out'=>$out);
            //                     exit;
            //                 }
            //              else {
            //                 $usrcredit = $this->userCreditBalance($userid, $az_routeid);
            //                 if (($usrcredit <= $total_credit) && $total_credit > 0) {
            //                     return array('status' => false, 'msg' => 'Less Balance','user'=>$usrcredit,'credit'=>$total_credit,'idss'=>$idss);
            //                     exit;
            //                 }
            //                 $userids = $userid;
            //             }
            //         }
            //         else
            //         {
                           $usrcredit = $this->userCreditBalance($userid, $az_routeid);
                            if (($usrcredit <= $total_credit) && $total_credit > 0) {
                                return array('status' => false, 'msg' => 'Less Balance','user'=>$usrcredit,'credit'=>$total_credit,'idss'=>$idss);
                                exit;
                            }
                            $userids = $userid;
                    //}

                     $is_refund = 0;

            $date = date('Y-m-d H:i:s');

                if (isset($_REQUEST['is_schedule']) && $_REQUEST['is_schedule'] != '') {
            $today_time=time();
                    $date = explode(' ', $schedule_date);
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
            $schdate = $this->scheduleDateTime($schedule_date);
            $req = "#1";
            $sent_at=$schdate;
            $sendtable = "az_sendmessages" . $this->getScheduleDateTimeMonth($schedule_date);
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
        
            if (isset($_REQUEST['sid']) && trim($_REQUEST['checkroutetype']) == 1) {
                $sender =  $_REQUEST['sid'];
                //$sid = trim($sender[0]);
                $sid=$_REQUEST['sid'];
                $senderid_name = $this->fetch_sender_name($sid);
                if (isset($sender[2]) && !empty($sender[2])) {
                    $service_name = trim($sender[2]);
                }
            } else {
                $senderid_name = '';
                $sid = '';
            }

            if (isset($_REQUEST['sid']))
            {
                $sender = $_REQUEST['sid'];
                $sid = $_REQUEST['sid'];
                $senderid_name = $this->fetch_sender_name($sid);
            }
            else {
                $senderid_name = '';
                $sid = '';
            }
       
     
                $pe_id = '';
                $pe_id = $this->getSingleData('az_senderid', "sid = '{$sid}'", 'pe_id');
                
                mysqli_query($dbc, "START TRANSACTION");

                if (isset($_REQUEST['original_url']) && !empty($_REQUEST['original_url'])) {
                    $orig_url = trim($_REQUEST['original_url']);
                    $url_status = 1;
                } else {
                    $orig_url = '';
                    $url_status = 0;
                }
                $campaign_id = 0;
                $campaign_name = "";
            // $campaign_type = isset($_REQUEST['campaign_name']) && !empty($_REQUEST['campaign_name']) ? $_REQUEST['campaign_name'] : "";
                $campaign_name = isset($_REQUEST['campaign_name']) && !empty($_REQUEST['campaign_name']) ? $_REQUEST['campaign_name'] : "";


            
                $url_status = (($_REQUEST['original_url'] != '') ? '1' : '0');

                $vsms=$_REQUEST['vsms'];
            

                if($vsms=='vsms')
                {
                $gvsms='Yes';
                }
                else
                {
                    $gvsms='No';
                }


                if($_REQUEST['char_set']=='Text')
                {
                   $text_type=0;  
                }
                elseif($_REQUEST['char_set']=='Unicode')
                {
                   $text_type=1;
                   /*$msg=urlencode($msg);*/
                }

        
                $is_flash = isset($_REQUEST['is_flash']) && !empty($_REQUEST['is_flash']) ? $_REQUEST['is_flash'] : 0;
                $job_id=$this->random_strings(15);

      

            if($count_cutoff>0)
                {
                    $cutstatus="Yes";
                $q = 'INSERT INTO ' . $sendtable . ' (`id`, `message`, `userid`, `campaign_id`, `is_scheduled`, `scheduled_time`, `created_at`, `updated_at`, `unicode_type`, `senderid`, `service_id`, `sms_type`, `is_refund`, `other_operator`, `request_code`, `campaign_name`, `is_picked`, `numbers_count`, `msg_credit`,  `charset`, `senderid_name`,  `original_url`, `url_status`, `pe_id`, `template_id`,`gvsms`,`ip_address`,`method`,`form_type`,`cut_off_value`,`route`,`job_id`,`schedule_sent`,`sent_at`,`cut_off`,`cut_off_throughput`,`total_cutting`) VALUES (NULL, "' . $msg . '", "' . $userid. '", "' . $campaign_id . '", "' . $is_schedule . '", "' . $schdate . '", NOW(), NOW(), "'.$text_type.'", "' . $sid . '" , "' . $az_routeid . '", "' . $_REQUEST['send_type'] . '", ' . $is_refund . ', NULL, "", "' . $campaign_name . '", 0, "' . $count . '", "' . $msgcredit . '",  "utf-8", "' . $senderid_name . '",  "' . $orig_url . '", ' . $url_status . ', "' . $pe_id . '", "' . $template_id . '", "' . $gvsms . '", "' . $ip_address . '"
                    , "' . $method . '", "' . $form_type . '", "0","'.$route_name.'","'.$job_id.'","'.$schedule_sent.'","'.$sent_at.'","'.$cutstatus.'","'.$random_cutoff.'","'.$count_cutoff_data.'")';


                    $credit_refund=$count_cutoff_data*$msgcredit;
                }
                else
                {
                $q = 'INSERT INTO ' . $sendtable . ' (`id`, `message`, `userid`, `campaign_id`, `is_scheduled`, `scheduled_time`, `created_at`, `updated_at`, `unicode_type`, `senderid`, `service_id`, `sms_type`, `is_refund`, `other_operator`, `request_code`, `campaign_name`, `is_picked`, `numbers_count`, `msg_credit`,  `charset`, `senderid_name`,  `original_url`, `url_status`, `pe_id`, `template_id`,`gvsms`,`ip_address`,`method`,`form_type`,`cut_off_value`,`route`,`job_id`,`schedule_sent`,`sent_at`) VALUES (NULL, "' . $msg . '", "' . $userid. '", "' . $campaign_id . '", "' . $is_schedule . '", "' . $schdate . '", NOW(), NOW(), "'.$text_type.'", "' . $sid . '" , "' . $az_routeid . '", "' . $_REQUEST['send_type'] . '", ' . $is_refund . ', NULL, "", "' . $campaign_name . '", 0, "' . $count . '", "' . $msgcredit . '",  "utf-8", "' . $senderid_name . '", "' . $orig_url . '", ' . $url_status . ', "' . $pe_id . '", "' . $template_id . '", "' . $gvsms . '", "' . $ip_address . '"
                    , "' . $method . '", "' . $form_type . '", "0","'.$route_name.'","'.$job_id.'","'.$schedule_sent.'","'.$sent_at.'")';
                }
                mysqli_set_charset($dbc, 'utf8');
                $rs = mysqli_query($dbc, $q)or die(mysqli_error($dbc));
                        //echo "<pre>"; print_r($_REQUEST); echo "</pre>"; echo "2";exit();
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

            $tracking_key = ((strpos(trim($_REQUEST['message']), TRACKINGURL) !== false) ? TRACKINGURL : '');
            $char_set=$_REQUEST['char_set'];
            $meta_data="?smpp?PEID=$pe_id&TID=$template_id";

            if($count_cutoff>0 && !empty($cutoff_num))
            {
                $send_mob_num=$insert_data;
                $send_cut_off_num= $cut_off_data;

                        $c=0;
                foreach ($send_cut_off_num as $value) 
                {
                    $mob_without = str_replace("+91","",trim($value));
                    $msg=$msgdata[$mob_without];
                    $msgcredit=$credit_arr[$mob_without];
                    $msg_len=$charcount_arr[$mob_without];
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

                    $is_picked = 0;
                    $value = trim($value);
                    $num_count[] = "$value";
                    $num = "$value";
                    $mob_num[]=$num;
                    // if ($tracking_key != '') {
                        if($check_track_btn=='tracking_url_btn')
                        {
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
                        $strTrack[] = '(NULL, "' . $userid . '", "' . $rId . '", 0, "' . $num . '", "' . $subRandNo . '", "' . $randNo . '",  "' . $original_url . '",  0, NOW(),"'.$job_id.'","'.$campaign_name.'","'.$is_schedule.'")';
                    } else {
                        $msg1 = $msg;
                        $original_url = $orig_url;
                    }

                    if (!empty($original_url_dynamic)) {
                        $subRandNo="";
                        $randNo="";
                        $original_url2="";
                        $subRandNo=$subRandNo_arr[$mob_without];
                        $randNo=$randNo_arr[$mob_without];
                        $original_url2=$original_url_dynamic[$mob_without];

                        
                        $strTrack2[] = '(NULL, "' . $userid . '", "' . $rId . '", 0, "' . $num . '", "' . $subRandNo . '", "' . $randNo . '",  "' . $original_url2 . '",  0, NOW(),"'.$job_id.'","'.$campaign_name.'","'.$is_schedule.'")';
                    }

                    if ($pe_id == '') {
                        $is_picked = 1;
                        $status = 'Failed';
                        $err_code = 'PID';
                        $status_id = 2;
                    }
                    
                        $cut_off_status="Yes";
                        $is_picked=1;
                    

                    if($char_set=='Unicode')
                    {  
                        $unicode_type=1;
                        $send_msg=rawurlencode($msg1);
                    }
                    else
                    {
                        $unicode_type=0;
                        if(strpos($msg1, '%') !== false || strpos($msg1, "'") !== false || strpos($msg1, "+") !== false){
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

                    /*if(strpos($msgdata, "+") !== false)
                    {
                        $msgdata = str_replace('+', '\+', $msgdata);
                    }*/
                    $master_job_id=$this->random_strings(20);
                    $cut_status=$new_cut_off_status;

                        if($method=='groups')
                        {
                            $group_name=$this->get_contact_group($num_without,$num_with);
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
                    $str[] = '(NULL, "' . $rId . '", "' . $msg1 . '", "'.$num.'", NOW(), "' . $senderid_name . '", "' . $service_name . '", "", "' . $is_picked . '", "' . $priority . '", "' . $is_schedule . '", "' . $schdate . '", "' . $msgcredit . '", "' . $userids . '", "' . $is_flash . '", "' . $cut_status . '", "' . $err_code . '", "' . $status_id . '", "'.$route_name.'", "'.$msg_len.'", "'.$job_id.'", "'.$schedule_sent.'", "'.$parent_id.'", "'.$sent_at.'","'.$cut_off_status.'","'.$master_job_id.'","'.$send_msg.'","'.$unicode_type.'","'.$meta_data.'","'.$operator_name.'")';
                }

                }
                else
                {
                    $send_mob_num=$v_num;
                    $send_cut_off_num= [];
                }

                    $c=0;
                foreach ($send_mob_num as $value) 
                {
                    $mob_without = str_replace("+91","",trim($value));
                    $msg=$msgdata[$mob_without];
                    $msgcredit=$credit_arr[$mob_without];
                    $msg_len=$charcount_arr[$mob_without];
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
                /*  if ($isPic == false) {
                        $is_picked = 0;
                    } else {
                        $is_picked = 1;
                    }*/
                    $is_picked = 0;
                    $value = trim($value);
                    $num_count[] = "$value";
                    $num = "$value";
                    $mob_num[]=$num;
                    // if ($tracking_key != '') {
                        if($check_track_btn=='tracking_url_btn')
                        {
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
                        $strTrack[] = '(NULL, "' . $userid . '", "' . $rId . '", 0, "' . $num . '", "' . $subRandNo . '", "' . $randNo . '",  "' . $original_url . '",  0, NOW(),"'.$job_id.'","'.$campaign_name.'","'.$is_schedule.'")';
                    } else {
                        $msg1 = $msg;
                        $original_url = $orig_url;
                    }


                    if (!empty($original_url_dynamic)) {
                        $subRandNo="";
                        $randNo="";
                        $original_url2="";
                        $subRandNo=$subRandNo_arr[$mob_without];
                        $randNo=$randNo_arr[$mob_without];
                        $original_url2=$original_url_dynamic[$mob_without];

                        
                        $strTrack2[] = '(NULL, "' . $userid . '", "' . $rId . '", 0, "' . $num . '", "' . $subRandNo . '", "' . $randNo . '",  "' . $original_url2 . '",  0, NOW(),"'.$job_id.'","'.$campaign_name.'","'.$is_schedule.'")';
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

                            if(!empty($blockNum))
                        {
                        
                                if(in_array($num, $blockNum))
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
                        $cut_off_status="No";
                        


                    if($char_set=='Unicode')
                    {  
                        $unicode_type=1;
                        $send_msg=rawurlencode($msg1);
                    }
                    else
                    {
                        $unicode_type=0;
                        if(strpos($msg1, '%') !== false || strpos($msg1, "'") !== false || strpos($msg1, "+") !== false){
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
                    if($method=='groups')
                        {
                            $group_name=$this->get_contact_group($num_without,$num_with);
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
                    
                    $str[] = '(NULL, "' . $rId . '", "' . $msg1 . '", "'.$num.'", NOW(), "' . $senderid_name . '", "' . $service_name . '", "", "' . $is_picked . '", "' . $priority . '", "' . $is_schedule . '", "' . $schdate . '", "' . $msgcredit . '", "' . $userids . '", "' . $is_flash . '", "' . $status . '", "' . $err_code . '", "' . $status_id . '", "'.$route_name.'", "'.$msg_len.'", "'.$job_id.'", "'.$schedule_sent.'", "'.$parent_id.'", "'.$sent_at.'","'.$cut_off_status.'","'.$master_job_id.'","'.$send_msg.'","'.$unicode_type.'","'.$meta_data.'","'.$operator_name.'")';
                }
            

                $vsms=$_REQUEST['vsms'];
        
                if($vsms=='vsms' && $_REQUEST['is_schedule'] != '1')
                {
                    $verified_sms=$this->vsms_dynamic($v_num,$messages);
                
                }


                if($_REQUEST['is_schedule'] != '1')
                {
                
                    get_last_activities($u_id,"Dynamic SMS Send. Job Id: $job_id",@$login_date,@$logout_date);
                    $query_data = array_chunk($str, 10000);
                    $char_set=$_REQUEST['char_set'];
                    $is_schedule=$_REQUEST['is_schedule'];

                

                    $array = array('query_data' => $query_data,'msg_job_id'=>$job_id);
                    $filename=$job_id."_dynamic_".time().".json";
                    $file_path="classes/sent_sms/".$filename;
                    $fp = fopen($file_path, 'w+');
                    fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
                    fclose($fp);
                    $pyout = exec("/var/www/html/itswe_panel/python-venv/bin/python3 /var/www/html/itswe_panel/controller/rnd/message_sending_master.py $filename  &");
                }
                else
                {

                        $char_set=$_REQUEST['char_set'];
                        $is_schedule=$_REQUEST['is_schedule'];
            
                        get_last_activities($u_id,"Dynamic SMS Scheduled for Date:$schdate and Job Id: $job_id",@$login_date,@$logout_date);
                        $query_data = array_chunk($str, 5000);
                    
                        $array = array('query_data' => $query_data,'msg_job_id'=>$job_id);
                        $filename="schedule_msg_".time().".json";
                        $file_path="classes/schedule_sms/".$filename;
                        $fp = fopen($file_path, 'w+');
                        fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
                        fclose($fp);


                        $pyout = exec("/var/www/html/itswe_panel/python-venv/bin/python3 /var/www/html/itswe_panel/controller/rnd/insert_schedule_master.py $filename > /dev/null 2>/dev/null &");

                            $new_send_file="run_schedule_sms_".time().".php";
                            copy("/var/www/html/itswe_panel/controller/classes/run_schedule_sms.php", "/var/www/html/itswe_panel/controller/classes/schedule_sms/".$new_send_file);

                            $array_schedule = array('php_file' => $new_send_file,'schedule_time' =>$schdate,'message_id' =>$job_id);
                            $schedule_filename="scheduler.json";
                            $file_path2="classes/".$schedule_filename;


                            $data_results = file_get_contents($file_path2);
                            $tempArray = json_decode($data_results);

                            //append additional json to json file
                            $tempArray[] = $array_schedule ;
                            $jsonData = json_encode($tempArray);

                            file_put_contents($file_path2, $jsonData);
                }
                    if($check_track_btn=='tracking_url_btn')
                    {
                        // if ($tracking_key != '') {
                        $track_data = array_chunk($strTrack, 5000);
                        foreach ($track_data as $value) {
                            $tqr = "INSERT INTO `az_temp_trackingkey`(`id`, `userid`, `msgid`, `numid`, `number`, `sub_track_key`, `tracking_key`, `original_url`, `status`, `create_date`,`job_id`,`campaign_name`,`is_scheduled`) VALUES " . implode(',', $value);
                            $rst = mysqli_query($dbc, $tqr);
                        }
                    }


                
                    if(!empty($original_url_dynamic))
                    {
                        $track_data2 = array_chunk($strTrack2, 5000);
                        foreach ($track_data2 as $value) {
                            $tqr2 = "INSERT INTO `az_temp_trackingkey`(`id`, `userid`, `msgid`, `numid`, `number`, `sub_track_key`, `tracking_key`, `original_url`, `status`, `create_date`,`job_id`,`campaign_name`,`is_scheduled`) VALUES " . implode(',', $value);
                            $rst = mysqli_query($dbc, $tqr2);
                        }
                    }
                
                    $rs2 = mysqli_query($dbc, "UPDATE `az_credit_manage` SET balance = (balance - $total_credit) WHERE userid = '{$_SESSION['user_id']}' AND az_routeid = '{$az_routeid}'")or die(mysqli_error($dbc));
        
                    $this->update_adminbalance($idss,$credit,$az_routeid);
                    /*low balance alert start*/

 

                    if($credit_refund!=0)
                    {

                            $ids3 = implode(',', $idss); 
                            $admin_ids_val = $ids3;
                            
                            $admin_ids=$this->fetch_admin_ids($admin_ids_val);

                        $refund=$this->adminRefund($idss,$az_routeid,$credit_refund);
                        $sql_insert_smart_cutoff="insert into smart_cutoff(`userid`,`created_date`,`job_id`,`msg_count`,`throughput`,`cut_off`,`percent`,`routeid`,`min_value`,`parent_id`) values('".$userid."','".$sent_at."','$job_id','$total_num','$cut_off_throughput','$credit_refund','$random_cutoff','$az_routeid','$min_cut_value','$admin_ids')";

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

                            for($k=0;$k<count($user_ids);$k++)
                            {

                                if($current_balance[$k]<$bal_limit[$k])
                                {
                                                $sql_user="select client_name,mobile_no from az_user where userid='".$user_ids[$k]."' limit 1";

                                                    $result_user=mysqli_query($dbc,$sql_user) or die(mysqli_error($dbc));
                                                    $row=mysqli_fetch_array($result_user);
                                                    $client_name=$row['client_name'];
                                                    if($mobile_no[$k]=='' || empty($mobile_no[$k]))
                                                    {
                                                        $mobile_nos=$row['mobile_no'];
                                                    }
                                                    else
                                                    {
                                                        $mobile_nos= $mobile_no[$k];
                                                    }
                                                    
                                                    $sql_credit_route="select `az_routeid`,`balance` from az_credit_manage where userid='".$user_ids[$k]."'";
                                                    $result_credit_route=mysqli_query($dbc,$sql_credit_route) or die(mysqli_error($dbc));

                                                    while($row_credit_route=mysqli_fetch_array($result_credit_route))
                                                    {
                                                            $route_id=$row_credit_route['az_routeid'];
                                                            $route_name=$this->fetch_route_name($route_id);
                                                            $route_bal=$row_credit_route['balance'];
                                                            $route_dtls.=$route_name ."  ".$route_bal." \n";
                                                            
                                                    }
                                                
                                                    $msg="Hello $client_name , Your account balance is low .\n Please recharge your account.";
                                                    $msg=$msg." ".$route_dtls;
                                                    
                                    $msg=str_replace(' ', '%20', $msg);
                                    $url = "https://vapio.in/api.php?username=sam&apikey=m3Sr9ufrPDaj&senderid=MDSACC&route=TRANS&mobile=$mobile_nos&text=$msg";
                                                
                            
                                    $ch  = curl_init($url);
                                    curl_setopt($ch, CURLOPT_HTTPGET, "POST");
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                    $result = curl_exec($ch);
                    
                                }
                                    
                            }


                        }

            
                        //end of alert
                    }
            unset($strTrack2);
            unset($preview);
            unset($message);
            unset($num_count);
            unset($v_num);
            unset($user_ids);
            unset($send_cut_off_num);
            unset($str);
            unset($bal_limit);
            unset($mob_num);
            unset($current_balance);
            unset($mobile_no);
            unset($strTrack);
            unset($cut_off_data);
            unset($cutoff_num);
            unset($tempArray);

            unset($numbers);
    }