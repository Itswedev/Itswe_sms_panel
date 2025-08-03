<?php 
session_start();
ob_start();
header('Content-Type: text/html; charset=UTF-8');
$log_file = "../error/logfiles/template_function.log";
 
 error_reporting(E_ALL); 
 
// setting error logging to be active
ini_set("log_errors", TRUE); 
  
// setting the logging file in php.ini
ini_set('error_log', $log_file);
/*error_reporting(0);*/
include_once('../include/connection.php');
include_once('../include/config.php');
//include_once('../include/datatable_dbconnection.php');
require('classes/ssp.class.php');
include_once('controller/classes/last_activities.php');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if (isset($_POST['type']) && $_POST['type'] == 'saveTemplate') {
  
	 $rs = insert_template();
     echo $rs;
   /*if ($rs) {
       
       
         echo 1;
        //$tempdata = ListTemplate();
       //include('list_template.php');
       
    } else {
        echo 0;
    }*/
}
else if(isset($_POST['type']) && $_POST['type']=='all_template_download')
{
    $table = SENDERID;

            $primaryKey = 'tempid';

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

            $fileName = "template_".time().".xls"; 
			$fields_query=" u.user_name,s.template_name,s.template_id,s.content_type,s.category_type,s.senderid,s.template_data";
			
			 $sql="select $fields_query from az_template s join az_user u on s.userid=u.userid where $extraWhere";

			$result=mysqli_query($dbc,$sql);
			$table="";


				$columnHeader = '';  
				$columnHeader = "Username" . "\t" . "Template Name" . "\t". "Template ID" ."\t". "Content Type" . "\t". "Category Type" . "\t". "Sender ID" . "\t". "Template Data" . "\t";  
				$setData = '';  
			    while($rec=mysqli_fetch_row($result))
			    {
                    $rowData = '';  
                
                    foreach ($rec as $key => $value) {
                        if ($key == 4) { // Columns 4 and 5
                            // Format data from column 4 and 5
                            if($value == "1"){
                                $category_type = 'Banking/Insurance/Financial products/ credit cards';
                            }else if($value == "2"){
                                $category_type = 'Real Estate';
                            }else if($value == "3"){
                                $category_type = 'Education';
                            }else if($value == "4"){
                                $category_type = 'Health';
                            }else if($value == "5"){
                                $category_type = 'Consumer goods and automobiles';
                            }else if($value == "6"){
                                $category_type = 'Communication/Broadcasting/Entertainment/IT';
                            }else if($value == "7"){
                                $category_type = 'Tourism and Leisure';
                            }else if($value == "8"){
                                $category_type = 'Food and Beverages';
                            }else if($value == "0"){
                                $category_type = 'Others';
                            }else{
                                $category_type = '';
                            }
                            $value =   $category_type.  "\t"; // Assuming the data in column 4 and 5 are dates
                        }
                        if ($key == 3) { // Columns 4 and 5
                            // Format data from column 4 and 5
                            if($value == "T"){
                                $content_type = 'Transactional';
                            }else if($value == "P"){
                                $content_type = 'Promotional';
                            }else if($value == "SE"){
                                $content_type = 'Service Explicit';
                            }else if($value == "SI"){
                                $content_type = 'Service Implicit';
                            }else{
                                $content_type = '';
                            }
                            $value = $content_type. "\t"; // Assuming the data in column 4 and 5 are dates
                        }

                        if ($key == 5) { // Columns 4 and 5
                            $sid          = implode(',', json_decode($value, true));
                            $senderidsArr = getTemplateSenderId($sid);
                            $senderids = implode(', ', $senderidsArr);
                            $value = $senderids. "\t"; // Assuming the data in column 4 and 5 are dates
                        }
                        
                        if (is_numeric($value) && strlen($value) > 1) {
                            $value = '"\'' . $value . '\'"' . "\t"; 
                        } else {
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

else if (isset($_POST['type']) && $_POST['type'] == 'updateTemplate') {
  
    $rs = update_template();
   if ($rs) {
      /*$u_id=$_SESSION['user_id'];
        get_last_activities($u_id,'Template Details Updated',@$login_date,@$logout_date);*/
        echo $rs;
     
       
    } else {
        echo 0;
    }
}
else if (isset($_POST['type']) && $_POST['type'] == 'list_template') {
$u_id=$_SESSION['user_id'];
    $rs = template_data($u_id);
    
   if ($rs) {
        $tempdata = all_template($rs);
       return $tempdata;
       
    } else {
        echo 'FALSE';
    }
}
else if (isset($_POST['type']) && $_POST['type'] == 'upload_template') {
    $rs = upload_template();
    
   echo $rs;
}
else if (isset($_POST['type']) && $_POST['type'] == 'list_all_template') {
$u_id=$_SESSION['user_id'];
$user_role=$_SESSION['user_role'];
   

            $table = TEMPLATE;

            $primaryKey = 'tempid';

            if($user_role=='mds_adm')
            {
                $columns = array(
                array( 'db' => 'userid','dt' => 0,'formatter' => function( $d, $row ) {
                                   $username=get_username($d);
                        return $username;

                    }),
                array( 'db' => 'template_name','dt' => 1 ),
                array( 'db' => 'template_id','dt' => 2,'formatter'=>function($d,$row)
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
                array( 'db' => 'content_type','dt' => 3,'formatter'=>function($d,$row){
                    if($d == "T"){
                    $content_type = 'Transactional';
                }else if($d == "P"){
                    $content_type = 'Promotional';
                }else if($d == "SE"){
                    $content_type = 'Service Explicit';
                }else if($d == "SI"){
                    $content_type = 'Service Implicit';
                }else{
                    $content_type = '';
                }

                return $content_type;
                } ),
                array( 'db' => 'category_type','dt' => 4,'formatter'=>function($d,$row)
                {

                    if($d == "1"){
                    $category_type = 'Banking/Insurance/Financial products/ credit cards';
                }else if($d == "2"){
                    $category_type = 'Real Estate';
                }else if($d == "3"){
                    $category_type = 'Education';
                }else if($d == "4"){
                    $category_type = 'Health';
                }else if($d == "5"){
                    $category_type = 'Consumer goods and automobiles';
                }else if($d == "6"){
                    $category_type = 'Communication/Broadcasting/Entertainment/IT';
                }else if($d == "7"){
                    $category_type = 'Tourism and Leisure';
                }else if($d == "8"){
                    $category_type = 'Food and Beverages';
                }else if($d == "0"){
                    $category_type = 'Others';
                }else{
                    $category_type = '';
                }

                return $category_type;
                } ),
                array( 'db' => 'senderid','dt' => 5,'formatter'=>function($d,$row){

                        if($d != ''){
                            $sid          = implode(',', json_decode($d, true));
                            $senderidsArr = getTemplateSenderId($sid);
                            $senderids = implode(', ', $senderidsArr);
                            
                        }else{
                           $senderids = ''; 
                        }

                        return $senderids;
                }),
                array( 'db' => 'template_data','dt' => 6 ,'formatter'=>function($d,$row){

                    if($row[9]!='Unicode')
                        {
                             $temp_data=urldecode($d);
                        }
                        else
                        {
                            $temp_data=urldecode($d);
                        }
                    return "<div class='text-wrap width-200'> $temp_data </div>";
                }),
                array( 'db' => 'created','dt' => 7 ),
                array( 'db' => 'char_type','dt' => 8 ),
                array( 'db' => 'tempid','dt' => 9,'formatter' => function( $d, $row ) {
                   
                    $edit_userid=$row[0];
                   $tempid=$d;
                   $temp_name=$row[1];
                   $temp_id=$row[2];
                  // $template_content=urldecode($row[5]);
                   $content_type=$row[3];
                   $category_type=$row[4];
                   $senderid=$row[5];
                   
                        $action="<button class='btn btn-primary me-1 mb-1 edit_template_btn' type='button' data-bs-toggle='modal' data-bs-target='#edit_template_modal'data-edit_userid='".$edit_userid."' data-id='".$tempid."' data-tempname='".$temp_name."' data-templateid='".$temp_id."' data-contenttype='".$content_type."' data-categorytype='".$category_type."' data-senderid='".$senderid."'>
                        <i class='fa fa-pencil'></i>
                </button>&nbsp;
                <button class='btn btn-primary me-1 mb-1 delete_template_btn' type='button'  data-id='".$tempid."'>
                <i class='fa fa-trash'></i>
                </button>";
                        return $action;
                    }),
              
                );
            }
            else
            {
                $columns = array(
               
                    array( 'db' => 'template_name','dt' => 0 ),
                    array( 'db' => 'template_id','dt' => 1,'formatter'=>function($d,$row)
                    {
                         
                            global $restricted_tlv;
                            //return $restricted_tlv;
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
                    array( 'db' => 'content_type','dt' => 2,'formatter'=>function($d,$row){
                        if($d == "T"){
                        $content_type = 'Transactional';
                    }else if($d == "P"){
                        $content_type = 'Promotional';
                    }else if($d == "SE"){
                        $content_type = 'Service Explicit';
                    }else if($d == "SI"){
                        $content_type = 'Service Implicit';
                    }else{
                        $content_type = '';
                    }

                    return $content_type;
                    } ),
                    array( 'db' => 'category_type','dt' => 3,'formatter'=>function($d,$row)
                    {

                        if($d == "1"){
                        $category_type = 'Banking/Insurance/Financial products/ credit cards';
                    }else if($d == "2"){
                        $category_type = 'Real Estate';
                    }else if($d == "3"){
                        $category_type = 'Education';
                    }else if($d == "4"){
                        $category_type = 'Health';
                    }else if($d == "5"){
                        $category_type = 'Consumer goods and automobiles';
                    }else if($d == "6"){
                        $category_type = 'Communication/Broadcasting/Entertainment/IT';
                    }else if($d == "7"){
                        $category_type = 'Tourism and Leisure';
                    }else if($d == "8"){
                        $category_type = 'Food and Beverages';
                    }else if($d == "0"){
                        $category_type = 'Others';
                    }else{
                        $category_type = '';
                    }

                    return $category_type;
                    } ),
                    array( 'db' => 'senderid','dt' => 4,'formatter'=>function($d,$row){

                            if($d != ''){
                                $sid          = implode(',', json_decode($d, true));
                                $senderidsArr = getTemplateSenderId($sid);
                                $senderids = implode(', ', $senderidsArr);
                                
                            }else{
                               $senderids = ''; 
                            }

                            return $senderids;
                    }),
                    array( 'db' => 'template_data','dt' => 5 ,'formatter'=>function($d,$row){
                        if($row[8]!='Unicode')
                        {
                             $temp_data=urldecode($d);
                        }
                        else
                        {
                            $temp_data=urldecode($d);
                        }
                        //$temp_data=urldecode($d);
                       
                       
                        return "<div class='text-wrap width-200'> $temp_data </div>";
                    }),
                    array( 'db' => 'created','dt' => 6 ),
                    array( 'db' => 'char_type','dt' => 7 ),
                    array( 'db' => 'tempid','dt' => 8,'formatter' => function( $d, $row ) {
                       
                       $tempid=$d;
                       $temp_name=$row[0];
                       $temp_id=$row[1];
                      // $template_content=urldecode($row[5]);
                       $content_type=$row[2];
                       $category_type=$row[3];
                       $senderid=$row[4];
                       
                       $action="<button class='btn btn-primary me-1 mb-1 edit_template_btn' type='button' data-bs-toggle='modal' data-bs-target='#edit_template_modal' data-id='".$tempid."' data-tempname='".$temp_name."' data-templateid='".$temp_id."' data-contenttype='".$content_type."' data-categorytype='".$category_type."' data-senderid='".$senderid."'>
                        <i class='fa fa-pencil'></i>
                        </button>&nbsp;
                        <button class='btn btn-primary me-1 mb-1 delete_template_btn' type='button'  data-id='".$tempid."'>
                        <i class='fa fa-trash'></i>
                        </button>";
                            return $action;
                        }),
                    
                   
                );


            }
        
             
            // SQL server connection information
            global $sql_details ;

            $extraWhere="";

            $userid=$_SESSION['user_id'];
            if($userid!='1')
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
else if (isset($_POST['type']) && $_POST['type'] == 'select_all_template') {
    $u_id=$_SESSION['user_id'];
    $user_role=$_SESSION['user_role'];
       
    
                $table = TEMPLATE;
    
                $primaryKey = 'tempid';
    
                if($user_role=='mds_adm')
                {
                    $columns = array(
                    array( 'db' => 'userid','dt' => 0,'formatter' => function( $d, $row ) {
                                       $username=get_username($d);
                            return $username;
    
                        }),
                    array( 'db' => 'template_name','dt' => 1 ),
                    array( 'db' => 'template_id','dt' => 2,'formatter'=>function($d,$row)
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
                    array( 'db' => 'content_type','dt' => 3,'formatter'=>function($d,$row){
                        if($d == "T"){
                        $content_type = 'Transactional';
                    }else if($d == "P"){
                        $content_type = 'Promotional';
                    }else if($d == "SE"){
                        $content_type = 'Service Explicit';
                    }else if($d == "SI"){
                        $content_type = 'Service Implicit';
                    }else{
                        $content_type = '';
                    }
    
                    return $content_type;
                    } ),
                    array( 'db' => 'category_type','dt' => 4,'formatter'=>function($d,$row)
                    {
    
                        if($d == "1"){
                        $category_type = 'Banking/Insurance/Financial products/ credit cards';
                    }else if($d == "2"){
                        $category_type = 'Real Estate';
                    }else if($d == "3"){
                        $category_type = 'Education';
                    }else if($d == "4"){
                        $category_type = 'Health';
                    }else if($d == "5"){
                        $category_type = 'Consumer goods and automobiles';
                    }else if($d == "6"){
                        $category_type = 'Communication/Broadcasting/Entertainment/IT';
                    }else if($d == "7"){
                        $category_type = 'Tourism and Leisure';
                    }else if($d == "8"){
                        $category_type = 'Food and Beverages';
                    }else if($d == "0"){
                        $category_type = 'Others';
                    }else{
                        $category_type = '';
                    }
    
                    return $category_type;
                    } ),
                    array( 'db' => 'senderid','dt' => 5,'formatter'=>function($d,$row){
    
                            if($d != ''){
                                $sid          = implode(',', json_decode($d, true));
                                $senderidsArr = getTemplateSenderId($sid);
                                $senderids = implode(', ', $senderidsArr);
                                
                            }else{
                               $senderids = ''; 
                            }
    
                            return $senderids;
                    }),
                    array( 'db' => 'template_data','dt' => 6 ,'formatter'=>function($d,$row){
    
                        if($row[9]!='Unicode')
                            {
                                 $temp_data=urldecode($d);
                            }
                            else
                            {
                                $temp_data=urldecode($d);
                            }
                        return "<div class='text-wrap width-200'> $temp_data </div>";
                    }),
                  
                    array( 'db' => 'char_type','dt' => 7 ),
                    
                  
                    );
                }
                else
                {
                    $columns = array(
                        array( 'db' => 'tempid','dt' => 0 ,'formatter'=>function($d,$row)
                        {
                            $tempid=$row[0];
                            $temp_name=$row[1];
                            $char_type=$row[7];
                            $template_id=$row[2];
                            $msg=urldecode($row[6]);
                            $action="
                            <input type='radio'  name='templateOption' class='select_temp_id' id='templateOption$tempid' autocomplete='off' data-id='$tempid' data-template_id='$template_id' data-temp_name='$temp_name' data-msg='$msg' data-char_type='$char_type'>
                            ";
                            return $action;
                               
                        }),
                        array( 'db' => 'template_name','dt' => 1 ),
                        array( 'db' => 'template_id','dt' => 2,'formatter'=>function($d,$row)
                        {
                             
                                global $restricted_tlv;
                               
                                        if($restricted_tlv=='Yes')
                                        {
                                            $count_len=strlen($d);
                                            return substr($d, 1, $count_len-6)."XXXXXX";
                                        } 
                                        else
                                        {
                                             return $d;
                                        }
                        }),
                        array( 'db' => 'content_type','dt' => 3,'formatter'=>function($d,$row){
                            if($d == "T"){
                            $content_type = 'Transactional';
                        }else if($d == "P"){
                            $content_type = 'Promotional';
                        }else if($d == "SE"){
                            $content_type = 'Service Explicit';
                        }else if($d == "SI"){
                            $content_type = 'Service Implicit';
                        }else{
                            $content_type = '';
                        }
    
                        return $content_type;
                        } ),
                        array( 'db' => 'category_type','dt' => 4,'formatter'=>function($d,$row)
                        {
    
                            if($d == "1"){
                            $category_type = 'Banking/Insurance/Financial products/ credit cards';
                        }else if($d == "2"){
                            $category_type = 'Real Estate';
                        }else if($d == "3"){
                            $category_type = 'Education';
                        }else if($d == "4"){
                            $category_type = 'Health';
                        }else if($d == "5"){
                            $category_type = 'Consumer goods and automobiles';
                        }else if($d == "6"){
                            $category_type = 'Communication/Broadcasting/Entertainment/IT';
                        }else if($d == "7"){
                            $category_type = 'Tourism and Leisure';
                        }else if($d == "8"){
                            $category_type = 'Food and Beverages';
                        }else if($d == "0"){
                            $category_type = 'Others';
                        }else{
                            $category_type = '';
                        }
    
                        return $category_type;
                        } ),
                        array( 'db' => 'senderid','dt' => 5,'formatter'=>function($d,$row){
    
                                if($d != ''){
                                    $sid          = implode(',', json_decode($d, true));
                                    $senderidsArr = getTemplateSenderId($sid);
                                    $senderids = implode(', ', $senderidsArr);
                                    
                                }else{
                                   $senderids = ''; 
                                }
    
                                return $senderids;
                        }),
                        array( 'db' => 'template_data','dt' => 6 ,'formatter'=>function($d,$row){
                            if($row[8]!='Unicode')
                            {
                                 $temp_data=urldecode($d);
                            }
                            else
                            {
                                $temp_data=urldecode($d);
                            }
                            //$temp_data=urldecode($d);
                           
                           
                            return "<div class='text-wrap width-200'> $temp_data </div>";
                        }),
                        
                        array( 'db' => 'char_type','dt' => 7 ),
                       
                        
                       
                    );
    
    
                }
            
                 
                // SQL server connection information
                global $sql_details ;
    
                $extraWhere="";
    
                $userid=$_SESSION['user_id'];
                if($userid!='1')
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
else if (isset($_POST['type']) && $_POST['type'] == 'delete_template') {

   $rs=delete_template();

    if($rs==1)
    {
          /*$u_id=$_SESSION['user_id'];
        get_last_activities($u_id,'Template Details Deleted',@$login_date,@$logout_date);*/
      echo 1;

    }
    else
    {
      echo 0;
    }
}
else if (isset($_POST['type']) && $_POST['type'] == 'display_content') {

   $rs=template_content();

   echo $rs;
}
else if($_POST['type'] == 'get_msg_data')
{

    $temp_id=$_POST['temp_id'];
    $tempdata = ListTemplate($temp_id);
   // print_r($tempdata);
    if(!empty($tempdata))
    {
        $template_id=$tempdata[$temp_id]['template_id'];
        $char_type=$tempdata[$temp_id]['char_type'];
        if($char_type=="Unicode")
        {
             $msg_data=urldecode($tempdata[$temp_id]['template_data']);
        }
       else
       {
             $msg_data=$tempdata[$temp_id]['template_data'];
       }


        if(!empty($msg_data))
        {
            $val['msg_data']=$msg_data;
           // echo $msg_data;
        }
        else
        {
            $val['msg_data']='';
           // echo '';
        }
        $val['template_id']=$template_id;
         $val['char_type']=$char_type;
         echo json_encode($val);

    }
    else
    {
        echo '';
    }
  
}
else
{
	$tempdata=ListTemplate();
}


if(isset($_REQUEST['template_type']) && $_REQUEST['template_type']=='load_template_dropdown')
{
    $template_dropdown=template_dropdown();
    echo $template_dropdown;
}
else if(isset($_REQUEST['template_type']) && $_REQUEST['template_type']=='load_sender_dropdown')
{
    $userid=$_SESSION['user_id'];
    $sender_dropdown=sender_dropdown($userid);
    echo $sender_dropdown;
}
else if(isset($_REQUEST['template_type']) && $_REQUEST['template_type']=='load_sender_values')
{
    $userid=$_SESSION['user_id'];

    if($_SESSION['user_role']!='mds_adm')
    {
        $sender_val=sender_values($userid);
        
    }
    else{
        $userid=$_REQUEST['selected_userid'];
        
        $sender_val=sender_values($userid);
    }
    
    echo json_encode($sender_val);
}
else if(isset($_REQUEST['template_type']) && $_REQUEST['template_type']=='load_template_dropdown_userid')
{
    $template_dropdown=template_dropdown_bulk_sms($_SESSION['user_id']);
    $template_dropdown_select="<option value=''>Select Template</option>";
    echo $template_dropdown_select.$template_dropdown;
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



function upload_template()
{
    global $dbc; 
    $userid=$_SESSION['user_id'];
    $user_role=$_SESSION['user_role'];
    if($user_role=='mds_adm')
    {
        $userid=$_REQUEST['selected_userid'];
    }


    $fname = explode('.', $_FILES['upload_template']['name']);
    $filename=$_FILES['upload_template']['name'];
    $extension = end($fname);    
    if($extension=='csv')
    {
               if (($handle = fopen($_FILES['upload_template']['tmp_name'], "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 100000, ",")) !== FALSE) {
                        $number = $name = '';
          
                            if (isset($data[0])) {
                                $template_name[] = isset($data[0]) ? str_replace("'","",$data[0]) : '';
                                $template_id[] = isset($data[1]) ? str_replace("'","",$data[1]) : '';

                                $content_type_sheet = isset($data[2]) ? $data[2] : '';

                                 if($content_type_sheet == "Transactional"){
                                    $content_type[] = 'T';
                                }else if($content_type_sheet == "Promotional"){
                                    $content_type[] = 'P';
                                }else if($content_type_sheet == "Service Explicit"){
                                    $content_type[] = 'SE';
                                }else if($content_type_sheet == "Service Implicit"){
                                    $content_type[] = 'SI';
                                }else{
                                    $content_type[] = '';
                                }
                               

                               $category_type_sheet= isset($data[3]) ? $data[3] : '';

                                if($category_type_sheet == "Banking/Insurance/Financial products/ credit cards"){
                                    $category_type[] = '1';
                                }else if($category_type_sheet == "Real Estate"){
                                    $category_type[] = '2';
                                }else if($category_type_sheet == "Education"){
                                    $category_type[] = '3';
                                }else if($category_type_sheet == "Health"){
                                    $category_type[] = '4';
                                }
                                else if($category_type_sheet == "Consumer goods and automobiles"){
                                    $category_type[] = '5';
                                }
                                else if($category_type_sheet == "Communication/Broadcasting/Entertainment/IT"){
                                    $category_type[] = '6';
                                }
                                else if($category_type_sheet == "Tourism and Leisure"){
                                    $category_type[] = '7';
                                }
                                 else if($category_type_sheet == "Food and Beverages"){
                                    $category_type[] = '8';
                                }else{
                                    $category_type[] = '';
                                }

                               // $senderid[]=isset($data[4]) ? json_encode(explode(",",$data[4])) : '';
                                $sid = (isset($data[4]) && $data[4]!='Sender ID') ? $data[4] : '';
                                if(strpos($sid, ",") !== false){
                                   $sids=explode(",",$sid);
                                   $senderidsArr = getTemplateSenderId_upload($sids);
                                
                                    $senderid[]= json_encode($senderidsArr);
                                }
                                else
                                {
                                    $sids=$sid;
                                    $senderidsArr = getTemplateSenderId_upload_single($sids);
                                    $senderid[]= json_encode($senderidsArr);
                                }
                                
                                

                                 $character_type[]=isset($data[5]) ? $data[5] : '';
                                 

                                 if($data[5]=='Unicode')
                                 {
                                    $temp_data=isset($data[6]) ? $data[6] : '';
                                    $temp_data = str_replace("'", "\'", $temp_data);
                                    $temp_data = str_replace('"', '\"', $temp_data);
                                    $temp_data = str_replace(['–', '—'], '-', $temp_data);
                                    //return  $temp_data;

                                    $temp_data=urlencode($temp_data);
                                    $temp_data=str_replace("%96","-",$temp_data);
                                    
         
                                    $template_content[]= $temp_data;
                                 }
                                 else
                                 {
                                    $temp_data=isset($data[6]) ? $data[6] : '';
                                    $temp_data = str_replace("'", "\'", $temp_data);
                                    $temp_data = str_replace('"', '\"', $temp_data);
                                    $temp_data = str_replace(['–', '—'], '-', $temp_data);
                                   // $temp_data = urlencode($temp_data);

                                    $temp_data=str_replace("%96","-",$temp_data);

                                    $template_content[]= $temp_data;
                                    
                                 }
                            }
                            else
                            {
                                return "Please enter template name";
                            }
                        
                        
                    }

                   
                    fclose($handle);

                     $count_temp=count($template_name);
                     
                    if($count_temp>1)
                    {
                        $values="";
                        $today_dt=date("Y-m-d");
                        for($i=1;$i<count($template_name);$i++)
                        {
                             if($count_temp>1 && ($i!=(count($template_name)-1)))
                             {
                            $values.="('" . $userid. "','$template_id[$i]','$senderid[$i]','$template_name[$i]','$content_type[$i]','$category_type[$i]','$template_content[$i]',NOW(),'$character_type[$i]'),";
                             }
                             else
                             {
                             $values.="('" . $userid. "','$template_id[$i]','$senderid[$i]','$template_name[$i]','$content_type[$i]','$category_type[$i]','$template_content[$i]',NOW(),'$character_type[$i]')";
                             }
                        }




                    }
                    else
                    {
                        return "Please check your file";
                    }

                    if($values!="")
                    {

                           $sql = "INSERT INTO `az_template` ( `userid`,  `template_id`, `senderid`, `template_name`,`content_type`, `category_type`, `template_data`, `created`,`char_type`) values $values" ;
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


// function upload_template()
// {
//     global $dbc; 
//     $userid=$_SESSION['user_id'];
//     $fname = explode('.', $_FILES['upload_template']['name']);
//     $filename=$_FILES['upload_template']['name'];
//     $extension = end($fname);    
//     if($extension=='csv')
//     {
//                if (($handle = fopen($_FILES['upload_template']['tmp_name'], "r")) !== FALSE) {
//                     while (($data = fgetcsv($handle, 100000, ",")) !== FALSE) {
//                         $number = $name = '';
          
//                             if (isset($data[0])) {
//                                 $template_name[] = $data[0];
//                                 $template_id[] = isset($data[1]) ? $data[1] : '';
//                                 $content_type_sheet = isset($data[2]) ? $data[2] : '';

//                                  if($content_type_sheet == "Transactional" || $content_type_sheet == "transactional"){
//                                     $content_type[] = 'T';
//                                 }else if($content_type_sheet == "Promotional" ||  $content_type_sheet == "promotional"){
//                                     $content_type[] = 'P';
//                                 }else if($content_type_sheet == "Service Explicit" || $content_type_sheet == "service explicit"){
//                                     $content_type[] = 'SE';
//                                 }else if($content_type_sheet == "Service Implicit" || $content_type_sheet == "service implicit"){
//                                     $content_type[] = 'SI';
//                                 }else{
//                                     $content_type[] = '';
//                                 }
                               

//                                $category_type_sheet= isset($data[3]) ? $data[3] : '';

//                                 if($category_type_sheet == "Banking/Insurance/Financial products/ credit cards"){
//                                     $category_type[] = '1';
//                                 }else if($category_type_sheet == "Real Estate"){
//                                     $category_type[] = '2';
//                                 }else if($category_type_sheet == "Education"){
//                                     $category_type[] = '3';
//                                 }else if($category_type_sheet == "Health"){
//                                     $category_type[] = '4';
//                                 }
//                                 else if($category_type_sheet == "Consumer goods and automobiles"){
//                                     $category_type[] = '5';
//                                 }
//                                 else if($category_type_sheet == "Communication/Broadcasting/Entertainment/IT"){
//                                     $category_type[] = '6';
//                                 }
//                                 else if($category_type_sheet == "Tourism and Leisure"){
//                                     $category_type[] = '7';
//                                 }
//                                  else if($category_type_sheet == "Food and Beverages"){
//                                     $category_type[] = '8';
//                                 }else{
//                                     $category_type[] = '';
//                                 }

//                                // $senderid[]=isset($data[4]) ? json_encode(explode(",",$data[4])) : '';
//                                 $sid = (isset($data[4]) && $data[4]!='Sender ID') ? $data[4] : '';
//                                 if(strpos($sid, ",") !== false){
//                                    $sids=explode(",",$sid);
//                                    $senderidsArr = getTemplateSenderId_upload($sids);
                                
//                                     $senderid[]= json_encode($senderidsArr);
//                                 }
//                                 else
//                                 {
//                                     $sids=$sid;
//                                     $senderidsArr = getTemplateSenderId_upload_single($sids);
//                                     $senderid[]= json_encode($senderidsArr);
//                                 }
                                
                                

//                                  $character_type[]=isset($data[5]) ? $data[5] : '';
//                                  $template_content[]= isset($data[6]) ? $data[6] : '';
//                             }
//                             else
//                             {
//                                 return "Please enter template name";
//                             }
                        
                        
//                     }



//                     fclose($handle);

//                      $count_temp=count($template_name);
                     
//                     if($count_temp>1)
//                     {
//                         $values="";
//                         $today_dt=date("Y-m-d");
//                         for($i=1;$i<count($template_name);$i++)
//                         {
//                              if($count_temp>1 && ($i!=(count($template_name)-1)))
//                              {
//                             $values.="('" . $_SESSION['user_id'] . "','$template_id[$i]','$senderid[$i]','$template_name[$i]','$content_type[$i]','$category_type[$i]','$template_content[$i]',NOW(),'$character_type[$i]'),";
//                              }
//                              else
//                              {
//                              $values.="('" . $_SESSION['user_id'] . "','$template_id[$i]','$senderid[$i]','$template_name[$i]','$content_type[$i]','$category_type[$i]','$template_content[$i]',NOW(),'$character_type[$i]')";
//                              }
//                         }




//                     }
//                     else
//                     {
//                         return "Please check your file";
//                     }

//                     if($values!="")
//                     {

//                            $sql = "INSERT INTO `az_template` ( `userid`,  `template_id`, `senderid`, `template_name`,`content_type`, `category_type`, `template_data`, `created`,`char_type`) values $values" ;
                          
//                             $res = mysqli_query($dbc, $sql)or die(mysqli_error($dbc));
                
//                                if ($res) {
//                                     return 'success';
//                                 } else {
//                                     return 0;
//                                 }


//                     }
                    
                    


//                 }
//     }
// }
function template_content()
{
     global $dbc;
        $tempid=$_REQUEST['tempid'];
       
        $sql = "select template_data from az_template where tempid='".$tempid."'";
        $result = mysqli_query($dbc, $sql);
        if($result)
        {
            $row=mysqli_fetch_array($result);
            $template_content=urldecode($row['template_data']);
            return $template_content;
        }
        else
        {
            return 0;
        }
}

 function delete_template() {
        global $dbc;
        $tempid=$_REQUEST['tempid'];
       
        $sql = "delete from az_template where tempid='".$tempid."'";
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

     function all_template($result)
        {

          $i = 1;
          if (!empty($result)) { 
         
           foreach ($result as $key => $value) { 
            $edit_userid=$value['userid'];
            $tempid=$value['tempid'];
            $temp_name=$value['template_name'];
            /*$pe_id=$value['pe_id'];*/
            $temp_id=$value['template_id'];
            $senderid=$value['senderid'];
            $content_type = '';
                if($value['content_type'] == "T"){
                    $content_type = 'Transactional';
                }else if($value['content_type'] == "P"){
                    $content_type = 'Promotional';
                }else if($value['content_type'] == "SE"){
                    $content_type = 'Service Explicit';
                }else if($value['content_type'] == "SI"){
                    $content_type = 'Service Implicit';
                }else{
                    $content_type = '';
                }


             $category_type = '';
                if($value['category_type'] == "1"){
                    $category_type = 'Banking/Insurance/Financial products/ credit cards';
                }else if($value['category_type'] == "2"){
                    $category_type = 'Real Estate';
                }else if($value['category_type'] == "3"){
                    $category_type = 'Education';
                }else if($value['category_type'] == "4"){
                    $category_type = 'Health';
                }else if($value['category_type'] == "5"){
                    $category_type = 'Consumer goods and automobiles';
                }else if($value['category_type'] == "6"){
                    $category_type = 'Communication/Broadcasting/Entertainment/IT';
                }else if($value['category_type'] == "7"){
                    $category_type = 'Tourism and Leisure';
                }else if($value['category_type'] == "8"){
                    $category_type = 'Food and Beverages';
                }else if($value['category_type'] == "0"){
                    $category_type = 'Others';
                }else{
                    $category_type = '';
                }
            

            if($value['senderid'] != ''){
                $sid          = implode(',', json_decode($value['senderid'], true));
                $senderidsArr = getTemplateSenderId($sid);
                $senderids = implode(', ', $senderidsArr);
                
            }else{
               $senderids = ''; 
            }
            $template_content=  $value['template_data'];
            
          /* $template_content=*/
            $created_dt=date('d-M-Y', strtotime($value['created']));


          $return_temp.="<tr>
              <td width='5%'>$i</td>
              <td width='30%'>$temp_name</td>            
             
              <td width='15%'>$temp_id</td>  
              <td width='15%'>$content_type</td> 
              <td width='15%'>$category_type</td>
              <td width='15%'>$senderids</td> 
              <td width='15%' style='word-wrap: break-word;'>$template_content</td>    
              <td width='15%'>$created_dt</td>             
              <td width='15%'>
                <button class='btn btn-primary me-1 mb-1 edit_template_btn' type='button' data-bs-toggle='modal' data-bs-target='#edit_template_modal' data-id='".$tempid."' data-edit_userid='".$edit_userid."' data-tempname='".$temp_name."' data-templateid='".$temp_id."' data-templatecontent=".$template_content." data-contenttype='".$value['content_type']."' data-categorytype='".$value['category_type']."' data-senderid='".$value['senderid']."'>
                  <span class='fas fa-edit ms-1' data-fa-transform='shrink-3'></span>
                </button>&nbsp;
                <button class='btn btn-primary me-1 mb-1 delete_template_btn' type='button'  data-id='".$tempid."'>
                  <span class='fas fa-trash ms-1' data-fa-transform='shrink-3'></span>
                </button>
              </td></tr>";
                $i++;
                }

                echo $return_temp;
          } 
          else
          {
            return "No record available";
          }
        }


    
     function getTemplateSenderId($senderids) {
        global $dbc;
        
       $out = array();
       $q = "SELECT `sid`, `senderid` FROM `az_senderid` WHERE `sid` IN ({$senderids}) ORDER BY `senderid` ASC";
       $rs = mysqli_query($dbc, $q);

        while ($row = mysqli_fetch_assoc($rs)) {
            $out[] = $row['senderid'];
        }

        return $out;
    }

function getTemplateSenderId_upload($senderids) {
        global $dbc;
        $userid=$_SESSION['user_id'];
        //$senderid=implode(",", $senderids);
       $out = array();
       foreach($senderids as $senderid)
       {
            $q = "SELECT `sid`, `senderid` FROM `az_senderid` WHERE `senderid` ='".$senderid."' and userid='".$userid."' ORDER BY `senderid` ASC";
           $rs = mysqli_query($dbc, $q);

            while ($row = mysqli_fetch_assoc($rs)) {
                $out[] = $row['sid'];
            }

       }
       
        return $out;
    }


function getTemplateSenderId_upload_single($senderid) {
        global $dbc;
        $userid=$_SESSION['user_id'];
        //$senderid=implode(",", $senderids);
       $out = array();
       /*foreach($senderids as $senderid)
       {*/
            $q = "SELECT `sid`, `senderid` FROM `az_senderid` WHERE `senderid` ='".$senderid."' and userid='".$userid."' ORDER BY `senderid` ASC";
           $rs = mysqli_query($dbc, $q);

            while ($row = mysqli_fetch_assoc($rs)) {
                $out[] = $row['sid'];
            }

       //}
       
        return $out;
    }
 function template_data($u_id) {
        global $dbc;
        $result = array();
        $user_role=$_SESSION['user_role'];
        if($user_role!='mds_adm')
        {
            $sql = "SELECT *  FROM az_template where userid='$u_id' ORDER BY created DESC";
        }
        else
        {
            $sql = "SELECT *  FROM az_template ORDER BY created DESC";
        }
        
        $values = mysqli_query($dbc, $sql);
        while ($row = mysqli_fetch_array($values)) {
            $tempid = $row['tempid'];
            $result[$tempid] = $row;
        }
        return $result;
    }



function insert_template() {
        global $dbc;
        $userid=$_SESSION['user_id'];
        $msg = trim($_POST['template_data']);
          $msg = str_replace("'", "\'", $msg);
/*        $msg = str_replace("\r\n", "\n", $msg);
        $msg = str_replace(array("\xE2\x80\x99", "\xE2\x80\x98", "\xEF\xBF\xBD"), '\'', $msg);
        $msg = str_replace(array("\xEF\x82\xA7", "\xE2\x80\x8B"), '', $msg);
        $msg = antiinjection($msg);*/
        //$msg=urlencode($msg);

      /*  $PE_ID = trim($_POST['PE_ID']);*/
        $Template_ID = trim($_POST['Template_ID']);
        $content_type = trim($_POST['content_type']);
        $category_type = trim($_POST['category_type']);
        $character_type = trim($_POST['character_type']);
        $senderid = $_POST['sender_id'];
        $sql_select="select `template_name` from az_template where template_name='".$_POST['template_name']."' and userid='$userid'";
        $result_select=mysqli_query($dbc,$sql_select);
        $count_temp=mysqli_num_rows($result_select);
        if($count_temp>0)
        {
            return 2;
        }
        else
        {

            if($character_type=="Unicode")
            {
                $msg=urlencode($msg);
            }
                if ($_SESSION['user_id'] != 1) {
                    $userid = $_SESSION['user_id'];
                } else {
                    $userid=$_REQUEST['username_senderid'];
                    //$userid = $_POST['userid'];
                }

            $sql = "INSERT INTO `az_template` (`tempid`, `userid`,  `template_id`, `senderid`, `template_name`,`content_type`, `category_type`, `template_data`, `created`,`char_type`) VALUES (NULL, '" . $userid . "', '" . $Template_ID . "','" . $senderid . "','" . $_POST['template_name'] . "', '" . $content_type . "','" . $category_type . "','" . $msg . "', NOW(),'".$character_type."')";
         
                $res = mysqli_query($dbc, $sql)or die(mysqli_error($dbc));
                
               if ($res) {
                 /*$u_id=$_SESSION['user_id'];
                   get_last_activities($u_id,'New Template Details Added',$login_date="",$logout_date="");*/

                    return 1;
                } else {
                    return 0;
                }
        }
       
    }

function update_template() {
        global $dbc;
        $tempid=$_REQUEST['tempid'];
        $msg = trim($_POST['template_data']);
          $msg = str_replace("'", "\'", $msg);
     /* $msg = str_replace("\r\n", "\n", $msg);
        $msg = str_replace(array("\xE2\x80\x99", "\xE2\x80\x98", "\xEF\xBF\xBD"), '\'', $msg);
        $msg = str_replace(array("\xEF\x82\xA7", "\xE2\x80\x8B"), '', $msg);
        $msg = antiinjection($msg);
*/
        $template_name=$_POST['template_name'];
       /* $PE_ID = trim($_POST['PE_ID']);*/
        $Template_ID = trim($_POST['Template_ID']);
        $content_type = trim($_POST['content_type']);
        $category_type = trim($_POST['category_type']);
        $senderid = $_POST['edit_sender_id_hidden'];
     
            $sql = "update `az_template` set  `template_id`='$Template_ID', `senderid`='$senderid', `template_name`='$template_name',`content_type`='$content_type', `category_type`='$category_type', `template_data`='$msg' where tempid='$tempid'";
         
            $res = mysqli_query($dbc, $sql)or die(mysqli_error($dbc));
                
                if ($res) {
                    return 1;
                } else {
                    return 0;
                }
        
       
    }

    function antiinjection($data) {
        global $dbc;
        $filter_sql = mysqli_real_escape_string($dbc, stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES))));
        return $filter_sql;
    }

       function ListTemplate($id = null) {
        global $dbc;
        $cond = 'WHERE 1';
        if (!empty($id)) {
            $cond .= " AND tempid = $id";
        }
        $cond .= " AND userid = '{$_SESSION['user_id']}'";
        $sql = "SELECT * FROM az_template $cond ORDER BY tempid DESC";
        $out = array();
        $result = mysqli_query($dbc, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['tempid'];
            $out[$id] = $row;
        }
        return $out;
    }


    function template_dropdown($userid=null)
    {
             global $dbc;
             $cond = 'WHERE 1';
        if (!empty($userid)) {
            $cond .= " AND userid = $userid";
        }
             $q = "SELECT * FROM az_template $cond";
             $rs = mysqli_query($dbc, $q);
             $option="";
             while($row=mysqli_fetch_array($rs))
             {
                $tempid=$row['tempid'];
                $template_name=$row['template_name'];
                $option.="<option value='".$tempid."'>$template_name</option>";
             }

             return $option;

    }

        function sender_dropdown($userid=null)
    {
             global $dbc;
            
             $cond = 'WHERE 1';
             $user_role=$_SESSION['user_role'];

        if (!empty($userid)) {

            if($user_role=='mds_adm')
            {
                $selected_userid=$_REQUEST['selected_userid'];
                $cond .= " AND userid = $selected_userid";
            }
            else
            {
                $cond .= " AND userid = $userid";
            }
            
        }
             $q = "SELECT * FROM az_senderid $cond";
             $rs = mysqli_query($dbc, $q);
             $option="";
             while($row=mysqli_fetch_array($rs))
             {
                $sid=$row['sid'];
                $sender_name=$row['senderid'];
                $option.="<option value='".$sid."'>$sender_name</option>";
             }

             return $option;

    }



    function sender_values($userid=null)
    {
             global $dbc;
            
             $cond = 'WHERE 1';
             $user_role=$_SESSION['user_role'];

        if (!empty($userid)) {

            if($user_role=='mds_adm')
            {
               
                $selected_userid=$_REQUEST['selected_userid'];
                $cond .= " AND userid = $selected_userid";
            }
            else
            {
                $cond .= " AND userid = $userid";
            }
            
        }
                $q = "SELECT * FROM az_senderid $cond";
                $rs = mysqli_query($dbc, $q);
             $option="";
             $senderArray = array();
             while ($row = mysqli_fetch_assoc($rs)) {
                // Add the id and sendername to the array
                $senderArray[] = array(
                    'sid' => $row['sid'],
                    'senderid' => $row['senderid']
                );
            }

             return $senderArray;

    }


     function template_dropdown_bulk_sms($userid=null)
    {
             global $dbc;
             $senderid=$_REQUEST['senderid'];
             $cond = 'WHERE 1';
        if (!empty($userid)) {
            $cond .= " AND userid = $userid";
        }

          if (!empty($senderid)) {
            $cond .= " AND locate(`senderid`,'[\"$senderid\"]')";
        }
             $q = "SELECT * FROM az_template $cond";
             $rs = mysqli_query($dbc, $q);
             $option="";
             while($row=mysqli_fetch_array($rs))
             {
                $tempid=$row['tempid'];
                $template_name=$row['template_name'];
                $option.="<option value='".$tempid."'>$template_name</option>";
             }

             return $option;

    }





    
 ?>