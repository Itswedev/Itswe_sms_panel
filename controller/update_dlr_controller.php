<?php
session_start();
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
// error_reporting(0);
$log_file = "../error/logfiles/user_controller.log";
 
 error_reporting(E_ALL); 
 
// setting error logging to be active
ini_set("log_errors", TRUE); 
  
// setting the logging file in php.ini
ini_set('error_log', $log_file);
include('../include/connection.php');
// require('classes/ssp.class.php');
include('../include/config.php');
//include_once('../include/datatable_dbconnection.php');
include('classes/last_activities.php');
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
if(isset($_REQUEST['list_type']))
{
    $list_type=$_REQUEST['list_type'];


    if($list_type=='load_job_id')
    {
        $result = load_job_id();
            echo $result;

    }
    else if($list_type=='load_old_status')
    {
        $result = load_old_status();
            echo $result;

    }
    else if($list_type=='load_from_error')
    {
        $result = load_from_error();
            echo $result;

    }
    else if($list_type=='update_dlr')
    {
        $result = update_dlr();
            echo $result;

    }

}

function load_job_id()
{
        global $dbc;
        
        $userid=$_REQUEST['userid'];
        $result = array();
        $job_tbl=SENDSMS.CURRENTMONTH;
        $today_dt=date('Y-m-d');
        $sql = "SELECT job_id FROM $job_tbl where userid='".$userid."' and date(sent_at)='".$today_dt."' and is_picked=1";
        $values = mysqli_query($dbc, $sql);
        $count=mysqli_num_rows($values);
        $option ="<option value=''>Select campaign ID</option>";
        if($count>0)
        {
            
        while ($row = mysqli_fetch_array($values)) {
            $job_id=$row['job_id'];
            $option .="<option value='".$job_id."'>$job_id</option>";

        }



        }

        return $option;
}



function load_old_status()
{
        global $dbc;
        
        $camp_id=$_REQUEST['camp_id'];
        $result = array();
        $master_tbl=SENDSMSDETAILS;
        
        $sql = "SELECT `status` FROM $master_tbl where msg_job_id='".$camp_id."' and status not in ('Delivered','Scheduled') group by 1";
        $values = mysqli_query($dbc, $sql);
        $count=mysqli_num_rows($values);
        $option ="<option value=''>Select Status</option>";
        if($count>0)
        {
            
        while ($row = mysqli_fetch_array($values)) {
            $status=$row['status'];
            $option .="<option value='".$status."'>$status</option>";

        }



        }

        return $option;
}




function load_from_error()
{
        global $dbc;
        
        $old_status=$_REQUEST['old_status'];
        $camp_id=$_REQUEST['camp_id'];
        $result = array();
        $master_tbl=SENDSMSDETAILS;
        
        $sql = "SELECT `err_code` FROM $master_tbl where msg_job_id='".$camp_id."' and status='".$old_status."' group by 1";
        $values = mysqli_query($dbc, $sql);
        $count=mysqli_num_rows($values);
        $option ="<option value=''>Select Error Code</option>";
        if($count>0)
        {
            
        while ($row = mysqli_fetch_array($values)) {
            $error_code=$row['err_code'];
            $option .="<option value='".$error_code."'>$error_code</option>";

        }



        }

        return $option;
}




function update_dlr()
{
        global $dbc;
        
        $user_name=$_REQUEST['user_name'];
        $camp_id=$_REQUEST['camp_id'];
        $rows_count=$_REQUEST['rows_count'];
        $from_status=$_REQUEST['from_status'];
        $to_status=$_REQUEST['to_status'];
        $from_error=$_REQUEST['from_error'];
        $to_error_code=$_REQUEST['to_error_code'];


        $result = array();
        $master_tbl=SENDSMSDETAILS;
        
       $sql = "update $master_tbl set status='".$to_status."' ,err_code='".$to_error_code."'  where msg_job_id='".$camp_id."' and err_code='".$from_error."' and userids='".$user_name."' limit $rows_count";
        $values = mysqli_query($dbc, $sql);
        if($values)
        {
            return 1;
        }
        else{
            return 0;
        }
        
}