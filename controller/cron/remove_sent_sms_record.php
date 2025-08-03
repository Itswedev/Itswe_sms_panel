<?php 


error_reporting(0);
include_once('/var/www/html/itswe_panel/include/connection.php');

include("/var/www/html/itswe_panel/include/config.php");


remove_sent_sms_table_record();
    function remove_sent_sms_table_record()
    {
        global $dbc;
        $response="Cron start time:- ".date('Y-m-d h:i');
        $sentsms = SENTSMS;

        $sent_sms_bk= 'sent_sms_bk';

        $sql_del="truncate table $sent_sms_bk";
        $result_del=mysqli_query($dbc,$sql_del);

        $sql="select * from $sentsms";
        
        $result=mysqli_query($dbc,$sql);
        $count=mysqli_num_rows($result);
       //$response.="no record available on ".$record_dt;
       if($count>0)
       {

      
         //$sent_sms_bk=SENDSMSDETAILS.$record_year.$record_month;
       

        $sql_insert="insert into $sent_sms_bk select * FROM $sentsms ";
         /*echo "<br>";*/
         $result_insert=mysqli_query($dbc,$sql_insert) or die(mysqli_error($dbc));
        /* echo "select count(1) as count_archive from $sent_sms_bk where date(created_date)='$record_dt'";*/
         $archive_count_res=mysqli_query($dbc,"select count(1) as count_archive from $sent_sms_bk ");

         while($res_archive=mysqli_fetch_array($archive_count_res))
         {
           $count_archive=$res_archive['count_archive']; 
         }
         
         if($count_archive==$count)
         {
           /* echo "Successfully Inserted into archive table. Record Success Date:- ".$record_dt;*/

            echo $response.="Successfully Inserted into archive table. Record Success Date:- ".$record_dt.", record count:- $count";
            $sql_del="truncate table $sentsms";
            $result_del=mysqli_query($dbc,$sql_del);
         }
         else
         {
            echo "Failed to insert into archive Record Failed Date:- ".$record_dt;
            $response.="Failed to insert into archive Record Failed Date:- ".$record_dt.", record count:- $count";
           /* $sql_del="truncate table $sent_sms_bk";
            $result_del=mysqli_query($dbc,$sql_del);*/
         
         }

        
           
       }
       else
       {
        $response.="no record available on ".$record_dt;
       }
       $response.="Cron end time:- ".date('Y-m-d h:i');
       $myfile = fopen("/var/www/html/itswe_panel/controller/logfiles/remove_sent_sms_record_log.txt", "a") or die("Unable to open file!");
         
         fwrite($myfile, "\n". $response);
         fclose($myfile);
    }

    ?>