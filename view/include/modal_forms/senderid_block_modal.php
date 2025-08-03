
<!-- Add sender routing modal start -->

<div class="modal fade" id="add_sender_routing_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Sender Id</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_add_contact"></div>
        <form id="sender_block_form">
            <div class="container-fluid">
                 <input type="hidden" name="type" id="type" value="add_sender_block">
                <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
             <!--  <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-3"><label for="recipient-name" class="col-form-label">Username:</label></div>
                <div class="col-md-4">
                  <select class="form-control" id="username_senderid" name="username_senderid" data-placeholder="Select a Username..." >
                  
                  </select>
                </div>               
         
              </div> -->



             
    
              <br/>
               <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-3"><label for="recipient-name" class="col-form-label">Sender ID:</label></div>
                <div class="col-md-4">
                  <input type="text" name="senderid" class="form-control">
                <!--   <select name="sender_id1" id="sender_id1" class="form-control sender_id1">
                     </select> -->
              </div>
                
         
              </div>
             
              <br/>


            </div>

        
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createsenderid" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="save_sender_id">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Add sender routing end -->