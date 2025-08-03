<?php
session_start();
include_once('../include/connection.php');

$userid=$_REQUEST['userid'];
$agent_id=$_REQUEST['agent_id'];

	$public_fname = explode('.', $_FILES['public_key_file']['name']);
	$public_filename=$_FILES['public_key_file']['name'];
    $public_file_extension = end($public_fname); 

    $private_fname = explode('.', $_FILES['private_key_file']['name']);
    $private_filename=$_FILES['private_key_file']['name'];
    $private_file_extension = end($private_fname); 


    $service_fname = explode('.', $_FILES['service_key_file']['name']);
    $service_filename=$_FILES['service_key_file']['name'];
    $service_file_extension = end($service_fname); 


    if($public_file_extension=='pem' && $private_file_extension=='der' && $service_file_extension=='json')
    {
        
    if(!file_exists("vsms/$public_filename") && !file_exists("vsms/$private_filename") && !file_exists("vsms/$service_filename"))
        {
       		
                $sql_select="select * from vsms_dtls where userid='".$userid."'";
                $res_select=mysqli_query($dbc,$sql_select);
                $count_user_entry=mysqli_num_rows($res_select);

                if($count_user_entry==0)
                {
                    $res_public=move_uploaded_file($_FILES['public_key_file']['tmp_name'], 'vsms/' . $_FILES['public_key_file']['name']);

                    $res_private=move_uploaded_file($_FILES['private_key_file']['tmp_name'], 'vsms/' . $_FILES['private_key_file']['name']);

                    $res_service=move_uploaded_file($_FILES['service_key_file']['tmp_name'], 'vsms/' . $_FILES['service_key_file']['name']);

                    if($res_public==1 &&  $res_private==1 && $res_service==1)
                    {
                        $sql="insert into vsms_dtls(`agent_id`,`public_key`,`private_key`,`service_key`,`userid`,`created_at`) values('".$agent_id."','".$public_filename."','".$private_filename."','".$service_filename."','".$userid."',NOW())";
                        $result=mysqli_query($dbc,$sql);
                        if($result)
                        {
                            echo "success";
                        }
                    }
                    else
                    {
                        echo "Unable to upload Google VSMS key files";
                    }
                    
                }
                else
                {
                    echo "Google VSMS Key Files already Exists";
                }
                
           
        }
        else
        { 
            echo "File already exists";
        }

   }
   else
   {
   	echo "Please upload only vsms key file";
   }




  


?>