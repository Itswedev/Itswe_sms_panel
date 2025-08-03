<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/*error_reporting(0);*/
include_once('/var/www/html/itswe_panel/include/connection.php');

include("/var/www/html/itswe_panel/include/config.php");


remove_master_table_record();
    function remove_master_table_record()
    {

        global $dbc;

        $sendtabledetals = SENDSMSDETAILS;
        $record_dt='2022-05-08';//date('Y-m-d', strtotime(' -2 day'));
        $today_month=date('m');
        $today_year=date('Y');
        $record_month=date('m', strtotime($record_dt));
        $record_year=date('Y', strtotime($record_dt));

      /*  $record_month=date('m', strtotime(' -2 day'));
        $record_year=date('Y', strtotime(' -2 day'));
*/


         $sql="select * from $sendtabledetals where is_scheduled=1 and schedule_sent=1 and date(scheduled_time)='".$record_dt."'";
        
       $result=mysqli_query($dbc,$sql);
       $count=mysqli_num_rows($result);
       $response="no record available on ".$record_dt;
      if($count>0)
       {

      
          $monthly_archive_table=SENDSMSDETAILS.$record_year.$record_month;
        

        $sql_insert="insert into $monthly_archive_table select * FROM  $sendtabledetals WHERE date(scheduled_time)='$record_dt'";

         echo "<br>";
         $result_insert=mysqli_query($dbc,$sql_insert) or die(mysqli_error($dbc));
         $archive_count_res=mysqli_query($dbc,"select count(1) as count_archive from $monthly_archive_table where date(scheduled_time)='$record_dt'");

         $res_archive=mysqli_fetch_array($archive_count_res);
         echo $count_archive=$res_archive['count_archive'];
         if($count_archive==$count)
         {
            echo "Successfully Inserted into archive table. Record Success Date:- ".$record_dt;

            $response="Successfully Inserted into archive table. Record Success Date:- ".$record_dt;
            /*$sql_del="delete FROM $sendtabledetals WHERE date(created_at)='$record_dt' and is_scheduled!='1'";
            $result_del=mysqli_query($dbc,$sql_del);*/
         }
         else
         {
            echo "Failed to insert into archive Record Failed Date:- ".$record_dt;
            $response="Failed to insert into archive Record Failed Date:- ".$record_dt;
            $sql_del="delete FROM $monthly_archive_table WHERE date(scheduled_time)='$record_dt'";
            $result_del=mysqli_query($dbc,$sql_del);
         
         }

        
           
       }

       $myfile = fopen("/var/www/html/itswe_panel/controller/logfiles/remove_schedule_record_log.txt", "a") or die("Unable to open file!");
         
         fwrite($myfile, "\n". $response);
         fclose($myfile);
    }