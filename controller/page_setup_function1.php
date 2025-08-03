<?php 
$log_file = "../error/logfiles/page_setup.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);

/*session_start();*/
function choose_navigation($user_type)
{

	switch($user_type)
	{
	case 'mds_adm':
		$nav="view/mds_administrator/include/navigation.php";
		// code...
		break;
	case 'mds_su_ad':
		$nav="view/mds_super_admin/include/navigation.php";
		break;
	case 'mds_ad':
		$nav="view/mds_admin/include/navigation.php";
		break;
	case 'mds_acc':
		$nav="view/mds_accounts/include/navigation.php";
		break;
	case 'mds_rs':
		$nav="view/mds_reseller/include/navigation.php";
		break;
	case 'mds_usr':
		$nav="view/mds_user/include/navigation.php";
		break;
	default:
		header('Location:index.php');
	}

		return $nav;
}

function choose_dashboard($user_type)
{

	switch($user_type)
	{
	case 'mds_adm':
		$dashboard="view/mds_administrator/dash-boarda1.php";
		// code...
		break;
	case 'mds_su_ad':
		$dashboard="view/mds_super_admin/dashboard.php";
		break;
	case 'mds_ad':
		$dashboard="view/mds_admin/dashboard.php";
		break;
	case 'mds_acc':
		$dashboard="view/mds_accounts/dashboard.php";
		break;
	case 'mds_rs':
		$dashboard="view/mds_reseller/dashboard.php";
		break;
	case 'mds_usr':
		$dashboard="view/mds_user/dashboard.php";
		break;
	default:
		header('Location:index.php');
	}

		return $dashboard;
}





 ?>