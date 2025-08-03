<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

 


/*
include('/var/www/html/itswe_panel/include/connection.php');

include("/var/www/html/itswe_panel/include/config.php");*/


update_dlr();

function update_dlr()
{

	$host = "80.241.215.220";
	$username = "itswe";
     $password = "admin@!top97";
     $db = "gateway";
     $dbc = mysqli_connect("p:".$host, $username, $password,$db);


	 /*global $dbc;*/
	 $sendtabledetals = 'DLRStatus';
	 $new_status='UNDELIV';
	   $QuerySelect= "select ERRCode,MessageId from DLRStatus where date(LoggedAt)='2023-06-07' and Status='SUBMITD' limit 1";
               $result = mysqli_query($dbc, $QuerySelect);
             	echo mysqli_num_rows($result);
             	echo "\n";
                 if (mysqli_num_rows($result) > 0) {
                      while ($row = mysqli_fetch_array($result)) {
                      		$err_code=$row['ERRCode'];
                      		$message_id=$row['MessageId'];
                      		/*$id=$row['id'];*/
                      		
                      		 $select_status="select service, sender,dlr_mask,dlr_url, time,smsc_id,receiver,msgdata from sent_sms where dlr_url='".$message_id."' and momt = 'DLR'";
                      				$result3 = mysqli_query($dbc, $select_status);
             
					                 if (mysqli_num_rows($result3) > 0) {
					                      while ($row3 = mysqli_fetch_array($result3)) {
					                      		$msgdata = $row3[7];
					                      		$mask= $row3[2];
					                      		$sender=$row3[1];
					                      		$dlr_url=$row3[3];
					                      		$time=$row3[4];
					                      		$dlr_time = date("Y-m-d H:i:s", $time);


					                      		$err_split=explode("err%3A", $msgdata);
					                              $err_split2=explode("+",trim($err_split[1]));
					                              $err=trim($err_split2[0]);

					                              if ($err != '952')
					                              {
					                              	if($mask==1)
					                              	{
					                              		$status='DELIVRD';
					                              	}
					                              	else if($mask==2)
					                              	{
					                              		$status='UNDELIV';
					                              	}
					                              	else if($mask==16)
					                              	{
					                              		$status='REJECTED';
					                              	}
					                              	else if($mask==19)
					                              	{
					                              		$status='SUBMITD';
					                              	}
					                              	else
					                              	{
					                              		$status='UNDELIV';
					                              	}
					                              }
					                             else
					                             {
					                             		$status='DND';
					                             }

					                              if($sender=='NAVYSA')
					                              {
					                              	$insert_dlr_push="";
					                              }

					                      		/*$update_status="update DLRStatus set Status='".$new_status."',ERRCode=".$err.",DlrTime='".$dlr_time."' where MessageId='".$dlr_url."'";
					                      		$result4 = mysqli_query($dbc, $update_status);*/		
					                      }
					                  }
					                  else
					                  {
					                  	$new_status='DND';
					                   /*$update_status="update DLRStatus set Status='".$new_status."',ERRCode=".$err.",DlrTime='".$dlr_time."' where MessageId='".$dlr_url."'";
					                   $result4 = mysqli_query($dbc, $update_status);
*/
					                  }

                      }
                  }

}


