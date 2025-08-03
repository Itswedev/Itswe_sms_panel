<?php 
session_start();
$log_file = "../error/logfiles/bulk_sms.log";
 
 error_reporting(E_ALL); 
 
// setting error logging to be active
ini_set("log_errors", TRUE); 
  
// setting the logging file in php.ini
ini_set('error_log', $log_file);
  

include('../include/connection.php');
if($_REQUEST['act']=='import')	
	{
			if (is_uploaded_file($_FILES['uploadfile']['tmp_name'])) 
			{ 
				$temp = explode(".", $_FILES["uploadfile"]["name"]);
				$ext = end($temp); 
				$cntr = 0;
				if (($ext == 'csv') or ($ext == 'txt'))
					{
						if (($handle = fopen($_FILES['uploadfile']['tmp_name'], "r")) !== FALSE) {
							while (($data = fgetcsv($handle, 50000, ",")) !== FALSE) {
								$num = count($data);
								for ($c=0; $c < $num; $c++) {
									if((strlen( $data[$c]) == 10)&& (is_numeric( $data[$c])))
										{$cntr=$cntr+1;echo $data[$c] . "\n";}
								}
							}
							fclose($handle);
						}
					}
	/*			else if ($ext == 'xls') 
					{
							include("excel.class.php");
							$excel = new Spreadsheet_Excel_Reader();
							$excel->read($_FILES['uploadfile']['tmp_name']);
							$x=1;
							while($x<=$excel->sheets[0]['numRows']) {
							  $y=1;
							  while($y<=$excel->sheets[0]['numCols']) {
								$cell = isset($excel->sheets[0]['cells'][$x][$y]) ? $excel->sheets[0]['cells'][$x][$y] : '';
								if((strlen( $cell) == 10)&& (is_numeric( $cell))){$cntr=$cntr+1;echo $cell."\n";}
								$y++;
							  }  
							  $x++;
							}
					}	
				else if ($ext == 'xlsx')
					{
						include("xlsx.class.php");
						$xlsx = new SimpleXLSX($_FILES['uploadfile']['tmp_name']);
						list($num_cols, $num_rows) = $xlsx->dimension();
						foreach( $xlsx->rows() as $r ) 
						{
							for( $i=0; $i < $num_cols; $i++ )
								{
									if((strlen($r[$i]) == 10)&& (is_numeric($r[$i]))){$cntr=$cntr+1;echo $r[$i]."\n";}
								}
						}
					}*/
					echo "|".$cntr;	
			}
	}
else if($_REQUEST['act']=='load_gvsms_btn')	
{
	global $dbc;
	$userid=$_SESSION['user_id'];
 $sql="select `gvsms` from `az_user` where userid='$userid'";
			$result=mysqli_query($dbc,$sql);
			$count=mysqli_num_rows($result);
			if($count>0)
			{

				while($row=mysqli_fetch_array($result))
				{
					$gvsms=$row['gvsms'];
					echo $gvsms;

				}
				
			}
			else
			{
				echo 0;
			}

}
else if($_REQUEST['act']=='load_rcs_page')	
{
	global $dbc;
	$userid=$_SESSION['user_id'];
 $sql="select `rcs` from `az_user` where userid='$userid'";
			$result=mysqli_query($dbc,$sql);
			$count=mysqli_num_rows($result);
			if($count>0)
			{

				while($row=mysqli_fetch_array($result))
				{
					$rcs=$row['rcs'];
					echo $rcs;

				}
				
			}
			else
			{
				echo 0;
			}

}
else if($_REQUEST['act']=='load_template_with_sid')	
{
	$userid=$_SESSION['user_id'];
	$template_dropdown=template_dropdown($userid);
    echo $template_dropdown;
}




    function template_dropdown($userid=null)
    {
             global $dbc;
             $sid=$_REQUEST['sid'];
             $cond = 'WHERE 1';
        if (!empty($userid)) {
            $cond .= " AND userid = $userid";
        }

         if (!empty($sid)) {
            $cond .= " AND position('\"$sid\"' in senderid)";
        }
              $q = "SELECT * FROM az_template $cond order by `tempid` desc";
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

 ?>