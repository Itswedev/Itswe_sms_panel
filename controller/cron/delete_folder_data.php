<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//$bulk_sms_folder_path="/var/www/html/itswe_panel/controller/classes/sent_sms";
$bulk_sms_folder_path="/var/www/html/itswe_panel/controller/classes/sent_sms/";
echo $result=exec('rm -f '. $bulk_sms_folder_path .'*');


$send_voice_call_folder_path="/var/www/html/itswe_panel/controller/classes/sent_call/";
echo $result=exec('rm -f '. $send_voice_call_folder_path .'*');

$upload_folder_path="/var/www/html/itswe_panel/controller/upload/";
echo $result=exec('rm -f '. $upload_folder_path .'*.xls');


?>