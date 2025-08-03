<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


    $host = "localhost";
  
    $username = "itswe";
    $password = "NcbagqPkhdt#^98ajtd";
    $db = "itswe_client";
    $dbc = mysqli_connect("p:".$host, $username, $password,$db);

        //db connection for DND database
    //$db2 = "dnd";
    //$dbc2 = mysqli_connect("p:".$host, $username, $password,$db2);


    //db connection for all datatable values
    $sql_details = array(
       'user' => 'itswe',
       'pass' => 'NcbagqPkhdt#^98ajtd',
       'db'   => 'itswe_client',
       'host' => 'localhost'
    );

    $db_conn='mysql -h localhost -u itswe -p"NcbagqPkhdt#^98ajtd" "itswe_client"';

    if($dbc)
    {
     // echo "Connection Done";
    }
    else
    {
        echo "Connection Failed!!!!!";
    }
    

  $restricted_tlv=@$_SESSION['restricted_tlv'];
  $restricted_report=@$_SESSION['restricted_report'];

$llocal = true;
?>

