<?php
session_start();
include('include/connection.php');
include('controller/classes/last_activities.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// error_reporting(0);
$web_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

$sql_branding=mysqli_query($dbc,"select * from `branding` where `website_address`='$web_url'");
$sql_branding_count=mysqli_num_rows($sql_branding);
$_SESSION['web_url']=$web_url;


                        require 'phpmailer/PHPMailer.php';
                        require 'phpmailer/SMTP.php';
                        require 'phpmailer/Exception.php';

                        use PHPMailer\PHPMailer\PHPMailer;
                        use PHPMailer\PHPMailer\SMTP;
                        use PHPMailer\PHPMailer\Exception;

if($sql_branding_count>0)
{
    while($row_brand=mysqli_fetch_array($sql_branding))
    {
      $_SESSION['company_name']=$row_brand['company_name'];
      $_SESSION['company_logo']=$row_brand['company_logo'];
      $_SESSION['support_no']=$row_brand['support_mobile'];
      $_SESSION['support_email']=$row_brand['support_email'];
      $_SESSION['company_tagline']=$row_brand['company_tagline'];
      $_SESSION['login_desc']=$row_brand['login_desc'];

    }
}
else
{
  /*header('Location:index.php');
  exit;*/
}

if(isset($_REQUEST['submit']))
{
  $username=antiinjection($_REQUEST['username']);
  $password=antiinjection($_REQUEST['password']);
           $ip_address = $_SERVER['REMOTE_ADDR'];

            $login_date=time();
            $login_dt_time=date("d-m-Y h:i A",$login_date);
            $logout_date='';

   $select_ip_management="select count(*) as count_blacklist_ip from ip_management where username='".$username."' and ip_address='".$ip_address."'";
   $query_select_ip_management=mysqli_query($dbc,$select_ip_management);
   $row_failed_blacklist=mysqli_fetch_array($query_select_ip_management);
   $blacklist_count=$row_failed_blacklist['count_blacklist_ip'];

   if($blacklist_count>0)
   {
      echo "<script>alert('Sorry ... Due to an incorrect login attempt, your account has been blocked. Kindly contact account manager!!!!');</script>";
       

   }
   else
   {
             
  if(empty($username) || empty($password))
  {
    echo "<script>alert('Username Or Password should not be an empty!!!!');</script>";
      /*get_last_activities($row_login['userid'],"login Success by IP: $ip_address at $login_dt_time",$login_date,$logout_date);*/
  }
  else
  {

   $sql_login=mysqli_query($dbc,"select * from `az_user` where `user_name`='$username' and `user_status`='1'");
   $sql_count=mysqli_num_rows($sql_login);
   $today_date=date("Y-m-d");
   $dt=date("Y-m-d h:i");

 

    if($sql_count>0)
    {
        while($row_login=mysqli_fetch_array($sql_login))
        {

          $dbpassword=$row_login['user_psw'];
     
          $verify_pass=password_verify($password, $dbpassword);
         
          if($verify_pass)
          {
           

            $login_id=$row_login['userid'];

            $mobile_no=$row_login['mobile_no'];  
            $mobile_no_val=$row_login['mobile_no']; 
            $_SESSION['user_id']=$row_login['userid'];
            $_SESSION['mobile']=$row_login['mobile_no'];
             $_SESSION['mobile_val']=$mobile_no_val;
            $_SESSION['user_name']=$row_login['user_name'];
            $_SESSION['client_name']=$row_login['client_name'];
            $_SESSION['status']=$row_login['user_status'];
            $_SESSION['user_role']=$row_login['user_role'];
            $_SESSION['parent_id']=$row_login['parent_id'];
            $_SESSION['miscall_access']=$row_login['miscall_report'];
            $_SESSION['vsms_access']=$row_login['gvsms'];
            $_SESSION['rcs_access']=$row_login['rcs'];
            $_SESSION['lms']=$row_login['lms'];
            $_SESSION['acct_manager']=$row_login['acct_manager'];
            $_SESSION['rcs']=$row_login['rcs'];
            $_SESSION['voice_call']=$row_login['voice_call'];
            $_SESSION['miscall_report']=$row_login['miscall_report'];
            $_SESSION['gvsms']=$row_login['gvsms'];
            $_SESSION['vas']=$row_login['vas'];
            $_SESSION['campaign_report']=$row_login['campaign_report'];
            $_SESSION['BlockNum'] = 'BlockNum';
            $_SESSION['restricted_tlv'] = $row_login['restricted_tlv'];
            $_SESSION['api_key'] = $row_login['api_key'];
            $_SESSION['restricted_report'] = $row_login['restricted_report'];
            $_SESSION['profile_pic'] = $row_login['profile_pic'];
            $_SESSION['otp_status']='off';
            $_SESSION['otp_match_status']='no';

            $sql_login_update="update az_user set login=1,logout=0,login_time=NOW() where userid='$login_id'";
            $rs_login_update=mysqli_query($dbc,$sql_login_update);
            if($login_id!=1)
            {
               $sql_count_roles="select count(user_role) as count_roles,user_role from az_user where parent_id='$login_id' and (user_role='mds_usr' || user_role='mds_ad' || user_role='mds_rs') group by user_role";
               $rs_count_roles=mysqli_query($dbc,$sql_count_roles);
               while($row_count_roles=mysqli_fetch_array($rs_count_roles))
               {
                  $roles[]=$row_count_roles['user_role'];
                  $count_role[]=$row_count_roles['count_roles'];
               }
            }
            else
            {
               $sql_count_roles="select count(user_role) as count_roles,user_role from az_user where (user_role='mds_usr' || user_role='mds_ad' || user_role='mds_rs') group by user_role";
               $rs_count_roles=mysqli_query($dbc,$sql_count_roles);
               while($row_count_roles=mysqli_fetch_array($rs_count_roles))
               {
                  $roles[]=$row_count_roles['user_role'];
                  $count_role[]=$row_count_roles['count_roles'];
               }
            }


            $_SESSION['roles']=$roles;
            $_SESSION['roles_count']=$count_role;
             if ($row_login['permissions'] != "") {
                $data = explode(',', $row_login['permissions']);
                foreach ($data as $key => $value) {
                    $_SESSION[$value] = $value;
                    if ($value == 'LiveStatus') {
                        $live = 'live-status';
                    }
                    if($value == 'OTP') {
                        $secure = true;
                    }
                }
            }
            $ip_address = $_SERVER['REMOTE_ADDR'];
            $login_date=time();
            $login_dt_time=date("d-m-Y h:i A",$login_date);
            $logout_date='';
            get_last_activities($row_login['userid'],"login Success by IP: $ip_address at $login_dt_time",$login_date,$logout_date);
            $ip_logactivity="Login Success by IP: $ip_address at $login_dt_time";


            $sql_alert="select * from settings where userid='".$login_id."'";
            $result_alert=mysqli_query($dbc,$sql_alert);
            $count_alert=mysqli_num_rows($result_alert);
            if($count_alert>0)
            {
               while($row_alert=mysqli_fetch_array($result_alert))
               {
                  $login_alert=$row_alert['login_alert'];
                  $login_otp=$row_alert['login_otp'];
                  if($login_otp=='Yes')
                  {
                    $otp_mobile=$row_alert['mobile_otp'];
                    $otp_email=$row_alert['email_otp'];
                    $otp_whatsapp=$row_alert['whatsapp_otp'];

                  }
                  $security_option=$row_alert['security_questions'];
                  if($security_option=='Yes')
                  {
                    $questions[0]='que1';
                    $questions[1]='que2';
                    $questions[2]='que3';
                  }
               }
                /*Login Alert = Yes*/
               if($login_alert=='Yes')
               {

                $msg="Dear Customer,Your Account is logged in recently with IP $ip_address SUPTMD";
                $msg=str_replace(' ', '%20', $msg);
                //$url = "https://sms.vapio.io/api.php?username=alerts&apikey=0DZd1IoaL2XB&senderid=MDACCT&route=OTP&mobile=$mobile_no&text=$msg";
                $url = "https://vapio.in/api.php?username=inboxdemo&apikey=Dcg7UtqtFAdG&senderid=INBXTL&route=OTP&mobile=$mobile_no&text=$msg";

                
                
               }
               
               /*Login OTP = Yes*/
               if($login_otp=='Yes')
               {
                  $_SESSION['otp_status']='on';
                  $otp=random_strings(4);
                  $_SESSION['otp']=$otp;
                  $msg="Dear user your one time password (OTP) for login is $otp. TEAM INBOX";


                  if($otp_mobile=='Yes')
                  {
                   $msg=str_replace(' ', '%20', $msg);
                   //$url = "https://sms.vapio.io/api.php?username=alerts&apikey=0DZd1IoaL2XB&senderid=SUPTMD&route=OTP&mobile=$mobile_no&text=$msg";
                   $url = "https://vapio.in/api.php?username=inboxdemo&apikey=Dcg7UtqtFAdG&senderid=INBXTL&route=OTP&mobile=$mobile_no&text=$msg";
                  

                   $ch  = curl_init($url);
                    curl_setopt($ch, CURLOPT_HTTPGET, "POST");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($ch);
                    curl_close($ch); 
                    echo $result;
                  }


                  if($otp_whatsapp=='Yes')
                  {

                    $mobile_no_arr=explode(",",$mobile_no_val);

                    for($i=0;$i<count($mobile_no_arr);$i++)
                    {
                        $mobile_no=$mobile_no_arr[$i];

                        $mobile_no_len=strlen($mobile_no);
                        if($mobile_no_len==10)
                        {
                            $whatsapp_mobile="91".$mobile_no;

                        }
                        else if($mobile_no_len==13)
                        {
                            $whatsapp_mobile=trim($mobile_no,"+");
                        }
                        else
                        {
                            $whatsapp_mobile=$mobile_no;
                        }
                    

                    $msg=str_replace(' ', '%20', $msg);

                    }
                    /*echo $result;*/
                   
                  }
                

                  $login_status='1';
                  catch_iplogs($username,$ip_logactivity,$login_date,$logout_date,$ip_address,$login_status);
                  header('Location:otp.php');
                  exit;
               }


                /*Security Question= Yes*/
              if($security_option=='Yes')
               {

                  shuffle($questions);

                  $_SESSION['security_question']=$questions[0];
                  $login_status='1';
                  catch_iplogs($username,$ip_logactivity,$login_date,$logout_date,$ip_address,$login_status);
                  header('Location:security_questions.php');
                  exit;
               }


            }


            $login_status='1';
            /*IP Logs tracking*/
            catch_iplogs($username,$ip_logactivity,$login_date,$logout_date,$ip_address,$login_status);
            header('Location:dashboard.php');
        
            
          }
          else
          {


            $today_date=date("Y-m-d");
            $activity="Login failed since the password was wrong.";
            $login_date=time();
            $logout_date="";
            $login_status='0';
            catch_iplogs($username,$activity,$login_date,$logout_date,$ip_address,$login_status);

             $sql_ip_management="select count(login_status) as count_failed_status from ip_logs where username='".$username."' and date(created_dt)='".$today_date."' and login_status='0'";
             $query_ip_management=mysqli_query($dbc,$sql_ip_management);
             $row_failed=mysqli_fetch_array($query_ip_management);
             $count_failed_login=$row_failed['count_failed_status'];
           
             if($count_failed_login>2)
             {
                $sql_insert_ip_block="insert into ip_management(username,date,ip_address,status) values('".$username."','".$dt."','".$ip_address."','1')";
                $query_insert_ip_block=mysqli_query($dbc,$sql_insert_ip_block)or die(mysqli_query($dbc));


             }
            echo "<script>alert('Password dosent match!!!!');</script>";

            
          }
         
        }
    }
    else
    {
      echo "<script>alert('Invalid username or inactive user account !!!! Please Check');</script>";
    }
    }
  }
}

 function random_strings($length_of_string)
    {
        // String of all alphanumeric character
        $str_result = '0123456789';
        return substr(str_shuffle($str_result),0,$length_of_string);
    }


function antiinjection($data) {
    global $dbc;
    $filter_sql = mysqli_real_escape_string($dbc, stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES))));
    return $filter_sql;
}

?>

<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
   <!--Title-->
	<title>It'sWe - SMS Panel</title>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="DexignZone">
	<meta name="robots" content="index, follow">

	<meta name="keywords"
		content="It'sWe, sales Admin Dashboard, Bootstrap Template, Web Application, sales Management, Responsive Design, User Experience, Customizable, Modern UI, Dashboard Template, Admin Panel, Bootstrap 5, HTML5, CSS3, JavaScript, Analytics, Products, Admin Template, UI Kit, SASS, SCSS, CRM, Analytics, Responsive Dashboard, responsive admin dashboard, sales dashboard, ui kit, web app, Admin Dashboard, Template, Admin, CMS pages, Authentication, FrontEnd Integration, Web Application UI, Bootstrap Framework, User Interface Kit, Financial Dashboard, SASS Integration, Customizable Template, Product Management, HTML5/CSS3, CRM Dashboard, Analytics Dashboard, Admin Dashboard UI, Mobile-Friendly Design, UI Components, Dashboard Widgets, Dashboard Framework, Data Visualization, User Experience (UX), Dashboard Widgets, Real-time Analytics, Cross-Browser Compatibility, Interactive Charts, Product Processing, Performance Optimization, Multi-Purpose Template, Efficient Admin Tools, Task Management, Modern Web Technologies, Product Tracking, Responsive Tables, Dashboard Widgets, Invoice Management, Access Control, Modular Design, Product History, Trend Analysis, User-Friendly Interface">

	<meta name="description"
		content="The It'sWe Admin Sales Management System is a robust and intuitive platform designed to streamline sales operations and enhance business productivity. This comprehensive admin dashboard offers a feature-rich environment tailored specifically for managing sales processes effectively.With its modern and responsive design, It'sWe Admin provides a seamless user experience across various devices and screen sizes. The user interface is highly customizable, allowing administrators to tailor the dashboard to their specific needs and branding requirements.">

	<meta property="og:title" content="It'sWe -Sales Management System Admin Dashboard Bootstrap HTML Template | DexignZone">
	<meta property="og:description"
		content="The It'sWe Admin Sales Management System is a robust and intuitive platform designed to streamline sales operations and enhance business productivity. This comprehensive admin dashboard offers a feature-rich environment tailored specifically for managing sales processes effectively.With its modern and responsive design, It'sWe Admin provides a seamless user experience across various devices and screen sizes. The user interface is highly customizable, allowing administrators to tailor the dashboard to their specific needs and branding requirements.">
	<meta property="og:image" content="https://It'sWe.dexignzone.com/xhtml/social-image.png">

	<meta name="format-detection" content="telephone=no">

	<meta name="twitter:title" content="It'sWe -Sales Management System Admin Dashboard Bootstrap HTML Template| DexignZone">
	<meta name="twitter:description"
		content="The It'sWe Admin Sales Management System is a robust and intuitive platform designed to streamline sales operations and enhance business productivity. This comprehensive admin dashboard offers a feature-rich environment tailored specifically for managing sales processes effectively.With its modern and responsive design, It'sWe Admin provides a seamless user experience across various devices and screen sizes. The user interface is highly customizable, allowing administrators to tailor the dashboard to their specific needs and branding requirements.">
	<meta name="twitter:image" content="https://It'sWe.dexignzone.com/xhtml/social-image.png">
	<meta name="twitter:card" content="summary_large_image">

	<!-- MOBILE SPECIFIC -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- FAVICONS ICON -->
	<link rel="shortcut icon" type="image/png" href="assets2/images/favicon.png">
	<link href="assets2/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link class="main-css" href="assets2/css/style.css" rel="stylesheet">

</head>

<body style="background-image:url('assets2/images/bg.png'); background-position:center;">
    <div class="authincation fix-wrapper">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
									<div class="text-center mb-3">
										<a href="index.html"><img src="assets2/images/logo/logo-full.png" alt=""></a>
									</div>
                                    <h4 class="text-center mb-4">Sign up your account</h4>
                                    <form class="theme-form" action="#" method="post">
                                        <div class="mb-3">
                                            <label class="mb-1 form-label">Username</label>
                                            <input type="text" class="form-control" name="username" placeholder="username">
                                        </div>
                                        
                                        <div class="mb-3 position-relative">
                                            <label class="form-label" for="dz-password">Password</label>
                                            <input type="password" id="dz-password" name="password"  class="form-control" value="123456">
                                            <span class="show-pass eye">
                                                <i class="fa fa-eye-slash"></i>
                                                <i class="fa fa-eye"></i>
                                            </span>
                                        </div>
                                        <div class="form-row d-flex flex-wrap justify-content-between mb-2">
                                            <div class="form-group mb-sm-4 mb-1">
                                                <div class="form-check custom-checkbox ms-1">
                                                    <input type="checkbox" class="form-check-input" id="basic_checkbox_1">
                                                    <label class="form-check-label" for="basic_checkbox_1">Remember my preference</label>
                                                </div>
                                            </div>
                                            <div class="form-group ms-2">
                                                <a class="text-hover" href="page-forgot-password.html">Forgot Password?</a>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                        <button type="submit" name="submit" class="btn btn-primary btn-block">Sign In</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p>Already have an account? <a class="text-primary" href="page-register.html">Sign Up</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!--**********************************
	Scripts
***********************************-->
<!-- Required vendors -->
<script src="assets2/vendor/global/global.min.js"></script>
<script src="assets2/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="assets2/js/deznav-init.js"></script>
<script src="assets2/js/custom.min.js"></script>
<script src="assets2/js/demo.js"></script>
<script src="assets2/js/styleSwitcher.js"></script>
</body>
</html>