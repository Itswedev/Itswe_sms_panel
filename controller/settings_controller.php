<?php
session_start();
$log_file = "../error/logfiles/settings_controller.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);



include_once('../include/connection.php');

include('../include/config.php');
include('classes/last_activities.php');


if (isset($_POST['list_type']) && $_POST['list_type'] == 'update_password') {
    $rs = updatePassword();
    echo $rs;
  	


}

if (isset($_POST['list_type']) && $_POST['list_type'] == 'update_api_key') {
    $rs = updateAPIKey();
    echo $rs;
    


}

if (isset($_POST['list_type']) && $_POST['list_type'] == 'load_settings') {
    $settings = load_settings();
    
  //print_r($overview);
   echo json_encode($settings);
    


}
else if(isset($_POST['list_type']) && $_POST['list_type'] == 'update_settings')
    {
       
        $rs = update_settings();
        echo $rs;
        /*if($rs=='1')
        {
          echo "Access Details Updated successfully";
        }
        else if($rs=='0')
        {
        echo "Failed to Update Access details";
        }
        */
           
    }


function load_settings()
{
        global $dbc;
        $userid=$_SESSION['user_id'];

        $sql_setting="select * from settings where userid='".$userid."'";
        $result=mysqli_query($dbc,$sql_setting);
        $count=mysqli_num_rows($result);
        if($count>0)
        {
            while($row=mysqli_fetch_array($result))
            {
            $record_settings[]=$row;
            }

            return $record_settings;
            
        }
        else
        {
            return 0;
        }
}

function update_settings()
{
        global $dbc;
        $userid=$_SESSION['user_id'];
        $low_balance=$_REQUEST['low_balance'];
        if($low_balance=='Yes')
        {
            $low_bal_mobile=$_REQUEST['low_bal_mobile'];
        }

        $low_bal_limit=$_REQUEST['low_bal_limit'];
        $login_alert=$_REQUEST['login_alert'];
        $login_otp=$_REQUEST['login_otp'];

        $mobile=$_REQUEST['mobile'];
        $email=$_REQUEST['email'];
        $whatsapp=$_REQUEST['whatsapp'];
        $daily_usage=$_REQUEST['daily_usage'];
        $security_question=$_REQUEST['security_question'];
        if($security_question=='Yes')
        {
             $que1=$_REQUEST['que1'];
             $que2=$_REQUEST['que2'];
             $que3=$_REQUEST['que3'];

             $ans1=$_REQUEST['ans1'];
             $ans2=$_REQUEST['ans2'];
             $ans3=$_REQUEST['ans3'];

        }

         $sql_setting="UPDATE `settings` SET `low_balance` = '".$low_balance."', `low_bal_limit` = '".$low_bal_limit."',`login_alert` = '".$login_alert."', `login_otp` = '".$login_otp."', `daily_usage` = '".$daily_usage."',`security_questions` = '".$security_question."',`que1` = '".$que1."',`ans1` = '".$ans1."',`que2` = '".$que2."',`ans2` = '".$ans2."',`que3` = '".$que3."',`ans3` = '".$ans3."',`mobile_otp` = '".$mobile."',`email_otp` = '".$email."',`whatsapp_otp` = '".$whatsapp."',`low_bal_mobile`='".$low_bal_mobile."' WHERE `userid` = '".$userid."'";

        $rs=mysqli_query($dbc,$sql_setting) or die(mysqli_error($dbc));

        if($rs)
        {
            return 1;
        }
        else
        {
            return 0;
        }

}

function updatePassword()
{
        global $dbc;
        $userid=$_SESSION['user_id'];
        $old_password=$_REQUEST['old_password'];

        $sql="select user_psw from az_user where userid='".$userid."'";
        $result=mysqli_query($dbc,$sql);
        while($row=mysqli_fetch_array($result))
        {

          $dbpassword=$row['user_psw'];
          $verify_pass=password_verify($old_password, $dbpassword);
         
          if($verify_pass)
          {
            $new_password=$_REQUEST['new_password'];
            $confirm_password=$_REQUEST['confirm_password'];
            if($new_password==$confirm_password)
            {
                if($new_password!=$old_password)
                {
                $new_password = trim($_REQUEST['new_password']);
                $new_password = password_hash($new_password,PASSWORD_DEFAULT);
                    $sql_update="update az_user set user_psw='$new_password' where userid='$userid'";
                     $result_update=mysqli_query($dbc,$sql_update);
                     if($result_update)
                     {
                        return 1;
                     }
                     else
                     {
                        return "Failed to update password";
                     }
                }
                else
                {
                    return "The new password should not be the same as the previous one.";
                }
            }
            else
            {
                return "The re-entered password is not the same as the new one.";
            }

          }
          else
          {
             return "The old password did not match.";
          }



      }


}

function updateAPIKey()
{
        global $dbc;
        $userid=$_SESSION['user_id'];
        $api_key=$_REQUEST['api_key'];

        $sql_update="update az_user set api_key='$api_key' where userid='$userid'";
        $result_update=mysqli_query($dbc,$sql_update);
                     if($result_update)
                     {
                        $_SESSION['api_key']=$api_key;
                        return 1;
                     }
                     else
                     {
                        return "Failed to update API Key";
                     }
}

?>