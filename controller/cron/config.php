<?php
@session_start();
if (!isset($_SESSION['initiated']))
{
    session_regenerate_id(true);
}
$inactive = 3600;
if(isset($_SESSION['timeout'])) {
    $session_life = time() - $_SESSION['timeout'];
    if ($session_life > $inactive) {
        session_unset();
        session_destroy();
        echo "<meta http-equiv='Refresh' content='0; url=index.php'>";
        exit;
    }
}
 /*
 * Configuration file does the following things:
 * - Has site settings in one location.
 * - Stores URLs and URIs as constants.
 * - Sets how errors will be handled.
 */
 # ******************** #
 # ***** SETTINGS ***** #

// or on the real server:
if(stristr($_SERVER['HTTP_HOST'], 'local') || (substr($_SERVER['HTTP_HOST'], 0, 7) == '192.168') || $_SERVER['HTTP_HOST'] == 'domain' || $_SERVER['HTTP_HOST'] == 'local:8080' || $_SERVER['HTTP_HOST'] == 'domain:8080' || (substr($_SERVER['HTTP_HOST'], 0, 7) == '172.168'))
	$local = TRUE;
else
	$local = FALSE;

define('CMPNAME', 'Azmarq Technologies LLP '); // to allow multiple session of admin of different sites simultaneously open without conflict  TRANSALERT.CO.IN
define('LOGO', 'azlogo_light.png'); // this salt will be used to store the encrypted & decrypted password for users & admin mywerp
define('LOGINURL','buzz.azmarq.com'); // to decide whether the new button to enable the form with javascript should be present or not
define('WEBSITEURL','www.azmarq.com');  

define('EMAIL_PAT',"#^[\w.-]+@[\w.-]+\.[A-Za-z]{2,6}$#");

//If user has logged in then getting the constants for current session and user
//setting the timezone
$timezone = "Asia/Kolkata";
date_default_timezone_set($timezone);
// Determine location of files and the URL of the site:

// Allow for development on different servers.
$month = date('Ym');
$month = date('Ym');
define('SESS', 'MDSMEDIA');
define('CURRENTMONTH', $month);
define('BYOLDMONTH', '201706'); 
define('FOROLDDB', '201706'); 
define('CHANGEFROM', '201706'); 
/*define('SENDSMS',"az_sendmessages_$month"); 
define('SENDSMSDETAILS',"az_sendnumbers_$month"); */
define('SENDSMS',"az_sendmessages"); 
define('SENDSMSDETAILS',"az_sendnumbers"); 
define('SENTSMS',"sent_sms"); 
define('TRACKINGURL',"txt5.in/xyz/xxxxxxx");
define('TRACKINGURLUNICODE',"txt5.in/xyz/xxxxxxx/");
/*define('TRACKURLTABLE',"az_tracking_url");
if(!isset($_SESSION[SESS.'securetoken']) || empty($_SESSION[SESS.'securetoken']))
	$securetoken = $_SESSION[SESS.'securetoken']  = md5(uniqid(mt_rand(), true));
else
	$securetoken = $_SESSION[SESS.'securetoken'];*/
if($local)
{
	
	//error_reporting(0);
	$curdir = dirname(dirname(__FILE__)); // This will point to the admin folder
	$curdir_root = dirname($curdir); // will point to parent folder of admin
	$curhost = dirname($_SERVER['PHP_SELF']); //to set the base URL path to admin folder automatically
	$curhost_root = dirname($curhost); //to set the base URL path to parent of admin folder automatically
	// Always debug when running locally:
 	$debug = TRUE;
    define('SYM','/');
   // Define the constants: 
   define('MSYM','\\');  
   define ('BASE_URI', $curdir.MSYM);
   define ('BASE_URL', 'http://'.$_SERVER['HTTP_HOST'].$curhost);
   
   define ('BASE_URI_ROOT', $curdir_root.MSYM);
   define ('BASE_URL_ROOT', 'http://'.$_SERVER['HTTP_HOST'].$curhost_root.'/');
   
   define ('BASE_URI_A', BASE_URI);
   define ('BASE_URL_A', BASE_URL);
   
   
}
else
{
   error_reporting(0);
   $curdir = dirname(dirname(__FILE__)); // This will point to the admin folder
   $curdir_root = dirname($curdir); // will point to parent folder of admin
   $curhost = dirname($_SERVER['PHP_SELF']); //to set the base URL path to admin folder automatically
   $curhost_root = dirname($curhost); //to set the base URL path to parent of admin folder automatically
   define('SYM','/');
   define('MSYM','/');  
   define ('BASE_URI', $curdir.MSYM);
   define ('BASE_URL', 'http://'.$_SERVER['HTTP_HOST'].$curhost.'/');
   
   define ('BASE_URI_ROOT', $curdir_root.MSYM);
   define ('BASE_URL_ROOT', 'http://'.$_SERVER['HTTP_HOST'].$curhost_root.'/');
   
   define ('BASE_URI_A', BASE_URI);
   define ('BASE_URL_A', BASE_URL);
   
}

/*
* Most important setting...
* The $debug variable is used to set error management.
* To debug a specific page, add this to the index.php page:

if ($p == 'thismodule') $debug = TRUE;
require_once('./includes/config.inc.php');
* To debug the entire site, do

$debug = TRUE;

* before this next conditional.
*/

// Assume debugging is off.
if (!isset($debug))
	$debug = FALSE;

# ***** SETTINGS ***** #
# ******************** #

# **************************** #
# ***** ERROR MANAGEMENT ***** #

// Create the error handler.
function my_error_handler ($e_number, $e_message, $e_file, $e_line, $e_vars) 
{
	global $debug, $contact_email;

	// Build the error message.
	$message = "An error occurred in script '$e_file' on line $e_line: \n<br />$e_message\n<br/>";

	// Add the date and time.
	$message .= "Date/Time: " . date('n-j-Y H:i:s') . "\n<br />";

	// Append $e_vars to the $message.
	$message .= "<pre>" . print_r ($e_vars, 1) . "</pre>\n<br />";

	if ($debug) 
	{	// Show the error.
		echo '<p class="error">' . $message . '</p>';
	} 
	else
	{
		// Log the error:
		error_log ($message, 1, $contact_email); // Send email.

		// Only print an error message if the error isn't a notice or strict.
		if (($e_number != E_NOTICE) && ($e_number < 2048)) 
			echo '<p class="error">A system error occurred. We apologize for the inconvenience.</p>';
	} // End of $debug IF.

} // End of my_error_handler() definition.
// Use my error handler:
//set_error_handler ('my_error_handler');

# ***** ERROR MANAGEMENT ***** #
# **************************** #
# ***** Date AND time related Constants ***** #
define('DTS', '%d/%b/%Y at %r');
define('DTSB', '%d/%b/%Y <br/> %r');
define('DC', '%d/%b/%Y');
define('MASKDATE', '%d/%m/%Y');
define('OT', '%r');
define('MYSQL_DATE_SEARCH', '%Y%m%d'); 
define('TR_ROW_COLOR1','#efede8');
define('TR_ROW_COLOR2','#ffffff');
include('connection.php');
?>