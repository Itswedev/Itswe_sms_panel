<?php
session_start();
$log_file = "../error/logfiles/credit_controller.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);
error_reporting(0);
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
$session_userid=$_SESSION['user_id'];
include('../include/connection.php');
include('classes/last_activities.php');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
if (isset($_POST['type']) && $_POST['type'] == 'save_credit') {
   $rs = saveCredit();
   echo $rs;
  	/*if($rs=='1')
  	{
  		echo "Credit Details added successfully";
  	}
  	else if($rs=='0')
  	{
		echo "Failed to add credit details";
  	}
  	else if($rs=='-1')
  	{
		echo "Available balance less than your debit count";
  	}*/
  


}
else if(isset($_POST['type']) && $_POST['type'] == 'load_table_dtls')
{
	 			$result = viewcredit();

            $return_creditlist=credit_list($result);

            echo $return_creditlist;
}
else if(isset($_POST['type']) && $_POST['type'] == 'fetch_route')
{
       $uid=$_REQUEST['u_id'];

            $return_route=fetch_route($uid);

            echo $return_route;
}
else if(isset($_POST['type']) && $_POST['type'] == 'load_acct_bal')
{
     

            $return_bal=load_acct_bal();

            echo $return_bal;
}

function load_acct_bal()
{
   global $dbc,$session_userid;

   $userid=$session_userid;
   $sql= "select balance,az_routeid from az_credit_manage where userid='".$userid."'";



   $result=mysqli_query($dbc,$sql);
   $bal=0;
   $load_bal_data="";
   while($row=mysqli_fetch_array($result))
   {
      $route_id=$row['az_routeid'];
      $sql_route="select az_rname from az_routetype where az_routeid='".$route_id."'";
      $result_route=mysqli_query($dbc,$sql_route);
      $row_route=mysqli_fetch_array($result_route);
      $route_name=$row_route['az_rname'];
      $bal=$row['balance'];
      // $load_bal_data.="  <div class='list-group-item'>
      //                     <a class='notification notification-flush notification-unread' href='#!'>
      //                       <div class='notification-avatar'>
      //                         <div class='avatar avatar-2xl me-3'>
      //                           <img class='rounded-circle' style='margin-top: -6px;' src='assets/images/icons8-money-64.png' alt='' />
      //                         </div>
      //                       </div>
      //                       <div class='notification-body'>
      //                         <p class='mb-1' style='margin-left: -10px;'><strong >$route_name</strong> :- $bal</p>
                             
      //                       </div>
      //                     </a>
      //                   </div>";

      $load_bal_data.="<li>
										<div class='d-flex bd-highlight'>
											<div class='img_cont info'>MO</div>
											<div class='user_info'>
												<span>".$route_name."</span>
												<p>".$bal."</p>
											</div>
										</div>
									</li>";

   }


   echo $load_bal_data;

}

function fetch_route($u_id)
{

  $userid=$u_id;
  global $dbc;
  $sql_route_ids= "select * from az_user where userid='".$userid."'";
  $query_route_id = mysqli_query($dbc, $sql_route_ids);

  // $count_plan=mysqli_num_rows($query_route_id);

      $result_route_id=mysqli_fetch_array($query_route_id);
      $route_ids=$result_route_id['route_ids'];


  $sql = "select * from az_routetype where az_routeid in ($route_ids) order by az_create_date desc";
  $query_result = mysqli_query($dbc, $sql);

   $count_route=mysqli_num_rows($query_result);
   $route_dropdown="<option value=''>Select Route</option>";
   if($count_route>0)
   {
 
             
             while($row=mysqli_fetch_array($query_result))
             {
                $route_dropdown.="<option value='".$row['az_routeid']."'>".$row['az_rname']."</option>";
             }

             return $route_dropdown;


         
    }
    else {
               return $route_dropdown;
          }
   



  
}
  function viewcredit() {
        global $dbc;
        $result = array();
        $userid=$_SESSION['user_id'];
        if($userid!='1')
        {
          $sql = "SELECT *  FROM az_credit_manage where created_by='$userid' ORDER BY created DESC";
        }
        else
        {
          $sql = "SELECT *  FROM az_credit_manage ORDER BY created DESC";
        }
        
        $values = mysqli_query($dbc, $sql);
        while ($row = mysqli_fetch_assoc($values)) {
            $crmid = $row['crmid'];
            $result[$crmid] = $row;
        }
        return $result;
    }

      function fetch_username($userid) {
        global $dbc;
        $result = array();
        $sql = "SELECT *  FROM `az_user` where `userid`='$userid'";
        $values = mysqli_query($dbc, $sql);
        while ($row = mysqli_fetch_assoc($values)) {
            $username = $row['user_name'];
            
        }
        return $username;
    }


      function credit_list($result)
        {
          $i = 1;
          if (!empty($result)) { 
         
           foreach ($result as $key => $value) { 
            $crm_id=$value['crmid'];
            $userid=$value['userid'];
            $username=fetch_username($userid);

             $credit_type=$value['debit_credit'];
             $assign_credit=$value['assign_credit'];
             $balance=$value['balance'];
				$remark=$value['remark'];
            $credit_date=date("d-M-Y h:i a",strtotime($value['credit_date']));
            $created=date("d-M-Y h:i a",strtotime($value['created']));
           $created_by=$value['created_by'];
            if($credit_type=='1')
            {
              $type='<span class="badge light badge-success">Credit</span>';
            }
            else if($credit_type=='0')
            {
              $type='<span class="badge light badge-danger">Debit</span>';
            }
            else if($credit_type=='2')
            {
              $type='<span class="badge light badge-warning">Refund</span>';
            }
           
              $return_creditlist.="<tr>
              <td width='5%'>$i</td>
              <td width='20%'>$username</td>
              <td width='20%'>$type</td>
              <td width='15%'>$assign_credit</td>
              <td width='15%'>$balance</td>
              <td width='15%'>$remark</td>
             
              <td width='20%'>$credit_date</td>
              
             
              </tr>";
            
                $i++;
                }

                return $return_creditlist;
          } 
          else
          {
            return "No record available";
          }
        }


function saveCredit()
{
	      global $dbc;
       /* $gateway_family = ucwords(trim($_POST['gateway_family']));*/
        $username = trim($_POST['username']);
        $credit_type = trim($_POST['credit_type']);
        $route = trim($_POST['route']);
        $credit = trim($_POST['credit']);
        $remark = trim($_POST['remark']);
        if($username!=1)
        {
            $sql_parent="select * from az_user where userid='$username'";
            $result_parent=mysqli_fetch_array(mysqli_query($dbc, $sql_parent));
            $login_user=$_SESSION['user_id'];

            $parent_id=$result_parent['parent_id'];


            $sql_parent_dtls="select * from az_user where userid='$parent_id'";
            $result_parent_dtls=mysqli_fetch_array(mysqli_query($dbc, $sql_parent_dtls));
            $parent_role=$result_parent_dtls['user_role'];

            $sql_select_parent = "SELECT * from az_credit_manage where `userid`='$parent_id' and az_routeid='$route'";
        
            $query_select_parent = mysqli_query($dbc, $sql_select_parent);
            $count_bal_parent=mysqli_num_rows($query_select_parent);

            if($count_bal_parent>0)
            {
              $result_parent_bal=mysqli_fetch_array($query_select_parent);

              $parent_bal=$result_parent_bal['balance'];
              if($parent_role=='mds_ad')
              {


                $overselling_limit=$parent_bal*10;
              }
              $insert_id_parent=$result_parent_bal['crmid'];
             

              $sql_select = "SELECT * from az_credit_manage where `userid`='$username' and az_routeid='$route'";
              $query_select = mysqli_query($dbc, $sql_select);
              $count_plan=mysqli_num_rows($query_select);



            $sql_user="select * from az_user where userid='$username' ";
            $result_user=mysqli_fetch_array(mysqli_query($dbc, $sql_user));
            $subusername=$result_user['user_name'];


              if($count_plan==0)
              {

              	if($credit_type=='1' || $credit_type=='2')
              	{

                  if($parent_role!='mds_ad')
                  {
                     if($parent_bal<$credit)
                      {
                        return 2;
                      }
                       $parent_bal=$parent_bal-$credit;
                  }
                  else
                  {
                       if($overselling_limit<$credit)
                      {
                        return 2;
                      }
                      // $parent_bal=$parent_bal-$credit;
                  }
                   


                    $balance=$credit;

                   
                		$sql_manage = "INSERT INTO `az_credit_manage`(`userid`,`debit_credit`,`assign_credit`,`balance`,`remark`,`credit_date`,`created`,`created_by`,`az_routeid`) VALUES('".$username."','".$credit_type."','".$credit."','".$balance."','".$remark."',now(),now(),'".$_SESSION['user_id']."','$route')";
        				    $query = mysqli_query($dbc, $sql_manage)or die(mysqli_error($dbc));
    		    
          		    	$sql_last_id = "select * from az_credit_manage where userid='$username' order by crmid desc limit 1";
          				  $query_last_id = mysqli_query($dbc, $sql_last_id)or die(mysqli_error($dbc));
            
            				$row_last_id=mysqli_fetch_array($query_last_id);

            				$insert_id=$row_last_id['crmid'];

              	 		$sql_details = "INSERT INTO `az_credit_details`(`crmdid`,`userid`,`debit_credit`,`assign_credit`,`balance`,`remark`,`credit_date`,`created`,`created_by`,`az_routeid`) VALUES('".$insert_id."','".$username."','".$credit_type."','".$credit."','".$balance."','".$remark."',now(),now(),'".$_SESSION['user_id']."','$route')";
          	        $query_dtls = mysqli_query($dbc, $sql_details)or die(mysqli_error($dbc));

                    if($parent_role!='mds_ad')
                    {
                      /*parent balance settle*/
                      $sql_manage_parent = "update `az_credit_manage` set `debit_credit`='0',`assign_credit`='".$credit."',`balance`='".$parent_bal."',`remark`='Account credit is assigned to user id $subusername.',`credit_date`=now(),`created`=now() where userid='$parent_id' and az_routeid='$route'";
                    $query_parent = mysqli_query($dbc, $sql_manage_parent)or die(mysqli_error($dbc));


                     $sql_details_parent = "INSERT INTO `az_credit_details`(`crmdid`,`userid`,`debit_credit`,`assign_credit`,`balance`,`remark`,`credit_date`,`created`,`az_routeid`) VALUES('".$insert_id_parent."','".$parent_id."','0','".$credit."','".$parent_bal."','Account credit is assigned to user id $subusername.',now(),now(),'$route')";
                    $query_parent_dtls = mysqli_query($dbc, $sql_details_parent)or die(mysqli_error($dbc));

                    /*end of parent balance settle*/

                      if ($query) {
                         $session_userid=$_SESSION['user_id'];
                            get_last_activities($session_userid,'New credit information has been added. ',@$login_date,@$logout_date);
                          unset($_POST);
                          return 1;
                      } else {
                          return 0;
                      }
                    }
                    else
                    {



                       $session_userid=$_SESSION['user_id'];
                            get_last_activities($session_userid,'New credit information has been added. ',@$login_date,@$logout_date);
                          unset($_POST);
                          return 1;
                    }
                    
            	  }
                else if($credit_type=='0')
              	{

              	}

            }
            else
            {
    	        	while($row=mysqli_fetch_array($query_select))
    	        	{
    	        		$prev_bal=$row['balance'];
    	        		$crm_id=$row['crmid'];
    	        	}
                
    	        	if($credit_type=="1" || $credit_type=="2")
    	        	{

                    if($parent_role!='mds_ad')
                    {
                       if($parent_bal<$credit)
                      {
                        return 2;
                      }
                    }
                    else
                    {
                      if($overselling_limit<$credit)
                      {
                        return 2;
                      }
                     /* else if($prev_bal>=$overselling_limit)
                      {
                        return 3;
                      }*/
                    }
                   

    	        		$balance=$prev_bal+$credit;
                  $parent_bal=$parent_bal-$credit;
                  $parent_credit_type="0";
                  $remark="  $subusername.";


    	        	}
    	        	else if($credit_type=="0")
    	        	{

    	        		if($prev_bal<$credit)
    	        		{
    	        			return "-1";
    	        		}
    	        		else
    	        		{
    	        			$balance=$prev_bal-$credit;
                    $parent_bal=$parent_bal+$credit;
                    $parent_credit_type="1";
    	        		}
    	        		
    	        	}
    	        
    	        	$sql = "update `az_credit_manage` set `debit_credit`='$credit_type' , `assign_credit`='$credit',`balance`=$balance,`remark`='$remark',`credit_date`=now(),`created`=now() where crmid=$crm_id";
    		        $query = mysqli_query($dbc, $sql)or die(mysqli_error($dbc));

    		         $sql_details = "INSERT INTO `az_credit_details`(`crmdid`,`userid`,`debit_credit`,`assign_credit`,`balance`,`remark`,`credit_date`,`created`,`az_routeid`) VALUES('".$crm_id."','".$username."','".$credit_type."','".$credit."','".$balance."','".$remark."',now(),now(),'$route')";
    	             $query_dtls = mysqli_query($dbc, $sql_details)or die(mysqli_error($dbc));


                   if($parent_role!='mds_ad')
                   {

                   

               /*parent balance settle*/
                $sql_manage_parent = "update `az_credit_manage` set `debit_credit`='".$parent_credit_type."',`assign_credit`='".$credit."',`balance`='".$parent_bal."',`remark`='Account credit is assigned to user id $subusername.',`credit_date`=now(),`created`=now() where userid='$parent_id' and az_routeid='$route'";
                $query_parent = mysqli_query($dbc, $sql_manage_parent)or die(mysqli_error($dbc));


                $sql_details_parent = "INSERT INTO `az_credit_details`(`crmdid`,`userid`,`debit_credit`,`assign_credit`,`balance`,`remark`,`credit_date`,`created`,`az_routeid`) VALUES('".$insert_id_parent."','".$parent_id."','".$parent_credit_type."','".$credit."','".$parent_bal."','Account credit is assigned to user id $subusername.',now(),now(),'$route')";
                $query_parent_dtls = mysqli_query($dbc, $sql_details_parent)or die(mysqli_error($dbc));

              /*end of parent balance settle*/

    		        if ($query) {
                   $session_userid=$_SESSION['user_id'];
                   get_last_activities($session_userid,'The account balance was successfully updated.',@$login_date,@$logout_date);
    		            unset($_POST);
    		            return '1';
    		        } else {
    		            return '0';
    		        }
              }
              else
              {
                 /*parent balance settle*/
              
             
                   $session_userid=$_SESSION['user_id'];
                   get_last_activities($session_userid,'The account balance was successfully updated.',@$login_date,@$logout_date);
                    unset($_POST);
                    return '1';
             
              
              }

            	
            }
          }
          /*else 
          {
            return 2;
          }*/
         }
         else
         {
            /*administrator add/credit section*/
           
              $sql_select = "SELECT * from az_credit_manage where `userid`='$username' and az_routeid='$route'";
              $query_select = mysqli_query($dbc, $sql_select);
              $count_plan=mysqli_num_rows($query_select);

            
            /*$sql_user="select * from az_user where userid='$username' ";
            $result_user=mysqli_fetch_array(mysqli_query($dbc, $sql_user));
            $subusername=$result_user['user_name'];*/


              if($count_plan==0)
              {
                    if($credit_type=='1' || $credit_type=='2')
                    {

                      $balance=$credit;
                     
                      $sql_manage = "INSERT INTO `az_credit_manage`(`userid`,`debit_credit`,`assign_credit`,`balance`,`remark`,`credit_date`,`created`,`created_by`,`az_routeid`) VALUES('".$username."','".$credit_type."','".$credit."','".$balance."','".$remark."',now(),now(),'".$_SESSION['user_id']."','$route')";
                      $query = mysqli_query($dbc, $sql_manage)or die(mysqli_error($dbc));
              
                      $sql_last_id = "select * from az_credit_manage where userid='$username' and az_routeid='$route' order by crmid desc limit 1";
                      $query_last_id = mysqli_query($dbc, $sql_last_id)or die(mysqli_error($dbc));
              
                      $row_last_id=mysqli_fetch_array($query_last_id);

                      $insert_id=$row_last_id['crmid'];

                      $sql_details = "INSERT INTO `az_credit_details`(`crmdid`,`userid`,`debit_credit`,`assign_credit`,`balance`,`remark`,`credit_date`,`created`,`created_by`,`az_routeid`) VALUES('".$insert_id."','".$username."','".$credit_type."','".$credit."','".$balance."','".$remark."',now(),now(),'".$_SESSION['user_id']."','$route')";
                      $query_dtls = mysqli_query($dbc, $sql_details)or die(mysqli_error($dbc));

                     
                      

                        if ($query) {
                           $session_userid=$_SESSION['user_id'];
                            get_last_activities($session_userid,'New credit information has been added.',@$login_date,@$logout_date);
                            unset($_POST);
                            return 1;
                        } else {
                            return 0;
                        }
                  }
                  else if($credit_type=='0')
                  {

                      $balance=$credit;
                     
                      $sql_manage = "INSERT INTO `az_credit_manage`(`userid`,`debit_credit`,`assign_credit`,`balance`,`remark`,`credit_date`,`created`,`created_by`,`az_routeid`) VALUES('".$username."','".$credit_type."','".$credit."','".$balance."','".$remark."',now(),now(),'".$_SESSION['user_id']."','$route')";
                  $query = mysqli_query($dbc, $sql_manage)or die(mysqli_error($dbc));
                  
                    $sql_last_id = "select * from az_credit_manage where userid='$username' and az_routeid='$route' order by crmid desc limit 1";
                  $query_last_id = mysqli_query($dbc, $sql_last_id)or die(mysqli_error($dbc));
                  
                  $row_last_id=mysqli_fetch_array($query_last_id);

                  $insert_id=$row_last_id['crmid'];

                    $sql_details = "INSERT INTO `az_credit_details`(`crmdid`,`userid`,`debit_credit`,`assign_credit`,`balance`,`remark`,`credit_date`,`created`,`created_by`,`az_routeid`) VALUES('".$insert_id."','".$username."','".$credit_type."','".$credit."','".$balance."','".$remark."',now(),now(),'".$_SESSION['user_id']."','$route')";
                    $query_dtls = mysqli_query($dbc, $sql_details)or die(mysqli_error($dbc));



                    if ($query) {
                      $session_userid=$_SESSION['user_id'];
                      get_last_activities($session_userid,'New credit information has been added.',@$login_date,@$logout_date);
                        unset($_POST);
                        return 1;
                    } else {
                        return 0;
                    }
                    
                  }
            }
            else
            {
                /*administrator record available in credit manage table*/

                  while($row=mysqli_fetch_array($query_select))
                {
                  $prev_bal=$row['balance'];
                  $crm_id=$row['crmid'];
                }

                if($credit_type=="1" || $credit_type=='2')
                {
                  $balance=$prev_bal+$credit;
                 
                }
                else if($credit_type=="0")
                {

                  if($prev_bal<$credit)
                  {
                    return "-1";
                  }
                  else
                  {
                    $balance=$prev_bal-$credit;
                  
                  }
                  
                }
              
                $sql = "update `az_credit_manage` set `debit_credit`='$credit_type' , `assign_credit`='$credit',`balance`='$balance',`remark`='$remark',`credit_date`=now(),`created`=now() where crmid=$crm_id";
                $query = mysqli_query($dbc, $sql)or die(mysqli_error($dbc));

                 $sql_details = "INSERT INTO `az_credit_details`(`crmdid`,`userid`,`debit_credit`,`assign_credit`,`balance`,`remark`,`credit_date`,`created`,`az_routeid`) VALUES('".$crm_id."','".$username."','".$credit_type."','".$credit."','".$balance."','".$remark."',now(),now(),'$route')";
                   $query_dtls = mysqli_query($dbc, $sql_details)or die(mysqli_error($dbc));

                if ($query) {
                   $session_userid=$_SESSION['user_id'];
                   get_last_activities($session_userid,'The account balance was successfully updated.',@$login_date,@$logout_date);
                    unset($_POST);
                    return '1';
                } else {
                    return '0';
                }
            }

         }
      

}

?>