<?php
session_start();
require_once('../include/config.php');
require_once('../include/connection.php');
require_once('../include/dnd_dbconnection.php');

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
$log_file = "/var/log/php_errors.log";
 
 error_reporting(E_ALL); 
 
// setting error logging to be active
ini_set("log_errors", TRUE); 
  
// setting the logging file in php.ini
ini_set('error_log', $log_file);
error_reporting(0);

function __autoload($class) {
    require_once('../controller/classes/' . strtolower($class) . '.php');
}

$obj = new pushsms1();
$user_id=$_SESSION['user_id'];
$ip_address = get_ip_address1();
 $user_role=$_SESSION['user_role'];
if($user_role=='mds_rs' || $user_role=='mds_ad')
{
    echo "The reseller was unable to send messages.";
        exit;

}

if (isset($_POST['type']) && $_POST['type'] == 'sendCALLsave') { 
    $is_schedule=$_REQUEST['is_schedule'];
    $schedule_dt=$_REQUEST['scheduleDateTime'];
    $click_btn=$_REQUEST['btn_send'];

    // if($schedule_dt!='' && $click_btn=="send_call")
    // {
    //     echo "Please Click Schedule Button";
    //     exit;
    // } 
    // else
    // {
    //      $rs = $obj->sendQuickCALLSave($user_id);    
    // }


    
    if($is_schedule==1)
    {
        $rs = $obj->sendScheduleCALLSave($user_id);    
    }
    else{

      
        $rs = $obj->sendQuickCALLSave($user_id);  
        
    }


 // print_r($rs);
 //    die();

$dlr_url=$rs['dlr_url'];
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
    }
    else if (!$rs['status'] && $rs['msg'] == 'Incorrect Vendor selection') {
        $_SESSION['err'] = "Incorrect Vendor selection";
        echo "Incorrect Vendor selection";
        //header("Location:../dashboard.php?page=bulksms");
        //exit();
    }
     else {
        $_SESSION['err'] = "Error while sending sms, please contact to admin";
        echo "Error while sending sms, please contact to admin";
        //header("Location:../dashboard.php?page=bulksms"); exit();
    }
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