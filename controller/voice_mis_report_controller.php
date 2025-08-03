<?php 
	session_start();
	error_reporting(0);
	$log_file = "../error/logfiles/mis_report_controller.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);

include('../include/connection.php');
include("../include/config.php");

	if(isset($_REQUEST['list_type'])) {
    	$list_type=$_REQUEST['list_type'];
    	$selected_userid=$_REQUEST['selected_userid'];

	    if($list_type=='mis_report') {

	    	$result = viewMISReport();
	    	$u_id=$_SESSION['user_id'];
	    	$end_date = date("Y-m-d");
  			
  			$start_date=date('Y-m-01', strtotime($end_date));
	    	$return_daily_mis_report = daily_mis_report($result,$u_id,$start_date,$end_date);



	    	$return_monthly_mis_report = monthlyMISReport();
        $return_senderid_mis_report = senderidMISReport();
        /*$return_custom_mis_report = customMISReport();*/
	    	$return_yearly_mis_report = yearlyMISReport();

	    	$result['daily']=$return_daily_mis_report;
	    	$result['monthly']=$return_monthly_mis_report;
	    	$result['yearly']=$return_yearly_mis_report;
        $result['senderid']=$return_senderid_mis_report;
        /*$result['custom']=$return_custom_mis_report;*/
	    	echo json_encode($result);
	    }
      else if($list_type=='custom_report') {
        /*echo "test custom1";*/
        //$selected_role=$_REQUEST['selected_user_role'];

        $result = viewMISReport();
        $u_id=$_SESSION['user_id'];
        $end_date = date("Y-m-d");
        
        $start_date=date('Y-m-01', strtotime($end_date));
        $return_daily_mis_report = daily_mis_report($result,$u_id,$start_date,$end_date);
        $from_dt=$_REQUEST["min"];
        $to_dt=$_REQUEST["max"];



        $return_monthly_mis_report = monthlyMISReport();
        $return_senderid_mis_report = senderidMISReport();
        $return_custom_mis_report = customMISReport($from_dt,$to_dt);
        $return_yearly_mis_report = yearlyMISReport();

        $result['daily']=$return_daily_mis_report;
        $result['monthly']=$return_monthly_mis_report;
        $result['yearly']=$return_yearly_mis_report;
        $result['senderid']=$return_senderid_mis_report;

        $result['custom']=$return_custom_mis_report;
        echo json_encode($result);
      }

	}

   	function viewMISReport(){
  		global $dbc;
  		$result_daily_mis_report = array();
  		$selected_userid=$_REQUEST['selected_userid'];
  		
  		// $table_id .= $_SESSION['rp_id'];
  		// $date_convert .= "date_format(created_at, '%a %d %M %Y')";
  		// $sql = "SELECT id, date_format(created_at, '%a %d %M %Y'), status, sum(msgcredit) FROM az_sendnumbers202202 group by status";

  		$end_date = date("Y-m-d");
  		$u_id=$_SESSION['user_id'];
  		$user_role=$_SESSION['user_role'];
  		//$sendtabledetals = SENDSMSDETAILS . CURRENTMONTH;
  		$start_date=date('Y-m-d', strtotime(' -30 day'));
  		
  		if($user_role=='mds_usr')
  		{
  		 $sql = "select sum(bill_credit) as bill_credit,status,created_date,id from `voice_user_summary` where userid='".$u_id."' and date(created_date) between '$start_date' and '$end_date' group by status,date(created_date)";
  		}
  		else if($user_role=='mds_adm')
  		{
  			$sql = "select sum(bill_credit) as bill_credit,status,created_date,id from `voice_user_summary` where userid='".$selected_userid."' and  date(created_date) between '$start_date' and '$end_date' group by status,date(created_date)";
  		}
  		else if($user_role=='mds_ad' || $user_role=='mds_rs')
  		{
  			 $selected_user_role=$_REQUEST['selected_user_role'];
  			if($selected_user_role=='mds_usr')
  			{
  				$sql = "select sum(bill_credit) as bill_credit,status,created_date,id from `voice_user_summary` where userid='".$selected_userid."' and  date(created_date) between '$start_date' and '$end_date' group by status,date(created_date)";
  			}
  			else if($selected_user_role=='mds_rs')
  			{
  					$userid_arr[]=$selected_userid;
        		$child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                      $only_Users=get_onlyUsers($single_arr);
                      if(!empty($only_Users))
                      {
                      	 $check_user_ids=implode(",",$only_Users);
                      }

                $sql = "select sum(bill_credit) as bill_credit,status,created_date,id from `voice_user_summary` where userid in ($check_user_ids) and  date(created_date) between '$start_date' and '$end_date' group by status,date(created_date)";
  			}
  			else if($selected_user_role=='All')
  			{
  					$userid_arr[]=$u_id;
        		$child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                      $only_Users=get_onlyUsers($single_arr);
                      if(!empty($only_Users))
                      {
                      	 $check_user_ids=implode(",",$only_Users);
                      }

                $sql = "select sum(bill_credit) as bill_credit,status,created_date,id from `voice_user_summary` where userid in ($check_user_ids) and  date(created_date) between '$start_date' and '$end_date' group by status,date(created_date)";
  			}
  		}




  		$values = mysqli_query($dbc, $sql);
   	   	while ($row = mysqli_fetch_assoc($values)) {
   	   		$r_id = $row['id'];
   	   		$result_daily_mis_report[$r_id] = $row;
   	   	}
   	   	return $result_daily_mis_report;
	}



    function senderidMISReport(){
      global $dbc;
      $result_monthly_mis_report = array();
      $selected_userid=$_REQUEST['selected_userid'];
    
      $current_date = date("Y-m-d");
      $u_id=$_SESSION['user_id'];
      $user_role=$_SESSION['user_role'];
      $start_month=date("Y")."-01-01";
      $end_month = date("Y")."-12-31";

      if($user_role=='mds_usr')
      {

       $sql = "select sum(bill_credit) as bill_credit,status,created_date,id from `voice_user_summary` where userid='".$u_id."' and date(created_date) between '$start_month' and '$end_month' group by status,MONTH(created_date),sender";
      }
      else if($user_role=='mds_adm'){
        $sql = "select sum(bill_credit) as bill_credit,status,created_date,id from `voice_user_summary` where userid='".$selected_userid."' and  date(created_date) between '$start_month' and '$end_month' group by status,MONTH(created_date),sender";
      }
      else if($user_role=='mds_ad' || $user_role=='mds_rs')
      {
        $selected_user_role=$_REQUEST['selected_user_role'];
        if($selected_user_role=='mds_usr')
        {
          $sql = "select sum(bill_credit) as bill_credit,status,created_date,id from `voice_user_summary` where userid='".$selected_userid."' and  date(created_date) between '$start_month' and '$end_month' group by status,MONTH(created_date),sender";
        }
        else if($selected_user_role=='mds_rs')
        {
          $userid_arr[]=$selected_userid;
            $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                      $only_Users=get_onlyUsers($single_arr);
                      if(!empty($only_Users))
                      {
                         $check_user_ids=implode(",",$only_Users);
                      }
          $sql = "select sum(bill_credit) as bill_credit,status,created_date,id from `voice_user_summary` where userid in ($check_user_ids) and  date(created_date) between '$start_month' and '$end_month' group by status,MONTH(created_date),sender";
        }
        else if($selected_user_role=='All')
        {
            $userid_arr[]=$u_id;
            $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                      $only_Users=get_onlyUsers($single_arr);
                      if(!empty($only_Users))
                      {
                         $check_user_ids=implode(",",$only_Users);
                      }
          $sql = "select sum(bill_credit) as bill_credit,status,created_date,id,userid from `voice_user_summary` where userid in ($check_user_ids) and  date(created_date) between '$start_month' and '$end_month' group by status,MONTH(created_date),userid,sender";
        }

        
      }

    

      $values = mysqli_query($dbc, $sql);
      $i=1;
        while ($value = mysqli_fetch_array($values)) {
          $rid=$value['id'];
          $return_monthly_mis_report[]=$value;
          $i++;
        }

        if (!empty($return_monthly_mis_report)) {


        foreach ($return_monthly_mis_report as $key => $value) {
          
          $status[] = $value["status"];
          

        }

        $table_head="<tr>
        <th>Month</th>
        <th>User</th>
        <th>Senderid</th>
        <th>Total Bill</th>";

        $status_arr=array_unique($status);
        
        for($i=0;$i<count($status);$i++)
        {
          if($status_arr[$i]!='')
          {
            $status_arr1[]=$status_arr[$i];
          }
          
        }

        $sql_select="Select sum(bill_credit) as bill_credit";
        //print_r($status_arr1);
        for($j=0;$j<count($status_arr1);$j++)
        {
          $stat=$status_arr1[$j];
          $table_head.="<th>$stat</th>";
          
          $sql_select.=",sum(if(status='$stat',bill_credit,0))as `$stat`";

        }

        $table_head.="</tr>";



        if($user_role=='mds_usr')
        {
          $sql_select.=",created_date,id,sender from `voice_user_summary` where date(created_date) between '$start_month' and '$end_month' and userid='".$u_id."' group by MONTH(created_date),sender";
        }
        else if($user_role=='mds_adm'){
          $sql_select.=",created_date,id,userid,sender from `voice_user_summary` where date(created_date) between '$start_month' and '$end_month' and userid='".$selected_userid."'  group by MONTH(created_date),userid,sender"; 
        }
        else if($user_role=='mds_ad' || $user_role=='mds_rs')
        {
          $selected_user_role=$_REQUEST['selected_user_role'];
          if($selected_user_role=='mds_usr')
          {
            $sql_select.=",created_date,id,sender from `voice_user_summary` where date(created_date) between '$start_month' and '$end_month' and userid='".$selected_userid."'  group by MONTH(created_date),sender"; 
          }
          else if($selected_user_role=='mds_rs')
          {
            $userid_arr[]=$selected_userid;
              $child_users=get_childUsers($userid_arr);

                        foreach ($child_users as $child_val) {
                          foreach($child_val as $val)
                          {
                            $single_arr[]=$val;
                          }
                        }

                        $only_Users=get_onlyUsers($single_arr);
                        if(!empty($only_Users))
                        {
                           $check_user_ids=implode(",",$only_Users);
                        }


                  $sql_select.=",created_date,id,sender from `voice_user_summary` where date(created_date) between '$start_month' and '$end_month' and userid in ($check_user_ids)  group by MONTH(created_date),sender"; 
          }
          else if($selected_user_role=='All')
          {
              $userid_arr[]=$u_id;
              $child_users=get_childUsers($userid_arr);

                        foreach ($child_users as $child_val) {
                          foreach($child_val as $val)
                          {
                            $single_arr[]=$val;
                          }
                        }

                        $only_Users=get_onlyUsers($single_arr);
                        if(!empty($only_Users))
                        {
                           $check_user_ids=implode(",",$only_Users);
                        }


                  $sql_select.=",created_date,id,userid,sender from `voice_user_summary` where date(created_date) between '$start_month' and '$end_month' and userid in ($check_user_ids)  group by MONTH(created_date),userid,sender"; 
          }
        }

    $result_select = mysqli_query($dbc, $sql_select);

      $count_record=mysqli_num_rows($result_select);
      if($count_record>0)
      {
        $total_bill_credit=0;
        while($row=mysqli_fetch_array($result_select))
        {
          $created_date=date('F Y',strtotime($row['created_date']));
          $bill_credit=$row['bill_credit'];
          $useridss=$row['userid'];
          $sender=$row['sender'];
          $username=get_username($useridss);
          $table_body.="<tr>
          <td>$created_date</td>
          <td>$username</td>
          <td>$sender</td>
          <td>$bill_credit</td>";
          for($j=0;$j<count($status_arr1);$j++)
          {
            $stat=$status_arr1[$j];
            $stat_val=$row[$stat];
            $total_bill_credit+=$stat_val;
            $per=($stat_val/$bill_credit)*100;
            $per=round($per,2);
            $table_body.="<td>$stat_val <br>($per %)</td>";

          }
          $table_body.="</tr>";
        }

        $table_body.="<tr>  <td></td>
          <td></td>
          <td></td>
          <td>$total_bill_credit</td></tr>";
      }
      else
      {
        $table_body.="No record available";
      }
      
          return $table_head.$table_body;
      }


        return $table_head;
  }


 function customMISReport($from_dt,$to_dt){
      global $dbc;
      $result_monthly_mis_report = array();
      $selected_userid=$_REQUEST['selected_userid'];
    
      $current_date = date("Y-m-d");
      $u_id=$_SESSION['user_id'];
      $user_role=$_SESSION['user_role'];
      $start_month=date("Y")."-01-01";
      $end_month = date("Y")."-12-31";

      if($user_role=='mds_usr')
      {

      $sql = "select sum(bill_credit) as bill_credit,status,created_date,id from `voice_user_summary` where userid='".$u_id."' and date(created_date) between '$from_dt' and '$to_dt' group by status";
      }
      else if($user_role=='mds_adm'){
         $sql = "select sum(bill_credit) as bill_credit,status,created_date,id from `voice_user_summary` where userid='".$selected_userid."' and  date(created_date) between '$from_dt' and '$to_dt' group by status,MONTH(created_date),sender";
      }
      else if($user_role=='mds_ad' || $user_role=='mds_rs')
      {
        $selected_user_role=$_REQUEST['selected_user_role'];
        if($selected_user_role=='mds_usr')
        {
          $sql = "select sum(bill_credit) as bill_credit,status,created_date,id from `voice_user_summary` where userid='".$selected_userid."' and  date(created_date) between '$start_month' and '$end_month' group by status,MONTH(created_date),sender";
        }
        else if($selected_user_role=='mds_rs')
        {
          $userid_arr[]=$selected_userid;
            $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                      $only_Users=get_onlyUsers($single_arr);
                      if(!empty($only_Users))
                      {
                         $check_user_ids=implode(",",$only_Users);
                      }
          $sql = "select sum(bill_credit) as bill_credit,status,created_date,id from `voice_user_summary` where userid in ($check_user_ids) and  date(created_date) between '$start_month' and '$end_month' group by status,MONTH(created_date),sender";
        }
        else if($selected_user_role=='All')
        {
            $userid_arr[]=$u_id;
            $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                      $only_Users=get_onlyUsers($single_arr);
                      if(!empty($only_Users))
                      {
                         $check_user_ids=implode(",",$only_Users);
                      }
          $sql = "select sum(bill_credit) as bill_credit,status,created_date,id,userid from `voice_user_summary` where userid in ($check_user_ids) and  date(created_date) between '$start_month' and '$end_month' group by status,MONTH(created_date),userid,sender";
        }

        
      }

    

      $values = mysqli_query($dbc, $sql);
      $i=1;
        while ($value = mysqli_fetch_array($values)) {
          $rid=$value['id'];
          $return_monthly_mis_report[]=$value;
          $i++;
        }

        if (!empty($return_monthly_mis_report)) {


        foreach ($return_monthly_mis_report as $key => $value) {
          
          $status[] = $value["status"];
          

        }

        $table_head="<tr>
        <th>Month</th>
        <th>User</th>
        <th>Senderid</th>
        <th>Total Bill</th>";

        $status_arr=array_unique($status);
        
        for($i=0;$i<count($status);$i++)
        {
          if($status_arr[$i]!='')
          {
            $status_arr1[]=$status_arr[$i];
          }
          
        }

        $sql_select="Select sum(bill_credit) as bill_credit";
        //print_r($status_arr1);
        for($j=0;$j<count($status_arr1);$j++)
        {
          $stat=$status_arr1[$j];
          $table_head.="<th>$stat</th>";
          
          $sql_select.=",sum(if(status='$stat',bill_credit,0))as `$stat`";

        }

        $table_head.="</tr>";



        if($user_role=='mds_usr')
        {
          $sql_select.=",created_date,id,sender from `voice_user_summary` where date(created_date) between '$from_dt' and '$to_dt' and userid='".$u_id."' group by MONTH(created_date)";
        }
        else if($user_role=='mds_adm'){
          $sql_select.=",created_date,id,userid,sender from `voice_user_summary` where date(created_date) between '$start_month' and '$end_month' and userid='".$selected_userid."'  group by MONTH(created_date),userid,sender"; 
        }
        else if($user_role=='mds_ad' || $user_role=='mds_rs')
        {
          $selected_user_role=$_REQUEST['selected_user_role'];
          if($selected_user_role=='mds_usr')
          {
            $sql_select.=",created_date,id,sender from `voice_user_summary` where date(created_date) between '$start_month' and '$end_month' and userid='".$selected_userid."'  group by MONTH(created_date),sender"; 
          }
          else if($selected_user_role=='mds_rs')
          {
            $userid_arr[]=$selected_userid;
              $child_users=get_childUsers($userid_arr);

                        foreach ($child_users as $child_val) {
                          foreach($child_val as $val)
                          {
                            $single_arr[]=$val;
                          }
                        }

                        $only_Users=get_onlyUsers($single_arr);
                        if(!empty($only_Users))
                        {
                           $check_user_ids=implode(",",$only_Users);
                        }


                  $sql_select.=",created_date,id,sender from `voice_user_summary` where date(created_date) between '$start_month' and '$end_month' and userid in ($check_user_ids)  group by MONTH(created_date),sender"; 
          }
          else if($selected_user_role=='All')
          {
              $userid_arr[]=$u_id;
              $child_users=get_childUsers($userid_arr);

                        foreach ($child_users as $child_val) {
                          foreach($child_val as $val)
                          {
                            $single_arr[]=$val;
                          }
                        }

                        $only_Users=get_onlyUsers($single_arr);
                        if(!empty($only_Users))
                        {
                           $check_user_ids=implode(",",$only_Users);
                        }


                  $sql_select.=",created_date,id,userid,sender from `voice_user_summary` where date(created_date) between '$start_month' and '$end_month' and userid in ($check_user_ids)  group by MONTH(created_date),userid,sender"; 
          }
        }

    $result_select = mysqli_query($dbc, $sql_select);

      $count_record=mysqli_num_rows($result_select);
      if($count_record>0)
      {
        $total_bill_credit=0;
        while($row=mysqli_fetch_array($result_select))
        {
          $created_date=date('F Y',strtotime($row['created_date']));
          $bill_credit=$row['bill_credit'];
          $useridss=$row['userid'];
          $sender=$row['sender'];
          $username=get_username($useridss);
          $table_body.="<tr>
          <td>$created_date</td>
          <td>$username</td>
          <td>$sender</td>
          <td>$bill_credit</td>";
          for($j=0;$j<count($status_arr1);$j++)
          {
            $stat=$status_arr1[$j];
            $stat_val=$row[$stat];
            $total_bill_credit+=$stat_val;
            $per=($stat_val/$bill_credit)*100;
            $per=round($per,2);
            $table_body.="<td>$stat_val <br>($per %)</td>";

          }
          $table_body.="</tr>";
        }

        $table_body.="<tr>  <td></td>
          <td></td>
          <td></td>
          <td>$total_bill_credit</td></tr>";
      }
      else
      {
        $table_body.="No record available";
      }
      
          return $table_head.$table_body;
      }


        return $table_head;
  }


   	function monthlyMISReport(){
  		global $dbc;
  		$result_monthly_mis_report = array();
  		$selected_userid=$_REQUEST['selected_userid'];
  	
  		$current_date = date("Y-m-d");
  		$u_id=$_SESSION['user_id'];
  		$user_role=$_SESSION['user_role'];
  		$start_month=date("Y")."-01-01";
  		$end_month = date("Y")."-12-31";

  		if($user_role=='mds_usr')
  		{

  		 $sql = "select sum(bill_credit) as bill_credit,status,created_date,id from `voice_user_summary` where userid='".$u_id."' and date(created_date) between '$start_month' and '$end_month' group by status,MONTH(created_date)";
  		}
  		else if($user_role=='mds_adm'){
  			$sql = "select sum(bill_credit) as bill_credit,status,created_date,id from `voice_user_summary` where userid='".$selected_userid."' and  date(created_date) between '$start_month' and '$end_month' group by status,MONTH(created_date)";
  		}
  		else if($user_role=='mds_ad' || $user_role=='mds_rs')
  		{
  			$selected_user_role=$_REQUEST['selected_user_role'];
  			if($selected_user_role=='mds_usr')
  			{
  				$sql = "select sum(bill_credit) as bill_credit,status,created_date,id from `voice_user_summary` where userid='".$selected_userid."' and  date(created_date) between '$start_month' and '$end_month' group by status,MONTH(created_date)";
  			}
  			else if($selected_user_role=='mds_rs')
  			{
  				$userid_arr[]=$selected_userid;
        		$child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                      $only_Users=get_onlyUsers($single_arr);
                      if(!empty($only_Users))
                      {
                      	 $check_user_ids=implode(",",$only_Users);
                      }
  				$sql = "select sum(bill_credit) as bill_credit,status,created_date,id from `voice_user_summary` where userid in ($check_user_ids) and  date(created_date) between '$start_month' and '$end_month' group by status,MONTH(created_date)";
  			}
  			else if($selected_user_role=='All')
  			{
  					$userid_arr[]=$u_id;
        		$child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                      $only_Users=get_onlyUsers($single_arr);
                      if(!empty($only_Users))
                      {
                      	 $check_user_ids=implode(",",$only_Users);
                      }
  				$sql = "select sum(bill_credit) as bill_credit,status,created_date,id,userid from `voice_user_summary` where userid in ($check_user_ids) and  date(created_date) between '$start_month' and '$end_month' group by status,MONTH(created_date),userid";
  			}

  			
  		}

  	

  		$values = mysqli_query($dbc, $sql);
  		$i=1;
   	   	while ($value = mysqli_fetch_array($values)) {
   	   		$rid=$value['id'];
   	   		$return_monthly_mis_report[]=$value;
   		    $i++;
   	   	}

   	   	if (!empty($return_monthly_mis_report)) {


	   		foreach ($return_monthly_mis_report as $key => $value) {
	   			
	   			$status[] = $value["status"];
	   			

	   		}

	   		$table_head="<tr>
   			<th>Month</th>
   			<th>User</th>
   			
   			<th>Total Bill</th>";

	   		$status_arr=array_unique($status);
	   		
	   		for($i=0;$i<count($status);$i++)
	   		{
	   			if($status_arr[$i]!='')
	   			{
	   				$status_arr1[]=$status_arr[$i];
	   			}
	   			
	   		}

	   		$sql_select="Select sum(bill_credit) as bill_credit";
	   		//print_r($status_arr1);
	   		for($j=0;$j<count($status_arr1);$j++)
	   		{
	   			$stat=$status_arr1[$j];
	   			$table_head.="<th>$stat</th>";
	   			
	   			$sql_select.=",sum(if(status='$stat',bill_credit,0))as `$stat`";

	   		}

	   		$table_head.="</tr>";



	   		if($user_role=='mds_usr')
	   		{
	   			$sql_select.=",created_date,id from `voice_user_summary` where date(created_date) between '$start_month' and '$end_month' and userid='".$u_id."' group by MONTH(created_date)";
	   		}
	   		else if($user_role=='mds_adm'){
	   			$sql_select.=",created_date,id,userid from `voice_user_summary` where date(created_date) between '$start_month' and '$end_month' and userid='".$selected_userid."'  group by MONTH(created_date),userid";	
	   		}
	   		else if($user_role=='mds_ad' || $user_role=='mds_rs')
	  		{
	  			$selected_user_role=$_REQUEST['selected_user_role'];
	  			if($selected_user_role=='mds_usr')
	  			{
	  				$sql_select.=",created_date,id from `voice_user_summary` where date(created_date) between '$start_month' and '$end_month' and userid='".$selected_userid."'  group by MONTH(created_date)";	
	  			}
	  			else if($selected_user_role=='mds_rs')
	  			{
	  				$userid_arr[]=$selected_userid;
	        		$child_users=get_childUsers($userid_arr);

	                      foreach ($child_users as $child_val) {
	                        foreach($child_val as $val)
	                        {
	                          $single_arr[]=$val;
	                        }
	                      }

	                      $only_Users=get_onlyUsers($single_arr);
	                      if(!empty($only_Users))
	                      {
	                      	 $check_user_ids=implode(",",$only_Users);
	                      }


	                $sql_select.=",created_date,id from `voice_user_summary` where date(created_date) between '$start_month' and '$end_month' and userid in ($check_user_ids)  group by MONTH(created_date)";	
	  			}
	  			else if($selected_user_role=='All')
	  			{
	  					$userid_arr[]=$u_id;
	        		$child_users=get_childUsers($userid_arr);

	                      foreach ($child_users as $child_val) {
	                        foreach($child_val as $val)
	                        {
	                          $single_arr[]=$val;
	                        }
	                      }

	                      $only_Users=get_onlyUsers($single_arr);
	                      if(!empty($only_Users))
	                      {
	                      	 $check_user_ids=implode(",",$only_Users);
	                      }


	                $sql_select.=",created_date,id,userid from `voice_user_summary` where date(created_date) between '$start_month' and '$end_month' and userid in ($check_user_ids)  group by MONTH(created_date),userid";	
	  			}
	  		}

 		$result_select = mysqli_query($dbc, $sql_select);

  		$count_record=mysqli_num_rows($result_select);
  		if($count_record>0)
  		{
  			$total_bill_credit=0;
  			while($row=mysqli_fetch_array($result_select))
  			{
  				$created_date=date('F Y',strtotime($row['created_date']));
  				$bill_credit=$row['bill_credit'];
  				$useridss=$row['userid'];
  				
  				$username=get_username($useridss);
  				$table_body.="<tr>
  				<td>$created_date</td>
  				<td>$username</td>
  			
  				<td>$bill_credit</td>";
          
  				for($j=0;$j<count($status_arr1);$j++)
		   		{
		   			$stat=$status_arr1[$j];

		   			$stat_val=$row[$stat];
            $total_stat_val[$stat]=$stat_val;
            
		   			$total_bill_credit+=$stat_val;
		   			$per=($stat_val/$bill_credit)*100;
		   			$per=round($per,2);
		   			$table_body.="<td>$stat_val <br>($per %)</td>";
           // $status_total_count[$stat].="<td>$total_stat_val[$stat]</td>";
		   		}

          
  				$table_body.="</tr>";
  			}

  			$table_body.="<tr>	
          <td></td>
  				<td></td>
          <td></td>
  				<td>$total_bill_credit</td>";
          for($j=0;$j<count($status_arr1);$j++)
          {
            $ii=9;
            $stat=$status_arr1[$j];
            $status_total_count[$stat]=array_sum(array_column($total_stat_val,$stat));
            $total_stat_sum_val=$status_total_count[$stat];
            $table_body.="<td>".$total_stat_sum_val."</td>";
          }
          $table_body.="</tr>";
  		}
  		else
  		{
  			$table_body.="No record available";
  		}
  		
   		    return $table_head.$table_body;
   		}


   	   	return $table_head;
	}

   	function daily_mis_report($result_daily_mis_report,$u_id,$start_date,$end_date) {
   		global $dbc;
   		$i = 1;
   		$user_role=$_SESSION['user_role'];
   		$selected_userid=$_REQUEST['selected_userid'];

   		if (!empty($result_daily_mis_report)) {


   		foreach ($result_daily_mis_report as $key => $value) {
   			
   			$status[] = $value["status"];
   			

   		}

   		
   			$table_head="<tr>
   			<th>Date</th>
   			<th>Total Bill</th>";

   		$status_arr=array_unique($status);


	   		for($k=0;$k<count($status);$k++)
	   		{
	   			if($status_arr[$k]!='')
	   			{
	   				$status_arr1[]=$status_arr[$k];
	   			}
	   			
	   		}

	   		
   		$sql_select="Select sum(bill_credit) as bill_credit";
   		for($j=0;$j<count($status_arr1);$j++)
   		{
   			$stat=$status_arr1[$j];
   			$table_head.="<th>$stat</th>";
   			$sql_select.=",sum(if(status='$stat',bill_credit,0))as `$stat`";

   		}

   		$table_head.="</tr>";

   		if($user_role=='mds_usr')
   		{
   			 $sql_select.=",created_date,id from `voice_user_summary` where date(created_date) between '$start_date' and '$end_date' and userid='".$u_id."' group by date(created_date)";

   		}
   		else if($user_role=='mds_adm')
  		{
  			 $sql_select.=",created_date,id from `voice_user_summary` where date(created_date) between '$start_date' and '$end_date' and userid='".$selected_userid."' group by date(created_date)";
  		}
   		else if($user_role=='mds_ad'){
   			 $sql_select.=",created_date,id from `voice_user_summary` where date(created_date) between '$start_date' and '$end_date' and userid='".$selected_userid."'  group by date(created_date)";

   		}
   		else if($user_role=='mds_ad' || $user_role=='mds_rs')
  		{
  			$selected_user_role=$_REQUEST['selected_user_role'];
  			if($selected_user_role=='mds_usr')
  			{
  				$sql_select.=",created_date,id from `voice_user_summary` where date(created_date) between '$start_date' and '$end_date' and userid='".$selected_userid."'  group by date(created_date)";
  			}
  			else if($selected_user_role=='mds_rs')
  			{
  				  $userid_arr[]=$selected_userid;
        		$child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                      $only_Users=get_onlyUsers($single_arr);
                      if(!empty($only_Users))
                      {
                      	 $check_user_ids=implode(",",$only_Users);
                      }
  				$sql_select.=",created_date,id from `voice_user_summary` where date(created_date) between '$start_date' and '$end_date' and userid in ($check_user_ids) group by date(created_date)";
  			}
  			else if($selected_user_role=='All')
  			{
  				  $userid_arr[]=$u_id;
        		$child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                      $only_Users=get_onlyUsers($single_arr);
                      if(!empty($only_Users))
                      {
                      	 $check_user_ids=implode(",",$only_Users);
                      }
  				$sql_select.=",created_date,id from `voice_user_summary` where date(created_date) between '$start_date' and '$end_date' and userid in ($check_user_ids) group by date(created_date)";
  			}

  			
  		}

  		
  		$result_select = mysqli_query($dbc, $sql_select);

  		$count_record=mysqli_num_rows($result_select);
  		if($count_record>0)
  		{

  			while($row=mysqli_fetch_array($result_select))
  			{
  				$created_date=date('dS F y',strtotime($row['created_date']));
  				$bill_credit=$row['bill_credit'];
  				$table_body.="<tr>
  				<td>$created_date</td>
  				<td>$bill_credit</td>";
  				for($j=0;$j<count($status_arr1);$j++)
		   		{
		   			$stat=$status_arr1[$j];
		   			$stat_val=$row[$stat];
		   			$per=($stat_val/$bill_credit)*100;
		   			$per=round($per,2);
		   			$table_body.="<td>$stat_val <br>($per %)</td>";
		   			

		   		}
  				$table_body.="</tr>";
  			}
  		}
  		else
  		{
  			$table_body.="No record available";
  		}
  		
   		    return $table_head.$table_body;
   		} else {
   		  return "No record available";
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

 	
   	function yearlyMISReport(){
  		global $dbc;

  		$user_role=$_SESSION['user_role'];
  		$result_yearly_mis_report = array();
  		
  		$selected_userid=$_REQUEST['selected_userid'];

  		
  		$u_id=$_SESSION['user_id'];
  		$year=date("Y");
  		$last_one_yr=date("Y",strtotime("-1 year"));
  		$last_two_yr=date("Y",strtotime("-2 year"));
  		$last_three_yr=date("Y",strtotime("-3 year"));
  		$last_four_yr=date("Y",strtotime("-4 year"));


  		if($user_role=='mds_usr')
  		{

  		 $sql = "select sum(bill_credit) as bill_credit,status,created_date,id from `voice_user_summary` where userid='".$u_id."' and YEAR(created_date) in ('$year','$last_one_yr','$last_two_yr','$last_three_yr','$last_four_yr') group by status,YEAR(created_date)";
  		}
  		else if($user_role=='mds_adm')
  		{
  			 $sql = "select sum(bill_credit) as bill_credit,status,created_date,id from `voice_user_summary` where userid='".$selected_userid."' and  YEAR(created_date)  in ('$year','$last_one_yr','$last_two_yr','$last_three_yr','$last_four_yr') group by status,YEAR(created_date)";
  		}
  		else if($user_role=='mds_ad' || $user_role=='mds_rs')
  		{
  			$selected_user_role=$_REQUEST['selected_user_role'];
  			if($selected_user_role=='mds_usr')
  			{
  				$sql = "select sum(bill_credit) as bill_credit,status,created_date,id from `voice_user_summary` where userid='".$selected_userid."' and  YEAR(created_date) in ('$year','$last_one_yr','$last_two_yr','$last_three_yr','$last_four_yr') group by status,YEAR(created_date)";
  			}
  			else if($selected_user_role=='mds_rs')
  			{
  				$userid_arr[]=$selected_userid;
        		$child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                      $only_Users=get_onlyUsers($single_arr);
                      if(!empty($only_Users))
                      {
                      	 $check_user_ids=implode(",",$only_Users);
                      }
  				$sql = "select sum(bill_credit) as bill_credit,status,created_date,id from `voice_user_summary` where userid in ($check_user_ids) and  YEAR(created_date) in ('$year','$last_one_yr','$last_two_yr','$last_three_yr','$last_four_yr') group by status,YEAR(created_date)";
  			}
  			else if($selected_user_role=='All')
  			{
  				$userid_arr[]=$u_id;
        		$child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                      $only_Users=get_onlyUsers($single_arr);
                      if(!empty($only_Users))
                      {
                      	 $check_user_ids=implode(",",$only_Users);
                      }
  				$sql = "select sum(bill_credit) as bill_credit,status,created_date,id from `voice_user_summary` where userid in ($check_user_ids) and  YEAR(created_date) in ('$year','$last_one_yr','$last_two_yr','$last_three_yr','$last_four_yr') group by status,YEAR(created_date)";
  			}

  			
  		}

  		$values = mysqli_query($dbc, $sql);
  		$i=1;
   	   	while ($value = mysqli_fetch_array($values)) {
   	   		$rid=$value['id'];
   	   		$result_yearly_mis_report[]=$value;
   		    $i++;
   	   	}

   	   	if (!empty($result_yearly_mis_report)) {


	   		foreach ($result_yearly_mis_report as $key => $value) {
	   			
	   			$status[] = $value["status"];
	   			

	   		}

	   		$table_head="<tr>
   			<th>Year</th>
   			<th>Total Bill</th>";

	   		$status_arr=array_unique($status);
	   		
	   		for($i=0;$i<count($status);$i++)
	   		{
	   			if($status_arr[$i]!='')
	   			{
	   				$status_arr1[]=$status_arr[$i];
	   			}
	   			
	   		}

	   		$sql_select="Select sum(bill_credit) as bill_credit";
	   		//print_r($status_arr1);
	   		for($j=0;$j<count($status_arr1);$j++)
	   		{
	   			$stat=$status_arr1[$j];
	   			$table_head.="<th>$stat</th>";
	   			
	   			$sql_select.=",sum(if(status='$stat',bill_credit,0))as `$stat`";

	   		}

	   		$table_head.="</tr>";


if($user_role=='mds_usr')
  		{
   	 	$sql_select.=",created_date,id from `voice_user_summary` where YEAR(created_date) in ('$year','$last_one_yr','$last_two_yr','$last_three_yr','$last_four_yr') and userid='".$u_id."' group by YEAR(created_date)";
   	 	}
   	 	else if($user_role=='mds_adm')
   	 	{
   	 		$sql_select.=",created_date,id from `voice_user_summary` where YEAR(created_date) in ('$year','$last_one_yr','$last_two_yr','$last_three_yr','$last_four_yr') and userid='".$selected_userid."' group by YEAR(created_date)";

   	 	}
   	 	else if($user_role=='mds_ad' || $user_role=='mds_rs')
  		{
  			$selected_user_role=$_REQUEST['selected_user_role'];
  			if($selected_user_role=='mds_usr')
  			{
  				$sql_select.=",created_date,id from `voice_user_summary` where YEAR(created_date) in ('$year','$last_one_yr','$last_two_yr','$last_three_yr','$last_four_yr') and userid='".$selected_userid."' group by YEAR(created_date)";

  			}
  			else if($selected_user_role=='mds_rs')
  			{
  				$userid_arr[]=$selected_userid;
        		$child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                      $only_Users=get_onlyUsers($single_arr);
                      if(!empty($only_Users))
                      {
                      	 $check_user_ids=implode(",",$only_Users);
                      }
  				$sql_select.=",created_date,id from `voice_user_summary` where YEAR(created_date) in ('$year','$last_one_yr','$last_two_yr','$last_three_yr','$last_four_yr') and userid in ($check_user_ids) group by YEAR(created_date)";

  			}
  			else if($selected_user_role=='All')
  			{
  				$userid_arr[]=$u_id;
        		$child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                      $only_Users=get_onlyUsers($single_arr);
                      if(!empty($only_Users))
                      {
                      	 $check_user_ids=implode(",",$only_Users);
                      }
  				$sql_select.=",created_date,id from `voice_user_summary` where YEAR(created_date) in ('$year','$last_one_yr','$last_two_yr','$last_three_yr','$last_four_yr') and userid in ($check_user_ids) group by YEAR(created_date)";

  			}

  			
  		}
   	
 		$result_select = mysqli_query($dbc, $sql_select);

  		$count_record=mysqli_num_rows($result_select);
  		if($count_record>0)
  		{

  			while($row=mysqli_fetch_array($result_select))
  			{
  				$created_date=date('Y',strtotime($row['created_date']));
  				$bill_credit=$row['bill_credit'];
  				$table_body.="<tr>
  				<td>$created_date</td>
  				<td>$bill_credit</td>";
  				for($j=0;$j<count($status_arr1);$j++)
		   		{
		   			$stat=$status_arr1[$j];
		   			$stat_val=$row[$stat];
		   			$per=($stat_val/$bill_credit)*100;
		   			$per=round($per,2);
		   			$table_body.="<td>$stat_val <br>($per %)</td>";
		   			

		   		}
  				$table_body.="</tr>";
  			}
  		}
  		else
  		{
  			$table_body.="No record available";
  		}
  		
   		    return $table_head.$table_body;
   		}


   	   	return $table_head;


  		/*$result_yearly_mis_report = array();
  		  		
  		$year=date("Y");
  		$u_id=$_SESSION['user_id'];
  		$sql = "select sum(bill_credit) as bill_credit,sum(if(status='Delivered',bill_credit,0))as Delivered,sum(if(status='submitted',bill_credit,0))as submitted,sum(if(status='Failed',bill_credit,0))as Failed,sum(if(status='Rejected',bill_credit,0))as Rejected,sum(if(status='DND',bill_credit,0))as DND,sum(if(status='Block',bill_credit,0))as Block,sum(if(status='Spam',bill_credit,0))as Spam,sum(if(status='NULL',bill_credit,0))as null_stat,sum(if(status='Refund',bill_credit,0))as Refund,sum(if(status='Smart',bill_credit,0))as Smart,created_date,id from `voice_user_summary` where userid='".$u_id."' and YEAR(created_date)='$year' group by STR_TO_DATE(created_date,'%Y')";

  		$values = mysqli_query($dbc, $sql);
  		$i=1;
   	   	while ($value = mysqli_fetch_assoc($values)) {
   	   		$r_id = $row['id'];
   	   		$created_at = $value["created_date"];
   			$created_at=date("Y",strtotime($created_at));
   			$msgcredit = $value['bill_credit'];
   			$status = $value["status"];
   			$Delivered = $value['Delivered'];
   			$submitted = $value['submitted'];
   			$Failed = $value['Failed'];
   			$Rejected = $value['Rejected'];
   			$DND = $value['DND'];
   			$Block = $value['Block'];
   			$Spam = $value['Spam'];
   			$NULL = $value['null_stat'];
   			$Refund = $value['Refund'];
   			$Smart = $value['Smart'];
   		    $return_yearly_mis_report .= 
   		    		"<tr>
   		    			<td>$created_at</td>
   		    			<td>$msgcredit</td>
   		    			
   		    			<td>$Delivered</td>
   		    			<td>$submitted</td>
   		    			<td>$Failed</td>
   		    			<td>$Rejected</td>
   		    			<td>$DND</td>
   		    			<td>$Block</td>
   		    			<td>$Spam</td>
   		    			<td>$NULL</td>
   		    			<td>$Refund</td>
   		    			<td>$Smart</td>
   		    		</tr>";
   		    	$i++;
   	   	}
   	   	return $return_yearly_mis_report;*/
	}

	function get_childUsers($userid)
{
  global $dbc;
  $ids = array();
  static $child=array();
  $userids=implode(",", $userid);
   
        $qry = "SELECT userid FROM az_user WHERE parent_id in ($userids) order by userid desc";
        $rs = mysqli_query($dbc, $qry);
        if(mysqli_num_rows($rs)>0) {
          while($row = mysqli_fetch_array($rs))
          {
            //echo $row['userid'];
            if($row['userid']!=1)
            {
            	$ids[] = $row['userid'];
            }
            
           /* if($row['userid'] == 1 ) {
               $child[]=$ids;
              return $child;
            }*/
          }

          if(!empty($ids)) {
            $child[]=$ids;
              return get_childUsers($ids);
              }
          //return $ids;
          
        }
        else {
      return $child;
    }
}

function get_onlyUsers($userid)
{
  global $dbc;
  $ids = array();

  $userids=implode(",", $userid);
   
        $qry = "SELECT userid FROM az_user WHERE userid in ($userids) and user_role='mds_usr' order by userid desc";
        $rs = mysqli_query($dbc, $qry);
        if(mysqli_num_rows($rs)>0) {
          while($row = mysqli_fetch_array($rs))
          {
            	$ids[]=$row['userid'];
          }

        }

        if(!empty($ids))
        {
        	return $ids;
        }
       
}

?>
