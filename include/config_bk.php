<?php
// index.php

// Dynamically detect base URL
 //$baseURL = 'https://' . $_SERVER['HTTP_HOST'] ;
 //$baseURL = "https://sms.vapio.io/";
 //$baseURL = "https://onereach.in:8080/";
 //$baseURL = "https://".$_SERVER['HTTP_HOST']."/";
 $baseURL = "http://localhost/itswe_sms_app/";
 //$baseURL = "http://156.67.105.86:8081/";
@session_start();

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
if (!isset($_SESSION['user_id']))
{
    session_regenerate_id(true);
}
$inactive = 3600;
if(isset($_SESSION['timeout'])) {
    $session_life = time() - $_SESSION['timeout'];
    if ($session_life > $inactive) {
        session_unset();
        session_destroy();
        echo "<meta http-equiv='Refresh' content='0; url=index.php'>";
        exit;
    }
}

$timezone = "Asia/Kolkata";
date_default_timezone_set($timezone);
// Determine location of files and the URL of the site:

// Allow for development on different servers.
$month = date('Ym');
$month = date('Ym');
define('SESS', 'MDSMEDIA');
define('CURRENTMONTH', $month);
define('BYOLDMONTH', '201706'); 
define('FOROLDDB', '201706'); 
define('CHANGEFROM', '201706'); 
define('SENDSMS_API',"sendmessages_api"); 
/*define('SENDSMS',"az_sendmessages_$month"); 
define('SENDSMSDETAILS',"az_sendnumbers_$month"); */
define('SENDSMS',"az_sendmessages"); 
define('SENDCALL',"multimedia_job"); 
define('LEAD',"lms_leads"); 


define('USER',"az_user"); 
define('IPLOGS',"ip_logs");
define('SENDERID',"az_senderid");
define('RCS',"rcs_cred");
define('RCS_TEMP',"rcs_template");
define('TEMPLATE',"az_template");
define('IPMANAGEMENT',"ip_management"); 
define('SENDSMSDETAILS',"az_sendnumbers"); 
define('SENDCALLDETAILS',"voice_call"); 
define('SENDCALLSCHEDULE',"voice_schedule"); 
define('SENDSMSDETAILS_BK',"sendnumbers_bk"); 
define('RCSDETAILS',"rcs_dtls"); 
define('RCSSMS',"rcs_sendmessages"); 
define('RCSMASTER',"sendrcs_master");
define('RCSJOBS',"rcs_jobs");
define('SENTSMS',"sent_sms"); 
define('SMARTCUTOFF',"smart_cutoff"); 
// define('TRACKINGURL',"vap1.in/xyz/xxxxxxx");
// define('TRACKINGURLUNICODE',"vap1.in/xyz/xxxxxxx/");

define('TRACKINGURL',"https://vap1.in/abcxyz/xxxxxxx");
define('TRACKINGURLUNICODE',"https://vap1.in/abcxyz/xxxxxxx");


?>