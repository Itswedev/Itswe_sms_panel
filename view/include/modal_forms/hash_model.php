<!-- Add plan modal start -->
<div class="modal fade" id="add_plan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Hash</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_add_contact"></div>
        <form id="create_hash_form">
            <div class="container-fluid">
                 <input type="hidden" name="createhash" id="type" value="createhash">
                <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
              <div class="row">
                
                <div class="col-md-2"><label for="recipient-name" class="col-form-label">Username:</label></div>
                <div class="col-md-4"> 
                    <input class="form-control some_class_name" name="usernames" id="usernames" placeholder="Select Username">
                <input type="hidden" id="username" name="username"></div>

            
              </div>
              <br/>
              <div class="row">
                
             
                <div class="col-md-2"><label for="recipient-name" class="col-form-label">Hash Value:</label></div>
                <div class="col-md-6">
                <input type="text" required="required"  class="form-control" name="hash_value" id="hash_value" placeholder="Hash Value">
              </div>
            
              </div>
             
    
              <br/>
              
             
              <br/>
            </div>

        </form>
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createsenderid" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save_hash">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- Add plan modal end -->

<!-- plan details edit modal start -->
<div class="modal fade" id="edit_plan" name="edit_plan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Plan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_add_contact"></div>
        <form id="edit_plan_form">
            <div class="container-fluid">
                 <input type="hidden" name="list_type" id="list_type" value="editplan">
                  <input type="hidden" name="pid" id="pid" value="">
                <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
              <div class="row">
                
                <div class="col-md-2"><label for="recipient-name" class="col-form-label">Plan Name:</label></div>
                <div class="col-md-4"><input type="text" required="required"  class="form-control" name="p_name" id="edit_p_name" placeholder="Plan Name"></div>

                <div class="col-md-2"><label for="recipient-name" class="col-form-label">Status:</label></div>
                <div class="col-md-4">
                  <select name="plan_status" id="edit_plan_status" class="form-control">
                     <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                </select>
              </div>
                
         
              </div>
             
    
              <br/>
              
             
              <br/>
            </div>

        </form>
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createsenderid" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="edit_plan_btn">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- plan details edit modal end -->