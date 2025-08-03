<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$date = date('Ymdhims');
$path = "/var/www/html/itswe_panel/controller/upload/";

$csfilename = 'SEND_JOB_NEW_'.$date.'.csv';
$full_path = $path.$csfilename;

$enclose = '\"';
$terminate = '\n';

echo $mysqlCommand = "mysql -h localhost -u vapio -p'Nbc0Q167anvpqta51mq' 'sms' -e \"SELECT 'Job Date', 'Userid', 'Template ID', 'Job ID', 'Chars', 'Route', 'Sender ID', 'Bill Credit', 'Mobile Number', 'Status', 'Error Code', 'Message' UNION ALL SELECT date(sent_at), userids, SUBSTRING_INDEX(metadata, 'TID=', -1), msg_job_id, char_count, route, senderid, msgcredit, mobile_number, status, err_code, msgdata from az_sendnumbers202311 where (date(sent_at) BETWEEN '2023-11-01' AND '2023-11-03') and userids='4667' limit 0,400000 INTO OUTFILE '/tmp/$csfilename' FIELDS TERMINATED BY ',' ENCLOSED BY '$enclose' LINES TERMINATED BY '$terminate'\"";
echo "<br>";
echo $scpCommand = "scp -i /var/www/html/itswe_panel/LIVE ubuntu@localhost:/tmp/$csfilename $path";
echo "<br>";
// Execute MySQL command
$result = shell_exec($mysqlCommand);
// Execute SCP command
$resultScp = shell_exec($scpCommand);

echo "MySQL command result: $result\n";
echo "SCP command result: $resultScp\n";
?>
