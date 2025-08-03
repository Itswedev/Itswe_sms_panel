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

/*$sendtabledetals = SENDCALLDETAILS ;*/
global $dbc;
$today_date='2023-09-25';
//$today_date=date('Y-m-d');
/*$trans_id = 1157773_1;*/


$kolpol_dlr = "select caseno,msg_job_id from kolpol_dlr where date(created_date)='".$today_date."' and update_dlr='0' limit 3000";
//$kolpol_dlr = "select * from kolpol_dlr where date(created_date)>'2023-07-16' and update_dlr='0' ";

$rs_job = mysqli_query($dbc, $kolpol_dlr) ;


$count_rows= mysqli_num_rows($rs_job);
/*echo $count_rows;
*/
if($count_rows>0)
{


while ($row=mysqli_fetch_array($rs_job)) {

/*	
   $mobile_number = $row['mobile_number'];

	$status = $row['status'];

	$mobile_kolpol=str_replace("+91",'',$mobile_number);
*/
	$caseno = $row['caseno'];

	$msg_job_id_arr[] = "'".$row['msg_job_id']."'";
}
}

$msg_job_id_arr1=array_unique($msg_job_id_arr);

$msg_job_id_arr_val=implode(",",$msg_job_id_arr1);






	 $kolpol_master_dlr = "select `status`,`err_code`,`delivered_date`,`msg_job_id` from az_sendnumbers where date(sent_at)='".$today_date."' and msg_job_id in ($msg_job_id_arr_val) and status!='Submitted'";
//$kolpol_dlr = "select * from kolpol_dlr where date(created_date)>'2023-07-16' and update_dlr='0' ";

$rs_job1 = mysqli_query($dbc, $kolpol_master_dlr) ;


$count_rows1= mysqli_num_rows($rs_job1);
if($count_rows1>0)
{

while ($row1=mysqli_fetch_array($rs_job1)) {

		$status=$row1['status'];
		$err_code=$row1['err_code'];
		$msg_job_id=$row1['msg_job_id'];
		$dlr_time=$row1['delivered_date'];
		$updated_at=date('Y-m-d h:i:s');

		/*if($status!='Submitted')
		{*/
			//echo "<br>";
			 $update_dlr_tbl="update kolpol_dlr set update_dlr=1,status='$status',err_code='$err_code',dlr_time=$dlr_time,updated_at='$updated_at'   where  msg_job_id='$msg_job_id' and date(created_date)='".$today_date."'";

			
	 	$update_job = mysqli_query($dbc, $update_dlr_tbl) ;

		//}

		


	}

}

	



	

	

	
	//die();






?>