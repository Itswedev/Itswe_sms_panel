<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
error_reporting(0);
include('/var/www/html/itswe_panel/include/connection.php');


// Set the PHPMailer class to use SMTP
require '/var/www/html/itswe_panel/phpmailer/PHPMailer.php';
require '/var/www/html/itswe_panel/phpmailer/SMTP.php';
require '/var/www/html/itswe_panel/phpmailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

daily_usage_alert_email();


function daily_usage_alert_email()
{
	$yesterday_dt=date('Y-m-d',strtotime("-1 days"));

	global $dbc;
	$sql_user="select u.userid,u.user_name as Uname,us.route as Route,sum(us.bill_credit) as Total,sum(if(us.status='Delivered',us.bill_credit,0)) as DELIVRD from user_summary as us inner join az_user as u  on us.userid = u.userid where u.userid in ('5076','5049','4975','4501','4719','4715','4716','4717','4718','4939','4949','7','5039') and date(us.created_date)='$yesterday_dt' group by 1,3;";
	$result_user=mysqli_query($dbc,$sql_user) or die(mysqli_error($dbc));
	$email_data="<table border='1' align='center'><tr><th colspan=4>Daily Usage summary of $yesterday_dt</th>
	<tr><th>Username</th><th>Route</th><th>Total</th><th>Delivered</th></tr>";
	while ($row=mysqli_fetch_array($result_user)) {
		$ids=$row['u.userid'];
		$username=$row['Uname'];
		$route=$row['Route'];
		$total=$row['Total'];
		$delivered=$row['DELIVRD'];
		$email_data.="<tr><td>$username</td><td>$route</td><td>$total</td><td>$delivered</td></tr>";

	}

	$email_data.="</table>";
	 
//echo $email_data;
	// Recipient's email address
$to = "abhay@mdsmedia.in";


// Email subject and content
$subject = "Daily Usage Summary of $yesterday_dt";
$message = $email_data;

// Additional headers
$headers = "From: noreply.mdsmedia@gmail.com" . "\r\n" .
           "MIME-Version: 1.0" . "\r\n" .
           "Content-type: text/html; charset=UTF-8" . "\r\n";

// SMTP server configuration
$smtpHost = 'smtp.gmail.com';
$smtpPort = 587;
$smtpUsername = 'noreply.mdsmedia@gmail.com';
$smtpPassword = 'ujmhghtfruzzojyj';

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Host = $smtpHost;
$mail->Port = $smtpPort;
$mail->SMTPAuth = true;
$mail->Username = $smtpUsername;
$mail->Password = $smtpPassword;
$mail->SMTPSecure = 'tls'; // You can change this to 'ssl' if needed

// Email settings
$mail->SetFrom('noreply.mdsmedia@gmail.com', 'MDS Digital Media - Daily Usage Alert');
$mail->addCC('abhishek@mdsmedia.in');
$mail->addBCC('komal@mdsmedia.in');
$mail->addBCC('shoaib.pantave@mdsmedia.in');
// $mail->addCC('shital@mdsmedia.in');
// $mail->addCC('pranita@mdsmedia.in');
$mail->AddAddress($to);
$mail->Subject = $subject;
$mail->MsgHTML($message);

// Send the email
if ($mail->Send()) {
    echo "Email sent successfully";
} else {
    echo "Email sending failed: " . $mail->ErrorInfo;
}




}

daily_usage_alert_email_sikha();

function daily_usage_alert_email_sikha()
{
	$yesterday_dt=date('Y-m-d',strtotime("-1 days"));

	global $dbc;
	$sql_user="select u.userid,u.user_name as Uname,us.route as Route,sum(us.bill_credit) as Total,sum(if(us.status='Delivered',us.bill_credit,0)) as DELIVRD from user_summary as us inner join az_user as u  on us.userid = u.userid where u.userid in ('4973','4708','4964','34','4934','4862','4793','4804','4761','4726','4725','4744','4650','4647','4532','37','20','35','36') and date(us.created_date)='$yesterday_dt' group by 1,3;";
	$result_user=mysqli_query($dbc,$sql_user) or die(mysqli_error($dbc));
	$email_data="<table border='1' align='center'><tr><th colspan=4>Daily Usage summary of $yesterday_dt</th>
	<tr><th>Username</th><th>Route</th><th>Total</th><th>Delivered</th></tr>";
	while ($row=mysqli_fetch_array($result_user)) {
		$ids=$row['u.userid'];
		$username=$row['Uname'];
		$route=$row['Route'];
		$total=$row['Total'];
		$delivered=$row['DELIVRD'];
		$email_data.="<tr><td>$username</td><td>$route</td><td>$total</td><td>$delivered</td></tr>";

	}

	$email_data.="</table>";
	 
//echo $email_data;
	// Recipient's email address
$to = "sikha@mdsmedia.in";


// Email subject and content
$subject = "Daily Usage Summary of $yesterday_dt";
$message = $email_data;

// Additional headers
$headers = "From: noreply.mdsmedia@gmail.com" . "\r\n" .
           "MIME-Version: 1.0" . "\r\n" .
           "Content-type: text/html; charset=UTF-8" . "\r\n";

// SMTP server configuration
$smtpHost = 'smtp.gmail.com';
$smtpPort = 587;
$smtpUsername = 'noreply.mdsmedia@gmail.com';
$smtpPassword = 'ujmhghtfruzzojyj';

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Host = $smtpHost;
$mail->Port = $smtpPort;
$mail->SMTPAuth = true;
$mail->Username = $smtpUsername;
$mail->Password = $smtpPassword;
$mail->SMTPSecure = 'tls'; // You can change this to 'ssl' if needed

// Email settings
$mail->SetFrom('noreply.mdsmedia@gmail.com', 'MDS Digital Media - Daily Usage Alert');
$mail->addCC('abhishek@mdsmedia.in');
$mail->addBCC('komal@mdsmedia.in');
$mail->addBCC('shoaib.pantave@mdsmedia.in');
// $mail->addCC('shital@mdsmedia.in');
// $mail->addCC('pranita@mdsmedia.in');
$mail->AddAddress($to);
$mail->Subject = $subject;
$mail->MsgHTML($message);

// Send the email
if ($mail->Send()) {
    echo "Email sent successfully";
} else {
    echo "Email sending failed: " . $mail->ErrorInfo;
}




}




daily_usage_alert_email_anil();

function daily_usage_alert_email_anil()
{
	$yesterday_dt=date('Y-m-d',strtotime("-1 days"));

	global $dbc;
	$sql_user="select u.userid,u.user_name as Uname,us.route as Route,sum(us.bill_credit) as Total,sum(if(us.status='Delivered',us.bill_credit,0)) as DELIVRD from user_summary as us inner join az_user as u  on us.userid = u.userid where u.userid in ('4947','4903','4828','4655') and date(us.created_date)='$yesterday_dt' group by 1,3;";
	$result_user=mysqli_query($dbc,$sql_user) or die(mysqli_error($dbc));
	$email_data="<table border='1' align='center'><tr><th colspan=4>Daily Usage summary of $yesterday_dt</th>
	<tr><th>Username</th><th>Route</th><th>Total</th><th>Delivered</th></tr>";
	while ($row=mysqli_fetch_array($result_user)) {
		$ids=$row['u.userid'];
		$username=$row['Uname'];
		$route=$row['Route'];
		$total=$row['Total'];
		$delivered=$row['DELIVRD'];
		$email_data.="<tr><td>$username</td><td>$route</td><td>$total</td><td>$delivered</td></tr>";

	}

	$email_data.="</table>";
	 
//echo $email_data;
	// Recipient's email address
$to = "anil.rathod@mdsmedia.in";


// Email subject and content
$subject = "Daily Usage Summary of $yesterday_dt";
$message = $email_data;

// Additional headers
$headers = "From: noreply.mdsmedia@gmail.com" . "\r\n" .
           "MIME-Version: 1.0" . "\r\n" .
           "Content-type: text/html; charset=UTF-8" . "\r\n";

// SMTP server configuration
$smtpHost = 'smtp.gmail.com';
$smtpPort = 587;
$smtpUsername = 'noreply.mdsmedia@gmail.com';
$smtpPassword = 'ujmhghtfruzzojyj';

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Host = $smtpHost;
$mail->Port = $smtpPort;
$mail->SMTPAuth = true;
$mail->Username = $smtpUsername;
$mail->Password = $smtpPassword;
$mail->SMTPSecure = 'tls'; // You can change this to 'ssl' if needed

// Email settings
$mail->SetFrom('noreply.mdsmedia@gmail.com', 'MDS Digital Media - Daily Usage Alert');
$mail->addCC('abhishek@mdsmedia.in');
$mail->addBCC('komal@mdsmedia.in');
$mail->addBCC('shoaib.pantave@mdsmedia.in');
// $mail->addCC('shital@mdsmedia.in');
// $mail->addCC('pranita@mdsmedia.in');
$mail->AddAddress($to);
$mail->Subject = $subject;
$mail->MsgHTML($message);

// Send the email
if ($mail->Send()) {
    echo "Email sent successfully";
} else {
    echo "Email sending failed: " . $mail->ErrorInfo;
}




}



?>