<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


    $host = "65.2.73.213";
   // $host = "172.31.11.77";
    $username = "itswe";
    $password = "2sE#E2$4";
    $db = "voice";
    // echo phpinfo();
     $dbc = mysqli_connect($host, $username, $password,$db);

   if (!$dbc) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully";
}

$llocal = true;
?>

