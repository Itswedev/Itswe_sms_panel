<?php 
$log_file = "../error/logfiles/list_template.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);
error_reporting(0);
include_once('include/connection.php');

 if (!empty($tempdata)) {
			$inc = 1;
            foreach ($tempdata as $key => $value) {
		 ?>
            <tr>
              <td width="2%"><?php echo $inc++; ?></td>
              <td width="5%"><?php echo $value['template_name']; ?></td>
              <td width="5%"><?php echo $value['pe_id']; ?></td>
              <td width="5%"><?php echo $value['template_id']; ?></td>
               <?php 
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
            ?>
            <td width="10%"><?php echo $content_type; ?></td>
              <?php
            
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
              
              ?>
              <td width="10%"><?php echo $category_type; ?></td>
             <?php if($value['senderid'] != ''){
                $sid          = implode(',', json_decode($value['senderid'], true));
                $senderidsArr = getTemplateSenderId($sid);
                $senderids = implode(', ', $senderidsArr);
                
            }else{
               $senderids = ''; 
            }
              ?>
              
               <td width="13%"><?php print_r($senderids); ?></td>
              <td width="17%"><?php echo $value['template_data']; ?></td>
              <td width="10%"><?php echo date('d-M-Y', strtotime($value['created'])); ?></td>
              <td width="25%"><button class='btn btn-primary me-1 mb-1' type='button'>
  <span class='fas fa-edit ms-1' data-fa-transform='shrink-3'></span>
</button>&nbsp;<button class='btn btn-primary me-1 mb-1' type='button'>
  <span class='fas fa-trash ms-1' data-fa-transform='shrink-3'></span>
</button></td>
            </tr>
             <?php
                }
            }
            else
            {
        ?><tr>
            <td colspan="10" align="center"><?php echo "No Records Found(s)";?></td>
        </tr>
        <?php }
	
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

    
   

 ?>