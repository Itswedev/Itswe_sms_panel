<?php 

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL);*/
$log_file = "/var/www/html/itswe_panel/error/logfiles/report_summary.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);
error_reporting(0);
include_once('connection.php');

include("/var/www/html/itswe_panel/include/config.php");


report_summary_table();
    function report_summary_table()
    {

        global $dbc;

        $sendtabledetals = SENDSMSDETAILS;
        $today=date('Y-m-d', strtotime(' -1 day'));
         $sql="select userid,status,route,senderid,service_id,sent_at from $sendtabledetals where STR_TO_DATE(sent_at,'%Y-%m-%d')='$today' group by status";
        
       $result=mysqli_query($dbc,$sql);
        $count=mysqli_num_rows($result);
      if($count>0)
       {
            while($row=mysqli_fetch_array($result))
            {

                $route=$row['route'];
                $sender=$row['senderid'];
                $service_id=$row['service_id'];
                $created_dt=$row['sent_at'];
                $userid=$row['userids'];
                $bill_credit=$row['msgcredit'];
                $status=$row['status'];
                $summary_date=time();
                $query_insert="INSERT INTO `report_summary`(`userid`,`bill_credit`,`status`,`route`,`sender`,`service_id`,`created_date`,`summary_date`)
                VALUES('$userid','$bill_credit','$status','$route','$sender','$service_id','$created_dt',$summary_date)";

                $result_insert=mysqli_query($dbc,$query_insert);



            }
       }
    }