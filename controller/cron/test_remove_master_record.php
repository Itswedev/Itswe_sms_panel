<?php 

error_reporting(0);
include_once('/var/www/html/itswe_panel/include/connection.php');
include("/var/www/html/itswe_panel/include/config.php");



update_user_summary_table();

    function update_user_summary_table()
    {

        global $dbc;

        $sendtabledetals = "az_sendnumbers202309";
        $today=date('Y-m-d', strtotime(' -3 day'));
         
        $sql="select sum(msgcredit) as msgcredit,userids,status,route,senderid,service_id,sent_at,parent_id from sms.az_sendnumbers202309 where date(sent_at)='$today' and schedule_sent=1 and userids=34  group by status,userids";

       
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


