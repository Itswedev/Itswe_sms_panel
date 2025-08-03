<?php 

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
$log_file = "/var/www/html/itswe_panel/error/logfiles/user_summary_cron.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);
error_reporting(0);
include_once('/var/www/html/itswe_panel/include/connection.php');

include("/var/www/html/itswe_panel/include/config.php");


update_user_summary_table();
    function update_user_summary_table()
    {

        global $dbc;
    }
    