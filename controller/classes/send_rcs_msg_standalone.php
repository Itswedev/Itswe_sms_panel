<?php
session_start();
/*$user_id=$_SESSION['user_id'];*/
$log_file = "/var/www/html/itswe_panel/error/logfiles/send_rcs_msg_standalone.log";
 
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
$msg=explode(",,",$data['msg']);
$image_url=explode(",",$data['image_url']);
$thumbnail_url=explode(",",$data['thumbnail_url']);
$url=explode(",",$data['web_url']);
$dial_number=explode(",",$data['dial_number']);
$card_title=explode(",",$data['card_title']);
$url_title=explode(",",$data['url_title']);
$dial_title=explode(",",$data['dial_title']);


 $mob_num_data = array_chunk($mob_num_arr, 2000);
 $dlr_url_data = array_chunk($dlr_url_arr, 2000);
 $i=0;
  foreach($mob_num_data as $values) {

        
        
        if($message_type=='standalone')
        {

          $array = array('mobile_number' => $values,'msg' => $msg[0],'dlr_url'=>$dlr_url_data[$i],'image_url'=>$image_url[0],'url'=>$url[0],'thumbnail_url'=>$thumbnail_url[0],'card_title'=>$card_title[0],'url_title'=>$url_title[0],'dial_title'=>$dial_title[0],'dial_number'=>$dial_number[0]);
        
         $fname="rcs_send_sms_standalone_data_".time().".json";
        $filename="/var/www/html/itswe_panel/controller/classes/rcs_messages/".$fname;

        $file_path="rcs/".$filename;
        $fp = fopen($filename, 'w+');
        
        fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
        fclose($fp);

         $pyout = exec("/var/www/html/itswe_panel/rcs/rcs-env/bin/python /var/www/html/itswe_panel/rcs/rich_card.py $fname $user_id", $outp, $return);
        }
        else if($message_type=='carousel')
        {
          $fname="rcs_send_sms_standalone_data_".time().".json";
        $filename="/var/www/html/itswe_panel/controller/classes/rcs_messages/".$fname;
         $file_path="rcs/".$filename;

          /*for($c=0;$c<count($card_title);$c++)
          {*/
                $array = array('mobile_number' => $values,'msg' => $msg,'dlr_url'=>$dlr_url_data,'image_url'=>$image_url,'url'=>$url,'thumbnail_url'=>$thumbnail_url,'card_title'=>$card_title,'url_title'=>$url_title,'dial_title'=>$dial_title,'dial_number'=>$dial_number);
                 $fp = fopen($filename, 'w+');
        
               fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
                fclose($fp);
          /*}*/
         $pyout = exec("/var/www/html/itswe_panel/rcs/rcs-env/bin/python /var/www/html/itswe_panel/rcs/carousel_card.py $fname $user_id", $outp, $return);
        }
      /*  else if($message_type=='standalone')
        {
        $pyout = exec("/var/www/html/itswe_panel/rcs/rcs-env/bin/python /var/www/html/itswe_panel/rcs/rich_card.py rcs_send_sms1.json", $outp, $return);
        }*/
        $response=explode(",",$pyout);
     /*   $master_table_ids=implode(",",$dlr_url_data[$i]);*/

   /*     $master_table_arr=explode(",",$master_table_ids);
    $response_arr=explode(",",$response);*/

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
