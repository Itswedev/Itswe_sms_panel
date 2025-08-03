
<div class="modal fade" id="repush_job_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Repush Campaign: - <span id="job_id"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_add_contact"></div>
        <form id="repush_job_form">
            <div class="container-fluid">
                <input type="hidden" name="type"  value="repush_job"  >
                <input type="hidden" id="repush_job_id" name="repush_job_id">
                <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
                
              <div class="row">
                
          
              

                <div class="col-md-2 "><label for="recipient-name" class="col-form-label">Gateway:</label></div>
                <div class="col-md-4"><select name="gateway_id" id="gateway_id" class="form-control">
                      <option value="">Select Gateway</option> 
                                  
                </select></div>


                <div class="col-md-2 "><label for="recipient-name" class="col-form-label">Status:</label></div>
                <div class="col-md-4"><select name="status" id="status" class="form-control">
                     
                                
                </select></div>


              </div>
             
      <br/>
               <!-- <div class="row">
                <div class="col-md-2 "><label for="recipient-name" class="col-form-label">Gateway:</label></div>
                <div class="col-md-4"><select name="dnd_check" id="dnd_check" class="form-control">
                      <option value="">Select Gateway</option> 
                                  
                </select></div>

              </div>
              
              <br/>
               -->
             
              <br/>
            </div>

       
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createsenderid" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="push_job_btn">Click To Repush Campaign</button>
      </div>
       </form>
    </div>
  </div>
</div>