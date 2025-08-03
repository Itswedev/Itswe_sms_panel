<?php
session_start();
$log_file = "../error/logfiles/gateway_controller.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);
include_once('../include/connection.php');
include('classes/last_activities.php');
if (isset($_POST['add_gateway']) && $_POST['add_gateway'] == 'add_gateway') {
   $rs = saveGateway();
  	if($rs=='1')
  	{
  		echo "Gateway added successfully";
  	}
  	else if($rs=='0')
  	{
		echo "Failed to create Gateway";
  	}
  


}

if(isset($_REQUEST['list_type']))
{
    $list_type=$_REQUEST['list_type'];


  if($list_type=='all_gateway')
    {
           $result = viewallgateway();

            $return_gateway=all_gateway($result);

            echo $return_gateway;
    }
    else if($list_type=='load_gateway_edit_form')
    {
           $result = viewallgateway_byid();
            echo json_encode($result);
    }
    else if($list_type=='update_gateway')
    {
           $rs = updateGateway();
          if($rs=='1')
          {
            echo 1;
          }
          else if($rs=='0')
          {
          echo 0;
          }
  
           
    }
    else if($list_type=='delete_gateway')
    {
           $rs = deleteGateway();
         echo $rs;
  
           
    }
}


 function deleteGateway() {
        global $dbc;
        $gateway_id=$_REQUEST['gateway_id'];
        $result = array();
        $sql = "delete FROM voice_gateway where gateway_id='".$gateway_id."'";
        $values = mysqli_query($dbc, $sql);
        if($values)
        {
          $session_userid=$_SESSION['user_id'];
               get_last_activities($session_userid,'The information about the voice gateway has been removed.. ',@$login_date,@$logout_date);
          return 1;
        }
        else
        {
          return 0;
        }
        
    }

 function viewallgateway() {
        global $dbc;
        $result = array();
        $sql = "SELECT *  FROM voice_gateway ORDER BY created_date DESC";
        $values = mysqli_query($dbc, $sql);
        while ($row = mysqli_fetch_assoc($values)) {
            $gateway_id = $row['gateway_id'];
            $result[$gateway_id] = $row;
        }
        return $result;
    }


 function viewallgateway_byid() {
        global $dbc;
        $gateway_id=$_REQUEST['gateway_id'];
        $result = array();
        $sql = "SELECT *  FROM voice_gateway where gateway_id='$gateway_id' ";
        $values = mysqli_query($dbc, $sql);
        while ($row = mysqli_fetch_assoc($values)) {
           
            $result = $row;
        }
        return $result;
    }

         function all_gateway($result)
        {
          $i = 1;
          if (!empty($result)) { 
         
          foreach ($result as $key => $value) {
            $gateway_id=$value['gateway_id'];
            $smsc_id=$value['gateway_name'];
            $end_point=$value['end_point'];
          

            $pstatus=$value['status'];
            if($pstatus=='1')
            {
               $status='Active';
            }
            else
            {
              $status='Inactive';
            }
            $created_dt=date('d-M-Y', strtotime($value['created_date']));
              $return_plan.="<tr>
                <td width='5%'>$i</td>
                <td width='20%'>$smsc_id</td>
                <td width='20%'>$end_point</td>
              
                <td width='15%'>$status</td>
                <td width='15%'>$created_dt</td>
                
                <td width='25%'>
                  <button class='btn btn-primary me-1 mb-1 edit_gatway_btn' type='button' data-bs-toggle='modal' data-bs-target='#edit_gateway_modal' data-id='".$gateway_id."'>
                    <span class='fas fa-edit ms-1' data-fa-transform='shrink-3'></span>
                  </button>&nbsp;<button class='btn btn-primary me-1 mb-1 delete_gateway_btn' type='button' data-id='".$gateway_id."'>
                    <span class='fas fa-trash ms-1' data-fa-transform='shrink-3'></span>
                  </button>
                </td>
              </tr>";
              $i++;
          }

                return $return_plan;
          } 
          else
          {
            return "No record available";
          }
        }




function saveGateway()
{
	global $dbc;
       /* $gateway_family = ucwords(trim($_POST['gateway_family']));*/
        $smsc_id = trim($_POST['smsc_id']);
        $end_point = trim($_POST['end_point']);
        
        $sql = "INSERT INTO `voice_gateway`(`gateway_name`,`end_point`) VALUES('".$smsc_id."','".$end_point."')";
	      $query = mysqli_query($dbc, $sql);
	        if ($query) {
               $session_userid=$_SESSION['user_id'];
               get_last_activities($session_userid,'New gateway information has been added. ',@$login_date,@$logout_date);
	            return '1';
	        } else {
	            return '0';
	        }
      

}


function updateGateway()
{
  global $dbc;
       /* $gateway_family = ucwords(trim($_POST['gateway_family']));*/
        $smsc_id = trim($_POST['smsc_id']);
        $gateway_id=$_REQUEST['gateway_id'];
        $end_point=$_REQUEST['end_point'];
        $gateway_status = trim($_POST['gateway_status']);
       // $log_file="/etc/vapio/logs/".$smsc_id.".log";
        
       
        $sql = "update `voice_gateway` set `end_point`='$end_point',`status`='$gateway_status' where gateway_id='$gateway_id'";
          $query = mysqli_query($dbc, $sql);
          if ($query) {
           
              $session_userid=$_SESSION['user_id'];
               get_last_activities($session_userid,'Voice Gateway information has been updated. ',@$login_date,@$logout_date);
              return '1';
          } else {
              return '0';
          }
        

       

}

