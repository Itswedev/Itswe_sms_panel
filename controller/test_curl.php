<?php
//     libxml_use_internal_errors(true);
// $url = 'http://localhost:13000/status.xml?password=aaa';
 
// $curl = curl_init();
 
// curl_setopt($curl, CURLOPT_URL, $url);
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($curl, CURLOPT_HEADER, false);
 
//  $data = curl_exec($curl);
 
// $xml=simplexml_load_string($data) or die("Error: Cannot create object");
// $con = json_encode($xml);
  
// // Convert into associative array
// $newArr = json_decode($con, true);
// curl_close($curl);
//       print_r($newArr);

$master_job_id='Yvpx4Cn6aToEyI0sMAQjsdh';
$bot_id='xLsWUOS8m23u840F';

$template_name='lendingplateApplyNow';

$access_token='eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJzY29wZSI6WyJDaGF0Ym90LW1lc3NhZ2UiLCJyY3MtY29uZmlnIiwia29ubmVjdCIsIndiYXBpIiwiZ29vZ2xlIl0sImV4cCI6MTcxMjk2MjA3MiwianRpIjoiNmE5MGNiMTAtYmUxNC00MjE5LTg2YWMtNGZmNmM1MTJjODg1IiwiY2xpZW50X2lkIjoieExzV1VPUzhtMjN1ODQwRiJ9.fdnHFeRWJLp9NAR0SRcETyiz1q5qmNY8OOw3Cp2OR6rnNbooNAC5XKwz-_JsYN1oWTCkLb9iG3xkosRYIIzfE9v67_X_mNF_0EauGIW7B07W7Qb8D_Ep2vm3BVM_HN1D1x_e8NJ0gwhXbrQUNx9BgKdP1ZiGyOHR1xrmAyI7KtDlaEkJT9iKT1HFxVSuHxWDYDpij0QvrqXlZp8qQxMci6PJ0QdQyFPexuJ45ScQVBWPhUUE1cR_VMRIFUPwB08aZQ8UZMLSW9Ic7exlBRpVL1lx7ZHKsIPGX1RLwXfByT_3fwtFxc11rDdEYXSlBBWwhTR8DLvmcIWReli5I3lYqw';

$endpoint = 'https://api.virbm.in/rcs/v1/phones/+919819708784/agentMessages/async?sendGipLink=false&messageId='.$master_job_id.'&botId='.$bot_id;


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

echo $response = curl_exec($curl);

?>
