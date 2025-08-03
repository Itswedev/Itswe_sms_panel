<?php
$api_key=$_SESSION['api_key'];
//include('controller/manage_gateway_controller.php');

 ?>

    <link rel="stylesheet" type="text/css" href="assets/css/vendors/sweetalert2.css">
   
   <div class="page-body">
   <div class="card mb-3">
            <div class="bg-holder d-none d-lg-block bg-card" style="" ></div>
            <!--/.bg-holder-->
            <div class="card-body position-relative">
              <div class="row">
                <div class="col-lg-4">
                  <h3><span id="page_name" style="display:none;">settings</span># Account Settings </h3>
                  
                </div>
                  <div class="col-lg-8">
               <!--   <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_route" id="add_route_btn" style="float:right;">+ Add Route </button> -->

                  
                </div>
              
              </div>
            </div>
          </div>

          <div class="row g-3 mb-3">
            
            <div class="col-lg-12">
              <div class="card" >
                
                <div class="card-body">

                   <ul class="nav nav-pills" id="pill-myTab" role="tablist">
                      <li class="nav-item"><a class="nav-link active" id="pill-home-tab" data-bs-toggle="tab" href="#pill-tab-setting" role="tab" aria-controls="pill-tab-home" aria-selected="true" style="border-radius: 1.25rem;">Alert Module</a></li>
                      <li class="nav-item"><a class="nav-link" id="pill-profile-tab" data-bs-toggle="tab" href="#pill-tab-profile" role="tab" aria-controls="pill-tab-profile" aria-selected="false" style="border-radius: 1.25rem;">Change Password</a></li>
                      <li class="nav-item"><a class="nav-link" id="pill-access-tab" data-bs-toggle="tab" href="#pill-tab-access" role="tab" aria-controls="pill-tab-access" aria-selected="false" style="border-radius: 1.25rem;">API Key</a></li>
                     
                    </ul>


                    <div class="tab-content border p-3 mt-3" id="pill-myTabContent">
  <div class="tab-pane fade show active" id="pill-tab-setting" role="tabpanel" aria-labelledby="home-tab">

         <div class="row g-3 mb-3">
            
            <div class="col-lg-12">
              <div class="card" >
                
                <div class="card-body">
                  <div id="action_message" style="display:''"><?php if(isset($_SESSION['succ']) && !empty($_SESSION['succ'])) { echo '<span class="asm1">'.$_SESSION['succ'].'</span>'; $_SESSION['succ'] = ''; } else if(isset($_SESSION['err']) && !empty($_SESSION['err'])) { echo '<span class="awm1">'.$_SESSION['err'].'</span>'; $_SESSION['err'] = '';}?></div>

                  <div class="container-fluid">
             <!--   <div class="row">
                <input type="hidden" name="userid" id="userid" value="<?php //echo $_REQUEST['edit_userid']?>">
                 <input type="hidden" name="type" value="save_profile">
                        <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Route</label>
                        </div>
                      <div class="pmd-textfield col col-sm-3" >
                           <select name="route" id="route" class="form-control">
                            
                           </select>
                        </div>
                        <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Sender</label>
                        </div>
                        <div class="pmd-textfield col col-sm-3" >
                   <select name="sender_id" id="sender_id" class="form-control">
                            
                           </select>
                </div>
                      <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Template</label>
                        </div>
                        <div class="col col-sm-3">
                            <select name="template_id" id="template_id" class="form-control">
                            
                           </select>
                          
                        </div>


                </div>
                <br/>
                <hr width="100%"> -->
                <b>Alert Access</b>
                <br/> <br/>
                 <form id="save_alert_module_form"  name="save_alert_module_form" method="POST">
              <input type="hidden" name="list_type" value="save_alert_module">
                  <div class="row">
                      <div class="col col-sm-2">
                          <label for="inputEmail3" class="">Low Balance</label>
                        </div>
                        <div class="col col-sm-1">
                           <div class="form-check form-switch"><input class="form-check-input low_balance setting_access" id="low_balance" name="low_balance"  type="checkbox" /></div>
                        </div>
                         <div class="col col-sm-3">
                           <input type="text" class="form-control" aria-label="username" aria-describedby="basic-addon1" id="low_balance_amt" name="low_balance_amt" placeholder="Limit" readonly >
                        </div>
                        <div class="col col-sm-3">
                           <input type="text" class="form-control" aria-label="username" aria-describedby="basic-addon1" id="low_balance_mobile" name="low_balance_mobile" placeholder="Mobile No. (Max 2)" readonly >
                        </div>
                  </div>
                 <div class="row">
                        <div class="col col-sm-2">
                          <label for="inputEmail3" class="">Login Alert</label>
                        </div>
                        <div class="col col-sm-2">
                           <div class="form-check form-switch"><input class="form-check-input login_alert setting_access" id="login_alert" name="login_alert"  type="checkbox" /></div>
                        </div>
                        
                        
                </div>
                  <div class="row">
                        <div class="col col-sm-2">
                          <label for="inputEmail3" class="">Login OTP</label>
                        </div>
                        <div class="col col-sm-1">
                           <div class="form-check form-switch"><input class="form-check-input login_otp setting_access" id="login_otp" name="login_otp"  type="checkbox" /></div>
                        </div>
                        
                       
                        <div class="col col-sm-4 login_otp_type" style="display: none;">
                           
                           <input class="form-check-input"  name="login_otp_mobile" id="login_otp_mobile"  type="checkbox" checked />
                           <label for="inputEmail3" class="">Mobile</label>
                           &nbsp;&nbsp;
                         <input class="form-check-input"  name="login_otp_email" id="login_otp_email" type="checkbox" checked />
                         <label for="inputEmail3" class="" checked>Email</label> &nbsp;&nbsp;
                         <input class="form-check-input"  name="login_otp_whatsapp" id="login_otp_whatsapp" type="checkbox" />
                         <label for="inputEmail3" class="" checked>WhatsApp</label>
                        </div>
                        
                      
                        
                        
                        
                </div>
                  <div class="row">
                        <div class="col col-sm-2">
                          <label for="inputEmail3" class="">Daily Usage</label>
                        </div>
                        <div class="col col-sm-2">
                           <div class="form-check form-switch"><input class="form-check-input daily_usage setting_access" id="daily_usage" name="daily_usage"  type="checkbox" /></div>
                        </div>
                        
                        
                </div>
             
                <hr width="100%">
                <br/>
                    <div class="row">
                   <div class="col col-sm-2">
                          <b>Security Questions</b>
                        </div>
                        <div class="col col-sm-2">
                           <div class="form-check form-switch"><input class="form-check-input security_question setting_access" id="security_question" name="security_question"  type="checkbox" checked /></div>
                        </div>
                        
                </div>
                <!-- <input type="button" class="btn btn-primary carousal_btn" style="float:right;" id="question_repeat" value="+"> -->
                <br/> <br/>
             
                <span class="repeat_section">
                  
                  <div class="row">
                      <span ><b class="card_count">#Question 1</b></span>
                          <br/>
                        <div class="col col-sm-5">
                            <select name="questions1" id="questions1" class="form-control que">
                            <option value="">Select Question 1</option>
                            <option value="1">In what city were you born?</option>
                            <option value="2">What is the name of your favourite pet?</option>
                            <option value="3">What is your mother maiden name?</option>
                            <option value="4">What highschool did you attend?</option>
                            <option value="5">What is the name of your first school?</option>
                            <option value="6">What was your favourite food as a child?</option>
                            <option value="7">Where did you meet your spouse?</option>
                           </select>
                          
                        </div>
                         <div class="col col-sm-5">
                           <input type="text" class="form-control que" name="answers1" id="answers1" placeholder="Enter Answer" maxlength="10">
                          
                        </div>
                        <div class="col col-sm-2">
                          <!--  <input type="button" class="btn btn-danger question_remove" style="float:right;" value="-" id="remove1"/> -->
                          
                        </div>
                </div>
                <br/>
                <div class="row">
                      <span ><b class="card_count">#Question 2</b></span>
                          <br/>
                        <div class="col col-sm-5">
                            <select name="questions2" id="questions2" class="form-control que">
                             <option value="">Select Question 2</option>
                            <option value="1">In what city were you born?</option>
                            <option value="2">What is the name of your favourite pet?</option>
                            <option value="3">What is your mother maiden name?</option>
                            <option value="4">What highschool did you attend?</option>
                            <option value="5">What is the name of your first school?</option>
                            <option value="6">What was your favourite food as a child?</option>
                            <option value="7">Where did you meet your spouse?</option>
                           </select>
                          
                        </div>
                         <div class="col col-sm-5">
                           <input type="text" class="form-control que" name="answers2" id="answers2" placeholder="Enter Answer" maxlength="10">
                          
                        </div>
                        <div class="col col-sm-2">
                          <!--  <input type="button" class="btn btn-danger question_remove" style="float:right;" value="-" id="remove1"/> -->
                          
                        </div>
                </div>
                <br/>
                <div class="row">
                      <span ><b class="card_count">#Question 3</b></span>
                          <br/>
                        <div class="col col-sm-5">
                            <select name="questions3" id="questions3" class="form-control que">
                             <option value="">Select Question 3</option>
                            <option value="1">In what city were you born?</option>
                            <option value="2">What is the name of your favourite pet?</option>
                            <option value="3">What is your mother maiden name?</option>
                            <option value="4">What highschool did you attend?</option>
                            <option value="5">What is the name of your first school?</option>
                            <option value="6">What was your favourite food as a child?</option>
                            <option value="7">Where did you meet your spouse?</option>
                           </select>
                          
                        </div>
                         <div class="col col-sm-5">
                           <input type="text" class="form-control que" name="answers3" id="answers3" placeholder="Enter Answer" maxlength="10">
                          
                        </div>
                        <div class="col col-sm-2">
                          <!--  <input type="button" class="btn btn-danger question_remove" style="float:right;" value="-" id="remove1"/> -->
                          
                        </div>
                </div>
                <br/>
                </span>

              
                <div class="row">
                        <div class="col col-sm-4">
                            <button type="submit" class="btn btn-primary pmd-ripple-effect" name="input-form-submit" value="Subscribe" id="save_question_btn">Save</button>
                            <button type="reset" class="btn btn-secondary">Clear</button>
                        </div>
                        <div class="col col-sm-4">
                        
                          
                        </div>
                          <div class="col col-sm-4">
                          
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


   <div class="tab-pane fade" id="pill-tab-profile" role="tabpanel" aria-labelledby="profile-tab">
    <div class="tab-pane fade show active" id="pill-tab-setting" role="tabpanel" aria-labelledby="home-tab">
     <form id="update_password_form"  name="update_password_form" method="POST">
       <input type="hidden" name="list_type" value="update_password">
         <div class="row g-3 mb-3">
            
            <div class="col-lg-12">
              <div class="card" >
                
                <div class="card-body">
                  <div id="action_message" style="display:''"><?php if(isset($_SESSION['succ']) && !empty($_SESSION['succ'])) { echo '<span class="asm1">'.$_SESSION['succ'].'</span>'; $_SESSION['succ'] = ''; } else if(isset($_SESSION['err']) && !empty($_SESSION['err'])) { echo '<span class="awm1">'.$_SESSION['err'].'</span>'; $_SESSION['err'] = '';}?></div>

                  <div class="container-fluid">
                  <span style="font-size: 13px;">*Note: The length of a password should be no more than ten characters.</span>
                <br/> <br/>
                  <div class="row">
                      <div class="col col-sm-2">
                          <label for="inputEmail3" class="">Old Password</label>
                        </div>
                       
                         <div class="col col-sm-3">
                           <input type="text" class="form-control" aria-label="old_password" aria-describedby="basic-addon1" id="old_password" name="old_password" placeholder="Old Password"  >
                        </div>

                </div>
                <br/>
                 <div class="row">
                        <div class="col col-sm-2">
                          <label for="inputEmail3" class="">New Password</label>
                        </div>
                        <div class="col col-sm-3">
                           <input type="text" class="form-control" aria-label="new_password" aria-describedby="basic-addon1" id="new_password" name="new_password" placeholder="New Password"  maxlength="10">
                        </div>
                        
                        
                </div>
                <br/>
                <div class="row">
                        <div class="col col-sm-2">
                          <label for="inputEmail3" class="">Re-Enter Password</label>
                        </div>
                        <div class="col col-sm-3">
                            <input type="text" class="form-control" aria-label="confirm_password" aria-describedby="basic-addon1" id="confirm_password" name="confirm_password" placeholder="Re-Enter Password"  maxlength="10">
                        </div>
                        
                        
                </div>
   
             
                <hr width="100%">
             
                <div class="row">
                        <div class="col col-sm-4">
                            <button type="submit" class="btn btn-primary pmd-ripple-effect" name="change_password_btn" value="Subscribe" id="change_password_btn">Update</button>
                            <button type="reset" class="btn btn-secondary">Clear</button>
                        </div>
                        <div class="col col-sm-4">
                        
                          
                        </div>
                          <div class="col col-sm-4">
                          
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


</div>


<div class="tab-pane fade" id="pill-tab-access" role="tabpanel" aria-labelledby="contact-tab">    
 <div class="tab-pane fade show active" id="pill-tab-setting" role="tabpanel" aria-labelledby="home-tab">
     <form id="update_apikey_form"  name="update_apikey_form" method="POST">
       <input type="hidden" name="list_type" value="update_api_key">


       <div class="row g-3 mb-3">
            
            <div class="col-lg-12">
              <div class="card" >
                
                <div class="card-body">


                <div class="container-fluid">
                 
                  <div class="row">
                      <div class="col col-sm-2">
                          <label for="inputEmail3" class="">API Key</label>
                        </div>
                       
                         <div class="col col-sm-3">
                           <input type="text" class="form-control" aria-label="api_key" aria-describedby="basic-addon1" id="api_key" name="api_key" placeholder="API Key" value="<?php echo $api_key; ?>" maxlength="12" readonly>
                        </div>

                        <div class="col col-sm-6">
                            <button type="button" class="btn btn-primary pmd-ripple-effect" name="api_key_btn" id="api_key_btn">Generate New</button>
                            <button type="submit" class="btn btn-primary pmd-ripple-effect" name="change_api_key_btn" id="change_api_key_btn">Update</button>
                        </div>
                       

                </div>
              </div>

                </div>
              </div>
            </div>
          </div>
     </form>
   </div>
</div>



<!-- invoice tab -->

<div class="tab-pane fade" id="pill-tab-invoice" role="tabpanel" aria-labelledby="contact-tab">    
 <div class="tab-pane fade show active" id="pill-tab-setting" role="tabpanel" aria-labelledby="home-tab">
     <form id="update_invoice_form"  name="update_invoice_form" method="POST">
       <input type="hidden" name="list_type" value="update_invoice_form">


       <div class="row g-3 mb-3">
            
            <div class="col-lg-12">
              <div class="card" >
                
                <div class="card-body">


                <div class="container-fluid">
                 
                  <div class="row">
                      <div class="col col-sm-2">
                          <label for="inputEmail3" class="">Invoice</label>
                        </div>
                       
                      

                       
                       

                </div>
              </div>

                </div>
              </div>
            </div>
          </div>
     </form>
   </div>
</div>


<!-- Sender Tab -->

</div>

                </div>



              </div>
            </div>
          </div>


          


    </div>

    <script src="assets/js/settings.js?=<?=time();?>"></script>
    <script src="assets/js/jquery.multiselect.js?=<?=time();?>"></script>