<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Recipient's email address
$to = "shoaib.pantave@mdsmedia.in";

// Email subject and content
$subject = "DB Connection Failed";
$message = "DB Connection failed";

// Additional headers
$headers = "From: noreply.mdsmedia@gmail.com" . "\r\n" .
           "CC: komal@mdsmedia.in" . "\r\n" .
           "MIME-Version: 1.0" . "\r\n" .
           "Content-type: text/html; charset=UTF-8" . "\r\n";

// SMTP server configuration
$smtpHost = 'smtp.gmail.com';
$smtpPort = 587;
$smtpUsername = 'noreply.mdsmedia@gmail.com';
$smtpPassword = 'ujmhghtfruzzojyj';

// Set the PHPMailer class to use SMTP
require '/var/www/html/itswe_panel/phpmailer/PHPMailer.php';
require '/var/www/html/itswe_panel/phpmailer/SMTP.php';
require '/var/www/html/itswe_panel/phpmailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Host = $smtpHost;
$mail->Port = $smtpPort;
$mail->SMTPAuth = true;
$mail->Username = $smtpUsername;
$mail->Password = $smtpPassword;
$mail->SMTPSecure = 'tls'; // You can change this to 'ssl' if needed

// Email settings
$mail->SetFrom('noreply.mdsmedia@gmail.com', 'ITSWE Client - DB Connection');
$mail->addCC('komal@mdsmedia.in');
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
?>
