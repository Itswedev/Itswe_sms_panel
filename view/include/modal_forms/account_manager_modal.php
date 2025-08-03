<!--Credit modal start -->

<!--  <div class="modal fade" id="add_acct_manager_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Account Manager</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_add_contact"></div>
          <form id="add_acct_form"  name="add_user_form" method="POST">
                  <input type="hidden" name="list_type" value="save_acct_manager">
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
                </div>
                <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Full Name</label>
                        </div>
                        <div class="pmd-textfield col col-sm-3" >
                    <input type="text" class="form-control" aria-label="f_name" aria-describedby="basic-addon1" id="f_name" name="f_name">
                </div>
                
                 <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Email</label>
                        </div>
                        <div class="pmd-textfield col col-sm-3" >
                    <input type="email" class="form-control" aria-label="email" aria-describedby="basic-addon1" id="email" name="email">
                </div>
                    
            </div>
          
            <div class="form-group">
                <button type="submit" class="btn btn-primary pmd-ripple-effect" name="input-form-submit" value="Subscribe" id="save_acct_manager_btn">Save</button>
                <button type="reset" class="btn btn-secondary pmd-ripple-effect" name="input-form-submit" value="Clear" id="clear">Clear</button>
            </div>

                    
                  </div>
                   </form>
                    </div>
  </div>
</div> --> 

<!-- credit data upload end -->

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="add_acct_manager_modal">
  <div class="modal-dialog modal-xl">
       <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Account Manager</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_add_contact"></div>
          <form id="add_acct_form"  name="add_user_form" method="POST">
                  <input type="hidden" name="list_type" value="save_acct_manager">
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
                </div>
                <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Full Name</label>
                        </div>
                        <div class="pmd-textfield col col-sm-3" >
                    <input type="text" class="form-control" aria-label="f_name" aria-describedby="basic-addon1" id="f_name" name="f_name">
                </div>
                
                 <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Email</label>
                        </div>
                        <div class="pmd-textfield col col-sm-3" >
                    <input type="email" class="form-control" aria-label="email" aria-describedby="basic-addon1" id="email" name="email">
                </div>

                    
            </div>
          
            <div class="form-group">
                <button type="submit" class="btn btn-primary pmd-ripple-effect" name="input-form-submit" value="Subscribe" id="save_acct_manager_btn">Save</button>
                <button type="reset" class="btn btn-secondary pmd-ripple-effect" name="input-form-submit" value="Clear" id="clear">Clear</button>
            </div>

                    
                  </div>
                   </form>
                    </div>
  </div>
  </div>
</div>

<!-- Edit Brand modal start -->

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="editacctmanagerModel">
  <div class="modal-dialog modal-xl">
       <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Account Manager Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_add_contact"></div>
          <form id="edit_acct_form"  name="edit_user_form" method="POST">
                  <input type="hidden" name="list_type" value="update_acct_manager">
                  <input type="hidden" id="acct_manager_id" name="acct_manager_id" value="">
                  <div id="action_message" style="display:''"><?php if(isset($_SESSION['succ']) && !empty($_SESSION['succ'])) { echo '<span class="asm1">'.$_SESSION['succ'].'</span>'; $_SESSION['succ'] = ''; } else if(isset($_SESSION['err']) && !empty($_SESSION['err'])) { echo '<span class="awm1">'.$_SESSION['err'].'</span>'; $_SESSION['err'] = '';}?></div>

                  <div class="container-fluid">
                  
                
                     <div class="input-group pmd-input-group mb-3 row">
                      <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Username</label>
                        </div>
                        <div class="pmd-textfield col col-sm-3" >
                    <input type="text" class="form-control" aria-label="username" aria-describedby="basic-addon1" id="edit_username" name="edit_username">
                </div>
             <!--    <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Password</label>
                        </div>
                        <div class="pmd-textfield col col-sm-3" >
                    <input type="text" class="form-control" aria-label="password" aria-describedby="basic-addon1" id="edit_password" name="edit_password" value="<?php echo $new_password; ?>">
                </div> -->
                <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Mobile No.</label>
                        </div>
                        <div class="pmd-textfield col col-sm-3" >
                    <input type="text" class="form-control" aria-label="mobile" aria-describedby="basic-addon1" id="edit_mobile" name="edit_mobile">
                </div>
                <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Full Name</label>
                        </div>
                        <div class="pmd-textfield col col-sm-3" >
                    <input type="text" class="form-control" aria-label="f_name" aria-describedby="basic-addon1" id="edit_f_name" name="edit_f_name">
                </div>
                
                 <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Email</label>
                        </div>
                        <div class="pmd-textfield col col-sm-3" >
                    <input type="email" class="form-control" aria-label="email" aria-describedby="basic-addon1" id="edit_email" name="edit_email">
                </div>
                  <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Status</label>
                        </div>
                        <div class="pmd-textfield col col-sm-3" >
                    <select  class="form-control" id="edit_status" name="edit_status">
                      <option value="">Select Status</option>
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>
                    </select>
                </div>
                    
            </div>
          
            <div class="form-group">
                <button type="submit" class="btn btn-primary pmd-ripple-effect" name="input-form-submit" value="Subscribe" id="update_acct_manager_btn">Update</button>
                <button type="reset" class="btn btn-secondary pmd-ripple-effect" name="input-form-submit" value="Clear" id="clear">Clear</button>
            </div>

                    
                  </div>
                   </form>
                    </div>
  </div>
  </div>
</div>

<!-- credit data upload end-->