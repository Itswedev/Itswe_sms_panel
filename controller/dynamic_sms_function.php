<?php 
session_start();
$log_file = "../error/logfiles/dynamic_sms_function.log";
 
error_reporting(E_ALL); 
// setting error logging to be active
ini_set("log_errors", TRUE); 
// setting the logging file in php.ini
ini_set('error_log', $log_file);
	error_reporting(0);
	// ini_set('display_errors', 1);
	// ini_set('display_startup_errors', 1);
	// error_reporting(E_ALL);

	if($_REQUEST['act']=='import') {
		if (is_uploaded_file($_FILES['uploadfile']['tmp_name'])) {

			$temp = explode(".", $_FILES["uploadfile"]["name"]);
			$ext = end($temp);
			$cntr = 0;


			if (($ext == 'csv') or ($ext == 'txt')) {
				if (($handle = fopen($_FILES['uploadfile']['tmp_name'], "r")) !== FALSE) {
					while (($data = fgetcsv($handle, 50000, ",")) !== FALSE) {
						$data_mobile_col[]=$data[0];
						$data_name_col[]=$data[1];
						$data_amt_col[]=$data[2];
						$data_date_col[]=$data[3];		
					}
								
					$num=count($data_mobile_col);
					$data_return['mobile'] = $data_mobile_col;
					$data_return['name'] = $data_name_col;
					$data_return['amt'] = $data_amt_col;
					$data_return['date'] = $data_date_col;	
							
					

					$target_dir = "/var/www/html/itswe_panel/view/include/data/dynamic_sms_csv/";
					$file1 = $_FILES["uploadfile"]["tmp_name"];
					$file_nm=rand(10,9999).$_FILES["uploadfile"]["name"];
					$file_name=$target_dir.$file_nm;
					// $target_file_name = basename($currentDate . "_" . rand(0,999999) . "_" . $file1);
					$mv_file = move_uploaded_file($file1, $file_name);
					$data_return['file_name']=$file_nm;


					$data_row_arr['table_data'] = $data_return;
					/*if($mv_file)
					{
						echo "Uploaded successfully";

					}
					else
					{
						echo "Failed to upload";
					}*/
							
					echo json_encode($data_row_arr);
				}
			}
		}
	}
	else if($_REQUEST['act']=='import1') {
		if (is_uploaded_file($_FILES['uploadfile']['tmp_name'])) {

			$temp = explode(".", $_FILES["uploadfile"]["name"]);
			$ext = end($temp);
			$cntr = 0;

			if (($ext == 'csv') or ($ext == 'txt')) {
				if (($handle = fopen($_FILES['uploadfile']['tmp_name'], "r")) !== FALSE) {
					  $columns = fgetcsv($handle, 50000, ",");
					  $csv = array();
					  $i = 0;
					while (($data = fgetcsv($handle, 50000, ",")) !== FALSE) {
						foreach ($data as &$value) {
							$value = preg_replace('/[^a-zA-Z0-9\s,.-]/', '', $value); // Adjust the regex as needed
						}
						  $csv[$i] = array_combine($columns, $data);
        					$i++;

					}

					for($i=0;$i<count($columns);$i++)
					{
						$table_header[]="$columns[$i]";
					}

					$target_dir = "/var/www/html/itswe_panel/view/include/data/dynamic_sms_csv/";
					$file1 = $_FILES["uploadfile"]["tmp_name"];
					$file_nm=rand(10,9999).$_FILES["uploadfile"]["name"];
					$file_name=$target_dir.$file_nm;
					// $target_file_name = basename($currentDate . "_" . rand(0,999999) . "_" . $file1);
					$mv_file = move_uploaded_file($file1, $file_name);
					


					$table_data['header']=$table_header;
					$table_data['data']=$csv;
					$table_data['file_name']=$file_nm;

						
					echo json_encode($table_data);
				}

			}
			else{
				
				echo 0;
			}
		}
	}
	 elseif ($_REQUEST['act'] == 'preview') {
			
		$file_name=$_REQUEST['file_name'];
		$msg=$_REQUEST['msg'];
		$target_dir = "/var/www/html/itswe_panel/view/include/data/dynamic_sms_csv/";
		$file_path=$target_dir.$file_name;
		$row=0;
		if (($handle = fopen($file_path, "r")) !== FALSE) {
			
					while (($data = fgetcsv($handle, 50000, ",")) !== FALSE) {

						$data_mobile_col[]=$data[0];
						$data_name_col[]=$data[1];
						$data_amt_col[]=$data[2];
						$data_date_col[]=$data[3];		
					}

					$col_header=[$data_mobile_col[0],$data_name_col[0],$data_amt_col[0],$data_date_col[0]];

					$num=count($data_mobile_col);
					$data_return[$col_header[0]] = $data_mobile_col;
					$data_return[$col_header[1]] = $data_name_col;
					$data_return[$col_header[2]] = $data_amt_col;
					$data_return[$col_header[3]] = $data_date_col;	
						
					/*print_r($data_return['mobile']);*/
					$tbl_head ="<table id='tfhover' class='table table-hover' border='1' width='100%'><tr><th scope='col'>$col_header[0]</th><th scope='col'>Message</th></tr>";
					
					for ($c = 1; $c < $num; $c++) {
						$sms=$msg;
		                $mobile_no = $data_return[$col_header[0]][$c];

		               		for($i=0;$i<count($col_header);$i++)
		               		{

		               			$header = $col_header[$i];
			               		 $s = "{" . $header . "}";

			               		 $val=$data_return[$header][$c];
			               			
			               		 $sms = str_replace($s,$val, $sms);
			               		 
			               		
			               		 
		               		}
		                	
			                
			                //$sms = str_replace($s, , $msg);
		                
		               
		                $preview.="<tr><td>$mobile_no</td><td>$sms</td></tr>";
		                $message.=$mobile_no . '||' . $sms . "*****";
		            }
		         //   print_r($sms1);
		           
		         echo $preview=$tbl_head.$preview."</table>"."|||".$message;
					

					
				}
			

	}
		else if ($_REQUEST['act'] == 'set_default') {

			$default_value=$_REQUEST['default_value'];
			$placeholder=$_REQUEST['placeholder'];
			$session_name="placeholder*".$placeholder;
			echo $_SESSION[$session_name]=$default_value;


		}
	else if ($_REQUEST['act'] == 'preview1') {
		$file_name=$_REQUEST['file_name'];
		$msg=$_REQUEST['msg'];
		$senderid=$_REQUEST['senderid'];
		$dynamic_url=$_REQUEST['dynamic_url'];
		if($dynamic_url!="")
		{
			$subRandNo = subRandomNumGen(3);
		}
		/*$default_val=$_REQUEST['default_value'];

		$default_value=explode(",",$default_val);*/
		/*print_r($default_value);*/
		$target_dir = "/var/www/html/itswe_panel/view/include/data/dynamic_sms_csv/";
		 $file_path=$target_dir.$file_name;
			$row=0;
		if (($handle = fopen($file_path, "r")) !== FALSE) {
			
					$columns = fgetcsv($handle, 50000, ",");
					  $csv = array();
					  $i = 0;
					while (($data = fgetcsv($handle, 50000, ",")) !== FALSE) {
						  $csv[$i] = array_combine($columns, $data);
        					$i++;

					}

					$tbl_head ="<table id='tfhover' class='table table-hover' border='1' width='100%'><tr><th scope='col'>$columns[0]</th><th scope='col'>Message</th><th scope='col'>Char count</th><th scope='col'>Bill</th></tr>";

					$num=count($csv);
					$udh = 153;
			        $SMS = 160;
			        $msgcredit = 1;  

					for ($c = 0; $c < $num; $c++) {
						$sms=$msg;
					
						
			
		                $col1_header= $columns[0];
		                $mobile_no=$csv[$c][$col1_header];
						$dynamic_original_url = $csv[$c][$dynamic_url];

		                	for($i=0;$i<count($columns);$i++)
							{
								$header="$columns[$i]";
								
			               		 $s = "{" . $header . "}";
									//$s_url = "vap1.in/xyz/xxxxxxx";
								 
			               		 $session_name="placeholder*".$header;
			               		 $val=$csv[$c][$header];

			               		 if(empty($val))
			               		 {
			               		 	if(isset($_SESSION[$session_name]))
			               		 	{
			               		 		$default_value =$_SESSION[$session_name];

			               		 		$sms = str_replace($s,$default_value, $sms);
											// if(!empty($dynamic_url))
											// {
											// 	$subRandNo = subRandomNumGen(3);
											//    $randNo = randomNumGen(7);
											//    $combRandNo = $subRandNo . '/' . $randNo;
											//    $sms = str_replace('xyz/xxxxxxx',$combRandNo, $sms);
											// 	$rand_val=$subRandNo."|comb|".$randNo;
		
											// }
										//$sms = str_replace($s_url,$default_value, $sms);
			               		 	}
			               		 	else
			               		 	{
			               		 		
			               		 		$default_value =0;
			               		 		$sms = str_replace($s,$default_value, $sms);
											// if(!empty($dynamic_url))
											// {
											// 	$subRandNo = subRandomNumGen(3);
											//    $randNo = randomNumGen(7);
											//    $combRandNo = $subRandNo . '/' . $randNo;
											//    $sms = str_replace('xyz/xxxxxxx',$combRandNo, $sms);
											// 	$rand_val=$subRandNo."|comb|".$randNo;
		
											// }
										//$sms = str_replace($s_url,$default_value, $sms);
			               		 	}
				               		/*if(count($default_value)>0)
									{
										for($k=0;$k<count($default_value);$k++)
										{
											if($default_value[$k]!='')
											{
												$sms=preg_replace("/{#var#}/",$default_value[$k], $sms,1);
											}
											
										}
									}*/
					              }
					              else
					              {
									$sms = str_replace($s,$val, $sms);
									
									   
					              		 
										 
					              } 
								  
								 
			               		
							}
							if($dynamic_url!='')
							{
								//$subRandNo="";
								$randNo="";
								$combRandNo="";
								
								$randNo = randomNumGen(7);
								$combRandNo = $senderid . '/' . $randNo;
								$sms = str_replace('abcxyz/xxxxxxx',$combRandNo, $sms);
								$rand_val=$senderid."|comb|".$randNo;
								
								$sms.='*|*|*|'.$dynamic_original_url.'-|-|-|'.$rand_val ;
							}
		               		
               
		                //$preview.="<tr><td>$mobile_no</td><td style='word-break: break-all;'>$sms</td><td>$msg_len</td><td>$msgcredit</td></tr>";
		                $message.=$mobile_no . '||' . $sms . "*****";
		            }


		            	for ($c = 0; $c < 5; $c++) {
							$sms=$msg;
					/*	
						if(count($default_value)>0)
						{
							for($k=0;$k<count($default_value);$k++)
							{
								if($default_value[$k]!='')
								{
									$sms=preg_replace("/{#var#}/",$default_value[$k], $sms,1);
								}
							}
						}*/
		                $col1_header= $columns[0];
		                $mobile_no=$csv[$c][$col1_header];

		                	for($i=0;$i<count($columns);$i++)
							{
								$header="$columns[$i]";
								
			               		 $s = "{" . $header . "}";

			               		 $val=$csv[$c][$header];
			               			
			               		// $sms = str_replace($s,$val, $sms);
			               		  $session_name="placeholder*".$header;
			               		if(empty($val))
			               		 {
			               		 	if(isset($_SESSION[$session_name]))
			               		 	{
			               		 		$default_value =$_SESSION[$session_name];

			               		 		$sms = str_replace($s,$default_value,$sms);
			               		 	}
			               		 	else
			               		 	{
			               		 		
			               		 		$default_value =0;

			               		 		$sms = str_replace($s,$default_value, $sms);
			               		 		

			               		 	}


				               		/*if(count($default_value)>0)
									{
										for($k=0;$k<count($default_value);$k++)
										{
											if($default_value[$k]!='')
											{
												$sms=preg_replace("/{#var#}/",$default_value[$k], $sms,1);
											}
											
										}
									}*/
					              }
					              else
					              {
					              		 $sms = str_replace($s,$val, $sms);
										//    if(!empty($dynamic_url))
										//    {
										// 	   $subRandNo = subRandomNumGen(3);
										// 	  $randNo = randomNumGen(7);
										// 	  $combRandNo = $subRandNo . '/' . $randNo;
										// 	  $sms = str_replace('xyz/xxxxxxx',$combRandNo, $sms);
	   
										//    }
					              } 

			               		 $msg_len=strlen($sms);
			               		  if ($msg_len > $SMS) {
							            $msgcredit = ceil($msg_len / $udh);
							        }
							        else
							        {
							        	$msgcredit=1;
							        }
							}
		               		
               
		                $preview.="<tr><td>$mobile_no</td><td style='word-break: break-all;'>$sms</td><td>$msg_len</td><td>$msgcredit</td></tr>";
		                //$message.=$mobile_no . '||' . $sms . "*****";
		            }
		             echo $preview=$tbl_head.$preview."</table>"."|||".$message;

			}
	}
		else if ($_REQUEST['act'] == 'preview2') {
		$file_name=$_REQUEST['file_name'];
		$msg=$_REQUEST['msg'];
		/*$default_val=$_REQUEST['default_value'];

		$default_value=explode(",",$default_val);*/
		/*print_r($default_value);*/
		$target_dir = "/var/www/html/itswe_panel/view/include/data/dynamic_sms_csv/";
		 $file_path=$target_dir.$file_name;
			$row=0;
		if (($handle = fopen($file_path, "r")) !== FALSE) {
			
					$columns = fgetcsv($handle, 50000, ",");
					  $csv = array();
					  $i = 0;
					while (($data = fgetcsv($handle, 50000, ",")) !== FALSE) {
						  $csv[$i] = array_combine($columns, $data);
        					$i++;

					}

					$tbl_head ="<table id='tfhover' class='table table-hover' border='1' width='100%'><tr><th scope='col'>$columns[0]</th><th scope='col'>Message</th><th scope='col'>Char count</th><th scope='col'>Bill</th></tr>";

					$num=count($csv);
					$udh = 153;
			        $SMS = 160;
			        $msgcredit = 1;  

					for ($c = 0; $c < $num; $c++) {
						$sms=$msg;
					
						
			
		                $col1_header= $columns[0];
		                $mobile_no=$csv[$c][$col1_header];

		                	for($i=0;$i<count($columns);$i++)
							{
								$header="$columns[$i]";
								
			               		 $s = "{" . $header . "}";

			               		 $session_name="placeholder*".$header;
			               		 $val=$csv[$c][$header];

			               		 if(empty($val))
			               		 {
			               		 	
			               		 	
			               		 	if(isset($_SESSION[$session_name]))
			               		 	{
			               		 		
			               		 		$default_value =$_SESSION[$session_name];

			               		 		$sms = str_replace($s,$default_value, $sms);
			               		 	}
			               		 	else
			               		 	{
			               		 		
			               		 		$default_value =0;

			               		 		$sms = str_replace($s,$default_value, $sms);
			               		 		

			               		 	}
				               		
					              }
					              else
					              {

					              		 $sms = str_replace($s,$val, $sms);

					              } 			
			               		

			               		 /*$msg_len=strlen($sms);
			               		  if ($msg_len > $SMS) {
							            $msgcredit = ceil($msg_len / $udh);
							        }
							        else
							        {
							        	$msgcredit=1;
							        }*/
							}
		               		
               
		                //$preview.="<tr><td>$mobile_no</td><td style='word-break: break-all;'>$sms</td><td>$msg_len</td><td>$msgcredit</td></tr>";
		                $message.=$mobile_no . '||' . $sms . "*****";
		            }

		         

		            	for ($c = 0; $c < 5; $c++) {
							$sms=$msg;
					/*	
						if(count($default_value)>0)
						{
							for($k=0;$k<count($default_value);$k++)
							{
								if($default_value[$k]!='')
								{
									$sms=preg_replace("/{#var#}/",$default_value[$k], $sms,1);
								}
							}
						}*/
		                $col1_header= $columns[0];
		                $mobile_no=$csv[$c][$col1_header];

		                	for($i=0;$i<count($columns);$i++)
							{
								$header="$columns[$i]";
								
			               		 $s = "{" . $header . "}";

			               		 $val=$csv[$c][$header];
			               			
			               		// $sms = str_replace($s,$val, $sms);
			               		  $session_name="placeholder*".$header;
			               		if(empty($val))
			               		 {
			               		 	if(isset($_SESSION[$session_name]))
			               		 	{
			               		 		$default_value =$_SESSION[$session_name];

			               		 		$sms = str_replace($s,$default_value,$sms);
			               		 	}
			               		 	else
			               		 	{
			               		 		
			               		 		$default_value =0;

			               		 		$sms = str_replace($s,$default_value, $sms);
			               		 		

			               		 	}

				               		
					              }
					              else
					              {
					              		 $sms = str_replace($s,$val, $sms);
					              } 

			               		 $msg_len=strlen($sms);
			               		  if ($msg_len > $SMS) {
							            $msgcredit = ceil($msg_len / $udh);
							        }
							        else
							        {
							        	$msgcredit=1;
							        }
							}
		               		
               
		                $preview.="<tr><td>$mobile_no</td><td style='word-break: break-all;'>$sms</td><td>$msg_len</td><td>$msgcredit</td></tr>";
		                //$message.=$mobile_no . '||' . $sms . "*****";
		            }
		             echo $preview=$tbl_head.$preview."</table>"."|||".$message;

			}
	}


	function subRandomNumGen($length) 
	{
        global $dbc;
        $str = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz', 2)), 0, $length);
        $sql = "SELECT (1) AS cnt FROM `az_temp_trackingkey` WHERE `sub_track_key` = '{$str}' LIMIT 1;";
        $res = mysqli_query($dbc, $sql);
        if (mysqli_num_rows($res) > 0) {
            subRandomNumGen($length);
        }
        return $str;
    }

	function randomNumGen($length) {
        return substr(str_shuffle(str_repeat('ABCghijDEFGH0123IJKLMNOPtuvwxQRSopqrsTUVW459XYZabcdefklmn678yz', 5)), 0, $length);
    }
	

?>