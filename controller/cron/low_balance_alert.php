<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/*error_reporting(0);*/
include('/var/www/html/itswe_panel/include/connection.php');
/*include('../../include/config.php');
*/


low_bal_alert();

function low_bal_alert()
{


	global $dbc;
	
	

	$sql_settings="select s.`userid`,s.`low_bal_limit`,s.`low_bal_mobile`,sum(c.balance) as balance from settings as s join az_credit_manage as c on s.userid=c.userid where s.low_balance='Yes' group by c.userid ";
	//$sql_settings="select s.`userid`,s.`low_bal_limit`,s.`low_bal_mobile`,sum(c.balance) as balance from settings as s join az_credit_manage as c on s.userid=c.userid where s.low_balance='Yes' and s.userid='4548' ";


	$result_settings=mysqli_query($dbc,$sql_settings) or die(mysqli_error($dbc));
	$count_users=mysqli_num_rows($result_settings);

	if($count_users>0)
	{
			while($row_settings=mysqli_fetch_array($result_settings)) 
			{

					$user_ids[]=$row_settings['userid'];	
					$bal_limit[]=$row_settings['low_bal_limit'];	
					$mobile_no[]=$row_settings['low_bal_mobile'];	
					$current_balance[]=$row_settings['balance'];	
			}

			if(!empty($user_ids))
			{

				for($i=0;$i<count($user_ids);$i++)
				{

								if($current_balance[$i]<$bal_limit[$i])
								{
									$sql_user="select client_name,mobile_no from az_user where userid='".$user_ids[$i]."' limit 1";

										$result_user=mysqli_query($dbc,$sql_user) or die(mysqli_error($dbc));
										$row=mysqli_fetch_array($result_user);
										$client_name=$row['client_name'];
									
										if($mobile_no[$i]=='' || empty($mobile_no[$i]))
										{

											$mobile_nos=$row['mobile_no'];
										}
										else
										{

											$mobile_no_arr=array();
											if( strpos($mobile_no[$i], ",") !== false ) {
											     $mobile_no_arr[]=explode(",",$mobile_no[$i]);
											}
											$mobile_nos= $mobile_no[$i];
										}
										
										$sql_credit_route="select * from az_credit_manage where userid='".$user_ids[$i]."'";
										$result_credit_route=mysqli_query($dbc,$sql_credit_route) or die(mysqli_error($dbc));

										while($row_credit_route=mysqli_fetch_array($result_credit_route))
										{
												$route_id=$row_credit_route['az_routeid'];
												$route_name[]=fetch_route_name($route_id);
												$route_bal[]=$row_credit_route['balance'];
												
										}
										
										for($j=0;$j<count($route_name);$j++)
										{
												$route_dtls[]=$route_name[$j] ."  ".$route_bal[$j];
										}


										$route_dtlss=implode(" , ", $route_dtls);
										unset($route_name);
										unset($route_dtls);
										unset($route_bal);

										$msg="Dear $client_name,Your Account balance is low. Your remaining balance is $route_dtlss to recharge your account please contact your account manager. %0a Thank You!!!";
										//$msg=$msg." ".$route_dtlss;

										
						        $msg=str_replace(' ', '%20', $msg);
				// 		       $url = "https://vapio.in/api.php?username=alerts&apikey=0DZd1IoaL2XB&senderid=MDACCT&route=OTP&mobile=$mobile_nos&text=$msg";
						      

				// 		      $ch  = curl_init($url);
                  // curl_setopt($ch, CURLOPT_HTTPGET, "POST");
                  // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                  // $result = curl_exec($ch);
                  // echo $result;
                  
                  if(!empty($mobile_no_arr))
                  {
                  	for($j=0;$j<count($mobile_no_arr[0]);$j++)
                  	{
                  		$mob=$mobile_no_arr[0][$j];

                  		echo $mob;
                  		$url_whatsapp = "https://web.vapio.in/api/send.php?number=$mob&type=text&message=$msg&instance_id=63B2B21F36A1B&access_token=c557e35c2215a777cd195bd920956db8";
                  		 $ch  = curl_init($url_whatsapp);
	                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	                    curl_setopt($ch, CURLOPT_HTTPGET, "POST");
	                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	                    $result = curl_exec($ch);
	                    curl_close($ch); 


                  	}
                  	
                  }
                  else
                  {

                  	$url_whatsapp = "https://web.vapio.in/api/send.php?number=$mobile_nos&type=text&message=$msg&instance_id=63B2B21F36A1B&access_token=c557e35c2215a777cd195bd920956db8";

                  	 $ch  = curl_init($url_whatsapp);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt($ch, CURLOPT_HTTPGET, "POST");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($ch);
                    curl_close($ch); 

                  }
                  
                    
                    
                   
						                

								}
						
				}


			}
	}

}




// function low_bal_email_alert()
// {

// 	global $dbc;
// 	$sql_settings="select `userid`,sum(balance) as balance from az_credit_manage where userid in ('','','','','') group by userid";
// 	$result_settings=mysqli_query($dbc,$sql_settings) or die(mysqli_error($dbc));
// 	$count_users=mysqli_num_rows($result_settings);

// 	if($count_users>0)
// 	{
// 			while($row_settings=mysqli_fetch_array($result_settings)) 
// 			{

// 					$user_ids[]=$row_settings['userid'];	
// 					// $bal_limit[]=$row_settings['low_bal_limit'];	
// 					// $mobile_no[]=$row_settings['low_bal_mobile'];	
// 					$current_balance[]=$row_settings['balance'];	
// 			}

// 			if(!empty($user_ids))
// 			{

// 				for($i=0;$i<count($user_ids);$i++)
// 				{

// 									  $sql_user="select client_name,mobile_no from az_user where userid='".$user_ids[$i]."' limit 1";

// 										$result_user=mysqli_query($dbc,$sql_user) or die(mysqli_error($dbc));
// 										$row=mysqli_fetch_array($result_user);
// 										$client_name=$row['client_name'];
																									
// 										$sql_credit_route="select * from az_credit_manage where userid='".$user_ids[$i]."'";
// 										$result_credit_route=mysqli_query($dbc,$sql_credit_route) or die(mysqli_error($dbc));

// 										while($row_credit_route=mysqli_fetch_array($result_credit_route))
// 										{
// 												$route_id=$row_credit_route['az_routeid'];
// 												$route_name[]=fetch_route_name($route_id);
// 												$route_bal[]=$row_credit_route['balance'];
												
// 										}
										
// 										for($j=0;$j<count($route_name);$j++)
// 										{
// 												$route_dtls[]=$route_name[$j] ."  ".$route_bal[$j];
// 										}


// 										$route_dtlss=implode(" , ", $route_dtls);
// 										unset($route_name);
// 										unset($route_dtls);
// 										unset($route_bal);

// 										$msg="Dear $client_name,Your Account balance is low. Your remaining balance is $route_dtlss to recharge your account please contact your account manager. %0a Thank You!!!";
// 										//$msg=$msg." ".$route_dtlss;

										
// 						        $msg=str_replace(' ', '%20', $msg);
				
           
						
// 				}


// 			}
// 	}

// }



	function fetch_route_name($route_id)
	{
			global $dbc;

			$sql_route="select az_rname from az_routetype where az_routeid='".$route_id."'";
			$result_route=mysqli_query($dbc,$sql_route) or die(mysqli_error($dbc));
										while($row_route=mysqli_fetch_array($result_route))
										{
											
												$route_name=$row_route['az_rname'];
											
										}

										return $route_name;


	}


?>
