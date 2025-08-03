<?php
session_start();

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
$log_file = "../error/logfiles/report_controller.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);


error_reporting(0);
include('../include/connection.php');
require('classes/ssp.class.php');
include('../include/config.php');
//include_once('../include/datatable_dbconnection.php');
include_once('../include/url_encode.php');

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/


$u_id=$_SESSION['user_id'];
if(isset($_REQUEST['list_type']))
{
     $list_type=$_REQUEST['list_type'];


    if($list_type=='load_today_summary')
    {
          $result = load_today_summary();

            
            echo $result;
    }
    if($list_type=='load_today_summary_test')
    {
          $result = load_today_summary_test();

            
            echo $result;
    }
    else if($list_type=='load_gateway_summary')
    {
          $result = load_gateway_summary();

            
            echo $result;
    }
    else if($list_type=='show_delivery_count')
    {

    		$job_id = $_REQUEST['job_id'];
    	$delivery_count=get_delivery_count($job_id);
	        		echo $delivery_count;
    }
    else if($list_type=='download_report')
    {
	    		$rs=load_send_job_data();

	    		$job_id=$_REQUEST['job_id'];
    			$message_job_id=$rs[0]['job_id'];

    			$message_id=$rs[0]['id'];
    			$sendtabledetals = SENDSMSDETAILS;
    			$job_date=date("Y-m-d",strtotime($_REQUEST['job_date']));
    
		   	$today_dt=date("Y-m-d");

		   	$yesterday_dt=date("Y-m-d",strtotime("-1 day"));
		   	if($job_date!=$today_dt && $job_date!=$yesterday_dt)
		   	{
		   		$report_yr=date("Y",strtotime($job_date));
		   		$report_mt=date("m",strtotime($job_date));
		   		$sendtabledetals=SENDSMSDETAILS.$report_yr.$report_mt;
		   	}
		   	 	if($job_date==$yesterday_dt)
			   	{
			   		
			   		$report_yr=date("Y",strtotime($job_date));
			   		$report_mt=date("m",strtotime($job_date));
			   		$sendtable=SENDSMS.$report_yr.$report_mt;
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
				$extraWhere.=" and `userids`='$userid'";
			}
			else
			{

				$extraWhere="`userids`='$userid'";
			}
			 

			 if($job_id!='')
			 {
			 		if($extraWhere!="")
					{
						$extraWhere.=" and msg_job_id='$message_job_id'";
					}
					else
					{

						$extraWhere=" msg_job_id='$message_job_id'";
					}
			 }

				$fileName = "/var/www/html/itswe_panel/send_job_report.xls"; 
			 	$fields_query="id,route,mobile_number,msgdata,char_count,msgcredit,master_job_id,status,sent_at,err_code ";
			 	$fields = array('id','route','mobile_number','msgdata','char_count','msgcredit','master_job_id','status','sent_at','err_code'); 
			 	$excelData = implode("\t", array_values($fields)) . "\n"; 
			 	$query="select $fields_query from $table where $extraWhere";
			/* 	echo "echo $query| mysql -u root -p'mds321321' 'sms_portal' > /var/www/html/itswe_panel/controller/send_job_tbl_dtls.xls";
			 $result_file=exec("echo $query| mysql -h 3.110.189.171 -u root -p'mds321321' 'sms_portal' > /var/www/html/itswe_panel/controller/send_job_tbl_dtls.xls",$outp,$return);
			 echo $return;*/
			 	$result_download=mysqli_query($dbc,$query);
			 	$count_rows=mysqli_num_rows($result_download);



  /*      
			 	$columnHeader = '';  
				$columnHeader = "ID" . "\t" . "Route" . "\t" . "Mobile" . "\t". "Chars" . "\t". "Bill" . "\t". "Message ID" . "\t". "Status" . "\t". "Date" . "\t". "Err/Stat" . "\t";  
				$setData = '';  */
				 while ($rec = mysqli_fetch_assoc($result_download)) {  

				$lineData = array($rec['id'], $rec['route'], $rec['mobile_number'], $rec['msgdata'], $rec['char_count'], $rec['msgcredit'], $rec['master_job_id'], $rec['status'],  $rec['sent_at'], $rec['err_code']); 
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 


				   /* $rowData = '';  
				    foreach ($rec as $value) {  
				        $value = '"' . $value . '"' . "\t";  
				        $rowData .= $value;  
				    }  
				    $setData .= trim($rowData) . "\n";  */
				}  
 
header("Content-Type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=$fileName"); 
 
// Render excel data 
echo $excelData; 

    }
    else if($list_type=='today_report')
    {

    	$sendtabledetals = SENDSMSDETAILS;
		$select_user_id=$_REQUEST['uid'];
		$today_dt=date('Y-m-d');

    	$report_type=$_REQUEST['report_type'];
	$table = $sendtabledetals;

	$primaryKey = 'id';

			$columns = array(
			/*	array( 'db' => 'id','dt' => 0 ),
*/			    array( 'db' => 'route','dt' => 0 ),
			    array( 'db' => 'mobile_number','dt' => 1,'formatter' => function( $d, $row ) {

			    				global $restricted_report;
			    				if($restricted_report=='Yes')
			    				{
			    					$count_len=strlen($d);
			    					return substr($d, 0, $count_len-6)."XXXXXX";
			    				} 
			    				else
			    				{
			    					 return $d;
			    				}
			           
			        } ),
			    array( 'db' => 'userids','dt' => 2 ,'formatter' => function( $d, $row ) {
			    		$username=get_username($d);
			            return $username;
			        }),
			    array( 'db' => 'char_count','dt' => 3 ),
			    array( 'db' => 'msgcredit','dt' => 4),
			    array( 'db' => 'master_job_id','dt' => 5),
			    array( 'db' => 'msgdata','dt' => 6,'formatter' => function( $d, $row ) {
			    		$msg=urldecode($d);
			            return $msg;
			        }),
			   /* array( 'db' => 'id','dt' => 8 ),*/
			    array( 'db' => 'status','dt' => 7 ),
			  	array(
			        'db'        => 'sent_at',
			        'dt'        => 8,
			        'formatter' => function( $d, $row ) {
			            return date( 'Y-m-d h:i a', strtotime($d));
			        }
			    ),
			    array(
			        'db'        => 'delivered_date',
			        'dt'        => 9,
			        'formatter' => function( $d, $row ) {
			        	if($d!=0)
			        	{

			            return date( 'Y-m-d h:i a', $d);
			        	}
			        	else
			        	{
			        		return '-';
			        	}

			        }
			    ),
			    array(
			        'db'        => 'metadata',
			        'dt'        => 10,
			        'formatter' => function( $d, $row ) {

			        		$queryString = $d;

									// Remove the leading "?" if present
									$queryString = ltrim($queryString, '?');

									// Parse the query string into an associative array
									parse_str($queryString, $params);

									// Access the value of the TID parameter
									if (isset($params['TID'])) {
									    $tidValue = $params['TID'];
									    return $tidValue;
									}
			        	
			        }
			    ),
			  	array( 'db' => 'err_code','dt' => 11)
			  	/*array( 'db' => 'id','dt' => 12 )*/
			);
			 
			// SQL server connection information
			global $sql_details ;

			$extraWhere=" (date(sent_at)='$today_dt')";
			if($report_type=="total")
			{
				$extraWhere=" (date(sent_at)='$today_dt')";
				
			}
		

			if($report_type!="total")
			{
				if($extraWhere!="")
				{
					$extraWhere.="and status='".$report_type."'";

				}
				else
				{
					$extraWhere="status='".$report_type."'";
				}

			}
			else if($report_type=="" || $report_type=='total')
			{

			}
		


		
			$user_role=$_REQUEST['user_role'];
			$userid=$_SESSION['user_id'];
			$select_user_id=$_REQUEST['uid'];

			if($user_role=='mds_rs' || $user_role=='mds_ad')
			{

				$selected_role=$_REQUEST['selected_role'];

			if($selected_role=="User")
			{
				$userid=$_REQUEST['uid'];

				if($userid=="All")
				{
					$parent_id=$_SESSION['user_id'];
					/*$user_ids=fetch_userids($parent_id);
					$check_user_ids=implode(",",$user_ids);*/

					if($extraWhere!="")
					{
						$extraWhere.=" and `parent_id`='".$parent_id."' and schedule_sent=1 ";
					}
					else
					{

						$extraWhere="`userids` in ($userid) and schedule_sent=1 ";
					}
				}
				else
				{

					if($extraWhere!="")
					{
						$extraWhere.=" and `userids` in ($userid) and schedule_sent=1 ";
					}
					else
					{

						$extraWhere="`userids` in ($userid) and schedule_sent=1 ";
					}
				}

			}
			else if($selected_role=="Reseller")
			{
				if($select_user_id=="All")
				{
								$userid=$_SESSION['user_id'];
								$userid_arr[]=$userid;
                $child_users=get_childUsers($userid_arr);
                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }



                     
                      $single_arr=array_unique($single_arr);
                      $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                      	 $check_user_ids=implode(",",$only_resellers);
                      }

					if($extraWhere!="")
					{
						$extraWhere.=" and `parent_id` in ($check_user_ids) and schedule_sent=1 ";
					}
					else
					{
						$extraWhere="`parent_id` in ($check_user_ids) and schedule_sent=1 ";
					}
				}
				else
				{

					
										$userid_arr[]=$select_user_id;
                    // $child_users=get_childUsers($userid_arr);

                    //   foreach ($child_users as $child_val) {
                    //     foreach($child_val as $val)
                    //     {
                    //       $single_arr[]=$val;
                    //     }
                    //   }

                    //   $single_arr[]=$select_user_id;
                    //   $single_arr=array_unique($single_arr);
                    // $only_resellers=get_onlyResellers($single_arr);
                    //   if(!empty($only_resellers))
                    //   {
                    //   	 $check_user_ids=implode(",",$only_resellers);
                    //   }

                    $parent_id=get_parentID($select_user_id);

										if($extraWhere!="")
										{
											$extraWhere.=" and `parent_id` in ($parent_id) and schedule_sent=1 ";
										}
										else
										{

											$extraWhere=" `parent_id` in ($parent_id) and schedule_sent=1 ";
										}
				}

		}


			}
	else if($user_role=='mds_adm')
	{
		
		$selected_role=$_REQUEST['selected_role'];


		if($selected_role=="User")
		{
			if($select_user_id!="" && $select_user_id!="All")
			{

				$check_user_ids=$select_user_id;
				$extraWhere.=" and `userids` in ($check_user_ids) and schedule_sent=1 ";
			}
			else
			{

				$user_ids=fetch_allusers();
				$check_user_ids=implode(",",$user_ids);
				$extraWhere.=" and `userids` in ($check_user_ids) and schedule_sent=1 ";
			}
		}
		else if($selected_role=="Reseller")
		{
			if($select_user_id=='All')
			{
				$all_resellers=fetch_allresellers();

        $check_user_ids=implode(",",$all_resellers);

			
				$extraWhere.=" and `parent_id` in ($check_user_ids) and schedule_sent=1 ";
			}
			else
			{

					$userid_arr[]=$select_user_id;
                    $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                      $single_arr[]=$select_user_id;
                      $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                      	 $check_user_ids=implode(",",$only_resellers);
                      }
                     
				 $extraWhere.=" and `parent_id` in ($check_user_ids) and schedule_sent=1 ";
			}
		}
		else if($selected_role=="Admin")
		{
			if($select_user_id=='All')
			{
				$all_admins=fetch_alladmins();

				$userid_arr=$all_admins;
				
        $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                    $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                      	 $check_user_ids=implode(",",$only_resellers);
                      }
			$extraWhere.=" and `parent_id` in ($check_user_ids) and schedule_sent=1 ";
			}
			else
			{

					$userid_arr[]=$select_user_id;
                    $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                     
                      $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                      	 $check_user_ids=implode(",",$only_resellers);
                      }
                     
				$extraWhere.=" and `parent_id` in ($check_user_ids) and schedule_sent=1 ";
			}
		}
		else if($selected_role=="All")
			{
				$userid=$_REQUEST['uid'];

				if($userid=="All")
				{
					$parent_id=$_SESSION['user_id'];
					/*$user_ids=fetch_userids($parent_id);
					$check_user_ids=implode(",",$user_ids);*/

					if($extraWhere!="")
					{
						$extraWhere.=" and `parent_id`='".$parent_id."' and schedule_sent=1 ";
					}
					else
					{

						$extraWhere="`userids` in ($userid) and schedule_sent=1 ";
					}
				}
				else
				{

					if($extraWhere!="")
					{
						$extraWhere.=" and `userids` in ($userid) and schedule_sent=1 ";
					}
					else
					{

						$extraWhere="`userids` in ($userid) and schedule_sent=1 ";
					}
				}

			}
	}
		else
			{

					if($extraWhere!="")
					{
						$extraWhere.=" and `userids` in ($userid) and schedule_sent=1 ";
					}
					else
					{

						$extraWhere="`userids` in ($userid) and schedule_sent=1 ";
					}
			}

			// echo $extraWhere;
			 
			echo json_encode(
			    SSP::complex( $_REQUEST, $sql_details, $table, $primaryKey, $columns,$test=null,$extraWhere )
			);

 	}
 	 else if($list_type=='today_report_test')
    {
    	$sendtabledetals = SENDSMSDETAILS;
		$select_user_id=$_REQUEST['uid'];
		$today_dt=date('Y-m-d');

    	$report_type=$_REQUEST['report_type'];
	$table = $sendtabledetals;

	$primaryKey = 'id';

			$columns = array(
			/*	array( 'db' => 'id','dt' => 0 ),
*/			    array( 'db' => 'route','dt' => 0 ),
			    array( 'db' => 'mobile_number','dt' => 1,'formatter' => function( $d, $row ) {

			    				global $restricted_report;
			    				if($restricted_report=='Yes')
			    				{
			    					$count_len=strlen($d);
			    					return substr($d, 0, $count_len-6)."XXXXXX";
			    				} 
			    				else
			    				{
			    					 return $d;
			    				}
			           
			        } ),
			    array( 'db' => 'userids','dt' => 2 ,'formatter' => function( $d, $row ) {
			    		$username=get_username($d);
			            return $username;
			        }),
			    array( 'db' => 'char_count','dt' => 3 ),
			    array( 'db' => 'msgcredit','dt' => 4),
			    array( 'db' => 'master_job_id','dt' => 5),
			    array( 'db' => 'msgdata','dt' => 6,'formatter' => function( $d, $row ) {
			    		$msg=urldecode($d);
			            return $msg;
			        }),
			   /* array( 'db' => 'id','dt' => 8 ),*/
			    array( 'db' => 'status','dt' => 7 ),
			  	array(
			        'db'        => 'sent_at',
			        'dt'        => 8,
			        'formatter' => function( $d, $row ) {
			            return date( 'Y-m-d h:i a', strtotime($d));
			        }
			    ),
			    array(
			        'db'        => 'delivered_date',
			        'dt'        => 9,
			        'formatter' => function( $d, $row ) {
			        	if($d!=0)
			        	{

			            return date( 'Y-m-d h:i a', $d);
			        	}
			        	else
			        	{
			        		return '-';
			        	}

			        }
			    ),
			    array(
			        'db'        => 'metadata',
			        'dt'        => 10,
			        'formatter' => function( $d, $row ) {

			        		$queryString = $d;

									// Remove the leading "?" if present
									$queryString = ltrim($queryString, '?');

									// Parse the query string into an associative array
									parse_str($queryString, $params);

									// Access the value of the TID parameter
									if (isset($params['TID'])) {
									    $tidValue = $params['TID'];
									    return $tidValue;
									}
			        	
			        }
			    ),
			  	array( 'db' => 'err_code','dt' => 11)
			  	/*array( 'db' => 'id','dt' => 12 )*/
			);
			 
			// SQL server connection information
			global $sql_details ;

			$extraWhere=" (date(sent_at)='$today_dt')";
			if($report_type=="total")
			{
				$extraWhere=" (date(sent_at)='$today_dt')";
				
			}
		

			if($report_type!="total")
			{
				if($extraWhere!="")
				{
					$extraWhere.="and status='".$report_type."'";

				}
				else
				{
					$extraWhere="status='".$report_type."'";
				}

			}
			else if($report_type=="" || $report_type=='total')
			{

			}
		


		
			$user_role=$_REQUEST['user_role'];
			$userid=$_SESSION['user_id'];
			$select_user_id=$_REQUEST['uid'];

			if($user_role=='mds_rs' || $user_role=='mds_ad')
			{

				$selected_role=$_REQUEST['selected_role'];

			if($selected_role=="User")
			{
				$userid=$_REQUEST['uid'];

				if($userid=="All")
				{
					$parent_id=$_SESSION['user_id'];
					/*$user_ids=fetch_userids($parent_id);
					$check_user_ids=implode(",",$user_ids);*/

					if($extraWhere!="")
					{
						$extraWhere.=" and `parent_id`='".$parent_id."' and schedule_sent=1 ";
					}
					else
					{

						$extraWhere="`userids` in ($userid) and schedule_sent=1 ";
					}
				}
				else
				{

					if($extraWhere!="")
					{
						$extraWhere.=" and `userids` in ($userid) and schedule_sent=1 ";
					}
					else
					{

						$extraWhere="`userids` in ($userid) and schedule_sent=1 ";
					}
				}

			}
			else if($selected_role=="Reseller")
			{
				if($select_user_id=="All")
				{
								$userid=$_SESSION['user_id'];
								$userid_arr[]=$userid;
                $child_users=get_childUsers($userid_arr);
                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }



                     
                      $single_arr=array_unique($single_arr);
                      $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                      	 $check_user_ids=implode(",",$only_resellers);
                      }

					if($extraWhere!="")
					{
						$extraWhere.=" and `parent_id` in ($check_user_ids) and schedule_sent=1 ";
					}
					else
					{
						$extraWhere="`parent_id` in ($check_user_ids) and schedule_sent=1 ";
					}
				}
				else
				{

					
										$userid_arr[]=$select_user_id;
                    // $child_users=get_childUsers($userid_arr);

                    //   foreach ($child_users as $child_val) {
                    //     foreach($child_val as $val)
                    //     {
                    //       $single_arr[]=$val;
                    //     }
                    //   }

                    //   $single_arr[]=$select_user_id;
                    //   $single_arr=array_unique($single_arr);
                    // $only_resellers=get_onlyResellers($single_arr);
                    //   if(!empty($only_resellers))
                    //   {
                    //   	 $check_user_ids=implode(",",$only_resellers);
                    //   }

                    $parent_id=get_parentID($select_user_id);

										if($extraWhere!="")
										{
											$extraWhere.=" and `parent_id` in ($parent_id) and schedule_sent=1 ";
										}
										else
										{

											$extraWhere=" `parent_id` in ($parent_id) and schedule_sent=1 ";
										}
				}

		}


			}
	else if($user_role=='mds_adm')
	{
		
		$selected_role=$_REQUEST['selected_role'];


		if($selected_role=="User")
		{
			if($select_user_id!="" && $select_user_id!="All")
			{

				$check_user_ids=$select_user_id;
				$extraWhere.=" and `userids` in ($check_user_ids) and schedule_sent=1 ";
			}
			else
			{

				$user_ids=fetch_allusers();
				$check_user_ids=implode(",",$user_ids);
				$extraWhere.=" and `userids` in ($check_user_ids) and schedule_sent=1 ";
			}
		}
		else if($selected_role=="Reseller")
		{
			if($select_user_id=='All')
			{
				$all_resellers=fetch_allresellers();

        $check_user_ids=implode(",",$all_resellers);

			
				$extraWhere.=" and `parent_id` in ($check_user_ids) and schedule_sent=1 ";
			}
			else
			{

					$userid_arr[]=$select_user_id;
                    $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                      $single_arr[]=$select_user_id;
                      $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                      	 $check_user_ids=implode(",",$only_resellers);
                      }
                     
				 $extraWhere.=" and `parent_id` in ($check_user_ids) and schedule_sent=1 ";
			}
		}
		else if($selected_role=="Admin")
		{
			if($select_user_id=='All')
			{
				$all_admins=fetch_alladmins();

				$userid_arr=$all_admins;
				
        $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                    $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                      	 $check_user_ids=implode(",",$only_resellers);
                      }
			$extraWhere.=" and `parent_id` in ($check_user_ids) and schedule_sent=1 ";
			}
			else
			{

					$userid_arr[]=$select_user_id;
                    $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                     
                      $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                      	 $check_user_ids=implode(",",$only_resellers);
                      }
                     
				$extraWhere.=" and `parent_id` in ($check_user_ids) and schedule_sent=1 ";
			}
		}
		else if($selected_role=="All")
			{
				$userid=$_REQUEST['uid'];

				if($userid=="All")
				{
					$parent_id=$_SESSION['user_id'];
					/*$user_ids=fetch_userids($parent_id);
					$check_user_ids=implode(",",$user_ids);*/

					if($extraWhere!="")
					{
						$extraWhere.=" and `parent_id`='".$parent_id."' and schedule_sent=1 ";
					}
					else
					{

						$extraWhere="`userids` in ($userid) and schedule_sent=1 ";
					}
				}
				else
				{

					if($extraWhere!="")
					{
						$extraWhere.=" and `userids` in ($userid) and schedule_sent=1 ";
					}
					else
					{

						$extraWhere="`userids` in ($userid) and schedule_sent=1 ";
					}
				}

			}
	}
		else
			{

					if($extraWhere!="")
					{
						$extraWhere.=" and `userids` in ($userid) and schedule_sent=1 ";
					}
					else
					{

						$extraWhere="`userids` in ($userid) and schedule_sent=1 ";
					}
			}

			// echo $extraWhere;
			 
			echo json_encode(
			    SSP::complex( $_REQUEST, $sql_details, $table, $primaryKey, $columns,$test=null,$extraWhere )
			);

 	}
 	else if($list_type=='archive_report')
    	{

		 			session_start();
				
    			$sendtable = SENDSMS . CURRENTMONTH;
    		/*$sendtabledetals = SENDSMSDETAILS . CURRENTMONTH;*/
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
		    		$sendtable = SENDSMS .$frm_year.$frm_month;
		    		$senddtlstable = SENDSMSDETAILS .$frm_year.$frm_month;
		    		$table = $sendtable;
		    }

		    $extraWhere.="(date(sent_at) BETWEEN '" . $frmDate . "' AND '" . $toDate . "')";

		$primaryKey = 'id';

		$columns = array(
		/*	array('db' => 'id', 'dt' => 0),*/
			array('db' => 'job_id', 'dt' => 0,
				'formatter' => function($d, $row) {
					global $table,$sendtabledetals;
					session_start();
					
	        			return "<a href='dashboard.php?page=send_job&job_id=$d&table_name=$table&job_date=$row[1]'>$d</a>";
	        		}
			),
		    	array('db' => 'sent_at', 'dt' => 1, 
		    	'formatter' => function($d, $row) {
	        		return date( 'Y-m-d h:i a', strtotime($d));
	        	}),
	        	array('db' => 'userid','dt' => 2,'formatter' => function($d, $row) {
		   		$username=get_username($d);
	        		return $username;
	        	}),
		    	array('db' => 'route','dt' => 3),
		    	array('db' => 'senderid_name','dt' => 4),
		    	array('db' => 'message','dt' => 5,'formatter' => function($d, $row) {
		   		$msg=urldecode($d);
	        		return $msg;
	        	}),
		   	array('db' => 'msg_credit','dt' => 6,'formatter' => function($d, $row) {
		   		$numbers_count=$row[7];
		   		$form_type=$row[8];
		   		if($form_type!='Dynamic')
		   		{
	        		return $d*$numbers_count;
		   		}
		   		else
		   		{
		   			return $d;
		   		}
	       }),
	        	array('db' => 'numbers_count','dt' => 7),
	        	array('db' => 'job_id','dt' => 8,'formatter' => function($d, $row) {
		   					return '<button type="button" class="btn btn-primary view_delivery_count" alt="Delievry count" data-item-id="'.$d.'"><i class="fa fa-eye"></i></button><br><b><span id=delivery_count_'.$d.'></b></span>';
	        	}),
	        	
		    
		);
		 
		// SQL server connection information
		global $sql_details ;


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
						$user_ids=fetch_userids($parent_id);
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
						$user_ids=fetch_userids_by_resellers($check_parent_ids);
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

						$user_ids=fetch_userids_by_resellers($userid);
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
			 
			echo json_encode(
			    SSP::complex( $_REQUEST, $sql_details, $table, $primaryKey, $columns,$test=null,$extraWhere )
			);

 	}
 	else if($list_type=='download_archive_report_old')
    	{
    			global $dbc;
		 		
    		/*	$sendtable = SENDSMSDETAILS . CURRENTMONTH;*/
    		$sendtabledetals = SENDSMSDETAILS . CURRENTMONTH;
					$table = $sendtabledetals;

					$extraWhere="";
					 
					if ($_REQUEST['frmDate'] != "" && $_REQUEST['toDate'] != "") {
					    $frmDate = $_REQUEST["frmDate"];
					    $toDate = $_REQUEST["toDate"];


					} else {

					
					}

		    $from_dt_split=explode("-",$frmDate);
		    $frm_year=$from_dt_split[0];
		    $frm_month=$from_dt_split[1];

		    $to_dt_split=explode("-",$toDate);
		     $to_year=$to_dt_split[0];
		    $to_month=$to_dt_split[1];
		    	$sendtabledetals=SENDSMSDETAILS .$frm_year.$frm_month;
		   
		    $extraWhere.="(date(sent_at) BETWEEN '" . $frmDate . "' AND '" . $toDate . "') ";


				$userid=$_SESSION['user_id'];
				$user_role=$_SESSION['user_role'];
				$login_user_role=$_SESSION['user_role'];
					$selected_role=$_REQUEST['selected_role'];
				$select_user_id=$_REQUEST['select_user_id'];

						if($user_role=='mds_rs' || $user_role=='mds_ad')
						{


					}
					else if($user_role=='mds_adm')
					{

				
					if($selected_role=="User")
					{
						if($select_user_id!="" && $select_user_id!="All")
						{

							$check_user_ids=$select_user_id;
							$extraWhere.="and userids in (".$check_user_ids.") and schedule_sent=1 and (msgcredit>0) group by userids";
						}
						else if($select_user_id=="All")
						{

						/*	$user_ids=fetch_allusers();
							$check_user_ids=implode(",",$user_ids);*/
							$extraWhere.=" and schedule_sent=1 and (msgcredit>0) group by userids";
							
						}
					}
				}
				else if($user_role=='mds_usr')
				{
						$extraWhere.=" and userids='$userid'";
				}
						
					$sql="select sent_at,userids,sum(msgcredit) as total_msgcredit from $sendtabledetals where $extraWhere  order by sent_at desc";
					$result=mysqli_query($dbc,$sql)or die(mysqli_error($dbc));
					$record_count=mysqli_num_rows($result);

					 $sql2="select count(1) as total_record_count from $sendtabledetals where $extraWhere";
					$result2=mysqli_query($dbc,$sql2)or die(mysqli_error($dbc));
					$result_row2=mysqli_fetch_array($result2);
					$record_count2=$result_row2['total_record_count'];

					 $file_count=ceil($record_count2/200000);
		if($record_count>0)
		{
					$date = date('Ymdhims');

				$fileName = 'upload/Download_'.$date.'.zip';
	   		$fname='upload/Download_'.$date.'.zip';
			


	   			$zip = new ZipArchive;
			 $result_zip = $zip->open($fileName, ZipArchive::CREATE); 
			if ($result_zip === TRUE) 
			{
					    while($row=mysqli_fetch_array($result))
							{
									//
									$download_userid=$row['userids'];
									$record.="<tr>";
									if($user_role=='mds_adm')
									{
									
										$username=get_username($row['userids']);
										$record.="<td>".$username."</td>";

									}
							
									$total_credit=$row['total_msgcredit'];
							

									$record.="<td>".$total_credit."</td><td><a href='controller/".$fileName."' download><span class='fas fa-download text-primary fs-3'></span></a></td>";
										$record.="</tr>";

							}


					    $from_dt_split=explode("-",$frmDate);
					    $frm_year=$from_dt_split[0];
					    $frm_month=$from_dt_split[1];

					    $to_dt_split=explode("-",$toDate);
					    $to_year=$to_dt_split[0];
					    $to_month=$to_dt_split[1];
					    if($frm_month==$to_month && $frm_year==$to_year)
					    {
					    	$senddtlstable = "az_sendnumbers" .$frm_year.$frm_month;
					    	$extraWhere = "WHERE  master_tbl.userids = {$download_userid} and master_tbl.schedule_sent=1 and (date(master_tbl.sent_at) BETWEEN '" . $frmDate . "' AND '" . $toDate . "')";
					
					    }

					    $start=1;

			for($j=1;$j<=$file_count;$j++)
			{
					$date = date('Ymdhims');
					$path="/var/www/html/itswe_panel/controller/";
	   	
	   		$csfilename ='upload/SEND_JOB_NEW_'.$date.'.csv';
	   		$full_path = $path.$csfilename;

	   		$fh = fopen($full_path, 'w') or die("Can't open file");
	   		chmod($full_path, 0777);
	   		$db_path="https://vapio.in/controller/".$csfilename;
	   		$arr = array('Date','User','Job ID','Message','Chars','Route','Bill Credit','Mobile Number','Status', 'Error Code');	   		
	   		 $sql_file="select date(sent_at) Send_Date,u.client_name User,msg_job_id Job_ID,msgdata Message,route Route,char_count Char_Count,msgcredit Msgcredit,mobile_number Mobile,status Status,err_code Error_Code from $senddtlstable master_tbl inner join az_user u on u.userid=master_tbl.userids $extraWhere limit $start,200000" ;
	   			
	   			$cmd='echo "'.$sql_file.'" | mysql -h localhost -u vapio -p"NcbagqPkhdt#^98ajtd" "vapio" | sed "s/\t/\",\"/g;s/^/\"/;s/$/\"/;s/\n//g" > "'.$full_path.'"';
	   			
	   		$last=shell_exec($cmd);
	   		/*echo $ret;*/

				/*$result=mysqli_query($dbc,$sql_file)or die(mysqli_error($dbc));
				$record_count=mysqli_num_rows($result);*/
				$start=$start+200000;

				$zip->addFile($csfilename);

			}
		}

		$zip->close();
		
			echo $record;
		}
		else
		{
			$record.="<tr>";
					/*$record.="<td>".$row['sent_at']."</td>";*/
					/*$record.="<td>".$username."</td>";*/
			$record.="<td>No record available</td>";
			$record.="</tr>";
			echo $record;
		}
 	}
 	else if($list_type=='download_archive_report')
    	{
    			global $dbc;
		 		
    		$sendtabledetals = SENDSMSDETAILS . CURRENTMONTH;
				$table = $sendtabledetals;

				$extraWhere="";
					 
					if ($_REQUEST['frmDate'] != "" && $_REQUEST['toDate'] != "") {
					    $frmDate = $_REQUEST["frmDate"];
					    $toDate = $_REQUEST["toDate"];


					} else {

					
					}

		    $from_dt_split=explode("-",$frmDate);
		    $frm_year=$from_dt_split[0];
		    $frm_month=$from_dt_split[1];

		    $to_dt_split=explode("-",$toDate);
		     $to_year=$to_dt_split[0];
		    $to_month=$to_dt_split[1];
		    	$sendtabledetals=SENDSMSDETAILS .$frm_year.$frm_month;
		   
		    //$extraWhere.="(date(sent_at) BETWEEN '" . $frmDate . "' AND '" . $toDate . "') ";
		    	$extraWhere.="(sent_at BETWEEN '" . $frmDate . " 00:00:00' AND '" . $toDate . " 23:59:59') ";


				$userid=$_SESSION['user_id'];
				$user_role=$_SESSION['user_role'];
				$login_user_role=$_SESSION['user_role'];
				$selected_role=$_REQUEST['selected_role'];
				$select_user_id=$_REQUEST['select_user_id'];
				$mobile_number=$_REQUEST['mobile_number'];
				$sender_id=$_REQUEST['sender_id'];

					if($user_role=='mds_rs' || $user_role=='mds_ad')
					{
						if($selected_role=='Reseller')
						{
								
									if($select_user_id!="" && $select_user_id!="All")
									{

										$userid_arr1[]=$select_user_id;

											$reseller_ids_arr=get_onlyResellers_new($userid_arr1);
											

											$reseller_ids=implode(",",$reseller_ids_arr);

											if(empty($reseller_ids))
											{
												$reseller_ids=$select_user_id;
											}

											//echo $reseller_ids;

										 $extraWhere.="and parent_id in (".$reseller_ids.") and schedule_sent=1 and (msgcredit>0) ";
										
									}
									else if($select_user_id=="All")
									{
											$userid_arr1[]=$userid;

											$reseller_ids_arr=get_onlyResellers_new($userid_arr1);
											

											$reseller_ids=implode(",",$reseller_ids_arr);

											//echo $reseller_ids;

										 $extraWhere.="and parent_id in (".$reseller_ids.") and schedule_sent=1 and (msgcredit>0) ";
											
									}		


						
						}
						else if($selected_role=='User')
						{
								if($select_user_id!="" && $select_user_id!="All")
									{
										 $extraWhere.="and userids in (".$$select_user_id.") and schedule_sent=1 and (msgcredit>0) ";	
									}
									else if($select_user_id=="All")
									{

											$userid_arr1[]=$userid;

											$reseller_ids_arr=get_onlyResellers_new($userid_arr1);
											$reseller_ids=implode(",",$reseller_ids_arr);

											//echo $reseller_ids;

										 $extraWhere.="and parent_id in (".$reseller_ids.") and schedule_sent=1 and (msgcredit>0) ";

											
									}		

						}

					}
					else if($user_role=='mds_adm')
					{

				
					if($selected_role=="User")
					{
						if($select_user_id!="" && $select_user_id!="All")
						{

							$check_user_ids=$select_user_id;

							$extraWhere.="and userids in (".$check_user_ids.") and schedule_sent=1 and (msgcredit>0) ";
						}
						else if($select_user_id=="All")
						{

					
							$extraWhere.=" and schedule_sent=1 and (msgcredit>0) ";
							
						}

						if($mobile_number!='')
						{
							$extraWhere.=" and mobile_number='".$mobile_number."'";
						}

						if($sender_id!='')
						{
							$extraWhere.=" and senderid='".$sender_id."'";
						}

						$extraWhere.=" group by userids";
					}
				}
				else if($user_role=='mds_usr')
				{
						$extraWhere.=" and userids='$userid'";
						if($mobile_number!='')
						{
							$extraWhere.=" and mobile_number like '%".$mobile_number."%'";
						}

						if($sender_id!='')
						{
							$extraWhere.=" and senderid='".$sender_id."'";
						}

				}
						
				  $sql="select count(1) as total_records from $sendtabledetals where $extraWhere  limit 1";
				
				 

					$result=mysqli_query($dbc,$sql)or die(mysqli_error($dbc));
					
					$row_count=mysqli_num_rows($result);

					// $sql_bill="select sum(msgcredit) as bill from $sendtabledetals where $extraWhere limit 1";
					

					// $result_bill=mysqli_query($dbc,$sql_bill)or die(mysqli_error($dbc));
					
					//$row_count_bill=mysqli_num_rows($result_bill);

					
					
				$total_records=0;
				$total_records_bill=0;
		if($row_count>0)
		{
					$date = date('Ymdhims');

				$fileName = 'upload/Download_'.$date.'_'.$userid.'.zip';
	   			$fname='upload/Download_'.$date.'.zip';
			
	   	$zip = new ZipArchive;
			$result_zip = $zip->open($fileName, ZipArchive::CREATE); 
			if ($result_zip === TRUE) 
			{
					    while($row=mysqli_fetch_array($result))
							{
									 $total_records=$row['total_records'];
							}


							// while($row_bill=mysqli_fetch_array($result_bill))
							// {
							// 		 $total_records_bill=$row_bill['bill'];
							// }
 
							 $record.="<td>".$total_records."</td><td><a href='controller/".$fileName."' download><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-download'><path d='M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4'></path><polyline points='17 8 12 3 7 8'></polyline><line x1='12' y1='3' x2='12' y2='15'></line></svg></a></td>";
							//$record.="<td><a href='controller/".$fileName."' download><span class='fas fa-download text-primary fs-3'></span></a></td>";

							// 			$record.="</tr>";

						$file_count=ceil($total_records/400000);
							

						$start=0;
						for($j=1;$j<=$file_count;$j++)
						{
								$date = date('Ymdhims');
								$path="/var/www/html/itswe_panel/controller/";
				   			//$path="/var/www/html/itswe_panel/controller/upload/";
				   		$csfilename ='upload/SEND_JOB_NEW_'.$date.'.xls';
								//$csfilename ='SEND_JOB_NEW_'.$date.'.csv';
				   		 $full_path = $path.$csfilename;
				   		

				   		 $fh = fopen($full_path, 'w') or die("Can't open file");
				   		
				   		 chmod($full_path, 0777);


				   		// $enclose='\"';
				   		// $terminate='\n';

			   		  $record_query="SELECT 'Job Date', 'Userid', 'Template ID', 'Job ID', 'Chars', 'Route', 'Sender ID', 'Bill Credit', 'Mobile Number', 'Status', 'Error Code', 'Message','DLR Time' UNION ALL
					 		SELECT DATE_FORMAT(sent_at, '%Y-%m-%d %H:%i:%s') AS formatted_sent_at, userids, SUBSTRING_INDEX(metadata, 'TID=', -1), msg_job_id, char_count, route, senderid, msgcredit, mobile_number, status, err_code, msgdata, DATE_FORMAT(FROM_UNIXTIME(delivered_date), '%Y-%m-%d %H:%i:%s') AS formatted_delivered_date from $sendtabledetals where $extraWhere limit $start,400000 ";
			   			

			   			$cmd='echo "'.$record_query.'" | mysql -h localhost -u vapio -p"NcbagqPkhdt#^98ajtd" "vapio"  > "'.$full_path.'"';



					

			   			$last=shell_exec($cmd);
				   			
				   		chmod($full_path, 0777);
				   		
							$start=$start+400000;

							$zip->addFile($csfilename);
							

						}
			}

		$zip->close();
		
			echo $record;
		}
		else
		{
			
			$record.="<tr>";
					/*$record.="<td>".$row['sent_at']."</td>";*/
					/*$record.="<td>".$username."</td>";*/
			$record.="<td>No record available</td>";
			$record.="</tr>";
			echo $record;
		}
 	}
 	else if($list_type=='delete_schedule')
    	{
    		$msg_id=$_REQUEST['msg_id'];
    		$table_name=$_REQUEST['table_name'];

    		$rs=delete_schedule($msg_id,$table_name);

    		if($rs==1)
    		{
    			echo "Schedule Deleted Successfully";
    		}
    		else
    		{
    			echo "Failed to delete Schedule Details";
    		}
    		
    	}
 	else if($list_type=='send_job_summary_report')
    	{
    	
		session_start();		
    	$sendtable = SENDSMS . CURRENTMONTH;
    		/*$sendtabledetals = SENDSMSDETAILS . CURRENTMONTH;*/
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
		    		$sendtable = SENDSMS .$frm_year.$frm_month;
		    		$senddtlstable = SENDSMSDETAILS .$frm_year.$frm_month;
		    		$table = $sendtable;
		    }

		    $extraWhere.="(STR_TO_DATE(sent_at,'%Y-%m-%d') BETWEEN '" . $frmDate . "' AND '" . $toDate . "')";


		} else {
		    $extraWhere="";
		}

		$primaryKey = 'id';

		$columns = array(
		/*	array('db' => 'id', 'dt' => 0),*/
			array('db' => 'job_id', 'dt' => 0,
				'formatter' => function($d, $row) {
					global $table,$sendtabledetals;
					session_start();
					
	        			return "<a href='dashboard.php?page=send_job&job_id=$d&table_name=$table&job_date=$row[1]'>$d</a>";
	        		}
			),
		    	array('db' => 'sent_at', 'dt' => 1, 
		    	'formatter' => function($d, $row) {
	        		return date( 'Y-m-d h:i a', strtotime($d));
	        	}),
	        	array('db' => 'userid','dt' => 2,'formatter' => function($d, $row) {
		   		$username=get_username($d);
	        		return $username;
	        	}),
		    	array('db' => 'route','dt' => 3),
		    	array('db' => 'senderid_name','dt' => 4),
		    	array('db' => 'campaign_name','dt' => 5),
		    	array('db' => 'message','dt' => 6,'formatter' => function($d, $row) {
		   		$msg=urldecode($d);
	        		return $msg;
	        	}),
		   	array('db' => 'msg_credit','dt' => 7,'formatter' => function($d, $row) {
		   		$numbers_count=$row[8];
		   		$form_type=$row[9];
		   		if($form_type!='Dynamic')
		   		{

	        	
	        		return $d*$numbers_count;
		   		}
		   		else
		   		{
		   			return $d;
		   		}
	        	}),
	        	array('db' => 'numbers_count','dt' => 8),
	       /* 	array('db' => 'job_id','dt' => 9,'formatter' => function($d, $row) {
		   		$delivery_count=get_delivery_count($d);
	        		return $delivery_count;
	        	}),*/
	        	array('db' => 'job_id','dt' => 9,'formatter' => function($d, $row) {
		   					return '<button type="button" class="btn btn-primary view_delivery_count" alt="Delievry count" data-item-id="'.$d.'"><i class="fa fa-eye"></i></button><br><b><span id=delivery_count_'.$d.'></b></span>';
	        	}),
		    
		);
		 
		// SQL server connection information
		global $sql_details ;


		$userid=$_SESSION['user_id'];
		$user_role=$_REQUEST['user_role'];
				if($user_role=='mds_rs' || $user_role=='mds_ad')
			{

					$selected_role=$_REQUEST['selected_role'];

				if($selected_role=="User")
				{
					$userid=$_REQUEST['uid'];

					if($userid=="All")
					{
						$parent_id=$_SESSION['user_id'];
						$user_ids=fetch_userids($parent_id);
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
						$user_ids=fetch_userids_by_resellers($check_parent_ids);
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

						$user_ids=fetch_userids_by_resellers($userid);
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
			else if($user_role=='mds_sub_usr')
			{
				$userid=$_REQUEST['uid'];
				if(empty($userid))
				{

				
					if($extraWhere!="") {

						if($userid=='All')
						{
							$extraWhere.=" and `userid` in ('$userid') and schedule_sent='1'";
						}
						else
						{
							$extraWhere.=" and `userid`='$userid' and schedule_sent='1'";
						}
						
					} else {

							if($userid=='All')
						{
							$extraWhere=" `userid` in ('$userid') and schedule_sent='1'";
						}
						else
						{
							$extraWhere=" `userid`='$userid' and schedule_sent='1'";
						}
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
		 //$extraWhere.=" order by created_at desc";
		//  echo $extraWhere;
		echo json_encode(
		    SSP::complex($_REQUEST, $sql_details, $table, $primaryKey, $columns,$test=null, $extraWhere)
		);

 	}
 	 	else if($list_type=='send_job_summary_report1')
    	{
    		/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
    		if (session_status() == PHP_SESSION_NONE) {
				    session_start();
				}
				
    			$sendtable = SENDSMS . CURRENTMONTH;
    		/*$sendtabledetals = SENDSMSDETAILS . CURRENTMONTH;*/
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
		    		$sendtable = SENDSMS .$frm_year.$frm_month;
		    		$senddtlstable = SENDSMSDETAILS .$frm_year.$frm_month;
		    		$table = $sendtable;
		    }

		    $extraWhere.="(STR_TO_DATE(sent_at,'%Y-%m-%d') BETWEEN '" . $frmDate . "' AND '" . $toDate . "')";


		} else {
		    $extraWhere="";
		}

		$primaryKey = 'id';

		$columns = array(
		/*	array('db' => 'id', 'dt' => 0),*/
			array('db' => 'job_id', 'dt' => 0,
				'formatter' => function($d, $row) {
					global $table,$sendtabledetals;
					if (session_status() == PHP_SESSION_NONE) {
				    session_start();
				}
					
	        			return "<a href='dashboard.php?page=send_job&job_id=$d&table_name=$table&job_date=$row[1]'>$d</a>";
	        		}
			),
		    	array('db' => 'sent_at', 'dt' => 1, 
		    	'formatter' => function($d, $row) {
	        		return date( 'Y-m-d h:i a', strtotime($d));
	        	}),
	        	array('db' => 'userid','dt' => 2,'formatter' => function($d, $row) {
		   		$username=get_username($d);
	        		return $username;
	        	}),
		    	array('db' => 'route','dt' => 3),
		    	array('db' => 'senderid_name','dt' => 4),
		    	array('db' => 'campaign_name','dt' => 5),
		    	array('db' => 'message','dt' => 6,'formatter' => function($d, $row) {
		   		$msg=urldecode($d);
	        		return $msg;
	        	}),
		   	array('db' => 'msg_credit','dt' => 7,'formatter' => function($d, $row) {
		   		$numbers_count=$row[8];
		   		$form_type=$row[9];
		   		if($form_type!='Dynamic')
		   		{

	        	
	        		return $d*$numbers_count;
		   		}
		   		else
		   		{
		   			return $d;
		   		}
	        	}),
	        	array('db' => 'numbers_count','dt' => 8),
	       /* 	array('db' => 'job_id','dt' => 9,'formatter' => function($d, $row) {
		   		$delivery_count=get_delivery_count($d);
	        		return $delivery_count;
	        	}),*/
	        	array('db' => 'job_id','dt' => 9,'formatter' => function($d, $row) {
		   					return '<button type="button" class="btn btn-primary view_delivery_count" alt="Delievry count" data-item-id="'.$d.'"><i class="fa fa-eye"></i></button><br><b><span id=delivery_count_'.$d.'></b></span>';
	        	}),
		    
		);
		 
		// SQL server connection information
		global $sql_details ;


		$userid=$_SESSION['user_id'];
		$user_role=$_REQUEST['user_role'];
				if($user_role=='mds_rs' || $user_role=='mds_ad')
			{

					$selected_role=$_REQUEST['selected_role'];

				if($selected_role=="User")
				{
					$userid=$_REQUEST['uid'];

					if($userid=="All")
					{
						$parent_id=$_SESSION['user_id'];
						$user_ids=fetch_userids($parent_id);
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
						$user_ids=fetch_userids_by_resellers($check_parent_ids);
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

						$user_ids=fetch_userids_by_resellers($userid);
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
				if($extraWhere!="") {
					$extraWhere.=" and `userid`='$userid' and schedule_sent='1'";
				} else {

					$extraWhere="`userid`='$userid' and schedule_sent='1'";
				}
			}

		 //$extraWhere.=" order by created_at desc";
			$rs=SSP::complex($_REQUEST, $sql_details, $table, $primaryKey, $columns,$test=null, $extraWhere);
			print_r($rs);
		echo json_encode(
		    SSP::complex($_REQUEST, $sql_details, $table, $primaryKey, $columns,$test=null, $extraWhere)
		);

 	}
 		else if($list_type=='live_job_summary_report')
    	{
    			session_start();
    			$userid=$_SESSION['user_id'];
    			
    				$user_ids=fetch_userids($userid);
    			
					
					$check_user_ids=implode(",",$user_ids);

    			$sendtable = SENDSMS . CURRENTMONTH;
    		/*$sendtabledetals = SENDSMSDETAILS . CURRENTMONTH;*/
		$table = $sendtable;
		$today_dt=date('Y-m-d');
		$extraWhere=" date(sent_at)='".$today_dt."'";
		 
	

		$primaryKey = 'id';

		$columns = array(
		/*	array('db' => 'id', 'dt' => 0),*/
			array('db' => 'job_id', 'dt' => 0,
				'formatter' => function($d, $row) {
					global $table,$sendtabledetals;
					session_start();
					
	        			return "<a href='dashboard.php?page=send_job&job_id=$d&job_date=$row[1]'>$d</a>";
	        		}
			),
		    	array('db' => 'sent_at', 'dt' => 1, 
		    	'formatter' => function($d, $row) {
	        		return date( 'Y-m-d h:i a', strtotime($d));
	        	}),
	        	array('db' => 'userid','dt' => 2,'formatter' => function($d, $row) {
		   		$username=get_username($d);
	        		return $username;
	        	}),
		    	array('db' => 'route','dt' => 3),
		    	array('db' => 'senderid_name','dt' => 4),
		    	array('db' => 'message','dt' => 5,'formatter' => function($d, $row) {
		   		$msg=urldecode($d);
	        		return $msg;
	        	}),
		   	array('db' => 'msg_credit','dt' => 6,'formatter' => function($d, $row) {
		   		$numbers_count=$row[7];
	        		return $d*$numbers_count;
	        	}),
	        	array('db' => 'numbers_count','dt' => 7),
	        	 	array('db' => 'id','dt' => 8,'formatter' => function($d, $row) {

		   		$msg_id=$d;
		   		$job_id=$row[0];
		   		$delivery_count=fetch_delivery_count($job_id,$msg_id);
	    		return $delivery_count;
	        	}),
		    
		);
		 
		// SQL server connection information
		global $sql_details ;


		$userid=$_SESSION['user_id'];
				
		$user_role=$_REQUEST['user_role'];
				if($user_role=='mds_rs' || $user_role=='mds_ad')
			{

					$selected_role=$_REQUEST['selected_role'];

				if($selected_role=="User")
				{
					$userid=$_REQUEST['uid'];

					if($userid=="All")
					{
						$parent_id=$_SESSION['user_id'];
						$user_ids=fetch_userids($parent_id);
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
						$user_ids=fetch_userids_by_resellers($check_parent_ids);
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

						$user_ids=fetch_userids_by_resellers($userid);
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
					if($extraWhere!="") {
						$extraWhere.=" and `userid` in ($userid) and schedule_sent='1'";
					} else {

						$extraWhere="`userid` in ($userid) and schedule_sent='1'";
					}
			}
		 
		echo json_encode(
		    SSP::complex($_REQUEST, $sql_details, $table, $primaryKey, $columns,$test=null, $extraWhere)
		);

 	}
 	else if($list_type=='rcs_job_summary_report')
    	{
    			session_start();
				
    			$sendtable = RCSJOBS . CURRENTMONTH;
    		/*$sendtabledetals = SENDSMSDETAILS . CURRENTMONTH;*/
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
		    		$sendtable = RCSJOBS .$frm_year.$frm_month;
		    		$senddtlstable = RCSMASTER .$frm_year.$frm_month;
		    		$table = $sendtable;
		    }

		    $extraWhere.="(STR_TO_DATE(sent_at,'%Y-%m-%d') BETWEEN '" . $frmDate . "' AND '" . $toDate . "')";


		} else {
		    $extraWhere="";
		}

		$primaryKey = 'id';

		$columns = array(
			array('db' => 'id', 'dt' => 0),
			array('db' => 'job_id', 'dt' => 1,
				'formatter' => function($d, $row) {
					global $table,$sendtabledetals;
					session_start();
					
	  	return "<a href='dashboard.php?page=rcs_job&job_id=$d&table_name=$table&job_date=$row[2]'>$d</a>";
	        		}
			),
		    	array('db' => 'sent_at', 'dt' => 2, 
		    	'formatter' => function($d, $row) {
	        		return date( 'Y-m-d h:i a', strtotime($d));
	        	}),
	        	array('db' => 'userid','dt' => 3,'formatter' => function($d, $row) {
		   		$username=get_username($d);
	        		return $username;
	        	}),
		    	array('db' => 'template_name','dt' => 4),
		   	array('db' => 'msg_credit','dt' => 5,'formatter' => function($d, $row) {
		   		
	        		return $d;
	        	}),
	        	array('db' => 'numbers_count','dt' => 6),
		    
		);
		 
		// SQL server connection information
	  global $sql_details ;


		$userid=$_SESSION['user_id'];

		if($extraWhere!="") {
			$extraWhere.=" and `userid`='$userid' and schedule_sent='1'";
		} else {

			$extraWhere="`userid`='$userid' and schedule_sent='1'";
		}
		 
		echo json_encode(
		    SSP::complex($_REQUEST, $sql_details, $table, $primaryKey, $columns,$test=null, $extraWhere)
		);

 	}
 	else if($list_type=='send_job_report')
    	{


		$sendtabledetals = SENDSMSDETAILS . CURRENTMONTH;
		$table = $sendtabledetals;
		$primaryKey = 'id';

		$columns = array(
			array('db' => 'id', 'dt' => 0,
				'formatter' => function($d, $row) {
	        			return "<a href='view/report_blank.php?id=$d'>$d</a>";
	        		}
			),
		    	array('db' => 'sent_at', 'dt' => 1, 
		    	'formatter' => function($d, $row) {
	        		return date( 'Y-m-d h:i a', strtotime($d));
	        	}),
		    	array('db' => 'route','dt' => 2),
		    	array('db' => 'senderid','dt' => 3),
		    	array('db' => 'msgdata','dt' => 4),
		    	array('db' => 'msgcredit','dt' => 5),
		    	array('db' => 'status','dt' => 6)
		);
		 
		// SQL server connection information
		global $sql_details ;

		$extraWhere="";
		 
		if ($_REQUEST['frmDate'] != "" && $_REQUEST['toDate'] != "") {
		    $frmDate = $_REQUEST["frmDate"];
		    $toDate = $_REQUEST["toDate"];
		    $extraWhere.="(STR_TO_DATE(sent_at,'%Y-%m-%d') BETWEEN '" . $frmDate . "' AND '" . $toDate . "')";
		} else {
		    $extraWhere="";
		}

		$userid=$_SESSION['user_id'];

		if($extraWhere!="") {
			$extraWhere.=" and `userids`='$userid'";
		} else {

			$extraWhere.="`userids`='$userid'";
		}
		 
		echo json_encode(
		    SSP::complex($_REQUEST, $sql_details, $table, $primaryKey, $columns,$test=null, $extraWhere)
		);

 	}
 	else if($list_type=='send_job_data')
    {

    	$rs=load_send_job_data();
    //	print_r($rs);
    	$rs1=load_status($rs);
    //	print_r($rs1);
    	if($rs1!=0)
    	{
    			$res=array_merge($rs,$rs1);
    	}
    
  
   	if($res!=0)
    	{
    		echo json_encode($res);
    	}
    	else
    	{
    		//echo 0;
    	}

    }
 	else if($list_type=='rcs_job_data')
    {

    	$rs=load_rcs_job_data();
    //	print_r($rs);
    	$rs1=load_rcs_status($rs);
    //	print_r($rs1);
    	if($rs1!=0)
    	{
    			$res=array_merge($rs,$rs1);
    	}
    
  
   	if($res!=0)
    	{
    		echo json_encode($res);
    	}
    	else
    	{
    		//echo 0;
    	}

    }
    else if($list_type=='send_job_table_dtls')
    {
    			global $dbc;
    			$rs=load_send_job_data();
    			$job_id=$_REQUEST['job_id'];
    			$message_job_id=$rs[0]['job_id'];

    			$message_id=$rs[0]['id'];
    			$sendtabledetals = SENDSMSDETAILS;
    			$job_date=date("Y-m-d",strtotime($_REQUEST['job_date']));
    
		   	$today_dt=date("Y-m-d");

		   	$yesterday_dt=date("Y-m-d",strtotime("-1 day"));
		   	if($job_date!=$today_dt)
		   	{
		   		$report_yr=date("Y",strtotime($job_date));
		   		$report_mt=date("m",strtotime($job_date));
		   		$sendtabledetals=SENDSMSDETAILS.$report_yr.$report_mt;
		   	}
		   	 	/*if($job_date==$yesterday_dt)
			   	{
			   		
			   		$report_yr=date("Y",strtotime($job_date));
			   		$report_mt=date("m",strtotime($job_date));
			   		$sendtable=SENDSMS.$report_yr.$report_mt;
			   	}*/


			$today_dt=date('Y-m-d');
    	
			$table = $sendtabledetals;

			$primaryKey = 'id';

			$columns = array(
			array( 'db' => 'id','dt' => 0 ),
			    array( 'db' => 'route','dt' => 1 ),
			    array( 'db' => 'mobile_number','dt' => 2 ,'formatter' => function( $d, $row ) {

			    				global $restricted_report;
			    				if($restricted_report=='Yes')
			    				{
			    					$count_len=strlen($d);
			    					return substr($d, 0, $count_len-6)."XXXXXX";
			    				} 
			    				else
			    				{
			    					 return $d;
			    				}
			           
			        } ),
			    array( 'db' => 'msgdata','dt' => 3 ,'formatter' => function( $d, $row ) {

			    			$msg=urldecode($d);
			    				return "<div style='word-break: break-all;'>$msg</div>";
			           
			        }),
			    array( 'db' => 'char_count','dt' => 4 ),
			    array( 'db' => 'msgcredit','dt' => 5),
			    array( 'db' => 'master_job_id','dt' => 6),
			   /* array( 'db' => 'id','dt' => 7),*/
			    array( 'db' => 'status','dt' => 7),
			    array( 'db' => 'sent_at','dt' => 8),
			    array( 'db' => 'delivered_date','dt' => 9,'formatter' => function( $d, $row ) {

			    		if($row[7]!='Submitted')
			    		{
			    			if($d=="0" or $d==NULL)
			    			{
			    				$randomSeconds = rand(0, 59);
			    				$new_time=strtotime($row[8]);
			    				$newdateTime = strtotime("+$randomSeconds seconds", $new_time);
			    				$dateTime = date('Y-m-d h:i a', $newdateTime);
			    			}
			    			else
			    			{
			    				$dateTime = date('Y-m-d h:i a', $d);
			    			}
			    			
			    			return $dateTime;
			    		}
			    		else
			    		{
			    				$dateTime="-";
			    				return $dateTime;

			    		}


			           
			        }),
			    array( 'db' => 'err_code','dt' => 10)
			   /* array( 'db' => 'id','dt' => 11)*/
			   
			);
			 
			// SQL server connection information
			global $sql_details ;

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

			/*if($extraWhere!="")
			{
				$extraWhere.=" and `userids`='$userid'";
			}
			else
			{

				$extraWhere="`userids`='$userid'";
			}*/
			 

			 if($job_id!='')
			 {
			 		if($extraWhere!="")
					{
						$extraWhere.="  and msg_job_id='$message_job_id'";
					}
					else
					{

						$extraWhere=" msg_job_id='$message_job_id'";
					}
			 }
			echo json_encode(
			    SSP::complex( $_REQUEST, $sql_details, $table, $primaryKey, $columns,$test=null,$extraWhere )
			);


    }
     else if($list_type=='rcs_job_table_dtls')
    {
    			global $dbc;
    			$rs=load_rcs_job_data();
    			$job_id=$_REQUEST['job_id'];

    			$message_id=$rs[0]['id'];
    			$message_job_id=$rs[0]['job_id'];
    			$sendtabledetals = RCSMASTER;
    			$job_date=date("Y-m-d",strtotime($_REQUEST['job_date']));
    
		   	$today_dt=date("Y-m-d");

		   	$yesterday_dt=date("Y-m-d",strtotime("-1 day"));
		   	if($job_date!=$today_dt && $job_date!=$yesterday_dt)
		   	{
		   		$report_yr=date("Y",strtotime($job_date));
		   		$report_mt=date("m",strtotime($job_date));
		   		$sendtabledetals=RCSMASTER.$report_yr.$report_mt;
		   	}
		   	 	if($job_date==$yesterday_dt)
			   	{
			   		
			   		$report_yr=date("Y",strtotime($job_date));
			   		$report_mt=date("m",strtotime($job_date));
			   		$sendtable=RCSJOBS.$report_yr.$report_mt;
			   	}


			$today_dt=date('Y-m-d');
    	
			$table = $sendtabledetals;

			$primaryKey = 'id';

			$columns = array(
			array( 'db' => 'id','dt' => 0 ),
			  /*  array( 'db' => 'route','dt' => 1 ),*/
			    array( 'db' => 'mobile_number','dt' => 1,'formatter' => function( $d, $row ) {

			    				global $restricted_report;
			    				if($restricted_report=='Yes')
			    				{
			    					$count_len=strlen($d);
			    					return substr($d, 0, $count_len-6)."XXXXXX";
			    				} 
			    				else
			    				{
			    					 return $d;
			    				}
			           
			        } ),
			    /*array( 'db' => 'circle','dt' => 3 ),*/
			  
			    array( 'db' => 'msgcredit','dt' => 2),
			    array( 'db' => 'master_job_id','dt' => 3),
			   /* array( 'db' => 'id','dt' => 7),*/
			    
			    array( 'db' => 'sent_at','dt' => 4),
			    array( 'db' => 'status','dt' => 5)
			  
			   /* array( 'db' => 'id','dt' => 11)*/
			   
			);
			 
			// SQL server connection information
		global $sql_details ;

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
						$extraWhere.="  and msg_job_id='$message_job_id'";
					}
					else
					{

						$extraWhere=" msg_job_id='$message_job_id'";
					}
			 }
			echo json_encode(
			    SSP::complex( $_REQUEST, $sql_details, $table, $primaryKey, $columns,$test=null,$extraWhere )
			);


    }
 		else if($list_type=='schedule_report')
    {

    	$sendtabledetals = SENDSMSDETAILS;
    		
			$table =SENDSMS.CURRENTMONTH;
			$userid=$_SESSION['user_id'];
			$select_user_id=$_REQUEST['u_id'];
			$user_role=$_REQUEST['user_role'];
			$login_user_role=$_SESSION['user_role'];
			
			$u_id=$_REQUEST['u_id'];
			$today_dt=date('Y-m-d');


			$primaryKey = 'id';

			$columns = array(
				array( 'db' => 'id','dt' => 0 ),			   
			    array( 'db' => 'userid','dt' => 1 ,'formatter' => function( $d, $row ) {
			            $username=get_username($d);
	        			  return $username;
			        }),
			    array( 'db' => 'job_id','dt' => 2 /*,'formatter' => function($d, $row) {
					global $table,$sendtabledetals;
					session_start();
					
	        			return "<a href='dashboard.php?page=send_job&job_id=$d&table_name=$table&job_date=$row[2]'>$d</a>";
	        		}*/),
			    array('db' => 'message','dt' => 3,'formatter' => function($d, $row) {
		   		$msg=urldecode($d);
	        		return $msg;
	        	}),
			    array(
			        'db'        => 'created_at',
			        'dt'        => 4,
			        'formatter' => function( $d, $row ) {
			            return date( 'Y-m-d h:i a', strtotime($d));
			        }
			    ),
			      array(
			        'db'        => 'sent_at',
			        'dt'        => 5,
			        'formatter' => function( $d, $row ) {
			            return date( 'Y-m-d h:i a', strtotime($d));
			        }
			    ),
			       array( 'db' => 'msg_credit','dt' =>6,'formatter' => function( $d, $row ) {
			            return $d*$row[8];
			        }),
			        array( 'db' => 'id','dt' =>7,'formatter' => function( $d, $row ) {
			        	global $table;
			            return "<button class='btn btn-primary me-1 mb-1 delete_message_job_btn' type='button' data-id='".$d."' data-tblname='".$table."'>
                    <span class='fas fa-trash ms-1' data-fa-transform='shrink-3'></span>
                  </button>";
			        }),
			         array( 'db' => 'numbers_count','dt' => 8),
			);
			 
			// SQL server connection information
			global $sql_details ;

			$extraWhere="";
			 
			if ($_REQUEST['frmDate'] != "" && $_REQUEST['toDate'] != "") {
			    $frmDate = $_REQUEST["frmDate"];
			    $toDate = $_REQUEST["toDate"];
			    $extraWhere.="(date(sent_at) BETWEEN '" . $frmDate . "' AND '" . $toDate . "')";

			     $from_dt_split=explode("-",$frmDate);
		    $frm_year=$from_dt_split[0];
		    $frm_month=$from_dt_split[1];

		    $to_dt_split=explode("-",$toDate);
		     $to_year=$to_dt_split[0];
		    $to_month=$to_dt_split[1];

		    if($frm_month==$to_month && $frm_year==$to_year)
		    {
		    		$sendtable = SENDSMS .$frm_year.$frm_month;
		    		
		    		$table = $sendtable;
		    }
			}
			else
			{
					$frmDate=$today_dt;
					$toDate=$today_dt;
			    $extraWhere.="(date(sent_at) BETWEEN '" . $frmDate . "' AND '" . $toDate . "')";
			}

			/*	if($user_role=='mds_rs' || $user_role=='mds_ad')
				{
					$selected_role=$_REQUEST['selected_role'];
					if($selected_role=="User")
					{
						
						if($select_user_id=="All")
						{
							$parent_id=$_SESSION['user_id'];
							$user_ids=fetch_userids($parent_id);
							$check_user_ids=implode(",",$user_ids);

							$extraWhere. = " and userid in ('".$check_user_ids."') and schedule_sent=0 and is_scheduled=1";
						}
						else
						{
							$extraWhere. = " and userid='".$select_user_id."' and schedule_sent=0 and is_scheduled=1";
						}
					}
				}
			else*/ 
			if($user_role=='mds_adm')
				{		
						$selected_role=$_REQUEST['selected_role'];
						if($selected_role=="User")
						{
							if($select_user_id!="" && $select_user_id!="All")
							{
								$check_user_ids=$select_user_id;
								$extraWhere.=" and userid in (".$check_user_ids.") and schedule_sent=0 and is_scheduled=1";
							}
							else
							{
								$extraWhere.=" and schedule_sent=0 and is_scheduled=1";
							}
						}
					else if($selected_role=="Reseller")
						{
							if($select_user_id=='All')
							{
								$all_resellers=fetch_allresellers();

								$userid_arr=$all_resellers;
				                    $child_users=get_childUsers($userid_arr);

				                      foreach ($child_users as $child_val) {
				                        foreach($child_val as $val)
				                        {
				                          $single_arr[]=$val;
				                        }
				                      }

				                     
				                      $single_arr=array_unique($single_arr);
				                   // $only_resellers=get_onlyResellers($single_arr);
				                      if(!empty($single_arr))
				                      {
				                      	 $check_user_ids=implode(",",$single_arr);
				                      }

				        $check_user_ids=implode(",",$all_resellers);
								
								$extraWhere.=" and userid in (".$check_user_ids.") and schedule_sent=0 and is_scheduled=1";
							}
							else
							{

									$userid_arr[]=$select_user_id;
				                    $child_users=get_childUsers($userid_arr);

				                      foreach ($child_users as $child_val) {
				                        foreach($child_val as $val)
				                        {
				                          $single_arr[]=$val;
				                        }
				                      }

				                      $single_arr[]=$select_user_id;
				                      $single_arr=array_unique($single_arr);
				                    //$only_resellers=get_onlyResellers($single_arr);
				                      if(!empty($single_arr))
				                      {
				                      	 $check_user_ids=implode(",",$single_arr);
				                      }
				                     
								 $extraWhere.=" and userid in (".$check_user_ids.") and schedule_sent=0 and is_scheduled=1";
							}
						}
						else if($selected_role=="Admin")
							{
								if($select_user_id=='All')
								{
									$all_admins=fetch_alladmins();

									$userid_arr=$all_admins;
									
					        $child_users=get_childUsers($userid_arr);

					                      foreach ($child_users as $child_val) {
					                        foreach($child_val as $val)
					                        {
					                          $single_arr[]=$val;
					                        }
					                      }


					                    $single_arr=array_unique($single_arr);
					                    //$only_resellers=get_onlyResellers($single_arr);
					                      if(!empty($single_arr))
					                      {
					                      	 $check_user_ids=implode(",",$single_arr);
					                      }
								 $extraWhere.=" and userid in (".$check_user_ids.") and schedule_sent=0 and is_scheduled=1";
								}
								else
								{

										$userid_arr[]=$select_user_id;
					                    $child_users=get_childUsers($userid_arr);

					                      foreach ($child_users as $child_val) {
					                        foreach($child_val as $val)
					                        {
					                          $single_arr[]=$val;
					                        }
					                      }

					                     $single_arr[]=$select_user_id;
					                      $single_arr=array_unique($single_arr);
					                   // $only_resellers=get_onlyResellers($single_arr);
					                      if(!empty($single_arr))
					                      {
					                      	 $check_user_ids=implode(",",$single_arr);
					                      }
					                     
									 $extraWhere.=" and userid in (".$check_user_ids.") and schedule_sent=0 and is_scheduled=1";
								}
							}
				}
				else if($user_role=='mds_sub_usr')
				{

						if($u_id=='All')
						{
								$user_tree=$_SESSION['user_tree'];
								$userid = $user_tree;
						 		if($extraWhere!="")
											{
												$extraWhere.=" and `userid` in ($userid) and schedule_sent=0 and is_scheduled=1 ";
											}
											else
											{
												$extraWhere="`userid` in ($userid) and schedule_sent=0 and is_scheduled=1 ";
											}
						}
						else
						{
								$userid = $u_id;
						 		if($extraWhere!="")
											{
												$extraWhere.=" and `userid` in ($userid) and schedule_sent=0 and is_scheduled=1 ";
											}
											else
											{
												$extraWhere="`userid` in ($userid) and schedule_sent=0 and is_scheduled=1 ";
											}
						}

				}
				else if($user_role=='mds_rs' || $user_role=='mds_ad')
				{
						$selected_role=$_REQUEST['selected_role'];
						//$select_user_id=$_REQUEST['u_id'];
						if($selected_role=="User")
						{
							if($select_user_id=="All")
							{
								$userid=$_SESSION['user_id'];
								$userid_arr[]=$userid;
                $child_users=get_childUsers($userid_arr);
                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                     
                      $single_arr=array_unique($single_arr);
                     // $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($single_arr))
                      {
                      	 $check_user_ids=implode(",",$single_arr);
                      }
								
                   if(!empty($check_user_ids))
                   {
	                   		if($extraWhere!="")
											{
												$extraWhere.=" and `userid` in ($check_user_ids) and schedule_sent=0 and is_scheduled=1 ";
											}
											else
											{
												$extraWhere="`userid` in ($check_user_ids) and schedule_sent=0 and is_scheduled=1 ";
											}
                   }
							}
							else
							{
									$userid=$_REQUEST['u_id'];
                   	if($extraWhere!="")
											{
												$extraWhere.=" and `userid`=$userid and schedule_sent=0 and is_scheduled=1 ";
											}
											else
											{
												$extraWhere="`userid`=$userid and schedule_sent=0 and is_scheduled=1 ";
											}
							}
						}
						else if($selected_role=="Reseller")
						{
							if($select_user_id=="All")
							{
								$userid=$_SESSION['user_id'];

								$userid_arr[]=$userid;
                $child_users=get_childUsers($userid_arr);
                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                     
                      $single_arr=array_unique($single_arr);
                     // $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($single_arr))
                      {
                      	 $check_user_ids=implode(",",$single_arr);
                      }

                   if(!empty($check_user_ids))
                   {
	                   		if($extraWhere!="")
											{
												$extraWhere.=" and `userid` in ($check_user_ids) and schedule_sent=0 and is_scheduled=1 ";
											}
											else
											{
												$extraWhere="`userid` in ($check_user_ids) and schedule_sent=0 and is_scheduled=1 ";
											}
                   }
                   else
                   {
                   			if($extraWhere!="")
											{
												$extraWhere.=" and `userid` in ($userid) and schedule_sent=0 and is_scheduled=1 ";
											}
											else
											{
												$extraWhere="`userid` in ($userid) and schedule_sent=0 and is_scheduled=1 ";
											}
                   }
										


							
							}
							else
							{
								$userid=$_REQUEST['u_id'];

								$userid_arr[]=$userid;
                $child_users=get_childUsers($userid_arr);
                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                     
                      $single_arr=array_unique($single_arr);
                     // $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($single_arr))
                      {
                      	 $check_user_ids=implode(",",$single_arr);
                      }

                   if(!empty($check_user_ids))
                   {
	                   		if($extraWhere!="")
											{
												$extraWhere.=" and `userid` in ($check_user_ids) and schedule_sent=0 and is_scheduled=1 ";
											}
											else
											{
												$extraWhere="`userid` in ($check_user_ids) and schedule_sent=0 and is_scheduled=1 ";
											}
                   }
                   else
                   {
                   			if($extraWhere!="")
											{
												$extraWhere.=" and `userid` in ($userid) and schedule_sent=0 and is_scheduled=1 ";
											}
											else
											{
												$extraWhere="`userid` in ($userid) and schedule_sent=0 and is_scheduled=1 ";
											}
                   }
									
							}
						}

					
				}
				else
				{
					$extraWhere.=" and `userid`='$userid' and is_scheduled=1 and schedule_sent=0";
				}
			/*		$selected_role=$_REQUEST['selected_role'];
					if($selected_role=="User")
					{
						if($select_user_id!="" && $select_user_id!="All")
						{
							$check_user_ids=$select_user_id;
							$extraWhere.=" and userid in (".$check_user_ids.") and schedule_sent=0 and is_scheduled=1";
						}
						else
						{
							$extraWhere.=" and schedule_sent=0 and is_scheduled=1";
						}
					}
					else if($selected_role=="Admin")
					{
						if($select_user_id=='All')
						{
							$all_admins=fetch_alladmins();

							$userid_arr=$all_admins;
							
			        $child_users=get_childUsers($userid_arr);

			                      foreach ($child_users as $child_val) {
			                        foreach($child_val as $val)
			                        {
			                          $single_arr[]=$val;
			                        }
			                      }


			                    $single_arr=array_unique($single_arr);
			                    //$only_resellers=get_onlyResellers($single_arr);
			                      if(!empty($single_arr))
			                      {
			                      	 $check_user_ids=implode(",",$single_arr);
			                      }
						 $extraWhere.=" and userid in (".$check_user_ids.") and schedule_sent=0 and is_scheduled=1";
						}
						else
						{

								$userid_arr[]=$select_user_id;
			                    $child_users=get_childUsers($userid_arr);

			                      foreach ($child_users as $child_val) {
			                        foreach($child_val as $val)
			                        {
			                          $single_arr[]=$val;
			                        }
			                      }

			                     $single_arr[]=$select_user_id;
			                      $single_arr=array_unique($single_arr);
			                   // $only_resellers=get_onlyResellers($single_arr);
			                      if(!empty($single_arr))
			                      {
			                      	 $check_user_ids=implode(",",$single_arr);
			                      }
			                     
							 $extraWhere.=" and userid in (".$check_user_ids.") and schedule_sent=0 and is_scheduled=1";
						}
					}
					else if($selected_role=="Reseller")
					{
						if($select_user_id=='All')
						{
							$all_resellers=fetch_allresellers();

			       // $check_user_ids=implode(",",$all_resellers);
									$userid_arr=$all_resellers;
			                    $child_users=get_childUsers($userid_arr);

			                      foreach ($child_users as $child_val) {
			                        foreach($child_val as $val)
			                        {
			                          $single_arr[]=$val;
			                        }
			                      }

			                     
			                      $single_arr=array_unique($single_arr);
			                   // $only_resellers=get_onlyResellers($single_arr);
			                      if(!empty($single_arr))
			                      {
			                      	 $check_user_ids=implode(",",$single_arr);
			                      }
			                     
							 $extraWhere.=" and userid in (".$check_user_ids.") and schedule_sent=0 and is_scheduled=1";
							
						}
						else
						{

								$userid_arr[]=$select_user_id;
			                    $child_users=get_childUsers($userid_arr);

			                      foreach ($child_users as $child_val) {
			                        foreach($child_val as $val)
			                        {
			                          $single_arr[]=$val;
			                        }
			                      }

			                      //$single_arr[]=$select_user_id;
			                      $single_arr=array_unique($single_arr);
			                   // $only_resellers=get_onlyResellers($single_arr);
			                      if(!empty($single_arr))
			                      {
			                      	 $check_user_ids=implode(",",$single_arr);
			                      }
			                     
							 $extraWhere.=" and userid in (".$check_user_ids.") and schedule_sent=0 and is_scheduled=1";
						}
					}
					else if($selected_role=='All')
					{
							//$extraWhere. = " and schedule_sent=0 and is_scheduled=1";
					}*/
			
		/*	else if($user_role=='mds_rs' || $user_role=='mds_ad')
			{
				$selected_role=$_REQUEST['selected_role'];
				if($selected_role=="User")
				{
					
					if($u_id=="All")
					{
						$parent_id=$_SESSION['user_id'];
						$user_ids=fetch_userids($parent_id);
						$check_user_ids=implode(",",$user_ids);

						$extraWhere. = " and userid in ('".$check_user_ids."') and schedule_sent=0 and is_scheduled=1";
					}
					else
					{
						$extraWhere. = " and userid='".$select_user_id."' and schedule_sent=0 and is_scheduled=1";
					}
				}
			}*/
			
	

		
		



			echo json_encode(
			    SSP::complex( $_REQUEST, $sql_details, $table, $primaryKey, $columns,$test=null,$extraWhere )
			);

 	}

}
function fetch_userids($u_id)
{
	global $dbc;

	//echo "dzsf ".$u_id;
	
	$u_id=$_SESSION['user_id'];
	if($u_id!=1)
	{
		$sql="select userid from az_user where parent_id='".$u_id."' and user_role='mds_usr' and user_status=1";
	}
	else
	{
		$sql="select userid from az_user where user_role='mds_usr' and user_status=1";
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


function fetch_userids1($u_id)
{
	global $dbc;

	//echo "dzsf ".$u_id;
	
	$u_id=$_SESSION['user_id'];
	if($u_id!=1)
	{
		$sql="select userid from az_user where parent_id='".$u_id."' and user_status=1";
	}
	else
	{
		$sql="select userid from az_user where user_role='mds_usr' and user_status=1";
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



function get_username($uid)
{
	global $dbc;
	$sql="select * from az_user where userid='".$uid."' and user_status=1";

	$result=mysqli_query($dbc,$sql);
	while ($row=mysqli_fetch_array($result)) {
		$uname=$row['user_name'];
	}

	return $uname;
}

function get_delivery_count($job_id)
{
	global $dbc;
	$delivery_count = 0;
	$month = $_REQUEST['month'];
	$sql="select sum(`msgcredit`) as delivery_count from az_sendnumbers where msg_job_id='".$job_id."' and `status`='Delivered'";

	$result=mysqli_query($dbc,$sql);
	while ($row=mysqli_fetch_array($result)) {
		$delivery_count=$row['delivery_count'];
	}

	if(($delivery_count==0 || $delivery_count == '') && $month == 0)
	{	
		$sendtabledetals=SENDSMSDETAILS.CURRENTMONTH;

			$sql="select sum(`msgcredit`) as delivery_count from $sendtabledetals where msg_job_id='".$job_id."' and `status`='Delivered'";

		$result=mysqli_query($dbc,$sql);
		while ($row=mysqli_fetch_array($result)) {
			$delivery_count=$row['delivery_count'];
		}
	}
	else
	{
		if($month > 0)
		{	
			$yr = date('Y');
			if($month<10)
			{
				$month = str_pad($month, 2, '0', STR_PAD_LEFT); 
			}
			$sendtabledetals=SENDSMSDETAILS.$yr.$month;

				$sql="select sum(`msgcredit`) as delivery_count from $sendtabledetals where msg_job_id='".$job_id."' and `status`='Delivered'";

			$result=mysqli_query($dbc,$sql);
			while ($row=mysqli_fetch_array($result)) {
				$delivery_count=$row['delivery_count'];
			}
		}
	}


	return $delivery_count;
}

function fetch_delivery_count($job_id,$msg_id)
{
	global $dbc;
	$sendtabledetals=SENDSMSDETAILS;
	$sql="select count(msgcredit) as count_delivered from $sendtabledetals where msg_job_id='".$job_id."' and message_id='".$msg_id."' and status='Delivered'";

	$result=mysqli_query($dbc,$sql);
	while ($row=mysqli_fetch_array($result)) {
		$count_delivered=$row['count_delivered'];
	}

	return $count_delivered;
}

function delete_schedule($msg_id,$table_name)
{
	global $dbc;
	$sql_select="select * from $table_name where id='".$msg_id."'";

	$result_select=mysqli_query($dbc,$sql_select);
	while($row_select=mysqli_fetch_array($result_select))
	{
		$msgcredit=$row_select['msg_credit']*$row_select['numbers_count'];
		$user_id=$row_select['userid'];
		$job_id=$row_select['job_id'];
		$route_name=$row_select['route'];

	}

	$route_id=fetch_routeid($route_name);
	$sql="delete from $table_name where id='".$msg_id."'";

	$result=mysqli_query($dbc,$sql);

	if($result)
	{

		$sql2="delete from az_sendnumbers where message_id='".$msg_id."'";
		$result2=mysqli_query($dbc,$sql2);

		$sql_smart="delete from smart_cutoff where job_id='".$job_id."' and userid='".$user_id."'";
		$result_smart=mysqli_query($dbc,$sql_smart);

	      $sql_select1 = "SELECT * from az_credit_manage where `userid`='$user_id' and `az_routeid`='$route_id'";
	      $query_select = mysqli_query($dbc, $sql_select1);
	      $count_plan=mysqli_num_rows($query_select);

        	while($row=mysqli_fetch_array($query_select))
	     {
	        		$prev_bal=$row['balance'];
	        		$crm_id=$row['crmid'];
	     }

	        	$balance=$prev_bal+$msgcredit;
	        	$update_credit_manage = "update `az_credit_manage` set `debit_credit`='1' , `assign_credit`='$msgcredit',`balance`='$balance',`remark`='Re-credit for schedule $job_id',`credit_date`=now(),`created`=now(),`created_by`='".$_SESSION['user_id']."' where crmid=$crm_id";
		     $query = mysqli_query($dbc, $update_credit_manage)or die(mysqli_error($dbc));

		     $sql_details = "INSERT INTO `az_credit_details`(`crmdid`,`userid`,`debit_credit`,`assign_credit`,`balance`,`remark`,`credit_date`,`created`,`created_by`) VALUES('".$crm_id."','".$user_id."','1','".$msgcredit."','".$balance."','Re-credit for schedule $job_id',now(),now(),'".$_SESSION['user_id']."')";
	          $query_dtls = mysqli_query($dbc, $sql_details)or die(mysqli_error($dbc));


		return 1;
	}
	else
	{
		return 0;
	}
	
}
function load_send_job_data()
{
	global $dbc;
	$sendtable = SENDSMS . CURRENTMONTH;
    		
	
   	$job_id=$_REQUEST['job_id'];
   	$table_name=$_REQUEST['table_name'];
   	$job_date=date("Y-m-d",strtotime($_REQUEST['job_date']));
    
   	$today_dt=date("Y-m-d");

   	$yesterday_dt=date("Y-m-d",strtotime("-1 day"));
   	if($job_date!=$today_dt )
   	{
   		$report_yr=date("Y",strtotime($job_date));
   		$report_mt=date("m",strtotime($job_date));
   		$sendtable=SENDSMS.$report_yr.$report_mt;
   	}

   /*	if($job_date==$yesterday_dt)
   	{

   		$report_yr=date("Y",strtotime($job_date));
   		$report_mt=date("m",strtotime($job_date));
   		$sendtable=SENDSMS.$report_yr.$report_mt;
   	}*/

	$sql="select * from $sendtable where job_id='".$job_id."'";
	$values=mysqli_query($dbc,$sql);
	$count_record=mysqli_num_rows($values);
	if($count_record>0)
	{
		
		while($row=mysqli_fetch_array($values))
		{
			$id = $row['id'];
	          $result[0] = $row;
	          $result[1]['msg']=urldecode($row['message']);

		}
		//$result=array_merge($result,$result2);
		return $result;
	}
	else
	{
		echo 0;
	}
	

}

function fetch_routeid($route_name)
{
	global $dbc;
	$sql="select az_routeid from az_routetype where az_rname='$route_name'";
	$result=mysqli_query($dbc,$sql);
	while($row=mysqli_fetch_array($result))
	{
		$route_id=$row['az_routeid'];

	}
	return $route_id;
}

function load_rcs_job_data()
{
	global $dbc;
	$sendtable = RCSJOBS . CURRENTMONTH;
    		
	
   	$job_id=$_REQUEST['job_id'];
   	$table_name=$_REQUEST['table_name'];
   	$job_date=date("Y-m-d",strtotime($_REQUEST['job_date']));
    
   	$today_dt=date("Y-m-d");

   	$yesterday_dt=date("Y-m-d",strtotime("-1 day"));
   	if($job_date!=$today_dt && $job_date!=$yesterday_dt)
   	{
   		$report_yr=date("Y",strtotime($job_date));
   		$report_mt=date("m",strtotime($job_date));
   		$sendtable=RCSJOBS.$report_yr.$report_mt;
   	}

   	if($job_date==$yesterday_dt)
   	{

   		$report_yr=date("Y",strtotime($job_date));
   		$report_mt=date("m",strtotime($job_date));
   		$sendtable=RCSJOBS.$report_yr.$report_mt;
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


function load_status($job_result)
{
	global $dbc;
	$sendtabledetals = SENDSMSDETAILS;
   
	$message_id=$job_result[0]['id'];
	$message_job_id=$job_result[0]['job_id'];
   	$job_id=$_REQUEST['job_id'];
   	$job_date=date("Y-m-d",strtotime($_REQUEST['job_date']));
    
   	 $today_dt=date("Y-m-d");

   	$yesterday_dt=date("Y-m-d",strtotime("-1 day"));
   	if($job_date!=$today_dt)
   	{
   		$report_yr=date("Y",strtotime($job_date));
   		$report_mt=date("m",strtotime($job_date));
   		$sendtabledetals=SENDSMSDETAILS.$report_yr.$report_mt;
   	}

   /*	if($job_date==$yesterday_dt)
   	{
   		
   		$report_yr=date("Y",strtotime($job_date));
   		$report_mt=date("m",strtotime($job_date));
   		$sendtable=SENDSMS.$report_yr.$report_mt;
   	}*/

	$sql="select status,sum(msgcredit) as sum_msgcredit,msgcredit from $sendtabledetals where msg_job_id='".$message_job_id."' group by status";
	$values=mysqli_query($dbc,$sql);
	$count_record=mysqli_num_rows($values);
	if($count_record>0)
	{
		$i=1;
		while($row=mysqli_fetch_array($values))
		{
			
	          $result[$i] = $row;
	          $i++;
		}
		return $result;
	}
	else
	{
		echo 0;
	}

	
	

}

function load_rcs_status($job_result)
{
	global $dbc;
	$sendtabledetals = RCSMASTER;
   
	$message_id=$job_result[0]['id'];
	$message_job_id=$job_result[0]['job_id'];
   	$job_id=$_REQUEST['job_id'];
   	$job_date=date("Y-m-d",strtotime($_REQUEST['job_date']));
    
   	 $today_dt=date("Y-m-d");

   	$yesterday_dt=date("Y-m-d",strtotime("-1 day"));
   	if($job_date!=$today_dt && $job_date!=$yesterday_dt)
   	{
   		$report_yr=date("Y",strtotime($job_date));
   		$report_mt=date("m",strtotime($job_date));
   		$sendtabledetals=RCSMASTER.$report_yr.$report_mt;
   	}

   	if($job_date==$yesterday_dt)
   	{
   		
   		$report_yr=date("Y",strtotime($job_date));
   		$report_mt=date("m",strtotime($job_date));
   		$sendtable=RCSJOBS.$report_yr.$report_mt;
   	}

	$sql="select status,sum(msgcredit) as sum_msgcredit,msgcredit from $sendtabledetals where message_id='".$message_id."' and msg_job_id='".$message_job_id."' group by status";
	$values=mysqli_query($dbc,$sql);
	$count_record=mysqli_num_rows($values);
	if($count_record>0)
	{
		$i=1;
		while($row=mysqli_fetch_array($values))
		{
			
	          $result[$i] = $row;
	          $i++;
		}
		return $result;
	}
	else
	{
		echo 0;
	}

	
	

}



function load_today_summary()
{
	global $dbc;
	$userid=$_SESSION['user_id'];
	$select_user_id=$_REQUEST['u_id'];
  $user_role=$_REQUEST['user_role'];
	$sendtabledetals = SENDSMSDETAILS;
	$u_id=$_REQUEST['u_id'];
	$today_dt=date('Y-m-d');
	if($user_role=='mds_rs' || $user_role=='mds_ad')
	{
		
		$selected_role=$_REQUEST['selected_role'];

		if($selected_role=="User")
		{
			
			if($u_id=="All")
			{
				$parent_id=$_SESSION['user_id'];
				/*$user_ids=fetch_userids($parent_id);
				$check_user_ids=implode(",",$user_ids);*/

				$sql = "select sum(msgcredit) as msgcredit,status from $sendtabledetals where parent_id='".$parent_id."' and date(sent_at)='$today_dt' and schedule_sent=1 group by userids,status";
			}
			else
			{
				$sql = "select sum(msgcredit) as msgcredit,status from $sendtabledetals where userids='".$select_user_id."' and date(sent_at)='$today_dt' and schedule_sent=1 group by userids,status";
			}
		}
		else if($selected_role=="Reseller")
		{
			//$u_id=$_REQUEST['u_id'];
			if($select_user_id=="All")
			{

			/*$parent_resellers=fetch_resellers($userid);
				$check_parent_ids=implode(",",$parent_resellers);
				$user_ids=fetch_userids_by_resellers($check_parent_ids);
				$check_user_ids=implode(",",$user_ids);*/

					$userid_arr[]=$userid;
                    $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                     
                      $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                      	 $check_user_ids=implode(",",$only_resellers);
                      }

				$sql = "select sum(msgcredit) as msgcredit,status from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 group by userids,status";
			}
			else
			{
				$userid_arr[]=$select_user_id;
                    $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }


                       $single_arr[]=$select_user_id;
                      $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                      	 $check_user_ids=implode(",",$only_resellers);
                      }

				$sql = "select sum(msgcredit) as msgcredit,status from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 group by userids,status";
			}

		}

	}
	else if($user_role=='mds_sub_usr')
	{

			if($u_id=='All')
			{
					$user_tree=$_SESSION['user_tree'];

					$check_user_ids=$user_tree;
					$sql="select sum(msgcredit) as msgcredit,status from $sendtabledetals where userids in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids,status";

			}
			else
			{

				$check_user_ids=$u_id;
					$sql="select sum(msgcredit) as msgcredit,status from $sendtabledetals where userids in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids,status";

			}
			

	}
	else if($user_role=='mds_adm')
	{
		
		$selected_role=$_REQUEST['selected_role'];
		if($selected_role=="User")
		{
			if($select_user_id!="" && $select_user_id!="All")
			{

				$check_user_ids=$select_user_id;
				$sql="select sum(msgcredit) as msgcredit,status from $sendtabledetals where userids in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids,status";
			}
			else
			{

			/*	$user_ids=fetch_allusers();
				$check_user_ids=implode(",",$user_ids);*/
				$sql="select sum(msgcredit) as msgcredit,status from $sendtabledetals where  date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids,status";
			}
		}
		else if($selected_role=="Reseller")
		{
			if($select_user_id=='All')
			{
				$all_resellers=fetch_allresellers();

        $check_user_ids=implode(",",$all_resellers);
				
				$sql="select sum(msgcredit) as msgcredit,status from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids,status";
			}
			else
			{

					$userid_arr[]=$select_user_id;
                    $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                      $single_arr[]=$select_user_id;
                      $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                      	 $check_user_ids=implode(",",$only_resellers);
                      }
                     
				 $sql="select sum(msgcredit) as msgcredit,status from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids,status";
			}
		}
		else if($selected_role=="Admin")
		{
			if($select_user_id=='All')
			{
				$all_admins=fetch_alladmins();

				$userid_arr=$all_admins;
				
        $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }


                    $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                      	 $check_user_ids=implode(",",$only_resellers);
                      }
			 $sql="select sum(msgcredit) as msgcredit,status from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids,status";
			}
			else
			{

					$userid_arr[]=$select_user_id;
                    $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                     $single_arr[]=$select_user_id;
                      $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                      	 $check_user_ids=implode(",",$only_resellers);
                      }
                     
				 $sql="select sum(msgcredit) as msgcredit,status from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids,status";
			}
		}
		else if($selected_role=='All')
		{
			$sql = "select sum(msgcredit) as msgcredit,status from $sendtabledetals where date(sent_at)='$today_dt' and schedule_sent=1 group by userids,status";
		}
	}
	else
	{
		$sql = "select sum(msgcredit) as msgcredit,status from $sendtabledetals where userids='".$userid."' and date(sent_at)='$today_dt' and schedule_sent=1 group by userids,status";
	}
	
	$result=mysqli_query($dbc,$sql);
	$count=mysqli_num_rows($result);
	$i=1;
	if($count>0)
	{
		while($row=mysqli_fetch_array($result)) {
   			
   			$status[] = $row["status"];
   			

   		}

   		$table_head="<thead class='tbl_th'><tr>
   			
   			<th>Username</th><th>Total</th>";

   		$status_arr=array_unique($status);


	   		for($k=0;$k<count($status);$k++)
	   		{

	   			if($status_arr[$k]!='')
	   			{
	   				$status_arr1[]=$status_arr[$k];
	   			}
	   			
	   		}

	   	
   		$sql_select="Select sum(msgcredit) as msgcredit,userids";
   		for($j=0;$j<count($status_arr1);$j++)
   		{
   			$stat=$status_arr1[$j];
   			$table_head.="<th>$stat</th>";
   			$sql_select.=",sum(if(status='$stat',msgcredit,0))as `$stat`";

   		}

   			$table_head.="</tr></thead>";

$u_id=$_REQUEST['u_id'];
$select_user_id=$_REQUEST['u_id'];
if($user_role=='mds_rs' || $user_role=='mds_ad')
	{
		
		$selected_role=$_REQUEST['selected_role'];

		if($selected_role=="User")
		{
			
			if($u_id=="All")
			{
				$parent_id=$_SESSION['user_id'];
			/*	$user_ids=fetch_userids($parent_id);
				$check_user_ids=implode(",",$user_ids);*/
				$sql_select.=" from $sendtabledetals where parent_id in (".$parent_id.") and date(sent_at)='$today_dt' and schedule_sent=1 group by userids";


				
			}
			else
			{
				$sql_select.=" from $sendtabledetals where userids in (".$u_id.") and date(sent_at)='$today_dt' and schedule_sent=1 group by userids";
			}
		}
		else if($selected_role=="Reseller")
		{
		
			if($u_id=="All")
			{
				/*$parent_resellers=fetch_resellers($userid);
				$check_parent_ids=implode(",",$parent_resellers);
				$user_ids=fetch_userids_by_resellers($check_parent_ids);
				$check_user_ids=implode(",",$user_ids);*/
								$userid_arr[]=$userid;
                    $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                     
                      $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                      	 $check_user_ids=implode(",",$only_resellers);
                      }


				$sql_select.=" from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 group by userids";

			}
			else
			{
				/*$user_ids=fetch_userids_by_resellers($u_id);
				$check_user_ids=implode(",",$user_ids);*/
				$userid_arr[]=$select_user_id;
                    $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }


                       $single_arr[]=$select_user_id;
                      $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                      	 $check_user_ids=implode(",",$only_resellers);
                      }


			$sql_select.=" from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 group by userids";


			}

		}
	}
	else if($user_role=='mds_sub_usr')
	{

			if($u_id=='All')
			{
					$user_tree=$_SESSION['user_tree'];

					$check_user_ids=$user_tree;
					$sql_select.=" from $sendtabledetals where userids in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids";
			}
			else{

				$check_user_ids=$u_id;
				$sql_select.=" from $sendtabledetals where userids in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids";
			}
	}
		else if($user_role=='mds_adm')
	{
		
		$selected_role=$_REQUEST['selected_role'];
		if($selected_role=="User")
		{
			if($select_user_id!="" && $select_user_id!="All")
			{

				$check_user_ids=$select_user_id;
				$sql_select.=" from $sendtabledetals where userids in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids";
			}
			else
			{

				/*$user_ids=fetch_allusers();
				$check_user_ids=implode(",",$user_ids);*/
				$sql_select.=" from $sendtabledetals where date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids";
			}
		}
		else if($selected_role=="Reseller")
		{
			if($select_user_id=='All')
			{
				$all_resellers=fetch_allresellers();

        $check_user_ids=implode(",",$all_resellers);

			
				 $sql_select.=" from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids";
			}
			else
			{

					$userid_arr[]=$select_user_id;
                    $child_users=get_childUsers($userid_arr);
                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                      $single_arr[]=$select_user_id;
                      $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                      	 $check_user_ids=implode(",",$only_resellers);
                      }
                     
				 $sql_select.=" from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids";
			}
		}
		else if($selected_role=="Admin")
		{
			if($select_user_id=='All')
			{
				$all_admins=fetch_alladmins();

				$userid_arr=$all_admins;
				
        $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                    $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                      	 $check_user_ids=implode(",",$only_resellers);
                      }
			 $sql_select.=" from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids";
			}
			else
			{

					$userid_arr[]=$select_user_id;
                    $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                     
                      $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                      	 $check_user_ids=implode(",",$only_resellers);
                      }
                     
				 $sql_select.=" from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids";
			}
		}
		else if($selected_role=='All')
		{
			$sql_select.= " from $sendtabledetals where date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids";
		}

	}
	else
	{
			$sql_select.=" from $sendtabledetals where userids='".$userid."'  and date(sent_at)='$today_dt' and schedule_sent=1 group by userids";
	}


	//echo $sql_select;
   		
  		$result_select = mysqli_query($dbc, $sql_select);

  		$count_record=mysqli_num_rows($result_select);
  		if($count_record>0)
  		{
  			$total_bill=0;
  			$table_body2.="<tr><td></td>";
  			while($row=mysqli_fetch_array($result_select))
  			{
  				/*$created_date=date('dS F y',strtotime($row['created_at']));*/
  				$bill_credit=$row['msgcredit'];
  				
  				$total_bill+=$bill_credit;

  				$userid=$row['userids'];
  				$u_id=$userid;
  				$username=get_username($userid);
  				$table_body.="<tr>
  				
  				<td>$username</td>
  				<td><a href='#' class='report_type' name='total' data-role='$user_role' data-uid='$u_id' data-selected_role='$selected_role'>$bill_credit</a></td>";
  				$total_stat_val=0;
  				for($j=0;$j<count($status_arr1);$j++)
		   		{
		   			$stat=$status_arr1[$j];
		   			$stat_val=$row[$stat];
		   			$total_stat_val[$stat]=$stat_val;
		   			$table_body.="<td><a href='#' class='report_type' name='$stat' data-role='$user_role' data-uid='$u_id' data-selected_role='$selected_role'>$stat_val</a></td>";
		   			//$table_body2.="<td>$stat</td>";
						
		   		}

  				$table_body.="</tr>";
  				

  			}

  			for($j=0;$j<count($status_arr1);$j++)
		   		{
		   			$stat=$status_arr1[$j];
		   			
						$total_stat_val1=array_sum($total_stat_val[$stat]);
						$table_body_stat.="<td></td>";
		   		}
  			$table_body2.="<td>$total_bill</td>";
  			$table_body2.=$table_body_stat;
  			$table_body2.="</tr>";
  			$table_body.=$table_body2;
  		}
  		else
  		{
  			$table_body.="No record available";
  		}
  		
   		    return $table_head.$table_body;


	}
	else
	{
		return $record="No record available";
	}

/*
	$sql="select sum(msgcredit) as msgcredit,sum(if(status='Delivered',msgcredit,0))as DELIVRD,sum(if(status='submitted',msgcredit,0))as submitted,sum(if(status='Failed',msgcredit,0))as Failed,sum(if(status='Rejected',msgcredit,0))as Rejected,sum(if(status='DND',msgcredit,0))as DND,sum(if(status='Block',msgcredit,0))as Block,sum(if(status='Spam',msgcredit,0))as Spam,sum(if(status='NULL',msgcredit,0))as null_stat,sum(if(status='Refund',msgcredit,0))as Refund,sum(if(status='Other',msgcredit,0))as Other,sum(if(status='Smart',msgcredit,0))as Smart,userids from( select sum(msgcredit) as msgcredit,userids,status from $sendtabledetals where userids='".$u_id."' and STR_TO_DATE(created_at,'%Y-%m-%d')='$today_dt' group by userids,status) x group by userids";

	$result=mysqli_query($dbc,$sql);
	$count=mysqli_num_rows($result);
	$i=1;
	if($count>0)
	{
	while($row=mysqli_fetch_array($result))
	{
		$msgcredit=$row['msgcredit'];
		$delivered=$row['DELIVRD'];
		$undelivered=$row['submitted'];
		$rejected=$row['Rejected'];
		$failed=$row['Failed'];
		$null=$row['null_stat'];
		$other=$row['Other'];
		$record.="<tr>
		<td>$i</td>
	
		<td><a href='#' class='report_type' name='total'>$msgcredit</a></td>
		<td><a href='#' class='report_type' name='delivered'>$delivered</a></td>
		<td>$undelivered</td>
		<td>0</td>
		<td>0</td>
		<td><a href='#' class='report_type' name='rejected'>$rejected</a></td>
		<td>0</td>
		<td><a href='#' class='report_type' name='other'>$other</a></td>
		<td><a href='#' class='report_type' name='failed'>$failed</a></td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		

		</tr>";
		$i++;
	}
	}
	else
	{
		$record="No record available";
	}
*/
	//echo $record;
}



function load_today_summary_test()
{
	global $dbc;
	$userid=$_SESSION['user_id'];
	$select_user_id=$_REQUEST['u_id'];
$user_role=$_REQUEST['user_role'];
	$sendtabledetals = SENDSMSDETAILS;
	$u_id=$_REQUEST['u_id'];
	$today_dt=date('Y-m-d');
	if($user_role=='mds_rs' || $user_role=='mds_ad')
	{
		
		$selected_role=$_REQUEST['selected_role'];

		if($selected_role=="User")
		{
			
			if($u_id=="All")
			{
				$parent_id=$_SESSION['user_id'];
				/*$user_ids=fetch_userids($parent_id);
				$check_user_ids=implode(",",$user_ids);*/

				$sql = "select sum(msgcredit) as msgcredit,status from $sendtabledetals where parent_id='".$parent_id."' and date(sent_at)='$today_dt' and schedule_sent=1 group by userids,status";
			}
			else
			{
				$sql = "select sum(msgcredit) as msgcredit,status from $sendtabledetals where userids='".$select_user_id."' and date(sent_at)='$today_dt' and schedule_sent=1 group by userids,status";
			}
		}
		else if($selected_role=="Reseller")
		{
			//$u_id=$_REQUEST['u_id'];
			if($select_user_id=="All")
			{

			/*$parent_resellers=fetch_resellers($userid);
				$check_parent_ids=implode(",",$parent_resellers);
				$user_ids=fetch_userids_by_resellers($check_parent_ids);
				$check_user_ids=implode(",",$user_ids);*/

					$userid_arr[]=$userid;
                    $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                     
                      $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                      	 $check_user_ids=implode(",",$only_resellers);
                      }

				$sql = "select sum(msgcredit) as msgcredit,status from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 group by userids,status";
			}
			else
			{
				$userid_arr[]=$select_user_id;
                    $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }


                       $single_arr[]=$select_user_id;
                      $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                      	 $check_user_ids=implode(",",$only_resellers);
                      }

				$sql = "select sum(msgcredit) as msgcredit,status from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 group by userids,status";
			}

		}

	}
	else if($user_role=='mds_adm')
	{
		
		$selected_role=$_REQUEST['selected_role'];
		if($selected_role=="User")
		{
			if($select_user_id!="" && $select_user_id!="All")
			{

				$check_user_ids=$select_user_id;
				$sql="select sum(msgcredit) as msgcredit,status from $sendtabledetals where userids in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids,status";
			}
			else
			{

			/*	$user_ids=fetch_allusers();
				$check_user_ids=implode(",",$user_ids);*/
				$sql="select sum(msgcredit) as msgcredit,status from $sendtabledetals where  date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids,status";
			}
		}
		else if($selected_role=="Reseller")
		{
			if($select_user_id=='All')
			{
				$all_resellers=fetch_allresellers();

        $check_user_ids=implode(",",$all_resellers);
				
				$sql="select sum(msgcredit) as msgcredit,status from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids,status";
			}
			else
			{

					$userid_arr[]=$select_user_id;
                    $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                      $single_arr[]=$select_user_id;
                      $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                      	 $check_user_ids=implode(",",$only_resellers);
                      }
                     
				 $sql="select sum(msgcredit) as msgcredit,status from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids,status";
			}
		}
		else if($selected_role=="Admin")
		{
			if($select_user_id=='All')
			{
				$all_admins=fetch_alladmins();

				$userid_arr=$all_admins;
				
        $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }


                    $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                      	 $check_user_ids=implode(",",$only_resellers);
                      }
			 $sql="select sum(msgcredit) as msgcredit,status from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids,status";
			}
			else
			{

					$userid_arr[]=$select_user_id;
                    $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                     $single_arr[]=$select_user_id;
                      $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                      	 $check_user_ids=implode(",",$only_resellers);
                      }
                     
				 $sql="select sum(msgcredit) as msgcredit,status from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids,status";
			}
		}
		else if($selected_role=='All')
		{
			$sql = "select sum(msgcredit) as msgcredit,status from $sendtabledetals where date(sent_at)='$today_dt' and schedule_sent=1 group by userids,status";
		}
	}
	else
	{
		$sql = "select sum(msgcredit) as msgcredit,status from $sendtabledetals where userids='".$userid."' and date(sent_at)='$today_dt' and schedule_sent=1 group by userids,status";
	}
	
	$result=mysqli_query($dbc,$sql);
	$count=mysqli_num_rows($result);
	$i=1;
	if($count>0)
	{
		while($row=mysqli_fetch_array($result)) {
   			
   			$status[] = $row["status"];
   			

   		}

   		$table_head="<tr>
   			
   			<th>Username</th><th>Total</th>";

   		$status_arr=array_unique($status);


	   		for($k=0;$k<count($status);$k++)
	   		{
	   			if($status_arr[$k]!='')
	   			{
	   				$status_arr1[]=$status_arr[$k];
	   			}
	   			
	   		}

	   	
   		$sql_select="Select sum(msgcredit) as msgcredit,userids";
   		for($j=0;$j<count($status_arr1);$j++)
   		{
   			$stat=$status_arr1[$j];
   			$table_head.="<th>$stat</th>";
   			$sql_select.=",sum(if(status='$stat',msgcredit,0))as `$stat`";

   		}

   			$table_head.="</tr>";

$u_id=$_REQUEST['u_id'];
$select_user_id=$_REQUEST['u_id'];
if($user_role=='mds_rs' || $user_role=='mds_ad')
	{
		
		$selected_role=$_REQUEST['selected_role'];

		if($selected_role=="User")
		{
			
			if($u_id=="All")
			{
				$parent_id=$_SESSION['user_id'];
			/*	$user_ids=fetch_userids($parent_id);
				$check_user_ids=implode(",",$user_ids);*/
				$sql_select.=" from $sendtabledetals where parent_id in (".$parent_id.") and date(sent_at)='$today_dt' and schedule_sent=1 group by userids";


				
			}
			else
			{
				$sql_select.=" from $sendtabledetals where userids in (".$u_id.") and date(sent_at)='$today_dt' and schedule_sent=1 group by userids";
			}
		}
		else if($selected_role=="Reseller")
		{
		
			if($u_id=="All")
			{
				/*$parent_resellers=fetch_resellers($userid);
				$check_parent_ids=implode(",",$parent_resellers);
				$user_ids=fetch_userids_by_resellers($check_parent_ids);
				$check_user_ids=implode(",",$user_ids);*/
								$userid_arr[]=$userid;
                    $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                     
                      $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                      	 $check_user_ids=implode(",",$only_resellers);
                      }


				$sql_select.=" from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 group by userids";

			}
			else
			{
				/*$user_ids=fetch_userids_by_resellers($u_id);
				$check_user_ids=implode(",",$user_ids);*/
				$userid_arr[]=$select_user_id;
                    $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }


                       $single_arr[]=$select_user_id;
                      $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                      	 $check_user_ids=implode(",",$only_resellers);
                      }


			$sql_select.=" from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 group by userids";


			}

		}
	}
		else if($user_role=='mds_adm')
	{
		
		$selected_role=$_REQUEST['selected_role'];
		if($selected_role=="User")
		{
			if($select_user_id!="" && $select_user_id!="All")
			{

				$check_user_ids=$select_user_id;
				$sql_select.=" from $sendtabledetals where userids in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids";
			}
			else
			{

				/*$user_ids=fetch_allusers();
				$check_user_ids=implode(",",$user_ids);*/
				$sql_select.=" from $sendtabledetals where date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids";
			}
		}
		else if($selected_role=="Reseller")
		{
			if($select_user_id=='All')
			{
				$all_resellers=fetch_allresellers();

        $check_user_ids=implode(",",$all_resellers);

			
				 $sql_select.=" from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids";
			}
			else
			{

					$userid_arr[]=$select_user_id;
                    $child_users=get_childUsers($userid_arr);
                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                      $single_arr[]=$select_user_id;
                      $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                      	 $check_user_ids=implode(",",$only_resellers);
                      }
                     
				 $sql_select.=" from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids";
			}
		}
		else if($selected_role=="Admin")
		{
			if($select_user_id=='All')
			{
				$all_admins=fetch_alladmins();

				$userid_arr=$all_admins;
				
        $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                    $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                      	 $check_user_ids=implode(",",$only_resellers);
                      }
			 $sql_select.=" from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids";
			}
			else
			{

					$userid_arr[]=$select_user_id;
                    $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                     
                      $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                      	 $check_user_ids=implode(",",$only_resellers);
                      }
                     
				 $sql_select.=" from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids";
			}
		}
		else if($selected_role=='All')
		{
			$sql_select.= " from $sendtabledetals where date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids";
		}

	}
	else
	{
			$sql_select.=" from $sendtabledetals where userids='".$userid."'  and date(sent_at)='$today_dt' and schedule_sent=1 group by userids";
	}


	//echo $sql_select;
   		
  		$result_select = mysqli_query($dbc, $sql_select);

  		$count_record=mysqli_num_rows($result_select);
  		if($count_record>0)
  		{
  			$total_bill=0;
  			$table_body2.="<tr><td></td>";
  			while($row=mysqli_fetch_array($result_select))
  			{
  				/*$created_date=date('dS F y',strtotime($row['created_at']));*/
  				$bill_credit=$row['msgcredit'];
  				
  				$total_bill+=$bill_credit;

  				$userid=$row['userids'];
  				$u_id=$userid;
  				$username=get_username($userid);
  				$table_body.="<tr>
  				
  				<td>$username</td>
  				<td><a href='#' class='report_type_test' name='total' data-role='$user_role' data-uid='$u_id' data-selected_role='$selected_role'>$bill_credit</a></td>";
  				$total_stat_val=0;
  				for($j=0;$j<count($status_arr1);$j++)
		   		{
		   			$stat=$status_arr1[$j];
		   			$stat_val=$row[$stat];
		   			$total_stat_val[$stat]=$stat_val;
		   			$table_body.="<td><a href='#' class='report_type_test' name='$stat' data-role='$user_role' data-uid='$u_id' data-selected_role='$selected_role'>$stat_val</a></td>";
		   			//$table_body2.="<td>$stat</td>";
						
		   		}

  				$table_body.="</tr>";
  				

  			}

  			for($j=0;$j<count($status_arr1);$j++)
		   		{
		   			$stat=$status_arr1[$j];
		   			
						$total_stat_val1=array_sum($total_stat_val[$stat]);
						$table_body_stat.="<td></td>";
		   		}
  			$table_body2.="<td>$total_bill</td>";
  			$table_body2.=$table_body_stat;
  			$table_body2.="</tr>";
  			$table_body.=$table_body2;
  		}
  		else
  		{
  			$table_body.="No record available";
  		}
  		
   		    return $table_head.$table_body;


	}
	else
	{
		return $record="No record available";
	}

/*
	$sql="select sum(msgcredit) as msgcredit,sum(if(status='Delivered',msgcredit,0))as DELIVRD,sum(if(status='submitted',msgcredit,0))as submitted,sum(if(status='Failed',msgcredit,0))as Failed,sum(if(status='Rejected',msgcredit,0))as Rejected,sum(if(status='DND',msgcredit,0))as DND,sum(if(status='Block',msgcredit,0))as Block,sum(if(status='Spam',msgcredit,0))as Spam,sum(if(status='NULL',msgcredit,0))as null_stat,sum(if(status='Refund',msgcredit,0))as Refund,sum(if(status='Other',msgcredit,0))as Other,sum(if(status='Smart',msgcredit,0))as Smart,userids from( select sum(msgcredit) as msgcredit,userids,status from $sendtabledetals where userids='".$u_id."' and STR_TO_DATE(created_at,'%Y-%m-%d')='$today_dt' group by userids,status) x group by userids";

	$result=mysqli_query($dbc,$sql);
	$count=mysqli_num_rows($result);
	$i=1;
	if($count>0)
	{
	while($row=mysqli_fetch_array($result))
	{
		$msgcredit=$row['msgcredit'];
		$delivered=$row['DELIVRD'];
		$undelivered=$row['submitted'];
		$rejected=$row['Rejected'];
		$failed=$row['Failed'];
		$null=$row['null_stat'];
		$other=$row['Other'];
		$record.="<tr>
		<td>$i</td>
	
		<td><a href='#' class='report_type' name='total'>$msgcredit</a></td>
		<td><a href='#' class='report_type' name='delivered'>$delivered</a></td>
		<td>$undelivered</td>
		<td>0</td>
		<td>0</td>
		<td><a href='#' class='report_type' name='rejected'>$rejected</a></td>
		<td>0</td>
		<td><a href='#' class='report_type' name='other'>$other</a></td>
		<td><a href='#' class='report_type' name='failed'>$failed</a></td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		

		</tr>";
		$i++;
	}
	}
	else
	{
		$record="No record available";
	}
*/
	//echo $record;
}


function load_gateway_summary()
{
	global $dbc;
	$userid=$_SESSION['user_id'];
	$gateway_id=$_REQUEST['gateway'];
	$frmDate=$_REQUEST['frmDate'];
	$toDate=$_REQUEST['toDate'];
	$month=$_REQUEST['month'];
	$year=$_REQUEST['year'];
	$sendtabledetals = SENDSMSDETAILS;
	
	if($frmDate=="" && $toDate=="")
	{
		$today_dt=date('Y-m-d');
		if($gateway_id=='All')
		{
			$sql = "select sum(msgcredit) as msgcredit,status from $sendtabledetals where date(sent_at)='$today_dt' and schedule_sent=1 group by service_id,status";
		}
		else
		{
			$sql = "select sum(msgcredit) as msgcredit,status from $sendtabledetals where service_id='".$gateway_id."' and date(sent_at)='$today_dt' and schedule_sent=1 group by service_id,status";
		}
	
	}
	else
	{
		$today_dt=date('Y-m-d');
		if($frmDate==$today_dt && $toDate==$today_dt)
		{
			if($gateway_id=='All')
			{
				$sql = "select sum(msgcredit) as msgcredit,status from $sendtabledetals where date(sent_at)='$today_dt' and schedule_sent=1 group by service_id,status";
			}
			else
			{
				$sql = "select sum(msgcredit) as msgcredit,status from $sendtabledetals where service_id='".$gateway_id."' and date(sent_at)='$today_dt' and schedule_sent=1 group by service_id,status";
			}
		}
		else
		{
			//$sendtabledetals=$sendtabledetals.$year.$month;
			$sendtabledetals="user_summary";
		
			if($gateway_id=='All')
			{
				  $sql = "select sum(bill_credit) as msgcredit,status from $sendtabledetals where (date(created_date) between '$frmDate' and '$toDate') group by service_id,status";
			}
			else
			{
				$sql = "select sum(bill_credit) as msgcredit,status from $sendtabledetals where service_id='".$gateway_id."' and (date(created_date) between '$frmDate' and '$toDate')  group by service_id,status";
			}
		}

		

	}
	

	
	
	
	$result=mysqli_query($dbc,$sql);
	$count=mysqli_num_rows($result);
	$i=1;
	if($count>0)
	{
		while($row=mysqli_fetch_array($result)) {
   			$status[] = $row["status"];
   		}
   		$table_head="<tr>	
   			<th>Gateway Name</th><th>Total</th>";
   		$status_arr=array_unique($status);
	   		for($k=0;$k<count($status);$k++)
	   		{
	   			if($status_arr[$k]!='')
	   			{
	   				$status_arr1[]=$status_arr[$k];
	   			}
	   			
	   		}

	   		if($sendtabledetals=="user_summary")
	   		{
	   			$sql_select="Select sum(bill_credit) as msgcredit,service_id";
	   			for($j=0;$j<count($status_arr1);$j++)
		   		{
		   			$stat=$status_arr1[$j];
		   			$table_head.="<th>$stat</th>";
		   			$sql_select.=",sum(if(status='$stat',bill_credit,0))as `$stat`";

		   		}
	   		}
	   		else
	   		{
	   			$sql_select="Select sum(msgcredit) as msgcredit,service_id";
	   			for($j=0;$j<count($status_arr1);$j++)
		   		{
		   			$stat=$status_arr1[$j];
		   			$table_head.="<th>$stat</th>";
		   			$sql_select.=",sum(if(status='$stat',msgcredit,0))as `$stat`";

		   		}
	   		}

   		
   		

   			$table_head.="</tr>";


  if($frmDate=="" && $toDate=="")
	{
		
		if($gateway_id=='All')
		{

			 $sql_select.=" from $sendtabledetals where date(sent_at)='$today_dt' and schedule_sent=1 group by service_id";
		}
		else
		{
			 $sql_select.=" from $sendtabledetals where service_id='".$gateway_id."'  and date(sent_at)='$today_dt' and schedule_sent=1 group by service_id";
		}
	
	}
	else
	{
		
		$today_dt=date('Y-m-d');
		if($frmDate==$today_dt && $toDate==$today_dt)
		{
				if($gateway_id=='All')
				{

					 $sql_select.=" from $sendtabledetals where date(sent_at)='$today_dt' and schedule_sent=1 group by service_id";
				}
				else
				{
					 $sql_select.=" from $sendtabledetals where service_id='".$gateway_id."'  and date(sent_at)='$today_dt' and schedule_sent=1 group by service_id";
				}

		}
		else
		{
			// $sendtabledetals="user_summary";
			if($gateway_id=='All')
			{

					$sql_select.=" from $sendtabledetals where (date(created_date) between '$frmDate' and '$toDate')  group by service_id";
			}
			else
			{
				$sql_select.=" from $sendtabledetals where service_id='".$gateway_id."'  and (date(created_date) between '$frmDate' and '$toDate') group by service_id";
			}
		}

		
		
		

	}
	



  		$result_select = mysqli_query($dbc, $sql_select);

  		$count_record=mysqli_num_rows($result_select);
  		if($count_record>0)
  		{
  			$total_bill=0;
  			$table_body2.="<tr><td></td>";
  			while($row=mysqli_fetch_array($result_select))
  			{
  				
  				$bill_credit=$row['msgcredit'];
  				
  				$total_bill+=$bill_credit;

  				$service_id=$row['service_id'];
  			
  				$table_body.="<tr>
  				
  				<td>$service_id</td>
  				<td><a href='#' class='report_type' name='total' >$bill_credit</a></td>";
  				$total_stat_val=0;
  				for($j=0;$j<count($status_arr1);$j++)
		   		{
		   			$stat=$status_arr1[$j];
		   			$stat_val=$row[$stat];
		   			$total_stat_val[$stat]=$stat_val;
		   			$table_body.="<td><a href='#' class='report_type' name='$stat' >$stat_val</a></td>";
		   			//$table_body2.="<td>$stat</td>";
						
		   		}

  				$table_body.="</tr>";
  				

  			}

  			for($j=0;$j<count($status_arr1);$j++)
		   		{
		   			$stat=$status_arr1[$j];
		   			
						$total_stat_val1=array_sum($total_stat_val[$stat]);
						$table_body_stat.="<td></td>";
		   		}
  			$table_body2.="<td>$total_bill</td>";
  			$table_body2.=$table_body_stat;
  			$table_body2.="</tr>";
  			$table_body.=$table_body2;
  		}
  		else
  		{
  			$table_body.="No record available";
  		}
   		    return $table_head.$table_body;
	}
	else
	{
		return $record="No record available";
	}
}
/*function load_today_report($u_id)
{
	global $dbc;
	$u_id=$_SESSION['user_id'];
	$sendtabledetals = SENDSMSDETAILS . CURRENTMONTH;
	$report_status=$_SESSION['report_status'];
	$today_dt=date('Y-m-d');
	
	  $sql="select sum(msgcredit) as msgcredit,sum(if(status='Delivered',msgcredit,0))as DELIVRD,sum(if(status='submitted',msgcredit,0))as submitted,sum(if(status='Failed',msgcredit,0))as Failed,sum(if(status='Rejected',msgcredit,0))as Rejected,sum(if(status='DND',msgcredit,0))as DND,sum(if(status='Block',msgcredit,0))as Block,sum(if(status='Spam',msgcredit,0))as Spam,sum(if(status='NULL',msgcredit,0))as null_stat,sum(if(status='Refund',msgcredit,0))as Refund,sum(if(status='Smart',msgcredit,0))as Smart,userids from( select sum(msgcredit) as msgcredit,userids,status from az_sendnumbers202202 where userids='".$u_id."' and STR_TO_DATE(created_at,'%Y-%m-%d')='2022-02-21' group by userids,status) x group by userids";

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
			return $record="No record available";
		}
	
	
}*/


function fetch_alladmins()
{
	global $dbc;

	$sql="select userid from az_user where user_role='mds_ad' and user_status=1";

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


function get_parentID($userid)
{
  global $dbc;
  // $ids = array();
  // static $child=array();
  // $userids=implode(",", $userid);
   
        $qry = "SELECT parent_id FROM az_user WHERE userid=$userid";
        $rs = mysqli_query($dbc, $qry);
        if(mysqli_num_rows($rs)>0) {
          while($row = mysqli_fetch_array($rs))
          {
           	$parent_id = $row['parent_id'];
          }

          return $parent_id;

        }
        else {
      return 0;
    }
}

function get_childUsers_resellers($userid)
{
  global $dbc;
  $ids = array();
  static $child=array();
  $userids=implode(",", $userid);
   
        $qry = "SELECT userid FROM az_user WHERE parent_id in ($userids) and user_role!='mds_usr' and user_status=1 order by userid desc";
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

function fetch_allresellers()
{
	global $dbc;

	$sql="select userid from az_user where user_role='mds_rs' and user_status=1";

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

	$sql="select userid from az_user where user_role='mds_usr' and user_status=1";

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

function fetch_resellers($u_id)
{
	global $dbc;

	//echo "dzsf ".$u_id;
	
	
	$sql="select userid from az_user where parent_id='".$u_id."' and user_role='mds_rs' and user_status=1";

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


function get_onlyResellers_new($userids)
{
  global $dbc;

    $ids = array();
    $resellers = array();

    $userids_str = implode(",", $userids);

    $qry = "SELECT userid, user_role, count(1) as 'reseller_cnt' FROM az_user WHERE parent_id IN ($userids_str) AND (user_role='mds_rs' OR user_role='mds_ad') GROUP BY 1 ORDER BY userid DESC";
    $rs = mysqli_query($dbc, $qry);

    if (mysqli_num_rows($rs) > 0) {
        while ($row = mysqli_fetch_array($rs)) {
            if ($row['reseller_cnt'] > 0) {
                $ids[] = $row['userid'];
                if($row['user_role']=='mds_rs')
                {
                  $resellers[] = $row['userid'];
                }
                
            }
        }
    }

    if (!empty($ids)) {
        $subResellers = get_onlyResellers($ids);
        $resellers = array_merge($resellers, $subResellers);

        $resellers=array_unique($resellers);
    }

    return $resellers;      
       
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

function load_today_report_dtls($u_id)
{
	global $dbc;
	$u_id=$_SESSION['user_id'];
	$sendtabledetals = SENDSMSDETAILS . CURRENTMONTH;
	$report_status=$_SESSION['report_status'];
	$today_dt=date('Y-m-d');
	
	  $sql="select * from $sendtabledetals where userids='".$u_id."' and STR_TO_DATE(sent_at,'%Y-%m-%d')='$today_dt' order by id desc";

		$result=mysqli_query($dbc,$sql);
		$count=mysqli_num_rows($result);
		$i=1;
		if($count>0)
		{
		while($row=mysqli_fetch_array($result))
		{
			$route=$row['route'];
			$mobile=$row['mobile_number'];
			$msgcredit=$row['msgcredit'];
			$msg_id=$row['message_id'];
			$status=$row['status'];
			$err_code=$row['err_code'];
			$created_dt=date("d-m-Y H:i:s",strtotime($row['sent_at']));
			// $dlr_time=date("d-m-Y H:i:s",$row['delivered_date']);
			$record.="<tr>
			<td>$i</td>
			<td>$route</td>
			<td>$mobile</td>
			<td>0</td>
			<td>0</td>
			<td>$msgcredit</td>
		
			<td>$msg_id</td>
			<td>0</td>
			<td>$status</td>
			<td>$created_dt</td>

			<td>$err_code</td>
			<td>0</td>

			</tr>";

			//return $row;
			$i++;
		}
		return $record;
		}
		else
		{
			return $record="No record available";
		}
	
	
}