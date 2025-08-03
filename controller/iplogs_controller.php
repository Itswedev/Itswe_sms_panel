<?php
session_start();
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
$log_file = "../error/logfiles/utility_controller.log";
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);


include_once('../include/connection.php');
require('classes/ssp.class.php');
include('../include/config.php');
include('classes/last_activities.php');


if(isset($_REQUEST['list_type']) && $_REQUEST['list_type'] == 'load_ip_logs')
{

  /* $userdata= loadUserData();
   echo $userdata;*/
    	
			$table = IPLOGS;

			$primaryKey = 'id';

			$columns = array(
					array( 'db' => 'created_dt','dt' => 0 ),
			    array( 'db' => 'ip_address','dt' => 1 ),
			    array( 'db' => 'status','dt' => 2 ) 
			);
			 
			// SQL server connection information
			global $sql_details;

			$extraWhere="";

			if ($_REQUEST['frmDate'] != "" && $_REQUEST['toDate'] != "") {
		    $frmDate = $_REQUEST["frmDate"];
		    $toDate = $_REQUEST["toDate"];
		    $extraWhere.="(date(created_dt) BETWEEN '" . $frmDate . "' AND '" . $toDate . "')";
			} 



			$username=$_SESSION['user_name'];
			if($userid!='1')
			{
				if($extraWhere!="")
				{
					$extraWhere=" and username='$username'";
				}
				else
				{
					$extraWhere=" username='$username'";
				}
			}

			echo json_encode(SSP::complex( $_REQUEST, $sql_details, $table, $primaryKey, $columns,$test=null,$extraWhere));

}






?>