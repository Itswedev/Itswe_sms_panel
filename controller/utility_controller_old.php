<?php
session_start();
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
$log_file = "../error/logfiles/utility_controller.log";
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);


include_once('../include/connection.php');
require('classes/ssp.class.php');
include('../include/config.php');
include('classes/last_activities.php');
//include_once('../include/datatable_dbconnection.php');

if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'all_recharge_history')
{

   $recharge_history= loadData();
   echo $recharge_history;

}
else if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'all_user')
{

  /* $userdata= loadUserData();
   echo $userdata;*/
    	
			$table = USER;

			$primaryKey = 'userid';

			$columns = array(
					array( 'db' => 'userid','dt' => 0 ),
			    array( 'db' => 'parent_id','dt' => 1,'formatter'=>function($d,$row){
			    	$parent_name=get_username($d); 
			    	return $parent_name;
			    } ),
			    array( 'db' => 'user_name','dt' => 2 ),
			    array( 'db' => 'route_ids','dt' => 3 ,'formatter' => function( $d, $row ) {

			    	$route_name=fetch_route_names($d,$row[0]);

			    	return $route_name;

			    }),
			    array( 'db' => 'user_role','dt' => 4 ,'formatter' => function( $d, $row ) {

						    	 if($d=="mds_usr")
			             {
			                $user_role="User";
			             }
			             else if($d=="mds_rs")
			             {
			               $user_role="Reseller";
			             }
			             else if($d=="mds_acc")
			             {
			               $user_role="Accounts";
			             }
			             else if($d=="mds_ad")
			             {
			               $user_role="Admin";
			             }
			             else if($d=="mds_su_ad")
			             {
			               $user_role="Super Admin";
			             }
			             else if($d=="mds_adm")
			             {
			               $user_role="Administrator";
			             }

			            return $user_role;
			        }),
			    array( 'db' => 'user_status','dt' => 5,'formatter' => function( $d, $row ) {

			    			if($d=='1')
								{
									$color="#5e6e82";
									$stat="Active";
								}
								else
								{
									$color="red";
									$stat="Deactive";
								}

								return "<span style='color:$color;'>".$stat."</span>";

			    } ),
			    	array(
			        'db'        => 'created',
			        'dt'        => 6,
			        'formatter' => function( $d, $row ) {
			            return date( 'd-m-Y H:i', strtotime($d));
			        }
			    ),
			    array( 'db' => 'userid','dt' => 7,'formatter' => function( $d, $row ) {
			    	if($row[5]=='1')
			    	{
			    		$btn_class="inactive_user_btn";
			    		$btn_val="Inactive";
			    	}else
			    	{
			    		$btn_class="active_user_btn";
			    		$btn_val="Active";
			    	}
			    		$action="<div class='btn-group'>
								  <button class='btn dropdown-toggle mb-2 btn-primary' type='button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Action</button>
								  <div class='dropdown-menu'>
									 
										 <button class='dropdown-item user_edit_btn' id='$d' data-id='$d'>Edit</button>
							
								   
								    <button class='dropdown-item $btn_class' data-id='$d' >$btn_val</button>
								    <div class='dropdown-divider'></div>
								    <button class='dropdown-item login_to_acct' data-id='$d'>Login To account</button>
								  </div>
									</div>";
			            return $action;
			        })
			   
			);
			 
			// SQL server connection information
		 global $sql_details ;

			$extraWhere="";

			$userid=$_SESSION['user_id'];
			if($userid!='1')
			{
				if($extraWhere!="")
				{
					$extraWhere=" and parent_id='$userid' and user_role!='mds_acc' ";
				}
				else
				{
					$extraWhere=" parent_id='$userid' and user_role!='mds_acc' ";
				}
			}
			else
			{
				$extraWhere=" user_role!='mds_acc'";
			}

			echo json_encode(
			    SSP::complex( $_REQUEST, $sql_details, $table, $primaryKey, $columns,$test=null,$extraWhere )
			);

}
else if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'save_profile')
{

  	$save_profile=save_profile();
  	echo $save_profile;

}
else if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'inactive_user')
{

  	$inactive_user=inactive_user();
  	echo $inactive_user;

}
else if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'active_user')
{

  	$active_user=active_user();
  	echo $active_user;

}
else if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'login_to_acct')
{

  	$login_to_acct=login_to_acct();
  	echo $login_to_acct;

}
else if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'overview')
{
	$edit_userid=$_REQUEST['userid'];
   $overview= load_overview($edit_userid);
  //print_r($overview);
   echo json_encode($overview);

}


function load_overview($edit_userid)
{

	global $dbc;
	$login_user=$_SESSION['user_id'];
	$edit_userid=$_SESSION['edit_userid'];
	$sql="select * from `az_user` where userid='$edit_userid'";
	$result=mysqli_query($dbc,$sql);
	$count=mysqli_num_rows($result);
	if($count>0)
	{
		

		$i=1;
		while($row=mysqli_fetch_array($result))
		{
			$record_user[]=$row;
			$record_user['cut_off_route'][]=$row['cut_off_route'];
			$record_user['cut_off_status'][]=$row['cut_off_status'];
			$record_user['all_cut_off_status']=['Delivered','Failed','Submitted'];
			//$record_user['vsms']=['Yes'];
			if($row['gvsms']=='Yes')
			{
				$sql_vsms="select * from vsms_dtls where userid='".$edit_userid."'";
				$result_vsms=mysqli_query($dbc,$sql_vsms);
				while($row_vsms=mysqli_fetch_array($result_vsms))
				{
					$record_user['vsms']=$row_vsms;
				}
			}
			
			$route_ids=explode(",",$row['route_ids']);
			//$route_dtls[]=$route_ids;
						foreach($route_ids as $routeid)
						{
							$route_dtls['id'][]=$routeid;
							
						}

			$route_dtls['all_route']=fetch_route_name();
			$role=$row['user_role'];

			 if($role=="mds_usr")
             {
                $user_role['role']="User";
             }
             else if($role=="mds_rs")
             {
               $user_role['role']="Reseller";
             }
             else if($role=="mds_acc")
             {
               $user_role['role']="Accounts";
             }
             else if($role=="mds_ad")
             {
               $user_role['role']="Admin";
             }
             else if($role=="mds_su_ad")
             {
               $user_role['role']="Super Admin";
             }
             else if($role=="mds_adm")
             {
               $user_role['role']="Administrator";
             }

			$user_role['role_hash']= password_hash($role,PASSWORD_DEFAULT);
		}

		//$record_user['user_dtls']=$record_user;

			$sql_plan="select * from `az_plan_assign` where userid='$edit_userid'";
			$result_plan=mysqli_query($dbc,$sql_plan);
			$count_plan=mysqli_num_rows($result_plan);
			if($count_plan>0)
			{
					while($row_plan=mysqli_fetch_array($result_plan))
					{
						$pid=$row_plan['pid'];
						$plan_name['selected']=fetch_plan_name($pid);

						
					}

				$plan_name['all']=fetch_plan_name();
				
				
			//	$record=array_merge($record_user,$plan_name,$route_dtls,$user_role);
			}
			else
			{
				$plan_name['all']=fetch_plan_name();
				
				
			}
			$record=array_merge($record_user,$plan_name,$route_dtls,$user_role);
			$sql_cutoff="select * from `cut_off_dtls` where userid='$edit_userid'";
			$result_cutoff=mysqli_query($dbc,$sql_cutoff);
			$count_cutoff=mysqli_num_rows($result_cutoff);
			if($count_cutoff>0)
			{
				while($row_cut_off=mysqli_fetch_array($result_cutoff))
				{
					$record_cut_off['cut_off_dtls']=$row_cut_off;
				}
				$record=array_merge($record_user,$plan_name,$route_dtls,$user_role,$record_cut_off);

			}


				
			/*$vsms_dtls['vsms']=['1','2'];
			$record=array_merge($record_user,$plan_name,$route_dtls,$user_role,$record_cut_off,$vsms_dtls);*/
/*
			$sql_vsms="select * from `vsms_dtls` where userid='$edit_userid'";
			$result_vsms=mysqli_query($dbc,$sql_vsms);
			$vsms_dtls['vsms_dtls']=$count_vsms=mysqli_num_rows($result_vsms);*/
			/*if($count_vsms>0)
			{
					while($row_vsms=mysqli_fetch_array($result_vsms))
					{
						$vsms_dtls['vsms_dtls']=$row_vsms;
					}
					$record=array_merge($record_user,$plan_name,$route_dtls,$user_role,$record_cut_off,$vsms_dtls);
			}
*/
			//$record=array_merge($record_user,$plan_name,$route_dtls,$user_role,$record_cut_off,$vsms_dtls);
			//$user_roles[]=fetch_user_roles();
			
		return $record;
	}
	else
	{
		return 0;
	}

}


function inactive_user()
{
	global $dbc;
	$u_id=$_REQUEST['u_id'];

	$update_query="update az_user set user_status=0 where userid='".$u_id."'";
	$rs=mysqli_query($dbc,$update_query);

	if($rs)
	{
		return 1;
	}
	else
	{
		return 0;
	}

}

function active_user()
{
	global $dbc;
	$u_id=$_REQUEST['u_id'];

	$update_query="update az_user set user_status=1 where userid='".$u_id."'";
	$rs=mysqli_query($dbc,$update_query);

	if($rs)
	{
		return 1;
	}
	else
	{
		return 0;
	}

}
function login_to_acct()
{
	global $dbc;
	$u_id=$_REQUEST['u_id'];
	$parent_id=$_SESSION['user_id'];
	$q1 = mysqli_query($dbc, "SELECT *  FROM `az_user` WHERE `userid` = '{$parent_id}' LIMIT 1");

	$row1 = mysqli_fetch_assoc($q1);
	$parent_name=$row1['user_name'];

	$q = mysqli_query($dbc, "SELECT *  FROM `az_user` WHERE `userid` = '{$u_id}' LIMIT 1");
	$count = mysqli_num_rows($q);
	$row_login = mysqli_fetch_assoc($q);
	if ($count > 0) {

						unset($_SESSION['user_id']);
						unset($_SESSION['user_role']);
						session_unset();
						session_destroy();
						session_start();
						session_regenerate_id(true);
		   			$_SESSION['user_id']=$row_login['userid'];
            $_SESSION['user_name']=$row_login['user_name'];
            $_SESSION['client_name']=$row_login['client_name'];
            $_SESSION['status']=$row_login['user_status'];
            $_SESSION['user_role']=$row_login['user_role'];
            $_SESSION['parent_id']=$row_login['parent_id'];
            $_SESSION['miscall_access']=$row_login['miscall_report'];
            $_SESSION['vsms_access']=$row_login['gvsms'];
            $_SESSION['rcs_access']=$row_login['rcs'];
            $_SESSION['acct_manager']=$row_login['acct_manager'];
            $_SESSION['rcs']=$row_login['rcs'];
            $_SESSION['miscall_report']=$row_login['miscall_report'];
            $_SESSION['gvsms']=$row_login['gvsms'];
            $_SESSION['BlockNum'] = 'BlockNum';
            $_SESSION['restricted_tlv'] = $row_login['restricted_tlv'];
            $_SESSION['api_key'] = $row_login['api_key'];
            $_SESSION['restricted_report'] = $row_login['restricted_report'];
            $_SESSION['profile_pic'] = $row_login['profile_pic'];


             if ($row_login['permissions'] != "") {
                $data = explode(',', $row_login['permissions']);
                foreach ($data as $key => $value) {
                    $_SESSION[$value] = $value;
                    if ($value == 'LiveStatus') {
                        $live = 'live-status';
                    }
                    if($value == 'OTP') {
                        $secure = true;
                    }
                }
            }

            $ip_address = $_SERVER['REMOTE_ADDR'];
            $login_date=time();
            $login_dt_time=date("d-m-Y h:i A",$login_date);
            $logout_date='';
            get_last_activities($row_login['userid'],"login Success by IP: $ip_address at $login_dt_time by $parent_name ",$login_date,$logout_date);
            return 1;
	}
	else
	{
			return 0;
	}

}




function fetch_plan_name($pid='')
{
	global $dbc;
	if($pid!='')
	{
		$sql_plan=mysqli_query($dbc,"select * from az_plan where pid='".$pid."'");
		while($row_plan=mysqli_fetch_array($sql_plan))
		{

			$plan_name['p_name'][]=$row_plan['p_name'];
			$plan_id['p_id'][]=$row_plan['pid'];
		}
	}
	else
	{
		$sql_plan=mysqli_query($dbc,"select * from az_plan ");
		while($row_plan=mysqli_fetch_array($sql_plan))
		{
			$plan_name['p_name'][]=$row_plan['p_name'];
			$plan_id['p_id'][]=$row_plan['pid'];
		}
	}
	
	$plan_option=array_merge($plan_id,$plan_name);
	
	return $plan_option;
}
function save_profile()
{
	$userid=$_REQUEST['userid'];
	return $userid;
}
function loadData()
{
	global $dbc;
	$userid=$_SESSION['user_id'];
	$sql="select c_dtls.assign_credit as a_credit,c_mng.az_routeid as routeid,c_dtls.balance as d_balance,c_dtls.remark as rmk ,c_dtls.debit_credit as dc_type,c_dtls.credit_date as c_dt from az_credit_details as c_dtls join az_credit_manage as c_mng on c_dtls.crmdid=c_mng.crmid where c_mng.userid='$userid' order by c_dtls.created desc";
	$result=mysqli_query($dbc,$sql) or die(mysqli_error($dbc));
	$count=mysqli_num_rows($result);
	if($count>0)
	{
		$i=1;
		while($row=mysqli_fetch_array($result))
		{
			$credit_type=$row['dc_type'];
			if($credit_type=='1')
			{
				$type="Credit";
			}
			else
			{
				$type="Debit";
			}

			$routeid=$row['routeid'];
			$route_name=fetch_route_name($routeid);
			$data.="<tr><td width='10%'>$i</td>
				<td width='10%'> ".date('d-M-Y h:i:s', strtotime($row['c_dt']))."</td>
	        	<td width='10%'> ".$route_name."</td>
	        	
	        	<td width='10%'> ".$type."</td>
	        	<td width='10%'> ".$row['a_credit']."</td>
	          	<td width='10%'> ".$row['d_balance']."</td>
	          	<td width='10%'> ".$row['rmk']."</td>
	          

	        	</tr>";
	        $i++;
		}

		return $data;
	}
	else
	{
		return 0;
	}
}



function loadUserData()
{
	global $dbc;
	$userid=$_SESSION['user_id'];

	$role=$_SESSION['role'];

	if($role!='mds_adm')
	{
		$sql="select * from az_user where parent_id='$userid'";
	}
	else
	{
		$sql="select * from az_user ";
	}


	
	$result=mysqli_query($dbc,$sql);
	$count=mysqli_num_rows($result);
	if($count>0)
	{
		$i=1;
		while($row=mysqli_fetch_array($result))
		{

			$u_id=$row['userid'];
			
			$sql_credit=mysqli_fetch_array(mysqli_query($dbc,"select * from az_credit_manage where userid='".$u_id."'"));

			$credit_bal=$sql_credit['balance'];
			$routeids=$row['route_ids'];
			$status=$row['user_status'];
			if($status=='1')
			{
				$stat="Active";
			}
			else
			{
				$stat="Deactive";
			}
			$route_name=fetch_route_names($routeids,$u_id);
			$data.="<tr><td width='3%'>$i</td>
			<td width='10%'> ".$row['client_name']."</td>
			<td width='10%'> ".$row['user_name']."</td>
	        	<td width='10%'> ".$route_name."($credit_bal)</td>
	        	
	        	<td width='10%'> ".$row['user_role']."</td>
	          	<td width='10%'> ".$stat."</td>
	          	
	          	<td width='10%'> ".date('d-M-Y', strtotime($row['created']))."</td>
	          	<td><div class='btn-group'>
				  <button class='btn dropdown-toggle mb-2 btn-primary' type='button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Action</button>
				  <div class='dropdown-menu'>
				  	
				   
				    <form action='dashboard.php' name='edit_user_form' id='form_$u_id' method='post'>
					<input type='hidden' name='page' value='edit_user'>
					<input type='hidden' name='edit_userid' value='$u_id'>
					 <a class='dropdown-item' id='$u_id' href='dashboard.php?page=edit_user&edit_userid=$u_id' data-id='$d' >Edit</a>
					</form>=
				   
				    <a class='dropdown-item' href='#'>Inactive</a>
				    <div class='dropdown-divider'></div>
				    <a class='dropdown-item' href='#'>Login To account</a>
				  </div>
				</div></td>
	        	</tr>";
	        $i++;
		}

		return $data;
	}
	else
	{
		return 0;
	}
}

function fetch_route_name($routeid='')
{
	global $dbc;
	
	if($routeid!='')
	{	
		$sql="select * from az_routetype where az_routeid='$routeid'";
	$result=mysqli_fetch_array(mysqli_query($dbc,$sql));
	$route_name=$result['az_rname'];

	return $route_name;

	}
	else
	{
		$sql="select * from az_routetype";
	$result=mysqli_query($dbc,$sql);

	while($row=mysqli_fetch_array($result))
	{
		$route_name['id'][]=$row['az_routeid'];
		$route_name['name'][]=$row['az_rname'];
	}
	

	return $route_name;
	}
	



}

function fetch_route_names($routeid,$u_id)
{
	global $dbc;
	$routeids=explode(",", $routeid);
	foreach($routeids as $routeid)
	{
		$sql="select * from az_routetype where az_routeid='$routeid'";
		$result=mysqli_fetch_array(mysqli_query($dbc,$sql));


		$sql_route_bal="select * from az_credit_manage where az_routeid='$routeid' and userid='".$u_id."'";
		$result_bal=mysqli_fetch_array(mysqli_query($dbc,$sql_route_bal));
		$r_name=$result['az_rname'];
		$r_bal=$result_bal['balance'];
		if($r_bal=="")
		{
			$r_bal=0;
		}
		$route_name.=$r_name." ($r_bal)".", ";
	}
	

	return $route_name;



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

?>