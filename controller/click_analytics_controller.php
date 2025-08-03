<?php
session_start();

include_once('../include/connection.php');
include_once('../include/config.php');
$type=@$_REQUEST['type'];
if($type=='load_click_dtls')
{
	$click_data = load_click_details();
	echo $click_data;
}
else if($type=='load_bitly_dtls')
{
	$bitly_details = load_bitly_details();
	echo $bitly_details;
}
else if($type=='load_lead_dtls')
{
	$lead_details = load_lead_details();
	echo $lead_details;
}
else if($type=='download_report')
{

	    global $dbc;
        $userid=$_SESSION['user_id'];
        $leadtable = LEAD . CURRENTMONTH;
        $job_id = $_REQUEST['job_id'];
        $extraWhere="message_id='".$job_id."'";
        $fileName = "lead_details_report_".$job_id.".xls"; 
        $fields_query="lead_id,mobile_no,message_id,date ";
        $query="select $fields_query from $leadtable where $extraWhere";
        $result_download=mysqli_query($dbc,$query);
        $count_rows=mysqli_num_rows($result_download);
        $columnHeader = '';  
        $columnHeader = "Lead ID" . "\t" . "Mobile No" . "\t" . "Message ID" . "\t". "Date" . "\t";  
        $setData = '';  
        while ($rec = mysqli_fetch_row($result_download)) {  

            $rowData = '';  
            foreach ($rec as $value) {  
                $value = '"' . $value . '"' . "\t";  
                $rowData .= $value;  
            }  
            $setData .= trim($rowData) . "\n";  
        }  
 header("Content-type: application/octet-stream");  
 header("Content-Disposition: attachment; filename=$fileName");  
 header("Pragma: no-cache");  
 header("Expires: 0");  
 echo ucwords($columnHeader) . "\n" . $setData . "\n";  
         
        
}

function load_click_details()
{
	global $dbc;
	$userid=$_SESSION['user_id'];
	$user_role=$_SESSION['user_role'];
	$today_dt=date("Y-m-d");
	$extraWhere="";
	if ($_REQUEST['frmDate'] != "" && $_REQUEST['toDate'] != "") 
	{
		    $frmDate = $_REQUEST["frmDate"];
		    $toDate = $_REQUEST["toDate"];

		    $from_dt_split=explode("-",$frmDate);
		    $frm_year=$from_dt_split[0];
		    $frm_month=$from_dt_split[1];

		    $to_dt_split=explode("-",$toDate);
		     $to_year=$to_dt_split[0];
		    $to_month=$to_dt_split[1];

		    if($frm_month==$to_month && $frm_year==$to_year)
		    {
		    		$sendtable = SENDSMS .$frm_year.$frm_month;
		    		
		    		
		    }

		    $extraWhere=" (date(job_tbl.sent_at) BETWEEN '" . $frmDate . "' AND '" . $toDate . "')";
	}
	else
	{

		    $frmDate = $today_dt;
		    $toDate = $today_dt;

		    $from_dt_split=explode("-",$frmDate);
		    $frm_year=$from_dt_split[0];
		    $frm_month=$from_dt_split[1];

		    $to_dt_split=explode("-",$toDate);
		    $to_year=$to_dt_split[0];
		    $to_month=$to_dt_split[1];

		    if($frm_month==$to_month && $frm_year==$to_year)
		    {
		    		$sendtable = SENDSMS .$frm_year.$frm_month;	
		    }

	    $extraWhere=" (date(job_tbl.sent_at) BETWEEN '" . $frmDate . "' AND '" . $toDate . "')";
	}

	if($user_role!='mds_usr')
		{
			$sql="select job_tbl.userid,job_tbl.campaign_name,job_tbl.fake_numbers,job_tbl.job_id,job_tbl.numbers_count as click_count,count(trk.msg_job_id),job_tbl.sent_at from $sendtable as job_tbl inner join az_tracking_url as trk on trk.msg_job_id=job_tbl.job_id  where $extraWhere group by job_tbl.job_id";
		}
		else
		{
			$sql="select job_tbl.userid,job_tbl.fake_numbers,job_tbl.campaign_name,job_tbl.job_id,job_tbl.numbers_count,count(trk.msg_job_id) as click_count,job_tbl.sent_at from $sendtable as job_tbl join az_tracking_url as trk on trk.msg_job_id=job_tbl.job_id  where $extraWhere and job_tbl.userid='".$userid."' group by job_tbl.job_id";
		}

	//	return $sql;
	$result=mysqli_query($dbc,$sql);
	 $count=mysqli_num_rows($result);
	$i=1;
	
	if($count>0)
	{
		while($row=mysqli_fetch_array($result)) {
		$username=$row['userid'];
		$campaign_name=$row['campaign_name'];
   		$job_id=$row['job_id'];
   		$bitly_count =$row['numbers_count'];
   		$click_count =$row['click_count'];
   		$lead_count =$row['fake_numbers'];
   		$sent_at =$row['sent_at'];
   		$table_body.="<tr>";
   		if($user_role=="mds_adm")
   		{
   			$table_body.="<td>$username</td>";	
   		}
   		$table_body.="<td>$job_id</td>";	
   		$table_body.="<td>$campaign_name</td>";	
   		$table_body.="<td>$bitly_count</td>";	
   		$table_body.="<td>$click_count</td>";
   		$table_body.="<td><a href='dashboard.php?page=lead_count_dtls&msg_job_id=$job_id'>$lead_count</a></td>";	 
   		$table_body.="<td>$sent_at</td>";	
   		$table_body.="<td>Download</td>";	
   		$table_body.="</tr>";
   		}

   		
   	}

   	return $table_body;

}

function load_bitly_details()
{
	global $dbc;
	$userid=$_SESSION['user_id'];
	$user_role=$_SESSION['user_role'];
	$today_dt=date("Y-m-d");
	$msg_job_id=$_REQUEST['job_id'];
	$extraWhere="";
	
		    $frmDate = $today_dt;
		    $toDate = $today_dt;

		    $from_dt_split=explode("-",$frmDate);
		    $frm_year=$from_dt_split[0];
		    $frm_month=$from_dt_split[1];

		    $to_dt_split=explode("-",$toDate);
		    $to_year=$to_dt_split[0];
		    $to_month=$to_dt_split[1];

		    if($frm_month==$to_month && $frm_year==$to_year)
		    {
		    		$sendtable = SENDSMSDETAILS .$frm_year.$frm_month;	
		    }

	    $extraWhere=" msg_job_id='".$msg_job_id."'";
	

	if($user_role!='mds_usr')
		{

			$sql="select msgdata,mobile_number from az_sendnumbers where $extraWhere";
		}
		else
		{
			$sql="select msgdata,mobile_number from az_sendnumbers where $extraWhere";
		}

	//	return $sql;
	$result=mysqli_query($dbc,$sql);
	 $count=mysqli_num_rows($result);
	$i=1;
	
	if($count>0)
	{
		while($row=mysqli_fetch_array($result)) {
		$username=$row['userid'];
		$campaign_name=$row['campaign_name'];
   		$job_id=$row['job_id'];
   		$bitly_count =$row['numbers_count'];
   		$click_count =$row['click_count'];
   		$sent_at =$row['sent_at'];
   		$table_body.="<tr>";
   		if($user_role=="mds_adm")
   		{
   			$table_body.="<td>$username</td>";	
   		}
   		$table_body.="<td>$job_id</td>";	
   		$table_body.="<td>$campaign_name</td>";	
   		$table_body.="<td><a href='dashboard.php?page=bitly_count&msg_job_id=$job_id'>$bitly_count</a></td>";	
   		$table_body.="<td><a href='dashboard.php?page=click_count&msg_job_id=$job_id'>$click_count</a></td>";
   		$table_body.="<td>0</td>";	 
   		$table_body.="<td>$sent_at</td>";	
   		$table_body.="<td>Download</td>";	
   		$table_body.="</tr>";
   		}

   		
   	}

   	return $table_body;

}



function load_lead_details()
{
	global $dbc;
	$userid=$_SESSION['user_id'];
	$user_role=$_SESSION['user_role'];
	$today_dt=date("Y-m-d");
	$msg_job_id=$_REQUEST['job_id'];
	$extraWhere="";
	$leadtable = LEAD . CURRENTMONTH;

		    $frmDate = $today_dt;
		    $toDate = $today_dt;

		    $from_dt_split=explode("-",$frmDate);
		    $frm_year=$from_dt_split[0];
		    $frm_month=$from_dt_split[1];

		    $to_dt_split=explode("-",$toDate);
		    $to_year=$to_dt_split[0];
		    $to_month=$to_dt_split[1];

		    if($frm_month==$to_month && $frm_year==$to_year)
		    {
		    		$sendtable = LEAD .$frm_year.$frm_month;	
		    }

    $extraWhere=" message_id='".$msg_job_id."'";
	

	/*if($user_role!='mds_usr')
		{
*/
			//$sql="select * from $leadtable where $extraWhere";
		/*}
		else
		{
		*/	$sql="select * from $leadtable where $extraWhere";
		//}

	//	return $sql;
	$result=mysqli_query($dbc,$sql);
	 $count=mysqli_num_rows($result);
	$i=1;
	
	if($count>0)
	{
		while($row=mysqli_fetch_array($result)) {
		/*$username=$row['userid'];*/
	
   		$job_id=$row['message_id'];
   		$mobile_no =$row['mobile_no'];
   		$lead_id =$row['lead_id'];
   		$date =$row['date'];
   		$table_body.="<tr>";
   		
   		$table_body.="<td>$lead_id</td>";	

   		$table_body.="<td>$mobile_no</td>";	
   		$table_body.="<td>$date</td>";
   	
   		$table_body.="</tr>";
   		}

   		
   	}

   	return $table_body;

}

?>