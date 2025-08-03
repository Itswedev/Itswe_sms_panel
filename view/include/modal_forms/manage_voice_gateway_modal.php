
<!-- Add gateway modal start -->
<div class="modal fade" id="add_gateway_modal" name="add_gateway_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Voice Gateway Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_add_contact"></div>
        <form id="add_gateway_form" action="#" name="add_gateway_form" method="POST">
          <input type="hidden" name="add_gateway" id="add_gateway" value="add_gateway">
          <div class="row g-3 mb-3">
            <div class="col-lg-12">
              <div class="card">                
                <div class="card-body">
                   <div id="action_message" style="display:none"></div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                          <label for="inputEmail3" class="form-label">Gateway Name</label>
                          <input type="text"   class="form-control" name="smsc_id" id="smsc_id" placeholder="Gateway Name">
                        </div>
                        <div class="col-sm-9">
                          <label for="inputEmail3" class="form-label">End Point</label>
                          <input type="text"   class="form-control" name="end_point" id="end_point" placeholder="URL">
                        </div>
                       
                        
                    </div>
                    <br/>
                    
              </div>
              </div>
            </div>
          </div>
       
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createsenderid" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="save_gateway">Save</button>
      </div>
       </form>
    </div>
  </div>
</div>
<!-- Add Gateway modal end -->

<!-- Edit Gateway Modal Start -->
<div class="modal fade" id="edit_gateway_modal" name="edit_gateway_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Gateway Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_add_contact"></div>
        <form id="edit_gateway_form" action="#" name="edit_gateway_form" method="POST">
         <input type="hidden" name="list_type" value="update_gateway">
         <input type="hidden" name="gateway_id" id="gateway_id" value="">
         <input type="hidden" name="conf_file" id="conf_file" value="">
         <input type="hidden" name="log_file" id="log_file" value="">
          <div class="row g-3 mb-3">
            <div class="col-lg-12">
              <div class="card">                
                <div class="card-body">
                   <div id="action_message" style="display:none"></div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                          <label for="inputEmail3" class="form-label">Gateway Name</label>
                          <input type="text"   class="form-control" name="smsc_id" id="edit_smsc_id" placeholder="Gateway Name" readonly>
                        </div>
                        <div class="col-sm-6">
                          <label for="inputEmail3" class="form-label">End Point</label>
                          <input type="text"   class="form-control" name="end_point" id="edit_end_point" placeholder="URL">
                        </div>
                         <div class="col-sm-3">
                         <label for="inputEmail3" class="form-label">Status</label>                       
                        <select name="gateway_status" id="edit_gateway_status" class="form-control">
                          <option value="">Select Status</option>
                          <option value="1">Active</option>
                          <option value="0">Inactive</option>
                        </select>
                        </div>
                        
                        
                    </div>
                   
                    <br/>
                   
              </div>
              </div>
            </div>
          </div>
       
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createsenderid" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="edit_gateway">Save</button>
      </div>
    </form>
    </div>
  </div>
</div>
<!-- Edit Gateway Modal End -->


