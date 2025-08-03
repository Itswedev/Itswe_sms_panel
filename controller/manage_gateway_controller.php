<?php
session_start();
// error_reporting(0);
$log_file = "../error/logfiles/manage_gateway_controller.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);

include('../include/connection.php');
include('classes/last_activities.php');
//include_once('../include/datatable_dbconnection.php');
require('classes/ssp.class.php');

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
if (isset($_POST['type']) && $_POST['type'] == 'addRoute') {
   $rs = saveRoute();
  	if($rs=='1')
  	{
  		echo "Route Details added successfully";
  	}
  	else if($rs=='0')
  	{
		echo "Failed to create routing";
  	}
  


}
else if (isset($_POST['type']) && $_POST['type'] == 'editRoute') {
   $rs = updateRoute();
   echo $rs;
  


}
else if (isset($_POST['type']) && $_POST['type'] == 'deleteRoute') {
   $rs = deleteRoute();
   echo $rs;
  


}
else if (isset($_POST['type']) && $_POST['type'] == 'deleteRoutePlan') {
   $rs = deleteRoutePlan();
   echo $rs;
  


}
else if (isset($_POST['type']) && $_POST['type'] == 'deleteSenderRouting') {
   $rs = deleteSenderRouting();
   echo $rs;
  


}


if (isset($_POST['type']) && $_POST['type'] == 'create_routing_plan') {
   $rs = saveRoutePlan();
   echo $rs;
   /* if($rs=='1')
    {
      echo "Route Plan Details added successfully";
    }
    else if($rs=='0')
    {
    echo "Failed to create routing plan";
    }*/
  


}
if (isset($_POST['type']) && $_POST['type'] == 'edit_routing_plan') {
   $rs = updateRoutePlan();
   echo $rs;
   /* if($rs=='1')
    {
      echo "Route Plan Details added successfully";
    }
    else if($rs=='0')
    {
    echo "Failed to create routing plan";
    }*/
  


}
else if(isset($_POST['type']) && $_POST['type'] == 'add_sender_routing')
{
     $rs = saveSenderRouting();
     echo $rs;
    /*if($rs=='1')
    {
      echo "Sender Routing Details added successfully";
    }
    else if($rs=='0')
    {
    echo "Failed to add sender routing details";
    }*/
}
else if(isset($_POST['type']) && $_POST['type'] == 'edit_sender_routing')
{
     $rs = updateSenderRouting();
     echo $rs;
    /*if($rs=='1')
    {
      echo "Sender Routing Details added successfully";
    }
    else if($rs=='0')
    {
    echo "Failed to add sender routing details";
    }*/
}
else if(isset($_POST['type']) && $_POST['type'] == 'add_smpp_error_code')
{
     $rs = saveSMPPErrorCode();
    if($rs=='1')
    {
      echo "SMPP Error Code Details added successfully";
    }
    else if($rs=='0')
    {
    echo "Failed to add SMPP Error Code detail";
    }
}
else if(isset($_POST['type']) && $_POST['type'] == 'upload_error_code')
{
     $rs = uploadSMPPErrorCode();
    if($rs=='1')
    {
      echo "success";
    }
    else if($rs=='0')
    {
    echo "Failed to add SMPP Error Code detail";
    }
}


if(isset($_REQUEST['list_type']))
{
    $list_type=$_REQUEST['list_type'];


    if($list_type=='all')
    {
           $result = viewroute();

            $return_routelist=route_list($result);

            echo $return_routelist;
    }
    else if($list_type=='all_plan')
    {


       $searchFilter = array(); 
if(!empty($_GET['search_keywords'])){ 
    $searchFilter['search'] = array( 
        'plan_id' => $_GET['search_keywords']
       
    ); 
} 

 
           
           $result = viewrouteplan();

            $return_routeplan=route_plan($result);

            echo $return_routeplan;
    }
    else if($list_type=='create_plan_form')
    {
           $result_plan = viewplandropdown();
           $result_route = viewroutedropdown_only();
           $result_gateway = viewgatewaydropdown();

            
           $result['plan']=$result_plan;
          $result['route']=$result_route;
           $result['gateway']=$result_gateway;

            echo json_encode($result);
    }
      else if($list_type=='route_dropdown')
    {

         if(isset($_REQUEST['page']))
        {
          $page_name=$_REQUEST['page'];
          if($page_name=='compose')
          {
            $result_route = viewroutedropdown($page_name);
          }
        }
        else
        {
          $userid=$_SESSION['user_id'];
          if($userid!='1')
          {

            $result_route = viewroutedropdown($page_name);
          }
          else
          {
            $result_route = viewroutedropdown_only();
          }
          
          // $result_route = viewroutedropdown_only();
        }


    //   $result_route = viewroutedropdown_only();  
        echo $result_route; 
    }
    // else if($list_type=='route_dropdown_multiple')
    // {

      
    //       $userid=$_SESSION['user_id'];
    //       if($userid!='1')
    //       {
    //         $result_route = viewroutedropdown_multiple();
    //       }
    //       else
    //       {
    //         $result_route = viewroutedropdown_multiple();
    //       }
          
       


    // //   $result_route = viewroutedropdown_only();  
    //     echo $result_route; 
    // }
    else if($list_type=='edit_route_dropdown')
    {

        $result_route = edit_viewroutedropdown();
        echo json_encode($result_route); 
    }
    else if($list_type=='add_route_dropdown')
    {

        $result_route = add_viewroutedropdown();
        echo json_encode($result_route); 
    }
    else if($list_type=='load_voice_gateway')
    {

        $result_gateway = load_voice_gateway();
         $result['gateway']=$result_gateway;
         echo json_encode($result);
       /* echo $result_gateway; */
    }
    else if($list_type=='load_other_gateway')
    {

        $result_gateway = viewgatewaydropdown();
         $result['gateway']=$result_gateway;
         echo json_encode($result);
       /* echo $result_gateway; */
    }
    else if($list_type=='acct_manager_dropdown')
    {
      $result_acct_manager= viewacctmanagerdropdown();
      echo $result_acct_manager; 
    }
    else if($list_type=='add_form_acct_manager_dropdown')
    {
      $result_acct_manager= add_form_viewacctmanagerdropdown();
      echo $result_acct_manager; 
    }
    else if($list_type=='plan_dropdown')
    {
          
          $result_plan = viewplandropdown();
        

        
           echo $result_plan; 
    }
      else if($list_type=='load_sender_id_list')
    {
         $sender_id_dropdown= sender_id_dropdown();
         echo $sender_id_dropdown;
    }
        else if($list_type=='load_sender_id_list_by_userid')
    {

         $sender_id_dropdown= sender_id_dropdown_byuserid();
         echo $sender_id_dropdown;
    }
      else if($list_type=='all_sender_id_routing')
    {
            /*$result = viewsenderrouting();

            $return_sender_routing_table=sender_routing_table($result);

            echo $return_sender_routing_table;*/


             $table = 'sender_routing';

            $primaryKey = 'sr_id';

            $columns = array(
                
                array( 'db' => 'userid','dt' => 0,'formatter'=>function($d,$row)
                {
                     $username=fetch_username($d);
                     return $username;
                       
                } ),
                array( 'db' => 'sender_id','dt' => 1,'formatter'=>function($d,$row)
                {
                     $sender_name=fetch_sender_name($d);
                     return $sender_name;
                       
                }),
                array( 'db' => 'gateway_id','dt' => 2 ,'formatter'=>function($d,$row){
                  $gateway_name=fetch_gateway_name($d);
                  return $gateway_name;
                   
                }),
                  array( 'db' => 'created_dt','dt' => 3 ,'formatter'=>function($d,$row){
                      $created_dt=date('d-M-Y h:i a', strtotime($d));
                  return $created_dt;
                   
                }),
                array( 'db' => 'sr_id','dt' => 4,'formatter' => function( $d, $row ) {
                 //return $d;
                   
                   $sr_id=$d;
                   $userid=$row[0];
                   $sender_id=$row[1];
                  // $template_content=urldecode($row[5]);
                   $gateway_id=$row[2];
                 
                   
                        $action="<button class='btn btn-primary me-1 mb-1 edit_sender_routing_btn' type='button' data-bs-toggle='modal' data-bs-target='#edit_sender_routing_modal' data-id='".$sr_id."' data-userid='".$userid."' data-gateway='".$gateway_id."' data-senderid='".$sender_id."'>
                        <i class='fa fa-pencil'></i>
              </button>&nbsp;<button class='btn btn-primary me-1 mb-1 delete_sender_routing_btn' type='button' data-id='".$sr_id."'>
              <i class='fa fa-trash'></i>
              </button>";
                        return $action;
                    })
               
            );
             
            // SQL server connection information
            global $sql_details ;

          /*  $extraWhere="";

            $userid=$_SESSION['user_id'];
            if($userid!='1')
            {
                if($extraWhere!="")
                {
                    $extraWhere=" and userid='$userid'";
                }
                else
                {
                    $extraWhere=" userid='$userid'";
                }
            }*/
           
            echo json_encode(
                SSP::complex( $_REQUEST, $sql_details, $table, $primaryKey, $columns,$test=null,$extraWhere )
            );
    }
        else if($list_type=='load_gateway_dropdown')
    {
        $result_gateway = viewgatewaydropdown2();
         echo json_encode($result_gateway);
    }
    else if($list_type=='load_smpp_error_details')
    {
            $result = viewsmpperrorcode();

            $return_smpp_error_code_details=smpp_error_code_details($result);

            echo $return_smpp_error_code_details;
    }
   /* elseif($list_type=='dropdown')
    {
        $result = viewgroup();

            $return_grplist=group_list_dropdown($result);

            echo $return_grplist;
    }*/
}
function sender_id_dropdown()
    {
             global $dbc;
             $q = "SELECT * FROM az_senderid WHERE 1";
             $rs = mysqli_query($dbc, $q);
             $option="<option value=''>Select Sender ID</option>";
             while($row=mysqli_fetch_array($rs))
             {
                $sid=$row['sid'];
                $senderid=$row['senderid'];
                $option.="<option value='".$sid."'>$senderid</option>";
             }

             return $option;

    }
    function sender_id_dropdown_byuserid()
    {
             global $dbc;
             $userid=$_REQUEST['userid'];
             $q = "SELECT * FROM az_senderid WHERE userid='".$userid."'";
             $rs = mysqli_query($dbc, $q);
             $option="<option value=''>Select Sender ID</option>";
             while($row=mysqli_fetch_array($rs))
             {
                $sid=$row['sid'];
                $senderid=$row['senderid'];
                $option.="<option value='".$sid."'>$senderid</option>";
             }

             return $option;

    }

  function viewroute() {
        global $dbc;
        $result = array();
        $sql = "SELECT *  FROM az_routetype ORDER BY az_create_date DESC";
        $values = mysqli_query($dbc, $sql);
        while ($row = mysqli_fetch_assoc($values)) {
            $r_id = $row['az_routeid'];
            $result[$r_id] = $row;
        }
        return $result;
    }


      function viewrouteplan() {
        global $dbc;
        $result = array();
        $sql = "SELECT *  FROM az_route_plan ORDER BY created_date DESC";
        $values = mysqli_query($dbc, $sql);
        while ($row = mysqli_fetch_assoc($values)) {
            $rp_id = $row['rp_id'];
            $result[$rp_id] = $row;
        }
        return $result;
    }

      function viewsenderrouting() {
        global $dbc;
        $result = array();
        $sql = "SELECT *  FROM sender_routing ORDER BY created_dt DESC";
        $values = mysqli_query($dbc, $sql);
        while ($row = mysqli_fetch_assoc($values)) {
            $sr_id = $row['sr_id'];
            $result[$sr_id] = $row;
        }
        return $result;
    }

          function viewsmpperrorcode() {
        global $dbc;
        $result = array();
        $sql = "SELECT *  FROM tbl_errorcode ORDER BY created DESC";
        $values = mysqli_query($dbc, $sql);
        while ($row = mysqli_fetch_assoc($values)) {
            $e_id = $row['e_id'];
            $result[$e_id] = $row;
        }
        return $result;
    }


      function route_list($result)
        {
          $i = 1;
          if (!empty($result)) { 
         
           foreach ($result as $key => $value) {
            $rid=$value['az_routeid'];
            $rname=$value['az_rname'];
            $start_time=date("h:i a",$value['start_time']);
            $end_time=date("h:i a",$value['end_time']);
            $status=$value['status'];
            $rate=$value['rate'];
            
            $sender_id=$value['az_issenderid'];
            if($sender_id=='1')
            {
              $sender_status='YES';
            }
            else
            {
              $sender_status='NO';
            }

            if($status=='1')
            {
              $stat='Active';
            }
            else
            {
              $stat='Inactive';
            }

            $dnd=$value['dnd_enable'];
            if($dnd==0)
            {
                $dnd_check='No';
            }
            else if($dnd==1)
            {
                 $dnd_check='Yes';
            }
            $created_dt=date('d-M-Y h:i a', strtotime($value['az_create_date']));
              $return_routelist.="<tr>
              <td width='5%'>$i</td>
              <td width='10%'>$rname</td>
              <td width='10%'>$start_time</td>
              <td width='15%'>$end_time</td>
              <td width='15%'>$rate</td>
              <td width='15%'>$sender_status</td>
              <td width='15%'>$dnd_check</td>
              <td width='15%'>$stat</td>
              <td width='15%'>$created_dt</td>
              
              <td width='35%'><button class='btn btn-primary me-1 mb-1 edit_route_btn' type='button' data-bs-toggle='modal' data-bs-target='#edit_route_modal' data-id='".$rid."' data-rname='".$rname."' data-status='".$status."' data-starttime='$start_time' data-endtime='$end_time' data-rate='$rate' data-senderid='$sender_id' data-dnd='$dnd'>
              <i class='fa fa-pencil'></i>
              </button>&nbsp;<button class='btn btn-primary me-1 mb-1 delete_route_btn' type='button'  data-id='".$rid."'>
              <i class='fa fa-trash'></i>
              </button>
              </td>
              </tr>";
            
                $i++;
                }

                return $return_routelist;
          } 
          else
          {
            return "No record available";
          }
        }



     function sender_routing_table($result)
        {
          $i = 1;
          if (!empty($result)) { 
         
           foreach ($result as $key => $value) { 
            $sr_id=$value['sr_id'];
            $userid=$value['userid'];
            //$created_dt=$value['created_dt'];
            //$status=$value['status'];

           /* if($status=='1')
            {
                $stat="Active";
            }
            else
            {
                $stat="Inactive";
            }
*/

            $gateway_id=$value['gateway_id'];
            $gateway_name=fetch_gateway_name($gateway_id);

            $sender_id=$value['sender_id'];
           $sender_name=fetch_sender_name($sender_id);
            $created_dt=date('d-M-Y h:i a', strtotime($value['created_dt']));
              $return_routelist.="<tr>
              <td width='5%'>$i</td>
              <td width='20%'>$username</td>
              <td width='20%'>$sender_name</td>
              <td width='15%'>$gateway_name</td>
              <td width='15%'>$stat</td>
              <td width='15%'>$created_dt</td>
              
              <td width='25%'>
              <button class='btn btn-primary me-1 mb-1 edit_sender_routing_btn' type='button' data-bs-toggle='modal' data-bs-target='#edit_sender_routing_modal' data-id='".$sr_id."' data-userid='".$userid."' data-status='".$status."' data-gateway='".$gateway_id."' data-senderid='".$sender_id."'>
              <i class='fa fa-pencil'></i>
              </button>&nbsp;<button class='btn btn-primary me-1 mb-1 delete_sender_routing_btn' type='button' data-id='".$sr_id."'>
              <i class='fa fa-trash'></i>
              </button></td>
              </tr>";
            
                $i++;
                }

                return $return_routelist;
          } 
          else
          {
            return "No record available";
          }
        }


   function smpp_error_code_details($result)
        {
          $i = 1;
          if (!empty($result)) { 
         
           foreach ($result as $key => $value) { 
            $e_id=$value['e_id'];
            $err_code=$value['err_code'];
            //$created_dt=$value['created_dt'];
            $err_status=$value['err_status'];

            $status=$value['status'];

            if($status=='1')
            {
                $stat="Active";
            }
            else
            {
                $stat="Inactive";
            }


            $gateway_id=$value['gateway_id'];
            $gateway_name=fetch_gateway_name($gateway_id);

           
            $created_dt=date('d-M-Y h:i a', strtotime($value['created']));
              $return_routelist.="<tr>
              <td width='5%'>$i</td>
              <td width='15%'>$err_code</td>
              <td width='15%'>$gateway_name</td>
              <td width='15%'>$err_status</td>
              <td width='15%'>$stat</td>
              <td width='15%'>$created_dt</td>
              
              
              </tr>";

              //<td width='15%'><button class='btn btn-primary me-1 mb-1' type='button'>
              // <i class='fa fa-pencil'></i>
              // </button>&nbsp;<button class='btn btn-primary me-1 mb-1' type='button'>
              // <i class='fa fa-trash'></i>
              // </button></td>
            
                $i++;
                }

                return $return_routelist;
          } 
          else
          {
            return "No record available";
          }
        }


         function route_plan($result)
        {
          $i = 1;
          if (!empty($result)) { 
         
           foreach ($result as $key => $value) { 
            $rp_id=$value['rp_id'];
            $plan_id=$value['plan_id'];
            $plan_name=fetch_plan_name($plan_id);
            
            $route_id=$value['route_id'];
            $route_name=fetch_route_name($route_id);

            if($route_id==7)
            {
                $gateway_id=$value['gateway_id'];
                $gateway_name=fetch_voice_gateway_name($gateway_id);
            }
            else
            {
                $gateway_id=$value['gateway_id'];
                $gateway_name=fetch_gateway_name($gateway_id);
            }
           

            $rp_status=$value['rp_status'];
            if($rp_status=='1')
            {
               $status='Active';
            }
            else
            {
              $status='Inactive';
            }
            $created_dt=date('d-M-Y h:i a', strtotime($value['created_date']));
              $return_routeplan.="<tr>
                           <td width='20%'>$plan_name</td>
              <td width='30%'>$route_name</td>
              <td width='20%'>$gateway_name</td>
             
              <td width='15%'>$status</td>
              <td width='15%'>$created_dt</td>

              
              <td width='25%'>
              <button class='btn btn-primary me-1 mb-1 edit_route_plan_btn' type='button' data-bs-toggle='modal' data-bs-target='#edit_route_plan_modal' data-id='$rp_id' data-plan='$plan_id' data-route='$route_id' data-gateway='$gateway_id' data-status='$rp_status'>
              <i class='fa fa-pencil'></i>
              </button>&nbsp;
              <button class='btn btn-primary me-1 mb-1 delete_route_plan_btn' type='button' data-id='$rp_id'>
              <i class='fa fa-trash'></i>
              </button></td>
              </tr>";
            
                $i++;
                }

                return $return_routeplan;
          } 
          else
          {
            return "No record available";
          }
        }



function saveRoute()
{
	      global $dbc;
       /* $gateway_family = ucwords(trim($_POST['gateway_family']));*/
        $route_name = trim($_POST['route_name']);
        $status = trim($_POST['status']);
        $start_time = strtotime(trim($_POST['start_time']));
        $end_time = strtotime(trim($_POST['end_time']));
        $rate = trim($_POST['rate']);
        $sender_id = trim($_POST['sender_id']);
        $dnd_check = trim($_POST['dnd_check']);
       
        
        
      /* $sql_select = "SELECT * from az_sms_gateway where p_name='$pname'";
        $query_select = mysqli_query($dbc, $sql_select);
        $count_plan=mysqli_num_rows($query_select);

        if($count_plan==0)
        {*/
     $sql = "INSERT INTO `az_routetype`(`az_rname`,`status`,`start_time`,`end_time`,`az_issenderid`,`rate`,`az_create_date`,`userid`,`dnd_enable`) VALUES('".$route_name."','".$status."','".$start_time."','".$end_time."','".$sender_id."','".$rate."',now(),'".$_SESSION['user_id']."','$dnd_check')";
	        $query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
	        if ($query) {
             $session_userid=$_SESSION['user_id'];
           get_last_activities($session_userid,'New routing information has been added.',@$login_date,@$logout_date);
	            unset($_POST);
	            return '1';
	        } else {
	            return '0';
	        }
        /*}
        else
        {
        	return '0';
        	
        }*/

       

}

function updateRoute()
{
        global $dbc;
       /* $gateway_family = ucwords(trim($_POST['gateway_family']));*/
       $rid=trim($_POST['route_id']);
        $route_name = trim($_POST['route_name']);
        $status = trim($_POST['status']);
        $start_time = strtotime(trim($_POST['start_time']));
        $end_time = strtotime(trim($_POST['end_time']));
        $rate = trim($_POST['rate']);
        $sender_id = trim($_POST['sender_id']);
        $dnd_check = trim($_POST['dnd_check']);
       
        $userid=$_SESSION['user_id'];
        $updated_date=time();
        $sql = "update `az_routetype` set `az_rname`='$route_name',`status`='$status',`start_time`=$start_time,`end_time`=$end_time,`az_issenderid`='$sender_id',`rate`='$rate',`az_updated_date`=$updated_date,`az_updated_by`='$userid',`dnd_enable`='$dnd_check' where az_routeid='".$rid."'";
          $query = mysqli_query($dbc, $sql);
          if ($query) {
           $session_userid=$_SESSION['user_id'];
           get_last_activities($session_userid,'Routing information has been updated.',@$login_date,@$logout_date);
              unset($_POST);
              return 1;
          } else {
              return 0;
          }
     
       

}

function deleteRoute()
{
        global $dbc;
       /* $gateway_family = ucwords(trim($_POST['gateway_family']));*/
       $rid=trim($_POST['rid']);
    
        $sql = "delete from `az_routetype` where az_routeid='".$rid."'";
          $query = mysqli_query($dbc, $sql);
          if ($query) {
             $session_userid=$_SESSION['user_id'];
           get_last_activities($session_userid,'Routing information has been deleted.',@$login_date,@$logout_date);
              return 1;
          } else {
              return 0;
          }
     
       

}



function deleteRoutePlan()
{
        global $dbc;
       /* $gateway_family = ucwords(trim($_POST['gateway_family']));*/
       $rid=trim($_POST['rpid']);
    
        $sql = "delete from `az_route_plan` where rp_id='".$rid."'";
          $query = mysqli_query($dbc, $sql);
          if ($query) {
             $session_userid=$_SESSION['user_id'];
           get_last_activities($session_userid,'Routing plan has been deleted.',@$login_date,@$logout_date);
              return 1;
          } else {
              return 0;
          }
     
       

}





function deleteSenderRouting()
{
        global $dbc;
       /* $gateway_family = ucwords(trim($_POST['gateway_family']));*/
       $srid=trim($_POST['srid']);
    
        $sql = "delete from `sender_routing` where sr_id='".$srid."'";
          $query = mysqli_query($dbc, $sql);
          if ($query) {
             $session_userid=$_SESSION['user_id'];
           get_last_activities($session_userid,'Sender Routing information has been deleted.',@$login_date,@$logout_date);
              return 1;
          } else {
              return 0;
          }
     
       

}


function saveRoutePlan()
{
        global $dbc;
     
        $route_id = trim($_POST['route_dropdown']);
        $gateway_id = $_POST['gateway_name'];
        $gateway_id_str=implode(",", $gateway_id);
        
        $plan_id = trim($_POST['plan_name']);
        $status = trim($_POST['status']);
      
       
        
        
      /* $sql_select = "SELECT * from az_sms_gateway where p_name='$pname'";
        $query_select = mysqli_query($dbc, $sql_select);
        $count_plan=mysqli_num_rows($query_select);

        if($count_plan==0)
        {*/
     $sql = "INSERT INTO `az_route_plan`(`plan_id`,`route_id`,`gateway_id`,`rp_status`,`created_date`,`created_by`) VALUES('".$plan_id."','".$route_id."','".$gateway_id_str."','".$status."',now(),'".$_SESSION['user_id']."')";
          $query = mysqli_query($dbc, $sql);
          if ($query) {
              unset($_POST);
              $session_userid=$_SESSION['user_id'];
           get_last_activities($session_userid,'A new route plan has been created.',@$login_date,@$logout_date);
              return 1;
          } else {
              return 0;
          }
        /*}
        else
        {
          return '0';
          
        }*/

       

}

function updateRoutePlan()
{
        global $dbc;
     
        $route_id = trim($_POST['route_dropdown']);
        $gateway_id = $_POST['gateway_name'];
        $gateway_id_str=implode(",", $gateway_id);
        
        $plan_id = trim($_POST['plan_name']);
        $status = trim($_POST['status']);
      
       $rp_id=trim($_POST['rp_id']);
        
        
      /* $sql_select = "SELECT * from az_sms_gateway where p_name='$pname'";
        $query_select = mysqli_query($dbc, $sql_select);
        $count_plan=mysqli_num_rows($query_select);

        if($count_plan==0)
        {*/
     $sql = "update `az_route_plan` set `plan_id`='$plan_id',`route_id`='$route_id',`gateway_id`='$gateway_id_str',`rp_status`='$status' where rp_id='$rp_id'";
          $query = mysqli_query($dbc, $sql);
          if ($query) {
             $session_userid=$_SESSION['user_id'];
           get_last_activities($session_userid,'Route plan has been updated',@$login_date,@$logout_date);
              unset($_POST);
              return 1;
          } else {
              return 0;
          }
        /*}
        else
        {
          return '0';
          
        }*/

       

}


function saveSenderRouting()
{
        global $dbc;
     
        $userid = trim($_POST['username_senderid']);
        $gateway_id = $_POST['gateway_id'];
        $sender_id = $_POST['sender_id1'];
      //  $sender_route_status = $_POST['sender_route_status'];
      
       
        
        
      /* $sql_select = "SELECT * from az_sms_gateway where p_name='$pname'";
        $query_select = mysqli_query($dbc, $sql_select);
        $count_plan=mysqli_num_rows($query_select);

        if($count_plan==0)
        {*/
     $sql = "INSERT INTO `sender_routing`(`sender_id`,`gateway_id`,`created_dt`,`userid`,`added_by`,`status`) 
     VALUES('".$sender_id."','".$gateway_id."',now(),'".$userid."','".$_SESSION['user_id']."','1')";
          $query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
          if ($query) {
              unset($_POST);
               $session_userid=$_SESSION['user_id'];
           get_last_activities($session_userid,'The senders routing information has been added.',@$login_date,@$logout_date);
              return 1;
          } else {
              return 0;
          }
        /*}
        else
        {
          return '0';
          
        }*/

       

}

function updateSenderRouting()
{
        global $dbc;
     
        $userid = trim($_POST['edit_username_senderid']);
        $gateway_id = $_POST['gateway_id'];
        $sender_id = $_POST['sender_id1'];
       // $sender_route_status = $_POST['sender_route_status'];
      
        $srid=$_POST['srid'];
        
   
     $sql = "update `sender_routing` set `sender_id`='$sender_id',`gateway_id`='$gateway_id',`userid`='$userid' where sr_id='".$srid."'";
          $query = mysqli_query($dbc, $sql);
          if ($query) {
            $session_userid=$_SESSION['user_id'];
           get_last_activities($session_userid,'The senders routing information has been updated.',@$login_date,@$logout_date);
              unset($_POST);
              return 1;
          } else {
              return 0;
          }
       
}

function saveSMPPErrorCode()
{
        global $dbc;
     
        $error_code = trim($_POST['error_code']);
         $error_status = trim($_POST['error_status']);
        $gateway_id = $_POST['gateway_id'];

      /* $sql_select = "SELECT * from az_sms_gateway where p_name='$pname'";
        $query_select = mysqli_query($dbc, $sql_select);
        $count_plan=mysqli_num_rows($query_select);

        if($count_plan==0)
        {*/
    $sql = "INSERT INTO `tbl_errorcode`(`err_code`,`gateway_id`,`err_status`,`created`,`userid`) VALUES('".$error_code."','".$gateway_id."','".$error_status."',now(),'".$_SESSION['user_id']."')";
          $query = mysqli_query($dbc, $sql);
          if ($query) {
            $session_userid=$_SESSION['user_id'];
           get_last_activities($session_userid,'A new SMPP Error code has been added to the list.',@$login_date,@$logout_date);
              unset($_POST);
              return '1';
          } else {
              return '0';
          }
        /*}
        else
        {
          return '0';
          
        }*/

}



function uploadSMPPErrorCode()
{
    global $dbc; 
    $userid=$_SESSION['user_id'];
    $user_role=$_SESSION['user_role'];
    $gateway_id=$_REQUEST['gateway_id'];

   
    $fname = explode('.', $_FILES['upload_error_code']['name']);
    $filename=$_FILES['upload_error_code']['name'];
    $extension = end($fname);    
    if($extension=='csv')
    {
               if (($handle = fopen($_FILES['upload_error_code']['tmp_name'], "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 100000, ",")) !== FALSE) {
                        $number = $name = '';
          
                            if (isset($data[0]) || isset($data[1])) {
                                $error_code[] = isset($data[0]) ? str_replace("'","",$data[0]) : '';
                                $status[] = isset($data[1]) ? str_replace("'","",$data[1]) : '';

                                // $header_id[] = isset($data[2]) ? $data[2] : '';
                                // $sender_desc[] = isset($data[3]) ? $data[3] : '';

                       

                            }
                            else
                            {
                                return "Error code and status is required";
                            }
                        
                        
                    }

                   
                    fclose($handle);

                     $count_temp=count($error_code);
                     
                    if($count_temp>1)
                    {
                        $values="";
                        $today_dt=date("Y-m-d");
                        for($i=1;$i<count($error_code);$i++)
                        {
                             if($count_temp>1 && ($i!=(count($error_code)-1)))
                             {
                            $values.="('$error_code[$i]','$status[$i]',$gateway_id,NOW()),";
                             }
                             else
                             {
                             $values.="('$error_code[$i]','$status[$i]',$gateway_id,NOW())";
                             }
                        }




                    }
                    else
                    {
                        return "Please check your file";
                    }

                    if($values!="")
                    {

                           $sql = "INSERT INTO `tbl_errorcode` ( `err_code`,  `err_status`, `gateway_id`, `created`) values $values" ;
                            // echo $sql;

                            
                            $res = mysqli_query($dbc, $sql)or die(mysqli_error($dbc));

                               if ($res) {
                                    return 1;
                                } else {
                                    return 0;
                                }


                    }
                    
                    


                }
    }
}

function viewplandropdown()
{
  global $dbc;
   $sql = "select * from az_plan where status=1 order by created_date desc";
   $query_result = mysqli_query($dbc, $sql);

   $count_plan=mysqli_num_rows($query_result);
   $plan_dropdown="<option value=''>Select Plan</option>";
   if($count_plan>0)
   {
          if ($query_result) {
             
             while($row=mysqli_fetch_array($query_result))
             {
                $plan_dropdown.="<option value='".$row['pid']."'>".$row['p_name']."</option>";
             }

             return $plan_dropdown;


          } else {
               return $plan_dropdown;
          }
    }
    else {
               return $plan_dropdown;
          }

}



function viewacctmanagerdropdown()
{
   global $dbc;
   $userid=$_SESSION['user_id'];
   $edit_userid=$_REQUEST['edit_userid'];



      $sql_parent="select parent_id from az_user where userid='".$edit_userid."'";
      $result_query=mysqli_query($dbc,$sql_parent);
      $row_parent=mysqli_fetch_array($result_query);

      $parent_id=$row_parent['parent_id'];
      $sql = "select * from account_manager where parent_id='$parent_id'";
  /* }
   else
   {
      $sql = "select * from account_manager where parent_id='$parent_id'";
   }*/
   
  
   $query_result = mysqli_query($dbc, $sql);

   $count_plan=mysqli_num_rows($query_result);
   
   if($count_plan>0)
   {
          if ($query_result) {
             $acct_manager_dropdown="<option value=''>Select Account Manager</option>";
             while($row=mysqli_fetch_array($query_result))
             {
                $acct_manager_dropdown.="<option value='".$row['userid']."'>".$row['user_name']."</option>";
             }

             return $acct_manager_dropdown;

          } else {
               return $acct_manager_dropdown;
          }
    }
    else 
    {
        return 0;
    }

}


function add_form_viewacctmanagerdropdown()
{
   global $dbc;
   $userid=$_SESSION['user_id'];
  
     $sql = "select * from account_manager where parent_id='$userid'";
   
   
  
   $query_result = mysqli_query($dbc, $sql);

   $count_plan=mysqli_num_rows($query_result);
   
   if($count_plan>0)
   {
          if ($query_result) {
             $acct_manager_dropdown="<option value=''>Select Account Manager</option>";
             while($row=mysqli_fetch_array($query_result))
             {
                $acct_manager_dropdown.="<option value='".$row['userid']."'>".$row['user_name']."</option>";
             }

             return $acct_manager_dropdown;

          } else {
               return $acct_manager_dropdown;
          }
    }
    else 
    {
        return 0;
    }

}

function viewroutedropdown($page_name)
{

  
  global $dbc;
  $userid=$_SESSION['user_id'];
  $sql_route_ids= "select * from az_user where userid='".$userid."'";
  $query_route_id = mysqli_query($dbc, $sql_route_ids);

  // $count_plan=mysqli_num_rows($query_route_id);

      $result_route_id=mysqli_fetch_array($query_route_id);
      $route_ids=$result_route_id['route_ids'];
      $rcs_access=$result_route_id['rcs'];


 $sql = "select * from az_routetype where az_routeid in ($route_ids) order by az_create_date desc";
   $query_result = mysqli_query($dbc, $sql);

   $count_route=mysqli_num_rows($query_result);
/*   $route_dropdown="<option value=''>Select Route</option>";*/
   if($count_route>0)
   {
 
             
             while($row=mysqli_fetch_array($query_result))
             {
                if($rcs_access=="No" && $row['az_rname']=='RCS')
                {
                  continue;
                }
                else
                {

                    if($page_name!='compose')
                    {
                        $route_dropdown.="<option value='".$row['az_routeid']."'>".$row['az_rname']."</option>";
                    }
                    else
                    {
                        if($row['az_routeid']!=7)
                        {
                            $route_dropdown.="<option value='".$row['az_routeid']."'>".$row['az_rname']."</option>";
                        }
                    }
                    /*if($row['az_routeid']!=7)
                    {*/
                        
                    /*}*/
                  
                }
                
             }

             return $route_dropdown;


         
    }
    else {
               return $route_dropdown;
          }
   



  
}





function viewroutedropdown_multiple()
{

  
  global $dbc;
  $userid=$_SESSION['user_id'];
  $sql_route_ids= "select * from az_user where userid='".$userid."'";
  $query_route_id = mysqli_query($dbc, $sql_route_ids);

  // $count_plan=mysqli_num_rows($query_route_id);

      $result_route_id=mysqli_fetch_array($query_route_id);
      $route_ids=$result_route_id['route_ids'];
      $rcs_access=$result_route_id['rcs'];


 $sql = "select * from az_routetype where az_routeid in ($route_ids) order by az_create_date desc";
   $query_result = mysqli_query($dbc, $sql);

   $count_route=mysqli_num_rows($query_result);
/*   $route_dropdown="<option value=''>Select Route</option>";*/
   if($count_route>0)
   {
 
             
             while($row=mysqli_fetch_array($query_result))
             {
                if($rcs_access=="No" && $row['az_rname']=='RCS')
                {
                  continue;
                }
                else
                {

                    
                      $routeArray[] = array(
                        'route_id' => $row['az_routeid'],
                        'route_name' => $row['az_rname']
                    );
                    
                   
                  
                }
                
             }

             return $route_dropdown;


         
    }
    else {
               return $route_dropdown;
          }
   



  
}

function edit_viewroutedropdown()
{

  
  global $dbc;
  $userid=$_SESSION['user_id'];
  $edit_userid=$_SESSION['edit_userid'];
  $sql_parent= "select parent_id,route_ids from az_user where userid='".$edit_userid."'";
  $result_parent = mysqli_fetch_array(mysqli_query($dbc, $sql_parent));


  $parent_id=$result_parent['parent_id'];
  $user_route_ids=$result_parent['route_ids'];
  $sql_route_ids= "select route_ids,rcs from az_user where userid='".$parent_id."'";
  $query_route_id = mysqli_query($dbc, $sql_route_ids);

  // $count_plan=mysqli_num_rows($query_route_id);

      $result_route_id=mysqli_fetch_array($query_route_id);
      $route_ids=$result_route_id['route_ids'];
      $rcs_access=$result_route_id['rcs'];


         $user_sql = "select az_routeid,az_rname from az_routetype where az_routeid in ($user_route_ids) order by az_create_date desc";
      
      
  
   $query_result_user = mysqli_query($dbc, $user_sql);
   while($row_u=mysqli_fetch_array($query_result_user))
   {
      $routeArray[0][] = array(
          'route_id' => $row_u['az_routeid'],
          'route_name' => $row_u['az_rname']
      );
      
   }

     if($userid!=1)
      {
         $sql = "select az_routeid,az_rname from az_routetype where az_routeid in ($route_ids) order by az_create_date desc";
      }
      else
      {
         $sql = "select az_routeid,az_rname from az_routetype where status=1 order by az_create_date desc";
      }
  
   $query_result = mysqli_query($dbc, $sql);

   $count_route=mysqli_num_rows($query_result);
/*   $route_dropdown="<option value=''>Select Route</option>";*/
   if($count_route>0)
   { 
             while($row=mysqli_fetch_array($query_result))
             {
                $routeArray[1][] = array(
                    'route_id' => $row['az_routeid'],
                    'route_name' => $row['az_rname']
                );
                
             }

             return $routeArray;
    }
    else {
               return $routeArray;
          }
}


function add_viewroutedropdown()
{

  
  global $dbc;
  $userid=$_SESSION['user_id'];
  $edit_userid=$_SESSION['edit_userid'];
  $sql_parent= "select parent_id,route_ids from az_user where userid='".$edit_userid."'";
  $result_parent = mysqli_fetch_array(mysqli_query($dbc, $sql_parent));


  $parent_id=$result_parent['parent_id'];
  // $user_route_ids=$result_parent['route_ids'];
  $sql_route_ids= "select route_ids,rcs from az_user where userid='".$parent_id."'";
  $query_route_id = mysqli_query($dbc, $sql_route_ids);

  // $count_plan=mysqli_num_rows($query_route_id);

      $result_route_id=mysqli_fetch_array($query_route_id);
      $route_ids=$result_route_id['route_ids'];
      $rcs_access=$result_route_id['rcs'];


     if($userid!=1)
      {
         $sql = "select az_routeid,az_rname from az_routetype where az_routeid in ($route_ids) order by az_create_date desc";
      }
      else
      {
         $sql = "select az_routeid,az_rname from az_routetype where status=1 order by az_create_date desc";
      }
  
   $query_result = mysqli_query($dbc, $sql);

   $count_route=mysqli_num_rows($query_result);
/*   $route_dropdown="<option value=''>Select Route</option>";*/
   if($count_route>0)
   { 
             while($row=mysqli_fetch_array($query_result))
             {
                $routeArray[] = array(
                    'route_id' => $row['az_routeid'],
                    'route_name' => $row['az_rname']
                );
                
             }

             return $routeArray;
    }
    else {
               return $routeArray;
          }
}



function viewroutedropdown_only()
{

  
  global $dbc;
 
  $sql = "select * from az_routetype order by az_create_date desc";
  $query_result = mysqli_query($dbc, $sql);

  $count_route=mysqli_num_rows($query_result);
  // $route_dropdown="<option value=''>Select Routing</option>";
   if($count_route>0)
   {
          if ($query_result) {
             
             while($row=mysqli_fetch_array($query_result))
             {
              $route_dropdown.="<option value='".$row['az_routeid']."'>".$row['az_rname']."</option>";
             }

             return $route_dropdown;


          } else {
               return $route_dropdown;
          }
    }
    else {
               return 0;
          }

 
  
}


function viewgatewaydropdown()
{
  global $dbc;
   $sql = "select * from az_sms_gateway where status='1' order by created_at desc";
   $query_result = mysqli_query($dbc, $sql);

   $count_gateway=mysqli_num_rows($query_result);
   $gateway_dropdown="";
/*  $gateway_dropdown="<option value=''>Select Gateway</option>";*/
   if($count_gateway>0)
   {
          if ($query_result) {
             
             while($row=mysqli_fetch_array($query_result))
             {
                $gateway_dropdown.="<option value='".$row['gateway_id']."'>".$row['smsc_id']."</option>";
             }

             return $gateway_dropdown;


          } else {
               return $gateway_dropdown;
          }
    }
    else {
               return $gateway_dropdown;
          }

}

function viewgatewaydropdown2()
{
  global $dbc;
   $sql = "select gateway_id,smsc_id from az_sms_gateway where status='1' order by created_at desc";
   $query_result = mysqli_query($dbc, $sql);

   $count_gateway=mysqli_num_rows($query_result);
   $gateway_dropdown="";
/*  $gateway_dropdown="<option value=''>Select Gateway</option>";*/
   if($count_gateway>0)
   {
          if ($query_result) {
            $gatewayArray = array();
             while($row=mysqli_fetch_array($query_result))
             {
              $gateway_id = $row['gateway_id'];
              $gateway_name = $row['smsc_id'];
                $gatewayArray[] = array(
                  'gateway_id' => $gateway_id,
                  'gateway_name' => $gateway_name
              );
             }

            


          } 
    }
    return $gatewayArray;
    

}
function load_voice_gateway()
{
  global $dbc;
   $sql = "select * from voice_gateway where status='1' order by created_date desc";
   $query_result = mysqli_query($dbc, $sql);

   $count_gateway=mysqli_num_rows($query_result);
   $gateway_dropdown="";
/*  $gateway_dropdown="<option value=''>Select Gateway</option>";*/
   if($count_gateway>0)
   {
          if ($query_result) {
             
             while($row=mysqli_fetch_array($query_result))
             {
                $gateway_dropdown.="<option value='".$row['gateway_id']."'>".$row['gateway_name']."</option>";
             }

             return $gateway_dropdown;


          } else {
               return $gateway_dropdown;
          }
    }
    else {
               return $gateway_dropdown;
          }

}


function fetch_plan_name($plan_id)
{
   global $dbc;
   $sql_select = "SELECT * from az_plan where pid='$plan_id'";
        $query_select = mysqli_query($dbc, $sql_select);
        $query_result=mysqli_fetch_array($query_select);
        $count_plan=mysqli_num_rows($query_select);

        if($count_plan>0)
        {
            $plan_name=$query_result['p_name'];

            return $plan_name;
        }
        else
        {
            return $plan_name='';
        }

}

function fetch_route_name($route_id)
{
   global $dbc;
   $sql_select = "SELECT * from az_routetype where az_routeid='$route_id'";
        $query_select = mysqli_query($dbc, $sql_select);
        $query_result=mysqli_fetch_array($query_select);
        $count_route=mysqli_num_rows($query_select);

        if($count_route>0)
        {
            $route_name=$query_result['az_rname'];

            return $route_name;
        }
        else
        {
            return $route_name='';
        }

}



function fetch_gateway_name($gateway_ids)
{
   global $dbc;

   $gateway_id=explode(",",$gateway_ids);
 
   for($i=0;$i<count($gateway_id);$i++)
   {
       $sql_select = "SELECT * from az_sms_gateway where gateway_id='$gateway_id[$i]'";
        $query_select = mysqli_query($dbc, $sql_select);
        $query_result=mysqli_fetch_array($query_select);
        $count_gateway=mysqli_num_rows($query_select);

        if($count_gateway>0)
        {
            $gateway_name.=$query_result['smsc_id'].",";

            
        }
        else
        {
            $gateway_name.='';
        }
   }

   return $gateway_name;
   
}


function fetch_voice_gateway_name($gateway_ids)
{
   global $dbc;

   $gateway_id=explode(",",$gateway_ids);
 
   for($i=0;$i<count($gateway_id);$i++)
   {
       $sql_select = "SELECT * from voice_gateway where gateway_id='$gateway_id[$i]'";
        $query_select = mysqli_query($dbc, $sql_select);
        $query_result=mysqli_fetch_array($query_select);
        $count_gateway=mysqli_num_rows($query_select);

        if($count_gateway>0)
        {
            $gateway_name.=$query_result['gateway_name'].",";

            
        }
        else
        {
            $gateway_name.='';
        }
   }

   return $gateway_name;
   
}

function fetch_sender_name($sender_id)
{
   global $dbc;

  /* $gateway_id=explode(",",$gateway_ids);
 
   for($i=0;$i<count($gateway_id);$i++)
   {*/
       $sql_select = "SELECT * from az_senderid where sid='$sender_id'";
        $query_select = mysqli_query($dbc, $sql_select);
        $query_result=mysqli_fetch_array($query_select);
        $count_senderid=mysqli_num_rows($query_select);

        if($count_senderid>0)
        {
            $sender_name.=$query_result['senderid'].",";

            
        }
        else
        {
            $sender_name.='';
        }
   //}

   return $sender_name;
   
}


function fetch_username($userid)
{
   global $dbc;

  /* $gateway_id=explode(",",$gateway_ids);
 
   for($i=0;$i<count($gateway_id);$i++)
   {*/
       $sql_select = "SELECT user_name from az_user where userid='$userid'";
        $query_select = mysqli_query($dbc, $sql_select);
        $query_result=mysqli_fetch_array($query_select);
        $count_senderid=mysqli_num_rows($query_select);

        if($count_senderid>0)
        {
            $user_name=$query_result['user_name'].",";

            
        }
       
   //}

   return $user_name;
   
}

function createRoutePlan()
{
       global $dbc;
       /* $gateway_family = ucwords(trim($_POST['gateway_family']));*/
        $route_name = trim($_POST['route_name']);
        $status = trim($_POST['status']);
        $start_time = strtotime(trim($_POST['start_time']));
        $end_time = strtotime(trim($_POST['end_time']));
        $rate = trim($_POST['rate']);
        $sender_id = trim($_POST['sender_id']);
       
        
        
      /* $sql_select = "SELECT * from az_sms_gateway where p_name='$pname'";
        $query_select = mysqli_query($dbc, $sql_select);
        $count_plan=mysqli_num_rows($query_select);

        if($count_plan==0)
        {*/
     $sql = "INSERT INTO `az_routetype`(`az_rname`,`status`,`start_time`,`end_time`,`az_issenderid`,`rate`,`az_create_date`,`userid`) VALUES('".$route_name."','".$status."','".$start_time."','".$end_time."','".$sender_id."','".$rate."',now(),'".$_SESSION['user_id']."')";
          $query = mysqli_query($dbc, $sql);
          if ($query) {
              unset($_POST);
              $session_userid=$_SESSION['user_id'];
           get_last_activities($session_userid,'New routing information has been added.',@$login_date,@$logout_date);
              return '1';
          } else {
              return '0';
          }
        /*}
        else
        {
          return '0';
          
        }*/

       

}

