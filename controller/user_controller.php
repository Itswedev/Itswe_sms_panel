<?php
session_start();
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
// error_reporting(0);
$log_file = "../error/logfiles/user_controller.log";
 
 error_reporting(E_ALL); 
 
// setting error logging to be active
ini_set("log_errors", TRUE); 
  
// setting the logging file in php.ini
ini_set('error_log', $log_file);
include('../include/connection.php');
require('classes/ssp.class.php');
include('../include/config.php');
//include_once('../include/datatable_dbconnection.php');
include('classes/last_activities.php');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
if(isset($_REQUEST['list_type']))
{
    $list_type=$_REQUEST['list_type'];


    if($list_type=='dropdown_user')
    {
     
            $result = viewusername();

            $return_username=username_dropdown($result);

            echo $return_username;
    }
    else if($list_type=='only_user')
    {
           $result = viewusername_only();

            $return_username=username_dropdown($result);

            echo $return_username;
    }
    else if($list_type=='dropdown_user_search')
    {
           $result = viewusername_search();

           echo json_encode($result);
          // $result = viewusername();
          //    $return_username=username_dropdown($result);

          //    echo $return_username;
    }
    else if($list_type=='archive_dropdown_user')
    {
           $result = viewarchiveusername();

            $return_username=username_dropdown($result);

            echo $return_username;
    }
    else if($list_type=='user_summary')
    {

          $u_id=$_REQUEST['u_id'];
          $result = getUserSummary($u_id);
          echo $result;
    }
     else if($list_type=='load_userslist')
    {
         $role=$_REQUEST['role'];
          $result = getUsersList($role);
          echo trim($result);
    }
        else if($list_type=='load_resellerslist')
    {

          $result = getResellersList();
          echo $result;
    }
   else if($list_type=='save_new_user')
    {

      //echo "Ok ";
      // ini_set('display_errors', 1);
      // ini_set('display_startup_errors', 1);
      // error_reporting(E_ALL);
        $rs = saveUser();

        //echo "test controller";
        echo $rs;
     
           
    }
     else if($list_type=='load_cutoff_dtls')
    {

      //echo "Ok ";
        $rs = load_cutoff_dtls();
        echo $rs;
    }
    else if ($list_type=='delete_cutoff') {

   $rs=delete_cut_off_dtls();

    if($rs==1)
    {
          
      echo 1;

    }
    else
    {
      echo 0;
    }
}
  else if($list_type=='delete_acct_manager')
  {
    $rs=delete_acct_manager();

    if($rs==1)
    {
      echo 1;
    }
    else
    {
      echo 0;
    }

           
  }
  else if($list_type=='load_acct_manager')
    {

      $table = 'account_manager';

      $primaryKey = 'userid';

      $columns = array(
         array( 'db' => 'parent_id','dt' => 0,'formatter' => function( $d, $row ) {

          $parent_username=fetch_user($d);
          return $parent_username;
         }),
         
          array( 'db' => 'user_name','dt' => 1),
          array( 'db' => 'mobile_no','dt' => 2 ),
          array( 'db' => 'email_id','dt' => 3),
            array( 'db' => 'user_status','dt' => 4,'formatter' => function( $d, $row ) {
              if($d==1)
            {
              $stat="Active";
            }
            else
            {
              $stat="Inactive";
            }

            return $stat;
            
            } ),
          array( 'db' => 'userid','dt' =>5,'formatter' => function( $d, $row ) {
            if($row[4]=='1')
            {
              $btn_class="inactive_user_btn";
              $btn_val="Inactive";
            }else
            {
              $btn_class="active_user_btn";
              $btn_val="Active";
            }

            $user_name=$row[1];
            $mobile_no=$row[2];
            $fname=fetch_acct_manager_name($d);
            $email_id=$row[3];
            $status=$row[4];
          
            
              $action="<button class='btn btn-primary btn-sm me-1 mb-1 edit_acct_manager_btn' type='button' data-bs-toggle='modal' data-bs-target='#editacctmanagerModel' data-id='".$d."' data-user_name='".$user_name."' data-mobile_no='".$mobile_no."'
              data-email_id='".$email_id."'
              data-status='".$status."' data-fname='".$fname."'>
             
                  <span class='fas fa-edit ms-1' data-fa-transform='shrink-3'></span>
                </button>&nbsp;
                <button class='btn btn-primary btn-sm me-1 mb-1 delete_acct_manager_btn' type='button'  data-id='".$d."'>
                  <span class='fas fa-trash ms-1' data-fa-transform='shrink-3'></span>
                </button>";
                  return $action;
              })
         
      );
       
      // SQL server connection information
       global $sql_details ;

      $extraWhere="";

      $userid=$_SESSION['user_id'];
      if($userid!='1')
      {
        if($extraWhere!="")
        {
          $extraWhere=" and parent_id='$userid'";
        }
        else
        {
          $extraWhere=" parent_id='$userid'";
        }
      }

      echo json_encode(
          SSP::complex( $_REQUEST, $sql_details, $table, $primaryKey, $columns,$test=null,$extraWhere )
      );
           
    }
    else if($list_type=='save_acct_manager')
    {

      //echo "Ok ";
        $rs = saveAcctManager();
        echo $rs;
     
           
    }
    else if($list_type=='update_acct_manager')
    {

      //echo "Ok ";
        $rs = updateAcctManager();
        echo $rs;
     
           
    }
     else if($list_type=='load_basic_dtls')
    {

      //echo "Ok ";
        $rs = load_profile_dtls();
         echo json_encode($rs);
      
     
           
    }
     else if($list_type=='update_user')
    {

      //echo "Ok ";
        $rs = updateUser();
        
        if($rs=='1')
        {
          echo "User Details Updated successfully";
        }
        else if($rs=='0')
        {
        echo "Failed to Update user details";
        }
        
           
    }
         else if($list_type=='update_user_profile')
    {

      //echo "Ok ";
        $rs = updateUserProfile();
        
        if($rs=='1')
        {
          echo "User Profile Updated successfully";
        }
        else if($rs=='0')
        {
        echo "Failed to Update user profile";
        }
        
           
    }
    else if($list_type=='update_plan')
    {

      //echo "Ok ";
       $rs = updatePlan();
        
        if($rs=='1')
        {
          echo "Plan Details Updated successfully";
        }
        else if($rs=='0')
        {
        echo "Failed to Update plan details";
        }
        
           
    }
   else if($list_type=='update_access')
    {

        $access_name=$_REQUEST['access_name'];
        $val=$_REQUEST['val'];
        $userid=$_REQUEST['userid'];
        $rs = updateAccess($access_name,$val,$userid);
        
        if($rs=='1')
        {
          echo "Access Details Updated successfully";
        }
        else if($rs=='0')
        {
        echo "Failed to Update Access details";
        }
        
           
    }
    else if($list_type=='update_rcs_rate')
    {

        $text_rate=$_REQUEST['text_rate'];
        $rich_card_rate=$_REQUEST['rich_card_rate'];
        $a2p_rate=$_REQUEST['a2p_rate'];
        $p2a_rate=$_REQUEST['p2a_rate'];
        
        $userid=$_REQUEST['userid'];
        
        $rs = updateRCS_rate($text_rate,$rich_card_rate,$a2p_rate,$p2a_rate,$userid);
        
        if($rs=='1')
        {
          echo "success";
        }
        else if($rs=='0')
        {
        echo "Failed to Update RCS Rate details";
        }
        
           
    }
    else if($list_type=='cut_off_module')
    {

        
        echo $rs = updateCutOff();
        
       /* if($rs=='1')
        {
          echo "Cut Off Details Added successfully";
        }
        else if($rs=='0')
        {
        echo "Failed to add Cut Off details";
        }
         else if($rs=='2')
        {
        echo "Cut Off details already exists";
        }
        */
           
    }
        else if($list_type=='edit_cut_off_module')
    {

        
        echo $rs = editCutOff();
      
           
    }
    else if ($list_type=='check_role') {

     $rs = check_user_role();
     echo $rs;
   

      // code...
    }
    else if ($list_type=='update_profile_pic') {

     $rs = update_profile_pic();
     echo $rs;
   

      // code...
    }
    else if($list_type=='role_dropdown')
    {
          $userid=$_SESSION['user_id'];
          $edit_userid=$_SESSION['edit_userid'];

          $user_role=$_SESSION['user_role'];
           /* if($userid==1 && $edit_userid!=1)
            {
              $roles=['mds_usr','mds_rs','mds_ad','mds_su_ad','mds_adm'];
            }*/
          if($userid==1 && $edit_userid==1)
            {
              $roles=['mds_adm'];
            }
            else
            {
               if($user_role=='mds_rs')
                {
                 // $roles=['mds_sub_usr','mds_usr','mds_rs'];

                   $roles=['mds_usr','mds_rs','mds_sub_usr'];
                }
                else if($user_role=='mds_usr')
                {
                  $roles=['mds_sub_usr'];
                }
                else if($user_role=='mds_ad')
                {
                  //$roles=['mds_sub_usr','mds_usr','mds_rs'];

                  $roles=['mds_usr','mds_rs','mds_sub_usr'];
                }
                else if($user_role=='mds_su_ad')
                {
                 // $roles=['mds_sub_usr','mds_usr','mds_rs','mds_ad'];
                  $roles=['mds_usr','mds_rs','mds_ad','mds_sub_usr'];
                }
                else if($user_role=='mds_adm')
                {
                 // $roles=['mds_sub_usr','mds_usr','mds_rs','mds_ad','mds_su_ad'];
                   $roles=['mds_usr','mds_rs','mds_ad','mds_su_ad'];
                }
            }
           

             
            $option="<option value=''>Select Role</option>";

            foreach($roles as $role)
            {

              
             $val = password_hash($role,PASSWORD_DEFAULT);
             if($role=="mds_usr")
             {
                $option.="<option value='$val' data-name='User'>User</option>";
             }
              else if($role=="mds_sub_usr")
             {
               $option.="<option value='$val' data-name='Sub User'>Sub User</option>";
             }
             else if($role=="mds_rs")
             {
               $option.="<option value='$val' data-name='Reseller'>Reseller</option>";
             }
             else if($role=="mds_acc")
             {
               $option.="<option value='$val' data-name='Account Manager'>Account Manager</option>";
             }
             else if($role=="mds_ad")
             {
               $option.="<option value='$val' data-name='Admin'>Admin</option>";
             }
             else if($role=="mds_su_ad")
             {
               $option.="<option value='$val' data-name='Super Admin'>Super Admin</option>"; 
             }
             else if($role=="mds_adm")
             {
               $option.="<option value='$val' data-name='Administrator'>Administrator</option>";
             }



            }
          

            echo $option;
    }
}

function load_profile_dtls()
{
  global $dbc;
  $userid=$_SESSION['user_id'];
  $sql="select * from az_user where userid='$userid'";
  $result=mysqli_query($dbc,$sql);

  while($row=mysqli_fetch_array($result))
  {
    $record=$row;
  }

  return $record;

}

 function delete_cut_off_dtls() {
        global $dbc;
        $cut_off_id=$_REQUEST['cut_off_id'];
        
        $sql_select = "select `userid`,`cut_off_route` from cut_off_dtls where id='".$cut_off_id."'";
        $result_parent = mysqli_query($dbc, $sql_select);

        while($row_cut_off_userid=mysqli_fetch_array($result_parent))
        {
            $parent_id=$row_cut_off_userid['userid'];
            $route_id=$row_cut_off_userid['cut_off_route'];
        }

        $sql = "delete from cut_off_dtls where id='".$cut_off_id."'";
        $result = mysqli_query($dbc, $sql);
        if($result)
        {

                     $userid_arr[]=$parent_id;
                     $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }
                    //print_r($single_arr);
                      if(!empty($single_arr))
                      {
                          foreach($single_arr as $cut_off_userid)
                          {
                            $sql = "delete from cut_off_dtls where userid='".$cut_off_userid."' and cut_off_route='$route_id'";
                            $result = mysqli_query($dbc, $sql);
                          }
                      }

          return 1;
        }
        else
        {
          return 0;
        }
        
    }

function fetch_acct_manager_name($userid)
{
  global $dbc;
  
  $sql="select * from account_manager where userid='$userid'";
  $result=mysqli_query($dbc,$sql);

  while($row=mysqli_fetch_array($result))
  {
    $fname=$row['client_name'];
  }

  return $fname;

}
function check_user_role()
{
      
       $role=trim($_POST['role']);

        if(password_verify('mds_acc', $role))
        {
            $role_select="mds_acc";
        }
        else if(password_verify('mds_sub_usr', $role))
        {
            $role_select="mds_sub_usr";
        }
       else
       {
          $role_select="other";
       }

       return $role_select;
}

function update_profile_pic()
{
  global $dbc;
    $userid=$_SESSION['user_id'];
    $fname = explode('.', $_FILES['profile_pic_select']['name']);
    $filename=$_FILES['profile_pic_select']['name'];
    $extension = strtolower(end($fname));    
      if($extension=='png' || $extension=='jpg' || $extension=='jpeg' || $extension=='gif')
      {
          
          if(!file_exists("../assets/images/profile/$filename"))
          {
          // echo $_FILES['profile_pic_select']['tmp_name']; 
                      $res=move_uploaded_file($_FILES['profile_pic_select']['tmp_name'], '../assets/images/profile/' . $_FILES['profile_pic_select']['name']);
                      echo $res;
                      if($res==1)
                      {
                         $sql="update az_user set profile_pic='$filename' where `userid`='$userid'";
                          $result=mysqli_query($dbc,$sql);
                          if($result)
                          {
                            $_SESSION['profile_pic']=$filename;
                              echo "success";
                          }
                      }
                      else
                      {
                          echo "Unable to upload profile image";
                      }
          }
          else
          { 
              echo "File already exists";
          }

     }
     else
     {
      echo "Please upload only jpeg,jpg,gif,png file";
     }

}


function updateUser()
{
        global $dbc;
       /* $gateway_family = ucwords(trim($_POST['gateway_family']));*/
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

         
        $email = trim($_POST['email']);
        $mobile = trim($_POST['mobile']);

        $city = trim($_POST['city']);
        $pincode = trim($_POST['pincode']);
        $company_name = trim($_POST['company_name']);
        $f_name = trim($_POST['f_name']);

        $role = trim($_POST['role']);


        if(password_verify('mds_usr', $role))
        {
            $role_insert="mds_usr";
        }
       /*  if(password_verify('mds_sub_usr', $role))
        {
            $role_insert="mds_sub_usr";
        }*/
        else if(password_verify('mds_su_ad', $role))
        {
          $role_insert="mds_su_ad";
        }
         else if(password_verify('mds_rs', $role))
        {
            $role_insert="mds_rs";
        }
         else if(password_verify('mds_acc', $role))
        {
          $role_insert="mds_acc";
        }
         else if(password_verify('mds_ad', $role))
        {
          $role_insert="mds_ad";
        }
         else if(password_verify('mds_adm', $role))
        {
          $role_insert="mds_adm";
        }
        

        $routes = $_POST['route'];
        // $route_numbers = array_map('intval', $route);
        // $routes=implode(",", $route_numbers);

        // echo $route;
        // die();
        $userid=$_SESSION['edit_userid'];
        $acct_manager=$_POST['acct_manager'];
        $time=time();
        $api_key = trim($_POST['api_key']);
        if($password!='')
        {
          $password = password_hash($password,PASSWORD_DEFAULT);

           $sql = "update `az_user` set `user_role`='$role_insert',`user_name`='".$username."',`user_psw`='".$password."',`mobile_no`='".$mobile."',`email_id`='".$email."',`city`='".$city."',`client_name`='".$f_name."',`company_name`='".$company_name."',`pincode`='".$pincode."',`route_ids`='$routes',`updated_at`=$time,`api_key`='$api_key',acct_manager='$acct_manager' where userid='".$userid."'";
        }
        else
        {
           $sql = "update `az_user` set `user_role`='$role_insert',`user_name`='".$username."',`mobile_no`='".$mobile."',`email_id`='".$email."',`city`='".$city."',`client_name`='".$f_name."',`company_name`='".$company_name."',`pincode`='".$pincode."',`route_ids`='$routes',`updated_at`=$time,`api_key`='$api_key',acct_manager='$acct_manager' where userid='".$userid."'";
        }
       


      $query=mysqli_query($dbc,$sql);
          if ($query) {
              unset($_POST);
              return '1';
          } else {
              return '0';
          }
      
      

}

function updateUserProfile()
{
        global $dbc;
     
         
        $email = trim($_POST['email']);
        $mobile = trim($_POST['mobile']);

        $city = trim($_POST['city']);
        $pincode = trim($_POST['pincode']);
        $company_name = trim($_POST['company_name']);
        $f_name = trim($_POST['f_name']);

        

     
        $userid=$_SESSION['user_id'];
        $time=time();

           $sql = "update `az_user` set `mobile_no`='".$mobile."',`email_id`='".$email."',`city`='".$city."',`client_name`='".$f_name."',`company_name`='".$company_name."',`pincode`='".$pincode."',`updated_at`=$time where userid='".$userid."'";
        


      $query=mysqli_query($dbc,$sql);
          if ($query) {
              unset($_POST);
              return '1';
          } else {
              return '0';
          }
      
      

}


function updatePlan()
{
        global $dbc;

        $plan = trim($_POST['plan']);
        $userid=$_SESSION['edit_userid'];
        $sql_user="select * from az_user where userid='$userid'";
        $result_user=mysqli_query($dbc,$sql_user);
        $row_user=mysqli_fetch_array($result_user);
        $user_role=$row_user['user_role'];
        if($user_role=='mds_usr')
        {
              $sql="select * from az_plan_assign where userid='".$userid."'";
              $result=mysqli_query($dbc,$sql);
              $count_user=mysqli_num_rows($result);
              if($count_user>0)
              {
                 $sql = "update `az_plan_assign` set `pid`='$plan' where userid='".$userid."'";
              }
              else
              {
                 $sql = "insert into `az_plan_assign`(`userid`,`pid`,`status`) value('".$userid."','".$plan."','1')";
              }
             
              $query=mysqli_query($dbc,$sql);
                if ($query) {
                    unset($_POST);
                    return '1';
                } else {
                    return '0';
                }
        }
        else
        {
              $sql="select * from az_plan_assign where userid='".$userid."'";
              $result=mysqli_query($dbc,$sql);
              $count_user=mysqli_num_rows($result);
              if($count_user>0)
              {
                 $sql = "update `az_plan_assign` set `pid`='$plan' where userid='".$userid."'";
              }
              else
              {
                 $sql = "insert into `az_plan_assign`(`userid`,`pid`,`status`) value('".$userid."','".$plan."','1')";
              }
             
              $query=mysqli_query($dbc,$sql);
                if ($query) {

                    $userid_arr[]=$userid;
                     $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }
                     // print_r($single_arr);
                      if(!empty($single_arr))
                      {
                          $child_userids=implode(",", $single_arr);
                          $sql_update_child_plan="update `az_plan_assign` set `pid`='$plan' where userid in ($child_userids)";
                          mysqli_query($dbc,$sql_update_child_plan)or die(mysqli_error($dbc));
                      }

                    //$child_users=get_childUsers($userid);


                    unset($_POST);
                    return '1';
                } else {
                    return '0';
                }
        }

       
      
      

}

/*
function get_childUsers($userid)
{
  global $dbc;
  static $ids = array();
  
   
        $qry = "SELECT userid FROM az_user WHERE parent_id = '{$userid}'";
        $rs = mysqli_query($dbc, $qry);
        if(mysqli_num_rows($rs)>0) {
          while($row = mysqli_fetch_array($rs))
          {

            $ids[] = $row['userid'];
            if($row['userid'] == 1 ) {
              return $ids;
            }
            else
            {
            if(!empty($ids)) {
              return get_childUsers($row['userid']);
            }else {

              if($userid == $row['userid']) {
                $ids[] = $rows['userid'];
                return get_childUsers($row['userid']);
              }
            }
          }
        }
          
        }
        else {
      return $ids;
    }
    

    
    

}
*/

function load_cutoff_dtls()
{
  global $dbc;
 $edit_userid=$_SESSION['edit_userid'];
 $sql="select * from cut_off_dtls where userid='".$edit_userid."'";
  $rs = mysqli_query($dbc, $sql);
  if(mysqli_num_rows($rs)>0) {
    $i=1;
    while($row=mysqli_fetch_array($rs))
    {
        $routeid=$row['cut_off_route'];
        $route_name=fetch_route_name($routeid);
        $cut_off_status=$row['cut_off_status'];
        $c_throughput=$row['throughput'];
        $min_cut_value=$row['min_cut_value'];
        $cut_off_id=$row['id'];


         $action="<button class='btn btn-primary btn-sm me-1 mb-1 edit_cut_off_btn' type='button' data-bs-toggle='modal' data-bs-target='#editcutoffModel' data-cut_off_id='".$cut_off_id."' data-routeid='".$routeid."' data-cut_off_status='".$cut_off_status."'
              data-c_throughput='".$c_throughput."'
              data-min_cut_value='".$min_cut_value."' >
             
              <i class='fa fa-pencil'></i>
                </button>&nbsp;
                <button class='btn btn-primary btn-sm me-1 mb-1 delete_cut_off_btn' type='button'  data-cut_off_id='".$cut_off_id."'>
                <i class='fa fa-trash'></i>
                </button>";


        $tbl_data.="<tr>
                  <td>$i</td>
                  <td>$route_name</td>
                  <td>$cut_off_status</td>
                  <td>$c_throughput</td>
                  <td>$min_cut_value</td>
                  <td>$action</td>

                  </tr>";
        $i++;
    }

    return $tbl_data;
  }
  else
  {
    return "<tr><td colspan='6'>No records available</td></tr>";
  }

}



function get_childUsers($userid)
{
  global $dbc;
  $ids = array();
  static $child=array();
  $userids=implode(",", $userid);
   
       $qry = "SELECT userid FROM az_user WHERE parent_id in ($userids)";
        $rs = mysqli_query($dbc, $qry);
        if(mysqli_num_rows($rs)>0) {
          while($row = mysqli_fetch_array($rs))
          {
            //echo $row['userid'];
            $ids[] = $row['userid'];
            if($row['userid'] == 1 ) {
               $child[]=$ids;
              return $child;
            }
          }

          if(!empty($ids)) {
            $child[]=$ids;
              return get_childUsers($ids);
              }
          //return $ids;
          
        }
        else {
      return $child;
    }
}


function updateAccess($access_name,$val,$userid)
{
      global $dbc;
      $sql = "update `az_user` set `$access_name`='$val' where userid='".$userid."'";
      $query=mysqli_query($dbc,$sql);
          if ($query) {
              unset($_POST);
              return '1';
          } else {
              return '0';
          }
      
      

}


function updateRCS_rate($text_rate,$rich_card_rate,$a2p_rate,$p2a_rate,$userid)
{
      global $dbc;
      $sql = "update `settings` set `rcs_sms_rate`='$text_rate',`rcs_rich_card_rate`='$rich_card_rate',`a2p_rate`='$a2p_rate',`p2a_rate`='$p2a_rate' where userid='".$userid."'";
      $query=mysqli_query($dbc,$sql);
          if ($query) {
              unset($_POST);
              return '1';
          } else {
              return '0';
          }
      
      

}

function updateCutOff()
{
      global $dbc;
      $route_cutoff=$_REQUEST['route_cutoff'];
        
        $cut_off_status=$_REQUEST['cut_off_status'];

        if($cut_off_status=='Delivered')
        {
          $err='000';

        }
        else if($cut_off_status=='Failed')
        {
          $err='045';
        }
        else
        {
          $err='';
        }
        $c_throughput=$_REQUEST['c_throughput'];
        $c_min_val=$_REQUEST['c_min_val'];
        $userid=$_SESSION['edit_userid'];


        $sql="select * from cut_off_dtls where userid='$userid' and cut_off_route='".$route_cutoff."'";
        $query=mysqli_query($dbc,$sql);
        $count=mysqli_num_rows($query);
        if($count>0)
        {
          return 2;
         
        }
        else
        {
         $sql_insert = "INSERT INTO `cut_off_dtls`(`cut_off_route`,`cut_off_status`,`throughput`,`min_cut_value`,`userid`,`error_code`) values('".$route_cutoff."','".$cut_off_status."','".$c_throughput."','".$c_min_val."','".$userid."','".$err."')";

          $query_insert=mysqli_query($dbc,$sql_insert);
              if ($query_insert) {


                     $userid_arr[]=$userid;
                     $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }
                    //print_r($single_arr);
                      if(!empty($single_arr))
                      {
                          foreach($single_arr as $cut_off_userid)
                          {
                              $sql_select_cutoff="select * from cut_off_dtls where userid='".$cut_off_userid."' and cut_off_route='".$route_cutoff."'";
                              $rs_select_cutoff=mysqli_query($dbc,$sql_select_cutoff);
                             $count_cutoff=mysqli_num_rows($rs_select_cutoff);
                            
                              if($count_cutoff>0)
                              {
                                  $sql_update_child_cutoff="update `cut_off_dtls` set `cut_off_status`='$cut_off_status',throughput='$c_throughput',min_cut_value='$c_min_val',error_code='$err' where userid='".$cut_off_userid."' and cut_off_route='".$route_cutoff."'";
                                   mysqli_query($dbc,$sql_update_child_cutoff)or die(mysqli_error($dbc));
                              }
                              else
                              {
                                  $sql_insert_child_cutoff = "INSERT INTO `cut_off_dtls`(`cut_off_route`,`cut_off_status`,`throughput`,`min_cut_value`,`userid`,`error_code`) values('".$route_cutoff."','".$cut_off_status."','".$c_throughput."','".$c_min_val."','".$cut_off_userid."','".$err."')";
                                  $query_insert_child_cutoff=mysqli_query($dbc,$sql_insert_child_cutoff);

                              }
                          }


                         
                      }


                  unset($_POST);
                  return '1';
              } else {
                  return '0';
              }
        }

}
function editCutOff()
{
      global $dbc;
      $route_cutoff=$_REQUEST['edit_route_cutoff'];
        $old_route=$_REQUEST['old_route'];
        $cut_off_status=$_REQUEST['edit_cut_off_status'];

        if($cut_off_status=='Delivered')
        {
          $err='000';

        }
        else if($cut_off_status=='Failed')
        {
          $err='045';
        }
        else
        {
          $err='';
        }
        $c_throughput=$_REQUEST['edit_c_throughput'];
        $c_min_val=$_REQUEST['edit_c_min_val'];
        $edit_cut_off_id=$_REQUEST['edit_cut_off_id'];
        $userid=$_SESSION['edit_userid'];
    
         $sql_update = "UPDATE `cut_off_dtls` SET `cut_off_route`='".$route_cutoff."',`cut_off_status`='".$cut_off_status."',`throughput`='".$c_throughput."',`min_cut_value`='".$c_min_val."',`error_code`='$err' where id='$edit_cut_off_id' and cut_off_route='".$old_route."'";
        $query_update=mysqli_query($dbc,$sql_update);
              if ($query_update) {

                  $userid_arr[]=$userid;
                  $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }
                     
                      if(!empty($single_arr))
                      {
                          foreach($single_arr as $cut_off_userid)
                          {
                             $sql_select_cutoff="select * from cut_off_dtls where userid='".$cut_off_userid."' and cut_off_route='".$old_route."'";
                              $rs_select_cutoff=mysqli_query($dbc,$sql_select_cutoff);
                             $count_cutoff=mysqli_num_rows($rs_select_cutoff);
                              if($count_cutoff>0)
                              {
                                 $sql_update_child_cutoff="update `cut_off_dtls` set `cut_off_status`='$cut_off_status',throughput='$c_throughput',min_cut_value='$c_min_val',`error_code`='$err' where userid='".$cut_off_userid."' and cut_off_route='".$old_route."'";
                                   mysqli_query($dbc,$sql_update_child_cutoff)or die(mysqli_error($dbc));
                              }
                              else
                              {
                                  $sql_insert_child_cutoff = "INSERT INTO `cut_off_dtls`(`cut_off_route`,`cut_off_status`,`throughput`,`min_cut_value`,`userid`,`error_code`) values('".$route_cutoff."','".$cut_off_status."','".$c_throughput."','".$c_min_val."','".$cut_off_userid."','".$err."')";
                                  $query_insert_child_cutoff=mysqli_query($dbc,$sql_insert_child_cutoff);

                              }
                          }


                         
                      }

                  unset($_POST);
                  return '1';
              } else {
                  return '0';
              }
        
}

function saveUser()
{
        global $dbc;
       


       /* $gateway_family = ucwords(trim($_POST['gateway_family']));*/
         $username = trim($_POST['username']);
         $password = trim($_POST['password']);
         $password = password_hash($password,PASSWORD_DEFAULT);
         $email = trim($_POST['email']);
         $mobile = trim($_POST['mobile']);

         $city = trim($_POST['city']);
         $pincode = trim($_POST['pincode']);
         $company_name = trim($_POST['company_name']);
         $f_name = trim($_POST['f_name']);

         $role = trim($_POST['role']);
         $api_key = trim($_POST['api_key']);
          $acct_manager = trim($_POST['acct_manager']);

        if(password_verify('mds_usr', $role))
        {
            $role_insert="mds_usr";
        }
        else if(password_verify('mds_sub_usr', $role))
        {
            $role_insert="mds_sub_usr";
        }
        else if(password_verify('mds_su_ad', $role))
        {
          $role_insert="mds_su_ad";
        }
         else if(password_verify('mds_rs', $role))
        {
            $role_insert="mds_rs";
        }
         else if(password_verify('mds_acc', $role))
        {
          $role_insert="mds_acc";
        }
         else if(password_verify('mds_ad', $role))
        {
          $role_insert="mds_ad";
        }
         else if(password_verify('mds_adm', $role))
        {
          $role_insert="mds_adm";
        }
        if($role_insert=='mds_acc')
        {
          $acct_manager="";
        }

        

        $routes = $_POST['route'];
        //$routes=implode(",", $route);
        $sql_select="select * from az_user where user_name='".$username."'";
        $query_select=mysqli_query($dbc,$sql_select);

        $user_count=mysqli_num_rows($query_select);

        if($user_count==0)
        {
           $sql = "INSERT INTO `az_user`(`user_role`,`user_name`,`user_psw`,`mobile_no`,`email_id`,`city`,`client_name`,`company_name`,`pincode`,`parent_id`,`route_ids`,`created`,`api_key`,`acct_manager`) VALUES('".$role_insert."','".$username."','".$password."','".$mobile."','".$email."','".$city."','".$f_name."','".$company_name."','".$pincode."','".$_SESSION['user_id']."','$routes',now(),'".$api_key."','".$acct_manager."')";


          $query=mysqli_query($dbc,$sql);
          if ($query) {

             $new_userid=mysqli_insert_id($dbc);

             $parent_id=$_SESSION['user_id'];

             $sql_parent_plan="select pid from az_plan_assign where userid='$parent_id'";
             $rs_parent_plan=mysqli_query($dbc,$sql_parent_plan);
             while($row_parent_plan=mysqli_fetch_array($rs_parent_plan))
             {
                $pid=$row_parent_plan['pid'];
             }
           

             if($role_insert=='mds_sub_usr')
             {
                $services_arr=$_REQUEST['services'];
                 $services=implode(",",$services_arr);

                $user_tree_arr=$_REQUEST['node_ids'];
                $user_tree=implode(",",$user_tree_arr);
                $sql_insert_settings = "INSERT INTO `settings`(`userid`,`services`,`user_tree`) values('".$new_userid."','".$services."','".$user_tree."')";
             }
             else
             {
              $sql_insert_settings = "INSERT INTO `settings`(`userid`) values('".$new_userid."')";
             }

             


             //$sql_insert_settings = "INSERT INTO `settings`(`userid`) values('".$new_userid."')";

             $query_settings=mysqli_query($dbc,$sql_insert_settings);


             if($pid!='')
             {
                  $sql_assign_plan = "INSERT INTO `az_plan_assign`(`userid`,`pid`,`status`) values('".$new_userid."','$pid','1')";

             $query_plan=mysqli_query($dbc,$sql_assign_plan);

             }
             else
             {
                  $sql_assign_plan = "INSERT INTO `az_plan_assign`(`userid`,`pid`,`status`) values('".$new_userid."','1','1')";

             $query_plan=mysqli_query($dbc,$sql_assign_plan);

             }


            $sql_parent_cutoff="select * from cut_off_dtls where userid='$parent_id'";
            $rs_parent_cutoff=mysqli_query($dbc,$sql_parent_cutoff);
            $count_parent_cutoff=mysqli_num_rows($rs_parent_cutoff);

            if($count_parent_cutoff>0)
            {
               while($row_parent_cutoff=mysqli_fetch_array($rs_parent_cutoff))
               {

                   $cut_off_route=$row_parent_cutoff['cut_off_route'];
                   $cutting_apply=$row_parent_cutoff['cutting_apply'];
                   $cut_off_status=$row_parent_cutoff['cut_off_status'];
                   $throughput=$row_parent_cutoff['throughput'];
                   $min_cut_value=$row_parent_cutoff['min_cut_value'];
                   $error_code=$row_parent_cutoff['error_code'];   
                   $sql_add_cutoff = "INSERT INTO `cut_off_dtls`(`userid`,`cut_off_route`,`cutting_apply`,`cut_off_status`,`throughput`,`min_cut_value`,`error_code`) values('".$new_userid."','$cut_off_route','$cutting_apply','$cut_off_status','$throughput','$min_cut_value','$error_code')";

                   $query_cutoff=mysqli_query($dbc,$sql_add_cutoff);


               }
            }

            
              unset($_POST);
              return 1;
          } else {
              return 0;
          }
        }
        else
        {
          return 2;
        }

         
        
    /*   
        
        
  
     $sql = "INSERT INTO `az_user`(`user_role`,`user_name`,`user_psw`,`mobile_no`,`email_id`,`city`,`client_name`,`company_name`,`pincode`) VALUES('".$role."','".$username."','".$password."','".$mobile."','".$email."','".$city."','".$f_name."','".$company_name."','".$pincode."'");
          if ($query) {
              unset($_POST);
              return '1';
          } else {
              return '0';
          }
        */
       

}


function saveAcctManager()
{
        global $dbc;
       
         $username = trim($_POST['username']);
         $password = trim($_POST['password']);
         $password = password_hash($password,PASSWORD_DEFAULT);
         $email = trim($_POST['email']);
         $mobile = trim($_POST['mobile']);
         $f_name = trim($_POST['f_name']);
        
          $role_insert="mds_acc";
        $sql_select="select * from account_manager where user_name='".$username."'";
        $query_select=mysqli_query($dbc,$sql_select);

        $user_count=mysqli_num_rows($query_select);

        if($user_count==0)
        {
           $sql = "INSERT INTO `account_manager`(`user_role`,`user_name`,`user_psw`,`mobile_no`,`email_id`,`client_name`,`parent_id`,`created`) VALUES('".$role_insert."','".$username."','".$password."','".$mobile."','".$email."','".$f_name."','".$_SESSION['user_id']."',now())";

          $query=mysqli_query($dbc,$sql)or die(mysqli_error($dbc));
          if ($query) {

              unset($_POST);
              return 1;
          } else {
              return 0;
          }
        }
        else
        {
          return 2;
        }

     

}
function updateAcctManager()
{
        global $dbc;
          $acct_userid=trim($_POST['acct_manager_id']);
         $username = trim($_POST['edit_username']);
        
         $email = trim($_POST['edit_email']);
         $mobile = trim($_POST['edit_mobile']);
         $f_name = trim($_POST['edit_f_name']);
         $status = trim($_POST['edit_status']);
        
         
        $sql_select="select * from account_manager where user_name='".$username."' and userid!='$acct_userid'";
        $query_select=mysqli_query($dbc,$sql_select);

        $user_count=mysqli_num_rows($query_select);

        if($user_count==0)
        {
           $sql = "update `account_manager` set `user_name`='".$username."',`mobile_no`='".$mobile."',`email_id`='".$email."',`client_name`='".$f_name."',user_status='".$status."' where userid='".$acct_userid."'";

          $query=mysqli_query($dbc,$sql)or die(mysqli_error($dbc));
          if ($query) {

              unset($_POST);
              return 1;
          } else {
              return 0;
          }
        }
        else
        {
          return 2;
        }

     

}




function viewusername_search() {
  global $dbc;
  $userid=$_SESSION['user_id'];
  $selected_user_role=$_REQUEST['selected_user_role'];


  $extraCond="";
  if(isset($_REQUEST['page']) && $_REQUEST['page']=='add_credit')
  {
    $extraCond=" user_role!='mds_acc'";
  }

  $result = array();
  if($userid!='1')
  {
     if($selected_user_role!="")
      {
        $extraCond=" user_role='".$selected_user_role."'";
      }
      $sql = "SELECT userid,user_name  FROM az_user where parent_id='".$userid."' and user_status=1 and $extraCond ORDER BY user_name ASC";
  }
  else
  {
    if($extraCond!="")
    {
        $whereCond=" where user_status=1 and $extraCond";
    }
    else
    {
      $whereCond="where user_status=1";
    }
    $sql = "SELECT userid,user_name  FROM az_user $whereCond ORDER BY user_name ASC";
  }
 
  $values = mysqli_query($dbc, $sql);
  $senderArray = array();
  while ($row = mysqli_fetch_assoc($values)) {
      $userid = $row['userid'];
      $senderArray[] = array(
        'userid' => $userid,
        'user_name' => $row['user_name']
    );
      
      //$result[$userid] = $row;
  }

  return $senderArray;
}

  function viewusername() {
        global $dbc;
        $userid=$_SESSION['user_id'];
        $selected_user_role=$_REQUEST['selected_user_role'];


        $extraCond="";
        if(isset($_REQUEST['page']) && $_REQUEST['page']=='add_credit')
        {
          $extraCond=" user_role!='mds_acc'";
        }

        $result = array();
        if($userid!='1')
        {
           if($selected_user_role!="")
            {
              $extraCond=" user_role='".$selected_user_role."'";
            }
            $sql = "SELECT *  FROM az_user where parent_id='".$userid."' and user_status=1 and $extraCond ORDER BY user_name ASC";
        }
        else
        {
          if($extraCond!="")
          {
              $whereCond=" where user_status=1 and $extraCond";
          }
          else
          {
            $whereCond="where user_status=1";
          }
          $sql = "SELECT *  FROM az_user $whereCond ORDER BY user_name ASC";
        }
       
        $values = mysqli_query($dbc, $sql);
        while ($row = mysqli_fetch_assoc($values)) {
            $userid = $row['userid'];
            $result[$userid] = $row;
        }

        return $result;
    }


    function viewusername_only() {
      global $dbc;
      $userid=$_SESSION['user_id'];
      $selected_user_role=$_REQUEST['selected_user_role'];


      $extraCond="";
      

      $result = array();
      // if($userid!='1')
      // {
        //  if($selected_user_role!="")
        //   {
        //     $extraCond=" user_role='".$selected_user_role."'";
        //   }
          $sql = "SELECT userid,user_name  FROM az_user where user_role='mds_usr' and user_status=1 ORDER BY user_name ASC";
      // }
      // else
      // {
      //   if($extraCond!="")
      //   {
      //       $whereCond=" where user_status=1 and $extraCond";
      //   }
      //   else
      //   {
      //     $whereCond="where user_status=1";
      //   }
      //   $sql = "SELECT *  FROM az_user $whereCond ORDER BY user_name ASC";
      // }
     
      $values = mysqli_query($dbc, $sql);
      while ($row = mysqli_fetch_assoc($values)) {
          $userid = $row['userid'];
          $result[$userid] = $row;
      }

      return $result;
  }


      function viewarchiveusername() {
        global $dbc;
        $userid=$_SESSION['user_id'];
        $user_role=$_SESSION['user_role'];
        $extraCond="";
        if($user_role=='mds_adm')
        {
          $extraCond=" user_role='mds_usr'";
        }

        $result = array();
      
          if($extraCond!="")
          {
              $whereCond=" where $extraCond";
          }
          else
          {
            $whereCond="";
          }
          $sql = "SELECT userid,user_name  FROM az_user $whereCond ORDER BY created DESC";
        
       
        $values = mysqli_query($dbc, $sql);
        while ($row = mysqli_fetch_assoc($values)) {
            $userid = $row['userid'];
            $result[$userid] = $row;
        }
        return $result;
    }


function getUsersList($role) {
        global $dbc;
        $userid=$_SESSION['user_id'];
        $result = array();
        if($role=="Reseller")
        {
          $cond_role="mds_rs";
        }
        else if($role=="User")
        {
          $cond_role="mds_usr";
        }
   
         else if($role=="Admin")
        {
          $cond_role="mds_ad";
        }
        if($userid!='1')
        {
            $sql = "SELECT *  FROM az_user where user_role='$cond_role' and parent_id='$userid' and user_status=1 ORDER BY created DESC";
        }
        else
        {
           $sql = "SELECT *  FROM az_user where user_role='$cond_role' and user_status=1 ORDER BY created DESC";
        }
       
        $values = mysqli_query($dbc, $sql);
        $result="<option value=''>Select $role</option>
        <option value='All'>All</option>
        ";
        $count_user=mysqli_num_rows($values);
        if($count_user>0)
        {
          while ($row = mysqli_fetch_array($values)) {

              $result.="<option value='".$row['userid']."'>".$row['user_name']."</option>";
          }
        }


        
        return $result;
    }





function getResellersList() {
        global $dbc;
        $userid=$_SESSION['user_id'];
        $result = array();
       
        if($userid!='1')
        {
            $sql = "SELECT *  FROM az_user where  parent_id='$userid' and user_role='mds_rs' and user_status=1 ORDER BY created DESC";
        }
        else
        {
           $sql = "SELECT *  FROM az_user where user_role='mds_rs' and user_status=1 ORDER BY created DESC";
        }
       
        $values = mysqli_query($dbc, $sql);
        $result="<option value=''>Select Reseller</option>";
        $count_user=mysqli_num_rows($values);
        if($count_user>0)
        {
          while ($row = mysqli_fetch_array($values)) {

              $result.="<option value='".$row['userid']."'>".$row['user_name']."</option>";
          }
        }


        
        return $result;
    }


  function getUserSummary($u_id) {
        global $dbc;
        $result = array();
        $sendtabledetals = SENDSMSDETAILS . CURRENTMONTH;
     $sql = "select sum(msgcredit) as msgcredit,sum(if(status='Delivered',msgcredit,0))as DELIVRD,sum(if(status='submitted',msgcredit,0))as submitted,sum(if(status='Failed',msgcredit,0))as Failed,sum(if(status='Rejected',msgcredit,0))as Rejected,sum(if(status='DND',msgcredit,0))as DND,sum(if(status='Block',msgcredit,0))as Block,sum(if(status='Spam',msgcredit,0))as Spam,sum(if(status='Refund',msgcredit,0))as Refund,sum(if(status='Smart',msgcredit,0))as Smart from $sendtabledetals where userids='".$u_id."' group by status ";
        $values = mysqli_query($dbc, $sql);

        $i=1;

        $count=mysqli_num_rows($values);
        if($count>0)
        {
        while ($row = mysqli_fetch_array($values)) {

            $delivered = $row['DELIVRD'];
            $msg_credit = $row['msgcredit'];
            $submitted = $row['submitted'];
             $undelivered = $row['Failed'];
            $rejected = $row['Rejected'];
             $block = $row['Block'];
              $spam = $row['spam'];
               $refund = $row['Refund'];
                $smart = $row['Smart'];
              $dnd = $row['DND'];
            $u_name = fetch_username($u_id);
            //$result[$userid] = $row;
          $result.="<tr>
           <td>$i</td>
          <td>$u_name</td>
          <td>$msg_credit</td>
          <td>$delivered</td>
          <td>$delivered</td>
          <td>$submitted</td>
          <td>$undelivered</td>
          <td>$rejected</td>
           <td>Expired</td>
           <td>$dnd</td>
            <td>$block</td>
             <td>$spam</td>
              <td>$refund</td>
              <td>$smart</td>

          </tr>";

          $i++;

        }
      }
      else
      {
        $result="No records available";
        
      }
      return $result;
    }

    function delete_acct_manager() {
        global $dbc;
        $acct_manager_id=$_REQUEST['acct_manager_id'];
       
        $sql = "delete from account_manager  where userid='".$acct_manager_id."'";
        $result = mysqli_query($dbc, $sql);
        if($result)
        {
          $u_id=$_SESSION['user_id'];
                            get_last_activities($u_id,'Account Manager Details Have Been Successfully Removed',@$login_date,@$logout_date);

          return 1;
        }
        else
        {
          return 0;
        }
        
    }

function fetch_username($u_id)
{
  global $dbc;

  $sql="select * from az_user where userid='".$u_id."'";
  $result=mysqli_query($dbc,$sql);
  while($row=mysqli_fetch_array($result))
  {
    $u_name=$row['client_name'];
  }
  return $u_name;
}


function fetch_route_name($routeid)
{
  global $dbc;

  $sql="select az_rname from az_routetype where az_routeid='".$routeid."'";
  $result=mysqli_query($dbc,$sql);
  while($row=mysqli_fetch_array($result))
  {
    $rname=$row['az_rname'];
  }
  return $rname;
}

function fetch_user($u_id)
{
  global $dbc;

  $sql="select * from az_user where userid='".$u_id."'";
  $result=mysqli_query($dbc,$sql);
  while($row=mysqli_fetch_array($result))
  {
    $u_name=$row['user_name'];
  }
  return $u_name;
}


function username_dropdown($result)
{
  global $dbc;

  // return $username_dropdown="<option value=''>Select Username</option>";
  
   $page_name=$_REQUEST['page'];
   $username_dropdown="<option value=''>Select Username</option>";
   if($page_name=='number_block')
   {
      $username_dropdown.="<option value='-1'>All</option>";
   }
   else if($page_name=='mis')
   {
    $username_dropdown.="<option value='All'>All</option>";
   }

  	 foreach ($result as $key => $value) { 
            $userid=$value['userid'];
            $username=$value['user_name'];
             
           	 $username_dropdown.="<option value='".$userid."'>$username</option>";
             
           }
             return $username_dropdown;
}


?>