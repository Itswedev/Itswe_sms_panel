<?php 

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


/*$log_file = "/var/www/html/itswe_panel/error/logfiles/remove_master_table_record.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);*/


//error_reporting(0);
include_once('/var/www/html/itswe_panel/include/connection.php');

include("/var/www/html/itswe_panel/include/config.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


update_user_summary_table();


//remove_master_table_record();


    function update_user_summary_table()
    {

        global $dbc;

        $sendtabledetals = SENDSMSDETAILS;
        $today=date('Y-m-d', strtotime(' -1 day'));
        $today="2025-08-20";
          /*$sql="select sum(msgcredit) as msgcredit,sum(if(status='Delivered',msgcredit,0))as DELIVRD,sum(if(status='submitted',msgcredit,0))as submitted,sum(if(status='Failed',msgcredit,0))as Failed,sum(if(status='Rejected',msgcredit,0))as Rejected,sum(if(status='DND',msgcredit,0))as DND,sum(if(status='Block',msgcredit,0))as Block,sum(if(status='Spam',msgcredit,0))as Spam,sum(if(status='NULL',msgcredit,0))as null_stat,sum(if(status='Refund',msgcredit,0))as Refund,sum(if(status='Smart',msgcredit,0))as Smart,userids,status,route,senderid,service_id,created_at from $sendtabledetals where STR_TO_DATE(created_at,'%Y-%m-%d')='$today' group by status";*/
        $sql="select sum(msgcredit) as msgcredit,userids,status,route,senderid,service_id,sent_at,parent_id,SUBSTRING_INDEX(SUBSTRING_INDEX(metadata, 'TID=', -1), '&', 1) AS TID from az_sendnumbers where date(sent_at)='$today' and schedule_sent=1  group by status,userids,senderid,route,tid";
        
       
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
                $template_id=$row['TID'];
                $summary_date=time();
                $query_insert="INSERT INTO `user_summary`(`userid`,`bill_credit`,`status`,`route`,`sender`,`service_id`,`created_date`,`summary_date`,`parent_id`,`tid`)
                VALUES('$userid','$bill_credit','$status','$route','$sender','$service_id','$created_dt',$summary_date,'$parent_id',$template_id)";

                $result_insert=mysqli_query($dbc,$query_insert) or die(mysqli_error($dbc));
                if($result_insert)
                {
                    $response="Successfully inserted into user_summary table for user: $userid, status: $status, route: $route, sender: $sender, service_id: $service_id, created_date: $created_dt, parent_id: $parent_id, template_id: $template_id";
                }
                else
                {
                    $response="Failed to insert into user_summary table for user: $userid, status: $status, route: $route, sender: $sender, service_id: $service_id, created_date: $created_dt, parent_id: $parent_id, template_id: $template_id";
                }

                echo $response."\n";
                



            }
       }



       $response="Summary generated on ".date('Y-m-d h:i');
       $myfile = fopen("/var/www/html/itswe_panel/error/remove_master_table_record_log.txt", "a") or die("Unable to open file!");
         
       fwrite($myfile, "\n". $response);
       fclose($myfile);
    }




    function remove_master_table_record()
    {

        global $dbc;
        $response="Cron start time:- ".date('Y-m-d h:i');
        $sendtabledetals = SENDSMSDETAILS;
        $sendtabledetals_bk = SENDSMSDETAILS_BK;
        //$sendtabledetals = 'az_sendnumbers_bk';
        $record_dt=date('Y-m-d', strtotime(' -1 day'));
        $today_month=date('m');
        $today_year=date('Y');
        $record_month=date('m', strtotime(' -1 day'));
        $record_year=date('Y', strtotime(' -1 day'));

        $sql="select * from $sendtabledetals where date(sent_at)='$record_dt' and is_scheduled!=1 and schedule_sent=1";
        
       $result=mysqli_query($dbc,$sql);
       $count=mysqli_num_rows($result);
       //$response.="no record available on ".$record_dt;
       if($count>0)
       {

      
         //$monthly_archive_table=SENDSMSDETAILS.$record_year.$record_month;
        $monthly_archive_table='az_sendnumbers'.$record_year.$record_month;
        

        $sql_insert="insert into $monthly_archive_table select * FROM $sendtabledetals WHERE date(sent_at)='$record_dt' and is_scheduled!=1 and schedule_sent=1";

         /*echo "<br>";*/
         $result_insert=mysqli_query($dbc,$sql_insert) or die(mysqli_error($dbc));
        /* echo "select count(1) as count_archive from $monthly_archive_table where date(created_at)='$record_dt'";*/
         $archive_count_res=mysqli_query($dbc,"select count(1) as count_archive from $monthly_archive_table where date(sent_at)='$record_dt' and is_scheduled!=1 and schedule_sent=1");

         while($res_archive=mysqli_fetch_array($archive_count_res))
         {
           $count_archive=$res_archive['count_archive']; 
         }
         
         if($count_archive==$count)
         {
           /* echo "Successfully Inserted into archive table. Record Success Date:- ".$record_dt;*/

            $response.="Successfully Inserted into archive table. Record Success Date:- ".$record_dt.", record count:- $count";

            $sql_bk="insert into $sendtabledetals_bk select * FROM $sendtabledetals WHERE date(sent_at)='$record_dt' and is_scheduled!=1 and schedule_sent=1";
            $result_bk=mysqli_query($dbc,$sql_bk);

            $sql_del="delete FROM $sendtabledetals WHERE date(sent_at)='$record_dt' and is_scheduled!=1 and schedule_sent=1";
            $result_del=mysqli_query($dbc,$sql_del);
         }
         else
         {
            echo "Failed to insert into archive Record Failed Date:- ".$record_dt;
            $response.="Failed to insert into archive Record Failed Date:- ".$record_dt.", record count:- $count";
            $sql_del="delete FROM $monthly_archive_table WHERE date(sent_at)='$record_dt' and is_scheduled!=1 and schedule_sent=1";
            $result_del=mysqli_query($dbc,$sql_del);
         
         }

        
           
       }
       else
       {
        $response.="no record available on ".$record_dt;
       }
       $response.="Cron end time:- ".date('Y-m-d h:i');
       $myfile = fopen("/var/www/html/itswe_panel/error/remove_master_table_record_log.txt", "a") or die("Unable to open file!");
         
         fwrite($myfile, "\n". $response);
         fclose($myfile);
    }