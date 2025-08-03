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


update_master_table();
    function update_master_table()
    {

        global $dbc;
        $sent_sms='sent_sms';
        $sendtabledetals = SENDSMSDETAILS;
        
    $QuerySelect= "SELECT `smsc_id`,`time`,`msgdata`,`dlr_url` FROM $sent_sms WHERE update_dlr=0 and `momt`='DLR' order by sql_id desc limit 10000";
                $result = mysqli_query($dbc, $QuerySelect);
              //  echo mysqli_num_rows($result);

                 if (mysqli_num_rows($result) > 0) {

                      while ($row = mysqli_fetch_array($result)) {
                          //$data['smsc_id'] = $row[0];
                          $data['time']   =  $row[1];
                          //$data['msgdata']   =  $row[2];
                          $dlr_id=$row[3];
                          //echo "<br>";
                          $msgdata=$row[2];//$data['msgdata'];
                          $smsc_id=$row[0];//$data['smsc_id'];
                          $gateway_id=fetch_gateway_id($smsc_id);
                          if(strpos($msgdata, 'NACK')!==false)
                          {
                             $stat="Failed";
                             $err="045";
                             //$stat=getDlrStatusDetails($gateway_id, $err);
                          }
                          else
                          {
                                $err_split=explode("err%3A", $msgdata);
                                $err_split2=explode("+",trim($err_split[1]));
                                $err=trim($err_split2[0]);
                                $stat=getDlrStatusDetails($gateway_id, $err);
                          }
                     

                           $queryUpdate="Update $sendtabledetals set service_id='$smsc_id',err_code='$err',status='$stat' where id=$dlr_id";                           
                            if(mysqli_query($dbc,$queryUpdate))
                            {
                               /* if($stat=='Delivered')
                                {*/
                                   /* $sql_select_master="select `msg_job_id` from $sendtabledetals where id=$dlr_id";
                                    $rs_select=mysqli_query($dbc,$sql_select_master);
                                    $row_select=mysqli_fetch_array($rs_select);
                                    $master_job_id=$row_select['msg_job_id'];

                                    if(!in_array($master_job_id,$msg_job_id))
                                    {
                                        $msg_job_id[]=$master_job_id;
                                    }*/
                                   

                                 $queryUpdatedlr="Update sent_sms set update_dlr=1 where dlr_url=$dlr_id";
                                 mysqli_query($dbc,$queryUpdatedlr);
                                //echo "success id $dlr_id";
                            }
                            else
                            {
                                 echo mysqli_error($dbc);
                            }
                      }

            }
            else
            {
                 // echo "DLR Not received Yet for dlr url".$dlr_url[$i];
            }

     //}


            //$msg_job_id=array_unique($msg_job_id);
   /*  if(!empty($msg_job_id))
     {
        $msg_job_ids=array_unique($msg_job_id);
       
        foreach ($msg_job_ids as $job_id) 
        {
           $sql_count_cut_off="select `userids`,`route` from $sendtabledetals where msg_job_id='$job_id' and cut_off='Yes' limit 1";
            $rs_count_cut_off=mysqli_query($dbc,$sql_count_cut_off);
            $count_cut_off=mysqli_num_rows($rs_count_cut_off);
           
           
           
            if($count_cut_off>0)
            {

            $sql_cut_off_status="select status,count(status),err_code from $sendtabledetals where msg_job_id='$job_id' and cut_off='No' group by status";
            $rs_cut_off_status=mysqli_query($dbc,$sql_cut_off_status);
            $count_cut_off_status=mysqli_num_rows($rs_cut_off_status);


            if($count_cut_off_status>1)
            {
                while($row_cut_off_status=mysqli_fetch_array($rs_cut_off_status)) {
                    $statuss[]=$row_cut_off_status['status'];
                    $err_code_arr[]=$row_cut_off_status['err_code'];
                }

                    if(in_array('Delivered',$statuss))
                    {
                           while($row_cut_off=mysqli_fetch_array($rs_count_cut_off))
                            {
                                $userid=$row_cut_off['userids'];
                                $route=trim($row_cut_off['route']);

                                $sql_route="select `az_routeid` from az_routetype where az_rname='".$route."' limit 1";
                                $rs_route=mysqli_query($dbc,$sql_route);
                                $row_route=mysqli_fetch_array($rs_route);
                                $route_id=$row_route['az_routeid'];
                                $sql_cutoff="select cut_off_status,error_code from cut_off_dtls where userid='".$userid."' and cut_off_route='".$route_id."' limit 1";
                                $rs_cutoff=mysqli_query($dbc,$sql_cutoff);

                                $count_cutoff=mysqli_num_rows($rs_cutoff);
                                if($count_cutoff>0)
                                {
                                $row_cutoff=mysqli_fetch_array($rs_cutoff);

                                $cut_off_status=$row_cutoff['cut_off_status'];
                                $cut_off_error_code=$row_cutoff['error_code'];
                                $update_master_table_cutoff="update $sendtabledetals set status='$cut_off_status',err_code='$cut_off_error_code' where msg_job_id='".$job_id."' and cut_off='Yes'";
                                mysqli_query($dbc,$update_master_table_cutoff);
                                continue 2;
                                }

                            }
                             /*status=delivered
                    }
                    else
                    {
                            $status=$statuss[0];
                            $err_code=$err_code_arr[0];
                        while($row_cut_off=mysqli_fetch_array($rs_count_cut_off))
                            {
                                $userid=$row_cut_off['userids'];
                                $route=trim($row_cut_off['route']);

                                $sql_route="select `az_routeid` from az_routetype where az_rname='".$route."' limit 1";
                                $rs_route=mysqli_query($dbc,$sql_route);
                                $row_route=mysqli_fetch_array($rs_route);
                                $route_id=$row_route['az_routeid'];
                                $sql_cutoff="select cut_off_status,error_code from cut_off_dtls where userid='".$userid."' and cut_off_route='".$route_id."' limit 1";
                                $rs_cutoff=mysqli_query($dbc,$sql_cutoff);

                                $count_cutoff=mysqli_num_rows($rs_cutoff);
                                if($count_cutoff>0)
                                {
                                $row_cutoff=mysqli_fetch_array($rs_cutoff);

                                $cut_off_status=$status;
                                $cut_off_error_code=$err_code;
                                $update_master_table_cutoff="update $sendtabledetals set status='$cut_off_status',err_code='$cut_off_error_code' where msg_job_id='".$job_id."' and cut_off='Yes'";
                                mysqli_query($dbc,$update_master_table_cutoff);
                                continue 2;
                                }

                            }
                    }


                
            }
            else
            {
                   while($row_cut_off_status=mysqli_fetch_array($rs_cut_off_status)) {
                    $status=$row_cut_off_status['status'];
                    $err_code=$row_cut_off_status['err_code'];
                           while($row_cut_off=mysqli_fetch_array($rs_count_cut_off))
                            {
                                $userid=$row_cut_off['userids'];
                                $route=trim($row_cut_off['route']);

                                $sql_route="select `az_routeid` from az_routetype where az_rname='".$route."' limit 1";
                                $rs_route=mysqli_query($dbc,$sql_route);
                                $row_route=mysqli_fetch_array($rs_route);
                                $route_id=$row_route['az_routeid'];

                                    $cut_off_status=$status;
                                    $cut_off_error_code=$err_code;
                                    $update_master_table_cutoff="update $sendtabledetals set status='$cut_off_status',err_code='$cut_off_error_code' where msg_job_id='".$job_id."' and cut_off='Yes'";
                                    mysqli_query($dbc,$update_master_table_cutoff);

                                    

                            }
                           
                    


                    }
            }
             
            }
        }
        
     }*/

        
         
      
        
}


    function getDlrStatusDetails($gateway_id, $err_code) {
        global $dbc;
        if ($err_code != "") {
            $q = "SELECT `err_status` FROM tbl_errorcode WHERE gateway_id = '{$gateway_id}' AND err_code = '{$err_code}'";
            $rs = mysqli_query($dbc, $q);
            if (mysqli_num_rows($rs) > 0) {
                $out = mysqli_fetch_assoc($rs);
                $status = $out['err_status'];
            } else {
                $status = 'Other';
            }
        } else {
            $status = 'Submitted';
        }
        return $status;
    }

    function fetch_gateway_id($smsc_id) {
        global $dbc;
        if ($smsc_id != "") {
            $q = "SELECT `gateway_id` FROM az_sms_gateway WHERE smsc_id = '{$smsc_id}'";
            $rs = mysqli_query($dbc, $q);
            if (mysqli_num_rows($rs) > 0) {
                $out = mysqli_fetch_assoc($rs);
                $gateway_id = $out['gateway_id'];
            } 
        }
        return $gateway_id;
    }

 ?>
