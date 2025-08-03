<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


    $host = "localhost";
  
    $username = "itswe";
    $password = "NcbagqPkhdt#^98ajtd";
    $db = "dnd";
    $dbc2 = mysqli_connect("p:".$host, $username, $password,$db);


  

  

    if($dbc2)
    {
       


      echo "Connection Done";
    }
    else
    {
        echo "Connection Failed!!!!!";
    }
    


$llocal = true;
?>

