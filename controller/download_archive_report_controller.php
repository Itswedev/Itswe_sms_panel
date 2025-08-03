<?php

error_reporting(E_ALL); 
ini_set('max_execution_time', '0');
include('../include/connection.php');
set_time_limit(0);


function __autoload($class)
{	
	require_once('../Classes/PHPExcel/'.$class.'.php');
}

if(isset($_REQUEST['list_type']))
{
	$web_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

    $list_type=$_REQUEST['list_type'];
    if($list_type=="download_archive_report")
	{
		global $dbc;
		$userid=$_SESSION['user_id'];
		$download_userid=$_REQUEST['download_userid'];
		$frmDate=$_REQUEST['frmDate'];
		$toDate=$_REQUEST['toDate'];

		$out = array();
		$fileName = date("Ymdhims").rand(11111,99999).'.csv';

		$date = date('Ymdhims');
	   		$fileName = 'Download_'.$date.'.zip';
	   		$fname='Download_'.$date.'.zip';
			header("Content-disposition: attachment; filename=".$fileName);
	    header("Content-Type: application/force-download");
		header("Content-Transfer-Encoding: application/zip;\n");
		header("Pragma: no-cache");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0, public");
		header("Expires: 0");

			$zip = new ZipArchive;
			 $result_zip = $zip->open("upload/".$fileName, ZipArchive::CREATE); 
			if ($result_zip === TRUE) 
			{

					if ($_REQUEST['frmDate'] != "" && $_REQUEST['toDate'] != "") {
					    $frmDate = $_REQUEST["frmDate"];
					    $toDate = $_REQUEST["toDate"];

					    $from_dt_split=explode("-",$frmDate);
					    $frm_year=$from_dt_split[0];
					    $frm_month=$from_dt_split[1];

					    $to_dt_split=explode("-",$toDate);
					    $to_year=$to_dt_split[0];
					    $to_month=$to_dt_split[1];
					    if($frm_month==$to_month && $frm_year==$to_year)
					    {
					    	$senddtlstable = "az_sendnumbers" .$frm_year.$frm_month;
					    	$extraWhere = "WHERE  userids = {$download_userid} and schedule_sent=1 and (date(sent_at) BETWEEN '" . $frmDate . "' AND '" . $toDate . "')";

					
					    }

					}

					/*$total_rows=$_REQUEST['total_rows'];
					$last_page = ceil($total_rows/100000);
					$start = 0;
					$file_number = 0;

					for($count=0;$count<$last_page;$count++)
					{*/
						$date = date('Ymdhims');
						$csfilename ='upload/SEND_JOB_'.$date.'.csv';
					 $query = "SELECT sent_at,userids,msg_job_id,route,msgdata,char_count,msgcredit,mobile_number,status,err_code from $senddtlstable $extraWhere order by RAND()";
					 /*ORDER BY sent_at desc limit $start,100000;*/ 
					$output = "";
					$sql = mysqli_query($dbc,$query);
					if(mysqli_num_rows($sql) > 0) {
						$total_rows=mysqli_num_rows($sql);

						

						 $query1="";
						//$columns_total = mysqli_num_fields($sql);
						$arr = array('Date','User','Job ID','Message','Chars','Route','Bill Credit','Mobile Number','Status', 'Error Code');
						for ($i = 0; $i < count($arr); $i++) 
						{
							//$heading = mysql_field_name($sql, $i);
							$heading = $arr[$i];
							$output .= '"'.$heading.'",';
						}
						$output .="\n";

						while ($row = mysqli_fetch_array($sql)) 
						{
							 $num = $row['mobile_number'];
							 $userids = $row['userids'];
							 $username=$userids;
							/* $username=get_username($userids); */
							$sent_date=$row['sent_at'];
							$msg_job_id=$row['msg_job_id'];
							$msgdata=$row['msgdata'];
							$char_count=$row['char_count'];
							
							$msg_credit = $row['msgcredit'];
							$route = $row['route'];
							
							
							$status = $row['status'];
							$err_code = $row['err_code'];
							$data = array($sent_date,$username,$msg_job_id,$msgdata,$char_count,$route,$msg_credit,$num,$status,$err_code);
							for ($i = 0; $i < count($data); $i++) 
							{
								$output .='"'.escape_csv_value($data["$i"]).'",';
							}
							$output .="\n";
						}
						$fh = fopen($csfilename, 'w') or die("Can't open file");
						 $stringData = $output;
						fwrite($fh, $stringData);
						fclose($fh);
						$zip->addFile($csfilename);
						$zip->close();
						/*$start=$start+100000;*/
						
					//}
				}
				$zip->close();
				//readfile("upload/".$fileName);  

				 //$file_name = basename($url);
      
			   /* if (file_put_contents("upload/".$fileName, file_get_contents("upload/".$fileName)))
			    {
			        echo "File downloaded successfully";
			    }
			    else
			    {
			        echo "File downloading failed.";
			    }
				//exit;*/

			}
			 $full_filepath=$web_url."/controller/upload/".$fileName;

			header("Content-type: application/x-file-to-save"); 
			header("Content-Disposition: attachment; filename=".basename($full_filepath));
			ob_end_clean();
			readfile($full_filepath);
			exit;

			/*header("Content-type: application/x-file-to-save"); 
			header("Content-disposition: attachment; filename=".basename($full_filepath));
		
		    header("Content-Type: application/force-download");
		    header("Content-Length: " . filesize($full_filepath));
			/*header("Content-Transfer-Encoding: application/zip;\n");
			header('Content-Transfer-Encoding: binary');
			header('Accept-Ranges: bytes');
			header("Pragma: no-cache");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0, public");
			header("Expires: 0");
			ob_end_clean();
			readfile($full_filepath);
			flush();*/

			/*header("Content-disposition: attachment; filename=".$fileName);
		
		    header("Content-Type: application/force-download");
		    header("Content-Length: " . filesize($fileName));
			/*header("Content-Transfer-Encoding: application/zip;\n");
			header('Content-Transfer-Encoding: binary');
			header('Accept-Ranges: bytes');
			header("Pragma: no-cache");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0, public");
			header("Expires: 0");
			ob_end_clean();
			flush();*/


	}
}


 function escape_csv_value($value) {
    if(empty($value)) return;
    $value = str_replace('"', '""', $value); // First off escape all " and make them ""
    if(strpos(',', $value) or strpos("\n", $value) or strpos('"', $value)) { // Check if I have any commas or new lines
        return '"'.$value.'"'; // If I have new lines or commas escape them
    } else {
        return $value; // If no new lines or commas just return the value
    }
}


function get_username($uid)
{
	global $dbc;
	$sql="select * from az_user where userid='".$uid."'";

	$result=mysqli_query($dbc,$sql);
	while ($row=mysqli_fetch_array($result)) {
		$uname=$row['client_name'];
	}

	return $uname;
}