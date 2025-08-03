<?php 
session_start();
ob_start();
$log_file = "../error/logfiles/sender_id_function.log";
// require '../vendor/autoload.php';
// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
 error_reporting(E_ALL); 
 
// setting error logging to be active
ini_set("log_errors", TRUE); 
  
// setting the logging file in php.ini
ini_set('error_log', $log_file);
error_reporting(0);
include_once('../include/connection.php');
include_once('../include/config.php');
require('classes/ssp.class.php');
include_once('controller/classes/last_activities.php');
include_once('../include/datatable_dbconnection.php');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
$sender_type=@$_REQUEST['sender_type'];

if (isset($_POST['export']) && $_POST['export'] === 'excel') {
     
 
    

    $table = SENDERID;

    $primaryKey = 'sid';

    $login_user=$_SESSION['user_id'];

    global $sql_details ;
    $extraWhere="";

    $userid=$_SESSION['user_id'];
    
    $user_role=$_SESSION['user_role'];
    if($user_role!='mds_adm')
    {
        if($extraWhere!="")
        {
            $extraWhere=" and userid='$userid'";
        }
        else
        {
            $extraWhere=" userid='$userid'";
        }
    }
    else{
        $extraWhere=1;
    }
   


     $sql="select * from $table where ".$extraWhere;

    $result = mysqli_query($dbc, $sql);

    $data = [];
   
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $row_utf8 = array_map('utf8_encode', $row);
            $data[] = $row_utf8;
        }
    }
// Output JSON

// // Create new Spreadsheet object
// $spreadsheet = new Spreadsheet();

// // Set document properties
// $spreadsheet->getProperties()
//     ->setCreator("Your Name")
//     ->setLastModifiedBy("Your Name")
//     ->setTitle("Data")
//     ->setSubject("Data")
//     ->setDescription("Data")
//     ->setKeywords("Data")
//     ->setCategory("Data");

// // Get active sheet
// $sheet = $spreadsheet->getActiveSheet();

// // Set data
// $sheet->fromArray($data, NULL, 'A1');

// // Auto size columns
// foreach(range('A', $sheet->getHighestDataColumn()) as $col) {
//     $sheet->getColumnDimension($col)->setAutoSize(true);
// }


// // Save Excel file to a variable
// $writer = new Xlsx($spreadsheet);
// $writer->setPreCalculateFormulas(false);
// ob_start();
// $writer->save('php://output');
// $excelOutput = ob_get_clean();

// // Send headers
// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// header('Content-Disposition: attachment;filename="data.xlsx"');
// header('Cache-Control: max-age=0');

// // Output the Excel file
// echo $excelOutput;
// exit;    
}


if($sender_type=='all')
{
	 ListSenderid($id , $senderid , $start , $end );
}
else if($sender_type=='all_senderid')
{
    $table = SENDERID;

            $primaryKey = 'sid';

            $login_user=$_SESSION['user_id'];

            if($login_user!=1)
            {
                $columns = array(
                        array( 'db' => 'senderid','dt' => 0 ),
                    array( 'db' => 'pe_id','dt' => 1,'formatter'=>function($d,$row)
                    {
                         
                            global $restricted_tlv;
                           
                                    if($restricted_tlv=='Yes')
                                    {
                                        $count_len=strlen($d);
                                        return substr($d, 0, $count_len-6)."XXXXXX";
                                    } 
                                    else
                                    {
                                         return $d;
                                    }
                    }),
                    array( 'db' => 'header_id','dt' => 2 ),
                    array( 'db' => 'descript','dt' => 3 ),
                    array( 'db' => 'created_at','dt' => 4 ),
                    array( 'db' => 'status','dt' => 5,'formatter' => function( $d, $row ) {

                                if($d=='1')
                                    {
                                        $color="#5e6e82";
                                        $stat="Active";
                                    }
                                    else
                                    {
                                        $color="red";
                                        $stat="Inactive";
                                    }

                                    return "<span style='color:$color;'>".$stat."</span>";

                    } ),
                    array( 'db' => 'sid','dt' => 6,'formatter' => function( $d, $row ) {
                       
                       $id=$d;
                       $senderid=$row[0];
                       $pe_id=$row[1];
                       $header_id=$row[2];
                       $descript=$row[3];
                       $status=$row[5];
                            $action="<button class='btn btn-primary me-1 mb-1 edit_senderid_btn' type='button' data-bs-toggle='modal' data-bs-target='#edit_sender_id' data-id='".$id."'
                    data-senderid='".$senderid."' data-peid='".$pe_id."'  data-status='".$status."' data-headerid='".$header_id."' data-descript='".$descript."'>
                    <i class='fa fa-pencil'></i>
                    </button>&nbsp;<button class='btn btn-primary me-1 mb-1 delete_btn' type='button' data-id='".$id."'>
                    <i class='fa fa-trash'></i>
                    </button>";
                            return $action;
                        })
                   
                );
        }
        else
        {
             $columns = array(
                 array( 'db' => 'userid','dt' => 0,'formatter' => function( $d, $row ) {
                                   $username=get_username($d);
                        return $username;

                    }),
                        array( 'db' => 'senderid','dt' => 1 ),
                    array( 'db' => 'pe_id','dt' => 2),
                    array( 'db' => 'header_id','dt' => 3 ),
                    array( 'db' => 'descript','dt' => 4 ),
                    array( 'db' => 'created_at','dt' => 5 ),
                    array( 'db' => 'status','dt' => 6,'formatter' => function( $d, $row ) {

                                if($d=='1')
                                    {
                                        $color="#5e6e82";
                                        $stat="Active";
                                    }
                                    else
                                    {
                                        $color="red";
                                        $stat="Inactive";
                                    }

                                    return "<span style='color:$color;'>".$stat."</span>";

                    } ),
                    array( 'db' => 'sid','dt' => 7,'formatter' => function( $d, $row ) {
                       
                       $id=$d;
                       $senderid=$row[1];
                       $pe_id=$row[2];
                       $header_id=$row[3];
                       $descript=$row[4];
                       $status=$row[6];
                            $action="<button class='btn btn-primary me-1 mb-1 edit_senderid_btn' type='button' data-bs-toggle='modal' data-bs-target='#edit_sender_id' data-id='".$id."'
                    data-senderid='".$senderid."' data-peid='".$pe_id."'  data-status='".$status."' data-headerid='".$header_id."' data-descript='".$descript."'>
                    <i class='fa fa-pencil'></i>
                    </button>&nbsp;<button class='btn btn-primary me-1 mb-1 delete_btn' type='button' data-id='".$id."'>
                    <i class='fa fa-trash'></i>
                    </button>";
                            return $action;
                        })
                   
                );
        }
             
            // SQL server connection information
            /*$sql_details = array(
                'user' => 'kannel',
                'pass' => 'mds321321',
                'db'   => 'itswe_client',
                'host' => '3.110.189.171'
            );
*/

            
             global $sql_details ;
            $extraWhere="";

            $userid=$_SESSION['user_id'];
            
            $user_role=$_SESSION['user_role'];
            if($user_role!='mds_adm')
            {
                if($extraWhere!="")
                {
                    $extraWhere=" and userid='$userid'";
                }
                else
                {
                    $extraWhere=" userid='$userid'";
                }
            }
           
            echo json_encode(
                SSP::complex( $_REQUEST, $sql_details, $table, $primaryKey, $columns,$test=null,$extraWhere )
            );

}
else if($sender_type=='all_senderid_download')
{
    $table = SENDERID;

            $primaryKey = 'sid';

            $login_user=$_SESSION['user_id'];
            $login_role=$_SESSION['user_role'];
             
            global $dbc ;
            $extraWhere="";
            $userid=$_SESSION['user_id'];
            $user_role=$_SESSION['user_role'];
            if($user_role!='mds_adm')
            {
                if($extraWhere!="")
                {
                    $extraWhere=" and s.userid='$userid'";
                }
                else
                {
                    $extraWhere=" s.userid='$userid'";
                }
            }
            else{
                $extraWhere="1";
            }

            $fileName = "senderid_".time().".xls"; 
			$fields_query=" u.user_name,s.senderid,s.pe_id,s.header_id ";
			
			 $sql="select $fields_query from az_senderid s join az_user u on s.userid=u.userid where $extraWhere";

			$result=mysqli_query($dbc,$sql);
			$table="";


				$columnHeader = '';  
				$columnHeader = "Username" . "\t" . "Sender ID" . "\t". "PE ID" ."\t". "Header ID" . "\t";  
				$setData = '';  
			while($rec=mysqli_fetch_row($result))
			{
                $rowData = '';  
                
									foreach ($rec as $value) {
                                        if (is_numeric($value) && strlen($value) > 1 )
                                        {
                                            $value = '"\'' . $value . '\'"' . "\t"; 
                                        }
                                        else{
                                            $value = '"' . $value . '"' . "\t"; 
                                        }
                                       
									  $rowData .= $value;  
										  
								  }  
								  $setData .= trim($rowData) . "\n"; 
            }

            header("Content-type: application/octet-stream");  
			header("Content-Disposition: attachment; filename=$fileName");  
			header("Pragma: no-cache");  
			header("Expires: 0");  
			echo ucwords($columnHeader) . "\n" . $setData . "\n";  


}

elseif($sender_type=='load_sender_dropdown')
{
   $sender_id_dropdown= sender_id_dropdown();
   echo $sender_id_dropdown;
}


if (isset($_POST['type']) && $_POST['type'] == 'upload_sender') {
    $rs = upload_sender();
    
   echo $rs;
}

if (isset($_POST['type']) && $_POST['type'] == 'saveSenderId') {
    $rs = insert_senderid();
    if ($rs['status'] == true && $rs['msg'] == 'Success') {
        echo $rs['msg'];
        if (isset($_POST['set_as_priority']) && $_POST['set_as_priority'] == 1) {
            //mailsend($_POST['senderid']);
        }
    } else if ($rs['status'] == false && $rs['msg'] == 'Already Exists') {
        echo $rs['msg'];
        exit;
    } else if ($rs['status'] == false && $rs['msg'] == 'Error') {
        echo 'FALSE';
        exit;
    }
}
else if (isset($_POST['type']) && $_POST['type'] == 'saveuserSenderId') {
    $rs = insert_user_senderid();
    if ($rs['status'] == true && $rs['msg'] == 'Success') {
        if (isset($_POST['set_as_priority']) && $_POST['set_as_priority'] == 1) {
            //mailsend($_POST['senderid']);
        }
    } else if ($rs['status'] == false && $rs['msg'] == 'Already Exists') {
        echo $rs['msg'];
        exit;
    } else if ($rs['status'] == false && $rs['msg'] == 'Error') {
        echo 'FALSE';
        exit;
    }
}
else if (isset($_POST['type']) && $_POST['type'] == 'add_sender_block') {
    $rs = insert_block_senderid();
    if ($rs['status'] == true && $rs['msg'] == 'Success') {
       echo $rs['msg'];
       exit;
    } else if ($rs['status'] == false && $rs['msg'] == 'Already Exists') {
       echo $rs['msg'];
        exit;
    } else if ($rs['status'] == false && $rs['msg'] == 'Error') {
       echo 'FALSE';
        exit;
    }
}
else if (isset($_POST['type']) && $_POST['type'] == 'all_sender_id_block') {
    $rs = all_senderid_block();
    echo $rs;
    exit;
}
else if (isset($_POST['type']) && $_POST['type'] == 'delete_sender') {
    $rs = delete_senderid();
    if ($rs['status'] == true && $rs['msg'] == 'Success') {
       echo "Sender Details Deleted Successfully";
    } 
}
else if (isset($_POST['type']) && $_POST['type'] == 'editSenderId') {
    $rs = update_senderid();
    if ($rs['status'] == true && $rs['msg'] == 'Success') {
        if (isset($_POST['set_as_priority']) && $_POST['set_as_priority'] == 1) {
            //mailsend($_POST['senderid']);
        }
    } else if ($rs['status'] == false && $rs['msg'] == 'Error') {
        echo 'FALSE';
        exit;
    }
}
else if(isset($_POST['type']) && $_POST['type'] == 'sender_id_dropdown')
{

    $sender_id_dropdown= sender_id_dropdown();
   echo $sender_id_dropdown;

}


    function ListSenderid($id = null, $senderid = null, $start = null, $end = null) {
        global $dbc;
        $cond = 'WHERE 1';
        $ids = getUserIds();
        if (!empty($id)) {
            $cond .= " AND sid = $id";
        }
        if ($_SESSION['user_id'] != 1) {
            $cond .= " AND userid = {$_SESSION['user_id']}";
        }
        if (!empty($ids) && $ids != '' && $_SESSION['user_id'] != 1) {
            $cond .= " OR userid IN($ids)";
        }
        if (isset($senderid) && !empty($senderid)) {
            $cond .= " AND senderid LIKE '{$senderid}%'";
        }
        $limit = '';
        if (isset($start) && !empty($start) || isset($end) && !empty($end)) {
            $limit = " LIMIT  $start, $end";
        }
        //$limit = " LIMIT  $start, $end";
        $qry = "SELECT count(sid) as tot FROM az_senderid INNER JOIN az_user as user USING(userid) $cond";
        $rs1 = mysqli_query($dbc, $qry)or mysqli_error($dbc);
        $data = mysqli_fetch_assoc($rs1);
        $tot = $data['tot'];

        $sql = "SELECT az_senderid.*, user.user_name FROM az_senderid INNER JOIN az_user as user USING(userid) $cond ORDER BY sid DESC $limit";
        $result = mysqli_query($dbc, $sql);
        $senderid_out = array();
        $inc=0;
        $return_data="";
        if($tot>0)
        {
	        while ($row = mysqli_fetch_assoc($result)) {
	            $id = $row['sid'];
	            $senderid_out[$id] = $row;
                $senderid=$row['senderid'];
                $pe_id=$row['pe_id'];
                $header_id=$row['header_id'];
                $descript=$row['descript'];
	            $inc++;
	            
		        $return_data.="<tr>
	        	<td width='5%'> $inc</td>
	        	<td width='10%'> ".$row['senderid']."</td>
	        	<td width='10%'> ".$row['pe_id']."</td>
	        	<td width='10%'> ".$row['header_id']."</td>
	          	<td width='10%'> ".$row['descript']."</td>
	          	<td width='10%'> ".date('d-M-Y', strtotime($row['created_at']))."</td>
                <td width='10%'> Active</td>
                <td width='15%'>
                <input type='hidden' class='sid' value='".$id."'/>
                <button class='btn btn-primary me-1 mb-1 edit_senderid_btn' type='button' data-bs-toggle='modal' data-bs-target='#edit_sender_id' data-id='".$id."'
                data-senderid='".$senderid."' data-peid='".$pe_id."' data-headerid='".$header_id."' data-descript='".$descript."'>
                    <span class='fas fa-edit ms-1' data-fa-transform='shrink-3'></span>
                </button>&nbsp;<button class='btn btn-primary me-1 mb-1 delete_btn' type='button' data-id='".$id."'>
                    <span class='fas fa-trash ms-1' data-fa-transform='shrink-3'></span>
                </button></td>
	        	</tr>";
	        }

	        echo $return_data;

        }
        else
        {
        	echo $tot;
        }
       // return array('result' => $senderid_out, 'count' => $tot);
        //return $senderid_out;
    }

function upload_sender()
{
    global $dbc; 
    $userid=$_SESSION['user_id'];
    $user_role=$_SESSION['user_role'];

    if($user_role=='mds_adm')
    {
        $userid=$_REQUEST['selected_userid'];
    }
    $fname = explode('.', $_FILES['upload_sender']['name']);
    $filename=$_FILES['upload_sender']['name'];
    $extension = end($fname);    
    if($extension=='csv')
    {
               if (($handle = fopen($_FILES['upload_sender']['tmp_name'], "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 100000, ",")) !== FALSE) {
                        $number = $name = '';
          
                            if (isset($data[0]) || isset($data[1])) {
                                $sender_name[] = isset($data[0]) ? str_replace("'","",$data[0]) : '';
                                $pe_id[] = isset($data[1]) ? str_replace("'","",$data[1]) : '';

                                // $header_id[] = isset($data[2]) ? $data[2] : '';
                                // $sender_desc[] = isset($data[3]) ? $data[3] : '';

                       

                            }
                            else
                            {
                                return "Sender Id and PEID is required";
                            }
                        
                        
                    }

                   
                    fclose($handle);

                     $count_temp=count($sender_name);
                     
                    if($count_temp>1)
                    {
                        $values="";
                        $today_dt=date("Y-m-d");
                        for($i=1;$i<count($sender_name);$i++)
                        {
                             if($count_temp>1 && ($i!=(count($sender_name)-1)))
                             {
                            $values.="('" . $userid . "','$pe_id[$i]','$sender_name[$i]',NOW(),1),";
                             }
                             else
                             {
                             $values.="('" . $userid . "','$pe_id[$i]','$sender_name[$i]',NOW(),1)";
                             }
                        }




                    }
                    else
                    {
                        return "Please check your file";
                    }

                    if($values!="")
                    {

                           $sql = "INSERT INTO `az_senderid` ( `userid`,  `pe_id`, `senderid`, `created_at`,`status`) values $values" ;
                            // echo $sql;

                            
                            $res = mysqli_query($dbc, $sql)or die(mysqli_error($dbc));

                               if ($res) {
                                    return 'success';
                                } else {
                                    return 0;
                                }


                    }
                    
                    


                }
    }
}

    function getUserIds() {
        global $dbc;
        $out = array();
        $ids = '';
        $q = "SELECT userid FROM az_user WHERE parent_id = {$_SESSION['user_id']}";
        $rs = mysqli_query($dbc, $q);
        if (mysqli_num_rows($rs) > 0) {
            while ($rows = mysqli_fetch_assoc($rs)) {
                $out['userid'][] = $rows['userid'];
            }
            $ids = implode(',', $out['userid']);
        }
        return $ids;
    }

function get_username($uid)
{
    global $dbc;
    $sql="select * from az_user where userid='".$uid."'";

    $result=mysqli_query($dbc,$sql);
    while ($row=mysqli_fetch_array($result)) {
        $uname=$row['user_name'];
    }

    return $uname;
}
     function insert_senderid() {
        global $dbc;
        if ($_SESSION['user_role'] !='mds_adm') {
            $userid = $_SESSION['user_id'];
        } else {
            $userid=$_REQUEST['username_senderid'];
            //$userid = $_POST['userid'];
        }
        //if($_SESSION['user_id'] != 1) {
        if (isset($_POST['gatewayid']) && !empty($_POST['gatewayid'])) {
            $gatewayid = $_POST['gatewayid'];
        } else {
            $gatewayid = "";
        }

        if (isset($_POST['set_as_priority']) && !empty($_POST['set_as_priority'])) {
            $set_as_priority = 1;
        } else {
            $set_as_priority = 0;
        }
       $q = "SELECT senderid FROM az_senderid WHERE senderid = '" . $_POST['senderid'] . "' AND status = 1 and userid='".$userid."'";
        $rs = mysqli_query($dbc, $q);
        $status = 0;
        if (mysqli_num_rows($rs) > 0) {
            return array('status'=>false, 'msg'=>'Already Exists');
              exit; 
             //$status = 1;
        }
        if ($_SESSION['user_id'] == 4) {
            $status = 1;
        }
 
     $sql = "INSERT INTO az_senderid(sid, userid,senderid, pe_id, header_id, descript,created_at, status, `gatewayid`, `set_as_priority`) VALUES(NULL, '" . $userid . "','" . $_POST['senderid'] . "','" . $_POST['PE_ID'] . "', '" . $_POST['Header_ID'] . "','" . $_POST['descript'] . "', NOW(), '1', '" . $gatewayid . "', " . $set_as_priority . ")";
        $res = mysqli_query($dbc, $sql);
        if ($res)
            return array('status' => true, 'msg' => 'Success');
        else
            return array('status' => false, 'msg' => 'Error');
    }



    function insert_block_senderid() {
        global $dbc;
        
        $userid = $_SESSION['user_id'];
       
        $q = "SELECT senderid FROM senderid_block WHERE senderid = '" . $_POST['senderid'] . "'";
        $rs = mysqli_query($dbc, $q);
      
        if (mysqli_num_rows($rs) > 0) {
            
            return array('status' => true, 'msg' => 'Already Exists');
        }
        else
        {
            $sql = "INSERT INTO senderid_block(userid,senderid) VALUES('" . $userid . "','" . $_POST['senderid'] . "')";
            $res = mysqli_query($dbc, $sql);
            if ($res)
                return array('status' => true, 'msg' => 'Success');
            else
                return array('status' => false, 'msg' => 'Error');
        }
       
       
       
        
    }

         function insert_user_senderid() {
        global $dbc;
        
            $userid = $_POST['userid'];
        
        //if($_SESSION['user_id'] != 1) {
        if (isset($_POST['gatewayid']) && !empty($_POST['gatewayid'])) {
            $gatewayid = $_POST['gatewayid'];
        } else {
            $gatewayid = "";
        }

        if (isset($_POST['set_as_priority']) && !empty($_POST['set_as_priority'])) {
            $set_as_priority = 1;
        } else {
            $set_as_priority = 0;
        }
        $q = "SELECT senderid FROM az_senderid WHERE senderid = '" . $_POST['senderid'] . "' AND status = 1";
        $rs = mysqli_query($dbc, $q);
        $status = 0;
        if (mysqli_num_rows($rs) > 0) {
            /* return array('status'=>false, 'msg'=>'Already Exists');
              exit; */
            $status = 1;
        }
        if ($_SESSION['user_id'] == 4) {
            $status = 1;
        }
        if (isset($_SESSION['OpnSndr']) && $_SESSION['OpnSndr'] == 'OpnSndr') {
            $result = checkUserGateway();
            if ($result == true) {
                $status = 1;
            }
        }
        if (checkParentOpnSndr()) {
            $status = 1;
        }
        $sql = "INSERT INTO az_senderid(sid, userid,senderid, pe_id, header_id, descript,created_at, status, `gatewayid`, `set_as_priority`) VALUES(NULL, '" . $userid . "','" . $_POST['senderid'] . "','" . $_POST['PE_ID'] . "', '" . $_POST['Header_ID'] . "','" . $_POST['descript'] . "', NOW(), '" . $status . "', '" . $gatewayid . "', " . $set_as_priority . ")";
        $res = mysqli_query($dbc, $sql);
        if ($res)
            return array('status' => true, 'msg' => 'Success');
        else
            return array('status' => false, 'msg' => 'Error');
    }


     function update_senderid() {
        global $dbc;
        $updated_at=time();
        $updated_by=$_SESSION['user_id'];
        $sql = "update az_senderid set senderid='" . $_POST['senderid'] . "', pe_id='" . $_POST['PE_ID'] . "', header_id='" . $_POST['Header_ID'] . "', descript='" . $_POST['descript'] . "',updated_at=$updated_at,updated_by='".$updated_by."',`status`='".$_POST['senderid_status']."' where sid='".$_REQUEST['s_id']."'";
        $res = mysqli_query($dbc, $sql);
        if ($res)
            return array('status' => true, 'msg' => 'Success');
        else
            return array('status' => false, 'msg' => 'Error');
    }

     function delete_senderid() {
        global $dbc;
        $sid=$_REQUEST['sid'];
        $sql = "delete from az_senderid where sid='".$sid."'";
        $res = mysqli_query($dbc, $sql);
        if ($res)
            return array('status' => true, 'msg' => 'Success');
        else
            return array('status' => false, 'msg' => 'Error');
    }


       function checkUserGateway() {
        global $dbc;
        $qry = "SELECT `az_optin` FROM `az_routetype` route INNER JOIN az_user_services usrser ON route.az_routeid = usrser.`service_id` WHERE userid = '{$_SESSION['user_id']}'";
        $rs = mysqli_query($dbc, $qry);
        $chk = false;
        if (mysqli_num_rows($rs) > 0) {
            while ($rows = mysqli_fetch_assoc($rs)) {
                if ($rows['az_optin'] == 1) {
                    $chk = true;
                }
            }
        }
        return $chk;
    }



    function checkParentOpnSndr() {
        global $dbc;
        $q = "SELECT parent_id FROM az_user WHERE userid = '{$_SESSION['user_id']}'";
        $rs = mysqli_query($dbc, $q);
        $out = mysqli_fetch_assoc($rs);
        $parent_id = $out['parent_id'];
        $qry = "SELECT permissions FROM az_user WHERE userid = '{$parent_id}'";
        $rs1 = mysqli_query($dbc, $qry);
        $row = mysqli_fetch_assoc($rs1);
        $status = false;
        if ($row['permissions'] != "") {
            $data = explode(',', $row['permissions']);
            if (in_array('OpnSndr', $data)) {
                $status = true;
            }
        }
        return $status;
    }

    function sender_id_dropdown()
    {
             global $dbc;
             $q = "SELECT * FROM az_senderid WHERE userid='".$_SESSION['user_id']."' and status=1";
             $rs = mysqli_query($dbc, $q);

             $count=mysqli_num_rows($rs);
             if($count>0)
             {
             $option="<option value=''>Select Sender ID</option>";
             while($row=mysqli_fetch_array($rs))
             {
                $sid=$row['sid'];
                $senderid=$row['senderid'];
                $option.="<option value='".$sid."'>$senderid</option>";
             }

             return $option;

             }
             else
             {
                return 0;
             }

    }


    function sender_id_dropdown_without_name()
    {
             global $dbc;
             $userid=$_SESSION['user_id'];
             
             $q = "SELECT * FROM az_senderid WHERE userid='$userid' and status=1";
             $rs = mysqli_query($dbc, $q);
             $option="";
             while($row=mysqli_fetch_array($rs))
             {
                $sid=$row['sid'];
                $senderid=$row['senderid'];
                $option.="<option value='".$sid."'>$senderid</option>";
             }

             return $option;

    }


    function all_senderid_block()
    {
             global $dbc;
             $userid=$_SESSION['user_id'];
             
             $q = "SELECT * FROM senderid_block";
             $rs = mysqli_query($dbc, $q);
             $option="";
             $table="";
             while($row=mysqli_fetch_array($rs))
             {
                $table.="<tr>";
                $id=$row['id'];
                $senderid=$row['senderid'];
                $created_date=date("Y-m-d",strtotime($row['created_date']));
               /* $table.="<td></td>";*/
                $table.="<td>$senderid</td>";
                $table.="<td>$created_date</td>";
                $table.="<td>Delete</td>";
                $table.="</tr>";
             }

             return $table;

    }
 ?>