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

  if($list_type=='all_block_numbers')
  {
      $table = 'az_blocknumbers';

      $primaryKey = 'id';

      $user_role=$_SESSION['user_role'];
      if($user_role!='mds_adm')
      {
              $columns = array(
          array( 'db' => 'added_date','dt' => 0 ),

          array( 'db' => 'numbers','dt' => 1),
          array( 'db' => 'status','dt' => 2,'formatter' => function( $d, $row ) {
              if($d==0)
              {
                $stat="Blocked";

              }
              else
              {
                $stat="Whitelist";
              }

              return $stat;
          }),
          array( 'db' => 'id','dt' => 3,'formatter' => function( $d, $row ) {
           
           $status=$row[2];
           if($status==0)
           {
             $action="
              <button class='btn btn-primary btn-sm me-1 mb-1 whitelist_btn' type='button' data-id='".$d."' >
             
              <i class='fa fa-check'></i>
                </button>&nbsp;
                <button class='btn btn-primary btn-sm me-1 mb-1 delete_btn' type='button'  data-id='".$d."'>
                <i class='fa fa-trash'></i>
                </button>";
           }
           else
           {

             $action="
              <button class='btn btn-primary btn-sm me-1 mb-1 block_btn' type='button' data-id='".$d."' >
             
              <i class='fa fa-check'></i>
                </button>&nbsp;
                <button class='btn btn-primary btn-sm me-1 mb-1 delete_btn' type='button'  data-id='".$d."'>
                <i class='fa fa-trash'></i>
                </button>";
           }


             
                  return $action;
              })
         
         );
      }
      else
      {
          $columns = array(
          array( 'db' => 'added_date','dt' => 0 ),
          array( 'db' => 'userid','dt' => 1,'formatter' => function( $d, $row ) {

                  if($d!=-1)
                  {
                     $username=get_username($d);
                  return $username;
                  }
                  else
                  {
                     $username='All';
                     $username.=get_username($d);
                  return $username;
                  }
                 
              } ),
          array( 'db' => 'numbers','dt' => 2),
          array( 'db' => 'status','dt' => 3,'formatter' => function( $d, $row ) {
              if($d==0)
              {
                $stat="Blocked";

              }
              else
              {
                $stat="Whitelist";
              }

              return $stat;
          }),
          array( 'db' => 'id','dt' => 4,'formatter' => function( $d, $row ) {
           
           $status=$row[3];
           if($status==0)
           {
             $action="
              <button class='btn btn-primary btn-sm me-1 mb-1 whitelist_btn' type='button' data-id='".$d."' >
             
              <i class='fa fa-check'></i>
                </button>&nbsp;
                <button class='btn btn-primary btn-sm me-1 mb-1 delete_btn' type='button'  data-id='".$d."'>
                <i class='fa fa-trash'></i>
                </button>";
           }
           else
           {

             $action="
              <button class='btn btn-primary btn-sm me-1 mb-1 block_btn' type='button' data-id='".$d."' >
             
              <i class='fa fa-check'></i>
                </button>&nbsp;
                <button class='btn btn-primary btn-sm me-1 mb-1 delete_btn' type='button'  data-id='".$d."'>
                <i class='fa fa-trash'></i>
                </button>";
           }


             
                  return $action;
              })
         
      );
      }

       
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
    else if($list_type=='add_block_numbers')
  {
    $rs=saveblocknumbers();
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
   else if($list_type=='delete_number')
  {
    $rs=delete_number();

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

    function delete_number() {
        global $dbc;
        $id=$_REQUEST['id'];
       
        $sql = "delete from az_blocknumbers  where id='".$id."'";
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




function saveblocknumbers()
{
	      global $dbc;


        $userid=$_SESSION['user_id'];



        $upload_type = $_POST['upload_type'];
         $status=$_POST['status'];
         $user_role=$_SESSION['user_role'];
         if($user_role!='mds_usr')
         {
            $userid=$_REQUEST['username'];
         }
         
        if($upload_type=='multiple')
        {
           //$company_logo=$_FILES['company_logo']['name'];
          $fname = explode('.', $_FILES['mobile_file']['name']);
          $filename=$_FILES['mobile_file']['name'];
          $extension = end($fname);    
          if($extension=='csv')
          {
              if (($handle = fopen($_FILES['mobile_file']['tmp_name'], "r")) !== FALSE) {
                 while (($data = fgetcsv($handle, 100000, ",")) !== FALSE) {
                     if (isset($data[0])) {
                                $mobile_number_arr[] = $data[0];


                      }
                 }
              }
          }

          $count_mobile_no=count($mobile_number_arr);

          if($count_mobile_no>0)
          {
              for($j=0;$j<count($mobile_number_arr);$j++)
              {

                $mobile="+91".$mobile_number_arr[$j];
                $sql_select = "SELECT * from az_blocknumbers where (userid='$userid'|| userid='-1') and numbers='$mobile'";
                $query_select = mysqli_query($dbc, $sql_select);
                $count_numbers=mysqli_num_rows($query_select);
                $date=date("Y-m-d H:i:s");
                if($count_numbers==0)
                {

                  if($status==0)
                  {
                     $sql = "INSERT INTO `az_blocknumbers`(userid,numbers,status,added_date) VALUES ('" . $userid . "','" . $mobile . "','" . $status . "','" . $date . "')";


                    $query = mysqli_query($dbc, $sql)or die(mysqli_error($dbc));
                   /* if ($query) {
                        unset($_POST);
                        return 1;
                    } else {
                        return 0;
                    }*/
                  }
                  else
                  {
                   $sql = "INSERT INTO `az_blocknumbers`(userid,numbers,status,added_date) VALUES ('" . $userid . "','" . $mobile . "','" . $status . "','" . $date . "')";


                    $query = mysqli_query($dbc, $sql);
                   /* if ($query) {
                        unset($_POST);
                        return 1;
                    } else {
                        return 0;
                    }*///number not available to mark it as whitelist
                  }
                } 
                else
                {
                   $sql = "update `az_blocknumbers` set status='" . $status . "',added_date='$date' where numbers='$mobile' and userid='$userid'";


                    $query = mysqli_query($dbc, $sql);
                   /* if ($query) {
                        unset($_POST);
                        return 1;
                    } else {
                        return 0;
                    }*/
                }
              }

              

              if ($query) {
                        unset($_POST);
                        return 1;
                    } else {
                        return 0;
                    }

          }

              if ($query) {
                        unset($_POST);
                        return 1;
                    } else {
                        return 0;
                    }

          /*multiple ends here*/
        }
        else
        {
          $mobile= "+91".$_POST['mobile_number'];

                  $sql_select = "SELECT * from az_blocknumbers where (userid='$userid'|| userid='-1') and numbers='$mobile'";
                $query_select = mysqli_query($dbc, $sql_select);
                $count_numbers=mysqli_num_rows($query_select);
                $date=date("Y-m-d H:i:s");
                if($count_numbers==0)
                {

                  if($status==0)
                  {
                     $sql = "INSERT INTO `az_blocknumbers`(userid,numbers,status,added_date) VALUES ('" . $userid . "','" . $mobile . "','" . $status . "','" . $date . "')";


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
                   $sql = "INSERT INTO `az_blocknumbers`(userid,numbers,status,added_date) VALUES ('" . $userid . "','" . $mobile . "','" . $status . "','" . $date . "')";


                    $query = mysqli_query($dbc, $sql);
                    if ($query) {
                        unset($_POST);
                        return 1;
                    } else {
                        return 0;
                    }//number not available to mark it as whitelist
                  }


                } 
                else
                {
                   $sql = "update `az_blocknumbers` set status='" . $status . "',added_date='$date' where numbers='$mobile' and userid='$userid'";


                    $query = mysqli_query($dbc, $sql);
                    if ($query) {
                        unset($_POST);
                        return 1;
                    } else {
                        return 0;
                    }



                }
        }

       


       

}

