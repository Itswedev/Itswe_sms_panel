<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/*error_reporting(0);*/
include('../../include/connection.php');
/*include('../../include/config.php');
*/


daily_usage_alert();

function daily_usage_alert()
{


	global $dbc;
	$sql_user="select `userid` from az_user where user_status=1";
	$result_user=mysqli_query($dbc,$sql_user) or die(mysqli_error($dbc));
	while ($row=mysqli_fetch_array($result_user)) {
		$ids[]=$row['userid'];
	}
	 $idss=implode(",", $ids);
	
	$today_dt=date('Y-m-d');

	$sql_count_todays_credit="select sum(msgcredit) as total_credit,userids from az_sendnumbers where ((date(sent_at)='$today_dt')) and (schedule_sent=1) and userids in ($idss)";

	$result_count_todays_credit=mysqli_query($dbc,$sql_count_todays_credit) or die(mysqli_error($dbc));

	while($row_credit=mysqli_fetch_array($result_count_todays_credit)) 
	{

		$row_credit['userids'];
		if($row_credit['total_credit']!=0)
		{
			
			$user_ids[]=$row_credit['userids'];
			$total_credit[]=$row_credit['total_credit'];
		}
		
	}

	
	if(!empty($user_ids))
	{

		$user_idss=implode(",", $user_ids);
		$sql_remaining_bal="select sum(balance) as balance,userid from az_credit_manage where userid in ($user_idss)";

	$result_remaining_bal=mysqli_query($dbc,$sql_remaining_bal) or die(mysqli_error($dbc));
	while ($row_bal=mysqli_fetch_array($result_remaining_bal)) {
		if($row_bal['balance']!=0)
		{
			$user_bal_ids[]=$row_bal['userid'];
			$total_bal[]=$row_bal['balance'];
		}
		
	}

	}


	if(!empty($user_bal_ids))
	{
		$send_msg_userids=implode(",",$user_bal_ids);
		$sql_send_msg_userid="select * from az_user where userid in ($send_msg_userids)";
		$result_send_msg_userid=mysqli_query($dbc,$sql_send_msg_userid) or die(mysqli_error($dbc));
		while ($row_send_msg_userid=mysqli_fetch_array($result_send_msg_userid)) {

			$user_fname[]=$row_send_msg_userid['client_name'];
			$mobile_no[]=$row_send_msg_userid['mobile_no'];



		}

		for($i=0;$i<count($user_bal_ids);$i++)
		{
			$balance=$total_bal[$i];
			$name=$user_fname[$i];
			$mobile=$mobile_no[$i];
			$used_credits=$total_credit[$i];


		$msg="Dear $name,You have consumed $user_credits balance as on $today_dt your remaining balance is $balance SUPTMD";
        $msg=str_replace(' ', '%20', $msg);
        $url = "https://vapio.in/api.php?username=alerts&apikey=0DZd1IoaL2XB&senderid=MDACCT&route=OTP&mobile=$mobile&text=$msg";

                  $ch  = curl_init($url);
                  curl_setopt($ch, CURLOPT_HTTPGET, "POST");
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                  $result = curl_exec($ch);
                  echo $result;
		}
	}




}



?>