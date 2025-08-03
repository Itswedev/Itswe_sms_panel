<?php
session_start();

include_once('../include/connection.php');
include('classes/last_activities.php');


// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

 error_reporting(0);


if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'save_longcode') {
   $rs = saveLongcode();
  	if($rs=='1')
  	{
  		echo 1;
  	}
  	else
  	{
		echo $rs;
  	}

 


}
else if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'update_longcode') {
    $rs = updateLongcode();
       if($rs=='1')
       {
           echo 1;
       }
       else
       {
         echo $rs;
       }
 
  
 
 
 }
else if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'load_service_number') {
   $rs = load_service_number();
  	echo $rs;
}
else if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'longcode_report') {
   $rs = load_longcode_report();
  	return $rs;
}
else if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'download_longcode_report') {
    global $dbc;
          $userid=$_SESSION['user_id'];
     $user_role=$_SESSION['user_role'];
     $today_dt=date("Y-m-d");
        $service_number=$_REQUEST['service_number'];
     $frmDate=$_REQUEST['frmDate'];
     $toDate=$_REQUEST['toDate'];
     $fileName = "longcode_report".time().".xls"; 
     $fields_query="longcode,sender,message,resp_time,userid";
     if($user_role=="mds_adm")
     {

        if(!empty($frmDate) && !empty($toDate))
        {
             if($service_number=='All')
             {
                 $extrawhere = " where date(created_date) between '".$frmDate."' and '".$toDate."'  ORDER BY created_date DESC";
             }
             else
             {
                $extrawhere = " where longcode='".$service_number."' and date(created_date) between '".$frmDate."' and '".$toDate."'  ORDER BY created_date DESC";
             }
        }
        else
        {
             if($service_number=='All')
             {
                $extrawhere = " where date(created_date)='".$today_dt."'  ORDER BY created_date DESC";
             }
             else
             {
                $extrawhere = " where longcode='".$service_number."' and date(created_date)='".$today_dt."'  ORDER BY created_date DESC";
             }  
        }
            
            
     }
     else
     {

        if(!empty($frmDate) && !empty($toDate))
        {

                if($service_number=='All')
                {
                     $extrawhere = " where  userid='".$userid."' and date(created_date) between '".$frmDate."' and '".$toDate."' ORDER BY created_date DESC";
                }
                else
                {
                    $extrawhere = " where longcode='".$service_number."' and userid='".$userid."' and date(created_date) between '".$frmDate."' and '".$toDate."' ORDER BY created_date DESC";
        
                }
       }else
       {
            if($service_number=='All')
                {
                     $extrawhere = " where  userid='".$userid."' ORDER BY created_date DESC";
                }
                else
                {
                    $extrawhere = " where longcode='".$service_number."' and userid='".$userid."' ORDER BY created_date DESC";
        
                }
       }
     }
  
    $query="select ".$fields_query." from longcode_report ". $extrawhere;
    
    $result_download=mysqli_query($dbc,$query);
                $count_rows=mysqli_num_rows($result_download);
                $columnHeader = '';  
                $columnHeader = "Longcode" . "\t" . "Sender" . "\t". "Message" . "\t". "Response Time" . "\t". "Username" . "\t";  
                $setData = '';  

                while ($rec = mysqli_fetch_row($result_download)) {  
                    $rowData = '';  
                    for($i=0;$i<count($rec);$i++) {
                       if($i==4)
                        {
                            $username=get_username($rec[$i]); 

                            $value=$username; 
                            
                        }
                        else
                        {
                            $value=$rec[$i];  
                        }
                        
                        $value = '"' . $value . '"' . "\t";  
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
else if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'all_longcode')
{
    global $dbc;
    $user_role=$_SESSION['user_role'];
      $table = 'vas';
      $userid=$_SESSION['user_id'];

      if($user_role=='mds_adm')
          {
            $sql="select * from vas where vas_type='longcode' order by created_dt desc";
            $result=mysqli_query($dbc,$sql);
            while($row=mysqli_fetch_array($result))
            {
                $username=get_username($row['userid']);
             
                $uid=$row['userid'];
                $status=$row['status'];
                $get_response=$row['get_response'];
                $longcode=$row['longcode'];
                $end_point=$row['end_point'];
                $end_point_config=$row['end_point_config'];
                $status=$row['status'];
                $format=$row['format'];
               
                $created_dt=$row['created_dt'];
              
                $approved_by=get_username($row['userid']);
                $id=$row['id'];

               
                if($status=='0')
                    {
                        $status_txt="<span style='color:red;'>Inactive</span>";
                    }
                    else
                    {
                        $status_txt="<span style='color:blue;'>Active</span>";
                    }

                  $action="<button class='btn btn-primary btn-sm me-1 mb-1 edit_admin_mulitmedia_btn' type='button' data-bs-toggle='modal' data-bs-target='#edit_admin_multimedia_modal' data-id='".$id."' data-uid='".$uid."' data-longcode='".$longcode."' data-end_point='".$end_point."' data-status='".$status."' data-get_response='".$get_response."' data-end_point_config='".$end_point_config."' data-format='".$format."' >
                 
                      <span class='fas fa-edit ms-1' data-fa-transform='shrink-3'></span>
                    </button>&nbsp;
                    <button class='btn btn-primary btn-sm me-1 mb-1 delete_longcode_btn' type='button'  data-id='".$id."'>
                      <span class='fas fa-trash ms-1' data-fa-transform='shrink-3'></span>
                    </button>";
               
                $table_body.="<tr>";
                $table_body.="<td>$username</td>";
                $table_body.="<td>$longcode</td>";
                $table_body.="<td style='word-break: break-all;'>$end_point</td>";
               
                $table_body.="<td>$status_txt</td>";
              

                $table_body.="<td>$created_dt</td>";
                $table_body.="<td>$action</td>";              
                 $table_body.="</tr>";

            }
            echo $table_body;
          }
/*          else
          {

            $sql="select * from vas where userid='$userid' order by created_dt desc";
            $result=mysqli_query($dbc,$sql);
            while($row=mysqli_fetch_array($result))
            {
                $username=get_username($row['userid']);
                 
                $status=$row['status'];
                $get_response=$row['get_response'];
                $longcode=$row['longcode'];
                $end_point=$row['end_point'];
                $status=$row['status'];
               
                $created_dt=$row['created_dt'];
              
              
                $id=$row['id'];

                if($status=='0')
                    {
                        $status_txt="<span style='color:red;'>Inactive</span>";
                    }
                    else
                    {
                        $status_txt="<span style='color:blue;'>Active</span>";
                    }

                     $action="<button class='btn btn-primary btn-sm me-1 mb-1 edit_admin_mulitmedia_btn' type='button' data-bs-toggle='modal' data-bs-target='#edit_admin_multimedia_modal' data-id='".$id."' >
                 
                      <span class='fas fa-edit ms-1' data-fa-transform='shrink-3'></span>
                    </button>&nbsp;
                    <button class='btn btn-primary btn-sm me-1 mb-1 delete_longcode_btn' type='button'  data-id='".$id."' >
                      <span class='fas fa-trash ms-1' data-fa-transform='shrink-3'></span>
                    </button>
                    ";
               
                $table_body.="<tr>";
            
                $table_body.="<td>$filename</td>";
                $table_body.="<td>$voice_id</td>";
                $table_body.="<td>$file_duration</td>";
                $table_body.="<td>$status_txt</td>";
                $table_body.="<td>$approved_by</td>";

                $table_body.="<td>$created_dt</td>";
                $table_body.="<td>$action</td>";              
                 $table_body.="</tr>";

            }
            echo $table_body; 
          }*/
   
}
else if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'delete_longcode') {
    $rs = delete_longcode();
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

function load_service_number()
{
	 global $dbc;
	 $user_role=$_SESSION['user_role'];
      
      $userid=$_SESSION['user_id'];
     if($user_role=="mds_adm")
	 {
	$sql = "SELECT longcode  FROM vas  where vas_type='longcode' and status=1 ORDER BY created_dt DESC";
 	}
 	else
 	{
 		$sql = "SELECT longcode  FROM vas  where vas_type='longcode' and status=1 and userid='".$userid."' ORDER BY created_dt DESC";
 	}
  
   $service_number_dropdown="<option value=''>Select Service Number</option><option value='All' selected>All</option>";
   $values = mysqli_query($dbc, $sql);
        while ($row = mysqli_fetch_assoc($values)) {
            $longcode = $row['longcode'];
            $service_number_dropdown.="<option value='".$longcode."'>$longcode</option>";
            
        }
           
             return $service_number_dropdown;
}


function load_longcode_report()
{
	 global $dbc;
	 $service_number=$_REQUEST['service_number'];
	 $userid=$_SESSION['user_id'];
	 $user_role=$_SESSION['user_role'];
     $today_dt=date("Y-m-d");

     $frmDate=$_REQUEST['frmDate'];
     $toDate=$_REQUEST['toDate'];

	 if($user_role=="mds_adm")
	 {

        if(!empty($frmDate) && !empty($toDate))
        {
             if($service_number=='All')
             {
                 $sql = "SELECT *  FROM longcode_report where date(created_date) between '".$frmDate."' and '".$toDate."'  ORDER BY created_date DESC";
             }
             else
             {
                $sql = "SELECT *  FROM longcode_report  where longcode='".$service_number."' and date(created_date) between '".$frmDate."' and '".$toDate."'  ORDER BY created_date DESC";
             }
        }
        else
        {
             if($service_number=='All')
             {
                $sql = "SELECT *  FROM longcode_report where date(created_date)='".$today_dt."'  ORDER BY created_date DESC";
             }
             else
             {
                $sql = "SELECT *  FROM longcode_report  where longcode='".$service_number."' and date(created_date)='".$today_dt."'  ORDER BY created_date DESC";
             }  
        }
			
			
	 }
	 else
	 {

        if(!empty($frmDate) && !empty($toDate))
        {

                if($service_number=='All')
                {
	 	             $sql = "SELECT *  FROM longcode_report  where  userid='".$userid."' and date(created_date) between '".$frmDate."' and '".$toDate."' ORDER BY created_date DESC";
	 		    }
                else
                {
                    $sql = "SELECT *  FROM longcode_report  where longcode='".$service_number."' and userid='".$userid."' and date(created_date) between '".$frmDate."' and '".$toDate."' ORDER BY created_date DESC";
        
                }
	   }else
       {
            if($service_number=='All')
                {
                     $sql = "SELECT *  FROM longcode_report  where  userid='".$userid."' ORDER BY created_date DESC";
                }
                else
                {
                    $sql = "SELECT *  FROM longcode_report  where longcode='".$service_number."' and userid='".$userid."' ORDER BY created_date DESC";
        
                }
       }
	 }
  
	
	 $result=mysqli_query($dbc,$sql);
            while($row=mysqli_fetch_array($result))
            {
              
                $longcode=$row['longcode'];
                $keyword=$row['keyword'];
                $message=$row['message'];
                $sender=$row['sender'];
                $userid=$row['userid'];
                $username=get_username($userid);
                $resp_time=$row['resp_time'];

                $table_body.="<tr>";
                $table_body.="<td>$username</td>";
                $table_body.="<td>$longcode</td>";
                $table_body.="<td>$sender</td>";
                $table_body.="<td>$keyword</td>";
                $table_body.="<td>$message</td>";
                $table_body.="<td>$resp_time</td>";         
                $table_body.="</tr>";
            }

            echo $table_body; 
 
}




  function delete_longcode() {
        global $dbc;
        $id=$_REQUEST['id'];
     
       
        $sql = "delete from vas  where id='".$id."'";
        $result = mysqli_query($dbc, $sql);
        if($result)
        {
          
          $u_id=$_SESSION['user_id'];
          get_last_activities($u_id,'Longcode Details Have Been Successfully Removed',@$login_date,@$logout_date);

          return 1;
        }
        else
        {
          return 0;
        }
        
    }




function saveLongcode()
{
          global $dbc;

        $userid=$_SESSION['user_id'];
        $user_role=$_SESSION['user_role'];
        if($user_role=='mds_adm')
        {
            $userid=trim($_REQUEST['username_senderid']);
        }
       // $file_name =trim($_REQUEST['file_name']);
       
        $longcode=$_REQUEST['longcode'];
        $added_by=$_SESSION['user_id'];
        $sql_select = "SELECT * from vas where longcode='$longcode'";
        $query_select = mysqli_query($dbc, $sql_select);
        $count_brand=mysqli_num_rows($query_select);
        
        if($count_brand==0)
        {
			    $template_id='';
			    $senderid='';
			    $route_id=0;
			    $duration2=0;
			    $get_response=$_REQUEST['get_reponse'];
			    $end_point_config=$_REQUEST['end_point_config'];
			    $end_point=$_REQUEST['end_point'];
			    $senderid=$_REQUEST['sid'];
			    $template_id=$_REQUEST['template'];
			    $route_id=$_REQUEST['route_id'];
			    $format=$_REQUEST['format'];
		     if(empty($route_id))
		     {
		         $route_id=0;
		     }
     $vas_type='longcode';
     $sql = "INSERT INTO `vas`(userid,created_dt,get_response,sender_id,template_id,route_id,vas_type,longcode,end_point_config,end_point,format) VALUES ('" . $userid . "',now(),'".$get_response."','".$senderid."','".$template_id."',".$route_id.",'".$vas_type."','".$longcode."','".$end_point_config."','".$end_point."','".$format."')";


            $query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
            if ($query) {
                $u_id=$_SESSION['user_id'];
                get_last_activities($u_id,'Added new Longcode details',@$login_date,@$logout_date);
                unset($_REQUEST);
                return 1;
            } else {
                return 'Failed to insert record !';
            }
            
        }
        else
        {
            return 'Longcode details already exists';
            
        }

       

}




function updateLongcode()
{
          global $dbc;

        $userid=$_SESSION['user_id'];
        $user_role=$_SESSION['user_role'];
        if($user_role=='mds_adm')
        {
            $userid=trim($_REQUEST['username_senderid']);
        }
       // $file_name =trim($_REQUEST['file_name']);
       
        $longcode=$_REQUEST['longcode'];
        $e_id=$_REQUEST['e_id'];
        $added_by=$_SESSION['user_id'];
        $sql_select = "SELECT * from vas where id=$e_id";
        $query_select = mysqli_query($dbc, $sql_select);
        $count_brand=mysqli_num_rows($query_select);
        
        if($count_brand!=0)
        {
			    $template_id='';
			    $senderid='';
			    $route_id=0;
			    $duration2=0;
			    $get_response=$_REQUEST['get_reponse'];
			    $end_point_config=$_REQUEST['end_point_config'];
			    $end_point=$_REQUEST['end_point'];
			    $senderid=$_REQUEST['sid'];
			    $template_id=$_REQUEST['template'];
			    $route_id=$_REQUEST['route_id'];
			    $format=$_REQUEST['format'];
		     if(empty($route_id))
		     {
		         $route_id=0;
		     }
        $vas_type='longcode';
        $sql = "update `vas` set get_response='".$get_response."',sender_id='".$senderid."',template_id='".$template_id."',route_id=".$route_id.",vas_type='".$vas_type."',longcode='".$longcode."',end_point_config='".$end_point_config."',end_point='".$end_point."',format='".$format."' where id=$e_id";

             
            $query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
            if ($query) {
                $u_id=$_SESSION['user_id'];
                get_last_activities($u_id,'Updated new Longcode details',@$login_date,@$logout_date);
                unset($_REQUEST);
                return 1;
            } else {
                return 'Failed to update record !';
            }
            
        }
        else
        {
            return 'Longcode details does not exists';
            
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
?>