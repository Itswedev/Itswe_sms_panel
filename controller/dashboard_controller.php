<?php
session_start();
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
$log_file = "../error/logfiles/dashboard_controller.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);
/*error_reporting(0);*/
include('../include/connection.php');
include('../include/config.php');
// include('../include/include_redis.php');

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$u_id=$_SESSION['user_id'];


if (isset($_REQUEST['list_type'])) {
	$list_type = $_REQUEST['list_type'];
	$page_name=$_REQUEST['page_name'];
	$select_user_id=$_REQUEST['uid'];
/*	if ($list_type == 'top_users') {
		$result = top_user();
		echo $result;
	}*/
	
	if($list_type == 'user_chart' )
	{
		$report_dt=date("Y-m-d");
			
		$sendtabledetals= SENDSMSDETAILS;
		$result1=user_chart();		
		$result2['chart_data']=$result1;
		
		$result=[$result1,$result2];
	
		echo json_encode($result);
	}
	else if($list_type == 'top_five_users' )
	{
		$rs=top_five_users();
		echo $rs;
		
	}
	else if($list_type == 'load_analysis' )
	{
		$rs=load_analysis();
		echo $rs;
		
	}
	else if($list_type == 'load_sender_performance' )
	{
		$rs=load_sender_performance();
		echo $rs;
		
	}
	else if($list_type == 'load_yearly_traffic' )
	{
		$rs=load_yearly_traffic();
		echo $rs;
		
	}
	else if($list_type == 'load_weekly_trend' )
	{
		$rs=load_weekly_trend();
		echo $rs;
		
	}
	else if($list_type == 'load_campaign_status' )
	{
		$rs=load_campaign_status();
		echo $rs;
		
	}
	else if($list_type == 'load_template_summary' )
	{
		$rs=load_template_summary();
		echo $rs;
		
	}
	else if($list_type == 'load_userwise_queue')
	{
		$userwise_queue_data=load_userwise_queue();
		 echo json_encode($userwise_queue_data);
	}
	else if($list_type == 'load_schedule_count')
	{
		$load_schedule_count=load_schedule_count();
		 echo json_encode($load_schedule_count);
	}
	else if($list_type == 'load_live_gateway' )
	{
		$rs=load_live_gateway();
			//print_r($rs);
		$status=$rs['status'];
		$data['sms_total_sent']=$rs['sms']['sent']['total'];
		$data['sms_total_queued']=$rs['sms']['sent']['queued'];
		$data['sms_total_inbound']=$rs['sms']['outbound'];
		$data['sms_store_size']=$rs['sms']['storesize'];

		$data['dlr_total_sent']=$rs['dlr']['received']['total'];
		$data['dlr_total_queued']=$rs['dlr']['queued'];
		$data['dlr_total_inbound']=$rs['dlr']['inbound'];
		
		$data['boxes_dtls']=implode(",",$rs['boxes']['box']);

		$count_gateway=$rs['smscs']['count'];
		for($i=0;$i<$count_gateway;$i++)
		{

			$gateway_id=$rs['smscs']['smsc'][$i]['id'];
			$gateway_name_arr[]=$rs['smscs']['smsc'][$i]['id'];

			$gateway_name=$rs['smscs']['smsc'][$i]['id'];
			$gateway_stat=explode(" ",$rs['smscs']['smsc'][$i]['status']);
			$gateway_status_arr[$gateway_name]=ucfirst($gateway_stat[0]);
				/*echo "-";
			echo $gateway_stat[0];*/
			$queues[$gateway_name][$i]=$rs['smscs']['smsc'][$i]['queued'];
			$port_name_arr=explode(":",$rs['smscs']['smsc'][$i]['name']);
			$ports_arr=explode("/",$port_name_arr[2]);
			$tx=$ports_arr[0];
			$rx=$ports_arr[1];
			/*echo "<br>";*/
			if($tx!=0 && $rx==0)
			{
				$txrx_port[$gateway_id][$i]=$tx;
				$tx_count['tx'][$gateway_id][$i]=1;
				//$txrx_port[$gateway_id][$tx]['tx']=$txrx_port[$gateway_id][$tx]+1;
			}
			else if($tx==0 && $rx!=0)
			{
				$txrx_port[$gateway_id][$i]=$rx;
				$rx_count['rx'][$gateway_id][$i]=1;
				//$txrx_port[$gateway_id][$rx]['rx']=$txrx_port[$gateway_id][$rx]['rx']+1;
			}
			else
			{
				$txrx_port[$gateway_id][$i]=$tx."/".$rx;
				$trx_count['trx'][$gateway_id][$i]=1;
			//	$txrx_port[$gateway_id][$tx."/".$rx]=$txrx_port[$gateway_id][$tx."/".$rx]+1;
			}
		}


		//print_r($tx_count);
		
		$gateway_name_arr=array_values(array_unique($gateway_name_arr));

		for($i=0;$i<count($gateway_name_arr);$i++)
		{
			$total_tx_count[$gateway_name_arr[$i]]=array_sum($tx_count['tx'][$gateway_name_arr[$i]]);
			$total_rx_count[$gateway_name_arr[$i]]=array_sum($rx_count['rx'][$gateway_name_arr[$i]]);
			$total_trx_count[$gateway_name_arr[$i]]=array_sum($trx_count['trx'][$gateway_name_arr[$i]]);
			$queues[$gateway_name_arr[$i]]=array_sum($queues[$gateway_name_arr[$i]]);
			//$ports_counts['tx'][$gateway_name_arr]=array_count_values($txrx_port['tx'][$gateway_name_arr[$i]]);
			$txrx_port['tx'][$gateway_name_arr[$i]]=array_values(array_unique($txrx_port['tx'][$gateway_name_arr[$i]]));

		}

		/*print_r($total_tx_count);
		print_r($total_rx_count);
		print_r($total_trx_count);*/
		$port_name_arr=$txrx_port;
		$data['gateway_names']=$gateway_name_arr;
		$data['ports']=$port_name_arr;
		$data['queued']=$queues;
		$data['gateway_status']=$gateway_status_arr;
		
		$data['status']=ucfirst($status);

		$data['tx_count']=$total_tx_count;
		$data['rx_count']=$total_rx_count;
		$data['trx_count']=$total_trx_count;
		echo json_encode($data);
	}
	else if($list_type == 'load_live_gateway2' )
	{
		$rs=load_live_gateway2();
			//print_r($rs);
		$status=$rs['status'];
		$data['sms_total_sent']=$rs['sms']['sent']['total'];
		$data['sms_total_queued']=$rs['sms']['sent']['queued'];
		$data['sms_total_inbound']=$rs['sms']['outbound'];
		$data['sms_store_size']=$rs['sms']['storesize'];

		$data['dlr_total_sent']=$rs['dlr']['received']['total'];
		$data['dlr_total_queued']=$rs['dlr']['queued'];
		$data['dlr_total_inbound']=$rs['dlr']['inbound'];
		
		$data['boxes_dtls']=implode(",",$rs['boxes']['box']);

		$count_gateway=$rs['smscs']['count'];
		for($i=0;$i<$count_gateway;$i++)
		{

			$gateway_id=$rs['smscs']['smsc'][$i]['id'];
			$gateway_name_arr[]=$rs['smscs']['smsc'][$i]['id'];

			$gateway_name=$rs['smscs']['smsc'][$i]['id'];
			$gateway_stat=explode(" ",$rs['smscs']['smsc'][$i]['status']);
			$gateway_status_arr[$gateway_name]=ucfirst($gateway_stat[0]);
				/*echo "-";
			echo $gateway_stat[0];*/
			$queues[$gateway_name][$i]=$rs['smscs']['smsc'][$i]['queued'];
			$port_name_arr=explode(":",$rs['smscs']['smsc'][$i]['name']);
			$ports_arr=explode("/",$port_name_arr[2]);
			$tx=$ports_arr[0];
			$rx=$ports_arr[1];
			/*echo "<br>";*/
			if($tx!=0 && $rx==0)
			{
				$txrx_port[$gateway_id][$i]=$tx;
				$tx_count['tx'][$gateway_id][$i]=1;
				//$txrx_port[$gateway_id][$tx]['tx']=$txrx_port[$gateway_id][$tx]+1;
			}
			else if($tx==0 && $rx!=0)
			{
				$txrx_port[$gateway_id][$i]=$rx;
				$rx_count['rx'][$gateway_id][$i]=1;
				//$txrx_port[$gateway_id][$rx]['rx']=$txrx_port[$gateway_id][$rx]['rx']+1;
			}
			else
			{
				$txrx_port[$gateway_id][$i]=$tx."/".$rx;
				$trx_count['trx'][$gateway_id][$i]=1;
			//	$txrx_port[$gateway_id][$tx."/".$rx]=$txrx_port[$gateway_id][$tx."/".$rx]+1;
			}
		}


		//print_r($tx_count);
		
		$gateway_name_arr=array_values(array_unique($gateway_name_arr));

		for($i=0;$i<count($gateway_name_arr);$i++)
		{
			$total_tx_count[$gateway_name_arr[$i]]=array_sum($tx_count['tx'][$gateway_name_arr[$i]]);
			$total_rx_count[$gateway_name_arr[$i]]=array_sum($rx_count['rx'][$gateway_name_arr[$i]]);
			$total_trx_count[$gateway_name_arr[$i]]=array_sum($trx_count['trx'][$gateway_name_arr[$i]]);
			$queues[$gateway_name_arr[$i]]=array_sum($queues[$gateway_name_arr[$i]]);
			//$ports_counts['tx'][$gateway_name_arr]=array_count_values($txrx_port['tx'][$gateway_name_arr[$i]]);
			$txrx_port['tx'][$gateway_name_arr[$i]]=array_values(array_unique($txrx_port['tx'][$gateway_name_arr[$i]]));

		}

		/*print_r($total_tx_count);
		print_r($total_rx_count);
		print_r($total_trx_count);*/
		$port_name_arr=$txrx_port;
		$data['gateway_names']=$gateway_name_arr;
		$data['ports']=$port_name_arr;
		$data['queued']=$queues;
		$data['gateway_status']=$gateway_status_arr;
		
		$data['status']=ucfirst($status);

		$data['tx_count']=$total_tx_count;
		$data['rx_count']=$total_rx_count;
		$data['trx_count']=$total_trx_count;
		echo json_encode($data);
	}
	else if($list_type == 'load_schedule' )
	{
		$rs=load_dashboard_schedule();
		echo $rs;
	}
	else if($list_type == 'load_cut_off_chart' )
	{
		 $rs=load_cut_off_chart();
		echo json_encode($rs);
	}
	else if($list_type == 'load_login_users' )
	{
		 $rs=load_login_users();
		echo json_encode($rs);
	}
		else if($list_type == 'load_all_login_users' )
	{
		 $rs=load_all_login_users();
		echo json_encode($rs);
	}
	
}

function load_userwise_queue()
{
		global $dbc;

	$today_dt=date("Y-m-d");
	 $sql="select count(1) as total_queue,master.userids,user.user_name from az_sendnumbers as master inner join az_user as user on master.userids=user.userid  where master.is_picked=0 and master.status='Submitted' and date(master.sent_at)='".$today_dt."' group by master.userids order by master.id desc ";

	$result=mysqli_query($dbc,$sql);
	$count=mysqli_num_rows($result);
	
	if($count>0)
	{

		while($row=mysqli_fetch_array($result))
		{
				$total_record[]=$row;
		}
		
		return $total_record;
		/*$i=0;
		while($row=mysqli_fetch_array($result))
		{
				$userids=$row['userids'];
				$queue=$row['total_queue'];
		}*/
	}
	else
	{
		return 0;
	}
}


function load_schedule_count()
{
		global $dbc;

	$today_dt=date("Y-m-d");
	$user_role=$_REQUEST['user_role'];
	$userid=$_SESSION['userid'];

	if($user_role=='mds_adm')
	{
		$sql="select count(1) as total_schedule,schedule_sent from az_sendnumbers where is_schedule=1 group by 2 ";

	}
	else{
		$sql="select count(1) as total_schedule,schedule_sent from az_sendnumbers where is_schedule=1 and userids='".$userid."' group by 2 ";

	}
	
	$result=mysqli_query($dbc,$sql);
	$count=mysqli_num_rows($result);
	
	if($count>0)
	{

		while($row=mysqli_fetch_array($result))
		{
				$total_record[]=$row;
		}
		
		return $total_record;
		/*$i=0;
		while($row=mysqli_fetch_array($result))
		{
				$userids=$row['userids'];
				$queue=$row['total_queue'];
		}*/
	}
	else
	{
		return 0;
	}
}

function load_live_gateway()
{
	libxml_use_internal_errors(true);
	$url = 'http://localhost:13000/status.xml?password=aaa';
// $url = 'http://localhost:13000/status?password=aaa';
 
$curl = curl_init();
 
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, false);
 
 $data = curl_exec($curl);
 
$xml=simplexml_load_string($data) or die("Error: Cannot create object");
$con = json_encode($xml);
  
// Convert into associative array
$newArr = json_decode($con, true);
curl_close($curl);
		if(!empty($newArr))
		{
			return $newArr;
		}
		else
		{
			return 0;
		}

}

function load_live_gateway2()
{
	libxml_use_internal_errors(true);
$url = 'http://localhost:14000/status.xml?password=aaa';
 
$curl = curl_init();
 
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, false);
 
 $data = curl_exec($curl);
 
$xml=simplexml_load_string($data) or die("Error: Cannot create object");
$con = json_encode($xml);
  
// Convert into associative array
$newArr = json_decode($con, true);
curl_close($curl);
		if(!empty($newArr))
		{
			return $newArr;
		}
		else
		{
			return 0;
		}

}


// function user_chart()
// {
// 	global $dbc;
// 	$report_dt=date("Y-m-d");
// 	//$report_dt='2024-04-03';
// 	$sendtabledetals=SENDSMSDETAILS;

// 	$user_role=$_SESSION['user_role'];
// 	$userid=$_SESSION['user_id'];
// 	$check_statistic=$_REQUEST['check_statistic'];



// 	if($user_role=='mds_adm')
// 	{

// 		$user_ids=fetch_allusers();
// 		$check_user_ids=implode(",",$user_ids);

// 		$sql_select="select status,sum(msgcredit) as sum_msgcredit,msgcredit from $sendtabledetals where userids in (".$check_user_ids.") and (date(sent_at)='$report_dt') and (schedule_sent=1) and (msgcredit>0) group by status"; 
// 		$sql_credit="select sum(if(status='Delivered',msgcredit,0)) as delivered,sum(if(status='Submitted',msgcredit,0)) as submitted,sum(if(status not in ('Delivered','Submitted'),msgcredit,0)) as failed,sum(msgcredit) as total_sent from $sendtabledetals where schedule_sent=1 and date(sent_at)='".$report_dt."'  ";
// 	}
// 	else if($user_role=='mds_rs')
// 	{

// 		$userid_arr[]=$userid;
//         $child_users=get_childUsers($userid_arr);

//                       foreach ($child_users as $child_val) {
//                         foreach($child_val as $val)
//                         {
//                           $single_arr[]=$val;
//                         }
//                       }

//                       $only_resellers=get_onlyResellers($single_arr);
//                       if(!empty($only_resellers))
//                       {
//                       	 $check_user_ids=implode(",",$only_resellers);
//                       }
// 		$sql_select="select status,sum(msgcredit) as sum_msgcredit,msgcredit from $sendtabledetals where parent_id in (".$check_user_ids.") and (date(sent_at)='$report_dt') and (schedule_sent=1) and (msgcredit>0) group by status";	
// 	}
// 	else if($user_role=='mds_usr'){
// 		$sql_select="select status,sum(msgcredit) as sum_msgcredit,msgcredit from $sendtabledetals where userids=$userid and (date(sent_at)='$report_dt') and (schedule_sent=1) and (msgcredit>0) group by status"; 
// 		$sql_credit="select sum(if(status='Delivered',msgcredit,0)) as delivered,sum(if(status='Submitted',msgcredit,0)) as submitted,sum(if(status not in ('Delivered','Submitted'),msgcredit,0)) as failed,sum(msgcredit) as total_sent from $sendtabledetals where schedule_sent=1 and date(sent_at)='".$report_dt."' and userids=$userid  ";	
// 	}

// 	$result=mysqli_query($dbc,$sql_select) or die(mysqli_error($dbc));
// 	$result_credit=mysqli_query($dbc,$sql_credit) or die(mysqli_error($dbc));
// 	$count=mysqli_num_rows($result);
// 	$i=1;
// 	if($count>0)
// 	{
		
// 		$res[0]=$count;
// 		$j=1;
// 		while($row=mysqli_fetch_array($result))
// 		{
// 			$res[$j] = $row;
// 	        $j++;
// 		}


// 		while($row2=mysqli_fetch_array($result_credit))
// 		{
// 			$res['submitted']=$row2[1];
// 			$res['delivered']=$row2[0];
// 			$res['failed']=$row2[2];
// 			$res['total_sent']=$row2[3];
// 		}
// 		//$res[$j]=$sql;

// 		return $res;
// 	}
// 	else
// 	{
// 		return "No Record available";
// 	}
	




// }

function user_chart()
{
	global $dbc;
	$today_dt=date("Y-m-d");
	//$report_dt='2024-04-03';
	$sendtabledetals=SENDSMSDETAILS;
	$user_role=$_SESSION['user_role'];
	$userid=$_SESSION['user_id'];
	$check_statistic=$_REQUEST['check_statistic'];

	if($check_statistic=='Weekly')
	{
		$end_dt = date('Y-m-d', strtotime('-1 day'));
		$start_dt = date('Y-m-d', strtotime('-8 days'));
		$sendtabledetals="user_summary";
	}
	else if($check_statistic=='Monthly')
	{
		$start_dt = date('Y-m-01');
		$end_dt = date('Y-m-t');
		$sendtabledetals="user_summary";

	}
	else{
		$start_dt=$today_dt;
		$end_dt=$today_dt;
	}

	if($check_statistic=='Today' || $check_statistic=='')
	{

		if($user_role=='mds_adm')
		{
			$user_ids=fetch_allusers();
			$check_user_ids=implode(",",$user_ids);
			$sql_select="select status,sum(msgcredit) as sum_msgcredit,msgcredit from $sendtabledetals where userids in (".$check_user_ids.") and (date(sent_at) between '".$start_dt."' and '".$end_dt."') and (schedule_sent=1) and (msgcredit>0) group by status"; 
			$sql_credit="select sum(if(status='Delivered',msgcredit,0)) as delivered,sum(if(status='Submitted',msgcredit,0)) as submitted,sum(if(status not in ('Delivered','Submitted'),msgcredit,0)) as failed,sum(msgcredit) as total_sent from $sendtabledetals where schedule_sent=1 and (date(sent_at) between '".$start_dt."' and '".$end_dt."')";
		}
		else if($user_role=='mds_rs')
		{

			$userid_arr[]=$userid;
			$child_users=get_childUsers($userid_arr);

						foreach ($child_users as $child_val) {
							foreach($child_val as $val)
							{
							$single_arr[]=$val;
							}
						}

						$only_resellers=get_onlyResellers($single_arr);
						if(!empty($only_resellers))
						{
							$check_user_ids=implode(",",$only_resellers);
						}
			$sql_select="select status,sum(msgcredit) as sum_msgcredit,msgcredit from $sendtabledetals where parent_id in (".$check_user_ids.") and (date(sent_at) between '".$start_dt."' and '".$end_dt."') and (schedule_sent=1) and (msgcredit>0) group by status";	
		}
		else if($user_role=='mds_usr'){
			$sql_select="select status,sum(msgcredit) as sum_msgcredit,msgcredit from $sendtabledetals where userids=$userid and (date(sent_at) between '".$start_dt."' and '".$end_dt."') and (schedule_sent=1) and (msgcredit>0) group by status"; 
			$sql_credit="select sum(if(status='Delivered',msgcredit,0)) as delivered,sum(if(status='Submitted',msgcredit,0)) as submitted,sum(if(status not in ('Delivered','Submitted'),msgcredit,0)) as failed,sum(msgcredit) as total_sent from $sendtabledetals where schedule_sent=1 and (date(sent_at) between '".$start_dt."' and '".$end_dt."') and userids=$userid  ";	
		}
	}
	else
	{
		$sendtabledetals="user_summary";
		if($user_role=='mds_adm')
		{
			$user_ids=fetch_allusers();
			$check_user_ids=implode(",",$user_ids);
			$sql_select="select status,sum(bill_credit) as sum_msgcredit,bill_credit from $sendtabledetals where userid in (".$check_user_ids.") and (date(created_date) between '".$start_dt."' and '".$end_dt."') and (bill_credit>0) group by status"; 
			$sql_credit="select sum(if(status='Delivered',bill_credit,0)) as delivered,sum(if(status='Submitted',bill_credit,0)) as submitted,sum(if(status not in ('Delivered','Submitted'),bill_credit,0)) as failed,sum(bill_credit) as total_sent from $sendtabledetals where  (date(created_date) between '".$start_dt."' and '".$end_dt."')";
		}
		else if($user_role=='mds_rs')
		{

			$userid_arr[]=$userid;
			$child_users=get_childUsers($userid_arr);

						foreach ($child_users as $child_val) {
							foreach($child_val as $val)
							{
							$single_arr[]=$val;
							}
						}

						$only_resellers=get_onlyResellers($single_arr);
						if(!empty($only_resellers))
						{
							$check_user_ids=implode(",",$only_resellers);
						}
			$sql_select="select status,sum(bill_credit) as sum_msgcredit,bill_credit from $sendtabledetals where parent_id in (".$check_user_ids.") and (date(created_date) between '".$start_dt."' and '".$end_dt."') and (bill_credit>0) group by status";	
		}
		else if($user_role=='mds_usr'){
			$sql_select="select status,sum(bill_credit) as sum_msgcredit,bill_credit from $sendtabledetals where userid=$userid and (date(created_date) between '".$start_dt."' and '".$end_dt."')  and (bill_credit>0) group by status"; 
			$sql_credit="select sum(if(status='Delivered',bill_credit,0)) as delivered,sum(if(status='Submitted',bill_credit,0)) as submitted,sum(if(status not in ('Delivered','Submitted'),bill_credit,0)) as failed,sum(bill_credit) as total_sent from $sendtabledetals where (date(created_date) between '".$start_dt."' and '".$end_dt."') and userid=$userid  ";	
		}

	}




	$result=mysqli_query($dbc,$sql_select) or die(mysqli_error($dbc));
	$result_credit=mysqli_query($dbc,$sql_credit) or die(mysqli_error($dbc));
	$count=mysqli_num_rows($result);
	$i=1;
	if($count>0)
	{
		
		$res[0]=$count;
		$j=1;
		while($row=mysqli_fetch_array($result))
		{
			$res[$j] = $row;
	        $j++;
		}


		while($row2=mysqli_fetch_array($result_credit))
		{
			$res['submitted']=$row2[1];
			$res['delivered']=$row2[0];
			$res['failed']=$row2[2];
			$res['total_sent']=$row2[3];
		}
		//$res[$j]=$sql;

		return $res;
	}
	else
	{
		return "No Record available";
	}
	




}

function user_profile($u_id)
{
	global $dbc;

	//echo "dzsf ".$u_id;
	
	
	$sql="select * from az_user where userid='".$u_id."'";

	$result=mysqli_query($dbc,$sql);
	$count=mysqli_num_rows($result);
	$i=1;
	if($count>0)
	{
		while($row=mysqli_fetch_array($result))
		{
			return $row;
		}
	}
	else
	{
		return "No Record available";
	}

}


function load_dashboard_schedule()
{
	global $dbc;

	//echo "dzsf ".$u_id;
	$sendtable=SENDSMS.CURRENTMONTH;
	
	$sql="select sent_at,job_id,userid,numbers_count,msg_credit from $sendtable where is_scheduled='1' and schedule_sent=0 order by id desc";

	$result=mysqli_query($dbc,$sql);
	$count=mysqli_num_rows($result);
	$i=1;
	if($count>0)
	{
		while($row=mysqli_fetch_array($result))
		{
			$sent_at=$row['sent_at'];
			$job_id=$row['job_id'];
			$userid=$row['userid'];
			$numbers_count=$row['numbers_count'];
			$msg_credit=$row['msg_credit'];
			$total_credit=$numbers_count*$msg_credit;
			/*$msg_credit=$row['msg_credit'];
			$numbers_count=$row['numbers_count'];
			$form_type=$row['form_type'];

			if($form_type!='Dynamic')
			{
				$total_credit=$msg_credit*$numbers_count;
			}
			else
			{
				$total_credit=$msg_credit;
			}*/
			$username=fetch_username($userid);
			$val=$username."|".$job_id."|".$sent_at."|".$total_credit;
			$schedule_record.=$val.",";

		}

		return $schedule_record;
	}
	else
	{
		return 0;
	}

}


function load_login_users()
{
	global $dbc;
	$userid=$_SESSION['user_id'];
	//echo "dzsf ".$u_id;
	
	
	$sql="select `profile_pic`,`user_name`,`user_role`,`login_time` from az_user where parent_id='".$userid."' and login=1 order by login_time desc limit 5";

	$result=mysqli_query($dbc,$sql);
	$count=mysqli_num_rows($result);
	
	if($count>0)
	{
		$i=0;
		while($row=mysqli_fetch_array($result))
		{
			$record[$i]=$row;
			$date1=strtotime($row['login_time']);
			$date2=time();
			$diff = abs($date1 - $date2);

			 $years = floor($diff / (365*60*60*24));
 
 
  $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
 
  $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	$hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));
 

  $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
			/*$hours=$interval->format('%h');
			$minutes = $dateDiff%60;*/
			$record[$i]['hrs']=$hours;
			$record[$i]['minutes']=$minutes;
			$i++;
		}
		return $record;
	}
	else
	{
		return 0;
	}

}



function load_all_login_users()
{
	global $dbc;
	$userid=$_SESSION['user_id'];
	//echo "dzsf ".$u_id;
	
	
	$sql="select `profile_pic`,`user_name`,`user_role`,`login_time` from az_user where parent_id='".$userid."' and login=1 order by login_time desc ";

	$result=mysqli_query($dbc,$sql);
	$count=mysqli_num_rows($result);
	
	if($count>0)
	{
		$i=0;
		while($row=mysqli_fetch_array($result))
		{
			$record[$i]=$row;
			$date1=strtotime($row['login_time']);
			$date2=time();
			$diff = abs($date1 - $date2);

			 $years = floor($diff / (365*60*60*24));
 
 
  $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
 
  $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	$hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));
 

  $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
			/*$hours=$interval->format('%h');
			$minutes = $dateDiff%60;*/
			$record[$i]['hrs']=$hours;
			$record[$i]['minutes']=$minutes;
			$i++;
		}
		return $record;
	}
	else
	{
		return 0;
	}

}


function get_childUsers($userid)
{
  global $dbc;
  $ids = array();
  static $child=array();
  $userids=implode(",", $userid);
   
        $qry = "SELECT userid FROM az_user WHERE parent_id in ($userids) order by userid desc";
        $rs = mysqli_query($dbc, $qry);
        if(mysqli_num_rows($rs)>0) {
          while($row = mysqli_fetch_array($rs))
          {
            //echo $row['userid'];
            if($row['userid']!=1)
            {
            	$ids[] = $row['userid'];
            }
            
           /* if($row['userid'] == 1 ) {
               $child[]=$ids;
              return $child;
            }*/
          }

          if(!empty($ids)) {
            $child[]=$ids;
              return get_childUsers($ids);
              }
          //return $ids;
          
        }
        else {
      return $child;
    }
}


function get_users($parent_id)
{
	global $dbc;
	$ids = array();
	static $child=array();
	 
	$qry = "SELECT userid FROM az_user WHERE parent_id=$parent_id and user_role='mds_usr'";
	$rs = mysqli_query($dbc, $qry);
	if(mysqli_num_rows($rs)>0) {
		while($row = mysqli_fetch_array($rs))
		{
			$ids[] = $row['userid'];
		}
	}

	$user_ids=implode(",",$ids);

	return $user_ids;
}

function get_childUsers_resellers($userid)
{
  global $dbc;
  $ids = array();
  static $child=array();
  $userids=implode(",", $userid);
   
        $qry = "SELECT userid FROM az_user WHERE parent_id in ($userids) and user_role!='mds_usr' order by userid desc";
        $rs = mysqli_query($dbc, $qry);
        if(mysqli_num_rows($rs)>0) {
          while($row = mysqli_fetch_array($rs))
          {
            //echo $row['userid'];
            if($row['userid']!=1)
            {
            	$ids[] = $row['userid'];
            }
            
           /* if($row['userid'] == 1 ) {
               $child[]=$ids;
              return $child;
            }*/
          }

          if(!empty($ids)) {
            $child[]=$ids;
              return get_childUsers_resellers($ids);
              }
          //return $ids;
          
        }
        else {
      return $child;
    }
}


function get_onlyResellers($userid)
{
  global $dbc;
  $ids = array();

  $userids=implode(",", $userid);
   
        $qry = "SELECT userid FROM az_user WHERE userid in ($userids) and user_role='mds_rs' order by userid desc";
        $rs = mysqli_query($dbc, $qry);
        if(mysqli_num_rows($rs)>0) {
          while($row = mysqli_fetch_array($rs))
          {
            	$ids[]=$row['userid'];
          }

        }

        if(!empty($ids))
        {
        	return $ids;
        }
       
}

function user_list($u_id)
{
	global $dbc;
	$userid=$_SESSION['user_id'];
	//echo "dzsf ".$u_id;
	
	if($userid!=1)
	{
		$sql="select `userid`,`user_name` from az_user where parent_id='".$u_id."'";

	}
	else
	{
		$sql="select `userid`,`user_name` from az_user where user_role='mds_usr'";

	}
	
	
	$result=mysqli_query($dbc,$sql);
	$count=mysqli_num_rows($result);
	$i=1;
	if($count>0)
	{
		$record="<option value=''>Select User</option>";
		while($row=mysqli_fetch_array($result))
		{
			$uid=$row['userid'];
			$uname=$row['user_name'];
			$record.="<option value='".$uid."'>$uname</option>";
		}

		return $record;
	}
	else
	{
		return 0;
	}

}

function top_five_users()
{
	global $dbc;
	$userid=$_SESSION['user_id'];

			$sendtable= SENDSMS. CURRENTMONTH;
			$today_dt=date("Y-m-d");
			$startDate = date('Y-m-01');

			// Find the end date of the current month
			$endDate = date('Y-m-t');
			 //$sql_select="select sum(if(form_type='Dynamic',msg_credit,(msg_credit*numbers_count))) as count_msg ,`userid` from $sendtable where schedule_sent=1  group by userid order by count_msg desc limit 10";
		//	$sql_select="select sum(msg_credit) as count_msg ,`userid` from $sendtable where schedule_sent=1  group by userid order by count_msg desc limit 10";
			 $last_date=date('Y-m-d',strtotime('-1 second',strtotime(date('m').'/01/'.date('Y'))));
		  $sql_select="select sum(bill_credit) as count_msg ,`userid` from `user_summary` where date(created_date) between '".$startDate."' and '".$endDate."'  group by userid order by count_msg desc limit 10";
			$rs_select=mysqli_query($dbc,$sql_select) or die(mysqli_error($dbc));
			while($row_select=mysqli_fetch_array($rs_select))
			{
				$count_msg=$row_select['count_msg'];
				$user_id=$row_select['userid'];
				 $sql="select `profile_pic` from az_user where userid='$user_id'";
					$rs=mysqli_fetch_array(mysqli_query($dbc,$sql));

					if($rs['profile_pic']!="" || $rs['profile_pic']!=NULL || $rs['profile_pic']!='' || !empty($rs['profile_pic']))
					{
						$profile_pic=$rs['profile_pic'];
					}
					else
					{
						$profile_pic="profile_default.png";
					}
					
				$username=fetch_username($user_id);
				$top_five_users_list.="$username|$count_msg|$profile_pic,";
			}

			return $top_five_users_list;
		

	
	
	
}


function load_analysis()
{
	global $dbc;
	$userid=$_SESSION['user_id'];
	$user_role=$_SESSION['user_role'];
    $key = "analysis:$user_id";
	$sendtable= SENDSMS. CURRENTMONTH;
	$sendtabledetals=SENDSMSDETAILS;
	$today_dt=date("Y-m-d");
	$startDate = date('Y-m-01');
	$endDate = date('Y-m-t');
	$check_analysis=$_REQUEST['check_analysis'];
	if($check_analysis=='Weekly')
	{
		$end_dt = date('Y-m-d', strtotime('-1 day'));
		$start_dt = date('Y-m-d', strtotime('-8 days'));
		$sendtabledetals="user_summary";
	}
	else if($check_analysis=='Monthly')
	{
		$start_dt = date('Y-m-01');
		$end_dt = date('Y-m-t');
		$sendtabledetals="user_summary";

	}
	else{
		$start_dt=$today_dt;
		$end_dt=$today_dt;
	}
	
	global $redis;

	if($check_analysis=='Today' || $check_analysis=='')
	{
		if($user_role=='mds_adm')
		{
			$sql_select="select sum(if(status='Delivered',msgcredit,0)) as delivered,sum(if(status='Submitted',msgcredit,0)) as submitted,sum(if(status not in ('Delivered','Submitted','Template Mismatch'),msgcredit,0)) as failed,sum(if(status='Template Mismatch',msgcredit,0)) as mismatch,sum(msgcredit) as total_sent from $sendtabledetals where schedule_sent=1 and (date(sent_at) between '".$start_dt."' and '".$end_dt."')";
		}
		else if($user_role=='mds_rs')
		{
			$sql_select="select sum(if(status='Delivered',msgcredit,0)) as delivered,sum(if(status='Submitted',msgcredit,0)) as submitted,sum(if(status not in ('Delivered','Submitted','Template Mismatch'),msgcredit,0)) as failed,sum(if(status='Template Mismatch',msgcredit,0)) as mismatch,sum(msgcredit) as total_sent from $sendtabledetals where schedule_sent=1 and (date(sent_at) between '".$start_dt."' and '".$end_dt."') and parent_id='".$userid."' ";
		}
		else{
			$sql_select="select sum(if(status='Delivered',msgcredit,0)) as delivered,sum(if(status='Submitted',msgcredit,0)) as submitted,sum(if(status not in ('Delivered','Submitted','Template Mismatch'),msgcredit,0)) as failed,sum(if(status='Template Mismatch',msgcredit,0)) as mismatch,sum(msgcredit) as total_sent from $sendtabledetals where schedule_sent=1 and (date(sent_at) between '".$start_dt."' and '".$end_dt."') and userids='".$userid."' ";
		}
	}
	else{

		if($user_role=='mds_adm')
		{
			$sql_select="select sum(if(status='Delivered',bill_credit,0)) as delivered,sum(if(status='Submitted',bill_credit,0)) as submitted,sum(if(status not in ('Delivered','Submitted','Template Mismatch'),bill_credit,0)) as failed,sum(if(status='Template Mismatch',bill_credit,0)) as mismatch,sum(bill_credit) as total_sent from $sendtabledetals where  (date(created_date) between '".$start_dt."' and '".$end_dt."')";
		}
		else if($user_role=='mds_rs')
		{
			$sql_select="select sum(if(status='Delivered',bill_credit,0)) as delivered,sum(if(status='Submitted',bill_credit,0)) as submitted,sum(if(status not in ('Delivered','Submitted','Template Mismatch'),bill_credit,0)) as failed,sum(if(status='Template Mismatch',bill_credit,0)) as mismatch,sum(bill_credit) as total_sent from $sendtabledetals where  (date(created_date) between '".$start_dt."' and '".$end_dt."') and parent_id='".$userid."' ";
		}
		else{
			$sql_select="select sum(if(status='Delivered',bill_credit,0)) as delivered,sum(if(status='Submitted',bill_credit,0)) as submitted,sum(if(status not in ('Delivered','Submitted','Template Mismatch'),bill_credit,0)) as failed,sum(if(status='Template Mismatch',bill_credit,0)) as mismatch,sum(bill_credit) as total_sent from $sendtabledetals where  (date(created_date) between '".$start_dt."' and '".$end_dt."') and userid='".$userid."' ";
		}

	}
	

	//if (!$redis->get($key)) {
	
	
			$rs_select=mysqli_query($dbc,$sql_select) or die(mysqli_error($dbc));
			while($row_select=mysqli_fetch_array($rs_select))
			{
				$delivered=intval($row_select['delivered']);
				$submitted=intval($row_select['submitted']);
				$failed=intval($row_select['failed']);
				$mismatch=intval($row_select['mismatch']);
				$total_sent=intval($row_select['total_sent']);
				//$dt[]=$row_select;
			}
			$status_data['statuswise']=[$submitted,$delivered,$failed,$mismatch];
			$status_data['total_sent']=[$total_sent];

			//$redis->set($key, serialize($status_data));
    		//$redis->expire($key, 300);

			//echo "Mysql";
		
// 	}
// 	else { 
// 		 //$source = 'Redis Server';
// 		$status_data = unserialize($redis->get($key));
	   
//    }   

   return json_encode($status_data);
	
	
	
}




function load_sender_performance()
{
	global $dbc;
	$userid=$_SESSION['user_id'];
	$user_role=$_SESSION['user_role'];
   
	$sendtabledetals=SENDSMSDETAILS;
	$sendtabledetals="az_sendnumbers202406";
	$today_dt=date("Y-m-d");
	
	global $redis;

	if($user_role=='mds_adm')
	{
		$sql_select="
		SELECT     
			 senderid,     
			 SUM(CASE WHEN TIMEDIFF(from_unixtime(delivered_date), sent_at) <= '00:05:00' THEN 1 ELSE 0 END) AS `0-5sec`,
			 SUM(CASE WHEN TIMEDIFF(from_unixtime(delivered_date), sent_at) > '00:05:00' AND TIMEDIFF(from_unixtime(delivered_date), sent_at) <= '00:10:00' THEN 1 ELSE 0 END) AS `06-10sec`,     
			 SUM(CASE WHEN TIMEDIFF(from_unixtime(delivered_date), sent_at) > '00:10:00' AND TIMEDIFF(from_unixtime(delivered_date), sent_at) <= '00:15:00' THEN 1 ELSE 0 END) AS `11-15sec`, 
			 SUM(CASE WHEN TIMEDIFF(from_unixtime(delivered_date), sent_at) > '00:15:00' AND TIMEDIFF(from_unixtime(delivered_date), sent_at) <= '00:20:00' THEN 1 ELSE 0 END) AS `16-20sec`,     
			 SUM(CASE WHEN TIMEDIFF(from_unixtime(delivered_date), sent_at) > '00:20:00' THEN 1 ELSE 0 END) AS `> 20sec`
			 from $sendtabledetals where schedule_sent=1 and date(sent_at)='".$today_dt."' and status='Delivered'  GROUP BY senderid";
	}
	else if($user_role=='mds_rs')
	{
		$sql_select="SELECT     
		senderid,     
		SUM(CASE WHEN TIMEDIFF(from_unixtime(delivered_date), sent_at) <= '00:05:00' THEN 1 ELSE 0 END) AS `0-5sec`,
		SUM(CASE WHEN TIMEDIFF(from_unixtime(delivered_date), sent_at) > '00:05:00' AND TIMEDIFF(from_unixtime(delivered_date), sent_at) <= '00:10:00' THEN 1 ELSE 0 END) AS `06-10sec`,     
		SUM(CASE WHEN TIMEDIFF(from_unixtime(delivered_date), sent_at) > '00:10:00' AND TIMEDIFF(from_unixtime(delivered_date), sent_at) <= '00:15:00' THEN 1 ELSE 0 END) AS `11-15sec`, 
		SUM(CASE WHEN TIMEDIFF(from_unixtime(delivered_date), sent_at) > '00:15:00' AND TIMEDIFF(from_unixtime(delivered_date), sent_at) <= '00:20:00' THEN 1 ELSE 0 END) AS `16-20sec`,     
		SUM(CASE WHEN TIMEDIFF(from_unixtime(delivered_date), sent_at) > '00:20:00' THEN 1 ELSE 0 END) AS `> 20sec` from $sendtabledetals where schedule_sent=1 and date(sent_at)='".$today_dt."' and parent_id='".$userid."' and status='Delivered'  GROUP BY senderid";
	}
	else{
		$sql_select="SELECT     
		senderid,     
		SUM(CASE WHEN TIMEDIFF(from_unixtime(delivered_date), sent_at) <= '00:05:00' THEN 1 ELSE 0 END) AS `0-5sec`,
		SUM(CASE WHEN TIMEDIFF(from_unixtime(delivered_date), sent_at) > '00:05:00' AND TIMEDIFF(from_unixtime(delivered_date), sent_at) <= '00:10:00' THEN 1 ELSE 0 END) AS `06-10sec`,     
		SUM(CASE WHEN TIMEDIFF(from_unixtime(delivered_date), sent_at) > '00:10:00' AND TIMEDIFF(from_unixtime(delivered_date), sent_at) <= '00:15:00' THEN 1 ELSE 0 END) AS `11-15sec`, 
		SUM(CASE WHEN TIMEDIFF(from_unixtime(delivered_date), sent_at) > '00:15:00' AND TIMEDIFF(from_unixtime(delivered_date), sent_at) <= '00:20:00' THEN 1 ELSE 0 END) AS `16-20sec`,     
		SUM(CASE WHEN TIMEDIFF(from_unixtime(delivered_date), sent_at) > '00:20:00' THEN 1 ELSE 0 END) AS `> 20sec` from $sendtabledetals where schedule_sent=1 and date(sent_at)='2024-06-19' and userids='".$userid."' and status='Delivered' GROUP BY senderid ";
	}
	

	$result=mysqli_query($dbc,$sql_select) or die(mysqli_error($dbc));
	$count=mysqli_num_rows($result);
	if($count>0)
	{
		
		$res[0]=$count;
		$j=1;
		while($row=mysqli_fetch_array($result))
		{
			$res[$j] = $row;
	        $j++;
		}
		
	}

   return json_encode($res);
	
	
	
}



function load_yearly_traffic()
{
	global $dbc;
	$userid=$_SESSION['user_id'];
	$user_role=$_SESSION['user_role'];
    $key = "analysis:$user_id";
	$tbl="user_summary";
	// $sendtable= SENDSMS. CURRENTMONTH;
	// $sendtabledetals=SENDSMSDETAILS;
	$today_dt=date("Y-m-d");
	$startDate = date('Y-m-01');
	$endDate = date('Y-m-t');
	global $redis;

	if($user_role=='mds_adm')
	{
		$sql_select="select sum(if(status='Delivered',bill_credit,0)) as delivered,sum(if(status!='Delivered',bill_credit,0)) as failed,sum(bill_credit) as total_sent,DATE_FORMAT(created_date, '%b') as m from $tbl group by 4 order by date(created_date) asc";
	}
	else if($user_role=='mds_rs')
	{
		$sql_select="select sum(if(status='Delivered',bill_credit,0)) as delivered,sum(if(status!='Delivered',bill_credit,0)) as failed,sum(bill_credit) as total_sent,DATE_FORMAT(created_date, '%b') as m from $tbl where parent_id='".$userid."' group by 4 order by date(created_date) asc";
	}
	else{
		$sql_select="select sum(if(status='Delivered',bill_credit,0)) as delivered,sum(if(status!='Delivered',bill_credit,0)) as failed,sum(bill_credit) as total_sent,DATE_FORMAT(created_date, '%b') as m from $tbl where userid='".$userid."' group by 4 order by date(created_date) asc";
	}
	//echo $sql_select;
	
			$rs_select=mysqli_query($dbc,$sql_select) or die(mysqli_error($dbc));
			while($row_select=mysqli_fetch_array($rs_select))
			{
				$month[]=$row_select['m'];
				$delivered[]=intval($row_select['delivered']);
				
				$failed[]=intval($row_select['failed']);
	
				$total_sent[]=intval($row_select['total_sent']);
				//$dt[]=$row_select;
			}
			$status_data['yearly_traffic']=[$month,$total_sent,$delivered,$failed];
			
		    return json_encode($status_data);
	
	
	
}



//Weekly Trend



function load_weekly_trend()
{
	global $dbc;
	$userid=$_SESSION['user_id'];
	$user_role=$_SESSION['user_role'];
   
	$tbl="user_summary";

	global $redis;

	if($user_role=='mds_adm')
	{
		$sql_select="SELECT 
		DATE_FORMAT(date_range.date, '%d %b') AS created_date,
		sum(if(user_summary.status!='',user_summary.bill_credit,0)) AS total_sent
	FROM 
		(SELECT CURDATE() - INTERVAL 1 DAY AS date
		 UNION SELECT CURDATE() - INTERVAL 2 DAY
		 UNION SELECT CURDATE() - INTERVAL 3 DAY
		 UNION SELECT CURDATE() - INTERVAL 4 DAY
		 UNION SELECT CURDATE() - INTERVAL 5 DAY
		 UNION SELECT CURDATE() - INTERVAL 6 DAY
		 UNION SELECT CURDATE() - INTERVAL 7 DAY) AS date_range
	LEFT JOIN 
		user_summary ON DATE(date_range.date) = DATE(user_summary.created_date)
	GROUP BY 
		date_range.date";
	}
	else if($user_role=='mds_rs')
	{
		
		$sql_select="SELECT 
		DATE_FORMAT(date_range.date, '%d %b') AS created_date,
		sum(if(user_summary.status!='',user_summary.bill_credit,0)) AS total_sent
	FROM 
		(SELECT CURDATE() - INTERVAL 1 DAY AS date
		 UNION SELECT CURDATE() - INTERVAL 2 DAY
		 UNION SELECT CURDATE() - INTERVAL 3 DAY
		 UNION SELECT CURDATE() - INTERVAL 4 DAY
		 UNION SELECT CURDATE() - INTERVAL 5 DAY
		 UNION SELECT CURDATE() - INTERVAL 6 DAY
		 UNION SELECT CURDATE() - INTERVAL 7 DAY) AS date_range
	LEFT JOIN 
		user_summary ON DATE(date_range.date) = DATE(user_summary.created_date) AND user_summary.parent_id = $userid
	GROUP BY 
		date_range.date";
	}
	else if($user_role=='mds_usr'){

		$sql_select="SELECT 
		DATE_FORMAT(date_range.date, '%d %b') AS created_date,
		sum(if(user_summary.status!='',user_summary.bill_credit,0)) AS total_sent
	FROM 
		(SELECT CURDATE() - INTERVAL 1 DAY AS date
		 UNION SELECT CURDATE() - INTERVAL 2 DAY
		 UNION SELECT CURDATE() - INTERVAL 3 DAY
		 UNION SELECT CURDATE() - INTERVAL 4 DAY
		 UNION SELECT CURDATE() - INTERVAL 5 DAY
		 UNION SELECT CURDATE() - INTERVAL 6 DAY
		 UNION SELECT CURDATE() - INTERVAL 7 DAY) AS date_range
	LEFT JOIN 
		user_summary ON DATE(date_range.date) = DATE(user_summary.created_date) AND user_summary.userid = $userid
	GROUP BY 
		date_range.date";
	}

	
			$rs_select=mysqli_query($dbc,$sql_select) or die(mysqli_error($dbc));
			while($row_select=mysqli_fetch_array($rs_select))
			{
				$month[]=$row_select['created_date'];
				$total_sent[]=intval($row_select['total_sent']);
				//$dt[]=$row_select;
			}
			$status_data['weekly_trend']=[$month,$total_sent];
			
		    return json_encode($status_data);
	
	
	
}

function load_campaign_status()
{
	global $dbc;
	$userid=$_SESSION['user_id'];
	$user_role=$_SESSION['user_role'];

	
	$sendtabledetals=SENDSMSDETAILS;
	$sendtable=SENDSMS.CURRENTMONTH;;
	$today_dt=date("Y-m-d");
	$startDate = date('Y-m-01');
	$endDate = date('Y-m-t');

	

	if($user_role=='mds_adm')
	{
		$sql_upcoming="select count(1) as upcoming from $sendtable where is_scheduled=1 and schedule_sent=0  ";
		$sql_completed="select count(1) as completed from $sendtable where schedule_sent=1 and date(sent_at)='".$today_dt."'  ";
		//$sql_upcoming="select sum(if(status='Delivered',msgcredit,0)) as delivered,sum(if(status='Submitted',msgcredit,0)) as submitted,sum(if(status not in ('Delivered','Submitted','Template Mismatch'),msgcredit,0)) as failed,sum(if(status='Template Mismatch',msgcredit,0)) as mismatch,sum(msgcredit) as total_sent from $sendtabledetals where schedule_sent=1 and date(sent_at)='".$today_dt."'  ";
	}
	else if($user_role=='mds_rs')
	{
		$user_ids=get_users($userid);

		$sql_upcoming="select count(1) as upcoming from $sendtable where is_scheduled=1 and schedule_sent=0 and userid in ($user_ids)";
		$sql_completed="select count(1) as completed from $sendtable where schedule_sent=1 and date(sent_at)='".$today_dt."' and userid in ($user_ids)  ";
		//$sql_upcoming="select sum(if(status='Delivered',msgcredit,0)) as delivered,sum(if(status='Submitted',msgcredit,0)) as submitted,sum(if(status not in ('Delivered','Submitted','Template Mismatch'),msgcredit,0)) as failed,sum(if(status='Template Mismatch',msgcredit,0)) as mismatch,sum(msgcredit) as total_sent from $sendtabledetals where schedule_sent=1 and date(sent_at)='".$today_dt."'  ";
	}
	else{
		$sql_upcoming="select count(1) as upcoming from $sendtable where is_scheduled=1 and schedule_sent=0  and userid='".$userid."' ";
		$sql_completed="select count(1) as completed from $sendtable where schedule_sent=1 and date(sent_at)='".$today_dt."' and userid='".$userid."' ";
		
	}
	
		//	$sql_select="select sum(msg_credit) as count_msg ,`userid` from $sendtable where schedule_sent=1  group by userid order by count_msg desc limit 10";
   //$last_date=date('Y-m-d',strtotime('-1 second',strtotime(date('m').'/01/'.date('Y'))));
		  //$sql_select="select sum(bill_credit) as count_msg ,`userid` from `user_summary` where date(created_date) between '".$startDate."' and '".$endDate."'  group by userid order by count_msg desc limit 10";
			$rs_select=mysqli_query($dbc,$sql_upcoming) or die(mysqli_error($dbc));
			while($row_select=mysqli_fetch_array($rs_select))
			{
				$upcoming=intval($row_select['upcoming']);
			}

			$rs_select2=mysqli_query($dbc,$sql_completed) or die(mysqli_error($dbc));
			while($row_select1=mysqli_fetch_array($rs_select2))
			{
				$completed=intval($row_select1['completed']);
			}
			$total=$upcoming+$completed;
			$status_data['upcoming']=[$upcoming];
			$status_data['completed']=[$completed];
			$status_data['total']=[$total];
			

			// $status_data['delivered']=$delivered;
			// $status_data['submitted']=$submitted;
			// $status_data['failed']=$failed;
			// $status_data['mismatch']=$mismatch;

			return json_encode($status_data);
		

	
	
	
}

function load_template_summary()
{
	global $dbc;
	$userid=$_SESSION['user_id'];
	$user_role=$_SESSION['user_role'];
	$check_temp_summary=$_REQUEST['check_temp_summary'];

	
	$sendtabledetals=SENDSMSDETAILS;
	$today_dt=date("Y-m-d");
	$startDate = date('Y-m-01');
	$endDate = date('Y-m-t');

	if($check_temp_summary=='Weekly')
	{
		$end_dt = date('Y-m-d', strtotime('-1 day'));
		$start_dt = date('Y-m-d', strtotime('-8 days'));
		$sendtabledetals="user_summary";
	}
	else if($check_temp_summary=='Monthly')
	{
		$start_dt = date('Y-m-01');
		$end_dt = date('Y-m-t');
		$sendtabledetals="user_summary";

	}
	else{
		$start_dt=$today_dt;
		$end_dt=$today_dt;
	}

	if($check_temp_summary=='Today' || $check_temp_summary=='')
	{
		if($user_role=='mds_adm')
		{
			$sql_select="select substring(metadata,36) as temp_id, sum(if(status='Delivered',msgcredit,0)) as delivered,sum(if(status='Submitted',msgcredit,0)) as submitted,sum(msgcredit) as total_sent from $sendtabledetals where schedule_sent=1 and (date(sent_at) between '".$start_dt."' and '".$end_dt."') group by 1  ";
		}
		else if($user_role=='mds_rs')
		{
			$sql_select="select substring(metadata,36) as temp_id, sum(if(status='Delivered',msgcredit,0)) as delivered,sum(if(status='Submitted',msgcredit,0)) as submitted,sum(msgcredit) as total_sent from $sendtabledetals where schedule_sent=1 and (date(sent_at) between '".$start_dt."' and '".$end_dt."') and parent_id='".$userid."' group by 1  ";
		}
		else{
			$sql_select="select substring(metadata,36) as temp_id,sum(if(status='Delivered',msgcredit,0)) as delivered,sum(if(status='Submitted',msgcredit,0)) as submitted,sum(msgcredit) as total_sent from $sendtabledetals where schedule_sent=1 and (date(sent_at) between '".$start_dt."' and '".$end_dt."') and userids='".$userid."' group by 1  ";
		}
	}
	else
	{
		$sendtabledetals="user_summary";
		if($user_role=='mds_adm')
		{
			$sql_select="select tid as temp_id, sum(if(status='Delivered',bill_credit,0)) as delivered,sum(if(status='Submitted',bill_credit,0)) as submitted,sum(bill_credit) as total_sent from $sendtabledetals where  (date(created_date) between '".$start_dt."' and '".$end_dt."') group by 1  ";
		}
		else if($user_role=='mds_rs')
		{
			$sql_select="select tid as temp_id, sum(if(status='Delivered',bill_credit,0)) as delivered,sum(if(status='Submitted',bill_credit,0)) as submitted,sum(bill_credit) as total_sent from $sendtabledetals where  (date(created_date) between '".$start_dt."' and '".$end_dt."') and parent_id='".$userid."' group by 1  ";
		}
		else{
			$sql_select="select tid as temp_id,sum(if(status='Delivered',bill_credit,0)) as delivered,sum(if(status='Submitted',bill_credit,0)) as submitted,sum(bill_credit) as total_sent from $sendtabledetals where  (date(created_date) between '".$start_dt."' and '".$end_dt."') and userid='".$userid."' group by 1  ";
		}
	}
	
		//	$sql_select="select sum(msg_credit) as count_msg ,`userid` from $sendtable where schedule_sent=1  group by userid order by count_msg desc limit 10";
   //$last_date=date('Y-m-d',strtotime('-1 second',strtotime(date('m').'/01/'.date('Y'))));
		  //$sql_select="select sum(bill_credit) as count_msg ,`userid` from `user_summary` where date(created_date) between '".$startDate."' and '".$endDate."'  group by userid order by count_msg desc limit 10";
			$rs_select=mysqli_query($dbc,$sql_select) or die(mysqli_error($dbc));
			$summary_data="";
			while($row_select=mysqli_fetch_array($rs_select))
			{
				$delivered=intval($row_select['delivered']);
				$submitted=intval($row_select['submitted']);
				// $failed=intval($row_select['failed']);
				$temp_id=intval($row_select['temp_id']);
				$total_sent=intval($row_select['total_sent']);
				$summary_data.="<tr>";

				
				$summary_data.="<td><div class='d-flex align-items-center'>
				<div class='flex-shrink-0'><img src='assets/images/dashboard/product/1.png' alt=''></div>
				<div class='flex-grow-1'><a href='#'>
					<h5>$temp_id</h5></a></div>
			  </div></td>";
				$summary_data.="<td>$total_sent</td>";
				$summary_data.="<td>$submitted</td>";
				$summary_data.="<td>$delivered</td>";
				$summary_data.="</tr>";
				
			}
			
			// $status_data['delivered']=$delivered;
			// $status_data['submitted']=$submitted;
			// $status_data['failed']=$failed;
			// $status_data['mismatch']=$mismatch;

			return $summary_data;
		

	
	
	
}


function load_cut_off_chart()
{
	global $dbc;
	$userid=$_SESSION['user_id'];
	$dt=$_REQUEST['dt'];


	//echo "dzsf ".$u_id;

	$sendtable=SENDSMS.CURRENTMONTH;
	$record_dt=date('Y-m-d');
	$start_dt=date('Y-m-01');
	$end_dt=date('Y-m-t');

	$user_role=$_SESSION['user_role'];

	if($dt=='Today')
	{

		$record_dt=date('Y-m-d');
				if($user_role!='mds_adm')
			{
			 $sql_select="select sum(msg_count) as total_submitted,sum(cut_off) as total_cut_off from smart_cutoff where parent_id='$userid' and date(created_date)='$record_dt' group by parent_id";
			}
			else
			{

				$sql_select="select sum(msg_count) as total_submitted,sum(cut_off) as total_cut_off from smart_cutoff where date(created_date)='$record_dt' ";
			}

	}
	else if($dt=='Yesterday')
	{

		$record_dt=date('Y-m-d',strtotime("-1 days"));

				if($user_role!='mds_adm')
				{
				 $sql_select="select sum(msg_count) as total_submitted,sum(cut_off) as total_cut_off from smart_cutoff where parent_id='$userid' and date(created_date)='$record_dt' group by parent_id";
				}
				else
				{

					$sql_select="select sum(msg_count) as total_submitted,sum(cut_off) as total_cut_off from smart_cutoff where date(created_date)='$record_dt' ";
				}
	}
	else if($dt=='This Month')
	{

		
				if($user_role!='mds_adm')
				{
				 $sql_select="select sum(msg_count) as total_submitted,sum(cut_off) as total_cut_off from smart_cutoff where parent_id='$userid' and date(created_date) between '$start_dt' and '$end_dt' group by parent_id";
				}
				else
				{

					$sql_select="select sum(msg_count) as total_submitted,sum(cut_off) as total_cut_off from smart_cutoff where date(created_date) between '$start_dt' and '$end_dt' ";
				}
	}

	$rs_select=mysqli_query($dbc,$sql_select);
	$count_record=mysqli_num_rows($rs_select);
	if($count_record>0)
	{
		unset($_SESSION['cut_per']);
		while($row_select=mysqli_fetch_array($rs_select))
		{
			$total_submitted=$row_select['total_submitted'];
			$total_cut_off=$row_select['total_cut_off'];

		}

		$cut_per=($total_cut_off/$total_submitted)*100;
		$data[0]=$total_submitted;
		$data[1]=$total_cut_off;
		$_SESSION['cut_per']=$cut_per;
		return $data;
	}
	else
	{
		$data[0]=0;
		$data[1]=0;
		$cut_per=($total_cut_off/$total_submitted)*100;
		$_SESSION['cut_per']=$cut_per;
		return $data;
	}
}
function fetch_userids($u_id)
{
	global $dbc;

	if($u_id!=1)
	{
		$sql="select userid from az_user where parent_id='".$u_id."' and user_role='mds_usr'";
	}
	else
	{
		$sql="select userid from az_user where user_role='mds_usr'";
	}
	

	$result=mysqli_query($dbc,$sql);
	$count=mysqli_num_rows($result);
	$i=1;
	if($count>0)
	{
		while($row=mysqli_fetch_array($result))
		{
			$user_ids[]=$row['userid'];

		}
		return $user_ids;
	}
	else
	{
		return 0;
	}

}

function fetch_username($u_id)
{
	global $dbc;

	//echo "dzsf ".$u_id;
	
	
	$sql="select user_name from az_user where userid='".$u_id."'";

	$result=mysqli_query($dbc,$sql);
	$count=mysqli_num_rows($result);
	$i=1;
	if($count>0)
	{
		while($row=mysqli_fetch_array($result))
		{
			$username=$row['user_name'];

		}
		return $username;
	}
	else
	{
		return 0;
	}

}

function fetch_allresellers()
{
	global $dbc;

	$sql="select userid from az_user where user_role='mds_rs'";

	$result=mysqli_query($dbc,$sql);
	$count=mysqli_num_rows($result);
	if($count>0)
	{
		while($row=mysqli_fetch_array($result))
		{
			$rs_ids[]=$row['userid'];

		}

		if(!empty($rs_ids))
		{
			return $rs_ids;
		}
		
	}
}

function fetch_alladmins()
{
	global $dbc;

	$sql="select userid from az_user where user_role='mds_ad'";

	$result=mysqli_query($dbc,$sql);
	$count=mysqli_num_rows($result);
	if($count>0)
	{
		while($row=mysqli_fetch_array($result))
		{
			$rs_ids[]=$row['userid'];

		}

		if(!empty($rs_ids))
		{
			return $rs_ids;
		}
		
	}
}

function fetch_users($userids)
{
	global $dbc;

	$userids_arr=implode(",",$userids);

	$sql="select userid from az_user where userid in ($userids_arr) and user_role='mds_usr'";

	$result=mysqli_query($dbc,$sql);
	$count=mysqli_num_rows($result);
	if($count>0)
	{
		while($row=mysqli_fetch_array($result))
		{
			$rs_ids[]=$row['userid'];

		}

		if(!empty($rs_ids))
		{
			return $rs_ids;
		}
		
	}
}


function fetch_allusers()
{
	global $dbc;

	$sql="select userid from az_user where user_role='mds_usr'";

	$result=mysqli_query($dbc,$sql);
	$count=mysqli_num_rows($result);
	if($count>0)
	{
		while($row=mysqli_fetch_array($result))
		{
			$rs_ids[]=$row['userid'];

		}

		if(!empty($rs_ids))
		{
			return $rs_ids;
		}
		
	}
}
function fetch_userids_by_resellers($parent_resellers)
{
	global $dbc;

	//echo "dzsf ".$u_id;
	
	
	$sql="select userid from az_user where parent_id in (".$parent_resellers.")";

	$result=mysqli_query($dbc,$sql);
	$count=mysqli_num_rows($result);
	$i=1;
	if($count>0)
	{
		while($row=mysqli_fetch_array($result))
		{
			$user_ids[]=$row['userid'];

		}
		return $user_ids;
	}
	else
	{
		return 0;
	}

}

function fetch_resellers($u_id)
{
	global $dbc;

	//echo "dzsf ".$u_id;
	
	if($u_id!=1)
	{
		$sql="select userid from az_user where parent_id='".$u_id."' and user_role='mds_rs'";
	}
	else
	{
		$sql="select userid from az_user where  user_role='mds_rs'";
	}
	

	$result=mysqli_query($dbc,$sql);
	$count=mysqli_num_rows($result);
	$i=1;
	if($count>0)
	{
		while($row=mysqli_fetch_array($result))
		{
			$user_ids[]=$row['userid'];

		}
		return $user_ids;
	}
	else
	{
		return 0;
	}

}
function fetch_route_name($route_ids_arr)
{
	global $dbc;
	$route_name="";
	foreach($route_ids_arr as $route_id)
	{
		$sql="select * from az_routetype where az_routeid='".$route_id."'";

		$result=mysqli_query($dbc,$sql);
		$count=mysqli_num_rows($result);
		if($count>0)
		{
			$row=mysqli_fetch_array($result);
			$route_name.=$row['az_rname'].", ";
		}
	}

	return $route_name;
}
function fetch_acct_manager($acct_manager)
{
	global $dbc;
	$acct_manager_name="";
	
		$sql="select * from account_manager where userid='".$acct_manager."'";

		$result=mysqli_query($dbc,$sql);
		$count=mysqli_num_rows($result);
		if($count>0)
		{
			$row=mysqli_fetch_array($result);
			$acct_manager_name=$row['user_name'];
		}
	

	return $acct_manager_name;
}
function fetch_group_name($u_id)
{
	global $dbc;
	$group_name="";

		$sql="select * from az_group where userid='".$u_id."'";

		$result=mysqli_query($dbc,$sql);
		$count=mysqli_num_rows($result);
		if($count>0)
		{
			while($row=mysqli_fetch_array($result))
			{
				$group_name.=$row['g_name'].", ";
			}
			
		}
		else
		{
			$group_name="No Group Available";
		}
	

	return $group_name;
}
function fetch_last_activities($u_id)
{
	global $dbc;


		$sql="select * from user_activities where userid='".$u_id."' order by id desc limit 5";

		$result=mysqli_query($dbc,$sql);
		$count=mysqli_num_rows($result);
		if($count>0)
		{
			while($row=mysqli_fetch_array($result))
			{
				//$res.="<li><p>".$row['activity']."</p></li>";
				$res.=$row['activity'].",";
			}
			
		}
		else
		{
			$res="No Activities Done";
		}
	

	return $res;
}

?>
