
<?php 
include_once('controller/sender_id_function.php');
$form_name=$_SESSION['form_name'];

 ?>
<div class="modal fade" id="create_multimedia_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Multimedia</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error"></div>
        <form id="addmultimediaForm">
            <div class="container-fluid">
              <input type="hidden" name="type" value="savemultimedia"  />
          <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
           <?php
                    $user_role=$_SESSION['user_role'];
                    if($user_role=='mds_adm')
                    {
                      ?>
                             <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Username:</label></div>
                <div class="col-md-6">
                  <select class="form-control" id="username_senderid" name="username_senderid" data-placeholder="Select a Username..." >
                  
                  </select>
                </div>               
         
              </div>
              <br/>
                      <?php
                    } 
                  ?>
            <!--       <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">File Name:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="file_name"  id="file_name" placeholder="Multimedia File Name"></div>
              

              </div>
              <br/>
         -->
              <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">File Upload:</label></div>
                <div class="col-md-6"><input type="file" class="form-control" name="multimedia_file"  id="multimedia_file" placeholder="Multimedia File"></div>
              

              </div>

              <br/>
            
            <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label"></label></div>
                <div class="col-md-6"> <span class="form-check form-switch"><input class="form-check-input" id="get_response" name="get_response" value="No" type="checkbox"  /><label class="form-check-label" for="flexSwitchCheckChecked">Auto Response</label></div>
              

              </div>

              <br/>
            
              <div class="row response">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Sender ID</label></div>
                <div class="col-md-6"> 

                  <select  class="form-select " name="sid" id="sid" aria-label="sid" aria-describedby="basic-addon1" >
                          <option value="">Sender Id</option>
                          
                        </select></div>
              

              </div>
                <br/>
               <div class="row response">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Template ID</label></div>
                <div class="col-md-6"> 

                  <select id="template" class="form-select " name="template" style="" aria-label="template" aria-describedby="basic-addon1">
                            <option value="">Select Template</option>
                          
                      </select> 
                </div>
              

              </div>

               <br/>
               <div class="row response">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Route</label></div>
                <div class="col-md-6"> 

                  <select id="route_id" class="form-select " name="route_id" style="" aria-label="route_id" aria-describedby="basic-addon1">
                            <option value="">Select Route</option>
                          
                      </select> 
                </div>
              

              </div>

             

            </div>

        
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createtemplate" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="save_multimedia_btn">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>




<div class="modal fade" id="edit_multimedia_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Multimedia Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error"></div>
        <form id="updatemultimediaForm">
            <div class="container-fluid">
              <input type="hidden" name="type" value="updateMultimedia"  />
          <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
          <input type="hidden" name="file_id" id="file_id" value=""  />
              <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">File Name:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="edit_file_name"  id="edit_file_name" placeholder="File Name" readonly></div>
              

              </div>
              <br/>


               <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Upload File:</label></div>
                <div class="col-md-6"><input type="file" class="form-control" name="edit_file_name" id="edit_file_name" placeholder="" value="Upload Voice File"></div>
              
                <span style="margin-left:33%;">Only mp3 format files are  allowed to import</span>
              

              </div>
              <br/>
      
             
            </div>

        
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createtemplate" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="update_multimedia">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>



<!-- Edit Caller ID Form -->

<div class="modal fade" id="edit_caller_id_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Caller ID Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error"></div>
        <form id="updatecalleridForm">
            <div class="container-fluid">
              <input type="hidden" name="type" value="updateCallerID"  />
          <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
          <input type="hidden" name="caller_dtl_id" id="caller_dtl_id" value=""  />
              <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Caller ID:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="edit_caller_id"  id="edit_caller_id" placeholder="Caller ID"></div>
              

              </div>

              <?php 
              if($_SESSION['user_role']!='mds_usr')
              {


              ?>
              <br/>

              
                 <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Status:</label></div>
                <div class="col-md-6"><select class="form-control" name="edit_callerid_status" id="edit_callerid_status"> <option value="">Select Status</option>
                <option value="0">Deactive</option>
              <option value="1">Active</option></select></div>
              

              </div>

            <?php }

            ?>
              <br/>



             
            </div>

        
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createtemplate" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="update_caller_id">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>




<!-- Admin edit form -->
<div class="modal fade" id="edit_admin_multimedia_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Multimedia Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error"></div>
        <form id="updateadminmultimediaForm">
            <div class="container-fluid">
              <input type="hidden" name="type" value="updateadminMultimedia"  />
          <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
          <input type="hidden" name="admin_file_id" id="admin_file_id" value=""  />
              <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">File Name:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="admin_edit_file_name"  id="admin_edit_file_name" placeholder="File Name" readonly></div>
              

              </div>
              <br/>


               <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Upload File:</label></div>
                <div class="col-md-6"><input type="file" class="form-control" name="admin_edit_file" id="admin_edit_file" placeholder="" value="Upload Voice File"></div>
              
                <span style="margin-left:33%;">Only mp3 format files are  allowed to import</span>
              

              </div>
           

              <!--  <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Source Type:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="admin_edit_source_type"  id="admin_edit_source_type" placeholder="Source Type"></div>
              

              </div>
              <br/>

              <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Campaign Type:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="admin_edit_campaign_type"  id="admin_edit_campaign_type" placeholder="Campaign Type"></div>
              

              </div>
              <br/>

              <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">File Type:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="admin_edit_file_type"  id="admin_edit_file_type" placeholder="File Type"></div>
              

              </div>
              <br/>
              <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">UKEY:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="admin_edit_ukey"  id="admin_edit_ukey" placeholder="UKEY"></div>
              

              </div>
              <br/>
              <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Service No.:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="admin_edit_service_no"  id="admin_edit_service_no" placeholder="Service No."></div>
              

              </div>
              <br/>
 
              <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">IVR Template ID:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="admin_edit_ivrtemplateid"  id="admin_edit_ivrtemplateid" placeholder="IVR Template ID"></div>
              

              </div>
              <br/>


               <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Retry Attempt:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="admin_edit_retryattempt"  id="admin_edit_retryattempt" placeholder="Retry Attempt" value="0"></div>
              

              </div>
              <br/>



                 <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Retry Duration:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="admin_edit_retryduration"  id="admin_edit_retryduration" placeholder="Retry duration" value="0"></div>
              

              </div>
              <br/>-->
 <?php 
              if($_SESSION['user_role']!='mds_usr')
              {


              ?>
               <br/>
             <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Status:</label></div>
                <div class="col-md-6"><select class="form-control" name="admin_edit_status" id="admin_edit_status"> <option value="">Select Status</option>
                <option value="0">Deactive</option>
              <option value="1">Active</option></select></div>
              

              </div>
             

             <br/>
             <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Voice ID:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="admin_edit_voice_id"  id="admin_edit_voice_id" value="0"></div>
              

              </div>
             
             <br/>
              <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">IVR ID:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="admin_edit_ivr_id"  id="admin_edit_ivr_id" value="0"></div>
              

              </div>
             


            <?php }

            ?>


                


             <br/>
      
             
            </div>

        
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createtemplate" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="admin_update_multimedia">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>



<!-- Caller ID Modal -->


<div class="modal fade" id="create_callerid_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Caller ID</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error"></div>
        <form id="addcalleridForm">
            <div class="container-fluid">
              <input type="hidden" name="type" value="savecallerid"  />
          <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
           <?php
                    $login_user=$_SESSION['user_id'];
                    if($login_user==1)
                    {
                      ?>
                             <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Username:</label></div>
                <div class="col-md-6">
                  <select class="form-control" id="callerid_username_senderid" name="callerid_username_senderid" data-placeholder="Select a Username..." >
                  
                  </select>
                </div>               
         
              </div>
              <br/>
                      <?php
                    } 
                  ?>
            <!--       <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">File Name:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="file_name"  id="file_name" placeholder="Multimedia File Name"></div>
              

              </div>
              <br/>
         -->
              <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Caller ID:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="caller_id"  id="caller_id" placeholder="Enter Caller ID"></div>
              

              </div>
              <br/>
           
            </div>

        
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createtemplate" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="save_caller_id_btn">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>



