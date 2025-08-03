<?php
session_start();

$log_file = "/var/www/html/itswe_panel/error/logfiles/send_rcs_open_url.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);

include('/var/www/html/itswe_panel/include/connection.php');

$user_id=$argv[2];
$send_msg_file = "/var/www/html/itswe_panel/controller/classes/rcs_messages/".$argv[1];

$jsonString = file_get_contents($send_msg_file);
$data = json_decode($jsonString, true);
/*print_r($data);*/
$dlr_url_arr=$data['dlr_url_arr'];
$mob_num_arr=$data['mob_num_arr'];
$message_type=$data['message_type'];
$msg=$data['msg'];
$url=$data['web_url'];
$url_title=$data['url_title'];

 $mob_num_data = array_chunk($mob_num_arr, 2000);
 $dlr_url_data = array_chunk($dlr_url_arr, 2000);
 $i=0;
  foreach($mob_num_data as $values) {

        $array = array('mobile_number' => $values,'msg' => $msg,'dlr_url'=>$dlr_url_data[$i],'url'=>$url,'url_title'=>$url_title);
       	
        //$filename="rcs_send_msg_".time().".json";
        $fname="rcs_send_sms_open_url_data_".time().".json";
        $filename="/var/www/html/itswe_panel/controller/classes/rcs_messages/".$fname;

        $file_path="rcs/".$filename;
        $fp = fopen($filename, 'w+');
        
        fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
        fclose($fp);
        
       

        $pyout = exec("/var/www/html/itswe_panel/rcs/rcs-env/bin/python /var/www/html/itswe_panel/rcs/open_url.py $fname $user_id", $outp, $return);
        $response=explode(",",$pyout);
     
   $master_table_ids=$dlr_url_data[$i];
   		for($k=0;$k<count($master_table_ids);$k++)
   		{
   		$master_id=$master_table_ids[$k];
    	$resp_status=$response[$k];
      	if($resp_status==200)
      	{
      		$status='Delivered';
      	}
      	else
      	{
      		$status="Failed";
      	}
    	$sql="update rcs_dtls set status='$status',err_code='$resp_status' where id='".$master_id."'";
    	$rs=mysqli_query($dbc,$sql)or die(mysqli_error($dbc));
    	}
    	sleep(1);
        $i++;
    }

    
	// print_r($response);

           

?>
