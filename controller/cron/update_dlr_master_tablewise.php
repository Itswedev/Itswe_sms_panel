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
        $sent_sms='sent_sms_13122022';
        $sendtabledetals = SENDSMSDETAILS;
        
        $sql_master="select master_tbl.id as master_id from az_sendnumbers as master_tbl inner join sent_sms_13122022 as sent_tbl on master_tbl.id=sent_tbl.dlr_url where date(master_tbl.sent_at)='2022-12-13' and master_tbl.status='Submitted' and master_tbl.userids='4682' and master_tbl.cut_off='No' and sent_tbl.momt='DLR' limit 25000";

        $result_master = mysqli_query($dbc, $sql_master);
           echo  $cnt=mysqli_num_rows($result_master);
                 if (mysqli_num_rows($result_master) > 0) {
                      while ($row_master = mysqli_fetch_array($result_master)) {

                        $master_id=$row_master['master_id'];
     $QuerySelect= "SELECT `smsc_id`,`time`,`msgdata`,`dlr_url` FROM $sent_sms WHERE update_dlr=0 and `momt`='DLR' and dlr_url='$master_id'";

    echo "<br>";
                $result = mysqli_query($dbc, $QuerySelect);
              mysqli_num_rows($result);
            
            
                 if (mysqli_num_rows($result) > 0) {
                      while ($row = mysqli_fetch_array($result)) {
                          //$data['smsc_id'] = $row[0];
                         $data['time']   =  $row[1];
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
                                 $queryUpdatedlr="Update $sent_sms set update_dlr=1 where dlr_url=$dlr_id";
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
                 echo "DLR Not received Yet for dlr url";
            }

          }
        }

        
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
