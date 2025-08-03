<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/


    $host = "localhost";
   // $host = "172.31.11.77";
    $username = "kannel";
    $password = "NcbagqPkhdt#^98ajtd";
    $db = "itswe_client";
    $dbc = mysqli_connect($host, $username, $password,$db);

    if($dbc)
    {
       


      //echo "Connection Done";
    }
    else
    {
        echo "Connection Failed!!!!!";
    }
    

$llocal = true;
?>
