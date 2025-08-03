<?php 
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

*/

$log_file = "../../error/logfiles/last_activities.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);

error_reporting(0);





 
    function get_last_activities($u_id,$activity,$login_date,$logout_date)
    {

        global $dbc;
        $ip_address = $_SERVER['REMOTE_ADDR'];
        if($login_date=='')
        {
            $login_date=0;
        }
         if($logout_date=='')
        {
            $logout_date=0;
        }
        $today=time();
         $sql="INSERT INTO `user_activities`(`userid`,`activity`,`activity_date`,`ip_address`,`login_date`,`logout_date`) VALUES('".$u_id."','".$activity."',".$today.",'".$ip_address."',".$login_date.",".$logout_date.")";
        
       $result=mysqli_query($dbc,$sql)or die(mysqli_error($dbc));

      
        
    }



    function catch_iplogs($u_id,$activity,$login_date,$logout_date,$ip_address,$login_status)
    {

        global $dbc;
       /* $ip_address = $_SERVER['REMOTE_ADDR'];*/
        if($login_date=='')
        {
            $login_date=0;
        }
        
        if($logout_date=='')
        {
            $logout_date=0;
        }
        $today=date("Y-m-d h:i:s");
        $sql="INSERT INTO `ip_logs`(`created_dt`,`ip_address`,`status`,`login_date`,`logout_date`,`username`,`login_status`) VALUES('".$today."','".$ip_address."','".$activity."',".$login_date.",".$logout_date.",'".$u_id."','".$login_status."')";
        
       $result=mysqli_query($dbc,$sql)or die(mysqli_error($dbc));

      
        
    }