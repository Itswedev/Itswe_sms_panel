<?php 

error_reporting(0);
include_once('/var/www/html/itswe_panel/include/connection.php');

include("/var/www/html/itswe_panel/include/config.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

remove_temp_tracking_data();
function remove_temp_tracking_data()
{

     global $dbc;
        $response="Cron start time:- ".date('Y-m-d h:i');
        $temp_tracking_key = "az_temp_trackingkey";
       
        $record_dt=date('Y-m-d', strtotime(' -1 day'));
        $today_month=date('m');
        $today_year=date('Y');
        $record_month=date('m', strtotime(' -1 day'));
        $record_year=date('Y', strtotime(' -1 day'));

        $main_count_res=mysqli_query($dbc,"select count(1) as count_row from $temp_tracking_key where date(create_date)='$record_dt' and is_scheduled=0");

         while($res_main=mysqli_fetch_array($main_count_res))
         {
           $count_main=$res_main['count_row']; 
         }

        if($count_main>0)
        {
            $monthly_archive_table='az_temp_trackingkey_'.$record_year.$record_month;
            

            $sql_insert="insert into $monthly_archive_table select * FROM $temp_tracking_key WHERE date(create_date)='$record_dt' and is_scheduled=0";
            $result_insert=mysqli_query($dbc,$sql_insert) or die(mysqli_error($dbc));
            $archive_count_res=mysqli_query($dbc,"select count(1) as count_archive from $monthly_archive_table where date(create_date)='$record_dt' and is_scheduled=0");
            while($res_archive=mysqli_fetch_array($archive_count_res))
            {
               $count_archive=$res_archive['count_archive']; 
            }

            if($count_main==$count_archive)
            {
                echo "inserted successfully!!!";
                $sql_del="delete FROM $temp_tracking_key WHERE date(create_date)='$record_dt' and is_scheduled=0";
                $result_del=mysqli_query($dbc,$sql_del);
            }
        }
    }

?>