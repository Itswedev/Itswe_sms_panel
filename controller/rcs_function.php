<?php 
session_start();
ob_start();
$log_file = "../error/logfiles/sender_id_function.log";
 
 error_reporting(E_ALL); 
 
// setting error logging to be active
ini_set("log_errors", TRUE); 
  
// setting the logging file in php.ini
ini_set('error_log', $log_file);
error_reporting(0);
include_once('../include/connection.php');
include_once('../include/config.php');
require('classes/ssp.class.php');
include_once('controller/classes/last_activities.php');
//include_once('../include/datatable_dbconnection.php');
$sender_type=@$_REQUEST['sender_type'];
if($sender_type=='all_access_token')
{
    $table = RCS;

            $primaryKey = 'id';
            $columns = array(
                 array( 'db' => 'user_id','dt' => 0,'formatter' => function( $d, $row ) {
                                   $username=get_username($d);
                        return $username;

                    }),
                        array( 'db' => 'client_id','dt' => 1 ),
                        array( 'db' => 'secret_code','dt' => 2 ),
                    array( 'db' => 'bot_type','dt' => 3),
                    
                    array( 'db' => 'date','dt' => 4 ,'formatter' => function( $d, $row ) {
			            return date( 'd-m-Y h:i a', strtotime($d));
			        })
                 
                   
                );

            
            global $sql_details ;
            $extraWhere="";

            
           
            echo json_encode(
                SSP::complex( $_REQUEST, $sql_details, $table, $primaryKey, $columns,$test=null,$extraWhere )
            );

}
else if($sender_type=='all_rcs_template')
{
    $table = RCS_TEMP;

            $primaryKey = 'id';
            $columns = array(
                 array( 'db' => 'user_id','dt' => 0,'formatter' => function( $d, $row ) {
                                   $username=get_username($d);
                        return $username;

                    }),
                    array( 'db' => 'bot_type','dt' => 1 ),
                    array( 'db' => 'template_name','dt' => 2 ),
                    array( 'db' => 'created_date','dt' => 3 ,'formatter' => function( $d, $row ) {
			            return date( 'd-m-Y h:i a', strtotime($d));
			        })
                 
                   
                );

            
            global $sql_details ;
            $extraWhere="";

            
           
            echo json_encode(
                SSP::complex( $_REQUEST, $sql_details, $table, $primaryKey, $columns,$test=null,$extraWhere )
            );
}

if (isset($_POST['type']) && $_POST['type'] == 'create_token') {
    $rs = insert_token();
    if ($rs['status'] == true && $rs['msg'] == 'Success') {

        echo $rs['msg'];
           
        
    } else if ($rs['status'] == false && $rs['msg'] == 'Error') {
        echo 'FALSE';
        exit;
    }
}
else if (isset($_POST['type']) && $_POST['type'] == 'add_template') {
    $rs = insert_template();
    if ($rs['status'] == true && $rs['msg'] == 'Success') {

        echo $rs['msg'];
           
        
    } else if ($rs['status'] == false && $rs['msg'] == 'Error') {
        echo 'FALSE';
        exit;
    }
}
else if (isset($_POST['type']) && $_POST['type'] == 'load_bot_template') {
    $rs = load_template();
    echo $rs;

    
}


function load_template()
{
    global $dbc;
    $userid=$_SESSION['user_id'];
    $bot_type = $_REQUEST['bot_type'];
    $q = "SELECT template_name,id FROM rcs_template WHERE user_id = '".$userid."' and bot_type='".$bot_type."'";
        $rs = mysqli_query($dbc, $q);
        $option = "<option value=''>Select Template</option>";

            
        if (mysqli_num_rows($rs) > 0) {   
            while ($rows = mysqli_fetch_assoc($rs)) {
                $template_name = $rows['template_name'];
                $option .= "<option value='".$rows['template_name']."'>".$template_name."<option>";
            }
            
        }
        return $option;

} 

    function getUserIds() {
        global $dbc;
        $out = array();
        $ids = '';
        $q = "SELECT userid FROM az_user WHERE parent_id = {$_SESSION['user_id']}";
        $rs = mysqli_query($dbc, $q);
        if (mysqli_num_rows($rs) > 0) {
            while ($rows = mysqli_fetch_assoc($rs)) {
                $out['userid'][] = $rows['userid'];
            }
            $ids = implode(',', $out['userid']);
        }
        return $ids;
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
     function insert_token() {
        global $dbc;
      
        $userid=$_REQUEST['username_senderid'];
        //if($_SESSION['user_id'] != 1) {
        if (isset($_POST['client_id']) && !empty($_POST['client_id'])) {
            $client_id = $_POST['client_id'];
        } else {
            $client_id = "";
        }

        if (isset($_POST['client_secret']) && !empty($_POST['client_secret'])) {
            $client_secret = $_POST['client_secret'];
        } else {
            $client_secret = '';
        }
        

        if (isset($_POST['bot_type']) && !empty($_POST['bot_type'])) {
            $bot_type = $_POST['bot_type'];
        } else {
            $bot_type = '';
        }
        
        
        $client_val = $client_id.":".$client_secret;

        $authorization = base64_encode($client_val);
        $endpoint = 'https://auth.virbm.in/auth/oauth/token?grant_type=client_credentials';

        $data = array(
          'grant_type' => 'client_credentials'
        );

        $headers = array(
          'Accept: application/json',
          'Authorization: Basic '.$authorization
        );

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $endpoint);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($curl);

        if ($response === false) {
          $error = curl_error($curl);
          // Handle the error accordingly
        } else {
          // Process the response
          $responseData = json_decode($response, true);

        if($responseData['access_token']!='')
                            {

                                $access_token = $responseData['access_token'];
                                $sql="insert into rcs_cred(`client_id`,`secret_code`,`access_token`,`user_id`,`bot_type`) values('".$client_id."','".$client_secret."','".$access_token."','".$userid."','".$bot_type."')";
                                $result=mysqli_query($dbc,$sql);
                                
                            }
        }

        curl_close($curl);


        if ($result)
            return array('status' => true, 'msg' => 'Success');
        else
            return array('status' => false, 'msg' => 'Error');
    }


    function insert_template() {
        global $dbc;
      
        $userid=$_REQUEST['username_senderid'];
        //if($_SESSION['user_id'] != 1) {
        if (isset($_POST['template_name']) && !empty($_POST['template_name'])) {
            $template_name = $_POST['template_name'];
        } else {
            $template_name = "";
        }

       
        if (isset($_POST['bot_type']) && !empty($_POST['bot_type'])) {
            $bot_type = $_POST['bot_type'];
        } else {
            $bot_type = '';
        }

        if (isset($_POST['template_type']) && !empty($_POST['template_type'])) {
            $template_type = $_POST['template_type'];
        } else {
            $template_type = '';
        }


        $sql="select * from rcs_cred where user_id='".$userid."' and bot_type='".$bot_type."'";
        $result=mysqli_query($dbc,$sql);
        $rowcount=mysqli_num_rows($result);
        if($rowcount > 0)
        {
            while($row = mysqli_fetch_array($result))
            {
                $rcs_cred_id = $row['id'];
                $cred_bot_type = $row['bot_type'];


            }

            $sql="insert into rcs_template(`user_id`,`bot_type`,`template_name`,`rcs_cred_id`,`template_type`) values('".$userid."','".$bot_type."','".$template_name."','".$rcs_cred_id."','".$template_type."')";
                                $result=mysqli_query($dbc,$sql);

            if ($result)
                return array('status' => true, 'msg' => 'Success');
            else
                return array('status' => false, 'msg' => 'Error');
        }
        else
        {
            return array('status' => false, 'msg' => 'Please generate access token!!');
        }
        
                                
                                
    }



 ?>