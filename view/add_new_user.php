<?php


// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// include('../include/config.php');
 $new_password=random_strings(10);

 function random_strings($length_of_string)
    {
        // String of all alphanumeric character
        $str_result = '0123456789ABCDEFGHJKMNOPQRSTUVWXYZabcdefghjkmnopqrstuvwxyz';
        return substr(str_shuffle($str_result),0,$length_of_string);
    }



function get_childUsers($userids)
{
    global $dbc;

    $child = array();

    $userids_str = implode(",", $userids);

 $qry = "SELECT userid, user_role,user_name FROM az_user WHERE parent_id IN ($userids_str)  ORDER BY userid DESC";
    $rs = mysqli_query($dbc, $qry);

    while ($row = mysqli_fetch_assoc($rs)) {

        if($row['user_role']=='mds_usr')
        {
            $childUser = array(
            'userid' => $row['userid'],
            'user_role' => $row['user_role'],
            'user_name' => $row['user_name'],
            'children' => []
             
            );

            $child[] = $childUser;   
        }
        else
        {
            $childUser = array(
            'userid' => $row['userid'],
            'user_role' => $row['user_role'],
            'user_name' => $row['user_name'],
            'children' => get_childUsers([$row['userid']]) // Recursive call for nested children
        );

        
        }
        
    }

    return $child;
}

function get_onlyResellers($userids)
{
    global $dbc;

    $resellers = array();

    $userids_str = implode(",", $userids);

    $qry = "SELECT userid, user_role,user_name FROM az_user WHERE parent_id IN ($userids_str) AND (user_role='mds_rs' OR user_role='mds_ad') ORDER BY userid DESC";
    $rs = mysqli_query($dbc, $qry);

    while ($row = mysqli_fetch_assoc($rs)) {
        $user = array(
            'userid' => $row['userid'],
            'user_role' => $row['user_role'],
            'user_name' => $row['user_name'],
            'children' => get_childUsers([$row['userid']]) // Include both resellers and users
        );

        $resellers[] = $user;
    }

    return $resellers;
}
if($_SESSION['user_role']=='mds_usr')
{
  $uid=$_SESSION['user_id'];
// // Example usage
$userId[] = $uid;


$resellerTree = get_onlyResellers($userId);
$directUserTree=get_childUsers($userId);

// Convert the tree structure to JSON for easier handling in JavaScript
$treeJson = json_encode($directUserTree, JSON_PRETTY_PRINT);  
}


  ?>

  
 
          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                  <span id="page_name" style="display:none;">manage_user</span>
                    <h4>Add New User</h4>
                    
                 
                  </div>
                  <div class="card-body">
                  <form id="add_user_form"  name="add_user_form" method="POST">
                  <input type="hidden" name="list_type" value="save_new_user">
                  <div id="action_message" style="display:''"><?php if(isset($_SESSION['succ']) && !empty($_SESSION['succ'])) { echo '<span class="asm1">'.$_SESSION['succ'].'</span>'; $_SESSION['succ'] = ''; } else if(isset($_SESSION['err']) && !empty($_SESSION['err'])) { echo '<span class="awm1">'.$_SESSION['err'].'</span>'; $_SESSION['err'] = '';}?></div>

                  <div class="container-fluid">
                     <div class="input-group pmd-input-group mb-3 row">
                      <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Username</label>
                        </div>
                        <div class="pmd-textfield col col-sm-3" >
                    <input type="text" class="form-control" aria-label="username" aria-describedby="basic-addon1" id="username" name="username">
                </div>
                <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Password</label>
                        </div>
                        <div class="pmd-textfield col col-sm-3" >
                    <input type="text" class="form-control" aria-label="password" aria-describedby="basic-addon1" id="password" name="password" value="<?php echo $new_password; ?>">
                </div>
                <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Mobile No.</label>
                        </div>
                        <div class="pmd-textfield col col-sm-3" >
                    <input type="text" class="form-control" aria-label="mobile" aria-describedby="basic-addon1" id="mobile" name="mobile">
                </div><br>
                 <br/><br>
                <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Full Name</label>
                        </div>
                        <div class="pmd-textfield col col-sm-3" >
                    <input type="text" class="form-control" aria-label="f_name" aria-describedby="basic-addon1" id="f_name" name="f_name">
                </div>
                 <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Company Name</label>
                        </div>
                        <div class="pmd-textfield col col-sm-3" >
                    <input type="text" class="form-control" aria-label="company_name" aria-describedby="basic-addon1" id="company_name" name="company_name">
                </div><br><br><br>
                 <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Email</label>
                        </div>
                        <div class="pmd-textfield col col-sm-3" >
                    <input type="email" class="form-control" aria-label="email" aria-describedby="basic-addon1" id="email" name="email">
                </div>
                 <div class="col col-sm-1">
                          <label for="inputEmail3" class="">City</label>
                        </div>
                        <div class="pmd-textfield col col-sm-3" >
                    <input type="text" class="form-control" aria-label="city" aria-describedby="basic-addon1" id="city" name="city">
                </div><br><br><br>
                 <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Pincode</label>
                        </div>
                        <div class="pmd-textfield col col-sm-3" >
                    <input type="text" class="form-control" aria-label="pincode" aria-describedby="basic-addon1" id="pincode" name="pincode">
                </div>

                 <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Role</label>
                        </div>
                        <div class="pmd-textfield col col-sm-3">
                            <input type="hidden" name="selected_user_role" id="selected_user_role"/>
                   <select class="form-control" name="role" id="role" aria-label="role" aria-describedby="basic-addon1">
                            
                        

                           </select>
                </div>
                 <br/><br>
                <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Route</label>
                        </div>
                        <div class="pmd-textfield col col-sm-3" >
                        <input class="form-control some_class_name" name="routes" id="routes" placeholder="Select Routes" required>
                        <input type="hidden" id="route" name="route"> 
                       <!-- <select class="form-control" name="route[]" id="route" aria-label="route" aria-describedby="basic-addon1" multiple>
                             <option value="">Select Route</option>
                        </select>  -->
                </div>
                <div class="col col-sm-1">
                    <label for="inputEmail3" class="">API Key</label>
                </div>
                <div class="pmd-textfield col col-sm-3" >
                    <input type="text" class="form-control" aria-label="pincode" aria-describedby="basic-addon1" readonly id="api_key" name="api_key" maxlength="12">
                    <br/>
                    <button type="button" class="btn btn-primary pmd-ripple-effect" name="input-form-submit" value="Generate" id="api_key_btn">Generate</button>

                </div>
             
             

               
                
                       
            </div>
          
             <!-- <hr width="100%" />
                <div class="card user_access" >
                <div class="card-body" >
                  
                  
                   <div class="container-fluid">
                     <div class="input-group pmd-input-group mb-3 row">
                        <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Services</label>
                        </div>
                        
                        <div class="pmd-textfield col col-sm-3" >
                        <select class="form-control" name="services[]" id="services" aria-label="route" aria-describedby="basic-addon1" multiple>
                             
                             
                             <optgroup label="SMS Reports">SMS Reports
                                <option value="today_report">Today Report</option>
                                <option value="job_report">Send Jobs</option>
                                <option value="schedule_report">Schedule Report</option>
                                <option value="mis_report">Summary / MIS Report</option>
                                <option value="error_desc">Error Description</option>

                             </optgroup>

                             
                        

                       </select>
                        </div>

                        <div class="col col-sm-1">
                          <label for="inputEmail3" class="">User Tree</label>
                        </div>

                        <div class="pmd-textfield col col-sm-7" id="tree-container" >
                                

                        </div>
                     </div>
                    </div>


            
                </div>
                </div> -->
                <br/>
            <div class="form-group">
                <button type="submit" class="btn btn-primary pmd-ripple-effect" name="input-form-submit" value="Subscribe" id="save_user_btn">Save</button>
                
            </div>

                    
                  </div>
                   </form>
                  </div>
                </div>
              </div>
              <!-- Zero Configuration  Ends-->
            </div>

       
  

  <!-- add new user js files -->
  <script  src="assets/js/jquery.multiselect.js?=<?php echo time();?>"></script>
  <script src="assets/js/user_details.js?<?php echo time(); ?>"></script>
