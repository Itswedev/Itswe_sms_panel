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

        $sendtabledetals = SENDSMSDETAILS;
        $today=date('Y-m-d', strtotime(' -1 day'));
          /*$sql="select sum(msgcredit) as msgcredit,sum(if(status='Delivered',msgcredit,0))as DELIVRD,sum(if(status='submitted',msgcredit,0))as submitted,sum(if(status='Failed',msgcredit,0))as Failed,sum(if(status='Rejected',msgcredit,0))as Rejected,sum(if(status='DND',msgcredit,0))as DND,sum(if(status='Block',msgcredit,0))as Block,sum(if(status='Spam',msgcredit,0))as Spam,sum(if(status='NULL',msgcredit,0))as null_stat,sum(if(status='Refund',msgcredit,0))as Refund,sum(if(status='Smart',msgcredit,0))as Smart,userids,status,route,senderid,service_id,created_at from $sendtabledetals where STR_TO_DATE(created_at,'%Y-%m-%d')='$today' group by status";*/
        $sql="select sum(msgcredit) as msgcredit,userids,status,route,senderid,service_id,sent_at,parent_id from sms.az_sendnumbers where date(sent_at)='$today' and schedule_sent=1 group by userids,status,route,senderid";

       
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
                $parent_id=$row['parent_id'];
                $summary_date=time();
                $query_insert="INSERT INTO `user_summary`(`userid`,`bill_credit`,`status`,`route`,`sender`,`service_id`,`created_date`,`summary_date`,`parent_id`)
                VALUES('$userid','$bill_credit','$status','$route','$sender','$service_id','$created_dt',$summary_date,'$parent_id')";

                $result_insert=mysqli_query($dbc,$query_insert);



            }
       }
    }