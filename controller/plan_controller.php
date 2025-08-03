<?php
session_start();
$log_file = "../error/logfiles/plan_controller.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);

include_once('../include/connection.php');

if (isset($_POST['createplan']) && $_POST['createplan'] == 'createplan') {
    $rs = savePlan();
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

  if($list_type=='all_plan')
  {
           $result = viewallplan();

            $return_plan=all_plan($result);

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
   else if($list_type=='delete_plan')
  {
    $rs=delete_plan();

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

    function delete_plan() {
        global $dbc;
        $pid=$_REQUEST['pid'];
       
        $sql = "delete from az_plan  where pid='".$pid."'";
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


      function viewallplan() {
        global $dbc;
        $result = array();
        $sql = "SELECT *  FROM az_plan ORDER BY created_date DESC";
        $values = mysqli_query($dbc, $sql);
        while ($row = mysqli_fetch_assoc($values)) {
            $pid = $row['pid'];
            $result[$pid] = $row;
        }
        return $result;
    }


         function all_plan($result)
        {
          $i = 1;
          if (!empty($result)) { 
         
           foreach ($result as $key => $value) { 
            $pid=$value['pid'];
            $plan_name=$value['p_name'];
            

            $pstatus=$value['status'];
            if($pstatus=='1')
            {
               $status='Active';
            }
            else
            {
              $status='Inactive';
            }
            $created_dt=date('d-M-Y h:i a', strtotime($value['created_date']));
              $return_plan.="<tr>
              <td width='5%'>$i</td>
              <td width='30%'>$plan_name</td>            
              <td width='15%'>$status</td>
              <td width='15%'>$created_dt</td>              
              <td width='15%'>
                <button class='btn btn-primary me-1 mb-1 edit_plan' type='button' data-bs-toggle='modal' data-bs-target='#edit_plan' data-id='".$pid."' data-plan='".$plan_name."' data-status='".$pstatus."' >
                <i class='fa fa-pencil'></i>
                </button>&nbsp;
                <button class='btn btn-primary me-1 mb-1 delete_plan_btn' type='button'  data-id='".$pid."'>
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

function savePlan()
{
	global $dbc;
        $pname = ucwords(strtolower($_POST['p_name']));
        $sql_select = "SELECT * from az_plan where p_name='$pname'";
        $query_select = mysqli_query($dbc, $sql_select);
        $count_plan=mysqli_num_rows($query_select);
        $plan_status = $_POST['plan_status'];
        if($count_plan==0)
        {
        	 $sql = "INSERT INTO az_plan (userid,p_name,created_date,status) VALUES ('" . $_SESSION['user_id'] . "','" . $pname . "',now(),$plan_status)";
	        $query = mysqli_query($dbc, $sql);
	        if ($query) {
	            unset($_POST);
	            return 1;
	        } else {
	            return 2;
	        }
        }
        else
        {
        	return 0;
        	
        }

       

}

