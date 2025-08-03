<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once('../../include/connection.php');




update_master_table(42);
    function update_master_table($dlr_url)
    {

        global $dbc;
        $sent_sms='sent_sms';
        
     $QuerySelect= "SELECT `smsc_id`,`time`,`msgdata` FROM $sent_sms WHERE `dlr_url` = $dlr_url and `momt`='DLR'";

    
        $result = mysqli_query($dbc, $QuerySelect);
         
       echo "Count ".mysqli_num_rows($result);
       if (mysqli_num_rows($result) > 0) {

            while ($row = mysqli_fetch_array($result)) {

                $data['smsc_id'] = $row[0];
                $data['time']   =  $row[1];
                $data['msgdata']   =  $row[2];
            }



                    $msgdata=$data['msgdata'];
       $msgdata_arr=explode("+",$msgdata);
       print_r($msgdata_arr);

       $smsc_id=$data['smsc_id'];
       $status=$msgdata_arr[7];
       $err_code=$msgdata_arr[8];
       if($status=='stat%3ADELIVRD')
       {
            $stat="Delivered";
       }

        if($err_code=='err%3A000')
       {
            $err="000";
       }

        //print_r($data);
     
     
      $queryUpdate="Update az_sendnumbers202201 set service_id='$smsc_id',err_code='$err',status='$stat' where id=$dlr_url";
           if(mysqli_query($dbc,$queryUpdate))
           {
                echo "Updated Successfully";
           }
           else
           {
                echo mysqli_error($dbc);
           }


       }
       else
       {
            echo "DLR Not received Yet";
       }
        
}

 ?>