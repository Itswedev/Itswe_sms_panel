<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once('../include/connection.php');

include('../include/config.php');


global $dbc;

$sent_sms='sent_sms';
        $sendtabledetals = SENDSMSDETAILS;
        
    $QuerySelect= "SELECT receiver, msgdata, smsc_id, dlr_url, dlr_mask FROM $sent_sms WHERE  `momt`='DLR' and dlr_mask in (1,2,16) order by sql_id desc limit 100";
                $result = mysqli_query($dbc, $QuerySelect);
              //  echo mysqli_num_rows($result);

                 if (mysqli_num_rows($result) > 0) {

                      while ($row = mysqli_fetch_array($result)) {
                      	 $num = $row["receiver"];
                    $msgdata1 = $row["msgdata"];
             $msgdata1 = str_replace("'", "", $msgdata1);
           $msgdata1 = utf8_decode(urldecode($msgdata1));
          	
                    //$scode = num.substring(2, 7);
                    $dlr_url = $row["dlr_url"];
                    $smsc_id = $row["smsc_id"];
                /* echo $strlen = strlen($msgdata1);
                 echo "<br>";*/
                 $dndstatus = 0;
                 $dlr_mask=$row['dlr_mask'];

                 $msgdata=explode(" ",$msgdata1);


                 echo $error_code=str_replace("err:","",$msgdata[8]);
                 echo "<br>";
                 	    /* if($dlr_mask == 8 || $dlr_mask == 16) {
                        $ary[] = explode("/", $msgdata1);
                       	print_r($ary);
                       	$status_id = 2;
                        $status = "Failed";
                        if($strlen > 50){
                            if ($ary[1] != null) {
                                $err = $ary[1].substring(7);
                                if("384"==$err && "azqSCB"==$smsc_id) {
                                    $dndstatus = 1;
                                    $status = "DNDFailed";
                                    //refundDNDCredit(dlr_url, smsc_id);
                                }
                            }
                        }


                    }*/
           }
       }



?>
