<?php 
	session_start();
	error_reporting(0);
	include('../include/connection.php');
	require('classes/ssp.class.php');
	include('../include/config.php');
	$u_id=$_SESSION['user_id'];

	// if(isset($_REQUEST['list_type']))
	// {
	// 	$list_type=$_REQUEST['list_type'];
	   
	//    // if($list_type == 'today_report') 
	//    if($list_type == 'send_job_report') 
	//    {
	//     	$report_type=$_REQUEST['report_type'];
	// 		$table = 'az_sendnumbers202202';
	// 		$primaryKey = 'id';
	// 		$columns = array(
	// 			array( 'db' => 'id','dt' => 0 ),
	// 		   array( 'db' => 'route','dt' => 1 ),
	// 		   array( 'db' => 'mobile_number','dt' => 2 ),
	// 		   array( 'db' => 'id','dt' => 3 ),
	// 		   array( 'db' => 'id','dt' => 4 ),
	// 		   array( 'db' => 'msgcredit','dt' => 5),
	// 		   array( 'db' => 'message_id','dt' => 6),
	// 		   array( 'db' => 'id','dt' => 7 ),
	// 		   array( 'db' => 'status','dt' => 8 ),
	// 		  	array( 'db' => 'created_at', 'dt' => 9, 'formatter' => function($d, $row) {
	// 		  		return date('Y-m-d', strtotime($d));
	// 		  	}),
	// 		  	array( 'db' => 'err_code','dt' => 10),
	// 		  	array( 'db' => 'id','dt' => 11 )
	// 		);

	// 		// SQL server connection information
	// 		$sql_details = array(
	// 			'user' => 'kannel',
	// 			'pass' => 'NcbagqPkhdt#^98ajtd',
	// 			'db'   => 'itswe_client',
	// 			'host' => 'localhost'
	// 		);

	// 		$extraWhere="";
				 
	// 		if ($_REQUEST['frmDate'] != "" && $_REQUEST['toDate'] != "") {
	// 		    $frmDate = $_REQUEST["frmDate"];
	// 		    $toDate = $_REQUEST["toDate"];
	// 		    $extraWhere.="(STR_TO_DATE(created_at,'%Y-%m-%d') BETWEEN '" . $frmDate . "' AND '" . $toDate . "')";
	// 		} else {
	// 		    $extraWhere="";
	// 		}

	// 		if($report_type=="delivered") {
	// 			if($extraWhere!="") {
	// 				$extraWhere.="and status='delivered'";
	// 			} else {
	// 				$extraWhere.="status='delivered'";
	// 			}
	// 		} else if($report_type=="rejected") {
	// 			if($extraWhere!="") {
	// 				$extraWhere.="and status='rejected'";
	// 			} else {
	// 				$extraWhere.="status='rejected'";
	// 			}
	// 		} else if($report_type=="null") {
	// 			if($extraWhere!="") {
	// 				$extraWhere.="and status='NULL'";
	// 			} else {
	// 				$extraWhere.="status='NULL'";
	// 			}
	// 		} else if($report_type=="failed") {
	// 			if($extraWhere!="") {
	// 				$extraWhere.="and status='failed'";
	// 			} else {
	// 				$extraWhere.="status='failed'";
	// 			}
	// 		} else {
	// 			$extraWhere="";
	// 		}

	// 		$userid=$_SESSION['user_id'];

	// 		if($extraWhere!="") {
	// 			$extraWhere.=" and `userids`='$userid'";
	// 		} else {
	// 			$extraWhere.="`userids`='$userid'";
	// 		} 
	// 		echo json_encode(
	// 			SSP::complex( $_REQUEST, $sql_details, $table, $primaryKey, $columns, $test=null, $extraWhere)
	// 		);
	//  	}
	//  	// else if($list_type == 'archive_report') {
	//  	else if($list_type == 'send_job_report') {
	// 		$table = 'az_sendnumbers202202';
	// 		$primaryKey = 'id';
	// 		$columns = array(
	// 			array('db' => 'id','dt' => 0 ),
	// 		   array('db' => 'created_at', 'dt' => 1, 'formatter' => function( $d, $row ) {
	// 		   	return date( 'Y-m-d', strtotime($d));
	// 		   }),
	// 		   array( 'db' => 'route','dt' => 2 ),
	// 		   array( 'db' => 'senderid','dt' => 3 ),
	// 		   array( 'db' => 'msgdata','dt' => 4 ),
	// 		   array( 'db' => 'msgcredit','dt' => 5),
	// 		   array( 'db' => 'status','dt' => 6)
	// 		);
				 
	// 		// SQL server connection information
	// 		$sql_details = array(
	// 		    'user' => 'kannel',
	// 		    'pass' => 'NcbagqPkhdt#^98ajtd',
	// 		    'db'   => 'itswe_client',
	// 		    'host' => 'localhost'
	// 		);

	// 		$extraWhere="";				 

	// 		if ($_REQUEST['frmDate'] != "" && $_REQUEST['toDate'] != "") {
	// 			$frmDate = $_REQUEST["frmDate"];
	// 			$toDate = $_REQUEST["toDate"];
	// 			$extraWhere.="(STR_TO_DATE(created_at,'%Y-%m-%d') BETWEEN '" . $frmDate . "' AND '" . $toDate . "')";
	// 		} else { 
	// 			$extraWhere="";
	// 		} 

	// 		$userid=$_SESSION['user_id'];
				
	// 		if($extraWhere!="") {
	// 			$extraWhere.=" and `userids`='$userid'";
	// 		} else {
	// 			$extraWhere.="`userids`='$userid'";
	// 		} 

	// 		echo json_encode(
	// 			SSP::complex( $_REQUEST, $sql_details, $table, $primaryKey, $columns,$test=null,$extraWhere )
	// 		);
	//  	}

	// }

	if(isset($_REQUEST['list_type'])) {
    	$list_type=$_REQUEST['list_type'];
	   if($list_type=='send_job_report') {
	    	$result = view_send_job_summary();
	    	$return_send_job_summary = send_job_summary($result);
	    	echo $return_send_job_summary;
	   }
	}

// 	// if(isset($_REQUEST['list_type'])) {
//  	//	$list_type=$_REQUEST['list_type'];
// 	//     if($list_type=='report_dashboard') {
// 	//     	$result = viewReportDashboard();
// 	//     	$return_today_report_dashboard = today_report_dashboard($result);
// 	//     	echo $return_today_report_dashboard;
// 	//     }
// 	// }

// 	// if(isset($_REQUEST['list_type'])) {
//  	//	$list_type=$_REQUEST['list_type'];
// 	//     if($list_type=='report_summary') {
// 	//     	$result = viewReportSummary();
// 	//     	$return_report_summary = report_summary($result);
// 	//     	echo $return_report_summary;
// 	//     }
// 	// }

// 	// if(isset($_REQUEST['list_type'])) {
//  	//	$list_type=$_REQUEST['list_type'];
// 	//    if($list_type=='toDate') {
// 	//    	if ($_POST['submit']) {
// 	//    		$toDate = $_POST['date_timepicker_start'];
// 	//    		echo $toDate;
// 	//    	}
// 	//    }
// 	// }


// /* Summary Report Function - az_sendnumbers202202
//    ========================================================================== */
	function view_send_job_summary(){
		global $dbc;
		$result5 = array();
		$sql = "SELECT id, campaign_name, senderid_name, message, sms_type, updated_at FROM az_sendmessages202202 ORDER BY created_at DESC";
		$values = mysqli_query($dbc, $sql);
		while ($row = mysqli_fetch_assoc($values)) {
			$r_id = $row['id'];
			$result5[$r_id] = $row;
		}
		return $result5;
	}

	function send_job_summary($result5){
		$i = 1;
		if (!empty($result5)) {
			foreach ($result5 as $key => $value) {
				$id = $value['id'];
				$campaign_name = $value['campaign_name'];
				$senderid_name = $value['senderid_name'];
				$message = $value['message'];
				$type = $value['sms_type'];
				$date = $value['updated_at'];
				// $status = $value['status']

				$_SESSION["btn-id"] = $id;

				$report_summary .= "<tr>
				<td><a href='view/report_blank.php?id=$id' class='btn btn-outline-warning btn-sm btn_id' style='width:50px !important;' 
				id='sms-message-$id' value='$id'>$id</a></td>
    			<td>$campaign_name</td>
    			<td>$senderid_name</td>
    			<td>$message</td>
    			<td>$type</td>
    			<td>$date</td>
    			</tr>";
	    		$msg_id .= $id;
				$i++;
			}
			return $report_summary;
		} else {
			return "No record available";
		}
	}

/* Today Report Chart
   ========================================================================== */
	// function viewChart(){
	// 	global $dbc;
	// 	$result_chart = array();
	// 	$table_id .= $_SESSION['rp_id'];
	// 	// $sql = "SELECT * FROM az_sendmessages202202 LIMIT 100";
	// 	$sql = "SELECT status, sum(msgcredit) FROM az_sendnumbers202202 WHERE message_id = $table_id group by status";
	// 	$values = mysqli_query($dbc, $sql);
	// 	while ($row = mysqli_fetch_assoc($values)) {
	// 		$r_id = $row['status'];
	// 		$result_chart[$r_id] = $row;
	// 	}
	// 	return $result_chart;
	// }

	// function today_chart_data($result_chart){
	// 	$i = 1;
	// 	if (!empty($result_chart)) {
	// 		// echo "Loaded till Line Number 65";
	// 		foreach ($result_chart as $key => $value) {
	// 			// echo "Hello";
	// 			$status = $value['status'];
	// 			$sum_msgcredit = $value['sum(msgcredit)'];

	// 			// $data1 = $status . " " . $sum_msgcredit . ",";
	// 			$data_status = $status;
	// 			$data_msgcredit = $sum_msgcredit;
	// 			// $data2 = json_encode($data1);
	// 			$return_today_chart_data .= "<tr><td>$data_status</td><td>$data_msgcredit</td></tr>";
	// 			// $return_today_chart_data .= $data_status . $data_msgcredit;
	// 			// $return_today_chart_data .= $data_msgcredit;
	// 			$i++;
	// 		}
	// 		return $return_today_chart_data;
	// 	} else {
	// 		return "No record available";
	// 	}
	// }

/* Today Report Function
   ========================================================================== */
	// function viewReport(){
	// 	global $dbc;
	// 	$result = array();
	// 	$table_id .= $_SESSION['rp_id'];
	// 	$sql = "SELECT * FROM az_sendnumbers202202 WHERE message_id = $table_id LIMIT 100";
	// 	$values = mysqli_query($dbc, $sql);
 //   	while ($row = mysqli_fetch_assoc($values)) {
 //   		$r_id = $row['id'];
 //   		$result[$r_id] = $row;
 //   	}
 //   	return $result;
	// }

	// function today_report($result) {
	// 	$i = 1;
	// 	if (!empty($result)) {
	// 	foreach ($result as $key => $value) {
	// 		$message_id = $value['message_id'];
	// 		$route = $value['route'];
	// 		$mobile_number = $value['mobile_number'];
	// 		$status = $value['status'];
	// 		$date = $value['created_at'];
	// 		$table_id = $_SESSION['rp_id'];
	// 	   $return_today_report.="<tr>
	// 	    		<td width='5%'>$message_id</td>
	// 	    		<td width='5%'>$route</td>
	// 	    		<td width='5%'>$mobile_number</td>
	// 	    		<td width='5%'>$message_id</td>
	// 	    		<td width='5%'>$status</td>
	// 	    		<td class='w-auto'>$date</td>
	// 	    		<td width='5%'></td>
	// 	    		<td width='5%'>$err_stat</td>
	// 	    		<td width='5%'>$table_id</td>
	// 	    	</tr>";
	// 	    	$i++;
	// 	  	}
	// 	    return $return_today_report;
	// 	} else {
	// 	  return "No record available";
	// 	}
	// }

	// function viewReportDashboard(){
	// 	global $dbc;
	// 	$result1 = array();
	// 	$sql = "SELECT id FROM az_sendnumbers202202 LIMIT 1000";
	// 	$values = mysqli_query($dbc, $sql);
	// 	while ($row = mysqli_fetch_assoc($values)) {
	// 		$r_id = $row['id'];
	// 		$result1[$r_id] = $row;
	// 	}
	// 	return $result1;
	// }

	// function today_report_dashboard($result1) {
	// 	$i = 1;
	// 	if (!empty($result1)) {
	// 		foreach ($result1 as $key => $value) {
	// 			$status = $value['status'];
	// 			$created_at = $value['created_at'];
	// 			$senderid = $value['senderid'];
	// 			$created_at = $value['created_at'];
	// 			$msgdata = $value['msgdata'];

	// 			// printing the variables
	// 			$return_today_report_dashboard .= $status;
	// 			$i++;
	// 		}
	// 		return $return_today_report_dashboard;
	// 	} else {
	// 		return "No record available";
	// 	}
	// }	

		
			// if(isset($_REQUEST['list_type'])) {
			//    	$list_type=$_REQUEST['list_type'];
			//     if($list_type=='scheduled_report') {
			//     	$result = viewScheduledReport();
			//     	$return_scheduled_report = scheduled_report($result);
			//     	echo $return_scheduled_report;
			//     }
			// }

		/* Scheduled Report
		   ========================================================================== */
			// function viewScheduledReport(){
			// 	global $dbc;
			// 	$result_scheduled_report = array();
			// 	// $table_id .= $_SESSION['rp_id'];
			// 	$sql = "SELECT message_id, route, senderid, msgdata, msgcredit, created_at, scheduled_time FROM az_sendnumbers202202 LIMIT 100";
			// 	$values = mysqli_query($dbc, $sql);
		 //   	while ($row = mysqli_fetch_assoc($values)) {
		 //   		$r_id = $row['message_id'];
		 //   		$result_scheduled_report[$r_id] = $row;
		 //   	}
		 //   	return $result_scheduled_report;
			// }

			// function scheduled_report($result_scheduled_report) {
			// 	$i = 1;
			// 	if (!empty($result_scheduled_report)) {
			// 	foreach ($result_scheduled_report as $key => $value) {
			// 		$id = $value['message_id'];
			// 		$route = $value['route'];
			// 		$senderid = $value['senderid'];
			// 		$msgdata = $value['msgdata'];
			// 		$msgcredit = $value['msgcredit'];
			// 		$created_at = $value['created_at'];
			// 		$scheduled_time = $_SESSION['scheduled_time'];
			// 	    $return_scheduled_report.="<tr>
			// 	    		<td width='5%'>$id</td>
			// 	    		<td width='5%'>$route</td>
			// 	    		<td width='5%'>$senderid</td>
			// 	    		<td width='5%'>$msgdata</td>
			// 	    		<td width='5%'></td>
			// 	    		<td width='5%'>$msgcredit</td>
			// 	    		<td width='5%'>$created_at</td>
			// 	    		<td width='5%'>$scheduled_time</td>
			// 	    		<td width='5%'></td>
			// 	    		<td width='5%'>
			// 	    			<button type='button' class='btn btn-outline-primary btn-sm'>Edit</button>
			// 	    			<br>
			// 	    			<button type='button' class='btn btn-outline-primary btn-sm mt-1'>Delete</button>
			// 	    		</td>
			// 	    	</tr>";
			// 	    	$i++;
			// 	  	}
			// 	    return $return_scheduled_report;
			// 	} else {
			// 	  return "No record available";
			// 	}
			// }


		// if(isset($_REQUEST['list_type'])) {
	 	// $list_type=$_REQUEST['list_type'];

		//     if($list_type=='chart_s') {
		//     	$result2 = viewReportChartSubmitted();
		//     	$today_report_submitted = today_report_submitted($result2);
		//     	echo $today_report_submitted;
		//     } elseif ($list_type=='chart_f') {
		//     	$result3 = viewReportChartFailed();
		//     	$today_report_failed = today_report_failed($result3);
		//     	echo $today_report_failed;
		//     } elseif ($list_type=='chart_d') {
		//     	$result4 = viewReportChartDelivered();
		//     	$today_report_delivered = today_report_delivered($result4);
		//     	echo $today_report_delivered;
		//     } else {
		//     	echo "None";
		//     }
		// }

	// function viewReportChartSubmitted(){
	// 	global $dbc;
	// 	$result2 = array();
	// 	$table_id .= $_SESSION['rp_id'];
	// 	$sql = "SELECT COUNT(id) FROM az_sendnumbers202202 WHERE status = 'Submitted' AND message_id = $table_id";
	// 	$values = mysqli_query($dbc, $sql);
	// 	while ($row = mysqli_fetch_assoc($values)) {
	// 		$r_id = $row['id'];
	// 		$result2[$r_id] = $row;
	// 	}
	// 	return $result2;
	// }

	// function viewReportChartFailed(){
	// 	global $dbc;
	// 	$result3 = array();
	// 	$table_id .= $_SESSION['rp_id'];
	// 	$sql = "SELECT COUNT(id) FROM az_sendnumbers202202 WHERE status = 'Failed' AND message_id = $table_id";
	// 	$values = mysqli_query($dbc, $sql);
	// 	while ($row = mysqli_fetch_assoc($values)) {
	// 		$r_id = $row['id'];
	// 		$result3[$r_id] = $row;
	// 	}
	// 	return $result3;
	// }

	// function viewReportChartDelivered(){
	// 	global $dbc;
	// 	$result4 = array();
	// 	$table_id .= $_SESSION['rp_id'];
	// 	$sql = "SELECT COUNT(id) FROM az_sendnumbers202202 WHERE status = 'Delivered' AND message_id = $table_id";
	// 	$values = mysqli_query($dbc, $sql);
	// 	while ($row = mysqli_fetch_assoc($values)) {
	// 		$r_id = $row['id'];
	// 		$result4[$r_id] = $row;
	// 	}
	// 	return $result4;
	// }

	// function viewTodayReport(){
	// 	global $dbc;
	// 	$result6 = array();
	// 	$table_id .= $_SESSION['rp_id'];
	// 	// $sql = "SELECT status, sum(msgcredit) FROM az_sendnumbers202202 WHERE message_id = $table_id group by status;"
	// 	$sql = "SELECT * FROM az_sendnumbers202202 WHERE message_id = $table_id;"
	// 	while ($row = mysqli_fetch_assoc($values)) {
	// 		$r_id = $row['id'];
	// 		$result6[$r_id] = $row;

	// 		// $result6['plan'] = $result_plan;
	// 		// $result6['route'] = $result_route;
	// 		// $result6['gateway'] = $result_gateway;
	// 		// echo json_encode($result);
	// 	}
	// 	return $result6;
	// }	

	// function today_report_submitted($result2){
	// 	$i = 1;
	// 	if (!empty($result2)) {
	// 		foreach ($result2 as $key => $value) {
	// 			$cnt_id = $value['COUNT(id)'];
	// 			$return_report_submitted .= $cnt_id;
	// 			$i++;
	// 		}
	// 		return $return_report_submitted;
	// 	} else {
	// 		return "No record available";
	// 	}
	// }

	// function today_report_failed($result3){
	// 	$i = 1;
	// 	if (!empty($result3)) {
	// 		foreach ($result3 as $key => $value) {
	// 			$cnt_id = $value['COUNT(id)'];
	// 			$return_report_failed .= $cnt_id;
	// 			$i++;
	// 		}
	// 		return $return_report_failed;
	// 	} else {
	// 		return "No record available";
	// 	}
	// }

	// function today_report_delivered($result4){
	// 	$i = 1;
	// 	if (!empty($result4)) {
	// 		foreach ($result4 as $key => $value) {
	// 			$cnt_id = $value['COUNT(id)'];
	// 			$return_report_delivered .= $cnt_id;
	// 			$i++;
	// 		}
	// 		return $return_report_delivered;
	// 	} else {
	// 		return "No record available";
	// 	}
	// }	
?>