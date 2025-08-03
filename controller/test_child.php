<?php
session_start();

include('../include/connection.php');
include('logger/Logger.php');
include('../include/config.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



	$userid[]=2;
	$userid1=[38,42];

  $logger = Logger::getLogger("main");


 // $child_users=get_childUsers($userid);
  $parent_users=get_parentUsers($userid1,$logger);

$logger->trace($userid1);
/*  print_r($child_users);
  echo count($child_users);*/
  /*foreach ($child_users as $child_val) {
  	foreach($child_val as $val)
  	{
  		$single_arr[]=$val;
  	}
  }

  print_r($single_arr);
*/

  foreach ($parent_users as $parent_val) {
  	
  		$single_arr1[]=$parent_val;
  	
  }

  /*print_r($single_arr1);*/

function get_childUsers($userid)
{
  global $dbc;
   $ids = array();
  static $child=array();
   $userids=implode(",", $userid);
   
       $qry = "SELECT userid FROM az_user WHERE parent_id in ($userids)";
        $rs = mysqli_query($dbc, $qry);
        if(mysqli_num_rows($rs)>0) {
          while($row = mysqli_fetch_array($rs))
          {
          	//echo $row['userid'];
            $ids[] = $row['userid'];
       		

       			
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

function get_parentUsers($userid,$logger)
{
  global $dbc;
  // $ids = array();
  static $parent=array();
  // $userids=implode(",", $userid);
   $userids=implode(",", $userid);
      $qry = "SELECT parent_id FROM az_user WHERE `userid` in ($userids)";
        $rs = mysqli_query($dbc, $qry);
        $logger->info($rs);
        if(mysqli_num_rows($rs)>0) {
          while($row = mysqli_fetch_array($rs))
          {
          	//echo $row['userid'];
            $ids = $row['parent_id'];
       		

       			
        	}

        	if(!empty($ids)) {
        		$parent[]=$ids;
        		if($ids==1)
        		{
        			return $parent;
        		}
        		else
        		{
        			return get_parentUsers($ids,$logger);
        		}
              
            	}
        	//return $ids;
          
        }
        else {
      return $parent;
    }
    

    
    

}
