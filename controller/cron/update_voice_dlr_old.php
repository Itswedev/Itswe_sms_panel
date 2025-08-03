<?php

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

include_once('/var/www/html/itswe_panel/include/connection.php');
include("/var/www/html/itswe_panel/include/config.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/*error_reporting(0);*/

$sendtabledetals = SENDCALLDETAILS ;
global $dbc;
$today_date=date('Y-m-d');
/*$trans_id = 1157773_1;*/
$voice_dlr = "select * from voice_dlr where date(created_date)='".$today_date."' and update_dlr='0' limit 500";

$rs_job = mysqli_query($dbc, $voice_dlr) or die(mysqli_error($dbc));


$count_rows= mysqli_num_row($rs_job);

if($count_rows>0)
{
	while ($row=mysqli_fetch_array($rs_job)) {

	$trans_id =  $row['trans_id'];

	$mobile_number = $row['mobile_number'];

	$status = $row['status'];

	$input = $row['input'];

	$call_duration = $row['call_duration'];

	$call_ans_time = $row['call_ans_time'];

	$call_connect_time = $row['call_connect_time'];

	$call_disconnect_time = $row['call_disconnect_time'];

	 $update_master_tbl="update voice_call set status='$status'  ,call_ans_time='$call_ans_time',call_connect_time='$call_connect_time',call_disconnect_time='$call_disconnect_time',call_duration='$call_duration',`input`='$input' where trans_id='$trans_id' and mobile_number='$mobile_number'";

	 $update_job = mysqli_query($dbc, $update_master_tbl) or die(mysqli_error($dbc));

	 $update_dlr_tbl="update voice_dlr set update_dlr='1' where trans_id='$trans_id' and mobile_number='$mobile_number'";

	 $update_dlr = mysqli_query($dbc, $update_dlr_tbl) or die(mysqli_error($dbc));



	}



}



?>