<?php 
/*session_start();*/
ob_start();
$form_name=$_SESSION['form_name'];

 ?>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Generate Access Token</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error"></div>
        <form id="accesstokenForm">
            <div class="container-fluid">
              <input type="hidden" name="type" value="create_token"  />
              <input type="hidden" name="form_name" id="form_name" value="<?php echo $form_name; ?>"  />
          <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
           
                             <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Username:</label></div>
                <div class="col-md-6">
                  <select class="form-control" id="username_senderid" name="username_senderid" data-placeholder="Select a Username..." >
                  
                  </select>
                </div>               
         
              </div>
              <br/>
                     


              <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Client ID:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="client_id"  id="client_id" value="" placeholder="Client Id" required></div>
              

              </div>
              <br/>
                 <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Client Secret:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="client_secret" id="client_secret"  placeholder="Client Secret" required></div>
              

              </div>
             
              <br/>
               <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Bot Type</label></div>
                <div class="col-md-6">
                  <select class="form-control" name="bot_type" id="bot_type" required>
                    <option value="">Select Bot Type</option>
                    <option value="Trans">Trans</option>
                    <option value="Promo">Promo</option>
                    <option value="Otp">OTP</option>
                  </select>
                </div>
              

              </div>
              <br/>
            </div>

        
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createsenderid" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="addAccessToken">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>



