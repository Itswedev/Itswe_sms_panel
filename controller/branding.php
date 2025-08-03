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

  if($list_type=='all_branding')
  {
      $table = 'branding';

      $primaryKey = 'id';

      $columns = array(
          array( 'db' => 'id','dt' => 0 ),
          array( 'db' => 'company_name','dt' => 1),
          array( 'db' => 'company_tagline','dt' => 2 ),
          array( 'db' => 'website_address','dt' => 3 ),
          array( 'db' => 'support_url','dt' => 4 ),
          array( 'db' => 'support_mobile','dt' => 5 ),
          array( 'db' => 'support_email','dt' => 6 ),
          array( 'db' => 'login_desc','dt' => 7 ),
          array( 'db' => 'id','dt' => 8,'formatter' => function( $d, $row ) {
            /*if($row[5]=='1')
            {
              $btn_class="inactive_user_btn";
              $btn_val="Inactive";
            }else
            {
              $btn_class="active_user_btn";
              $btn_val="Active";
            }*/

            $company_name=$row[1];
            $company_tagline=$row[2];
            $web_addr=$row[3];
            $support_url=$row[4];
            $support_mobile=$row[5];
            $support_email=$row[6];
            $login_desc=$row[7];
              $action="<button class='btn btn-primary btn-sm me-1 mb-1 edit_branddtls_btn' type='button' data-bs-toggle='modal' data-bs-target='#editbrandingModel' data-id='".$d."' data-company_name='".$company_name."' data-company_tagline='".$company_tagline."'
              data-web_addr='".$web_addr."'
              data-support_url='".$support_url."'
              data-support_mobile='".$support_mobile."'
              data-support_email='".$support_email."'
              data-login_desc='".$login_desc."'>
             
              <i class='fa fa-pencil'></i>
                </button>&nbsp;
                <button class='btn btn-primary btn-sm me-1 mb-1 delete_branddtls_btn' type='button'  data-id='".$d."'>
                <i class='fa fa-trash'></i>
                </button>";
                  return $action;
              })
         
      );
       
      // SQL server connection information
      global $sql_details;

      $extraWhere="";

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
      }

      echo json_encode(
          SSP::complex( $_REQUEST, $sql_details, $table, $primaryKey, $columns,$test=null,$extraWhere )
      );
  }
   else if($list_type=='count_branding')
  {
    global $dbc;
    $userid=$_SESSION['user_id'];
   $sql_count="select count(1) as count_brand from branding where userid='".$userid."'";

    $result_count=mysqli_query($dbc,$sql_count);
    $row_count=mysqli_fetch_array($result_count);
    $count_branding=$row_count['count_brand'];

    echo $count_branding;
  }
  else if($list_type=='edit_branding')
  {
    $rs=update_brand();
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
   else if($list_type=='delete_brand')
  {
    $rs=delete_brand();

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

function update_brand() {
 global $dbc;

        $userid=$_SESSION['user_id'];
        $brand_id=$_REQUEST['brand_id'];
       /* $userid=$_POST['reseller_dropdown'];*/
        $company_name = ucwords(strtolower($_POST['company_name']));
        if(isset($_FILES['company_logo']['name']))
        {
          $company_logo=$_FILES['company_logo']['name'];
        }
        else
        {
          $company_logo='';
        }
        $tag_line = $_POST['tag_line'];
        $support_url = $_POST['support_url'];
        $support_mobile = $_POST['support_mobile'];
        $support_email = $_POST['support_email'];
        $login_desc = $_POST['login_desc'];   
        $web_url = trim($_POST['web_url']);

        $added_by=$_SESSION['user_id'];
   




             $sql = "update `branding` set website_address='" . $web_url . "',company_name='" . $company_name . "',company_tagline='" . $tag_line . "',support_url='" . $support_url . "',support_mobile='" . $support_mobile . "',support_email='" . $support_email . "',login_desc='" . $login_desc . "',created_at=now() where id='".$brand_id."'";


                    $query = mysqli_query($dbc, $sql);
                    if ($query) {

                                        if($company_logo!='')
                          {
                            $target_dir = "../assets/images/branding/";
                            $target_file = $target_dir . $_FILES["company_logo"]["name"];
                            $uploadOk = 1;
                            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


                                      if (file_exists($target_file)) {
                                        return "File already exists.";
                                        $uploadOk = 0;
                                      }

                            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                            && $imageFileType != "gif" ) {
                              return "Only JPG, JPEG, PNG & GIF files are allowed.";
                              $uploadOk = 0;
                            }



                            if(move_uploaded_file($_FILES["company_logo"]["tmp_name"], $target_file))
                            {
                                  
                                $sql_logo = "update `branding` set company_logo='" . $company_logo . "' where id='".$brand_id."'";


                                $query = mysqli_query($dbc, $sql_logo);
                            }
                            
                          }

                           $u_id=$_SESSION['user_id'];
                            get_last_activities($u_id,'Successfully updated branding information',@$login_date,@$logout_date);

                        unset($_POST);
                        return 1;
                    } else {
                        return 0;
                    }



        
      

          
       
        
    }

    function delete_brand() {
        global $dbc;
        $bid=$_REQUEST['brandid'];
       
        $sql = "delete from branding  where id='".$bid."'";
        $result = mysqli_query($dbc, $sql);
        if($result)
        {
          $u_id=$_SESSION['user_id'];
                            get_last_activities($u_id,'Branding Details Have Been Successfully Removed',@$login_date,@$logout_date);

          return 1;
        }
        else
        {
          return 0;
        }
        
    }


      function viewallbrand() {
        global $dbc;
        $result = array();
        $userid=$_SESSION['user_id'];
        if($userid!=1)
        {
           $sql = "SELECT *  FROM branding where userid='".$userid."' ORDER BY created_at DESC";
        }
        else
        {
           $sql = "SELECT *  FROM branding ORDER BY created_at DESC";
        }
       
        $values = mysqli_query($dbc, $sql);
        while ($row = mysqli_fetch_assoc($values)) {
            $id = $row['id'];
            $result[$id] = $row;
        }
        return $result;
    }


         function all_brand($result)
        {
          $i = 1;
          if (!empty($result)) { 
         
           foreach ($result as $key => $value) { 
            $id=$value['id'];
            $company_name=$value['company_name'];
            

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
              <td width='30%'>$plan_name</td>            
              <td width='15%'>$status</td>
              <td width='15%'>$created_dt</td>              
              <td width='15%'>
                <button class='btn btn-primary me-1 mb-1 edit_plan' type='button' data-bs-toggle='modal' data-bs-target='#edit_plan' data-id='".$pid."' data-plan='".$plan_name."' data-status='".$pstatus."' >
                  <span class='fas fa-edit ms-1' data-fa-transform='shrink-3'></span>
                </button>&nbsp;
                <button class='btn btn-primary me-1 mb-1 delete_plan_btn' type='button'  data-id='".$pid."'>
                  <span class='fas fa-trash ms-1' data-fa-transform='shrink-3'></span>
                </button>
              </td></tr>";
                $i++;
                }

                return $return_plan;
          } 
          else
          {
            return "No record available";
          }
        }

function saveBranding()
{
	      global $dbc;

        $userid=$_SESSION['user_id'];
       /* $userid=$_POST['reseller_dropdown'];*/
        $company_name = ucwords(strtolower($_POST['company_name']));
        $company_logo=$_FILES['company_logo']['name'];
        $tag_line = $_POST['tag_line'];
        $support_url = $_POST['support_url'];
        $support_mobile = $_POST['support_mobile'];
        $support_email = $_POST['support_email'];
        $login_desc = $_POST['login_desc'];   
        $web_url = trim($_POST['web_url']);

        $added_by=$_SESSION['user_id'];
        $sql_select = "SELECT * from branding where website_address='$web_url'";
        $query_select = mysqli_query($dbc, $sql_select);
        $count_brand=mysqli_num_rows($query_select);
        
        if($count_brand==0)
        {



          $target_dir = "../assets/images/branding/";
          $target_file = $target_dir . $_FILES["company_logo"]["name"];
          $uploadOk = 1;
          $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
          //$check = getimagesize($_FILES["uploadfile"]["tmp_name"]);
        /*  if($check !== false) {
          
          $uploadOk = 1;
           // return "File is an image - " . $check["mime"] . ".";

          } else {
            $uploadOk = 0;
            return "File is not an image.";
            
          }*/

          if (file_exists($target_file)) {
            return "File already exists.";
            $uploadOk = 0;
          }

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  return "Only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}


if ($uploadOk == 0) {
  return "Your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["company_logo"]["tmp_name"], $target_file)) {
   // echo "The file ". htmlspecialchars( basename( $_FILES["uploadfile"]["name"])). " has been uploaded.";


     $sql = "INSERT INTO `branding`(userid,website_address,company_name,company_tagline,company_logo,support_url,support_mobile,support_email,login_desc,added_by,created_at) VALUES ('" . $userid . "','" . $web_url . "','" . $company_name . "','" . $tag_line . "','" . $company_logo . "','" . $support_url . "','" . $support_mobile . "','" . $support_email . "','" . $login_desc . "','" . $added_by . "',now())";


            $query = mysqli_query($dbc, $sql);
            if ($query) {
                $u_id=$_SESSION['user_id'];
                get_last_activities($u_id,'Added new branding details',@$login_date,@$logout_date);
                unset($_POST);
                return 1;
            } else {
                return 0;
            }



  } else {
    return "Sorry, there was an error uploading your file.";
  }
}

        	
        }
        else
        {
        	return 0;
        	
        }

       

}

