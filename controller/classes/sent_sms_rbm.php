<?php
$log_file = "/var/log/php_errors.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);

include('/var/www/html/itswe_panel/include/connection.php');
include('/var/www/html/itswe_panel/include/config.php');

$data_send=json_decode($argv[1],true);

$job_id=$data_send[0];
$bot_id=$data_send[1];
$template_name=$data_send[2];
$access_token=$data_send[3];
$sendtabledetals = RCSMASTER ;

global $dbc;


$query_master_tbl_select= "select * from $sendtabledetals where msg_job_id='".$job_id."' and is_picked=0 and status='Submitted'";
$master_data=mysqli_query($dbc,$query_master_tbl_select);
while($row=mysqli_fetch_array($master_data))
{
    $mobile_number=$row['mobile_number'];
    $master_job_id=$row['master_job_id'];

    $endpoint = 'https://api.virbm.in/rcs/v1/phones/'.$mobile_number.'/agentMessages/async?sendGipLink=false&messageId='.$master_job_id.'&botId='.$bot_id;


    $data = array(
        'contentMessage' => array(
            'templateMessage' => array(
                'templateCode' => $template_name
            )
        )
    );
   


    $headers = array(
        'Content-Type: application/json',
        'Authorization: Bearer '.$access_token
    );

    // print_r($headers);

   

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $endpoint);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($curl);
    // /echo $response;
    curl_close($curl);
    $filename="rcs_testing.json";
    $file_path="/var/www/html/itswe_panel/controller/classes/rcs_logs/".$filename;
    $fp = fopen($file_path, 'a+');
    fwrite($fp, json_encode($response));   // here it will print the array pretty
    fclose($fp);

}



?>