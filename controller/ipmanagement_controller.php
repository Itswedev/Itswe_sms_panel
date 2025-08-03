<?php
session_start();
$log_file = "../error/logfiles/branding_controller.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);



include_once('../include/connection.php');
require('classes/ssp.class.php');
include('../include/config.php');
include('classes/last_activities.php');




if(isset($_REQUEST['list_type']))
{
    $list_type=$_REQUEST['list_type'];

  if($list_type=='all_block_ips')
  {
      $table =IPMANAGEMENT;

      $primaryKey = 'id';

      $columns = array(
          array( 'db' => 'date','dt' => 0 ),
          array( 'db' => 'ip_address','dt' => 1),
          array( 'db' => 'username','dt' => 2),
          array( 'db' => 'id','dt' => 3,'formatter' => function( $d, $row ) {
           
         
             $action="
            
                <button class='btn btn-primary btn-sm me-1 mb-1 delete_btn' type='button'  data-id='".$d."'>
                  <span class='fas fa-trash ms-1' data-fa-transform='shrink-3'></span>
                </button>";
         


             
                  return $action;
              })
         
      );
       
      // SQL server connection information
      global $sql_details;

      $extraWhere="";

/*      $username=$_SESSION['user_id'];
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
   else if($list_type=='delete_ip')
  {
    $rs=delete_ip();

    if($rs==1)
    {
      echo 1;
    }
    else
    {
      echo 0;
    }

           
  }
  
}


    function delete_ip() {
        global $dbc;
        $id=$_REQUEST['id'];
       
        $sql = "delete from ip_management  where id='".$id."'";
        $result = mysqli_query($dbc, $sql);
        if($result)
        {
           $session_userid=$_SESSION['user_id'];
           get_last_activities($session_userid,'The IP address that was blacklisted has been removed from the list.',@$login_date,@$logout_date);
          return 1;
        }
        else
        {
          return 0;
        }
        
    }

