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
$u_id=$_SESSION['user_id'];
if(isset($_REQUEST['list_type']))
{
     $list_type=$_REQUEST['list_type'];


    if($list_type=='load_today_summary')
    {
          $result = load_today_summary();

            
            echo $result;
    }
    else if($list_type=='today_report')
    {

    	$sendtabledetals = SENDSMSDETAILS;
			$select_user_id=$_REQUEST['uid'];
			$operator_name=$_REQUEST['operator_name'];
			$today_dt=date('Y-m-d');

			$from_date=$_REQUEST['frmDate'];
			$to_date=$_REQUEST['toDate'];

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
			            return date( 'Y-m-d h:i', strtotime($d));
			        }
			    ),
			  	array( 'db' => 'err_code','dt' => 9)
			  	/*array( 'db' => 'id','dt' => 12 )*/
			);
			 
			// SQL server connection information
			global $sql_details ;
				if(isset($from_date) && isset($to_date))
				{
						$from_dt_split=explode("-",$from_date);
				    $frm_year=$from_dt_split[0];
				    $frm_month=$from_dt_split[1];

				    $to_dt_split=explode("-",$to_date);
				    $to_year=$to_dt_split[0];
				    $to_month=$to_dt_split[1];
		 				$yesterday_dt=date("Y-m-d",strtotime("-1 day"));

				    if($frm_month==$to_month && $frm_year==$to_year)
				    {
				    	if(($from_date==$today_dt && $to_date==$today_dt) || ($from_date==$yesterday_dt && $to_date==$yesterday_dt) || ($from_date==$yesterday_dt && $to_date==$today_dt))
				   			{
					    		$sendtabledetals = SENDSMSDETAILS;
					    		$table = $sendtabledetals;
				    		}
				    		else
				    		{
				    			if($frm_month==$to_month && $frm_year==$to_year)
				    			{
				    				  $sendtabledetals = SENDSMSDETAILS .$frm_year.$frm_month;
					    				$table = $sendtabledetals;
				    			}
				    			
				    		}
				    }

				}
			

				if(!isset($from_date) || !isset($to_date))
				{
					$extraWhere=" (date(sent_at)='$today_dt') and operator_name='$operator_name' ";
				}
				else
				{

					$extraWhere=" (date(sent_at) BETWEEN '$from_date' and '$to_date') and operator_name='$operator_name' ";
				}


			if($report_type!="total")
			{

			
				if($extraWhere!="")
				{
					$extraWhere.="and status='".$report_type."'";

				}
				else
				{
					$extraWhere.=" and status='".$report_type."'";
				}
				
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
				

					if($extraWhere!="")
					{
						$extraWhere.=" and `parent_id`='".$parent_id."' and schedule_sent=1 ";
					}
					else
					{

						$extraWhere.=" and `userids` in ($userid) and schedule_sent=1 ";
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

						$extraWhere.=" and `userids` in ($userid) and schedule_sent=1 ";
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
						$extraWhere.=" and `parent_id` in ($check_user_ids) and schedule_sent=1 ";
					}
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
					if($extraWhere!="")
					{
						$extraWhere.=" and `parent_id` in ($check_user_ids) and schedule_sent=1 ";
					}
					else
					{

						$extraWhere.=" and `parent_id` in ($check_user_ids) and schedule_sent=1 ";
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

						$extraWhere.=" and `userids` in ($userid) and schedule_sent=1 ";
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

						$extraWhere.=" and `userids` in ($userid) and schedule_sent=1 ";
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

						$extraWhere.=" and `userids` in ($userid) and schedule_sent=1 ";
					}
			}

			
			 
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


function fetch_userids1($u_id)
{
	global $dbc;

	//echo "dzsf ".$u_id;
	
	$u_id=$_SESSION['user_id'];
	if($u_id!=1)
	{
		$sql="select userid from az_user where parent_id='".$u_id."' ";
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



function get_username($uid)
{
	global $dbc;
	$sql="select * from az_user where userid='".$uid."'";

	$result=mysqli_query($dbc,$sql);
	while ($row=mysqli_fetch_array($result)) {
		$uname=$row['user_name'];
	}

	return $uname;
}

function get_delivery_count($job_id)
{
	global $dbc;
	$sql="select sum(`msgcredit`) as delivery_count from az_sendnumbers where msg_job_id='".$job_id."' and `status`='Delivered'";

	$result=mysqli_query($dbc,$sql);
	while ($row=mysqli_fetch_array($result)) {
		$delivery_count=$row['delivery_count'];
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
   	if($job_date!=$today_dt && $job_date!=$yesterday_dt)
   	{
   		$report_yr=date("Y",strtotime($job_date));
   		$report_mt=date("m",strtotime($job_date));
   		$sendtable=SENDSMS.$report_yr.$report_mt;
   	}

   	if($job_date==$yesterday_dt)
   	{

   		$report_yr=date("Y",strtotime($job_date));
   		$report_mt=date("m",strtotime($job_date));
   		$sendtable=SENDSMS.$report_yr.$report_mt;
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
	$sendtable = RCSSMS . CURRENTMONTH;
    		
	
   	$job_id=$_REQUEST['job_id'];
   	$table_name=$_REQUEST['table_name'];
   	$job_date=date("Y-m-d",strtotime($_REQUEST['job_date']));
    
   	$today_dt=date("Y-m-d");

   	$yesterday_dt=date("Y-m-d",strtotime("-1 day"));
   	if($job_date!=$today_dt && $job_date!=$yesterday_dt)
   	{
   		$report_yr=date("Y",strtotime($job_date));
   		$report_mt=date("m",strtotime($job_date));
   		$sendtable=RCSSMS.$report_yr.$report_mt;
   	}

   	if($job_date==$yesterday_dt)
   	{

   		$report_yr=date("Y",strtotime($job_date));
   		$report_mt=date("m",strtotime($job_date));
   		$sendtable=RCSSMS.$report_yr.$report_mt;
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
	$sendtabledetals = RCSDETAILS;
   
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
   		$sendtabledetals=RCSDETAILS.$report_yr.$report_mt;
   	}

   	if($job_date==$yesterday_dt)
   	{
   		
   		$report_yr=date("Y",strtotime($job_date));
   		$report_mt=date("m",strtotime($job_date));
   		$sendtable=RCSSMS.$report_yr.$report_mt;
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

			$from_date=$_REQUEST['frmDate'];
			$to_date=$_REQUEST['toDate'];
		if(isset($from_date) && isset($to_date))
				{
						$from_dt_split=explode("-",$from_date);
				    $frm_year=$from_dt_split[0];
				    $frm_month=$from_dt_split[1];

				    $to_dt_split=explode("-",$to_date);
				    $to_year=$to_dt_split[0];
				    $to_month=$to_dt_split[1];
		 				$yesterday_dt=date("Y-m-d",strtotime("-1 day"));

				    if($frm_month==$to_month && $frm_year==$to_year)
				    {
				    	if(($from_date==$today_dt && $to_date==$today_dt) || ($from_date==$yesterday_dt && $to_date==$yesterday_dt) || ($from_date==$yesterday_dt && $to_date==$today_dt))
				   			{
					    		$sendtabledetals = SENDSMSDETAILS;
					    		$table = $sendtabledetals;
				    		}
				    		else
				    		{
				    			if($frm_month==$to_month && $frm_year==$to_year)
				    			{
				    				  $sendtabledetals = SENDSMSDETAILS .$frm_year.$frm_month;
					    				$table = $sendtabledetals;
				    			}
				    			
				    		}
				    }

				}
			

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

				if(!isset($from_date) || !isset($to_date))
				{
					

					$sql = "select sum(msgcredit) as msgcredit,status,operator_name,sent_at from $sendtabledetals where parent_id='".$parent_id."' and date(sent_at)='$today_dt' and schedule_sent=1 group by userids,status,operator_name";
				}
				else
				{

					$sql = "select sum(msgcredit) as msgcredit,status,operator_name,sent_at from $sendtabledetals where parent_id='".$parent_id."' and (date(sent_at) BETWEEN '$from_date' and '$to_date') and schedule_sent=1 group by userids,status,operator_name";
				}


			
			}
			else
			{
				


				if(!isset($from_date) || !isset($to_date))
				{
					$sql = "select sum(msgcredit) as msgcredit,status,operator_name,sent_at from $sendtabledetals where userids='".$select_user_id."' and date(sent_at)='$today_dt' and schedule_sent=1 group by userids,status,operator_name";

					/*$sql = "select sum(msgcredit) as msgcredit,status,operator_name,sent_at from $sendtabledetals where parent_id='".$parent_id."' and date(sent_at)='$today_dt' and schedule_sent=1 group by userids,status,operator_name";*/
				}
				else
				{

					$sql = "select sum(msgcredit) as msgcredit,status,operator_name,sent_at from $sendtabledetals where userids='".$select_user_id."' and (date(sent_at) BETWEEN '$from_date' and '$to_date') and schedule_sent=1 group by userids,status,operator_name";

					
				}
			}
		}
		else if($selected_role=="Reseller")
		{
			//$u_id=$_REQUEST['u_id'];
			if($select_user_id=="All")
			{


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


        if(!isset($from_date) || !isset($to_date))
				{
					

					$sql = "select sum(msgcredit) as msgcredit,status,operator_name,sent_at from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 group by userids,status,operator_name";
				}
				else
				{

						$sql = "select sum(msgcredit) as msgcredit,status,operator_name,sent_at from $sendtabledetals where parent_id in (".$check_user_ids.") and (date(sent_at) BETWEEN '$from_date' and '$to_date')and schedule_sent=1 group by userids,status,operator_name";

					
				}


				
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


         if(!isset($from_date) || !isset($to_date))
				{
					

					/*$sql = "select sum(msgcredit) as msgcredit,status,operator_name,sent_at from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 group by userids,status,operator_name";*/

					$sql = "select sum(msgcredit) as msgcredit,status,operator_name,sent_at from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 group by userids,status,operator_name";
				}
				else
				{

					$sql = "select sum(msgcredit) as msgcredit,status,operator_name,sent_at from $sendtabledetals where parent_id in (".$check_user_ids.") and (date(sent_at) BETWEEN '$from_date' and '$to_date') and schedule_sent=1 group by userids,status,operator_name";

						/*$sql = "select sum(msgcredit) as msgcredit,status,operator_name,sent_at from $sendtabledetals where parent_id in (".$check_user_ids.") and (date(sent_at) BETWEEN '$from_date' and '$to_date')and schedule_sent=1 group by userids,status,operator_name";*/

					
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

				 if(!isset($from_date) || !isset($to_date))
				{
					


					$sql="select sum(msgcredit) as msgcredit,status,operator_name,sent_at from $sendtabledetals where userids in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids,status,operator_name";
				}
				else
				{

					$sql="select sum(msgcredit) as msgcredit,status,operator_name,sent_at from $sendtabledetals where userids in (".$check_user_ids.") and (date(sent_at) BETWEEN '$from_date' and '$to_date') and schedule_sent=1 and (msgcredit>0) group by userids,status,operator_name"; 
					
				}


				/*$sql="select sum(msgcredit) as msgcredit,status,operator_name,sent_at from $sendtabledetals where userids in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids,status,operator_name";*/
			}
			else
			{

			/*	$user_ids=fetch_allusers();
				$check_user_ids=implode(",",$user_ids);*/
				/*$sql="select sum(msgcredit) as msgcredit,status,operator_name,sent_at from $sendtabledetals where  date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids,status,operator_name";
*/

				if(!isset($from_date) || !isset($to_date))
				{
					$sql="select sum(msgcredit) as msgcredit,status,operator_name,sent_at from $sendtabledetals where  date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids,status,operator_name";
				}
				else
				{

					$sql="select sum(msgcredit) as msgcredit,status,operator_name,sent_at from $sendtabledetals where  (date(sent_at) BETWEEN '$from_date' and '$to_date') and schedule_sent=1 and (msgcredit>0) group by userids,status,operator_name";

				/*	$sql="select sum(msgcredit) as msgcredit,status,operator_name,sent_at from $sendtabledetals where userids in (".$check_user_ids.") and (date(sent_at) BETWEEN '$from_date' and '$to_date') and schedule_sent=1 and (msgcredit>0) group by userids,status,operator_name"; */
					
				}



			}
		}
		else if($selected_role=="Reseller")
		{
			if($select_user_id=='All')
			{
				$all_resellers=fetch_allresellers();

        $check_user_ids=implode(",",$all_resellers);

        if(!isset($from_date) || !isset($to_date))
				{
						
				$sql="select sum(msgcredit) as msgcredit,status,operator_name,sent_at from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids,status,operator_name";
				}
				else
				{

				$sql="select sum(msgcredit) as msgcredit,status,operator_name,sent_at from $sendtabledetals where parent_id in (".$check_user_ids.") and (date(sent_at) BETWEEN '$from_date' and '$to_date') and schedule_sent=1 and (msgcredit>0) group by userids,status,operator_name";

				}

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
          

           if(!isset($from_date) || !isset($to_date))
				{
						
				$sql="select sum(msgcredit) as msgcredit,status,operator_name,sent_at from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids,status,operator_name";
				}
				else
				{
					$sql="select sum(msgcredit) as msgcredit,status,operator_name,sent_at from $sendtabledetals where parent_id in (".$check_user_ids.") and (date(sent_at) BETWEEN '$from_date' and '$to_date') and schedule_sent=1 and (msgcredit>0) group by userids,status,operator_name";
				}


				 /*$sql="select sum(msgcredit) as msgcredit,status,operator_name,sent_at from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids,status,operator_name";*/
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

        if(!isset($from_date) || !isset($to_date))
				{
						
				 $sql="select sum(msgcredit) as msgcredit,status,operator_name,sent_at from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids,status,operator_name";
				}
				else
				{
					 $sql="select sum(msgcredit) as msgcredit,status,operator_name,sent_at from $sendtabledetals where parent_id in (".$check_user_ids.") and (date(sent_at) BETWEEN '$from_date' and '$to_date') and schedule_sent=1 and (msgcredit>0) group by userids,status,operator_name";


				}



			
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

        if(!isset($from_date) || !isset($to_date))
				{
						
				 $sql="select sum(msgcredit) as msgcredit,status,operator_name,sent_at from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids,status,operator_name";
				}
				else
				{
					$sql="select sum(msgcredit) as msgcredit,status,operator_name,sent_at from $sendtabledetals where parent_id in (".$check_user_ids.") and (date(sent_at) BETWEEN '$from_date' and '$to_date') and schedule_sent=1 and (msgcredit>0) group by userids,status,operator_name";

					

				}
                     
				 
			}
		}
		else if($selected_role=='All')
		{

			if(!isset($from_date) || !isset($to_date))
				{
					$sql = "select sum(msgcredit) as msgcredit,status,operator_name,sent_at from $sendtabledetals where date(sent_at)='$today_dt' and schedule_sent=1 group by userids,status,operator_name";
						
				}
				else
				{
					$sql = "select sum(msgcredit) as msgcredit,status,operator_name,sent_at from $sendtabledetals where (date(sent_at) BETWEEN '$from_date' and '$to_date') and schedule_sent=1 group by userids,status,operator_name";

				}


			
		}
	}
	else
	{


		 if(!isset($from_date) || !isset($to_date))
				{
					$sql = "select sum(msgcredit) as msgcredit,status,operator_name,sent_at from $sendtabledetals where userids='".$userid."' and date(sent_at)='$today_dt' and schedule_sent=1 group by userids,status,operator_name";
						
				 
				}
				else
				{

					$sql = "select sum(msgcredit) as msgcredit,status,operator_name,sent_at from $sendtabledetals where userids='".$userid."' and (date(sent_at) BETWEEN '$from_date' and '$to_date') and schedule_sent=1 group by userids,status,operator_name";

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
   			
   			<th>Username</th><th>Campaign Name</th><th>Date</th><th>Total</th>";

   		$status_arr=array_unique($status);


	   		for($k=0;$k<count($status);$k++)
	   		{
	   			if($status_arr[$k]!='')
	   			{
	   				$status_arr1[]=$status_arr[$k];
	   			}
	   			
	   		}

	   	
   		$sql_select="Select sum(msgcredit) as msgcredit,userids,operator_name,sent_at";
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
			
				 if(!isset($from_date) || !isset($to_date))
				{
					$sql_select.=" from $sendtabledetals where parent_id in (".$parent_id.") and date(sent_at)='$today_dt' and schedule_sent=1 group by userids,operator_name";
				}
				else
				{
					$sql_select.=" from $sendtabledetals where parent_id in (".$parent_id.") and (date(sent_at) BETWEEN '$from_date' and '$to_date') and schedule_sent=1 group by userids,operator_name";
				}
				
			}
			else
			{
				 if(!isset($from_date) || !isset($to_date))
				{
					$sql_select.=" from $sendtabledetals where userids in (".$u_id.") and date(sent_at)='$today_dt' and schedule_sent=1 group by userids,operator_name";
				}
				else
				{
					$sql_select.=" from $sendtabledetals where userids in (".$u_id.") and (date(sent_at) BETWEEN '$from_date' and '$to_date') and schedule_sent=1 group by userids,operator_name";

				}
				
			}
		}
		else if($selected_role=="Reseller")
		{
		
			if($u_id=="All")
			{
				
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

                if(!isset($from_date) || !isset($to_date))
				{
					$sql_select.=" from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 group by userids,operator_name";

				}
				else
				{
					$sql_select.=" from $sendtabledetals where parent_id in (".$check_user_ids.") and (date(sent_at) BETWEEN '$from_date' and '$to_date') and schedule_sent=1 group by userids,operator_name";

				}
				
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


                if(!isset($from_date) || !isset($to_date))
				{
						$sql_select.=" from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 group by userids,operator_name";
				}
				else
				{
						$sql_select.=" from $sendtabledetals where parent_id in (".$check_user_ids.") and (date(sent_at) BETWEEN '$from_date' and '$to_date') and schedule_sent=1 group by userids,operator_name";

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

				 if(!isset($from_date) || !isset($to_date))
				{
				$sql_select.=" from $sendtabledetals where userids in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids,operator_name";
				}
				else
				{
					$sql_select.=" from $sendtabledetals where userids in (".$check_user_ids.") and (date(sent_at) BETWEEN '$from_date' and '$to_date') and schedule_sent=1 and (msgcredit>0) group by userids,operator_name";
				}
			}
			else
			{

				 if(!isset($from_date) || !isset($to_date))
				{
				$sql_select.=" from $sendtabledetals where date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids,operator_name";
				}
				else
				{
					$sql_select.=" from $sendtabledetals where (date(sent_at) BETWEEN '$from_date' and '$to_date')and schedule_sent=1 and (msgcredit>0) group by userids,operator_name";
				}
			}
		}
		else if($selected_role=="Reseller")
		{
			if($select_user_id=='All')
			{
				$all_resellers=fetch_allresellers();

        $check_user_ids=implode(",",$all_resellers);

        		if(!isset($from_date) || !isset($to_date))
				{
			
				 $sql_select.=" from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids,operator_name";
				}
				else
				{
					 $sql_select.=" from $sendtabledetals where parent_id in (".$check_user_ids.") and (date(sent_at) BETWEEN '$from_date' and '$to_date') and schedule_sent=1 and (msgcredit>0) group by userids,operator_name";	
				}
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
                     
                if(!isset($from_date) || !isset($to_date))
				{
			
				 $sql_select.=" from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids,operator_name";
				}
				else
				{
				$sql_select.=" from $sendtabledetals where parent_id in (".$check_user_ids.") and (date(sent_at) BETWEEN '$from_date' and '$to_date') and schedule_sent=1 and (msgcredit>0) group by userids,operator_name";
				}
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

                if(!isset($from_date) || !isset($to_date))
				{
			 $sql_select.=" from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids,operator_name";
				}
				else
				{
					$sql_select.=" from $sendtabledetals where parent_id in (".$check_user_ids.") and (date(sent_at) BETWEEN '$from_date' and '$to_date') and schedule_sent=1 and (msgcredit>0) group by userids,operator_name";
				}
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
                     
                 if(!isset($from_date) || !isset($to_date))
				{
				 $sql_select.=" from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids,operator_name";
				}
				else
				{
				$sql_select.=" from $sendtabledetals where parent_id in (".$check_user_ids.") and (date(sent_at) BETWEEN '$from_date' and '$to_date') and schedule_sent=1 and (msgcredit>0) group by userids,operator_name";	
				}
			}
		}
		else if($selected_role=='All')
		{
			if(!isset($from_date) || !isset($to_date))
			{
			$sql_select.= " from $sendtabledetals where date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userids,operator_name";
			}
			else
			{
				$sql_select.= " from $sendtabledetals where (date(sent_at) BETWEEN '$from_date' and '$to_date') and schedule_sent=1 and (msgcredit>0) group by userids,operator_name";
			}
		}

	}
	else
	{
		if(!isset($from_date) || !isset($to_date))
			{
			$sql_select.=" from $sendtabledetals where userids='".$userid."'  and date(sent_at)='$today_dt' and schedule_sent=1 group by userids,operator_name";
			}
			else
			{
				$sql_select.=" from $sendtabledetals where userids='".$userid."'  and (date(sent_at) BETWEEN '$from_date' and '$to_date') and schedule_sent=1 group by userids,operator_name";
			}
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
  				$operator_name=$row['operator_name'];
  				$sent_at=$row['sent_at'];
  				$u_id=$userid;
  				$username=get_username($userid);
  				$table_body.="<tr>
  				
  				<td>$username</td>
  				<td>$operator_name</td>
  				<td>$sent_at</td>

  				<td><a href='#' class='report_type' name='total' data-role='$user_role' data-uid='$u_id' data-operator='$operator_name' data-selected_role='$selected_role'>$bill_credit</a></td>";
  				$total_stat_val=0;
  				for($j=0;$j<count($status_arr1);$j++)
		   		{
		   			$stat=$status_arr1[$j];
		   			$stat_val=$row[$stat];
		   			$total_stat_val[$stat]=$stat_val;
		   			$table_body.="<td><a href='#' class='report_type' name='$stat' data-role='$user_role' data-operator='$operator_name' data-uid='$u_id' data-selected_role='$selected_role'>$stat_val</a></td>";
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
  			$table_body2.="<td></td><td></td><td>$total_bill</td>";
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

function fetch_resellers($u_id)
{
	global $dbc;

	//echo "dzsf ".$u_id;
	
	
	$sql="select userid from az_user where parent_id='".$u_id."' and user_role='mds_rs'";

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
			$created_dt=date("d-m-Y h:i",strtotime($row['sent_at']));
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