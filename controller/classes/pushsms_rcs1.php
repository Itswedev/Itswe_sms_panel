<?php

session_start();
include('last_activities.php');
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
error_reporting(0);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

class pushsms_rcs1 extends common{

function sendRCSSMSSave($userid) {
        
        global $dbc;
        ini_set('date.timezone', 'Asia/Kolkata');
        ini_set('max_execution_time', 300);
        header('Content-type: text/html; charset=utf-8');


        $u_id=$_SESSION['user_id'];
        $az_routeid = '5';
        $bot_type=$_REQUEST['bot_type']; 
        $template_name=$_REQUEST['template'];  
        $route_name= $this->fetch_route_name($az_routeid);

        //get_last_activities($u_id,'RCS SMS Send',@$login_date,@$logout_date);
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
                
                $num_count[] = "$value";
                $v_num[]="+91$value";
            }
        }

        $num_count=array_unique($num_count);
        $v_num=array_unique($v_num);
        $v_num=array_filter($v_num, 'strlen');
        $check_numbers=$v_num;
        $num_split=array_chunk($v_num, 5000);
        $check_numbers_arr=array_chunk($v_num, 10000);

        $parent_id=$this->fetch_parent_id($userid);

         if($parent_id=="4530" || $userid=="4742")
        {
            
              $blockNum1 = $this->getBlockNumbers_json();  
              $blockNum = array_intersect($num_count, $blockNum1);
            
        }
        else
        {
            foreach($num_split as $mob_numbers)
            {

              $blockNum = $this->getBlockNumbers($mob_numbers);  
            }
        }


        if(!empty($blockNum))
        {
            $blockNum=array_unique($blockNum);
        }
        
        $total_num=count($v_num);
        $credit = $total_num * $msgcredit;
        $userid = $_SESSION['user_id'];

        //check template type
        $sql_rcs="select template_type from rcs_template where user_id='".$u_id."' and bot_type='".$bot_type."' and template_name='".$template_name."'";
        $result_rcs=mysqli_query($dbc,$sql_rcs);
        $rowcount=mysqli_num_rows($result_rcs);
        if($rowcount > 0)
        {
            while($row = mysqli_fetch_array($result_rcs))
            {
                $template_type = $row['template_type'];
            }
        }
        $sms_rate=0;

        if($template_type=='simple_text')
        {
            $rcs_rate="select rcs_sms_rate from settings where userid='".$u_id."'";
            $result_rcs_rate=mysqli_query($dbc,$rcs_rate);
            while($row_rate = mysqli_fetch_array($result_rcs_rate))
            {
                $sms_rate = $row_rate['rcs_sms_rate'];
            }
        }
        else if($template_type=='rich_card')
        {
            $rcs_rate="select rcs_rich_card_rate from settings where userid='".$u_id."'";
            $result_rcs_rate=mysqli_query($dbc,$rcs_rate);
            while($row_rate = mysqli_fetch_array($result_rcs_rate))
            {
                $sms_rate = $row_rate['rcs_rich_card_rate'];
            }
        }

        //$msgcredit=$sms_rate;


        $credit=$credit*$sms_rate;


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
            $sendtable = RCSJOBS . $this->getScheduleDateTimeMonth($_POST['scheduleDateTime']);
            $sendtabledetals = RCSMASTER ;
        } else {
            $is_schedule = 0;
            $schedule_sent=1;
            $sent_at=date('Y-m-d H:i:s');
            $schdate = '0000-00-00 00:00:00';
            $req = '';
            $sendtable = RCSJOBS . CURRENTMONTH;
            $sendtabledetals = RCSMASTER ;
        }
        



        $campaign_name = "";
        $campaign_name = isset($_POST['campaign_name']) && !empty($_POST['campaign_name']) ? $_POST['campaign_name'] : "";
        $job_id=$this->random_strings(15);



        $q = 'INSERT INTO ' . $sendtable . ' (`id`,  `userid`,  `is_scheduled`, `scheduled_time`, `created_at`, `template_name`,`template_type`,  `campaign_name`, `is_picked`, `numbers_count`, `msg_credit`, `ip_address`,`method`,`job_id`,`schedule_sent`,`sent_at`,`route`) VALUES (NULL, "' . $userid. '", "' . $is_schedule . '", "' . $schdate . '", NOW(),"'.$template_name.'", "Rich Card" , "' . $campaign_name . '", 0, "' . $total_num . '", "' . $credit . '", "' . $ip_address . '"
            , "' . $method . '","'.$job_id.'","'.$schedule_sent.'","'.$sent_at.'","'.$az_routeid.'")';


        //mysqli_set_charset($dbc, 'utf8');
        $rs = mysqli_query($dbc, $q)or die(mysqli_error($dbc));
                
        if (!$rs) {
            return array('status' => false, 'msg' => 'Failed');
        }

        $rId = mysqli_insert_id($dbc);


        if($_REQUEST['is_schedule']!='1')
        {
            $status   = 'Submitted';
        }
        else
        {
            $status   = 'Scheduled';
        }

        $sql="select * from rcs_cred where user_id='".$userid."' and bot_type='".$bot_type."' ";
        $result=mysqli_query($dbc,$sql);
        $rowcount=mysqli_num_rows($result);
        if($rowcount > 0)
        {
            while($row = mysqli_fetch_array($result))
            {
                $rcs_cred_id = $row['id'];
                $cred_bot_type = $row['bot_type'];
                $access_token = $row['access_token'];
                $bot_id = $row['client_id'];
                $secret_code = $row['secret_code'];


            }
        }


       
        /*Capability check start*/

        
         

          /*foreach($num_count as $number)
        {
            $number="+91".$number;
            array_push($check_numbers,$number);

        }*/
       /* print_r($check_numbers);*/

       foreach($check_numbers_arr as $check_numbers)
       {

        $resp_status = $this->check_capability($check_numbers,$access_token,$bot_id);
        //echo $resp_status;
        /*Generate new access token start*/
        if($resp_status=="invalid_token")
        {

           $client_val = $bot_id.":".$secret_code;

        $authorization = base64_encode($client_val);
        $endpoint = 'https://auth.virbm.in/auth/oauth/token?grant_type=client_credentials';

        $data = array(
          'grant_type' => 'client_credentials'
        );

        $headers = array(
          'Accept: application/json',
          'Authorization: Basic '.$authorization
        );

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $endpoint);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($curl);

        if ($response === false) {
          $error = curl_error($curl);
          // Handle the error accordingly
        } else {
          // Process the response
          $responseData = json_decode($response, true);
          if($responseData['access_token']!='')
                                {
                                    $access_token = $responseData['access_token'];
                                    $sql="update rcs_cred set access_token='".$access_token."' where user_id='".$userid."' and bot_type='".$bot_type."'";
                                    $result=mysqli_query($dbc,$sql) or die(mysqli_error($dbc));

                                    
                                }
            }
            curl_close($curl);
             $resp_status = $this->check_capability($check_numbers,$access_token,$bot_id);

        }
        $rcs_enabled_numbers=json_decode($resp_status,true);
        //$enabled_numbers = $rcs_enabled_numbers['rcsEnabledContacts'];
        $enabled_numbers_arr[] = $rcs_enabled_numbers['rcsEnabledContacts'];
        //$disabled_numbers=array_diff($check_numbers,$rcs_enabled_numbers['rcsEnabledContacts']);
        $disabled_numbers_arr[]=array_diff($check_numbers,$rcs_enabled_numbers['rcsEnabledContacts']);
        
    }

  

       

/*        echo $resp_status;
*/
      /*  exit();*/
        

      
     /*print_r($rcs_enabled_numbers);*/

   
       
    /*print_r($disabled_numbers);



*/
    
        foreach($disabled_numbers_arr as $disabled_numbers)
        {
            foreach ($disabled_numbers as $value) 
            {
                $is_picked = 1;
                $value = trim($value);
                $status='RCS Disabled';
                $master_job_id=$this->random_strings(20);
                $str[] = '(NULL, "' . $rId . '", "'.$value.'","' . $is_schedule . '", "' . $schdate . '", NOW(),"'.$is_picked.'",0,"' . $msgcredit . '",0,"'.$status.'", "' . $userid . '", "'.$schedule_sent.'","'.$master_job_id.'","'.$job_id.'",NULL, "'.$sent_at.'","'.$parent_id.'")';
            }
        }
       

            /*print_r($str);*/
        $query_data = array_chunk($str, 5000);
           
        foreach($query_data as $values) {
           
            $insert_val=implode(",",$values);
            $count_val=count($values);

            $query_master_tbl_insert= "INSERT INTO $sendtabledetals (`id`, `message_id`, `mobile_number`, `is_scheduled`, `scheduled_time`, `created_at`,`is_picked`,`unicode_type`, `msgcredit`,`delivered_date`, `status`,`userid`,`schedule_sent`,`master_job_id`,`msg_job_id`,`cut_off`,`sent_at`,`parent_id`) VALUES $insert_val";
            $result_master=mysqli_query($dbc,$query_master_tbl_insert);
        }

        // $filename="rcs_testing.json";
        // $file_path="classes/rcs_logs/".$filename;
        // $fp = fopen($file_path, 'a+');
        // fwrite($fp, json_encode($query_data));   // here it will print the array pretty
        // fclose($fp);
    
        


        $str=[];

        foreach($enabled_numbers_arr as $enabled_numbers)
        {
            foreach ($enabled_numbers as $value) 
            {
                $is_picked = 0;
                $value = trim($value);
                $status='Submitted';
                $master_job_id=$this->random_strings(20);
                $str[] = '(NULL, "' . $rId . '", "'.$value.'","' . $is_schedule . '", "' . $schdate . '", NOW(),"'.$is_picked.'",0,"' . $msgcredit . '",0,"'.$status.'", "' . $userid . '", "'.$schedule_sent.'","'.$master_job_id.'","'.$job_id.'",NULL, "'.$sent_at.'","'.$parent_id.'")';



            }
        }
        

            

        $query_data = array_chunk($str, 5000);


        foreach($query_data as $values) {
           
            $insert_val=implode(",",$values);
            $count_val=count($values);

            $query_master_tbl_insert= "INSERT INTO $sendtabledetals (`id`, `message_id`, `mobile_number`, `is_scheduled`, `scheduled_time`, `created_at`,`is_picked`,`unicode_type`, `msgcredit`,`delivered_date`, `status`,`userid`,`schedule_sent`,`master_job_id`,`msg_job_id`,`cut_off`,`sent_at`,`parent_id`) VALUES $insert_val";
            $result_master=mysqli_query($dbc,$query_master_tbl_insert);
        }


        

        /*send sms to rbm*/
        $data_send = escapeshellarg(json_encode([$job_id, $bot_id, $template_name, $access_token]));

       
      
        exec("php /var/www/html/itswe_panel/controller/classes/sent_sms_rbm.php $data_send > /dev/null 2>/dev/null &");
      

        $rs2 = mysqli_query($dbc, "UPDATE `az_credit_manage` SET balance = (balance - $credit) WHERE userid = '{$_SESSION['user_id']}' AND az_routeid = '{$az_routeid}'")or die(mysqli_error($dbc));
 
            $this->update_adminbalance($idss,$credit,$az_routeid);


        if ($rs2) {
          //  mysqli_commit($dbc);

            return array('status' => true, 'msg' => 'Success');
        } else {
           // mysqli_rollback($dbc);
            return array('status' => false, 'msg' => 'Failed');
        }



        /*end sending process*/
       /*print_r($disabled_numbers);*/

       

        /*Generate access token end*/

        /*Capability check end*/



 /*       foreach($numbers as $number)
        {
            $number="+91".$number;

        echo $msg_id =  $this->random_strings(10);

       $endpoint = 'https://api.virbm.in/rcs/v1/phones/'.$number.'/agentMessages/async?sendGipLink=false&messageId='.$msg_id.'&botId='.$bot_id;


$data = array(
    'contentMessage' => array(
        'templateMessage' => array(
            'templateCode' => $template_name
        )
    )
);



$headers = array(
    'Content-Type: application/json',
    'Authorization: Bearer '.$access_token
);



$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, $endpoint);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($curl);

curl_close($curl);

echo $response;
}*/


        /*$sql="select * from rcs_template where user_id='".$userid."' and bot_type='".$bot_type."' and template_name='".$template_name."'";
        $result=mysqli_query($dbc,$sql);
        $rowcount=mysqli_num_rows($result);
        if($rowcount > 0)
        {
            while($row = mysqli_fetch_array($result))
            {
                $rcs_cred_id = $row['id'];
                $cred_bot_type = $row['bot_type'];
                $access_token = $row['template_name'];
                $bot_id = $row['client_id'];


            }
        }*/




    }


public function update_adminbalance($idss,$credit,$routeid)
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


public function userCreditBalance($userid, $routeid) 
{
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


public  function checkBalance($userid, $routeid, $credit) {
        global $dbc;
        if (!empty($userid)) {
            $ids = trim(implode(',', $userid));

            $sql_user="select userid from az_user where userid in ($ids) and user_role='mds_ad'";
            $result_user=mysqli_query($dbc,$sql_user);
            while($row_user=mysqli_fetch_array($result_user))
            {
                $ids1[]=$row_user['userid'];
            }
           /* print_r($ids1);*/
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


public  function getOverSeelingUserids($userid) {
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

public function fetch_route_name($routeid = null) {
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


public function check_capability($check_numbers,$access_token,$bot_id)
{
        if(!empty($check_numbers))
        {
            $endpoint = "https://api.virbm.in/rcs/bot/v1/$bot_id/rcsEnabledContacts";

            $data = array(
                'users' => $check_numbers
            );

            /*print_r($data);*/
            $headers = array(
                'Content-Type: application/json',
                'Authorization: Bearer '.$access_token
            );

           /* print_r($headers);*/

            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, $endpoint);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($curl);

            curl_close($curl);

            //echo $response;
        }

        $response_arr=json_decode($response,true);
        if (array_key_exists("error",$response_arr))
        {
            $resp_status=$response_arr["error"];
        }
        else
        {
            $resp_status=$response;
        }
        

        return $resp_status;
        
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

public function fetch_parent_id($userid) {
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

public function getBlockNumbers($mob_num) {
        global $dbc;
        $userid=$_SESSION['user_id'];
        $parent_id=$this->fetch_parent_id($userid);
        $mobile_nos=implode(",",$mob_num);
        $q = "SELECT `numbers` FROM `az_blocknumbers` where ((userid='$userid') or (userid='$parent_id')) and status=0 and (numbers in ($mobile_nos))";
        $rs = mysqli_query($dbc, $q);
        $numbers = array();
        if (mysqli_num_rows($rs)) {
            while ($row = mysqli_fetch_assoc($rs)) {
                $numbers[] = $row['numbers'];
            }
        }
        return $numbers;
    }


public function getBlockNumbers_json() {
        global $dbc;
       
       $dnd_file = "/var/www/html/itswe_panel/controller/classes/block.json";

        $jsonString = file_get_contents($dnd_file);
        $data = json_decode($jsonString, true);
        $numbers=$data['mobile'];
        return $numbers;
    }


}
?>