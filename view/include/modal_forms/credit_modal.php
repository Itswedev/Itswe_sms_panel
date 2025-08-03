<!-- Credit modal start -->

<div class="modal fade" id="credit_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add / Remove Credit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_add_contact"></div>
        <form id="add_credit_form">
            <div class="container-fluid">
            
          <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
              
               <input name="page" type="hidden" id="page" value="credit"  />
               <input name="type" type="hidden" id="type" value="save_credit"  />
     
               <div class="row ">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Username:</label></div>
                <div class="col-md-6">
                <!-- <select class="form-control" id="username" name="username" data-placeholder="Select a Username..." >
                  
                </select>-->
                <input class="form-control some_class_name" name="usernames" id="usernames" placeholder="Select Username">
                <input type="hidden" id="username" name="username">
              
              </div> 
                

              </div>
              <br/>
              <div class="row ">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Route Type:</label></div>
                <div class="col-md-6">
                  <select class="form-control" id="route" name="route">
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

        </form>
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createsenderid" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save_credit">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- credit data upload end -->