<?php
session_start();
include('../include/connection.php');
include('../include/config.php');
$user_id=$_REQUEST['uid'];
$sql="select * from az_user where userid='$user_id'";
$result=mysqli_query($dbc,$sql);
while($row=mysqli_fetch_array($result))
{
	$parent_id=$row['parent_id'];
/*	$_SESSION['vsms_access']=$row['gvsms'];
	$_SESSION['rcs_access']=$row['rcs'];
	$_SESSION['miscall_access']=$row['miscall_report'];*/

}


$sql_parent="select * from az_user where userid='$parent_id'";
$result_parent=mysqli_query($dbc,$sql_parent);
while($row_parent=mysqli_fetch_array($result_parent))
{
	
	$_SESSION['vsms_access']=$row_parent['gvsms'];
	$_SESSION['rcs_access']=$row_parent['rcs'];
	$_SESSION['miscall_access']=$row_parent['miscall_report'];

}

$_SESSION['edit_userid']=$user_id;
?>