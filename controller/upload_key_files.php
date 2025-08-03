<?php
session_start();
include_once('../include/connection.php');

$userid=$_REQUEST['userid'];
$client_id=$_REQUEST['client_id'];
$client_secret=$_REQUEST['client_secret'];
$bot_type=$_REQUEST['bot_type'];

$client_val = $client_id.":".$client_secret;

 $authorization = base64_encode($client_val);


/*print_r($authorization);*/

$endpoint = 'https://auth.virbm.in/auth/oauth/token?grant_type=client_credentials';

$data = array(
  'grant_type' => 'client_credentials'
);

$headers = array(
  'Accept: application/json',
  'Authorization: Basic '.$authorization
);

/*print_r($headers);
*/

/*print_r($headers);*/

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
  /*print_r($responseData);*/
  if($responseData['access_token']!='')
                    {

                        $access_token = $responseData['access_token'];
                         $sql="insert into rcs_cred(`client_id`,`secret_code`,`access_token`,`bot_type`,`user_id`) values('".$client_id."','".$client_secret."','".$access_token."','".$bot_type."','".$userid."')";
                        $result=mysqli_query($dbc,$sql);
                        if($result)
                        {
                            echo "success";
                        }
                    }
  // Handle the response data accordingly
}

curl_close($curl);







/*	$fname = explode('.', $_FILES['rcs_key_file']['name']);
	$filename=$_FILES['rcs_key_file']['name'];
    $extension = end($fname);    
    if($extension=='json')
    {
        
        if(!file_exists("../rcs/resources/$filename"))
        {
       		

                

                $sql_select="select * from rcs_key_dtls where userid='".$userid."'";
                $res_select=mysqli_query($dbc,$sql_select);
                $count_user_entry=mysqli_num_rows($res_select);

                if($count_user_entry==0)
                {
                    $res=move_uploaded_file($_FILES['rcs_key_file']['tmp_name'], '../rcs/resources/' . $_FILES['rcs_key_file']['name']);
                    if($res==1)
                    {
                        $sql="insert into rcs_key_dtls(`key_file_name`,`userid`,`created_at`) values('".$filename."','".$userid."',NOW())";
                        $result=mysqli_query($dbc,$sql);
                        if($result)
                        {
                            echo "success";
                        }
                    }
                    else
                    {
                        echo "Unable to upload RCS key file";
                    }
                    
                }
                else
                {
                    echo "RCS Key File already Exists";
                }
                
           
        }
        else
        { 
            echo "File already exists";
        }

   }
   else
   {
   	echo "Please upload only RCS key file";
   }
*/



  


?>