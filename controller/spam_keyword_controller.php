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
//include_once('../include/datatable_dbconnection.php');


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['type']) && $_POST['type'] == 'add_branding') {
    $rs = saveBranding();
    echo $rs;
  	/*if($rs=='1')
  	{
  		echo 1;
  	}
  	else if($rs=='2')
  	{
		echo 2;
  	}
  	else if($rs=='0')
  	{
  		echo 0;
  	}*/


}


if(isset($_REQUEST['list_type']))
{
    $list_type=$_REQUEST['list_type'];

  if($list_type=='all_keywords')
  {
      $table = 'spam_keyword';

      $primaryKey = 'id';

      $user_role=$_SESSION['user_role'];
      /*if($user_role!='mds_adm')
      {*/
              $columns = array(
          array( 'db' => 'created_dt','dt' => 0 ),

          array( 'db' => 'spam_keywords','dt' => 1),
            array( 'db' => 'route_id','dt' => 2,'formatter' => function( $d, $row ) {

                  $route_id=$d;
                  $route_name=get_routename($route_id);

                  return $route_name;

            }),
             array( 'db' => 'status','dt' => 3,'formatter' => function( $d, $row ) {

                 $status=$row[3];
               if($status==0)
               {
                    return "Disabled";
               }
               else
               {
                    return "Enabled";
               }

             }),
          array( 'db' => 'id','dt' => 4,'formatter' => function( $d, $row ) {
           
           $status=$row[3];
           $spam_id=$d;
           $spamkeyword=$row[1];
           $route=$row[2];
           if($status==0)
           {
             $action="
             <button class='btn btn-primary btn-sm me-1 mb-1 edit_spamkeyword_btn' type='button' data-bs-toggle='modal' data-bs-target='#editspamkeywordModel' data-id='".$spam_id."' data-spamkeyword='".$spamkeyword."' data-status='".$status."' data-route='".$route."'> <span class='fas fa-edit ms-1' data-fa-transform='shrink-3'></span>
                </button>&nbsp;
              <button class='btn btn-primary btn-sm me-1 mb-1 whitelist_btn' type='button' data-id='".$d."' >
             
                  <span class='fas fa-check ms-1' data-fa-transform='shrink-3'></span>
                </button>&nbsp;
                <button class='btn btn-primary btn-sm me-1 mb-1 delete_spam_keyword_btn' type='button'  data-id='".$d."'>
                  <span class='fas fa-trash ms-1' data-fa-transform='shrink-3'></span>
                </button>";
           }
           else
           {

             $action="
              <button class='btn btn-primary me-1 mb-1 edit_template_btn' type='button' data-bs-toggle='modal' data-bs-target='#edit_template_modal' data-id='".$spam_id."' data-spamkeyword='".$spamkeyword."' data-status='".$status."'> <span class='fas fa-edit ms-1' data-fa-transform='shrink-3'></span>
                </button>&nbsp;
              <button class='btn btn-primary btn-sm me-1 mb-1 block_btn' type='button' data-id='".$d."' >
             
                  <span class='fas fa-ban ms-1' data-fa-transform='shrink-3'></span>
                </button>&nbsp;
                <button class='btn btn-primary btn-sm me-1 mb-1 delete_btn' type='button'  data-id='".$d."'>
                  <span class='fas fa-trash ms-1' data-fa-transform='shrink-3'></span>
                </button>";
           }


             
                  return $action;
              })
         
         );
      //}
     

       
      // SQL server connection information
       global $sql_details ;


      $extraWhere="";

      $userid=$_SESSION['user_id'];
      if($userid!='1')
      {
        if($extraWhere!="")
        {
          $extraWhere=" and ((userid='$userid') or (userid='-1')) ";
        }
        else
        {
          $extraWhere=" ((userid='$userid') or (userid='-1'))";
        }
      }

      echo json_encode(
          SSP::complex( $_REQUEST, $sql_details, $table, $primaryKey, $columns,$test=null,$extraWhere )
      );
  }
    else if($list_type=='add_spam_keywords')
  {
    $rs=savespamkeywords();
      echo $rs;
   /* if($rs==1)
    {
     echo 1;
    }
    else
    {
      echo 0;
    }
*/
           
  }
   else if($list_type=='update_spam_keywords')
  {
    $rs=updatespamkeywords();
      echo $rs;
   /* if($rs==1)
    {
     echo 1;
    }
    else
    {
      echo 0;
    }
*/
           
  }

else if($list_type=='dropdown_route')
  {
    $rs=load_route();
      echo $rs;
   /* if($rs==1)
    {
     echo 1;
    }
    else
    {
      echo 0;
    }
*/
           
  }   else if($list_type=='delete_keyword')
  {
    $rs=delete_keyword();

    if($rs==1)
    {
      echo 1;
    }
    else
    {
      echo 0;
    }

           
  }
    else if($list_type=='whitelist_number')
  {
    $rs=whitelist_number();

    if($rs==1)
    {
      echo 1;
    }
    else
    {
      echo 0;
    }

           
  }
else if($list_type=='block_number')
  {
    $rs=block_number();

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

    function delete_keyword() {
        global $dbc;
        $id=$_REQUEST['id'];
       
        $sql = "delete from spam_keyword  where id='".$id."'";
        $result = mysqli_query($dbc, $sql);
        if($result)
        {
          return 1;
        }
        else
        {
          return 0;
        }
        
    }
        function whitelist_number() {
        global $dbc;
        $id=$_REQUEST['id'];
       
        $sql = "update az_blocknumbers set status='1' where id='".$id."'";
        $result = mysqli_query($dbc, $sql);
        if($result)
        {
          return 1;
        }
        else
        {
          return 0;
        }
        
    }

     function block_number() {
        global $dbc;
        $id=$_REQUEST['id'];
       
        $sql = "update az_blocknumbers set status='0' where id='".$id."'";
        $result = mysqli_query($dbc, $sql);
        if($result)
        {
          return 1;
        }
        else
        {
          return 0;
        }
        
    }


     function load_route() {
        global $dbc;
      
        $sql = "select az_routeid,az_rname from az_routetype where status='1'";
        $result = mysqli_query($dbc, $sql);
        $count=mysqli_num_rows($result);

        if($count>0)
        {
            $options="<option>Select Route</option>";
           while ($row=mysqli_fetch_array($result)) {
             $route_id=$row['az_routeid'];
             $route_name=$row['az_rname'];
             $options.="<option value='$route_id'>$route_name</option>";

           }
           return $options;
        }
        else
        {
          return 0;
        }
       
        
    }

function get_routename($route_id) {
        global $dbc;
      
        $sql = "select az_rname from az_routetype where az_routeid='$route_id'";
        $result = mysqli_query($dbc, $sql);
        $count=mysqli_num_rows($result);

        if($count>0)
        {
           
           while ($row=mysqli_fetch_array($result)) {
            
             $route_name=$row['az_rname'];
            

           }
           return $route_name;
        }
        else
        {
          return 0;
        }
       
        
    }


function savespamkeywords()
{
	      global $dbc;


        $userid=$_SESSION['user_id'];
        $upload_type = $_POST['upload_type'];
        $status=$_POST['status'];
        $route=$_REQUEST['route'];
         
        if($upload_type=='multiple')
        {
           //$company_logo=$_FILES['company_logo']['name'];
        }
        else
        {
          $keyword= $_POST['keyword'];
        }

       
        $sql_select = "SELECT * from spam_keyword where (userid='$userid') and route_id='$route'";
        $query_select = mysqli_query($dbc, $sql_select);
        $count_numbers=mysqli_num_rows($query_select);
        $date=date("Y-m-d h:i:s");
        if($count_numbers==0)
        {

         
             $sql = "INSERT INTO `spam_keyword`(userid,spam_keywords,status,created_dt,route_id) VALUES ('" . $userid . "','" . $keyword . "','" . $status . "','" . $date . "','" . $route . "')";


            $query = mysqli_query($dbc, $sql)or die(mysqli_error($dbc));
            if ($query) {
                unset($_POST);
                return 1;
            } else {
                return 0;
            }
         
         


        } 
        else
        {
           $sql = "update `spam_keyword` set status='" . $status . "',spam_keywords='" . $keyword . "',created_dt='$date' where route_id='$route' and userid='$userid'";


            $query = mysqli_query($dbc, $sql);
            if ($query) {
                unset($_POST);
                return 1;
            } else {
                return 0;
            }



        }

       

}


function updatespamkeywords()
{
        global $dbc;


        $userid=$_SESSION['user_id'];
        $upload_type = $_POST['upload_type'];
        $status=$_POST['status'];
        $route=$_REQUEST['route'];
        $spamkeyword_id=$_REQUEST['spamkeyword_id'];
         
    
      $keyword= $_REQUEST['keyword'];
       
       $sql = "update `spam_keyword` set status='" . $status . "',spam_keywords='" . $keyword . "',route_id='".$route."' where id='$spamkeyword_id'";
        $query = mysqli_query($dbc, $sql) or mysqli_error($dbc);
            if ($query) {
                unset($_POST);
                return 1;
            } else {
                return 0;
            }



       
       

}
