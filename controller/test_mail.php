<?php

$to = "komal@mdsmedia.in";
$subject = "My subject";
$txt = "Hello world!";
$headers = "From: komal@sms.vapio.in";

echo mail($to,$subject,$txt,$headers);

?>