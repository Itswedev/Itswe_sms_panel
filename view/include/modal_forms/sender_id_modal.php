<?php 
/*session_start();*/
ob_start();
$form_name=$_SESSION['form_name'];

 ?>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Sender ID</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error"></div>
        <form id="senderidsForm" class="needs-validation custom-input" novalidate="">
            <div class="container-fluid">
              <input type="hidden" name="type" value="saveSenderId"  />
              <input type="hidden" name="form_name" id="form_name" value="<?php echo $form_name; ?>"  />
          <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
            <?php
                    $login_user=$_SESSION['user_id'];
                    $user_role=$_SESSION['user_role'];
                    if($user_role=='mds_adm' || $user_role=='mds_rs')
                    {
                      ?>
                             <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Username:</label></div>
                <div class="col-md-6">
                  <!-- <select class="form-control" required="" id="username_senderid" name="username_senderid" data-placeholder="Select a Username..." >
                  
                  </select> -->

                  <input class="form-control some_class_name" name="username_sender" id="username_sender" placeholder="Select Username" >
                  <input type="hidden" id="username_senderid" name="username_senderid">
                </div>               
         
              </div>
              <br/>
                      <?php
                    } 
                  ?>
        


              <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Sender ID / Header Name:</label></div>
                <div class="col-md-6"><input type="text" required="" class="form-control" name="senderid" maxlength="6" id="senderid_id" value="" re></div>
              
              </div>
              <br/>
                 <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Principle Entity ID (PE_ID):</label></div>
                <div class="col-md-6"><input type="text" class="form-control" required="" name="PE_ID" id="PE_ID"  placeholder="Principle Entity Id"></div>
              
              </div>
              <br/>
               <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Header ID:</label></div>
                <div class="col-md-6"><input type="text" class="form-control"  name="Header_ID" id="Header_ID" placeholder="Header Id"></div>
              

              </div>
              <br/>
               <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Description</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="descript" id="descript"></div>
              

              </div>
              <br/>
            </div>

        
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createsenderid" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="addSenderId">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="edit_sender_id" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Sender ID</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error"></div>
        <form id="senderidsEditForm">
            <div class="container-fluid">
              <input type="hidden" name="s_id" id="s_id" >
              <input type="hidden" name="type" value="editSenderId"  />
              <input type="hidden" name="edit_sender_form" id="edit_sender_form" value="<?php echo $form_name; ?>"  />
          <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />

              <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Sender ID / Header Name:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="senderid" maxlength="6" id="edit_senderid_id"></div>
              

              </div>
              <br/>
                 <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Principle Entity ID (PE_ID):</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="PE_ID" id="edit_PE_ID"  placeholder="Principle Entity Id"></div>
              

              </div>
              <br/>
               <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Header ID:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="Header_ID" id="edit_Header_ID" placeholder="Header Id"></div>
              

              </div>
              <br/>
               <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Description</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="descript" id="edit_descript"></div>
              

              </div>
              <br/>
               <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Status</label></div>
                <div class="col-md-6"><select name="senderid_status" id="senderid_status" class="form-control">
                      <option value="">Select Status</option> 
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>                 
                </select></div>
              

              </div>
              <br/>
            </div>

        </form>
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createsenderid" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="editSenderIds();">Save</button>
      </div>
    </div>
  </div>
</div>

<!--
  Upload sender id
-->

<!-- upload bulk sender -->
<div class="modal fade" id="upload_sender_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Bulk Senderid</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error"></div>
        <form id="uploadsenderForm" method="post" enctype="multipart/form-data">
            <div class="container-fluid">
              <input type="hidden" name="type" value="upload_sender"  />
              <?php
                    $user_role=$_SESSION['user_role'];
                    if($user_role=='mds_adm')
                    {
                      ?>
                             <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Username:</label></div>
                <div class="col-md-6">
                  <!-- <select class="form-control" required="" id="username_senderid" name="username_senderid" data-placeholder="Select a Username..." >
                  
                  </select> -->

                  <input class="form-control some_class_name" name="username_senderids2" id="username_senderids2" placeholder="Select Username" >
                  <input type="hidden" id="username_senderid2" name="username_senderid2">
                </div>               
         
              </div>
              <br/>
                      <?php
                    } 
                  ?>
              
               <div class="row">

                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Browse File:</label></div>
                <div class="col-md-6"><input type="file" class="form-control" name="upload_sender" id="upload_sender" placeholder="" value="Upload Senderid"></div>
              
                <span style="margin-left:33%;">(csv and xlsx can be upload)</span>
                <span style="margin-left:33%;"><a href="downloads/senderid_upload.csv" download>Download Sample File</a></span>
              </div>
        
              <br/>
            </div>

        
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createtemplate" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="upload_sender_btn">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>