<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$log_file = "/var/log/php_errors.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);

/*error_reporting(0);*/
include('/var/www/html/itswe_panel/include/connection.php');

include("/var/www/html/itswe_panel/include/config.php");


update_dlr();

function update_dlr()
{
	 global $dbc;
	 $sendtabledetals = SENDSMSDETAILS;
	 $new_status='Other';
	 $QuerySelect= "SELECT service, sender,dlr_mask,dlr_url, time,smsc_id,receiver, SUBSTR(SUBSTRING_INDEX(substr(msgdata,LOCATE('err%3A', msgdata)),'+',1),7) FROM sent_sms ORDER BY sql_id DESC limit 1";
                $result = mysqli_query($dbc, $QuerySelect);
             	echo mysqli_num_rows($result);
             	echo "\n";
                 if (mysqli_num_rows($result) > 0) {
                      while ($row = mysqli_fetch_array($result)) {
                      		$err_code=$row['err_code'];
                      		$service_id=$row['service_id'];
                      		$id=$row['id'];
                      		/*$gateway_query="select gateway_id from az_sms_gateway where smsc_id='".$service_id."' limit 1";
                      		$result2 = mysqli_query($dbc, $gateway_query);*/

                      		/*if (mysqli_num_rows($result2) > 0) {
                      			while ($row2 = mysqli_fetch_array($result2)) {
                      				$gateway_id=$row2['gateway_id'];*/

                      		 $select_status="select err_status from tbl_errorcode where err_code='".$err_code."' limit 1";
                      				$result3 = mysqli_query($dbc, $select_status);
             
					                 if (mysqli_num_rows($result3) > 0) {
					                      while ($row3 = mysqli_fetch_array($result3)) {
					                      		echo $new_status=$row3['err_status'];

					                      		echo $update_status="update az_sendnumbers set status='".$new_status."' where id='".$id."'";
					                      		$result4 = mysqli_query($dbc, $update_status);
				
					                      		
					                      }
					                  }
					                  else
					                  {
					                  	$new_status='Other';
					                  echo $update_status="update az_sendnumbers set status='".$new_status."' where id='".$id."'";
					                  	echo "\n";
					                  	$result4 = mysqli_query($dbc, $update_status);

					                  }

                      }
                  }

}


