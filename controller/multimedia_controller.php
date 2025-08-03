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
require('classes/MP3File.php');

include('../include/config.php');

include('classes/last_activities.php');
//include_once('../include/datatable_dbconnection.php');
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

error_reporting(0);


if (isset($_POST['type']) && $_POST['type'] == 'savemultimedia') {
    $rs = saveMultimedia();
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
else if (isset($_POST['type']) && $_POST['type'] == 'savecallerid') {
    $rs = saveCallerId();
    echo $rs;
}
else if (isset($_POST['type']) && $_POST['type'] == 'load_sender_id') {
    $rs = load_sender_id();
    echo $rs;
}
else if (isset($_POST['type']) && $_POST['type'] == 'load_route_id') {
    $rs = load_route_id();
    echo $rs;
}
else if (isset($_POST['type']) && $_POST['type'] == 'load_template_with_sid') {
   $userid=$_REQUEST['selected_userid'];
    $template_dropdown=template_dropdown($userid);
    echo $template_dropdown;
}
else if(isset($_POST['type']) && $_POST['type'] =='today_report')
    {

        $sendtabledetals = SENDCALLDETAILS;
        $select_user_id=$_REQUEST['uid'];
        $today_dt=date('Y-m-d');

        $report_type=$_REQUEST['report_type'];
        $table = $sendtabledetals;

        $primaryKey = 'id';

            $columns = array(
            /*  array( 'db' => 'id','dt' => 0 ),
*/              array( 'db' => 'caller_id','dt' => 0 ),
                array( 'db' => 'mobile_number','dt' => 1,'formatter' => function( $d, $row ) {

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
                       
                    } ),
                array( 'db' => 'userid','dt' => 2 ,'formatter' => function( $d, $row ) {
                        $username=get_username($d);
                        return $username;
                    }),
                array( 'db' => 'file_name','dt' => 3 ),
                array( 'db' => 'msgcredit','dt' => 4),
                array( 'db' => 'master_job_id','dt' => 5),
                array( 'db' => 'call_duration','dt' => 6),
               /* array( 'db' => 'id','dt' => 8 ),*/
                array( 'db' => 'status','dt' => 7 ),
                array(
                    'db'        => 'sent_at',
                    'dt'        => 8,
                    'formatter' => function( $d, $row ) {
                        return date( 'Y-m-d h:i', strtotime($d));
                    }
                ),
                array( 'db' => 'call_ans_time','dt' => 9,'formatter' => function( $d, $row ) {

                        if($d!='')
                        {
                            return date( 'Y-m-d h:i', strtotime($d));
                        }
                        else
                        {
                            return '-';
                        }
                        
                    })
                /*array( 'db' => 'id','dt' => 12 )*/
            );
             
            // SQL server connection information
            global $sql_details ;

            $extraWhere=" (date(sent_at)='$today_dt')";
            if($report_type=="total")
            {
                $extraWhere=" (date(sent_at)='$today_dt')";
                
            }
        

            if($report_type!="total")
            {
                if($extraWhere!="")
                {
                    $extraWhere.="and status='".$report_type."'";

                }
                else
                {
                    $extraWhere="status='".$report_type."'";
                }

            }
            else if($report_type=="" || $report_type=='total')
            {

            }
        


        
            $user_role=$_REQUEST['user_role'];
            $userid=$_SESSION['user_id'];
            $select_user_id=$_REQUEST['uid'];

            if($user_role=='mds_rs' || $user_role=='mds_ad')
            {

                $selected_role=$_REQUEST['selected_role'];

            if($selected_role=="User")
            {
                $userid=$_REQUEST['uid'];

                if($userid=="All")
                {
                    $parent_id=$_SESSION['user_id'];
                    /*$user_ids=fetch_userids($parent_id);
                    $check_user_ids=implode(",",$user_ids);*/

                    if($extraWhere!="")
                    {
                        $extraWhere.=" and `parent_id`='".$parent_id."' and schedule_sent=1 ";
                    }
                    else
                    {

                        $extraWhere="`userid` in ($userid) and schedule_sent=1 ";
                    }
                }
                else
                {

                    if($extraWhere!="")
                    {
                        $extraWhere.=" and `userid` in ($userid) and schedule_sent=1 ";
                    }
                    else
                    {

                        $extraWhere="`userid` in ($userid) and schedule_sent=1 ";
                    }
                }

            }
            else if($selected_role=="Reseller")
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
                      $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                         $check_user_ids=implode(",",$only_resellers);
                      }

                    if($extraWhere!="")
                    {
                        $extraWhere.=" and `parent_id` in ($check_user_ids) and schedule_sent=1 ";
                    }
                    else
                    {
                        $extraWhere="`parent_id` in ($check_user_ids) and schedule_sent=1 ";
                    }
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
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                         $check_user_ids=implode(",",$only_resellers);
                      }
                    if($extraWhere!="")
                    {
                        $extraWhere.=" and `parent_id` in ($check_user_ids) and schedule_sent=1 ";
                    }
                    else
                    {

                        $extraWhere="`parent_id` in ($check_user_ids) and schedule_sent=1 ";
                    }
                }

        }


            }
    else if($user_role=='mds_adm')
    {
        
        $selected_role=$_REQUEST['selected_role'];


        if($selected_role=="User")
        {
            if($select_user_id!="" && $select_user_id!="All")
            {

                $check_user_ids=$select_user_id;
                $extraWhere.=" and `userid` in ($check_user_ids) and schedule_sent=1 ";
            }
            else
            {

                $user_ids=fetch_allusers();
                $check_user_ids=implode(",",$user_ids);
                $extraWhere.=" and `userid` in ($check_user_ids) and schedule_sent=1 ";
            }
        }
        else if($selected_role=="Reseller")
        {
            if($select_user_id=='All')
            {
                $all_resellers=fetch_allresellers();

        $check_user_ids=implode(",",$all_resellers);

            
                $extraWhere.=" and `parent_id` in ($check_user_ids) and schedule_sent=1 ";
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
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                         $check_user_ids=implode(",",$only_resellers);
                      }
                     
                 $extraWhere.=" and `parent_id` in ($check_user_ids) and schedule_sent=1 ";
            }
        }
        else if($selected_role=="Admin")
        {
            if($select_user_id=='All')
            {
                $all_admins=fetch_alladmins();

                $userid_arr=$all_admins;
                
        $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                    $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                         $check_user_ids=implode(",",$only_resellers);
                      }
            $extraWhere.=" and `parent_id` in ($check_user_ids) and schedule_sent=1 ";
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

                     
                      $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                         $check_user_ids=implode(",",$only_resellers);
                      }
                     
                $extraWhere.=" and `parent_id` in ($check_user_ids) and schedule_sent=1 ";
            }
        }
        else if($selected_role=="All")
            {
                $userid=$_REQUEST['uid'];

                if($userid=="All")
                {
                    $parent_id=$_SESSION['user_id'];
                    /*$user_ids=fetch_userids($parent_id);
                    $check_user_ids=implode(",",$user_ids);*/

                    if($extraWhere!="")
                    {
                        $extraWhere.=" and `parent_id`='".$parent_id."' and schedule_sent=1 ";
                    }
                    else
                    {

                        $extraWhere="`userid` in ($userid) and schedule_sent=1 ";
                    }
                }
                else
                {

                    if($extraWhere!="")
                    {
                        $extraWhere.=" and `userid` in ($userid) and schedule_sent=1 ";
                    }
                    else
                    {

                        $extraWhere="`userid` in ($userid) and schedule_sent=1 ";
                    }
                }

            }
    }
        else
            {

                    if($extraWhere!="")
                    {
                        $extraWhere.=" and `userid` in ($userid) and schedule_sent=1 ";
                    }
                    else
                    {

                        $extraWhere="`userid` in ($userid) and schedule_sent=1 ";
                    }
            }

            
             
            echo json_encode(
                SSP::complex( $_REQUEST, $sql_details, $table, $primaryKey, $columns,$test=null,$extraWhere )
            );

    }
else if(isset($_POST['type']) && $_POST['type'] =='send_voice_job_data')
    {

        $rs=load_send_job_data();
    //  print_r($rs);
        $rs1=load_status($rs);


    //  print_r($rs1);
        if($rs1!=0)
        {
                $res=array_merge($rs,$rs1);
        }
    
  
    if($res!=0)
        {
            echo json_encode($res);
        }
        else
        {
            //echo 0;
        }

    }
    else if(isset($_POST['type']) && $_POST['type'] =='send_voice_job_table_dtls')
    {
                global $dbc;
                $rs=load_send_job_data();
                $job_id=$_REQUEST['job_id'];
                $message_job_id=$rs[0]['job_id'];

                $message_id=$rs[0]['id'];
                $sendtabledetals = SENDCALLDETAILS;
                $job_date=date("Y-m-d",strtotime($_REQUEST['job_date']));
    
            $today_dt=date("Y-m-d");

            $yesterday_dt=date("Y-m-d",strtotime("-1 day"));
            if($job_date!=$today_dt)
            {
                $report_yr=date("Y",strtotime($job_date));
                $report_mt=date("m",strtotime($job_date));
                $sendtabledetals=SENDCALLDETAILS.$report_yr.$report_mt;
            }

            
            /*
                if($job_date==$yesterday_dt)
                {
                    
                    $report_yr=date("Y",strtotime($job_date));
                    $report_mt=date("m",strtotime($job_date));
                    $sendtable=SENDCALL.$report_yr.$report_mt;
                }*/


            $today_dt=date('Y-m-d');
        
            $table = $sendtabledetals;

            $primaryKey = 'id';

            $columns = array(
            array( 'db' => 'id','dt' => 0 ),
                array( 'db' => 'route','dt' => 1 ),
                array( 'db' => 'mobile_number','dt' => 2 ,'formatter' => function( $d, $row ) {

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
                       
                    }),
                array( 'db' => 'file_name','dt' => 3 ),
                array( 'db' => 'call_duration','dt' => 4),
                array( 'db' => 'call_ans_time','dt' => 5,'formatter' => function( $d, $row ) {
                     if($row[5]==0)
                     {
                        $ans_time = '00-00-0000 00:00:00';
                     }
                     else
                     {
                        $ans_time = date("d-m-Y h:i a",$row[5]);
                     }

                    


                    return $ans_time;
                }),
                array( 'db' => 'master_job_id','dt' => 6),
               /* array( 'db' => 'id','dt' => 7),*/
                array( 'db' => 'status','dt' => 7),
                array( 'db' => 'input','dt' => 8),
            
            
               /* array( 'db' => 'id','dt' => 11)*/
               
            );
             
            // SQL server connection information
            global $sql_details ;

            $extraWhere="";
             
             if ($_REQUEST['frmDate'] != "" && $_REQUEST['toDate'] != "") {
                $frmDate = $_REQUEST["frmDate"];
                $toDate = $_REQUEST["toDate"];
                if($extraWhere!="")
                {

                $extraWhere.="and (STR_TO_DATE(sent_at,'%Y-%m-%d') BETWEEN '" . $frmDate . "' AND '" . $toDate . "')";
                }
                else
                {
                     $extraWhere="(STR_TO_DATE(sent_at,'%Y-%m-%d') BETWEEN '" . $frmDate . "' AND '" . $toDate . "')";
                }
            }
            else
            {
                $extraWhere="";
            }

            $userid=$_SESSION['user_id'];

            /*if($extraWhere!="")
            {
                $extraWhere.=" and `userids`='$userid'";
            }
            else
            {

                $extraWhere="`userids`='$userid'";
            }*/
             

             if($job_id!='')
             {
                    if($extraWhere!="")
                    {
                        $extraWhere.="  and msg_job_id='$message_job_id'";
                    }
                    else
                    {

                        $extraWhere=" msg_job_id='$message_job_id'";
                    }
             }
            echo json_encode(
                SSP::complex( $_REQUEST, $sql_details, $table, $primaryKey, $columns,$test=null,$extraWhere )
            );


    }
else if (isset($_POST['type']) && $_POST['type'] == 'voice_call_summary_report') {
        session_start();
        $sendtable = SENDCALL . CURRENTMONTH;
        /*$sendtabledetals = SENDSMSDETAILS . CURRENTMONTH;*/
        $table = $sendtable;

        $extraWhere="";
         
        if ($_REQUEST['frmDate'] != "" && $_REQUEST['toDate'] != "") {
            $frmDate = $_REQUEST["frmDate"];
            $toDate = $_REQUEST["toDate"];

            $from_dt_split=explode("-",$frmDate);
            $frm_year=$from_dt_split[0];
            $frm_month=$from_dt_split[1];

            $to_dt_split=explode("-",$toDate);
             $to_year=$to_dt_split[0];
            $to_month=$to_dt_split[1];

            if($frm_month==$to_month && $frm_year==$to_year)
            {
                    $sendtable = SENDCALL .$frm_year.$frm_month;
                    $senddtlstable = SENDCALLDETAILS .$frm_year.$frm_month;
                    $table = $sendtable;
            }

            $extraWhere.="(date(sent_at) BETWEEN '" . $frmDate . "' AND '" . $toDate . "')";


        } else {
            $extraWhere="";
        }

        $primaryKey = 'id';

        $columns = array(
        /*  array('db' => 'id', 'dt' => 0),*/
            array('db' => 'job_id', 'dt' => 0,
                'formatter' => function($d, $row) {
                    global $table,$sendtabledetals;
                    session_start();
                    
                        return "<a href='dashboard.php?page=voice_call_dtls&job_id=$d&table_name=$table&job_date=$row[1]'>$d</a>";
                    }
            ),
                array('db' => 'sent_at', 'dt' => 1, 
                'formatter' => function($d, $row) {
                    return date( 'Y-m-d h:i', strtotime($d));
                }),
                array('db' => 'userid','dt' => 2,'formatter' => function($d, $row) {
                $username=get_username($d);
                    return $username;
                }),
                array('db' => 'route','dt' => 3),
                array('db' => 'caller_id','dt' => 4),
                array('db' => 'campaign_name','dt' => 5),
                array('db' => 'file_name','dt' => 6),
                array('db' => 'msgcredit','dt' => 7,'formatter' => function($d, $row) {
                $numbers_count=$row[8];
                    return $d*$numbers_count;
               
                }),
                array('db' => 'numbers_count','dt' => 8)
          
            
        );
         
        // SQL server connection information
        global $sql_details ;


        $userid=$_SESSION['user_id'];
        $user_role=$_REQUEST['user_role'];
        if($user_role=='mds_rs' || $user_role=='mds_ad')
        {

                $selected_role=$_REQUEST['selected_role'];

                if($selected_role=="User")
                {
                    $userid=$_REQUEST['uid'];

                    if($userid=="All")
                    {
                        $parent_id=$_SESSION['user_id'];
                        $user_ids=fetch_userids($parent_id);
                        $check_user_ids=implode(",",$user_ids);

                        if($extraWhere!="")
                        {
                            $extraWhere.=" and `userid` in ($check_user_ids) and schedule_sent='1'";
                        }
                        else
                        {

                            $extraWhere="`userid` in ($check_user_ids) and schedule_sent='1'";
                        }
                    }
                    else
                    {

                        if($extraWhere!="")
                        {
                            $extraWhere.=" and `userid` in ($userid) and schedule_sent='1'";
                        }
                        else
                        {

                            $extraWhere="`userid` in ($userid) and schedule_sent='1'";
                        }
                    }

                }
                else if($selected_role=="Reseller")
            {
                $userid=$_REQUEST['uid'];

                    if($userid=="All")
                    {
                        $session_userid=$_SESSION['user_id'];
                        $parent_resellers=fetch_resellers($session_userid);
                        $check_parent_ids=implode(",",$parent_resellers);
                        $user_ids=fetch_userids_by_resellers($check_parent_ids);
                        $check_user_ids=implode(",",$user_ids);

                        if($extraWhere!="")
                        {
                            $extraWhere.=" and `userid` in ($check_user_ids) and schedule_sent='1'";
                        }
                        else
                        {
                            $extraWhere="`userid` in ($check_user_ids) and schedule_sent='1' ";
                        }
                    }
                    else
                    {

                        $user_ids=fetch_userids_by_resellers($userid);
                      $check_user_ids=implode(",",$user_ids);
                        if($extraWhere!="")
                        {
                            $extraWhere.=" and `userid` in ($check_user_ids) and schedule_sent='1'";
                        }
                        else
                        {

                            $extraWhere="`userid` in ($check_user_ids) and schedule_sent='1' ";
                        }
                    }

            }
            else
            {
                if($extraWhere!="") {
                    $extraWhere.=" and `userid`='$userid' and schedule_sent='1'";
                } else {

                    $extraWhere="`userid`='$userid' and schedule_sent='1'";
                }
            }
         

            }
            else if($user_role=='mds_adm')
            {
                 if($extraWhere!="") {
                    $extraWhere.=" and schedule_sent='1'";
                } else {

                    $extraWhere=" schedule_sent='1'";
                }
            }
            else
            {
                if($extraWhere!="") {
                    $extraWhere.=" and `userid`='$userid' and schedule_sent='1'";
                } else {

                    $extraWhere="`userid`='$userid' and schedule_sent='1'";
                }
            }
         //$extraWhere.=" order by created_at desc";
        echo json_encode(
            SSP::complex($_REQUEST, $sql_details, $table, $primaryKey, $columns,$test=null, $extraWhere)
        );

}
else if (isset($_POST['type']) && $_POST['type'] == 'delete_file') {
    $rs = delete_multimedia();
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
else if (isset($_POST['type']) && $_POST['type'] == 'delete_caller_id') {
    $rs = delete_callerid();
    echo $rs;
    

}
else if (isset($_POST['type']) && $_POST['type'] == 'admin_update') {
    $rs = admin_update_multimedia();
    echo $rs;
   

}
else if (isset($_POST['type']) && $_POST['type'] == 'updateCallerID') {
    $rs = updateCallerID();
    echo $rs;
   

}
else if (isset($_POST['type']) && $_POST['type'] == 'load_today_summary') {
     $result = load_today_summary();
     echo $result;
   

}
else if (isset($_POST['type']) && $_POST['type'] == 'load_duration') {
    $file_id=$_REQUEST['file_id'];

    $sql="select file_duration from multimedia where id=$file_id";
            $result=mysqli_query($dbc,$sql);
            while($row=mysqli_fetch_array($result))
            {
                $file_duration=$row['file_duration'];
            }

            if(!empty($file_duration))
            {
                echo $file_duration;
            }

}
else if (isset($_POST['type']) && $_POST['type'] == 'dropdown_voice') {
    $rs = load_dropdown_voice();
    echo $rs;
   

}
else if(isset($_POST['type']) && $_POST['type'] == 'all_caller_id')
{
    global $dbc;
    $user_role=$_SESSION['user_role'];
      $table = 'caller_id_dtls';
      $userid=$_SESSION['user_id'];

      if($user_role=='mds_adm')
          {
            $sql="select * from caller_id_dtls order by created_dt desc";
            $result=mysqli_query($dbc,$sql);
            while($row=mysqli_fetch_array($result))
            {
                $username=get_username($row[1]);
                $caller_id=$row['caller_id'];
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

                     $action="<button class='btn btn-primary btn-sm me-1 mb-1 edit_caller_id_btn' type='button' data-bs-toggle='modal' data-bs-target='#edit_caller_id_modal' data-id='".$id."' data-caller_id='".$caller_id."' data-status='".$status."'>
                 
                      <span class='fas fa-edit ms-1' data-fa-transform='shrink-3'></span>
                    </button>&nbsp;
                    <button class='btn btn-primary btn-sm me-1 mb-1 delete_caller_id_btn' type='button'  data-id='".$id."'>
                      <span class='fas fa-trash ms-1' data-fa-transform='shrink-3'></span>
                    </button>";
               
                $table_body.="<tr>";
                $table_body.="<td>$username</td>";
                $table_body.="<td>$caller_id</td>";
                $table_body.="<td>$status_txt</td>";
             
                $table_body.="<td>$created_dt</td>";
                $table_body.="<td>$action</td>";              
                 $table_body.="</tr>";

            }
            echo $table_body;
          }
          else
          {

            $sql="select * from caller_id_dtls where userid='$userid' order by created_dt desc";
            $result=mysqli_query($dbc,$sql);
            while($row=mysqli_fetch_array($result))
            {
                $username=get_username($row[1]);
                $caller_id=$row['caller_id'];
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

                     $action="<button class='btn btn-primary btn-sm me-1 mb-1 edit_caller_id_btn' type='button' data-bs-toggle='modal' data-bs-target='#edit_caller_id_modal' data-id='".$id."' data-caller_id='".$caller_id."' data-status='".$status."'>
                 
                      <span class='fas fa-edit ms-1' data-fa-transform='shrink-3'></span>
                    </button>&nbsp;
                    <button class='btn btn-primary btn-sm me-1 mb-1 delete_caller_id_btn' type='button'  data-id='".$id."'>
                      <span class='fas fa-trash ms-1' data-fa-transform='shrink-3'></span>
                    </button>";
               
                $table_body.="<tr>";
              
                $table_body.="<td>$caller_id</td>";
                $table_body.="<td>$status_txt</td>";
             
                $table_body.="<td>$created_dt</td>";
                $table_body.="<td>$action</td>";              
                 $table_body.="</tr>";

            }
            echo $table_body;
          
          }
}
else if(isset($_POST['type']) && $_POST['type'] == 'caller_id_dropdown')
{
      global $dbc;
      $user_role=$_SESSION['user_role'];

      $userid=$_SESSION['user_id'];

      if($user_role=='mds_adm')
          {
            $sql="select `caller_id` from caller_id_dtls where status=1 order by created_dt desc";
          }
          else
          {
            $sql="select `caller_id` from caller_id_dtls where userid='".$userid."' and status=1 order by created_dt desc";
          }

            $result=mysqli_query($dbc,$sql);
            $option="<option value='' selected>Select Caller ID</option>";
            while($row=mysqli_fetch_array($result))
            {
                $caller_id=$row['caller_id'];
                $option.="<option value='".$caller_id."'>$caller_id</option>";
            }
            echo $option;
}
else if(isset($_POST['type']) && $_POST['type'] == 'all_multimedia')
{
    global $dbc;
    $user_role=$_SESSION['user_role'];
      $table = 'multimedia';
      $userid=$_SESSION['user_id'];

      if($user_role=='mds_adm')
          {
            $sql="select * from multimedia order by created_dt desc";
            $result=mysqli_query($dbc,$sql);
            while($row=mysqli_fetch_array($result))
            {
                $username=get_username($row[3]);
                $source_type=$row['sourcetype'];
                $campaign_type=$row['campaign_type'];
                $file_type=$row['filetype'];
                 $file_duration=$row['file_duration'];
                $service_no=$row['serviceno'];
                $ivrtemplateid=$row['ivrtemplateid'];
                $retryatmpt=$row['retryatmpt'];
                $retryduration=$row['retryduration'];
                $ukey=$row['ukey'];
                $filename=$row['original_filename'];
                $status=$row['status'];
                $voice_id=$row['voice_id'];
                $ivr_id=$row['ivr_id'];
                $created_dt=$row['created_dt'];
                $status=$row['status'];
                $approved_by=get_username($row[5]);
                $id=$row['id'];

               
                if($status=='0')
                    {
                        $status_txt="<span style='color:red;'>Inactive</span>";
                    }
                    else
                    {
                        $status_txt="<span style='color:blue;'>Active</span>";
                    }

                     $action="<button class='btn btn-primary btn-sm me-1 mb-1 edit_admin_mulitmedia_btn' type='button' data-bs-toggle='modal' data-bs-target='#edit_admin_multimedia_modal' data-id='".$id."' data-original_filename='".$filename."' data-status='".$status."'
                  data-approved_by='".$approved_by."'
                  data-created_dt='".$created_dt."' data-source_type='".$source_type."' data-campaign_type='".$campaign_type."' data-filetype='".$file_type."' data-ukey='".$ukey."' data-voice_id='".$voice_id."' data-ivr_id='".$ivr_id."' data-service_no='".$service_no."' data-ivrtempid='".$ivrtemplateid."' data-retryatmpt='".$retryatmpt."' data-retryduration='".$retryduration."'>
                 
                      <span class='fas fa-edit ms-1' data-fa-transform='shrink-3'></span>
                    </button>&nbsp;
                    <button class='btn btn-primary btn-sm me-1 mb-1 delete_multimedia_btn' type='button'  data-id='".$id."' data-filename='".$filename."'>
                      <span class='fas fa-trash ms-1' data-fa-transform='shrink-3'></span>
                    </button>

                    
                    &nbsp;
                    

                   <a href='../assets/voice/".$filename."'  class='btn btn-primary btn-sm me-1 mb-1 download_multimedia_btn'  download='".$filename."'><span class='fas fa-download ms-1' data-fa-transform='shrink-3'></span></a>";
               
                $table_body.="<tr>";
                $table_body.="<td>$username</td>";
                $table_body.="<td>$filename</td>";
                $table_body.="<td>$voice_id</td>";
                $table_body.="<td>$ivr_id</td>";
                 $table_body.="<td>$file_duration</td>";
                $table_body.="<td>$status_txt</td>";
                $table_body.="<td>$approved_by</td>";

                $table_body.="<td>$created_dt</td>";
                $table_body.="<td>$action</td>";              
                 $table_body.="</tr>";

            }
            echo $table_body;
          }
          else
          {

            $sql="select * from multimedia where userid='$userid' order by created_dt desc";
            $result=mysqli_query($dbc,$sql);
            while($row=mysqli_fetch_array($result))
            {
                $username=get_username($row[3]);
                $source_type=$row['sourcetype'];
                $campaign_type=$row['campaign_type'];
                $file_type=$row['filetype'];
                $service_no=$row['serviceno'];
                $file_duration=$row['file_duration'];
                $ivrtemplateid=$row['ivrtemplateid'];
                $retryatmpt=$row['retryatmpt'];
                $retryduration=$row['retryduration'];
                $ukey=$row['ukey'];
                $filename=$row['original_filename'];
                $status=$row['status'];
                $voice_id=$row['voice_id'];
                $ivr_id=$row['ivr_id'];
                $created_dt=$row['created_dt'];
                $status=$row['status'];
                $approved_by=get_username($row[5]);
                $id=$row['id'];
                  
                if($status=='0')
                    {
                        $status_txt="<span style='color:red;'>Inactive</span>";
                    }
                    else
                    {
                        $status_txt="<span style='color:blue;'>Active</span>";
                    }

                     $action="<button class='btn btn-primary btn-sm me-1 mb-1 edit_admin_mulitmedia_btn' type='button' data-bs-toggle='modal' data-bs-target='#edit_admin_multimedia_modal' data-id='".$id."' data-original_filename='".$filename."' data-status='".$status."'
                         data-approved_by='".$approved_by."'
                         data-created_dt='".$created_dt."' data-source_type='".$source_type."' data-campaign_type='".$campaign_type."' data-filetype='".$file_type."' data-ukey='".$ukey."' data-voice_id='".$voice_id."' data-ivr_id='".$ivr_id."' data-service_no='".$service_no."' data-ivrtempid='".$ivrtemplateid."' data-retryatmpt='".$retryatmpt."' data-retryduration='".$retryduration."'>
                 
                      <span class='fas fa-edit ms-1' data-fa-transform='shrink-3'></span>
                    </button>&nbsp;
                    <button class='btn btn-primary btn-sm me-1 mb-1 delete_multimedia_btn' type='button'  data-id='".$id."' data-filename='".$filename."'>
                      <span class='fas fa-trash ms-1' data-fa-transform='shrink-3'></span>
                    </button>

                    &nbsp;
                    <a href='../assets/voice/".$filename."'  class='btn btn-primary btn-sm me-1 mb-1 download_multimedia_btn'  download='".$filename."'><span class='fas fa-download ms-1' data-fa-transform='shrink-3'></span></a>
                    ";
               
                $table_body.="<tr>";
            
                $table_body.="<td>$filename</td>";
                $table_body.="<td>$voice_id</td>";
                $table_body.="<td>$ivr_id</td>";
                $table_body.="<td>$file_duration</td>";
                $table_body.="<td>$status_txt</td>";
                $table_body.="<td>$approved_by</td>";

                $table_body.="<td>$created_dt</td>";
                $table_body.="<td>$action</td>";              
                 $table_body.="</tr>";

            }
            echo $table_body; 
          }
   


      /*    $columns = array(
              array( 'db' => 'id','dt' => 0 ),
                array( 'db' => 'userid','dt' => 1,'formatter' => function( $d, $row ) {


                    $username=get_username($d);
                    return $username;
                }),
                array( 'db' => 'original_filename','dt' => 2),
                array( 'db' => 'status','dt' => 3,'formatter' => function( $d, $row ) {
                    if($d=='0')
                    {
                        $status="<span style='color:red;'>Inactive</span>";
                    }
                    else
                    {
                        $status="<span style='color:blue;'>Active</span>";
                    }
                    return $status;
                }),
                array( 'db' => 'approved_by','dt' => 4,'formatter' => function( $d, $row ) {


                    $username=get_username($d);
                    return $username;
                }),
                array( 'db' => 'created_dt','dt' => 5),
                array( 'db' => 'id','dt' => 6,'formatter' => function( $d, $row ) {
                    $original_filename=$row[2];
                    $status=$row[3];
                    $approved_by=$row[4];
                    $created_dt=$row[5];

               
                $action="<button class='btn btn-primary btn-sm me-1 mb-1 edit_admin_mulitmedia_btn' type='button' data-bs-toggle='modal' data-bs-target='#edit_admin_multimedia_modal' data-id='".$d."' data-original_filename='".$original_filename."' data-status='".$status."'
                  data-approved_by='".$approved_by."'
                  data-created_dt='".$created_dt."'>
                 
                      <span class='fas fa-edit ms-1' data-fa-transform='shrink-3'></span>
                    </button>&nbsp;
                    <button class='btn btn-primary btn-sm me-1 mb-1 delete_multimedia_btn' type='button'  data-id='".$d."' data-filename='".$original_filename."'>
                      <span class='fas fa-trash ms-1' data-fa-transform='shrink-3'></span>
                    </button>";
                      return $action;
                  })
            );*/
        
     
       /*   }
          else
          {
            array( 'db' => 'original_filename','dt' => 1),
            array( 'db' => 'status','dt' => 2),
            array( 'db' => 'approved_by','dt' => 3),
            array( 'db' => 'created_dt','dt' => 4),
            array( 'db' => 'id','dt' => 5,'formatter' => function( $d, $row ) {
           
                     $original_filename=$row[1];
                $status=$row[2];
                $approved_by=$row[3];
                $created_dt=$row[4];

           
            $action="<button class='btn btn-primary btn-sm me-1 mb-1 edit_branddtls_btn' type='button' data-bs-toggle='modal' data-bs-target='#editbrandingModel' data-id='".$d."' data-original_filename='".$original_filename."' data-status='".$status."'
              data-approved_by='".$approved_by."'
              data-created_dt='".$created_dt."'>
             
                  <span class='fas fa-edit ms-1' data-fa-transform='shrink-3'></span>
                </button>&nbsp;
                <button class='btn btn-primary btn-sm me-1 mb-1 delete_branddtls_btn' type='button'  data-id='".$d."'>
                  <span class='fas fa-trash ms-1' data-fa-transform='shrink-3'></span>
                </button>";
                  return $action;
              })
          }*/
       
      // SQL server connection information
     /*global $sql_details;

      $extraWhere="";

      $userid=$_SESSION['user_id'];
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
      );*/
  
}


if($_REQUEST['act']=='import3') 
    {
        
            if (is_uploaded_file($_FILES['uploadfile']['tmp_name'])) 
            { 
                    
                $temp = explode(".", $_FILES["uploadfile"]["name"]);
                $ext = end($temp); 
                
                $cntr = 0;
                if (($ext == 'csv') or ($ext == 'txt') or ($ext == 'CSV'))
                    {
                        if (($handle = fopen($_FILES['uploadfile']['tmp_name'], "r")) !== FALSE) {
                            while (($data = fgetcsv($handle, 300000, ",")) !== FALSE) {
                                 $num = count($data);
                                for ($c=0; $c < $num; $c++) {
                                    if((strlen( $data[$c]) >= 10 && strlen( $data[$c])<=13)&& (is_numeric( $data[$c])))
                                        {$cntr=$cntr+1;echo $data[$c] . "\n";}
                                }
                            }
                            fclose($handle);
                        }
                    }
    
                    echo "|".$cntr; 
            }
    }


function load_sender_id()
{
    $userid=$_SESSION['user_id'];
    $user_role=$_SESSION['user_role'];
   
    if($user_role=='mds_adm')
    {

         $selected_userid=$_REQUEST['selected_userid'];
       
    }
    else
    {
         $selected_userid=$userid;

    }

     global $dbc;
             $q = "SELECT `sid`,`senderid` FROM az_senderid WHERE userid='".$selected_userid."' and status=1";
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


function load_route_id()
{
    $userid=$_SESSION['user_id'];
    $user_role=$_SESSION['user_role'];
   
    if($user_role=='mds_adm')
    {

         $selected_userid=$_REQUEST['selected_userid'];
       
    }
    else
    {
         $selected_userid=$userid;

    }

     global $dbc;
             $q = "SELECT route_ids FROM az_user WHERE userid='".$selected_userid."' and user_status=1";
             $rs = mysqli_query($dbc, $q);

             $count=mysqli_num_rows($rs);
             if($count>0)
             {
             $route_dropdown="<option value=''>Select Route</option>";
             while($row=mysqli_fetch_array($rs))
             {
                $route_ids=$row['route_ids'];
                
             }

             /*$route_id_arr=explode($route_ids);*/


               $sql = "select az_routeid,az_rname from az_routetype where az_routeid in ($route_ids) order by az_create_date desc";
               $query_result = mysqli_query($dbc, $sql);

               $count_route=mysqli_num_rows($query_result);
               $route_dropdown="<option value=''>Select Route</option>";
               if($count_route>0)
               {
             
                         
                         while($row=mysqli_fetch_array($query_result))
                         {
                           
                                if($row['az_routeid']!=7)
                                {
                                     $route_dropdown.="<option value='".$row['az_routeid']."'>".$row['az_rname']."</option>";
                                }  
                         }

                         return $route_dropdown;
                }
                else {
                           return $route_dropdown;
                      }

            return $route_dropdown;

             }
             else
             {
                return 0;
             }
        
}



/*load today summarry start*/

function load_today_summary()
{
    global $dbc;
    $userid=$_SESSION['user_id'];
    $select_user_id=$_REQUEST['u_id'];
$user_role=$_REQUEST['user_role'];
    $sendtabledetals = SENDCALLDETAILS;
    $u_id=$_REQUEST['u_id'];
    $today_dt=date('Y-m-d');
    if($user_role=='mds_rs' || $user_role=='mds_ad')
    {
        
        $selected_role=$_REQUEST['selected_role'];

        if($selected_role=="User")
        {
            
            if($u_id=="All")
            {
                $parent_id=$_SESSION['user_id'];
                /*$user_ids=fetch_userids($parent_id);
                $check_user_ids=implode(",",$user_ids);*/

                $sql = "select sum(msgcredit) as msgcredit,status from $sendtabledetals where parent_id='".$parent_id."' and date(sent_at)='$today_dt' and schedule_sent=1 group by userid,status";
            }
            else
            {
                $sql = "select sum(msgcredit) as msgcredit,status from $sendtabledetals where userid='".$select_user_id."' and date(sent_at)='$today_dt' and schedule_sent=1 group by userid,status";
            }
        }
        else if($selected_role=="Reseller")
        {
            //$u_id=$_REQUEST['u_id'];
            if($select_user_id=="All")
            {

                    $userid_arr[]=$userid;
                    $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                     
                      $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                         $check_user_ids=implode(",",$only_resellers);
                      }

                $sql = "select sum(msgcredit) as msgcredit,status from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 group by userid,status";
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
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                         $check_user_ids=implode(",",$only_resellers);
                      }

                $sql = "select sum(msgcredit) as msgcredit,status from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 group by userid,status";
            }

        }

    }
    else if($user_role=='mds_adm')
    {
        
        $selected_role=$_REQUEST['selected_role'];
        if($selected_role=="User")
        {
            if($select_user_id!="" && $select_user_id!="All")
            {

                $check_user_ids=$select_user_id;
                $sql="select sum(msgcredit) as msgcredit,status from $sendtabledetals where userid in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userid,status";
            }
            else
            {

            /*  $user_ids=fetch_allusers();
                $check_user_ids=implode(",",$user_ids);*/
                $sql="select sum(msgcredit) as msgcredit,status from $sendtabledetals where  date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userid,status";
            }
        }
        else if($selected_role=="Reseller")
        {
            if($select_user_id=='All')
            {
                $all_resellers=fetch_allresellers();

        $check_user_ids=implode(",",$all_resellers);
                
                $sql="select sum(msgcredit) as msgcredit,status from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userid,status";
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
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                         $check_user_ids=implode(",",$only_resellers);
                      }
                     
                 $sql="select sum(msgcredit) as msgcredit,status from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userid,status";
            }
        }
        else if($selected_role=="Admin")
        {
            if($select_user_id=='All')
            {
                $all_admins=fetch_alladmins();

                $userid_arr=$all_admins;
                
        $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }


                    $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                         $check_user_ids=implode(",",$only_resellers);
                      }
             $sql="select sum(msgcredit) as msgcredit,status from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userid,status";
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
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                         $check_user_ids=implode(",",$only_resellers);
                      }
                     
                 $sql="select sum(msgcredit) as msgcredit,status from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userid,status";
            }
        }
        else if($selected_role=='All')
        {
            $sql = "select sum(msgcredit) as msgcredit,status from $sendtabledetals where date(sent_at)='$today_dt' and schedule_sent=1 group by userid,status";
        }
    }
    else
    {
        $sql = "select sum(msgcredit) as msgcredit,status from $sendtabledetals where userid='".$userid."' and date(sent_at)='$today_dt' and schedule_sent=1 group by userid,status";
    }
    
    $result=mysqli_query($dbc,$sql);
    $count=mysqli_num_rows($result);
    $i=1;
    if($count>0)
    {
        while($row=mysqli_fetch_array($result)) {
            
            $status[] = $row["status"];
            

        }

        $table_head="<tr>
            
            <th>Username</th><th>Total</th>";

        $status_arr=array_unique($status);


            for($k=0;$k<count($status);$k++)
            {
                if($status_arr[$k]!='')
                {
                    $status_arr1[]=$status_arr[$k];
                }
                
            }

        
        $sql_select="Select sum(msgcredit) as msgcredit,userid";
        for($j=0;$j<count($status_arr1);$j++)
        {
            $stat=$status_arr1[$j];
            $table_head.="<th>$stat</th>";
            $sql_select.=",sum(if(status='$stat',msgcredit,0))as `$stat`";

        }

            $table_head.="</tr>";

$u_id=$_REQUEST['u_id'];
$select_user_id=$_REQUEST['u_id'];
if($user_role=='mds_rs' || $user_role=='mds_ad')
    {
        
        $selected_role=$_REQUEST['selected_role'];

        if($selected_role=="User")
        {
            
            if($u_id=="All")
            {
                $parent_id=$_SESSION['user_id'];
            /*  $user_ids=fetch_userids($parent_id);
                $check_user_ids=implode(",",$user_ids);*/
                $sql_select.=" from $sendtabledetals where parent_id in (".$parent_id.") and date(sent_at)='$today_dt' and schedule_sent=1 group by userid";


                
            }
            else
            {
                $sql_select.=" from $sendtabledetals where userid in (".$u_id.") and date(sent_at)='$today_dt' and schedule_sent=1 group by userid";
            }
        }
        else if($selected_role=="Reseller")
        {
        
            if($u_id=="All")
            {
                
                    $userid_arr[]=$userid;
                    $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                     
                      $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                         $check_user_ids=implode(",",$only_resellers);
                      }


                $sql_select.=" from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 group by userid";

            }
            else
            {
                /*$user_ids=fetch_userids_by_resellers($u_id);
                $check_user_ids=implode(",",$user_ids);*/
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
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                         $check_user_ids=implode(",",$only_resellers);
                      }


            $sql_select.=" from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 group by userid";


            }

        }
    }
        else if($user_role=='mds_adm')
    {
        
        $selected_role=$_REQUEST['selected_role'];
        if($selected_role=="User")
        {
            if($select_user_id!="" && $select_user_id!="All")
            {

                $check_user_ids=$select_user_id;
                $sql_select.=" from $sendtabledetals where userid in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userid";
            }
            else
            {

                /*$user_ids=fetch_allusers();
                $check_user_ids=implode(",",$user_ids);*/
                $sql_select.=" from $sendtabledetals where date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userid";
            }
        }
        else if($selected_role=="Reseller")
        {
            if($select_user_id=='All')
            {
                $all_resellers=fetch_allresellers();

                $check_user_ids=implode(",",$all_resellers);

                $sql_select.=" from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userid";
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
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                         $check_user_ids=implode(",",$only_resellers);
                      }
                     
                 $sql_select.=" from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userid";
            }
        }
        else if($selected_role=="Admin")
        {
            if($select_user_id=='All')
            {
                $all_admins=fetch_alladmins();

                $userid_arr=$all_admins;
                
        $child_users=get_childUsers($userid_arr);

                      foreach ($child_users as $child_val) {
                        foreach($child_val as $val)
                        {
                          $single_arr[]=$val;
                        }
                      }

                    $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                         $check_user_ids=implode(",",$only_resellers);
                      }
             $sql_select.=" from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userid";
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

                     
                      $single_arr=array_unique($single_arr);
                    $only_resellers=get_onlyResellers($single_arr);
                      if(!empty($only_resellers))
                      {
                         $check_user_ids=implode(",",$only_resellers);
                      }
                     
                 $sql_select.=" from $sendtabledetals where parent_id in (".$check_user_ids.") and date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userid";
            }
        }
        else if($selected_role=='All')
        {
            $sql_select.= " from $sendtabledetals where date(sent_at)='$today_dt' and schedule_sent=1 and (msgcredit>0) group by userid";
        }

    }
    else
    {
            $sql_select.=" from $sendtabledetals where userid='".$userid."'  and date(sent_at)='$today_dt' and schedule_sent=1 group by userid";
    }


    //echo $sql_select;
        
        $result_select = mysqli_query($dbc, $sql_select);

        $count_record=mysqli_num_rows($result_select);
        if($count_record>0)
        {
            $total_bill=0;
            $table_body2.="<tr><td></td>";
            while($row=mysqli_fetch_array($result_select))
            {
                /*$created_date=date('dS F y',strtotime($row['created_at']));*/
                $bill_credit=$row['msgcredit'];
                
                $total_bill+=$bill_credit;

                $userid=$row['userid'];
                $u_id=$userid;
                $username=get_username($userid);
                $table_body.="<tr>
                
                <td>$username</td>
                <td><a href='#' class='report_type' name='total' data-role='$user_role' data-uid='$u_id' data-selected_role='$selected_role'>$bill_credit</a></td>";
                $total_stat_val=0;
                for($j=0;$j<count($status_arr1);$j++)
                {
                    $stat=$status_arr1[$j];
                    $stat_val=$row[$stat];
                    $total_stat_val[$stat]=$stat_val;
                    $table_body.="<td><a href='#' class='report_type' name='$stat' data-role='$user_role' data-uid='$u_id' data-selected_role='$selected_role'>$stat_val</a></td>";
                    //$table_body2.="<td>$stat</td>";
                        
                }

                $table_body.="</tr>";
                

            }

            for($j=0;$j<count($status_arr1);$j++)
                {
                    $stat=$status_arr1[$j];
                    
                        $total_stat_val1=array_sum($total_stat_val[$stat]);
                        $table_body_stat.="<td></td>";
                }
            $table_body2.="<td>$total_bill</td>";
            $table_body2.=$table_body_stat;
            $table_body2.="</tr>";
            $table_body.=$table_body2;
        }
        else
        {
            $table_body.="No record available";
        }
        
            return $table_head.$table_body;


    }
    else
    {
        return $record="No record available";
    }

    //echo $record;
}



/*load today summary end*/


    function delete_multimedia() {
        global $dbc;
        $file_id=$_REQUEST['file_id'];
        $filename=$_REQUEST['filename'];
       
        $sql = "delete from multimedia  where id='".$file_id."'";
        $result = mysqli_query($dbc, $sql);
        if($result)
        {
          unlink('../assets/voice/'.$filename);
          $u_id=$_SESSION['user_id'];
          get_last_activities($u_id,'Multimedia Details Have Been Successfully Removed',@$login_date,@$logout_date);

          return 1;
        }
        else
        {
          return 0;
        }
        
    }

function load_send_job_data()
{
    global $dbc;
    $sendtable = SENDCALL . CURRENTMONTH;        
    
    $job_id=$_REQUEST['job_id'];
    /*$table_name=$_REQUEST['table_name'];*/
    $job_date=date("Y-m-d",strtotime($_REQUEST['job_date']));
    
    $today_dt=date("Y-m-d");

    $yesterday_dt=date("Y-m-d",strtotime("-1 day"));
    if($job_date!=$today_dt && $job_date!=$yesterday_dt)
    {
        $report_yr=date("Y",strtotime($job_date));
        $report_mt=date("m",strtotime($job_date));
        $sendtable=SENDCALL.$report_yr.$report_mt;
    }

    if($job_date==$yesterday_dt)
    {

        $report_yr=date("Y",strtotime($job_date));
        $report_mt=date("m",strtotime($job_date));
        $sendtable=SENDCALL.$report_yr.$report_mt;
    }

     $sql="select * from $sendtable where job_id='".$job_id."'";
    $values=mysqli_query($dbc,$sql);
    $count_record=mysqli_num_rows($values);
    if($count_record>0)
    {
        
        while($row=mysqli_fetch_array($values))
        {
            $id = $row['id'];
              $result[0] = $row;
              $result[1]['msg']=urldecode($row['message']);

        }
        //$result=array_merge($result,$result2);
        return $result;
    }
    else
    {
        echo 0;
    }
    

}

function load_status($job_result)
{
    global $dbc;
    $sendtabledetals = SENDCALLDETAILS;
   
    $message_id=$job_result[0]['id'];
    $message_job_id=$job_result[0]['job_id'];
    $job_id=$_REQUEST['job_id'];
    $job_date=date("Y-m-d",strtotime($_REQUEST['job_date']));
    
     $today_dt=date("Y-m-d");

    $yesterday_dt=date("Y-m-d",strtotime("-1 day"));
    if($job_date!=$today_dt && $job_date!=$yesterday_dt)
    {
        $report_yr=date("Y",strtotime($job_date));
        $report_mt=date("m",strtotime($job_date));
        $sendtabledetals=SENDCALLDETAILS.$report_yr.$report_mt;
    }

    if($job_date==$yesterday_dt)
    {
        
        $report_yr=date("Y",strtotime($job_date));
        $report_mt=date("m",strtotime($job_date));
        $sendtable=SENDCALL.$report_yr.$report_mt;
    }

    $sql="select status,sum(msgcredit) as sum_msgcredit,msgcredit from $sendtabledetals where msg_job_id='".$message_job_id."' group by status";
    $values=mysqli_query($dbc,$sql);
    $count_record=mysqli_num_rows($values);
    if($count_record>0)
    {
        $i=1;
        while($row=mysqli_fetch_array($values))
        {
            
              $result[$i] = $row;
              $i++;
        }
        return $result;
    }
    else
    {
        echo 0;
    }

    
    

}

        function delete_callerid() {
        global $dbc;
        $caller_dtls_id=$_REQUEST['caller_dtls_id'];
       
       
        $sql = "delete from caller_id_dtls  where id='".$caller_dtls_id."'";
        $result = mysqli_query($dbc, $sql);
        if($result)
        {
        
          $u_id=$_SESSION['user_id'];
          get_last_activities($u_id,'Caller ID Details Have Been Successfully Removed',@$login_date,@$logout_date);

          return 1;
        }
        else
        {
          return 0;
        }
        
    }
function fetch_alladmins()
{
    global $dbc;

    $sql="select userid from az_user where user_role='mds_ad'";

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

    function fetch_allresellers()
{
    global $dbc;

    $sql="select userid from az_user where user_role='mds_rs'";

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

    function get_onlyResellers($userid)
{
  global $dbc;
  $ids = array();

  $userids=implode(",", $userid);
   
        $qry = "SELECT userid FROM az_user WHERE userid in ($userids) and user_role='mds_rs' order by userid desc";
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


    function template_dropdown($userid=null)
    {
             global $dbc;
             $sid=$_REQUEST['sid'];
             
             if($userid==null || $userid=='' || $userid==undefined)
             {
                $userid=$_SESSION['user_id'];
             }


            
        if (!empty($userid)) {
            $cond .= " where userid = $userid";
        }

         if (!empty($sid)) {
            $cond .= " AND position('\"$sid\"' in senderid)";
        }

             $q = "SELECT tempid,template_name FROM az_template $cond order by `tempid` desc";
             $rs = mysqli_query($dbc, $q);
             $option="<option value=''>Select Template</option>";
             while($row=mysqli_fetch_array($rs))
             {
                $tempid=$row['tempid'];
                $template_name=$row['template_name'];
                $option.="<option value='".$tempid."'>$template_name</option>";
             }

             return $option;

    }


     function load_dropdown_voice() {
        global $dbc;
       $userid=$_SESSION['user_id'];
       
        $sql = "select id,original_filename from multimedia where userid='".$userid."' and status=1";
        $result = mysqli_query($dbc, $sql);
        if($result)
        {
            $file_opt="<option value=''>Select File</option>";
            while($row=mysqli_fetch_array($result))
            {
                $id=$row['id'];
                $file_name=$row['original_filename'];
                $file_opt.="<option value='".$id."'>$file_name</option>";
            }

          return $file_opt;
        }
        else
        {
            $file_opt="<option value=''>Select File</option>";
          return $file_opt;
        }
        
    }
function saveMultimedia()
{
          global $dbc;

        $userid=$_SESSION['user_id'];
        $user_role=$_SESSION['user_role'];
        if($user_role=='mds_adm')
        {
            $userid=trim($_POST['selected_userid']);
        }
       // $file_name =trim($_POST['file_name']);
        $multimedia_file=$_FILES['multimedia_file']['name'];
        

        $added_by=$_SESSION['user_id'];
        $sql_select = "SELECT * from multimedia where original_filename='$multimedia_file'";
        $query_select = mysqli_query($dbc, $sql_select);
        $count_brand=mysqli_num_rows($query_select);
        
        if($count_brand==0)
        {

          $target_dir = "../assets/voice/";
          $target_file = $target_dir . $_FILES["multimedia_file"]["name"];
          $full_path=$target_file;
          $original_filename=$_FILES["multimedia_file"]["name"];
          $uploadOk = 1;
          $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
           
          if (file_exists($target_file)) {
            return "File already exists.";
            exit();
            $uploadOk = 0;
          }

        if($imageFileType != "mp3") {
          return "Only wav,mp3 files are allowed.";
           exit();
          $uploadOk = 0;
        }


if ($uploadOk == 0) {
  return "Your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["multimedia_file"]["tmp_name"], $target_file)) {

    $mp3file = new MP3File($full_path);//http://www.npr.org/rss/podcast.php?id=510282
/*    $duration1 = $mp3file->getDurationEstimate();*/
    $duration2 = $mp3file->getDuration();
   // echo "The file ". htmlspecialchars( basename( $_FILES["uploadfile"]["name"])). " has been uploaded.";


    $template_id='';
    $senderid='';
    $route_id=0;
    $duration2=0;
    $get_response=$_REQUEST['get_response'];
    $senderid=$_REQUEST['senderid'];
    $template_id=$_REQUEST['template_id'];
    $route_id=$_REQUEST['route_id'];
     if(empty($route_id))
     {
         $route_id=0;
     }
     $sql = "INSERT INTO `multimedia`(userid,full_path,created_dt,original_filename,get_response,sender_id,template_id,file_duration,route_id) VALUES ('" . $userid . "','" . $full_path . "',now(),'".$original_filename."','".$get_response."','".$senderid."','".$template_id."',".$duration2.",".$route_id.")";


            $query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
            if ($query) {
                $u_id=$_SESSION['user_id'];
                get_last_activities($u_id,'Added new Multimedia details',@$login_date,@$logout_date);
                unset($_POST);
                return 1;
            } else {
                return 'Failed to insert record !';
            }



  } else {
    return "Sorry, there was an error uploading your file.";
  }
}

            
        }
        else
        {
            return 'File already exists';
            
        }

       

}




function saveCallerId()
{
          global $dbc;

        $userid=$_SESSION['user_id'];
        $user_role=$_SESSION['user_role'];
        if($user_role=='mds_adm')
        {
            $userid=trim($_REQUEST['callerid_username_senderid']);
        }
        $caller_id=trim($_REQUEST['caller_id']);
        $added_by=$_SESSION['user_id'];
        $sql_select = "SELECT * from caller_id_dtls where caller_id='$caller_id'";
        $query_select = mysqli_query($dbc, $sql_select);
        $count_brand=mysqli_num_rows($query_select);
        
        if($count_brand==0)
        {

    $sql = "INSERT INTO `caller_id_dtls`(userid,caller_id,created_dt) VALUES ('" . $userid . "','" . $caller_id . "',now())";


            $query = mysqli_query($dbc, $sql);
            if ($query) {
                $u_id=$_SESSION['user_id'];
                get_last_activities($u_id,'Added new Caller ID details',@$login_date,@$logout_date);
                unset($_POST);
                return 1;
            } else {
                return 'Failed to insert record!';
            }

            
        }
        else
        {
            return 'Caller ID already exists';
            
        }

       

}


/*admin update*/
function admin_update_multimedia()
{
          global $dbc;

        $userid=$_SESSION['user_id'];
        
       // $file_name =trim($_POST['file_name']);
        $multimedia_id=$_REQUEST['admin_file_id'];
        $multimedia_file=$_FILES['multimedia_file']['name'];
        

        $approved_by=$_SESSION['user_id'];
        $status=$_REQUEST['status'];
        $voice_id=$_REQUEST['voice_id'];
        $ivr_id=$_REQUEST['ivr_id'];
        if($multimedia_file!="")
        {
            $sql_select = "SELECT * from multimedia where original_filename='$multimedia_file'";
                $query_select = mysqli_query($dbc, $sql_select);
                $count_brand=mysqli_num_rows($query_select);
                
                if($count_brand==0)
                {

                  $target_dir = "../assets/voice/";
                  $target_file = $target_dir . $_FILES["multimedia_file"]["name"];
                  $full_path=$target_file;
                  $original_filename=$_FILES["multimedia_file"]["name"];
                  $uploadOk = 1;
                  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                   
                  if (file_exists($target_file)) {
                    return "File already exists.";
                    exit();
                    $uploadOk = 0;
                  }

                if($imageFileType != "mp3") {
                  return "Only wav,mp3 files are allowed.";
                   exit();
                  $uploadOk = 0;
                }

                if ($uploadOk == 0) {
                  return "Your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {
                  if (move_uploaded_file($_FILES["multimedia_file"]["tmp_name"], $target_file)) {
                   // echo "The file ". htmlspecialchars( basename( $_FILES["uploadfile"]["name"])). " has been uploaded.";


                if(!empty($voice_id))
                {
                    $sql = "update `multimedia` set original_filename='".$original_filename."',voice_id='".$voice_id."' where id='".$multimedia_id."'";

                }
                else
                {
                    $sql = "update `multimedia` set original_filename='".$original_filename."' where id='".$multimedia_id."'";

                }

                if(!empty($ivr_id))
                {
                    $sql = "update `multimedia` set ivr_id='".$ivr_id."' where id='".$multimedia_id."'";

                }
                else
                {
                    $sql = "update `multimedia` set ivr_id='".$ivr_id."' where id='".$multimedia_id."'";

                }
                  
                            $query = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
                            if ($query) {
                                $u_id=$_SESSION['user_id'];
                                get_last_activities($u_id,'Updated new Multimedia details',@$login_date,@$logout_date);
                                unset($_POST);
                                return 1;
                            } else {
                                return 'Failed to update record !';
                            }



                  } else {
                    return "Sorry, there was an error uploading your file.";
                  }
                }

            }
            else
            {
                return 'File already exists';               
            }
        }
        else
        {
                //$admin_edit_file_name=$_REQUEST['admin_edit_file_name'];
                /*$admin_edit_source_type=$_REQUEST['admin_edit_source_type'];
                $admin_edit_campaign_type=$_REQUEST['admin_edit_campaign_type'];
                $admin_edit_file_type=$_REQUEST['admin_edit_file_type'];
                $admin_edit_ukey=$_REQUEST['admin_edit_ukey'];
                $admin_edit_service_no=$_REQUEST['admin_edit_service_no'];
                $admin_edit_ivrtemplateid=$_REQUEST['admin_edit_ivrtemplateid'];
                $admin_edit_retryattempt=$_REQUEST['admin_edit_retryattempt'];
                $admin_edit_retryduration=$_REQUEST['admin_edit_retryduration'];*/
                $status=$_REQUEST['status'];
                $voice_id=$_REQUEST['voice_id'];
                 $ivr_id=$_REQUEST['ivr_id'];


                 $sql = "update `multimedia` set approved_by='$approved_by',status=$status,voice_id='".$voice_id."',ivr_id=".$ivr_id." where id='".$multimedia_id."'";


                            $query = mysqli_query($dbc, $sql);
                            if ($query) {
                                $u_id=$_SESSION['user_id'];
                                get_last_activities($u_id,'Updated Multimedia details',@$login_date,@$logout_date);
                                unset($_POST);
                                return 1;
                            } else {
                                return 'Failed to update record !';
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



/*Caller ID update*/
function updateCallerID()
{
          global $dbc;

        $userid=$_SESSION['user_id'];
        
       // $file_name =trim($_POST['file_name']);
        $caller_dtl_id=$_REQUEST['caller_dtl_id'];
        $edit_caller_id=$_REQUEST['edit_caller_id'];
        $status=$_REQUEST['edit_callerid_status'];
        
            $sql_select = "SELECT * from caller_id_dtls where caller_id='$edit_caller_id' ";
                $query_select = mysqli_query($dbc, $sql_select);
                $count_brand=mysqli_num_rows($query_select);


                if($count_brand==0)
                {

               echo $sql = "update `caller_id_dtls` set caller_id='".$edit_caller_id."',status='".$status."' where id='".$caller_dtl_id."'";
                $query = mysqli_query($dbc, $sql);
                            if ($query) {
                                $u_id=$_SESSION['user_id'];
                                get_last_activities($u_id,'Updated Caller ID details',@$login_date,@$logout_date);
                                unset($_POST);
                                return 1;
                            } else {
                                return 'Failed to update record !';
                            }
                }
                else
                {

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
