<?php
session_start();
$log_file = "../error/logfiles/branding_controller.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);



include_once('../include/connection.php');
require('classes/ssp.class.php');
include('../include/config.php');
include('classes/last_activities.php');
//include_once('../include/datatable_dbconnection.php');
global $dbc;

if(isset($_REQUEST['list_type']))
{
    $list_type=$_REQUEST['list_type'];

  if($list_type=='url_tracking_summary')
  {


      $result = viewcredit();

            $return_creditlist=credit_list($result);

            echo $return_creditlist;
  
  }
  else if($list_type=='download_report')
    {
      $restricted_report=$_SESSION['restricted_report'];
          
      $msg_job_id=$_SESSION['url_track_msgid'];
       
      $userid=$_SESSION['user_id'];

        /* $sql = "SELECT id,modified_date,click_count,ip_address,device_browser,mobile_number FROM az_tracking_url where msg_job_id='$msg_job_id' ORDER BY created_date DESC";
        $values = mysqli_query($dbc, $sql)or die(mysqli_error($dbc));
*/

        $table="az_tracking_url";
        $extraWhere="msg_job_id='".$msg_job_id."'";
        $fileName = "url_tracking_report_".time().".xls"; 
        $fields_query="mobile_number,device_browser,ip_address,click_count,modified_date ";
        
        $query="select $fields_query from $table where $extraWhere";
        
        $result_download=mysqli_query($dbc,$query);
        $count_rows=mysqli_num_rows($result_download);
          $columnHeader = '';  
        $columnHeader = "Mobile Number" . "\t" . "Browser" . "\t" . "IP Address" . "\t". "Click Count" . "\t". "Clickable Date" . "\t";  
        $setData = '';  

        $columnMap = array(
          
          'mobile_number' => 0
          
        );
        $mobileNumberPosition = $columnMap['mobile_number'];
        while ($rec = mysqli_fetch_row($result_download)) {  

            $rowData = '';  
            foreach ($rec as $key => $value) { 
              
              if($restricted_report=='Yes')
										  {
											  if ($key == $mobileNumberPosition) {
												  $count_len=strlen($value);
												  $value= substr($value, 0, $count_len-6)."XXXXXX";
											  }

											 
											 
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
    else if($list_type=='download_dtls_report')
    {
          
      $from_dt=$_REQUEST['frmDate'];
      $to_dt=$_REQUEST['toDate'];
       
      $userid=$_SESSION['user_id'];

        /* $sql = "SELECT id,modified_date,click_count,ip_address,device_browser,mobile_number FROM az_tracking_url where msg_job_id='$msg_job_id' ORDER BY created_date DESC";
        $values = mysqli_query($dbc, $sql)or die(mysqli_error($dbc));
*/

        $table="az_tracking_url";
        $extraWhere="(date(created_date) between '".$from_dt."' and '".$to_dt."') and userid='".$userid."'";
        $fileName = "url_tracking_detail_report_".time().".xls"; 
        $fields_query="mobile_number,campaign_name,created_date,userid ";
        
        $query="select $fields_query from $table where $extraWhere";
        
        $result_download=mysqli_query($dbc,$query);
        $count_rows=mysqli_num_rows($result_download);
          $columnHeader = '';  
        $columnHeader = "Mobile Number" . "\t" . "Campaign Name" . "\t". "Date" . "\t". "Userid" . "\t";  
        $setData = '';  
        while ($rec = mysqli_fetch_row($result_download)) {  

            $rowData = '';  
            foreach ($rec as $value) {  
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
  else if($list_type=='all_url_tracking')
  {

      $result = viewdtls();

      $return_creditlist=track_list($result);

      echo $return_creditlist;
  
  }
   else if($list_type=='save_msgid')
  {

     $msg_job_id=$_REQUEST['msg_job_id'];
     $_SESSION['msg_job_id']=$msg_job_id;
     echo $msg_job_id;
  
  }
}

function viewcredit() {
        global $dbc;
        $result = array();
        $userid=$_SESSION['user_id'];
        $user_role=$_SESSION['user_role'];
        $frmDate = $_REQUEST["frmDate"];
		    $toDate = $_REQUEST["toDate"];

		    $from_dt_split=explode("-",$frmDate);
		    $frm_year=$from_dt_split[0];
		    $frm_month=$from_dt_split[1];

		    $to_dt_split=explode("-",$toDate);
		    $to_year=$to_dt_split[0];
		    $to_month=$to_dt_split[1];

        $selected_role=$_REQUEST['selected_role'];
        $select_user_id=$_REQUEST['u_id'];
        $extraWhere="";
        $extraWhere.="(STR_TO_DATE(created_date,'%Y-%m-%d') BETWEEN '" . $frmDate . "' AND '" . $toDate . "')";

        if($user_role=='mds_usr')
        {
          $sql = "SELECT id,msg_job_id,created_date,sum(click_count) as total_clicks,userid,campaign_name,msgdata FROM az_tracking_url where userid='$userid'  group by msg_job_id ORDER BY id DESC";
        }
        else if($user_role=='mds_rs' || $user_role=='mds_ad')
        {
						if($selected_role=="User")
						{
							if($select_user_id=="All")
							{
								  $userid=$_SESSION['user_id'];
								  $userid_arr[]=$userid;
                	$child_users=get_childUsers($userid_arr);
                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }
                      $single_arr=array_unique($single_arr);
                      if(!empty($single_arr))
                      {
                      	 $check_user_ids=implode(",",$single_arr);
                      }

                      if(!empty($extraWhere))
                      {
                        $extraWhere.=" and userid in ($check_user_ids) ";
                      }
                      else{
                        $extraWhere.=" userid in ($check_user_ids) ";
                      }
                  $sql = "SELECT id,msg_job_id,created_date,sum(click_count) as total_clicks,userid,campaign_name,msgdata FROM az_tracking_url where $extraWhere  group by msg_job_id ORDER BY id DESC";

              }
              else{

                if(!empty($extraWhere))
                      {
                        $extraWhere.=" and userid =$select_user_id ";
                      }
                      else{
                        $extraWhere.=" userid =$select_user_id ";
                      }


                $sql = "SELECT id,msg_job_id,created_date,sum(click_count) as total_clicks,userid,campaign_name,msgdata FROM az_tracking_url where $extraWhere group by msg_job_id ORDER BY id DESC";
                
              }
            }
            else if($selected_role=="Reseller")
						{
							
              if($select_user_id=='All')
							{
								$all_resellers=fetch_allresellers();
								$userid_arr=$all_resellers;
				                    $child_users=get_childUsers($userid_arr);

				                      foreach ($child_users as $child_val) {
				                        foreach($child_val as $val)
				                        {
				                          $single_arr[]=$val;
				                        }
				                      }

				                     
				                      $single_arr=array_unique($single_arr);
				                   // $only_resellers=get_onlyResellers($single_arr);
				                      if(!empty($single_arr))
				                      {
				                      	 $check_user_ids=implode(",",$single_arr);
				                      }

				        	$check_user_ids=implode(",",$all_resellers);
								
								$extraWhere.=" and userid in (".$check_user_ids.") ";
							}
							else
							{

									          $userid_arr[]=$select_user_id;
				                    $child_users=get_childUsers($userid_arr);

				                      foreach ($child_users as $child_val) {
				                        foreach($child_val as $val)
				                        {
				                          $single_arr[]=$val;
				                        }
				                      }

				                      $single_arr[]=$select_user_id;
				                      $single_arr=array_unique($single_arr);
				                    //$only_resellers=get_onlyResellers($single_arr);
				                      if(!empty($single_arr))
				                      {
				                      	 $check_user_ids=implode(",",$single_arr);
				                      }
				                     
								 $extraWhere.=" and userid in (".$check_user_ids.") ";
							}

              $sql = "SELECT id,msg_job_id,created_date,sum(click_count) as total_clicks,userid,campaign_name,msgdata FROM az_tracking_url where $extraWhere  group by msg_job_id ORDER BY id DESC";

            }
        }
        else
        {
          $sql = "SELECT id,msg_job_id,created_date,sum(click_count) as total_clicks,userid,campaign_name,msgdata FROM az_tracking_url  group by msg_job_id ORDER BY id DESC";
        }
        //echo "test".$sql;
        $values = mysqli_query($dbc, $sql)or die(mysqli_error($dbc));
        while ($row = mysqli_fetch_assoc($values)) {
            $crmid = $row['id'];
            $result[$crmid] = $row;
        }
        return $result;
    }

    function fetch_allresellers()
    {
      global $dbc;
    
      $sql="select userid from az_user where user_role='mds_rs' and user_status=1";
    
      $result=mysqli_query($dbc,$sql);
      $count=mysqli_num_rows($result);
      if($count>0)
      {
        while($row=mysqli_fetch_array($result))
        {
          $rs_ids[]=$row['userid'];
    
        }
    
        if(!empty($rs_ids))
        {
          return $rs_ids;
        }
        
      }
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

function credit_list($result)
{
          $i = 1;
          $user_role=$_SESSION['user_role'];

          if (!empty($result)) { 
         
           foreach ($result as $key => $value) { 
 
            $userid=$value['userid'];
            $username=fetch_username($userid);
            $campaign_name=$value['campaign_name'];
            $msg_job_id=$value['msg_job_id'];
            $total_click=$value['total_clicks'];
            $msg=urldecode($value['msgdata']);
            
            $created_dt=date("d-M-Y h:i a",strtotime($value['created_date']));

              $return_creditlist.="<tr style='text-align:center;'>";
              if($user_role!='mds_usr')
              {
                $return_creditlist.="<td width='5%'>$username</td>";
              }
              
              $return_creditlist.="
              <td width='5%'>$msg_job_id</td>
              <td width='5%'>$msg</td>
               <td width='5%'>$campaign_name</td>
              <td width='5%'>$created_dt</td>
              <td width='5%'><button class='btn btn-primary btn-sm me-1 mb-1 url_tracking_dtls_btn' type='button'  data-msgid='".$msg_job_id."' > $total_click
                </button>&nbsp;</td>
              </tr>";
            
                $i++;
                }

                return $return_creditlist;
          } 
          else
          {
            return "No record available";
          }
}


function viewdtls() 
{
        global $dbc;
        $result = array();
        $userid=$_SESSION['user_id'];

        $msg_job_id=$_SESSION['msg_job_id'];
         $_SESSION['url_track_msgid']=$msg_job_id;       
        $sql = "SELECT id,modified_date,click_count,ip_address,device_browser,mobile_number,city FROM az_tracking_url where msg_job_id='$msg_job_id' ORDER BY created_date DESC";
        $values = mysqli_query($dbc, $sql)or die(mysqli_error($dbc));
        while ($row = mysqli_fetch_assoc($values)) {
            $crmid = $row['id'];
            $result[$crmid] = $row;
        }
        return $result;
}

        function track_list($result)
        {
          $i = 1;
          $user_role=$_SESSION['user_role'];
          $restricted_report=$_SESSION['restricted_report'];

          if (!empty($result)) { 
         
           foreach ($result as $key => $value) { 
 
           
           /* $modified_date=$value['modified_date'];*/
            $click_count=$value['click_count'];
            $ip_address=$value['ip_address'];
             $device_browser=$value['device_browser'];
             $mobile_number=$value['mobile_number'];
             if($restricted_report=='Yes')
             {
              $count_len=strlen($mobile_number);
              $mobile_number= substr($mobile_number, 0, $count_len-6)."XXXXXX";
             }
             

             $city=$value['city'];

            
            $modified_date=date("d-M-Y h:i a",strtotime($value['modified_date']));
              $return_creditlist.="<tr style='text-align:center;'>";
            
              $return_creditlist.="
              <td width='5%'>$mobile_number</td>
               <td width='5%'>$device_browser</td>
              <td width='5%'>$ip_address</td>
              <td width='5%'>$city</td>
              <td width='5%'>$click_count</td>
              <td width='5%'>$modified_date</td>
             
              </tr>";
            
                $i++;
                }

                return $return_creditlist;
          } 
          else
          {
            return "No record available";
          }
        }

    function fetch_username($userid) {
        global $dbc;
        $result = array();
        $sql = "SELECT *  FROM `az_user` where `userid`='$userid'";
        $values = mysqli_query($dbc, $sql)or die(mysqli_error($dbc));
        while ($row = mysqli_fetch_assoc($values)) {
            $username = $row['user_name'];
            
        }
        return $username;
    }