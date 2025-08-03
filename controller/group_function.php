<?php 
session_start();
include_once('../include/connection.php');
include('classes/last_activities.php');
require('classes/ssp.class.php');
//include_once('../include/datatable_dbconnection.php');
$log_file = "../error/logfiles/group_function.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);
error_reporting(0);
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
if (isset($_POST['creategrp']) && $_POST['creategrp'] == 'creategrp') {
    $rs = saveGroup();
   // echo $rs;
  if ($rs) {
        /*$result = viewgroup();

        $return_grplist=group_list($result);*/
        $u_id=$_SESSION['user_id'];
        get_last_activities($u_id,'New Group Added',@$login_date,@$logout_date);
        echo $rs;
    } 
    else if($rs==2)
    {
        echo $rs;
    }
    else {
        echo 'FALSE';
    }




}


if (isset($_POST['act']) && $_POST['act'] == 'import3') {


    $cnt = 0;
$sql = array();

//var file_data = $('#uploadfile').prop('files')[0];


   if (is_uploaded_file($_FILES['uploadfile']['tmp_name'])) {



       $temp = explode(".", $_FILES["uploadfile"]["name"]);


   $ext = end($temp);
   $cntr = 0;
   if(isset($_REQUEST['select_group_import']))
   {
       $groups=explode(",",$_REQUEST['select_group_import']);
   }
   else
   {
       echo 0;
   }

  

       // $temp = explode(".", $_FILES["uploadfile"]["name"]);
       // $ext = end($temp);
       // $cntr = 0;


    for($i=0;$i<count($groups);$i++)
   {
       if (($ext == 'csv') or ($ext == 'txt')) {
           if (($handle = fopen($_FILES['uploadfile']['tmp_name'], "r")) !== FALSE) {
                 $columns = fgetcsv($handle, 50000, ",");
                 $csv = array();
                 //$j = 0;
               while (($data = fgetcsv($handle, 50000, ",")) !== FALSE) {
                    // $csv[$i] = array_combine($columns, $data);


                   $number = $name = '';
                   //echo $data[1];
                   /*if (count($data) == 3 || count($data) == 2) {*/
                       //$group = isset($data[0]) ? $data[0] : '';
                       if ((strlen($data[0]) == 10) && (is_numeric($data[0]))) {
                           $number = $data[0];
                           $name = isset($data[1]) ? $data[1] : '';
                       }
                   //}
                   /* elseif(count($data)==3)  
                     {
                     if((strlen( $data[0]) == 10)&& (is_numeric($data[0]))){$number= $data[0];$name= $data[1];}
                     } */

                     $group =$groups[$i];
                   if ($number && $group) {
                       $result[$group]['group'] = $group;
                       $result[$group]['number'][] = $number;
                       $result[$group]['name'][] = $name;
                       $cnt = $cnt + 1;
                   }
                       //$j++;

               }


               fclose($handle);

           }


             
           }

       }




        if (!empty($result)) {
            foreach ($result as $key => $value) {
           /*$rs = mysqli_query($dbc, "INSERT INTO `az_group` (`g_id`, `userid`, `g_name`, `g_desc`, `total_count`, `created_date`) VALUES (NULL, '{$_SESSION['user_id']}', '{$key}', '', '0', NOW())");
           $rid = mysqli_insert_id($dbc);*/
           $divided_array = array_chunk($value['number'], 2000);
           $divided_array1 = array_chunk($value['name'], 2000);
           $group_id=$key;
           $query = array();
           $userid=$_SESSION['user_id'];
           foreach ($divided_array as $key1 => $value1) {
               foreach ($value1 as $ke => $val) {
                   $name = isset($divided_array1[$key1][$ke]) ? $divided_array1[$key1][$ke] : '';
                   $sql_select="select * from az_group_contactlist where g_id='$group_id' and cont_number='$val'";
                   $return_select=mysqli_query($dbc,$sql_select);
                   $count_num=mysqli_num_rows($return_select);
                   if($count_num==0)
                   {
                        $query = mysqli_query($dbc,"INSERT INTO az_group_contactlist(gcl_id, g_id,cont_name,cont_number,userid) values (NULL, '{$group_id}', '{$name}', '{$val}', '$userid')");
                   }
                  
               }
           }
       }
   

   }



    echo "Total no's of record imported :" . $cnt;
   }
}

if (isset($_POST['type']) && $_POST['type'] == 'IndContactForm') {

    $rs = saveIndividualContactNo();
    if(empty($rs))
    {
        $u_id=$_SESSION['user_id'];
        get_last_activities($u_id,'New Individual Group Details Added',@$login_date,@$logout_date);
        echo '1';
    }
    else
    {
        echo $rs;
    }
}
else if($_POST['list_type'] == 'show_contact_list')
{

    $group_id=$_POST['group_id'];
    $restricted_report=$_SESSION['restricted_report'];
 
    $table = 'az_group_contactlist';

    $primaryKey = 'gcl_id';
    $count=1;
            $columns = array(
                array( 'db' => 'gcl_id','dt' => 0),
                array( 'db' => 'cont_number','dt' => 1 ,'formatter' => function( $d, $row ) {

                    global $restricted_report;
                    if($restricted_report=='Yes')
                    {
                        $count_len=strlen($d);
                        return substr($d, 0, $count_len-6)."XXXXXX";
                    } 
                    else
                    {
                         return $d;
                    }
                })
               
              
            );
             
            // SQL server connection information
           global $sql_details;
            $extraWhere=" g_id='".$group_id."'";
      
            echo json_encode(
                SSP::complex( $_REQUEST, $sql_details, $table, $primaryKey, $columns,$test=null,$extraWhere )
            );

    /* $rs = show_contact_list($group_id);
    if(empty($rs))
    {
        echo '0';
    }
    else
    {
        echo $rs;
    }   */
}
else if($_POST['type'] == 'fetch_group_contacts')
{

    $group_id=$_POST['group_id'];
     $rs = fetch_group_contacts($group_id);
    if(empty($rs))
    {
        echo '0';
    }
    else
    {
        echo $rs;
    }   
}
else if($_POST['type'] == 'delete_group')
{

    
     $rs = delete_group();

     if($rs)
     {
        $u_id=$_SESSION['user_id'];
    get_last_activities($u_id,'Group Details Deleted',@$login_date,@$logout_date);
     }
     
   echo $rs;
}
else if($_POST['type'] == 'updategrp')
{

    
     $rs = update_group();
     if($rs)
     {
        $u_id=$_SESSION['user_id'];
        get_last_activities($u_id,'Group Details Updated',@$login_date,@$logout_date);
     }
   echo $rs;
}


/*import group with contacts*/


if(isset($_REQUEST['list_type']))
{
    $list_type=$_REQUEST['list_type'];


    if($list_type=='all')
    {
           $result = viewgroup();

            $return_grplist=group_list($result);

            echo $return_grplist;
    }
    elseif($list_type=='dropdown')
    {
        $result = viewgroup();

            $return_grplist=group_list_dropdown($result);

            echo $return_grplist;
    }
}

function update_group() {
        global $dbc;
        $gid=$_REQUEST['gid'];
        $g_name=$_REQUEST['g_name'];
        $descript=$_REQUEST['descript'];
        $sql = "update az_group set g_name='".$g_name."', g_desc='".$descript."' where g_id='".$gid."'";
        $result = mysqli_query($dbc, $sql);
        if($result)
        {
          return 1;
        }
        else
        {
          return 0;
        }
        
    }


    function delete_group() {
        global $dbc;
        $group_id=$_POST['gid'];
       
      

        $sql = "delete from az_group  where g_id='".$group_id."'";
        $result = mysqli_query($dbc, $sql);

        $sql_contacts = "delete from az_group_contactlist  where g_id='".$group_id."'";
        $result_contact = mysqli_query($dbc, $sql_contacts);


        if($result)
        {
          return 1;
        }
        else
        {
          return 0;
        }
        
    }

    function saveGroup() {
        global $dbc;
        $gname = ucwords(strtolower($_POST['g_name']));
        $sql_select="select * from az_group where g_name='".$gname."'";
         $query_select = mysqli_query($dbc, $sql_select);
         $count_group=mysqli_num_rows($query_select);
         if($count_group==0)
         {

            $sql = "INSERT INTO az_group (userid,g_name,g_desc,created_date) VALUES ('" . $_SESSION['user_id'] . "','" . $gname . "','" . $_POST['descript'] . "',now())";
            $query = mysqli_query($dbc, $sql);
            if ($query) {
                unset($_POST);
                RETURN TRUE;
            } else {
                RETURN FALSE;
            }
        }
        else
        {
            return 2;
        }
    }

        function viewgroup() {
        global $dbc;
        $result = array();
        $sql = "SELECT count(cont_number) as totnum, g_id, g_name,g_desc, ag.userid, cont_number, gcl_id, cont_name, cont_number,created_date  FROM az_group as ag LEFT JOIN az_group_contactlist as agc USING(g_id) where ag.userid='" . $_SESSION['user_id'] . "' group by g_id ORDER BY created_date DESC";
        $values = mysqli_query($dbc, $sql);
        while ($row = mysqli_fetch_assoc($values)) {
            $g_id = $row['g_id'];
            $result[$g_id] = $row;
        }
        return $result;
    }


    function fetch_group_name($groupid)
    {
        global $dbc;
         $sql = "SELECT *  FROM az_group where g_id='" . $groupid . "'";
        $values = mysqli_query($dbc, $sql);
        while ($row = mysqli_fetch_assoc($values)) {
            $g_name=$row['g_name'];
        }
        return $g_name;

    }


      function fetch_group_contacts($groupid)
    {
        global $dbc;
        $groupids=explode(",",$groupid);
        $nos="";
        $count=0;
        for($i=0;$i<count($groupids);$i++)
        {
              $sql = "SELECT *  FROM az_group_contactlist where g_id='" . $groupids[$i] . "'";
        $values = mysqli_query($dbc, $sql);
        
        if(mysqli_num_rows($values)>0)
        {
             while ($row = mysqli_fetch_assoc($values)) {
            $nos.=$row['cont_number']."\n";
            $count++;
            }
        }

       

        }


       
        return $nos."|".$count;

    }


function show_contact_list($groupid)
    {
        global $dbc;
        $count=0;
      
              $sql = "SELECT *  FROM az_group_contactlist where g_id='" . $groupid . "'";
        $values = mysqli_query($dbc, $sql);
        
        if(mysqli_num_rows($values)>0)
        {
             while ($row = mysqli_fetch_assoc($values)) {
                $count++;
                $nos=$row['cont_number'];
                $tbl_data.="<tr scope='row'>";
                $tbl_data.="<td>".$count."</td>";
                $tbl_data.="<td>".$nos."</td>";
                $tbl_data.="</tr>";
            }
        } 
        return $tbl_data;
    }


    function group_list_dropdown($result)
    	{
    			  $i = 1;
		  if (!empty($result)) { 
	      $return_grplist="<option value=''>Select Group</option>";
	       foreach ($result as $key => $value) { 

    	       $gname=$value['g_name'];
    	      
    	       $gid=$value['g_id'];
    	       $return_grplist.="<option value='".$gid."'>".$gname."</option>";
    	        
    	       $i++;


		  	}

		  		return $return_grplist;
	      } 
	      else
	      {
	      	return "<option value=''>No Group available</option>";
	      }
    	}

        function group_list($result)
        {
                  $i = 1;
          if (!empty($result)) { 
         
           foreach ($result as $key => $value) { 
            $gid=$value['g_id'];
            $gname=$value['g_name'];
            $g_desc=$value['g_desc'];
            $totnum=$value['totnum'];
            $created_dt=date('d-M-Y h:i a', strtotime($value['created_date']));
              $return_grplist.="<tr>
              <td width='5%'>$i</td>
              <td width='5%'>$gname</td>
              <td width='15%'>$g_desc</td>
              <td width='5%'><a href='#' data-bs-toggle='modal' data-bs-target='#show_mobile_numbers'  data-id='".$gid."' class='contact_link'>$totnum</a></td>
              <td width='10%'>$created_dt</td>
              
              <td width='20%'><button class='btn btn-primary upload_btn' id='upload_$gid' onClick='upload_data(this.id)'><i class='fa fa-upload'></i></button>&nbsp;<button class='btn btn-primary me-1 mb-1 edit_group_btn' type='button' data-bs-toggle='modal' data-bs-target='#edit_group' data-id='".$gid."' data-gname='".$gname."' data-desc='".$g_desc."' >
              <i class='fa fa-pencil'></i>
                </button>
                <button class='btn btn-primary me-1 mb-1 delete_group_btn' type='button' data-id='".$gid."'>
                <i class='fa fa-trash'></i>
                </button></td>
              </tr>";
            
                $i++;
                }

                return $return_grplist;
          } 
          else
          {
            return "No record available";
          }
        }

        function saveIndividualContactNo() {
        global $dbc;

        $group_ids=$_POST['select_group'];
      //  print_r($group_ids);
        $userid=$_SESSION['user_id'];
        foreach($group_ids as $group)
        {
               $q = 'SELECT `cont_number` FROM `az_group_contactlist` WHERE `g_id` = "' . $group . '" AND `cont_number` = "' . trim($_POST['contactno']) . '"';
                $result = mysqli_query($dbc, $q);
                if (mysqli_num_rows($result) > 0) {
                    //return 2;
                    $group_name=fetch_group_name($group);

                    $exist.=$group_name." , ";

                   
                }
                else
                {
                    $qry = "INSERT INTO `az_group_contactlist` (`gcl_id`, `g_id`, `cont_name`, `cont_number`,`userid`) VALUES (NULL, '{$group}', '{$_POST['person_name']}', '{$_POST['contactno']}', '$userid')";
                     $rs = mysqli_query($dbc, $qry); 
                     //$exist.="ok";

                }

               
               
         }

         return $exist;


     
    }


    if (isset($_REQUEST['mod']) && $_REQUEST['mod'] == 'groupWithContacts') {
    //echo $_GET['gid'];
    //die
    $cnt = 0;
    $sql = array();
    if (is_uploaded_file($_FILES['import_contact']['tmp_name'])) {  
        $temp = explode(".", $_FILES["import_contact"]["name"]);
        $ext = end($temp);
        $cntr = 0;
        if(isset($_REQUEST['select_group_import']))
        {
            $groups=explode(",",$_REQUEST['select_group_import']);
        }
        else
        {
            echo 0;
        }

        for($i=0;$i<count($groups);$i++)
        {
    
             if (($ext == 'csv') or ( $ext == 'txt')) {
                if (($handle = fopen($_FILES['import_contact']['tmp_name'], "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 100000, ",")) !== FALSE) {
                        $number = $name = '';
                        //echo $data[1];
                        /*if (count($data) == 3 || count($data) == 2) {*/
                            //$group = isset($data[0]) ? $data[0] : '';
                            if ((strlen($data[0]) == 10) && (is_numeric($data[0]))) {
                                 $number = $data[0];
                                $name = isset($data[1]) ? $data[1] : '';
                            }
                        //}
                        /* elseif(count($data)==3)  
                          {
                          if((strlen( $data[0]) == 10)&& (is_numeric($data[0]))){$number= $data[0];$name= $data[1];}
                          } */

                          $group =$groups[$i];
                        if ($number && $group) {
                            $result[$group]['group'] = $group;
                            $result[$group]['number'][] = $number;
                            $result[$group]['name'][] = $name;
                            $cnt = $cnt + 1;
                        }
                    }
                    fclose($handle);
                }
            }
        }

        /* else if ($ext == 'xls') {
            //include("include/excel.class.php");
            include("excel.class.php");
            $excel = new Spreadsheet_Excel_Reader();
            $excel->read($_FILES['importfile']['tmp_name']);
            $x = 1;
            $data = array();
            while ($x <= $excel->sheets[0]['numRows']) {
                $number = $name = '';
                //echo $excel->sheets[0]['numCols'];
                //echo '<br>';
                if ($excel->sheets[0]['numCols'] == 3 || $excel->sheets[0]['numCols'] == 2) {
                    if ($excel->sheets[0]['cells'][$x][1]) {
                        $group = $excel->sheets[0]['cells'][$x][1];
                    }
                    if ((strlen($excel->sheets[0]['cells'][$x][2]) == 10) && (is_numeric($excel->sheets[0]['cells'][$x][2]))) {
                        $number = $excel->sheets[0]['cells'][$x][2];
                        $name = isset($excel->sheets[0]['cells'][$x][3]) ? $excel->sheets[0]['cells'][$x][3] : '';
                    }
                }
                if ($number && $group) {
                    $result[$group]['group'] = $group;
                    $result[$group]['number'][] = $number;
                    $result[$group]['name'][] = $name;
                    $cnt = $cnt + 1;
                }
                $x++;
            }
        } else if ($ext == 'xlsx') {
            include("xlsx.class.php");
            $xlsx = new SimpleXLSX($_FILES['importfile']['tmp_name']);
            list($num_cols, $num_rows) = $xlsx->dimension();
            foreach ($xlsx->rows() as $r) {
                //pre($r);
                $number = $name = '';
                if ($num_cols == 1) {
                    if ((strlen($r[0]) == 10) && (is_numeric($r[0]))) {
                        $number = $r[0];
                    }
                } elseif ($num_cols == 2) {
                    if ((strlen($r[0]) == 10) && (is_numeric($r[0]))) {
                        $number = $r[0];
                        $name = $r[1];
                    }
                }
                if ($number) {
                    $sql[] = '(NULL,' . $gid . ',"' . antiinjection($name) . '","' . antiinjection($number) . '")';
                    $cnt = $cnt + 1;
                }
            }
            //pre($sql);
            //die;
        }*/
       if (!empty($result)) {
                 foreach ($result as $key => $value) {
                /*$rs = mysqli_query($dbc, "INSERT INTO `az_group` (`g_id`, `userid`, `g_name`, `g_desc`, `total_count`, `created_date`) VALUES (NULL, '{$_SESSION['user_id']}', '{$key}', '', '0', NOW())");
                $rid = mysqli_insert_id($dbc);*/
                $divided_array = array_chunk($value['number'], 2000);
                $divided_array1 = array_chunk($value['name'], 2000);
                $group_id=$key;
                $query = array();
                $userid=$_SESSION['user_id'];
                foreach ($divided_array as $key1 => $value1) {
                    foreach ($value1 as $ke => $val) {
                        $name = isset($divided_array1[$key1][$ke]) ? $divided_array1[$key1][$ke] : '';
                        $sql_select="select * from az_group_contactlist where g_id='$group_id' and cont_number='$val'";
                        $return_select=mysqli_query($dbc,$sql_select);
                        $count_num=mysqli_num_rows($return_select);
                        if($count_num==0)
                        {
                             $query = mysqli_query($dbc,"INSERT INTO az_group_contactlist(gcl_id, g_id,cont_name,cont_number,userid) values (NULL, '{$group_id}', '{$name}', '{$val}', '$userid')");
                        }
                       
                    }
                }
            }
        

        }

        //$sql="update tbl_group G set tot_count=(SELECT count(gc_id) FROM tbl_group_contact C WHERE G.g_id=C.g_id) where G.g_id=". antiinjection($gid).";";
        // mysqli_query($dbc,$sql);     
        echo "Total no's of record imported :" . $cnt;
    }
}


    if (isset($_REQUEST['mod']) && $_REQUEST['mod'] == 'singleGroup') {
    //echo $_GET['gid'];
    //die
    $cnt = 0;
    $sql = array();
    if (is_uploaded_file($_FILES['upload_contact']['tmp_name'])) {  
        $temp = explode(".", $_FILES["upload_contact"]["name"]);
        $ext = end($temp);
        $cntr = 0;
        if(isset($_REQUEST['select_group_import']))
        {
            $groups=explode(",",$_REQUEST['select_group_import']);
        }
        else
        {
            echo 0;
        }

        for($i=0;$i<count($groups);$i++)
        {
    
             if (($ext == 'csv') or ( $ext == 'txt')) {
                if (($handle = fopen($_FILES['upload_contact']['tmp_name'], "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 100000, ",")) !== FALSE) {
                        $number = $name = '';
                        //echo $data[1];
                        /*if (count($data) == 3 || count($data) == 2) {*/
                            //$group = isset($data[0]) ? $data[0] : '';
                            if ((strlen($data[0]) == 10) && (is_numeric($data[0]))) {
                                 $number = $data[0];
                                $name = isset($data[1]) ? $data[1] : '';
                            }
                        //}
                        /* elseif(count($data)==3)  
                          {
                          if((strlen( $data[0]) == 10)&& (is_numeric($data[0]))){$number= $data[0];$name= $data[1];}
                          } */

                          $group =$groups[$i];
                        if ($number && $group) {
                            $result[$group]['group'] = $group;
                            $result[$group]['number'][] = $number;
                            $result[$group]['name'][] = $name;
                            $cnt = $cnt + 1;
                        }
                    }
                    fclose($handle);
                }
            }
        }

        /* else if ($ext == 'xls') {
            //include("include/excel.class.php");
            include("excel.class.php");
            $excel = new Spreadsheet_Excel_Reader();
            $excel->read($_FILES['importfile']['tmp_name']);
            $x = 1;
            $data = array();
            while ($x <= $excel->sheets[0]['numRows']) {
                $number = $name = '';
                //echo $excel->sheets[0]['numCols'];
                //echo '<br>';
                if ($excel->sheets[0]['numCols'] == 3 || $excel->sheets[0]['numCols'] == 2) {
                    if ($excel->sheets[0]['cells'][$x][1]) {
                        $group = $excel->sheets[0]['cells'][$x][1];
                    }
                    if ((strlen($excel->sheets[0]['cells'][$x][2]) == 10) && (is_numeric($excel->sheets[0]['cells'][$x][2]))) {
                        $number = $excel->sheets[0]['cells'][$x][2];
                        $name = isset($excel->sheets[0]['cells'][$x][3]) ? $excel->sheets[0]['cells'][$x][3] : '';
                    }
                }
                if ($number && $group) {
                    $result[$group]['group'] = $group;
                    $result[$group]['number'][] = $number;
                    $result[$group]['name'][] = $name;
                    $cnt = $cnt + 1;
                }
                $x++;
            }
        } else if ($ext == 'xlsx') {
            include("xlsx.class.php");
            $xlsx = new SimpleXLSX($_FILES['importfile']['tmp_name']);
            list($num_cols, $num_rows) = $xlsx->dimension();
            foreach ($xlsx->rows() as $r) {
                //pre($r);
                $number = $name = '';
                if ($num_cols == 1) {
                    if ((strlen($r[0]) == 10) && (is_numeric($r[0]))) {
                        $number = $r[0];
                    }
                } elseif ($num_cols == 2) {
                    if ((strlen($r[0]) == 10) && (is_numeric($r[0]))) {
                        $number = $r[0];
                        $name = $r[1];
                    }
                }
                if ($number) {
                    $sql[] = '(NULL,' . $gid . ',"' . antiinjection($name) . '","' . antiinjection($number) . '")';
                    $cnt = $cnt + 1;
                }
            }
            //pre($sql);
            //die;
        }*/
       if (!empty($result)) {
                 foreach ($result as $key => $value) {
                /*$rs = mysqli_query($dbc, "INSERT INTO `az_group` (`g_id`, `userid`, `g_name`, `g_desc`, `total_count`, `created_date`) VALUES (NULL, '{$_SESSION['user_id']}', '{$key}', '', '0', NOW())");
                $rid = mysqli_insert_id($dbc);*/
                $divided_array = array_chunk($value['number'], 2000);
                $divided_array1 = array_chunk($value['name'], 2000);
                $group_id=$key;
                $query = array();
                $userid=$_SESSION['user_id'];
                foreach ($divided_array as $key1 => $value1) {
                    foreach ($value1 as $ke => $val) {
                        $name = isset($divided_array1[$key1][$ke]) ? $divided_array1[$key1][$ke] : '';
                       
                        $query = mysqli_query($dbc, "INSERT INTO az_group_contactlist(gcl_id, g_id,cont_name,cont_number,userid) values (NULL, '{$group_id}', '{$name}', '{$val}', '$userid')");
                    }
                }
            }
        

        }

        //$sql="update tbl_group G set tot_count=(SELECT count(gc_id) FROM tbl_group_contact C WHERE G.g_id=C.g_id) where G.g_id=". antiinjection($gid).";";
        // mysqli_query($dbc,$sql);     
        echo "Total no's of record imported :" . $cnt;
    }
}

 ?>