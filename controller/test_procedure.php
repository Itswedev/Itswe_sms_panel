<?php
session_start();
include_once('../include/connection.php');

include_once('../include/config.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

global $dbc;

        $response="Cron start time:- ".date('Y-m-d h:i');
        $sendtabledetals = SENDSMSDETAILS;
        //$sendtabledetals = 'az_sendnumbers_bk';
        $record_dt=date('Y-m-d', strtotime(' -2 day'));
        $today_month=date('m');
        $today_year=date('Y');
        $record_month=date('m', strtotime(' -2 day'));
        $record_year=date('Y', strtotime(' -2 day'));

$procedure_statement="CREATE PROCEDURE `test_proce`()
BEGIN
    begin
  DECLARE master_tbl_count INT;
    DECLARE archive_tbl_count INT;
    START transaction;
    SELECT count(1) into master_tbl_count FROM $sendtabledetals WHERE `date(sent_at)`='$record_dt' and is_scheduled!=1 and schedule_sent=1;  

    SELECT count(1) into archive_tbl_count FROM $monthly_archive_table WHERE `date(sent_at)`='$record_dt' and is_scheduled!=1 and schedule_sent=1;  
    
    if master_tbl_count = archive_tbl_count Then
    commit;
  else
    rollback;
  END IF;
    end;
END";
$result=mysqli_query($dbc,$procedure_statement) or die(mysqli_error($dbc));
echo "success";
/*
$sql="call move_master_tbl_records()";

$result=mysqli_query($dbc,$sql) or die(mysqli_error());
echo "success";

while($row=mysqli_fetch_array($result))
{
	echo $row[0];
}*/


?>