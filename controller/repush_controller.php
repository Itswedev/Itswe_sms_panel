<?php
session_start();

error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);
include_once('../include/connection.php');
include('../include/config.php');
include('classes/last_activities.php');
if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'load_status_gateway') {
    $job_id=$_REQUEST['job_id'];
   $rs = load_status($job_id);
   $rs2 = all_gateway_dropdown();
  
    echo $rs."|".$rs2;

}
else if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'pause_campaign') {
    global $dbc;
    $job_id=$_REQUEST['job_id'];
    $sendtable = SENDSMS . CURRENTMONTH;
    $senddtlstable = SENDSMSDETAILS;
    $update_job="update $sendtable set is_picked=2 where job_id='".$job_id."'";
    $rs = mysqli_query($dbc, $update_job);

    if($rs)
    {
        $update_master="update $senddtlstable set is_picked=2 where msg_job_id='".$job_id."' and is_picked=0";
        $rs2 = mysqli_query($dbc, $update_master);
        if($rs2)
        {
            echo 1;
        }
        else{
            echo 0;
        }

    }
    else{
        echo 0;
    }
     
    

}
else if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'play_campaign') {
    global $dbc;
    $job_id=$_REQUEST['job_id'];
    $sendtable = SENDSMS . CURRENTMONTH;
    $senddtlstable = SENDSMSDETAILS;
     
    
   $update_master="update $senddtlstable set is_picked='0' where msg_job_id='".$job_id."' and is_picked=2";
   $rs = mysqli_query($dbc, $update_master);
    if($rs)
    {
       // $update_master="update $senddtlstable set is_picked=0 where msg_job_id='".$job_id."' and is_picked=2";
        $update_job="update $sendtable set is_picked='0' where job_id='".$job_id."'";
        $rs2 = mysqli_query($dbc, $update_job);
        if($rs2)
        {
            echo 1;
        }
        else{
            echo 0;
        }

    }
    else{
        echo 0;
    }
     
    

}
else if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'repush_job')
{   

    $job_id=$_REQUEST['repush_job_id'];
    $status=$_REQUEST['status'];
    $gateway_id=$_REQUEST['gateway_id'];

    if(empty($job_id) || empty($status) || empty($gateway_id))
    {
        echo -1;
        exit();
    }
    else
    {

        $table="az_sendnumbers";
        global $dbc;
        $sql="update $table set status='Submitted' , is_picked=3 ,msgcredit=msgcredit*2, operator_status_id='".$gateway_id."' where msg_job_id='".$job_id."' and status='".$status."'";
        $rs = mysqli_query($dbc, $sql);

        if($rs)
        {
            echo 1;

        }
        else{
            echo 0;
        }
    }

}


function load_status($job_id)
{
    global $dbc;
    $today_date=date('Y-m-d');
   $sql_select = "SELECT `status` from az_sendnumbers where msg_job_id='$job_id' and status!='Delivered' and is_picked=1 and date(sent_at)='".$today_date."' group by status";
    $query_select = mysqli_query($dbc, $sql_select);
    $option="<option value=''>Select Status</option>";
    while($row=mysqli_fetch_array($query_select))
    {
        $status=$row['status'];
        $option.="<option>$status</option>";
    }
    return $option;
}

function all_gateway_dropdown()
{
global $dbc;
        $result = array();
        $sql = "SELECT gateway_id,smsc_id  FROM az_sms_gateway where status=1 ORDER BY created_at DESC";
        $values = mysqli_query($dbc, $sql);
        $option="<option value=''>Select Gateway</option>";
       
        while ($row = mysqli_fetch_assoc($values)) {
            $option.="<option value='".$row['smsc_id']."'>".$row['smsc_id']."</option>";
        }
        return $option;

}

?>