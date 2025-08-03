<?php 

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/


$log_file = "/var/www/html/itswe_panel/error/logfiles/remove_schedule_tbl_record.log"; 
/*error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);*/

/*
error_reporting(0);*/
include_once('/var/www/html/itswe_panel/include/connection.php');

include("/var/www/html/itswe_panel/include/config.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


remove_master_table_record();
    function remove_master_table_record()
    {

        global $dbc;

        $sendtabledetals = SENDSMSDETAILS;
        $sendtabledetals_bk = SENDSMSDETAILS_BK;
        $record_dt=date('Y-m-d', strtotime(' -1 day'));
        $today_month=date('m');
        $today_year=date('Y');
        $record_month=date('m', strtotime(' -1 day'));
        $record_year=date('Y', strtotime(' -1 day'));

       $sql="select * from $sendtabledetals where is_scheduled=1 and schedule_sent=1 and date(sent_at)='".$record_dt."'";
        
       $result=mysqli_query($dbc,$sql) or die(mysql_error($dbc));
        $count=mysqli_num_rows($result);
       $response="no record available on ".$record_dt;
       if($count>0)
       {

      
          $monthly_archive_table=SENDSMSDETAILS.$record_year.$record_month;
        

        $sql_insert="insert into $monthly_archive_table select * FROM  $sendtabledetals WHERE is_scheduled=1 and schedule_sent=1 and date(sent_at)='$record_dt'";

         echo "<br>";
         $result_insert=mysqli_query($dbc,$sql_insert) or die(mysqli_error($dbc));
         $archive_count_res=mysqli_query($dbc,"select count(1) as count_archive from $monthly_archive_table where is_scheduled=1 and schedule_sent=1 and date(sent_at)='$record_dt'");

         $res_archive=mysqli_fetch_array($archive_count_res);
          $count_archive=$res_archive['count_archive'];
         if($count_archive==$count)
         {
            echo "Successfully Inserted into archive table. Record Success Date:- ".$record_dt;

            $response="Successfully Inserted into archive table. Record Success Date:- ".$record_dt;

            $sql_bk="insert into $sendtabledetals_bk select * FROM  $sendtabledetals WHERE is_scheduled=1 and schedule_sent=1 and date(sent_at)='$record_dt'";
            $result_bk=mysqli_query($dbc,$sql_bk);
 
            $sql_del="delete FROM $sendtabledetals where is_scheduled=1 and schedule_sent=1 and date(sent_at)='$record_dt'";
            $result_del=mysqli_query($dbc,$sql_del);
         }
         else
         {
            echo "Failed to insert into archive Record Failed Date:- ".$record_dt;
            $response="Failed to insert into archive Record Failed Date:- ".$record_dt;
            $sql_del="delete FROM $monthly_archive_table WHERE date(sent_at)='$record_dt' and is_scheduled=1 and schedule_sent=1";
            $result_del=mysqli_query($dbc,$sql_del);
         
         }

        
           
       }

       $myfile = fopen("/var/www/html/itswe_panel/controller/logfiles/remove_schedule_record_log.txt", "a") or die("Unable to open file!");
         
         fwrite($myfile, "\n". $response);
         fclose($myfile);
    }