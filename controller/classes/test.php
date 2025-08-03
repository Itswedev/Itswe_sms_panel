<?php  

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// $id= get_childUsers(2);


$block_num=getBlockNumbers_json();
print_r($block_num);
echo "<br>";

 function getBlockNumbers_json() {
        global $dbc;
       
      $dnd_file = "/var/www/html/itswe_panel/controller/classes/block.json";

         echo $jsonString = file_get_contents($dnd_file);
         $data = json_decode($jsonString, true);
        $numbers=$data['mobile'];
        
       

        return $numbers;
    }

// function get_childUsers($userid)
// {
//   global $dbc;
//   static $ids = array();
  
   
//         $qry = "SELECT userid FROM az_user WHERE parent_id = '{$userid}'";
//         $rs = mysqli_query($dbc, $qry);
//         if(mysqli_num_rows($rs)>0) {
//           while($row = mysqli_fetch_array($rs))
//           {

//             $ids[] = $row['userid'];
//             //print_r($ids);
//             if($row['userid'] == 1 ) {
//               //return $ids;
//             }
//             else
//             {
//             if(!empty($ids)) {
//               return get_childUsers($row['userid']);
//             }else {

//               if($userid == $row['userid']) {
//                 $ids[] = $rows['userid'];
//                 return get_childUsers($row['userid']);
//               }
//             }
//           }
//         }

//          return $ids;
          
//         }
//         else {
//       return $ids;
//     }
    

    
    

// }



?>