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


update_voice_user_summary_table();
    function update_voice_user_summary_table()
    {

        global $dbc;

        //$sendtabledetals = SENDSMSDETAILS;
        $today=date('Y-m-d', strtotime(' -1 day'));
  
        $sql="select sum(msgcredit) as msgcredit,userid,status,sent_at,parent_id from sms.voice_call where date(sent_at)='$today' and schedule_sent=1 group by userid,status";

       
       $result=mysqli_query($dbc,$sql);
        $count=mysqli_num_rows($result);
      if($count>0)
       {
            while($row=mysqli_fetch_array($result))
            {

                
                $created_dt=$row['sent_at'];
                $userid=$row['userid'];
                $bill_credit=$row['msgcredit'];
                $status=$row['status'];
                $parent_id=$row['parent_id'];
                $summary_date=time();
                $query_insert="INSERT INTO `voice_user_summary`(`userid`,`bill_credit`,`status`,`created_date`,`summary_date`,`parent_id`)
                VALUES('$userid','$bill_credit','$status','$created_dt',$summary_date,'$parent_id')";

                $result_insert=mysqli_query($dbc,$query_insert);



            }
       }
    }