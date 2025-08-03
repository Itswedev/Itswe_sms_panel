
<?php 
include_once('controller/sender_id_function.php');
$form_name=$_SESSION['form_name'];

 ?>
<div class="modal fade" id="create_template_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Template</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error"></div>
        <form id="addtemplateForm">
            <div class="container-fluid">
              <input type="hidden" name="type" value="saveTemplate"  />
          <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
           <?php
                   // $login_user=$_SESSION['user_id'];
                    if($login_user==1)
                    {
                      ?>
                             <!-- <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Username:</label></div>
                <div class="col-md-6">
                  <select class="form-control" id="username_senderid" name="username_senderid" data-placeholder="Select a Username..." >
                  
                  </select>
                </div>               
         
              </div>
              <br/> -->
                      <?php
                    } 
                  ?> 

<?php
                    
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
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Template Name:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="template_name"  id="template_name" placeholder="Template Name"></div>
              

              </div>
              <br/>
                 <!-- <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Principle Entity ID (PE_ID):</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="PE_ID" id="PE_ID"  placeholder="Principle Entity Id"></div>
              

              </div>
              <br/> -->
               <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Template ID:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="Template_ID" id="Template_ID" placeholder="Template ID"></div>
              

              </div>
              <br/>
               <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Content Type</label></div>
                <div class="col-md-6"><select id="inputState" class="form-select " name="content_type" style="" id="content_type">
                        <option value="">Select Content Type</option>
                            <option value="T">Transactional</option>
                            <option value="P">Promotional</option>
                            <option value="SE">Service Explicit</option>
                            <option value="SI">Service Implicit</option>
      
                      </select></div>
              

              </div>
              <br/>
              <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Category Type</label></div>
                <div class="col-md-6"><select id="category_type" class="form-select " name="category_type" style="">
                        <option value="">Select Category</option>
                            <option value="1">Banking/Insurance/Financial products/ credit cards </option>
                            <option value="2">Real Estate</option>
                            <option value="3">Education</option>
                            <option value="4">Health</option>
                            <option value="5">Consumer goods and automobiles</option>
                            <option value="6">Communication/Broadcasting/Entertainment/IT</option>
                            <option value="7">Tourism and Leisure</option>
                            <option value="8">Food and Beverages</option>
                            <option value="0">Others</option>
                      
                      </select></div>
              

              </div>
              <br/>
                 <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Sender ID</label></div>
                <div class="col-md-6">
                
                  <input class="form-control some_class_name" name="senderids" id="senderids" placeholder="Select SenderID" >
                  <input type="hidden" id="sender_id" name="sender_id">
                  <!-- <select id="sender_id" class="form-select " name="sender_id[]" multiple>      
                  </select> -->
                    
                </div>
              

              </div>
              <br/>
                  <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Character Type</label></div>
                <div class="col-md-6">

                   <select id="character_type" class="form-select " name="character_type" >
                       
                          <option value="">Select Character Type</option>
                          <option value="Text">Text</option>
                          <option value="Unicode">Unicode</option>
                      </select>
                </div>
              </div>
              <br/>
               <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Template Data</label></div>
                <div class="col-md-6">
                     <input type="button" value="+ Add Variable" class="btn btn-primary add-variable" >
                
                              <br/>
                              <br/>
                      
                              <textarea class="form-control" placeholder="Type Message Here" name="template_data" id="add_mbl1"  style="height: 80%;" aria-label="message" aria-describedby="basic-addon1" required></textarea>
                              
                           


                    </div>
              

              </div>
              <br/>
            </div>

        
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createtemplate" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="save_template">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>




<div class="modal fade" id="edit_template_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Template</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error"></div>
        <form id="updatetemplateForm">
            <div class="container-fluid">
              <input type="hidden" name="type" value="updateTemplate"  />
          <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
          <input type="hidden" name="tempid" id="tempid" value=""  />
          <?php
                    
                    $user_role=$_SESSION['user_role'];
                    if($user_role=='mds_adm' )
                    {
                      ?>
              <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Username:</label></div>
                  <div class="col-md-6">
                    <!-- <select class="form-control" required="" id="username_senderid" name="username_senderid" data-placeholder="Select a Username..." >
                    
                    </select> -->

                    <input class="form-control some_class_name" name="edit_username_sender" id="edit_username_sender" placeholder="Select Username" >
                    <input type="hidden" id="edit_username_senderid" name="edit_username_senderid">
                  </div>               
          
              </div>
              <br/>
                      <?php
                    } 
                  ?>
              <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Template Name:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="template_name"  id="edit_template_name" placeholder="Template Name"></div>
              

              </div>
              <br/>
               <!--   <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Principle Entity ID (PE_ID):</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="PE_ID" id="edit_PE_ID"  placeholder="Principle Entity Id"></div>
              

              </div>
              <br/> -->
               <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Template ID:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="Template_ID" id="edit_Template_ID" placeholder="Template ID"></div>
              

              </div>
              <br/>
               <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Content Type</label></div>
                <div class="col-md-6"><select  class="form-select " name="content_type" style="" id="edit_content_type">
                        <option value="">Select Content Type</option>
                            <option value="T">Transactional</option>
                            <option value="P">Promotional</option>
                            <option value="SE">Service Explicit</option>
                            <option value="SI">Service Implicit</option>
      
                      </select></div>
              

              </div>
              <br/>
              <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Category Type</label></div>
                <div class="col-md-6"><select id="edit_category_type" class="form-select " name="category_type" style="">
                        <option value="">Select Category</option>
                            <option value="1">Banking/Insurance/Financial products/ credit cards </option>
                            <option value="2">Real Estate</option>
                            <option value="3">Education</option>
                            <option value="4">Health</option>
                            <option value="5">Consumer goods and automobiles</option>
                            <option value="6">Communication/Broadcasting/Entertainment/IT</option>
                            <option value="7">Tourism and Leisure</option>
                            <option value="8">Food and Beverages</option>
                            <option value="0">Others</option>
                      
                      </select></div>
              

              </div>
              <br/>
                 <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Sender ID</label></div>
                <div class="col-md-6">
                  <!-- <select id="edit_sender_id" class="form-select " name="sender_id[]" multiple>
                       
                          <?php //echo sender_id_dropdown_without_name(); ?>    

                          
                      </select> -->
                      <input id="edit_sender_id" class="form-control" name="edit_sender_id" value=""/>

                      <!-- Hidden input field to store the selected values -->
                      <input type="hidden" id="edit_sender_id_hidden" name="edit_sender_id_hidden" value=""/>

                    
                    </div>
              

              </div>
              <br/>
               <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Template Data</label></div>
                <div class="col-md-6">
                     <input type="button" value="+ Add Variable" class="btn btn-primary add-variable" >
                     <br/><br/>
                
                              
                      
                              <textarea class="form-control" placeholder="Type text here" id="edit_mbl1" name="template_data" style="height: 100px" ></textarea>
                            
                        


                    </div>
              

              </div>
              <br/>
            </div>

        
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createtemplate" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="update_template">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>


<!-- upload bulk template -->
<div class="modal fade" id="upload_template_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Bulk Template</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error"></div>
        <form id="uploadtemplateForm" method="post" enctype="multipart/form-data">
            <div class="container-fluid">
              <input type="hidden" name="type" value="saveTemplate"  />
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
                <div class="col-md-6"><input type="file" class="form-control" name="upload_template" id="upload_template" placeholder="" value="Upload Template"></div>
              
                <span style="margin-left:33%;">(csv and xlsx can be upload)</span>
                <span style="margin-left:33%;"><a href="downloads/template_upload.csv" download>Download Sample File</a></span>
              </div>
        
              <br/>
            </div>

        
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createtemplate" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="upload_template_btn">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>