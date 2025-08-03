<?php 
session_start();
//include('controller/manage_gateway_controller.php');
$miscall_access=$_SESSION['miscall_access'];
$vsms_access=$_SESSION['vsms_access'];
$rcs_access=$_SESSION['rcs_access'];
$edit_userid=$_SESSION['edit_userid'];



 ?>




        <div class="page-body">
          <!-- Container-fluid starts-->
          <div class="container-fluid default-dashboard"> 
          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                  <input type="hidden" name="login_user_role" id="login_user_role" value="<?php echo $_SESSION['user_role']; ?>">
                  <span id="page_name" style="display:none;">edit_user</span>
                    <h4>Edit User</h4>
                    
                 
                  </div>
                  <div class="card-body">

<ul class="nav nav-pills" id="pill-myTab" role="tablist">
                      <li class="nav-item"><a class="nav-link active" id="pill-home-tab" data-bs-toggle="tab" href="#pill-tab-home" role="tab" aria-controls="pill-tab-home" aria-selected="true" style="border-radius: 1.25rem;">Overview</a></li>
                      <li class="nav-item settings"><a class="nav-link" id="pill-profile-tab" data-bs-toggle="tab" href="#pill-tab-profile" role="tab" aria-controls="pill-tab-profile" aria-selected="false" style="border-radius: 1.25rem;">Settings</a></li>
                      <li class="nav-item"><a class="nav-link" id="pill-access-tab" data-bs-toggle="tab" href="#pill-tab-access" role="tab" aria-controls="pill-tab-access" aria-selected="false" style="border-radius: 1.25rem;">User Access</a></li>
                      <li class="nav-item"><a class="nav-link" id="pill-sender-tab" data-bs-toggle="tab" href="#pill-tab-sender" role="tab" aria-controls="pill-tab-sender" aria-selected="false" style="border-radius: 1.25rem;">Sender</a></li>
                      <li class="nav-item"><a class="nav-link" id="pill-credit-tab" data-bs-toggle="tab" href="#pill-tab-credit" role="tab" aria-controls="pill-tab-credit" aria-selected="false" style="border-radius: 1.25rem;">Manage Credits</a></li>

</ul>


<div class="tab-content border p-3 mt-3" id="pill-myTabContent">
  <div class="tab-pane fade show active" id="pill-tab-home" role="tabpanel" aria-labelledby="home-tab">
    <form id="save_profile_form"  name="save_profile_form" method="POST">
      <input type="hidden" name="list_type" value="update_user">
        <div class="row g-3 mb-3">
            
            <div class="col-lg-12">
              <div class="card" >
                
                <div class="card-body">
                <!--   <div id="action_message" style="display:''"><?php if(isset($_SESSION['succ']) && !empty($_SESSION['succ'])) { echo '<span class="asm1">'.$_SESSION['succ'].'</span>'; $_SESSION['succ'] = ''; } else if(isset($_SESSION['err']) && !empty($_SESSION['err'])) { echo '<span class="awm1">'.$_SESSION['err'].'</span>'; $_SESSION['err'] = '';}?></div> -->

                  <div class="container-fluid">
              <div class="row">
                <input type="hidden" name="userid" id="userid" value="<?php echo $edit_userid; ?>">
                <input type="hidden" name="type" value="save_profile">
                        <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Username</label>
                        </div>
                      <div class="pmd-textfield col col-sm-3" >
                            <input type="text" class="form-control" aria-label="username" aria-describedby="basic-addon1" id="username" name="username" readonly>
                        </div>
                        <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Password</label>
                        </div>
                        <div class="pmd-textfield col col-sm-3" >
                    <input type="text" class="form-control" aria-label="password" aria-describedby="basic-addon1" id="password" name="password">
                </div>
                      <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Mobile No.</label>
                        </div>
                        <div class="col col-sm-3">
                          <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Enter Mobile Number">
                          
                        </div>


                </div>
                <br/>

                  <div class="row">
                        <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Full Name</label>
                        </div>
                        <div class="col col-sm-3">
                          <input type="text" class="form-control" name="f_name" id="f_name" placeholder="Enter Full Name">
                          
                        </div>
                        <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Company Name</label>
                        </div>
                        <div class="col col-sm-3">
                          <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Company Name">
                          
                        </div>

                      <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Email</label>
                        </div>
                        <div class="col col-sm-3">
                          <input type="text" class="form-control" name="email" id="email_id" placeholder="Enter Email">
                          
                        </div>


                </div>
                <br/>



                  <div class="row">
                        <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Role</label>
                        </div>
                        <div class="col col-sm-3">
                          <input type="hidden" name="selected_user_role" id="selected_user_role"/>
                          <select class="form-control" name="role" id="role">
                            

                          </select>
                          
                        </div>
                        <div class="col col-sm-1">
                          <label for="inputEmail3" class="">City</label>
                        </div>
                        <div class="col col-sm-3">
                          <input type="text" class="form-control" name="city" id="city" placeholder="Enter City">
                          
                        </div>

                      <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Pincode</label>
                        </div>
                        <div class="col col-sm-3">
                          <input type="text" class="form-control" name="pincode" id="pincode" placeholder="Enter Pincode">
                          
                        </div>


                </div>
                <br/>




                  <div class="row">
                        <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Route</label>
                        </div>
                        <div class="col col-sm-3">
                          <!-- <select class="form-control" id="route" name="route[]" multiple>                          
                          </select> -->


                        <input class="form-control some_class_name" name="routes" id="routes" placeholder="Select Route" >
                        <input type="hidden" id="route" name="route">  
                          
                        </div>

                          <div class="col col-sm-1">
                          <label for="inputEmail3" class="">API Key</label>
                          </div>
                          <div class="pmd-textfield col col-sm-3" >
                              <input type="text" class="form-control" aria-label="pincode" aria-describedby="basic-addon1" readonly id="edit_api_key" name="api_key" maxlength="12">
                              <br/>
                              <button type="button" class="btn btn-primary pmd-ripple-effect" name="input-form-submit" value="Generate" id="edit_api_key_btn">Generate</button>
                          </div>
                            <div class="col col-sm-1">
                  <label for="inputEmail3" class="">Account Manager</label>
                        </div>
                          <div class="pmd-textfield col col-sm-3" >
                          <select class="form-control" name="acct_manager" id="acct_manager" aria-label="acct_manager" aria-describedby="basic-addon1">
                                    <option value="">Select Account Manager</option>
                                

                          </select>
                            </div>
                          
                  </div>


                <br/>
                <br/>
            
                <div class="row">
                        <div class="col col-sm-1">
                          
                        </div>
                        <div class="col col-sm-3">
                          <button type="submit" class="btn btn-primary pmd-ripple-effect" name="input-form-submit" value="Subscribe" id="save_user_btn">Save</button>
                            <!-- <button type="reset" class="btn btn-secondary">Clear</button> -->
                          
                        </div>
                          <div class="col col-sm-1">
                          
                        </div>
                        <div class="col col-sm-3">
                          
                          
                        </div>
                          <div class="col col-sm-1">
                          
                        </div>
                        <div class="col col-sm-3">
                          
                          
                        </div>

                </div>
                <br/>


                    
                  </div>

                </div>
            </div>
          </div>
        </div>
    </form>

  </div>


  <div class="tab-pane fade settings" id="pill-tab-profile" role="tabpanel" aria-labelledby="profile-tab">
    <?php 
      if ($_SESSION['user_role']!='mds_ad') {




    ?>
    <form id="update_plan_form"  name="update_plan_form" method="POST">
      <input type="hidden" name="list_type" value="update_plan">
        <input type="hidden" name="userid" id="userid" value="<?php echo $edit_userid; ?>">
        <div class="row g-3 mb-3">
            
            <div class="col-lg-12">
              <div class="card" >
                
                <div class="card-body">
              

              <div class="container-fluid">
              <div class="row">
                        <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Plan</label>
                        </div>
                        <div class="col col-sm-3">
                          <select name="plan" id="plan" class="form-control">
                            
                          </select>
                        </div>
                        <div class="col col-sm-4">
                          <button type="button" id="save_plan_btn" class="btn btn-primary">Save Plan</button>
                          
                        </div>
                        
                </div>
                <br/>


                  </div>

                </div>
            </div>
          </div>
        </div>
</form> 
<?php 

}
?>
<hr width="100%">
<b>Apply Cutting</b>
<form id="cut_off_form"  name="cut_off_form" method="POST">
<input type="hidden" name="list_type" value="cut_off_module">

<div class="row g-3 mb-3">
    
    <div class="col-lg-12">
      <div class="card" >
        
        <div class="card-body">
      

      <div class="container-fluid">
      <div class="row">
                <div class="col col-sm-2">
                  <label for="inputEmail3" class="">Route</label>
                </div>
              
              <!--  <div class="col col-sm-2">
                  <label for="inputEmail3" class="">Cutting</label>
                </div> -->
                

              <div class="col col-sm-2">
                  <label for="inputEmail3" class="">Cutt-Off Status</label>
                </div>

                <div class="col col-sm-2">
                  <label for="inputEmail3" class="">Cutting Throughput</label>
                </div>

                <div class="col col-sm-2">
                  <label for="inputEmail3" class="">Cutting Min Value</label>
                </div>
              


        </div>

        <br/>
                <div class="row">
                <div class="col col-sm-2">
                  <select name="route_cutoff" id="route_cutoff" class="form-control">
                    
                  </select>
                </div>
              
                <!-- <div class="col col-sm-2">
                <select name="cutting" id="cutting" class="form-control">
                    <option value="">Select Cutting</option>
                    
                  </select>
                </div>
                -->

              <div class="col col-sm-2">
                <select name="cut_off_status" id="cut_off_status" class="form-control">
                    <option value="">Select Status</option>
                    <!-- <option value="Delivered">Delivered</option> -->
                      <!-- <option value="Failed">Failed</option> -->
                      <option value="Submitted">Submitted</option>
                    
                  </select>
                </div>

                <div class="col col-sm-2">
                <input type="text" class="form-control" name="c_throughput" id="c_throughput" placeholder="eg. 50-60">
                </div>

                <div class="col col-sm-2">
                <input type="text" class="form-control" name="c_min_val" id="c_min_val" placeholder="eg. 10000">
                </div>

                <div class="col col-sm-2">
                <button type="submit" id="save_cut_off" class="btn btn-primary">Save</button>
                </div>
              


        </div>

            

          </div>

        </div>
    </div>
  </div>
</div>
</form> 

  <div class="row g-3 mb-3">
    
    <div class="col-lg-12">
      <div class="card" >
        
        <div class="card-body">
      

      <div class="container-fluid">
      <div class="row">
                <div class="col col-sm-12">
                                      
<div id="tableExample2" data-list='{"valueNames":["name","email","age"],"page":5,"pagination":true}'>
  <div class="table-responsive scrollbar">
    <table class="table table-bordered table-striped fs--1 mb-0">
      <thead class="bg-200 text-900">
        <tr>
          <th class="sort" data-sort="name" width="5%">Sr. No.</th>
          <th class="sort" data-sort="email">Cut-Off Route</th>
        
          <th class="sort" data-sort="age">Cutt-Off Status</th>
          <th class="sort" data-sort="age">Cutting Throughput</th>
        
          <th class="sort" data-sort="age">Cutting Min Value</th>
          
          <th class="sort" data-sort="age">Action(s)</th>
        </tr>
      </thead>
      <tbody class="cut_off_list" id="cut_off_list">

      </tbody>
    </table>
  </div>

</div>
                </div>
              
                


        </div>

        <br/>
                
            

          </div>

        </div>
    </div>
  </div>
</div>




</div>


<div class="tab-pane fade" id="pill-tab-access" role="tabpanel" aria-labelledby="access-tab">    
<form id="add_user_form"  name="add_user_form" method="POST">
<input type="hidden" name="userid" id="userid" value="<?php echo $edit_userid; ?>">
<div class="row g-3 mb-3">
    
    <div class="col-lg-12">
      <div class="card" >
        
        <div class="card-body">
      

      <div class="container-fluid">
      <div class="row">
                <div class="col col-sm-2">
                  <label for="inputEmail3" class="">API Access</label>
                </div>
                <div class="col col-sm-1">
                  <div class="form-check form-switch"><input class="form-check-input user_access" id="api_access" name="api_access"  type="checkbox" /></div>
                </div>
                
                
        </div>
        <div class="row">
                <div class="col col-sm-2">
                  <label for="inputEmail3" class="">Restricted Report</label>
                </div>
                <div class="col col-sm-2">
                  <div class="form-check form-switch"><input class="form-check-input user_access" id="restricted_report" name="restricted_report"  type="checkbox" /></div>
                </div>
                
                
        </div>

        <div class="row">
                <div class="col col-sm-2">
                  <label for="inputEmail3" class="">Restricted TLV</label>
                </div>
                <div class="col col-sm-2">
                  <div class="form-check form-switch"><input class="form-check-input user_access" id="restricted_tlv" name="restricted_tlv"  type="checkbox" /></div>
                </div>
                
                
        </div>
          
        <div class="row" id="voice_call_sec">
                <div class="col col-sm-2">
                  <label for="inputEmail3" class="">Voice Call</label>
                </div>
                <div class="col col-sm-2">
                  <div class="form-check form-switch"><input class="form-check-input user_access" id="voice_call" name="voice_call"  type="checkbox" /></div>
                </div>
                
                
        </div>
       
        <div class="row" id="campaign_report_sec">
                <div class="col col-sm-2">
                  <label for="inputEmail3" class="">Campaign Report</label>
                </div>
                <div class="col col-sm-2">
                  <div class="form-check form-switch"><input class="form-check-input user_access" id="campaign_report" name="campaign_report"  type="checkbox" /></div>
                </div>
        </div>
        
        <div class="row" id="rcs_sec">
                <div class="col col-sm-2">
                  <label for="inputEmail3" class="">Smart SMS (RCS)</label>
                </div>
                <div class="col col-sm-2">
                  <div class="form-check form-switch"><input class="form-check-input user_access" id="rcs" name="rcs" type="checkbox" /></div>
                </div>
                
                
        </div>

          </div>
          
          <?php
          $userid=$_SESSION['user_id'];



          ?>
</form>

<hr width="100%;">

<div class="container-fluid rcs_key_section" style="display: none;">
Smart SMS (RCS)
<br/>
          <form method="post" enctype="multipart/form-data">
          <input type="hidden" name="userid" id="rcs_userid" value="<?php echo $edit_userid; ?>"  />
          <div class="row">
              <div class="col col-sm-2">
                <label for="inputEmail3" class="">Text</label>
              </div>
              <div class="col col-sm-2">
                
                  <input type="text" class="form-control text_rate" id="text_rate" name="text_rate" placeholder="0.00" > 
              </div>
            </div>
            <br/>
            <div class="row">
              
              <div class="col col-sm-2">
                <label for="inputEmail3" class="">Rich Card / Carousal</label>
              </div>
              <div class="col col-sm-2">
                
                  <input type="text" class="form-control rich_card_rate" id="rich_card_rate" name="rich_card_rate" placeholder="0.00" > 
              </div>
            </div>
            <br/>
            <div class="row">
              <div class="col col-sm-2">
                <label for="inputEmail3" class="">A2P Conversion</label>
              </div>
              <div class="col col-sm-2">
                
                  <input type="text" class="form-control a2p_rate" id="a2p_rate" name="a2p_rate" placeholder="0.00"> 
              </div>
            </div>
            <br/>
            <div class="row">
              <div class="col col-sm-2">
                <label for="inputEmail3" class="">P2A Conversion</label>
              </div>
              <div class="col col-sm-2">
                
                  <input type="text" class="form-control p2a_rate" id="p2a_rate" name="p2a_rate" placeholder="0.00"> 
              </div>
            <div class="col col-sm-3">
                
                  <button type="button" class="btn btn-primary" id="add_rcs_rate">Save</button>
                
          </div>
          </div>

          <br/>


          </form>

          </div>

</div>
</div>
</div>
</div>




</div>

<hr width="100%;">




<!-- credit tab -->
<div class="tab-pane fade settings" id="pill-tab-credit" role="tabpanel" aria-labelledby="credit-tab">
<form id="add_credit_form">
            <div class="container-fluid">
            
              <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
              
               <input name="page" type="hidden" id="page" value="credit"  />
               <input name="type" type="hidden" id="type" value="save_credit"  />
     
             
                
                <input type="hidden" id="credit_username" name="username" value="<?php echo $edit_userid; ?>">
              
             
              <div class="row ">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Route Type:</label></div>
                <div class="col-md-6">
                  <select class="form-control" id="credit_route" name="route">
                  <option value="">Select Route</option>             
                </select>

                </div>
              </div>
            
              <br/>
               
               <div class="row ">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Credit Type:</label></div>
                <div class="col-md-6">
                  <select class="form-control" id="credit_type" name="credit_type">
                  <option>Select Credit Type</option>
                  <option value="1">Credit</option>
                  <option value="0">Debit</option>
                  <option value="2">Refund</option>
                </select>

                </div>
              

              </div>
              <br/>
               <div class="row ">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Credit:</label></div>
                <div class="col-md-6">
                   <input type="text" class="form-control" name="credit" id="credit" placeholder="Credit"  min="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');"  >

                </div>
              

              </div>
               <br/>
             
             
               <div class="row ">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Remark:</label></div>
                <div class="col-md-6">
                              <textarea class="form-control" placeholder="Type remark here" id="remark" name="remark" style="height: 100px" ></textarea>
                              
                           
              </div>
              

              </div>
              
         
              <br/>
            </div>
            <div class="mirror_edit_ok_btn" id="createsenderid" style="text-align: center;">
        </div>
       
        <button type="button" class="btn btn-primary" id="save_credit">Save</button>
      </div>

        </form>
    
</div>

<!-- credit tab end -->
<!-- Sender Tab -->
<div class="tab-pane fade" id="pill-tab-sender" role="tabpanel" aria-labelledby="sender-tab">    

      
<div class="row g-3 mb-3">
   
   <div class="col-lg-12">
     <div class="card" >
       
       <div class="card-body">
     

     <div class="container-fluid">
        <form id="senderidsForm">
           <input type="hidden" name="type" value="saveuserSenderId"  />
           <input type="hidden" name="form_name" id="form_name" value="<?php echo $form_name; ?>"  />
           <input type="hidden" name="userid" value="<?php echo $edit_userid; ?>"  />
      <div class="row">
      
               <div class="col col-sm-2">
                 <label for="inputEmail3" class="">Sender ID / Header Name:</label>
               </div>
              <div class="col col-sm-3">
                  
                   <input type="text" class="form-control" name="senderid" maxlength="6" id="senderid_id">
                
               </div>
                   <div class="col col-sm-2">
                 <label for="inputEmail3" class="">Principle Entity ID (PE_ID):</label>
               </div>
              <div class="col col-sm-3">
                  
                   <input type="text" class="form-control" name="PE_ID" id="PE_ID"  placeholder="Principle Entity Id">
                
               </div>
             </div>
             <br/>

               <div class="row">
      
           
             </div>

              <div class="row">
      
               <div class="col col-sm-2">
                 <label for="inputEmail3" class="">Header ID:</label>
               </div>
              <div class="col col-sm-3">
                  
                   <input type="text" class="form-control" name="Header_ID" id="Header_ID" placeholder="Header Id">
                 
               </div>

                   <div class="col col-sm-2">
                 <label for="inputEmail3" class="">Description:</label>
               </div>
              <div class="col col-sm-3">
                 
                   <input type="text" class="form-control" name="descript" id="descript">
                
               </div>

             </div>


             <br/>
             <div class="row">     
             <div class="col col-sm-4">

                 
                 
               </div>           
              <div class="col col-sm-4">

                  
                   <button type="submit" class="btn btn-primary" id="save_sender_id">Save</button>
                   <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Clear</button>
               </div>
               <div class="col col-sm-4">

                 
                 
               </div>
             </div>


             


             </form>
                       



               
       </div>
        
     

         </div>

       </div>
   </div>
 </div>
</div>
<script src="assets/js/jquery.multiselect.js?=<?=time();?>"></script>

  

  <!-- EDIT user js files -->
  <script src="assets/js/utility.js?=<?=time();?>"></script>
  <script src="assets/js/jquery.multiselect.js?=<?=time();?>"></script>
  <?php include('include/modal_forms/edit_user_modal.php');?>
   <?php

$userid=$_SESSION['user_id'];
if($miscall_access=='No' and $edit_userid!=1)
{
?>

<script>
 
  document.getElementById("miscall_sec").classList.add("d_none");

</script>
<?php

}
else
{
?>

<script>
  document.getElementById("miscall_sec").classList.remove("d_none");
  
</script>
<?php
}
/*gvsms*/

if($vsms_access=='No' and $edit_userid!=1 )
{
?>

<script>
 
  document.getElementById("vsms_sec").classList.add("d_none");

</script>
<?php

}
else
{
?>

<script>
  document.getElementById("vsms_sec").classList.remove("d_none");
  
</script>
<?php
}

?>

</html>