<?php




$log_file = "../error/logfiles/report_controller.log";
 
error_reporting(E_ALL); 
/*// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);*/
ini_set('max_execution_time', '0');

include('../include/connection.php');
require('classes/ssp.class.php');
include('../include/config.php');
function __autoload($class)
{	
	require_once('../Classes/PHPExcel/'.$class.'.php');
}

/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

/*$obj = new report();*/

$u_id=$_SESSION['user_id'];


if(isset($_REQUEST['list_type']))
{
    $list_type=$_REQUEST['list_type'];

    if($list_type=='download_report')
    {
	    		$rs=load_send_job_data();
	    		$job_id=$_REQUEST['job_id'];
    			$message_job_id=$rs[0]['job_id'];

    			$message_id=$rs[0]['id'];
    			$sendtabledetals = SENDCALLDETAILS;
    			$job_date=date("Y-m-d",strtotime($_REQUEST['job_date']));
    
		   	$today_dt=date("Y-m-d");

		   	$yesterday_dt=date("Y-m-d",strtotime("-1 day"));
		   	if($job_date!=$today_dt && $job_date!=$yesterday_dt)
		   	{
		   		$report_yr=date("Y",strtotime($job_date));
		   		$report_mt=date("m",strtotime($job_date));
		   		$sendtabledetals=SENDCALLDETAILS.$report_yr.$report_mt;
		   	}
		   	 	if($job_date==$yesterday_dt)
			   	{
			   		
			   		$report_yr=date("Y",strtotime($job_date));
			   		$report_mt=date("m",strtotime($job_date));
			   		$sendtable=SENDCALL.$report_yr.$report_mt;
			   	}


			$today_dt=date('Y-m-d');
    	
			$table = $sendtabledetals;

					$extraWhere="";
			 
			 if ($_REQUEST['frmDate'] != "" && $_REQUEST['toDate'] != "") {
			    $frmDate = $_REQUEST["frmDate"];
			    $toDate = $_REQUEST["toDate"];
			    if($extraWhere!="")
			    {

			    $extraWhere.="and (STR_TO_DATE(sent_at,'%Y-%m-%d') BETWEEN '" . $frmDate . "' AND '" . $toDate . "')";
			    }
			    else
			    {
			    	 $extraWhere="(STR_TO_DATE(sent_at,'%Y-%m-%d') BETWEEN '" . $frmDate . "' AND '" . $toDate . "')";
			    }
			}
			else
			{
			    $extraWhere="";
			}

			$userid=$_SESSION['user_id'];

			if($extraWhere!="")
			{
				$extraWhere.=" and `userid`='$userid'";
			}
			else
			{

				$extraWhere="`userid`='$userid'";
			}
			 



			 if($job_id!='')
			 {
			 		if($extraWhere!="")
					{
						$extraWhere.=" and `message_id`='$message_id' and msg_job_id='$message_job_id'";
					}
					else
					{

						$extraWhere="`message_id`='$message_id' and msg_job_id='$message_job_id'";
					}
			 }


				$fileName = "voice_job_dtl_report_".time().".xls"; 
			 	$fields_query="id,route,mobile_number,file_name,call_duration,msgcredit,master_job_id,status,input";
			 	
			 	$query="select $fields_query from $table where $extraWhere";
				
			 	$result_download=mysqli_query($dbc,$query)or die(mysqli_error($dbc));
			 	$count_rows=mysqli_num_rows($dbc);
			 	 	$columnHeader = '';  
				 $columnHeader = "ID" . "\t" . "Route" . "\t" . "Mobile" . "\t". "File Name" . "\t". "Call Duration". "\t". "Bill" . "\t". "Message ID" . "\t". "Status" . "\t". "Client Response"  . "\t";  
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
	else if($list_type=="download_archive_report")
	{
		global $dbc;


		$userid=$_SESSION['user_id'];
		$download_userid=$_REQUEST['download_userid'];
		$frmDate=$_REQUEST['frmDate'];
		$toDate=$_REQUEST['toDate'];

		$out = array();
		$fileName = date("Ymdhims").rand(11111,99999).'.csv';


	

		/*if(strlen($cond) > 0)
		{*/
			$date = date('Ymdhims');
	   		$fileName = 'upload/Download_'.$date.'.zip';
			
			header("Content-disposition: attachment; filename=".$fileName);
		    header("Content-Type: application/force-download");
		    header("Content-Length: " . filesize($fileName));
			header("Content-Transfer-Encoding: application/zip;\n");
			header('Accept-Ranges: bytes');
			header("Pragma: no-cache");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0, public");
			header("Expires: 0");

			$zip = new ZipArchive;
			$result_zip = $zip->open($fileName, ZipArchive::CREATE); 
			if ($result_zip === TRUE) 
			{
					$sendtabledetals = SENDCALLDETAILS . CURRENTMONTH;
					if ($_REQUEST['frmDate'] != "" && $_REQUEST['toDate'] != "") {
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
					    	$senddtlstable = SENDCALLDETAILS .$frm_year.$frm_month;
					    	$extraWhere = "WHERE  userid = {$download_userid} and schedule_sent=1 and (date(sent_at) BETWEEN '" . $frmDate . "' AND '" . $toDate . "')";

					
					    }



					}
					$total_rows=$_REQUEST['total_rows'];
					$last_page = ceil($total_rows/100000);
						 $start = 0;
						 $file_number = 0;

					for($count=0;$count<$last_page;$count++)
					{
						$date = date('Ymdhims');
						$csfilename ='upload/SEND_JOB_'.$date.'.csv';
					 $query = "SELECT sent_at,userid,msg_job_id,route,msgdata,char_count,msgcredit,mobile_number,status,err_code from $senddtlstable $extraWhere ORDER BY sent_at desc limit $start,100000"; 
					$output = "";
					$sql = mysqli_query($dbc,$query);
					if(mysqli_num_rows($sql) > 0) {
						$total_rows=mysqli_num_rows($sql);

						

						 $query1="";
						//$columns_total = mysqli_num_fields($sql);
						$arr = array('Date','User','Job ID','Message','Chars','Route','Bill Credit','Mobile Number','Status', 'Error Code');
						for ($i = 0; $i < count($arr); $i++) 
						{
							//$heading = mysql_field_name($sql, $i);
							$heading = $arr[$i];
							$output .= '"'.$heading.'",';
						}
						$output .="\n";

						while ($row = mysqli_fetch_array($sql)) 
						{
							 $num = $row['mobile_number'];
							 $userid = $row['userid'];
							 $username=get_username($userid); 
							$sent_date=$row['sent_at'];
							$msg_job_id=$row['msg_job_id'];
							$msgdata=$row['msgdata'];
							$char_count=$row['char_count'];
							
							$msg_credit = $row['msgcredit'];
							$route = $row['route'];
							
							
							$status = $row['status'];
							$err_code = $row['err_code'];
							$data = array($sent_date,$username,$msg_job_id,$msgdata,$char_count,$route,$msg_credit,$num,$status,$err_code);
							for ($i = 0; $i < count($data); $i++) 
							{
								$output .='"'.escape_csv_value($data["$i"]).'",';
							}
							$output .="\n";
						}
						$fh = fopen($csfilename, 'w') or die("Can't open file");
						 $stringData = $output;
						fwrite($fh, $stringData);
						fclose($fh);
						$zip->addFile($csfilename);
						$start=$start+100000;
						
					}
				}
				$zip->close();
						readfile($fileName);  
						exit;
					/*else {
					$filename =  'report_'.$date.'.csv';
					header('Content-type: application/csv');
					header('Content-Disposition: attachment; filename='.$filename);   
					echo $output;
					exit;   
				}*/
			}
		//}

	}
	else if($list_type=='send_job_summary_report')
    {
    	$sendtable = SENDCALL . CURRENTMONTH;
    		
		$table = $sendtable;

		$extraWhere="";
		 
		if ($_REQUEST['frmDate'] != "" && $_REQUEST['toDate'] != "") {
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
		    		$sendtable = SENDCALL .$frm_year.$frm_month;
		    		$senddtlstable = SENDCALLDETAILS .$frm_year.$frm_month;
		    		$table = $sendtable;
		    }

		    $extraWhere.="(STR_TO_DATE(sent_at,'%Y-%m-%d') BETWEEN '" . $frmDate . "' AND '" . $toDate . "')";


		} else {
		    $extraWhere="";
		}


		$userid=$_SESSION['user_id'];

		if($extraWhere!="") {
			$extraWhere.=" and `userid`='$userid' and schedule_sent='1'";
		} else {

			$extraWhere="`userid`='$userid' and schedule_sent='1'";
		}
		 

				$fileName = "voice_job_summary_report_".time().".xls"; 
			 	$fields_query="job_id,sent_at,userid,route,caller_id,campaign_name,file_name,msgcredit ";
			 	
			 	$query="select $fields_query from $table where $extraWhere order by id desc";
				
			 	$result_download=mysqli_query($dbc,$query);
			 	$count_rows=mysqli_num_rows($result_download);
			 	$columnHeader = '';  
				$columnHeader = "Job Id" . "\t" . "Date" . "\t". "User" . "\t". "Route" . "\t". "Caller ID" . "\t". "Campaign Name". "\t". "File Name" . "\t". "Bill Credit" . "\t";  
				$setData = '';  

			 	while ($rec = mysqli_fetch_row($result_download)) {  
				    $rowData = '';  
				    for($i=0;$i<count($rec);$i++) {
				    	if($i==1)
				    	{	
				    		 $created_dt=date('Y-m-d h:i', strtotime($rec[$i]));
				    		$value=$created_dt;
				    	}
				    	else if($i==2)
				    	{
				    		$username=get_username($rec[$i]); 

				    		$value=$username; 
				    		
				    	}
				    	else
				    	{
				    		$value=$rec[$i];  
				    	}
				    	
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
    else if($list_type=='ip_logs_report')
    {

    		
		$table = IPLOGS;

		$extraWhere="";
		 
		if ($_REQUEST['frmDate'] != "" && $_REQUEST['toDate'] != "") {
		    $frmDate = $_REQUEST["frmDate"];
		    $toDate = $_REQUEST["toDate"];

		   
		    $extraWhere.="(STR_TO_DATE(created_dt,'%Y-%m-%d') BETWEEN '" . $frmDate . "' AND '" . $toDate . "')";


		} else {
		    $extraWhere="";
		}


		$username=$_SESSION['user_name'];

		if($extraWhere!="") {
			$extraWhere.=" and `username`='$username'";
		} else {

			$extraWhere="`username`='$username' ";
		}
		 

				$fileName = "ip_logs_report_".time().".xls"; 
			 	$fields_query="created_dt,ip_address,status ";
			 	
			 	$query="select $fields_query from $table where $extraWhere order by id desc";
				
			 	$result_download=mysqli_query($dbc,$query);
			 	$count_rows=mysqli_num_rows($result_download);
			 	$columnHeader = '';  
				$columnHeader = "Date" . "\t" . "IP Address" . "\t". "Status";  
				$setData = '';  

			 	while ($rec = mysqli_fetch_row($result_download)) {  
				    $rowData = '';  
				    for($i=0;$i<count($rec);$i++) {
				    
				    		$value=$rec[$i];  
				    	
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
    else if($list_type=='archive_report')
    {
    		session_start();
				
    			$sendtable = SENDCALL . CURRENTMONTH;
    		/*$sendtabledetals = SENDCALLDETAILS . CURRENTMONTH;*/
					$table = $sendtable;

					$extraWhere="";
					 
					if ($_REQUEST['frmDate'] != "" && $_REQUEST['toDate'] != "") {
					    $frmDate = $_REQUEST["frmDate"];
					    $toDate = $_REQUEST["toDate"];


					} else {

						 $frmDate = date('Y-m-d');
					    $toDate = date('Y-m-d');

					   // $extraWhere="";
					}

		    $from_dt_split=explode("-",$frmDate);
		    $frm_year=$from_dt_split[0];
		    $frm_month=$from_dt_split[1];

		    $to_dt_split=explode("-",$toDate);
		     $to_year=$to_dt_split[0];
		    $to_month=$to_dt_split[1];

		    if($frm_month==$to_month && $frm_year==$to_year)
		    {
		    		$sendtable = SENDCALL .$frm_year.$frm_month;
		    		$senddtlstable = SENDCALLDETAILS .$frm_year.$frm_month;
		    		$table = $sendtable;
		    }

		    $extraWhere.="(date(sent_at) BETWEEN '" . $frmDate . "' AND '" . $toDate . "')";


		$userid=$_SESSION['user_id'];
		$user_role=$_REQUEST['user_role'];
		$login_user_role=$_SESSION['user_role'];

				if($user_role=='mds_rs' || $user_role=='mds_ad')
				{

					$selected_role=$_REQUEST['selected_role'];

				if($selected_role=="User")
				{
					$userid=$_REQUEST['uid'];

					if($userid=="All")
					{
						$parent_id=$_SESSION['user_id'];
						$user_ids=fetch_userid($parent_id);
						$check_user_ids=implode(",",$user_ids);

						if($extraWhere!="")
						{
							$extraWhere.=" and `userid` in ($check_user_ids) and schedule_sent='1'";
						}
						else
						{

							$extraWhere="`userid` in ($check_user_ids) and schedule_sent='1'";
						}
					}
					else
					{

						if($extraWhere!="")
						{
							$extraWhere.=" and `userid` in ($userid) and schedule_sent='1'";
						}
						else
						{

							$extraWhere="`userid` in ($userid) and schedule_sent='1'";
						}
					}

				}
				else if($selected_role=="Reseller")
			{
				$userid=$_REQUEST['uid'];

					if($userid=="All")
					{
						$session_userid=$_SESSION['user_id'];
						$parent_resellers=fetch_resellers($session_userid);
						$check_parent_ids=implode(",",$parent_resellers);
						$user_ids=fetch_userid_by_resellers($check_parent_ids);
						$check_user_ids=implode(",",$user_ids);

						if($extraWhere!="")
						{
							$extraWhere.=" and `userid` in ($check_user_ids) and schedule_sent='1'";
						}
						else
						{
							$extraWhere="`userid` in ($check_user_ids) and schedule_sent='1' ";
						}
					}
					else
					{

						$user_ids=fetch_userid_by_resellers($userid);
					  $check_user_ids=implode(",",$user_ids);
						if($extraWhere!="")
						{
							$extraWhere.=" and `userid` in ($check_user_ids) and schedule_sent='1'";
						}
						else
						{

							$extraWhere="`userid` in ($check_user_ids) and schedule_sent='1' ";
						}
					}

			}
			else
			{
				if($extraWhere!="") {
					$extraWhere.=" and `userid`='$userid' and schedule_sent='1'";
				} else {

					$extraWhere="`userid`='$userid' and schedule_sent='1'";
				}
			}
		 

			}
			else
			{

				if($login_user_role!='mds_adm')
				{
						if($extraWhere!="") {
							$extraWhere.=" and `userid`='$userid' and schedule_sent='1'";
						} else {

							$extraWhere="`userid`='$userid' and schedule_sent='1'";
						}
				}
			
			}
			 
		 	$date = date('Ymdhims');


		 	$fileName = "archive_report_".time().".xls"; 
			 	$fields_query="job_id,sent_at,userid,route,senderid_name,message,msg_credit,numbers_count,form_type";
			 	
			 	$query="select $fields_query from $table where $extraWhere order by sent_at desc";
				
			 	$result_download=mysqli_query($dbc,$query);
			 	$count_rows=mysqli_num_rows($result_download);
			 	$columnHeader = '';  
				$columnHeader = "Job ID" . "\t" . "Sent Date" . "\t". "Username" . "\t". "Route" . "\t". "Sender" . "\t". "Message" . "\t". "Bill Credit" . "\t". "Numbers Count" . "\t";  
				$setData = '';  

			 	while ($rec = mysqli_fetch_row($result_download)) {  
				    $rowData = '';  
				    for($i=0;$i<count($rec);$i++) {
				    	if($i==1)
				    	{	
				    		 $created_dt=date('Y-m-d h:i', strtotime($rec[$i]));
				    		$value=$created_dt;
				    	}
				    	else if($i==2)
				    	{
				    		$username=get_username($rec[$i]); 

				    		$value=$username; 
				    		
				    	}
				    	else if($i==6)
				    	{
				    		$form_type=$rec[8];
					   		if($form_type!='Dynamic')
					   		{
					   			$value=$rec[6]*$rec[7];  
				        		 
					   		}
					   		else
					   		{
					   			$value=$rec[6];  
					   		}

				    		//$value=$username; 
				    		
				    	}
				    	else
				    	{
				    		$value=$rec[$i];  
				    	}
				    	
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

 }
 function escape_csv_value($value) {
    if(empty($value)) return;
    $value = str_replace('"', '""', $value); // First off escape all " and make them ""
    if(strpos(',', $value) or strpos("\n", $value) or strpos('"', $value)) { // Check if I have any commas or new lines
        return '"'.$value.'"'; // If I have new lines or commas escape them
    } else {
        return $value; // If no new lines or commas just return the value
    }
}


function get_username($uid)
{
	global $dbc;
	$sql="select * from az_user where userid='".$uid."'";

	$result=mysqli_query($dbc,$sql);
	while ($row=mysqli_fetch_array($result)) {
		$uname=$row['client_name'];
	}

	return $uname;
}

 function load_send_job_data()
{
	global $dbc;
	$sendtable = SENDCALL . CURRENTMONTH;
    		
	
   	$job_id=$_REQUEST['job_id'];
   	$table_name=$_REQUEST['table_name'];
   	$job_date=date("Y-m-d",strtotime($_REQUEST['job_date']));
    
   	$today_dt=date("Y-m-d");

   	$yesterday_dt=date("Y-m-d",strtotime("-1 day"));
   	if($job_date!=$today_dt && $job_date!=$yesterday_dt)
   	{
   		$report_yr=date("Y",strtotime($job_date));
   		$report_mt=date("m",strtotime($job_date));
   		$sendtable=SENDCALL.$report_yr.$report_mt;
   	}

   	if($job_date==$yesterday_dt)
   	{

   		$report_yr=date("Y",strtotime($job_date));
   		$report_mt=date("m",strtotime($job_date));
   		$sendtable=SENDCALL.$report_yr.$report_mt;
   	}

	$sql="select * from $sendtable where job_id='".$job_id."'";
	$values=mysqli_query($dbc,$sql);
	$count_record=mysqli_num_rows($values);
	if($count_record>0)
	{
		while($row=mysqli_fetch_array($values))
		{
			$id = $row['id'];
	          $result[0] = $row;
		}
		return $result;
	}
	else
	{
		echo 0;
	}
	

}