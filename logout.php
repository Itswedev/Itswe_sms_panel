<?php
session_start();
include('include/connection.php');

$login_id=$_SESSION['user_id'];
$sql_login_update="update az_user set login=0,logout=1 where userid='$login_id'";
$rs_login_update=mysqli_query($dbc,$sql_login_update);

session_destroy();
header('Location:index.php');


?>