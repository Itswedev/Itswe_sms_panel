<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$log_file = "/var/log/php_errors.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);

/*error_reporting(0);*/
include('/var/www/html/itswe_panel/include/connection.php');

include("/var/www/html/itswe_panel/include/config.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 global $dbc;
        $sendtabledetals = 'smart_cutoff';
       /* $sendtabledetals = SENDSMSDETAILS;
        $today_dt=date('Y-m-d');
        $status='Delivered';
		$err_code='000';
 $update_master_tbl="update $sendtabledetals set status='$status',err_code='$err_code' where cut_off='Yes' and status='Submitted' and schedule_sent=1 and date(sent_at)='$today_dt' and route!='PROMO' limit 30000";
mysqli_query($dbc,$update_master_tbl);*/
update_cutoff_status();
    function update_cutoff_status()
    {

        global $dbc;
        echo date('Y-m-d h:i');
        // $sendtabledetals = 'smart_cutoff';
        $sendtabledetals = SENDSMSDETAILS;
       	$today_dt=date('Y-m-d');
        //$today_dt='2023-01-21';
        
    	 $QuerySelect= "SELECT `job_id` FROM `smart_cutoff` WHERE  date(created_date)='$today_dt' ";

       // $QuerySelect= "SELECT `msg_job_id` FROM $sendtabledetals WHERE `status`='Submitted' and `cut_off`='Yes' and date(sent_at)='$today_dt' and schedule_sent=1 and `msg_job_id` order by id desc limit 20";
    	
        $result = mysqli_query($dbc, $QuerySelect);

         if (mysqli_num_rows($result) > 0) 
         {
            while ($row = mysqli_fetch_array($result)) {
                $msg_job_ids[]=$row[0];

            }
         }
/*
         print_r($msg_job_ids);
         exit();*/

         $msg_job_ids=array_unique($msg_job_ids);
    	/*print_r($msg_job_ids);*/
        if(!empty($msg_job_ids))
         {
	        
		        $job_id=implode(',', array_map(function($val){return sprintf("'%s'", $val);}, $msg_job_ids));
				

				//echo $randomString;

	         	/*print_r($msg_job_id);*/
		         $sql_cut_off_status="select status,err_code,msg_job_id from $sendtabledetals where msg_job_id in ($job_id) and cut_off='No' and status='Delivered' and schedule_sent=1 group by msg_job_id";
		         
		            $rs_cut_off_status=mysqli_query($dbc,$sql_cut_off_status);
		            $count_cut_off_status=mysqli_num_rows($rs_cut_off_status);

		            if($count_cut_off_status>0)
		            { 
	                 while($row=mysqli_fetch_array($rs_cut_off_status))
		                 {
		                 	$status='Delivered';
		                 	$err_code='000';
		                 	$msg_job_id_update=$row['msg_job_id'];
							$msg_id = " | msg_id: ".substr(bin2hex(random_bytes(16)), 0, 8) . '-' .
							 substr(bin2hex(random_bytes(8)), 0, 4) . '-' .
							 substr(bin2hex(random_bytes(8)), 0, 4) . '-' .
							 substr(bin2hex(random_bytes(8)), 0, 4) . '-' .
							 substr(bin2hex(random_bytes(16)), 0, 12);

		                 	$update_master_tbl="update $sendtabledetals set status='$status',err_code='$err_code',master_job_id = concat(master_job_id,'".$msg_id."') where msg_job_id='$msg_job_id_update' and cut_off='Yes' and status='Submitted' and schedule_sent=1 ";
		                 	mysqli_query($dbc,$update_master_tbl);
		                 	echo "\n";
		                 }  
		            }
		            else
		            {
		            	
		            	 $sql_cut_off_status="select status,err_code,msg_job_id from $sendtabledetals where msg_job_id in ($job_id) and cut_off='No' and status!='Delivered' group by msg_job_id";
		           		 $rs_cut_off_status=mysqli_query($dbc,$sql_cut_off_status);
		           		 while($row=mysqli_fetch_array($rs_cut_off_status))
		           		 {
		           		 	$status=$row['status'];
		           		 	$err_code=$row['err_code'];
		           		 	$msg_job_id_update=$row['msg_job_id'];
							$msg_id = " | msg_id: ".substr(bin2hex(random_bytes(16)), 0, 8) . '-' .
								substr(bin2hex(random_bytes(8)), 0, 4) . '-' .
								substr(bin2hex(random_bytes(8)), 0, 4) . '-' .
								substr(bin2hex(random_bytes(8)), 0, 4) . '-' .
								substr(bin2hex(random_bytes(16)), 0, 12);

		           		 	$update_master_tbl="update $sendtabledetals set status='$status',err_code='$err_code',master_job_id = concat(master_job_id,'".$msg_id."') where msg_job_id='$msg_job_id_update' and cut_off='Yes' and status='Submitted' and schedule_sent=1";
		           		 	mysqli_query($dbc,$update_master_tbl);
		           		 	echo "\n";
		           		 	
		           		 }

		           		// mysqli_query($dbc,$update_master_tbl);
		           		 
		            }
   		}
    }

?>
