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
    else if($list_type=='all_gateway_name')
    {
           
           $return_gateway=all_gateway_dropdown();

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


function all_gateway_dropdown()
{
global $dbc;
        $result = array();
        $sql = "SELECT gateway_id,smsc_id  FROM az_sms_gateway where status=1 ORDER BY created_at DESC";
        $values = mysqli_query($dbc, $sql);
        $option="<option value=''>Select Gateway</option>";
        $option.="<option value='All'>All</option>";
        while ($row = mysqli_fetch_assoc($values)) {
            $option.="<option value='".$row['smsc_id']."'>".$row['smsc_id']."</option>";
        }
        return $option;

}

 function deleteGateway() {
        global $dbc;
        $gateway_id=$_REQUEST['gateway_id'];
        $result = array();
        $sql = "delete FROM az_sms_gateway where gateway_id='".$gateway_id."'";
        $values = mysqli_query($dbc, $sql);
        if($values)
        {
          $session_userid=$_SESSION['user_id'];
               get_last_activities($session_userid,'The information about the gateway has been removed.. ',@$login_date,@$logout_date);
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
        $sql = "SELECT *  FROM az_sms_gateway ORDER BY created_at DESC";
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
        $sql = "SELECT *  FROM az_sms_gateway where gateway_id='$gateway_id' ";
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
            $smsc_id=$value['smsc_id'];
           $host=$value['host'];
           $locate=$value['locate'];
            

            $pstatus=$value['status'];
            if($pstatus=='1')
            {
               $status='Active';
            }
            else
            {
              $status='Inactive';
            }
            $created_dt=date('d-M-Y h:i a', strtotime($value['created_at']));
              $return_plan.="<tr>
                <td width='5%'>$i</td>
                <td width='20%'>$smsc_id</td>
                <td width='20%'>$locate</td>
                <td width='20%'>$host</td>
              
                <td width='15%'>$status</td>
                <td width='15%'>$created_dt</td>
                
                <td width='25%'>
                  <button class='btn btn-primary me-1 mb-1 edit_gatway_btn' type='button' data-bs-toggle='modal' data-bs-target='#edit_gateway_modal' data-id='".$gateway_id."'>
                  <i class='fa fa-pencil'></i>
                  </button>&nbsp;<button class='btn btn-primary me-1 mb-1 delete_gateway_btn' type='button' data-id='".$gateway_id."'>
                  <i class='fa fa-trash'></i>
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
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
       /* $ip_address = trim($_POST['ip_address']);*/
        $allowed_smsc_id = trim($_POST['allowed_smsc_id']);
        $host = trim($_POST['host']);
        $port = trim($_POST['port']);
        // $tx_mode = trim($_POST['tx_mode']);
        $system_type = trim($_POST['system_type']);
        $enquiry_interval = trim($_POST['enquiry_interval']);
        $charset = trim($_POST['charset']);
        $source_ton = trim($_POST['source_ton']);
        $source_npi = trim($_POST['source_npi']);
        $destination_ton = trim($_POST['destination_ton']);
        $destination_npi = trim($_POST['destination_npi']);
        $instances = trim($_POST['instances']);
        $max_pending = trim($_POST['max_pending']);
        $locate = trim($_POST['locate']);
        $gateway_status = trim($_POST['gateway_status']);

        $bind_mode_val = trim($_POST['bind_mode_val']);
        $tx_mode='yes';
        if($bind_mode_val=='yes')
        {
          $port = trim($_POST['port']);
          $tx_port=0;
          $rx_port=0;

        }else{
          $port=0;
          $tx_port = trim($_POST['tx_port']);
          $rx_port = trim($_POST['rx_port']);
        }


        $log_file="/etc/vapio/logs/".$smsc_id.".log";
        
        
      /*  $sql_select = "SELECT * from az_sms_gateway where p_name='$pname'";
        $query_select = mysqli_query($dbc, $sql_select);
        $count_plan=mysqli_num_rows($query_select);

        if($count_plan==0)
        {*/
        $sql = "INSERT INTO `az_sms_gateway`(`smsc_id`,`username`,`password`,
`allowed_smsc_id`,`host`,`port`,`tx_mode`,`system_type`,`enquiry_interval`,`charset`,`source_ton`,`source_npi`,`destination_ton`,`destination_npi`,`instances`,`max_pending`,`userid`,`created_at`,`status`,`log_file`,`locate`,`tx_port`,`rx_port`) VALUES('".$smsc_id."','".$username."','".$password."','".$allowed_smsc_id."','".$host."','".$port."','".$tx_mode."','".$system_type."','".$enquiry_interval."','".$charset."','".$source_ton."','".$source_npi."','".$destination_ton."','".$destination_npi."','".$instances."','".$max_pending."','" . $_SESSION['user_id'] . "',now(),'".$gateway_status."','".$log_file."','".$locate."',".$tx_port.",".$rx_port.")";
	        $query = mysqli_query($dbc, $sql);
	        if ($query) {
            $time=time();
            $filename=$smsc_id.".conf";
           // $filepath="/var/www/html/itswe_panel/sms_dashboard/view/include/data/".$filename;

            if($locate=='smsc')
            {
              $filepath="/var/kannel/smsc/".$filename;
            }
            else if($locate=='otp')
            {
              $filepath="/var/kannel/otp/".$filename;
            }
            
            $myfile = fopen($filepath, "w");
            fwrite($myfile, $txt);
            $log_file="/etc/vapio/logs/".$smsc_id.".log";

            if($bind_mode_val=='yes')
            {
                $file_txt = "group = smsc\r\nsmsc = smpp\r\nsmsc-id = $smsc_id\r\nallowed-smsc-id = $allowed_smsc_id\r\nhost = $host\r\nport = $port\r\ntransceiver-mode = $tx_mode\r\nsystem-type = $system_type\r\nsmsc-username = $username\r\nsmsc-password = $password\r\nsource-addr-ton = $source_ton\r\nsource-addr-npi = $source_npi\r\ndest-addr-ton = $destination_ton\r\ndest-addr-npi = $destination_npi\r\nenquire-link-interval = $enquiry_interval\r\ninstances = $instances\r\nmax-pending-submits = $max_pending\r\nalt-charset = GSM\r\n#preferred-smsc-id = NEW\r\n#log-file = '$log_file'\r\n";
                
            }
            else{

              $file_txt = "group = smsc\r\nsmsc = smpp\r\nsmsc-id = $smsc_id\r\nallowed-smsc-id = $allowed_smsc_id\r\nhost = $host\r\nport = $tx_port\r\n#transceiver-mode = $tx_mode\r\nsystem-type = $system_type\r\nsmsc-username = $username\r\nsmsc-password = $password\r\nsource-addr-ton = $source_ton\r\nsource-addr-npi = $source_npi\r\ndest-addr-ton = $destination_ton\r\ndest-addr-npi = $destination_npi\r\nenquire-link-interval = $enquiry_interval\r\ninstances = $instances\r\nmax-pending-submits = $max_pending\r\nalt-charset = GSM\r\n#preferred-smsc-id = NEW\r\n#log-file = '$log_file'\r\n";



              $file_txt.= "\n\ngroup = smsc\r\nsmsc = smpp\r\nsmsc-id = $smsc_id\r\nallowed-smsc-id = $allowed_smsc_id\r\nhost = $host\r\nreceive-port = $rx_port\r\n#transceiver-mode = $tx_mode\r\nsystem-type = $system_type\r\nsmsc-username = $username\r\nsmsc-password = $password\r\nsource-addr-ton = $source_ton\r\nsource-addr-npi = $source_npi\r\ndest-addr-ton = $destination_ton\r\ndest-addr-npi = $destination_npi\r\nenquire-link-interval = $enquiry_interval\r\ninstances = $instances\r\nmax-pending-submits = $max_pending\r\nalt-charset = GSM\r\n#preferred-smsc-id = NEW\r\n#log-file = '$log_file'\r\n";

            }
        
        fwrite($myfile, $file_txt);
            fclose($myfile);
	            unset($_POST);
              $last_id = mysqli_insert_id($dbc);

              $sql_update="update az_sms_gateway set conf_file='$filepath' where gateway_id='$last_id'";
              $res=mysqli_query($dbc,$sql_update);

               $session_userid=$_SESSION['user_id'];
               get_last_activities($session_userid,'New gateway information has been added. ',@$login_date,@$logout_date);
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


function updateGateway()
{
  global $dbc;
       /* $gateway_family = ucwords(trim($_POST['gateway_family']));*/
        $smsc_id = trim($_POST['smsc_id']);
        $gateway_id=$_REQUEST['gateway_id'];
        $conf_file=$_REQUEST['conf_file'];
        $log_file=$_REQUEST['log_file'];
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        /*$ip_address = trim($_POST['ip_address']);*/
        $allowed_smsc_id = trim($_POST['allowed_smsc_id']);
        $host = trim($_POST['host']);
        $port = trim($_POST['port']);
        $tx_mode = trim($_POST['tx_mode']);
        $system_type = trim($_POST['system_type']);
        $enquiry_interval = trim($_POST['enquiry_interval']);
        $charset = trim($_POST['charset']);
        $source_ton = trim($_POST['source_ton']);
        $source_npi = trim($_POST['source_npi']);
        $destination_ton = trim($_POST['destination_ton']);
        $destination_npi = trim($_POST['destination_npi']);
        $instances = trim($_POST['instances']);
        $max_pending = trim($_POST['max_pending']);
        $locate = trim($_POST['locate']);
        $gateway_status = trim($_POST['gateway_status']);
       // $log_file="/etc/vapio/logs/".$smsc_id.".log";
        
       
        $sql = "update `az_sms_gateway` set `username`='$username',`password`='$password',`host`='$host',`port`='$port',`tx_mode`='$tx_mode',`system_type`='$system_type',`enquiry_interval`='$enquiry_interval',`charset`='$charset',`source_ton`='$source_ton',`source_npi`='$source_npi',`destination_ton`='$destination_ton',`destination_npi`='$destination_npi',`instances`='$instances',`max_pending`='$max_pending',`status`='$gateway_status' ,`locate`='$locate' where gateway_id='$gateway_id'";
          $query = mysqli_query($dbc, $sql);
          if ($query) {
            $time=time();
            //$filename=$smsc_id.".conf";
            //$filepath="/var/www/html/itswe_panel/sms_dashboard/view/include/data/".$filename;
            $filepath=$conf_file;
            $myfile = fopen($filepath, "w");
            fwrite($myfile, $txt);
            //$log_file="/etc/vapio/logs/".$smsc_id.".log";
            $file_txt = "group = smsc\r\nsmsc = smpp\r\nsmsc-id = $smsc_id\r\nallowed-smsc-id = $allowed_smsc_id\r\nhost = $host\r\nport = $port\r\ntransceiver-mode = $tx_mode\r\nsystem-type = $system_type\r\nsmsc-username = $username\r\nsmsc-password = $password\r\nsource-addr-ton = $source_ton\r\nsource-addr-npi = $source_npi\r\ndest-addr-ton = $destination_ton\r\ndest-addr-npi = $destination_npi\r\nenquire-link-interval = $enquiry_interval\r\ninstances = $instances\r\nmax-pending-submits = $max_pending\r\nalt-charset = GSM\r\n#preferred-smsc-id = NEW\r\n#log-file = '$log_file'\r\n";
              fwrite($myfile, $file_txt);
              fclose($myfile);
              unset($_POST);
              $session_userid=$_SESSION['user_id'];
               get_last_activities($session_userid,'Gateway information has been updated. ',@$login_date,@$logout_date);
              return '1';
          } else {
              return '0';
          }
        

       

}

