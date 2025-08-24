<?php
session_start();
$log_file = "../error/logfiles/plan_controller.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);

include_once('../include/connection.php');

if (isset($_POST['createhash']) && $_POST['createhash'] == 'createhash') {
    $rs = saveHash();
    echo $rs;
  	/*if($rs=='1')
  	{
  		echo 1;
  	}
  	else if($rs=='2')
  	{
		echo 2;
  	}
  	else if($rs=='0')
  	{
  		echo 0;
  	}*/


}


if(isset($_REQUEST['list_type']))
{
    $list_type=$_REQUEST['list_type'];

  if($list_type=='all_hash')
  {
           $result = viewallhash();

            $return_plan=all_hash($result);

            echo $return_plan;
  }
  else if($list_type=='editplan')
  {
    $rs=update_plan();

    if($rs==1)
    {
     echo 1;
    }
    else
    {
      echo 0;
    }

           
  }
   else if($list_type=='delete_hash')
  {
    $rs=delete_hash();

    if($rs==1)
    {
      echo 1;
    }
    else
    {
      echo 0;
    }

           
  }

}

function update_plan() {
        global $dbc;
        $pid=$_REQUEST['pid'];
        $p_name=$_REQUEST['p_name'];
        $plan_status=$_REQUEST['plan_status'];
        $sql = "update az_plan set p_name='".$p_name."', status='".$plan_status."' where pid='".$pid."'";
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

    function delete_hash() {
        global $dbc;
        $hash_id=$_REQUEST['hash_id'];
       
        $sql = "delete from hash_config  where hash_id='".$hash_id."'";
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


      function viewallhash() {
        global $dbc;
        $result = array();
        $sql = "SELECT *  FROM hash_config ORDER BY created_date DESC";
        $values = mysqli_query($dbc, $sql);
        while ($row = mysqli_fetch_assoc($values)) {
            $id = $row['hash_id'];
            $result[$id] = $row;
        }
        return $result;
    }


         function all_hash($result)
        {
          $i = 1;
          if (!empty($result)) { 
         
           foreach ($result as $key => $value) { 
            $hash_id=$value['hash_id'];
            $userid=$value['userid'];
            $username=get_username($userid);
            $tm_value=$value['tm'];
            $tmd_value=$value['tmd'];
            $created_date=$value['created_date'];
            $created_dt=date('d-M-Y h:i a', strtotime($created_date));  

            
   
              $return_plan.="<tr>
              <td width='5%'>$i</td>
              <td width='15%'>$username</td>            
              <td width='30%'>$tm_value</td>
              <td width='15%'>$tmd_value</td>              
              <td width='15%'>
                <button class='btn btn-primary me-1 mb-1 edit_hash' type='button' data-bs-toggle='modal' data-bs-target='#edit_hash' data-id='".$hash_id."' data-plan='".$plan_name."' data-status='".$pstatus."' >
                <i class='fa fa-pencil'></i>
                </button>&nbsp;
                <button class='btn btn-primary me-1 mb-1 delete_hash_btn' type='button'  data-id='".$hash_id."'>
                <i class='fa fa-trash'></i>
                </button>
              </td></tr>";
                $i++;
                }

                return $return_plan;
          } 
          else
          {
            return "No record available";
          }
        }


function saveHash()
{
    global $dbc;

    // Validate required fields
    if (empty($_POST['username']) || empty($_POST['tmd_value']) || empty($_POST['tm_value'])) {
        return 3; // Missing data
    }

    $userid = mysqli_real_escape_string($dbc, $_POST['username']);
    $tmd_value = mysqli_real_escape_string($dbc, $_POST['tmd_value']);

    // Handle TM values (array to comma-separated)
    $tm_values = array_filter($_POST['tm_value']); // Remove empty inputs
    $tm_value_str = mysqli_real_escape_string($dbc, implode(',', $tm_values));

    // Check if record exists
    $sql_select = "SELECT * FROM hash_config WHERE userid='$userid' AND tmd='$tmd_value'";
    $query_select = mysqli_query($dbc, $sql_select);

    if (!$query_select) {
        return 4; // Query error in select
    }

    $count_hash = mysqli_num_rows($query_select);

    if ($count_hash == 0) {
        // Insert new record
        $sql = "INSERT INTO hash_config (userid, tm, tmd, created_date)
                VALUES ('$userid', '$tm_value_str', '$tmd_value', NOW())";

        $query = mysqli_query($dbc, $sql);

        if ($query) {
            return 1; // Success
        } else {
            return 2; // Insert failed
        }
    } else {
        return 0; // Already exists
    }
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
