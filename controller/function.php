<?php 
$log_file = "../error/logfiles/function.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);
function choose_navigation($user_type)
{

	switch($user_type)
	{
	case 'mds_adm':
		$nav="../mds_administrator/include/navigation.php";
		// code...
		break;
	case 'mds_su_ad':
		$nav="mds_super_admin/include/navigation.php";
		break;
	case 'mds_ad':
		$nav="mds_admin/include/navigation.php";
		break;
	case 'mds_acc':
		$nav="mds_accounts/include/navigation.php";
		break;
	case 'mds_rs':
		$nav="mds_reseller/include/navigation.php";
		break;
	case 'mds_usr':
		$nav="mds_user/include/navigation.php";
		break;
	default:
		header('Location:../index.php');
	}

		return $nav;
}





 ?>