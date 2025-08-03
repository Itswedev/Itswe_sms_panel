<?php

$month = date('Ym');
$month = date('Ym');
define('SESS', 'MDSMEDIA');
define('CURRENTMONTH', $month);
define('BYOLDMONTH', '201706'); 
define('FOROLDDB', '201706'); 
define('CHANGEFROM', '201706'); 
/*define('SENDSMS',"az_sendmessages_$month"); 
define('SENDSMSDETAILS',"az_sendnumbers_$month"); */
define('SENDSMS',"az_sendmessages"); 
define('SENDSMS_API',"sendmessages_api"); 
define('SENDCALL',"multimedia_job"); 


define('USER',"az_user"); 
define('IPLOGS',"ip_logs");
define('SENDERID',"az_senderid");
define('TEMPLATE',"az_template");
define('IPMANAGEMENT',"ip_management"); 
define('SENDSMSDETAILS',"az_sendnumbers"); 
define('SENDSMSDETAILS_API',"sendnumbers_api"); 
define('SENDCALLDETAILS',"voice_call"); 
define('SENDCALLSCHEDULE',"voice_schedule"); 
define('SENDSMSDETAILS_BK',"sendnumbers_bk"); 
define('RCSDETAILS',"rcs_dtls"); 
define('RCSSMS',"rcs_sendmessages"); 
define('SENTSMS',"sent_sms"); 
define('SMARTCUTOFF',"smart_cutoff"); 
define('TRACKINGURL',"vap1.in/xyz/xxxxxxx");
define('TRACKINGURLUNICODE',"vap1.in/xyz/xxxxxxx/");


/*include('connection.php');*/

?>