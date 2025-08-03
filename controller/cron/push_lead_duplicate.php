<?php

include_once('/var/www/html/itswe_panel/include/connection.php');
include("/var/www/html/itswe_panel/include/config.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$job_id='dSAnJyZpWQUszVf';

get_mobile($job_id);

function get_mobile($job_id)
{
    global $dbc;
   
    $select_camp_name="select mobile_number,input from voice_call where msg_job_id='$job_id' and input=1";
    $camp_result = mysqli_query($dbc, $select_camp_name);

    while($row=mysqli_fetch_array($camp_result))
    {
        $mobile_number=$row['mobile_number'];

        $mobile_number="+91".$mobile_number;
        $camp_name='140923_EDELWEISS_1';

        echo $url = "http://194.233.72.181/get_response?mobile=$mobile_number&camp_name=$camp_name";

        $response=file_get_contents($url);
    
    }
    
}





?>