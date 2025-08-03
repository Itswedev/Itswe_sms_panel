<?php

session_start();
require_once('../include/config.php');
require_once('../include/connection.php');

// require_once('../include/dnd_dbconnection.php');
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
$log_file = "/var/log/php_errors.log";
 
 error_reporting(E_ALL); 
 
// setting error logging to be active
ini_set("log_errors", TRUE); 
  
// setting the logging file in php.ini
ini_set('error_log', $log_file);
 error_reporting(0);

//  ini_set('display_errors', 1);
//  ini_set('display_startup_errors', 1);
//  error_reporting(E_ALL);


 

function __autoload($class) {
    require_once('../controller/classes/' . strtolower($class) . '.php');
}


$obj = new pushsms();
$user_id=$_SESSION['user_id'];

global $dbc;

//$dlr_url=55;
   
$QuerySelectUser= "select userid from az_user where `userid`=$user_id and user_status=1";

$result = mysqli_query($dbc, $QuerySelectUser);

$active_user=mysqli_num_rows($result);

if($active_user==0)
{
    echo "User Is Inactive.";
    exit;
}

$ip_address = get_ip_address1();
 $user_role=$_SESSION['user_role'];
if($user_role=='mds_rs' || $user_role=='mds_ad')
{
    echo "The reseller was unable to send messages.";
        exit;

}
if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'sendSMSsave') { 
  $is_schedule=$_REQUEST['is_schedule'];
  $schedule_dt=$_REQUEST['scheduleDateTime'];
    $click_btn=$_REQUEST['btn_send'];

  /*  if($schedule_dt!='' && $click_btn=="send_sms")
    {
        echo "Please Click Schedule Button";
        exit;
    } 
    else
    {*/
        

 
        if($is_schedule==1)
        {
            $rs = $obj->sendScheduleSMSSave($user_id);    
        }
        else{

          
            $rs = $obj->sendQuickSMSSave($user_id);  
            
        }

//      print_r($rs);
         
    //}





   
    $dlr_url=$rs['dlr_url'];
if ($rs['status'] == true && $rs['msg'] == 'Success') {
    $duplicate_count=0;
    if($is_schedule!='1')
    {

      $_SESSION['succ'] = "Message Successfully Send";
      $duplicate_count=$rs['duplicate_count'];

     $msg="Message Successfully Send";

     if($duplicate_count>0)
      {
            echo $msg.="|You are processing messages with $duplicate_count duplicate numbers.";
      }
      else
      {
        echo $msg.="|$duplicate_count";
      }
      
    }
    else
    {
        $_SESSION['succ'] = "Message Successfully Scheduled";
        $duplicate_count=$rs['duplicate_count'];
         $msg="Message Successfully Scheduled";
          if($duplicate_count>0)
          {
                echo $msg.="|You are processing messages with $duplicate_count duplicate numbers.";
          }
          else
          {
            echo $msg.="|$duplicate_count";
          }
        //echo "Message Successfully Scheduled";
    }
      
       // header("Location:../dashboard.php?page=bulksms"); exit();
    } else if (!$rs['status'] && $rs['msg'] == 'Less Balance') {
        $_SESSION['err'] = "You have not enough credit to send sms";
        echo "You have not enough credit to send sms";
        //header("Location:../dashboard.php?page=bulksms"); exit();
    }
    else if (!$rs['status'] && $rs['msg'] == 'Template id empty') {
        $_SESSION['err'] = "Template ID should not be an empty";
        echo "Template ID should not be an empty";
        //header("Location:../dashboard.php?page=bulksms"); exit();
    }
    else if (!$rs['status'] && $rs['msg'] == 'Parent Less Balance') {
        $_SESSION['err'] = "Less Parent Balance";

        echo "Less Parent Balance";

      //  header("Location:../dashboard.php?page=bulksms"); exit();
    }
    else if (!$rs['status'] && $rs['msg'] == 'Sender ID Blocked') {
        $_SESSION['err'] = "Sender ID Blocked";
        echo "Sender ID Blocked";
        //header("Location:../dashboard.php?page=bulksms"); exit();
    }
     else if (!$rs['status'] && $rs['msg'] == 'Unicode contents') {
        $_SESSION['err'] = "Your message contents has unicode characters";
        echo "Your message contents has unicode characters";
       // header("Location:../dashboard.php?page=bulksms"); exit();
    } else if (!$rs['status'] && $rs['msg'] == 'EmptyField') {
        $_SESSION['err'] = "Something went wrong while message posting, please try again!";
        echo "Something went wrong while message posting, please try again!";
      //  header("Location:../dashboard.php?page=bulksms"); exit();
    } else if (!$rs['status'] && $rs['msg'] == 'InvalidToken') {
        $_SESSION['err'] = "Invalid Token, Please try again!";
       // header("Location: ../dashboard.php?page=bulksms"); exit();
        echo "Invalid Token, Please try again!";
    } else if (!$rs['status'] && $rs['msg'] == 'Template mismatch') {
        $_SESSION['err'] = "Invalid Template format";
        echo "Invalid Template format";
        //header("Location:../dashboard.php?page=bulksms");
        //exit();
    }
    else if (!$rs['status'] && $rs['msg'] == 'Back Time') {
        $_SESSION['err'] = "Invalid Schedule Time";
        echo "Invalid Schedule Time";
        //header("Location:../dashboard.php?page=bulksms");
        //exit();
    }
    else if (!$rs['status'] && $rs['msg'] == 'Unreliable message sending time') {
        $_SESSION['err'] = "Unreliable message sending time";
        echo "Unreliable message sending time";
        //header("Location:../dashboard.php?page=bulksms");
        //exit();
    }
    else if (!$rs['status'] && $rs['msg'] == 'Incorrect route selection') {
        $_SESSION['err'] = "Incorrect route selection";
        echo "Incorrect route selection";
        //header("Location:../dashboard.php?page=bulksms");
        //exit();
    } else {
        $_SESSION['err'] = "Error while sending sms, please contact to admin";
        echo "Error while sending sms, please contact to admin";
        //header("Location:../dashboard.php?page=bulksms"); exit();
    }
}



if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'sendCALLsave') { 
  $is_schedule=$_REQUEST['is_schedule'];
  $schedule_dt=$_REQUEST['scheduleDateTime'];
    $click_btn=$_REQUEST['btn_send'];

    if($schedule_dt!='' && $click_btn=="send_call")
    {
        echo "Please Click Schedule Button";
        exit;
    } 
    else
    {
         $rs = $obj->sendQuickCALLSave($user_id);    
    }
/*

    print_r($rs);
*/    $dlr_url=$rs['dlr_url'];
if ($rs['status'] == true && $rs['msg'] == 'Success') {
    $duplicate_count=0;
    if($is_schedule!='1')
    {

      $_SESSION['succ'] = "Call Successfully Send";
      $duplicate_count=$rs['duplicate_count'];

     $msg="Call Successfully Send";

     if($duplicate_count>0)
      {
            echo $msg.="|You are processing calls with $duplicate_count duplicate numbers.";
      }
      else
      {
        echo $msg.="|$duplicate_count";
      }
      
    }
    else
    {
        $_SESSION['succ'] = "Call Successfully Scheduled";
        $duplicate_count=$rs['duplicate_count'];
         $msg="Call Successfully Scheduled";
          if($duplicate_count>0)
          {
                echo $msg.="|You are processing calls with $duplicate_count duplicate numbers.";
          }
          else
          {
            echo $msg;
          }
        //echo "Message Successfully Scheduled";
    }
      
       // header("Location:../dashboard.php?page=bulksms"); exit();
    } else if (!$rs['status'] && $rs['msg'] == 'Less Balance') {
        $_SESSION['err'] = "You have not enough credit to send calls";
        echo "You have not enough credit to send sms";
        //header("Location:../dashboard.php?page=bulksms"); exit();
    } else if (!$rs['status'] && $rs['msg'] == 'Parent Less Balance') {
        $_SESSION['err'] = "Less Parent Balance";

        echo "Less Parent Balance";

      //  header("Location:../dashboard.php?page=bulksms"); exit();
    }  else if (!$rs['status'] && $rs['msg'] == 'EmptyField') {
        $_SESSION['err'] = "Something went wrong while message posting, please try again!";
        echo "Something went wrong while message posting, please try again!";
      //  header("Location:../dashboard.php?page=bulksms"); exit();
    }
    else if (!$rs['status'] && $rs['msg'] == 'Back Time') {
        $_SESSION['err'] = "Invalid Schedule Time";
        echo "Invalid Schedule Time";
        //header("Location:../dashboard.php?page=bulksms");
        //exit();
    }
    else if (!$rs['status'] && $rs['msg'] == 'Unreliable message sending time') {
        $_SESSION['err'] = "Unreliable message sending time";
        echo "Unreliable message sending time";
        //header("Location:../dashboard.php?page=bulksms");
        //exit();
    } else {
        $_SESSION['err'] = "Error while sending sms, please contact to admin";
        echo "Error while sending sms, please contact to admin";
        //header("Location:../dashboard.php?page=bulksms"); exit();
    }
}

if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'sendDynamicSMSSave') {  
    
   $is_schedule=$_REQUEST['is_schedule'];
   $schedule_dt=$_REQUEST['scheduleDateTime'];
   $click_btn=$_REQUEST['btn_send'];

   if($is_schedule==1)
   {
       $rs = $obj->sendDynamicScheduleSMSSave($user_id);    
   }
    else
    {
         $rs = $obj->advCustomizeSmsSave($user_id);    
    }
    // echo "asjgdf".$rs;
   // print_r($rs);


    /*

    print_r($rs);*/
    $dlr_url=$rs['dlr_url'];
    if ($rs['status'] == true && $rs['msg'] == 'Success') {
    $duplicate_count=0;
    if($is_schedule!='1')
    {

      $_SESSION['succ'] = "Message Successfully Send";
      $duplicate_count=$rs['duplicate_count'];

     $msg="Message Successfully Send";

     if($duplicate_count>0)
      {
            echo $msg.="|You are processing messages with $duplicate_count duplicate numbers.";
      }
      else
      {
        echo $msg.="|$duplicate_count";
      }
      
    }
    else
    {
        $_SESSION['succ'] = "Message Successfully Scheduled";
        $duplicate_count=$rs['duplicate_count'];
         $msg="Message Successfully Scheduled";
          if($duplicate_count>0)
          {
                echo $msg.="|You are processing messages with $duplicate_count duplicate numbers.";
          }
          else
          {
            echo $msg;
          }
        //echo "Message Successfully Scheduled";
    }
      
       // header("Location:../dashboard.php?page=bulksms"); exit();
    } else if (!$rs['status'] && $rs['msg'] == 'Less Balance') {
        $_SESSION['err'] = "You have not enough credit to send sms";
        echo "You have not enough credit to send sms";
        //header("Location:../dashboard.php?page=bulksms"); exit();
    } else if (!$rs['status'] && $rs['msg'] == 'Parent Less Balance') {
        $_SESSION['err'] = "Less Parent Balance";

        echo "Less Parent Balance";

      //  header("Location:../dashboard.php?page=bulksms"); exit();
    } else if (!$rs['status'] && $rs['msg'] == 'Unicode contents') {
        $_SESSION['err'] = "Your message contents has unicode characters";
        echo "Your message contents has unicode characters";
       // header("Location:../dashboard.php?page=bulksms"); exit();
    }
    else if (!$rs['status'] && $rs['msg'] == 'Sender ID Blocked') {
        $_SESSION['err'] = "Sender ID Blocked";
        echo "Sender ID Blocked";
        //header("Location:../dashboard.php?page=bulksms"); exit();
    }
     else if (!$rs['status'] && $rs['msg'] == 'EmptyField') {
        $_SESSION['err'] = "Something went wrong while message posting, please try again!";
        echo "Something went wrong while message posting, please try again!";
      //  header("Location:../dashboard.php?page=bulksms"); exit();
    } else if (!$rs['status'] && $rs['msg'] == 'InvalidToken') {
        $_SESSION['err'] = "Invalid Token, Please try again!";
       // header("Location: ../dashboard.php?page=bulksms"); exit();
        echo "Invalid Token, Please try again!";
    } else if (!$rs['status'] && $rs['msg'] == 'Template mismatch') {
        $_SESSION['err'] = "Invalid Template format";
        echo "Invalid Template format";
        //header("Location:../dashboard.php?page=bulksms");
        //exit();
    }
     else if (!$rs['status'] && $rs['msg'] == 'Unreliable message sending time') {
        $_SESSION['err'] = "Unreliable message sending time";
        echo "Unreliable message sending time";
        //header("Location:../dashboard.php?page=bulksms");
        //exit();
    }
    else if (!$rs['status'] && $rs['msg'] == 'Back Time') {
        $_SESSION['err'] = "Invalid Schedule Time";
        echo "Invalid Schedule Time";
        //header("Location:../dashboard.php?page=bulksms");
        //exit();
    }
    else if (!$rs['status'] && $rs['msg'] == 'Incorrect route selection') {
        $_SESSION['err'] = "Incorrect route selection";
        echo "Incorrect route selection";
        //header("Location:../dashboard.php?page=bulksms");
        //exit();
    } else {
        $_SESSION['err'] = "Error while sending sms, please contact to admin";
        echo "Error while sending sms, please contact to admin";
        //header("Location:../dashboard.php?page=bulksms"); exit();
    }
}




if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'sendRCSSMS') {  

    $is_schedule=$_REQUEST['is_schedule'];
    $schedule_dt=$_REQUEST['scheduleDateTime'];
    $click_btn=$_REQUEST['btn_send'];
/*
    if($schedule_dt!='' && $click_btn=="send_sms")
    {
        echo "Please Click Schedule Button";
        exit;
    } 
    else
    {*/
         $rs = $obj->sendRCSSMSSave($user_id);    
    //}

    $dlr_url=$rs['dlr_url'];
if ($rs['status'] == true && $rs['msg'] == 'Success') {
  
    if($is_schedule!='1')
    {

      $_SESSION['succ'] = "Message Successfully Send";
      echo "Message Successfully Send";
    }
    else
    {
        $_SESSION['succ'] = "Message Successfully Scheduled";
        echo "Message Successfully Scheduled";
    }
      
       // header("Location:../dashboard.php?page=bulksms"); exit();
    } else if (!$rs['status'] && $rs['msg'] == 'Less Balance') {
        $_SESSION['err'] = "You have not enough credit to send sms";
        echo "You have not enough credit to send sms";
        //header("Location:../dashboard.php?page=bulksms"); exit();
    } else if (!$rs['status'] && $rs['msg'] == 'Parent Less Balance') {
        $_SESSION['err'] = "Less Parent Balance";

        echo "Less Parent Balance";

      //  header("Location:../dashboard.php?page=bulksms"); exit();
    } else if (!$rs['status'] && $rs['msg'] == 'Unicode contents') {
        $_SESSION['err'] = "Your message contents has unicode characters";
        echo "Your message contents has unicode characters";
       // header("Location:../dashboard.php?page=bulksms"); exit();
    } else if (!$rs['status'] && $rs['msg'] == 'EmptyField') {
        $_SESSION['err'] = "Something went wrong while message posting, please try again!";
        echo "Something went wrong while message posting, please try again!";
      //  header("Location:../dashboard.php?page=bulksms"); exit();
    } else if (!$rs['status'] && $rs['msg'] == 'InvalidToken') {
        $_SESSION['err'] = "Invalid Token, Please try again!";
       // header("Location: ../dashboard.php?page=bulksms"); exit();
        echo "Invalid Token, Please try again!";
    } else if (!$rs['status'] && $rs['msg'] == 'Template mismatch') {
        $_SESSION['err'] = "Invalid Template format";
        echo "Invalid Template format";
        //header("Location:../dashboard.php?page=bulksms");
        //exit();
    }
    else if (!$rs['status'] && $rs['msg'] == 'Back Time') {
        $_SESSION['err'] = "Invalid Schedule Time";
        echo "Invalid Schedule Time";
        //header("Location:../dashboard.php?page=bulksms");
        //exit();
    } else {
        $_SESSION['err'] = "Error while sending sms, please contact to admin";
        echo "Error while sending sms, please contact to admin";
        //header("Location:../dashboard.php?page=bulksms"); exit();
    }
}

/*
function update_master_table($dlr_url)
    {
        global $dbc;
        $sent_sms=SENTSMS;
       
        //$dlr_url=55;
           
       echo $QuerySelect= "select * from sent_sms where `dlr_url`=$dlr_url";
 
        $result = mysqli_query($dbc, $QuerySelect);

        echo "Count ".mysqli_num_rows($result);
        echo "<br>";
       /* if (mysqli_num_rows($result) > 0) {*/

            /*while ($row = mysqli_fetch_assoc($result)) {
               
               echo $var1  = $row['sql_id'];
                
            }*/
       // }
        
        /*$queryUpdate="";
           if(mysqli_query($dbc,$queryInsert))
           {
                return 1;
           }
           else
           {
                return mysqli_error($dbc);
           }
        
    }*/



function sendSMS1($number, $msg) {
    $url = "http://buzzify.in/V2/http-api.php?apikey=xVoEWj7clf4iB5Pc&senderid=ACCINF&number=" . $number . "&message=" . urlencode($msg) . "&format=json";
    $res = curl_init();
    curl_setopt($res, CURLOPT_URL, $url);
    curl_setopt($res, CURLOPT_RETURNTRANSFER, true);
   $result = curl_exec($res);
    return $result;
}

function get_ip_address1() {
    global $HTTP_SERVER_VARS;
    if (isset($HTTP_SERVER_VARS)) {
        if (isset($HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR'])) {
            $ip = $HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($HTTP_SERVER_VARS['HTTP_CLIENT_IP'])) {
            $ip = $HTTP_SERVER_VARS['HTTP_CLIENT_IP'];
        } else {
            $ip = $HTTP_SERVER_VARS['REMOTE_ADDR'];
        }
    } else {
        if (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } else {
            $ip = getenv('REMOTE_ADDR');
        }
    }
    return $ip;
}

?>