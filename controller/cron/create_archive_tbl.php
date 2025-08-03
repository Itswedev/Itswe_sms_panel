<?php 
$log_file = "/var/www/html/itswe_panel/error/logfiles/create_archive_tbl.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);

error_reporting(0);
include_once('/var/www/html/itswe_panel/include/connection.php');
include("/var/www/html/itswe_panel/include/config.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$today_dt=date('Y-m-d');

$sendtbldtls=SENDSMSDETAILS.CURRENTMONTH;
$sql="create table $sendtbldtls like `az_sendnumbers`";
$rs=mysqli_query($dbc,$sql)or mysqli_error($dbc);
    	
$sendsms=SENDSMS.CURRENTMONTH;
$sql="create table $sendsms like `az_sendmessages`";
$rs=mysqli_query($dbc,$sql)or mysqli_error($dbc);

/*$rcstbldtls=RCSDETAILS.CURRENTMONTH;
$sql="create table $rcstbldtls like `rcs_dtls`";
$rs=mysqli_query($dbc,$sql)or die(mysqli_error($dbc));*/

/*$rcssendmsgtbl=RCSSMS.CURRENTMONTH;
$sql="create table $rcssendmsgtbl like `rcs_sendmessages`";
$rs=mysqli_query($dbc,$sql)or die(mysqli_error($dbc));*/

$smartcutofftbl=SMARTCUTOFF.CURRENTMONTH;
$sql="create table $smartcutofftbl like `smart_cutoff`";
$rs=mysqli_query($dbc,$sql)or mysqli_error($dbc);

$voicecalltbl=SENDCALLDETAILS.CURRENTMONTH;
$sql="create table $voicecalltbl like `voice_call`";
$rs=mysqli_query($dbc,$sql)or mysqli_error($dbc);


$voicejobtbl=SENDCALL.CURRENTMONTH;
$sql="create table $voicejobtbl like `multimedia_job`";
$rs=mysqli_query($dbc,$sql)or mysqli_error($dbc);

/*
$sent_sms=SENTSMS.CURRENTMONTH;
$sql="create table $sent_sms like `sent_sms`";
$rs=mysqli_query($dbc,$sql)or mysqli_error($dbc);*/


?>
