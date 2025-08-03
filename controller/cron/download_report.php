<?php
// session_start();


ini_set('zlib.output_compression', 'Off');
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
// ini_set('error_log', $log_file);


// error_reporting(0);
include('/var/www/html/itswe_panel/include/connection.php');
require('/var/www/html/itswe_panel/controller/classes/ssp.class.php');
include('/var/www/html/itswe_panel/include/config.php');
require '/var/www/html/itswe_panel/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
download_report();

function download_report()
{
    global $dbc;
    $today_dt=date('Y-m-d');
    $sql="select * from download_queue where status='queued' and date(created_date)='".$today_dt."' limit 2";

    $result=mysqli_query($dbc,$sql)or die(mysqli_error($dbc));
    $row_count=mysqli_num_rows($result);

    if($row_count>0)
    {
        while($row=mysqli_fetch_array($result))
        {
            $id=$row['id'];
            $sql_update="update download_queue set status='processing' where id=$id";
            $result_update=mysqli_query($dbc,$sql_update);
            
            $userid=$row['userid'];
            $sql_user="select restricted_tlv,restricted_report from az_user where userid=$userid";
            $result_user=mysqli_query($dbc,$sql_user);

            while($row_user=mysqli_fetch_array($result_user))
					{
						$restricted_tlv=$row_user['restricted_tlv'];
                        $restricted_report=$row_user['restricted_report'];
					}


            $from_date=$row['from_date'];
            $to_date=$row['to_date'];
            $file_name=$row['file_name'];
            $extraWhere=$row['extrawhere'];
            $extraWhere=urldecode($extraWhere);

            $from_dt_split=explode("-",$from_date);
		    $frm_year=$from_dt_split[0];
		    $frm_month=$from_dt_split[1];

		    $to_dt_split=explode("-",$to_date);
		    $to_year=$to_dt_split[0];
		    $to_month=$to_dt_split[1];
		    $sendtabledetals=SENDSMSDETAILS .$frm_year.$frm_month;
            $full_path="/var/www/html/itswe_panel/controller/upload/".$file_name;
           
            $sql_cnt="select count(1) as total_records from $sendtabledetals sn where $extraWhere  limit 1";
				
				 

					$result_count=mysqli_query($dbc,$sql_cnt);
					
					//$count=mysqli_num_rows($result_count);

					$total_records=0;
					$total_records_bill=0;
					while($row_cnt=mysqli_fetch_array($result_count))
					{
						$record_count=$row_cnt['total_records'];
					}
                    
            if($record_count>0)
            {

                $path="/var/www/html/itswe_panel/controller/";
                $zip = new ZipArchive;
                $download_path="Report/";
                $result_zip = $zip->open($full_path, ZipArchive::CREATE | ZipArchive::OVERWRITE);
                //echo $result_zip;
         
                if ($result_zip === TRUE) 
                {

                    $file_count=ceil($record_count/900000);
                    $start=0;
						for($j=1;$j<=$file_count;$j++)
						{

							$date = date('Ymdhims');
				   			//$path="/var/www/html/itswe_panel/controller/upload/";
				   		    $csfilename ='upload/SEND_JOB_NEW_'.$date.'.xls';
								//$csfilename ='SEND_JOB_NEW_'.$date.'.csv';
				   		    $full_path = $path.$csfilename;
				   		    $fh = fopen($full_path, 'w') or die("Can't open file");
				   		    chmod($full_path, 0777);
                            // $record_query = "SELECT 
                            // DATE_FORMAT(sn.sent_at, '%Y-%m-%d %H:%i:%s') AS 'Job Date',
                            
                            // u.user_name AS 'Username',
                            // CONCAT('\'\\\'', SUBSTRING_INDEX(sn.metadata, 'TID=', -1), '\'\\\'') AS 'Template ID',
                            // sn.master_job_id AS 'Job ID',
                            // sn.char_count AS 'Chars',
                            // sn.route AS 'Route',
                            // sn.senderid AS 'Sender ID',
                            // sn.msgcredit AS 'Bill Credit',
                            // sn.mobile_number AS 'Mobile Number',
                            // sn.status AS 'Status',
                            // sn.err_code AS 'Error code',
                            // sn.msgdata AS 'Message',
                            // DATE_FORMAT(FROM_UNIXTIME(sn.delivered_date), '%Y-%m-%d %H:%i:%s') AS 'DLR Time'
                
                            //  FROM  $sendtabledetals sn
                            //  JOIN 
                            //     az_user u ON sn.userids = u.userid
                            
                            //  WHERE $extraWhere
                            //  LIMIT $start, 900000";	

                            // Construct the dynamic part for Template ID
                            $template_id_query = $restricted_tlv === 'Yes' ? "
                            CONCAT(
                                SUBSTRING(
                                    SUBSTRING_INDEX(sn.metadata, 'TID=', -1),
                                    1,
                                    LENGTH(SUBSTRING_INDEX(sn.metadata, 'TID=', -1)) - 6
                                ),
                                'xxxxxx'
                            )" : "SUBSTRING_INDEX(sn.metadata, 'TID=', -1)";

                            // Construct the dynamic part for Mobile Number
                            $mobile_query = $restricted_report === 'Yes' ? "
                            CONCAT(
                                SUBSTRING(sn.mobile_number, 1, LENGTH(sn.mobile_number) - 6),
                                'xxxxxx'
                            )" : "sn.mobile_number";

                            // Construct the final query
                            $record_query = "
                            SELECT 
                                DATE_FORMAT(sn.sent_at, '%Y-%m-%d %H:%i:%s') AS 'Job Date',
                                u.user_name AS 'Username',
                                CONCAT('\'\\\'', $template_id_query, '\'\\\'') AS 'Template ID',
                                sn.master_job_id AS 'Job ID',
                                sn.char_count AS 'Chars',
                                sn.route AS 'Route',
                                sn.senderid AS 'Sender ID',
                                sn.msgcredit AS 'Bill Credit',
                                $mobile_query AS 'Mobile Number',
                                sn.status AS 'Status',
                                sn.err_code AS 'Error code',
                                sn.msgdata AS 'Message',
                                DATE_FORMAT(FROM_UNIXTIME(sn.delivered_date), '%Y-%m-%d %H:%i:%s') AS 'DLR Time'
                            FROM $sendtabledetals sn
                            JOIN az_user u ON sn.userids = u.userid
                            WHERE $extraWhere
                            LIMIT $start, 900000
                            ";


                             $cmd='echo "'.$record_query.'" | mysql -h localhost -u vapio -p"NcbagqPkhdt#^98ajtd" "vapio"  > "'.$full_path.'"';

                                            $last=shell_exec($cmd);
                                               
                                            chmod($full_path, 0777);
                                           
                                            $start=$start+900000;
                
                                            $zip->addFile($full_path,$csfilename);
                        }
                }
                $zip->close();
            }
            $sql_update="update download_queue set status='completed' where id=$id";
            $result_update=mysqli_query($dbc,$sql_update);

            echo "Record downloaded for id $id";
            

        }
    }
}


?>