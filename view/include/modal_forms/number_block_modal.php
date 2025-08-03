<!--Credit modal start -->
<style type="text/css">
  .d_none
  {
    display: none;
  }
</style>
<div class="modal fade" id="addblocknumberModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New List</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_add_contact"></div>
        <form id="addblocknumberForm" enctype="multipart/form-data">
            <div class="container-fluid">
            
        <input type="hidden"  name="upload_type" value="single" id="upload_type">
              <div class="row ">
                  <div class="col-md-4 "></div>
                <div class="col-md-4 "><button type="button" class="btn btn-primary" id="single_btn">Single</button>&nbsp;&nbsp;&nbsp;
                <button type="button" class="btn btn-primary" id="multiple_btn">Multiple</button></div>
              <div class="col-md-4 "></div>

              </div>
              <br/>


          
               <div class="row d_none"  id="multiple_section">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Upload Multiple Numbers:</label></div>
                <div class="col-md-6"><input type="file" class="form-control" name="mobile_file" id="mobile_file" placeholder="Mobile Number" aria-label="mobile" aria-describedby="basic-addon1" ></div>
              

              </div>
              <?php
              if($_SESSION['user_role']!='mds_usr')
              {

                ?>
               <div class="row ">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Username:</label></div>
                <div class="col-md-6"><select class="form-control" id="username" name="username" data-placeholder="Select a Username..." >                  
                </select></div>
              </div>
              <br/>

              <?php
            }


              ?>

               <div class="row " id="single_section">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Mobile Number:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile Number" aria-label="mobile" aria-describedby="basic-addon1" ></div>
              

              </div>
              <br/>
              <div class="row ">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Status:</label></div>
                <div class="col-md-6">
                    <select class="form-control" name="status" id="status">
                      <option value="">Select Status</option>
                      <option value="0">Block</option>
                      <?php 
                     if($_SESSION['user_role']=='mds_ad' || $_SESSION['user_role']=='mds_adm' || $_SESSION['user_role']=='mds_su_ad')
                        {
                          ?>
                          <option value="1">Whitelist</option>
                          <?php
                        }

                      ?>
                      
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
        <button type="submit" class="btn btn-primary" id="save_btn">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- credit data upload end -->



<!-- Edit Brand modal start -->

<div class="modal fade" id="editbrandingModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Branding Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_add_contact"></div>
      <form id="editbrandingForm" enctype="multipart/form-data" >
            <div class="container-fluid">
            
          <input type="hidden" name="brand_id" value="" id="brand_id">
            
     
             <!--  <div class="row ">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Reseller:</label></div>
                <div class="col-md-6">
                  <select class="form-control" id="reseller_dropdown" name="reseller_dropdown"><option value="">Select Reseller</option></select>
                </div>
              

              </div>
              <br/> -->
               <div class="row ">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Company Name:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="company_name" id="company_name_edit" placeholder="Company Name" aria-label="company_name" aria-describedby="basic-addon1" ></div>
              

              </div>
              <br/>
              <div class="row ">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Company Tagline:</label></div>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="tag_line" id="tag_line_edit" placeholder="Write some tagline" aria-label="tag_line" aria-describedby="basic-addon1">

                </div>
              

              </div>
            
              <br/>
               
               <div class="row ">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Website Address:</label></div>
                <div class="col-md-6">
                 
                 <input type="text" class="form-control" name="web_url" id="web_url_edit" placeholder="Website Address" aria-label="web_url" aria-describedby="basic-addon1" >
                </div>
              

              </div>
              <br/>
               <div class="row ">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Company Logo:</label></div>
                <div class="col-md-6">
                   <input type="file" class="form-control " name="uploadfile" id="uploadfile_edit" title="Please select .png, .jpg, .jpeg file typeonly" />

                </div>
              

              </div>
               <br/>
             
             
               <div class="row ">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Support URL:</label></div>
                <div class="col-md-6">
                            <input type="text" class="form-control" name="support_url" id="support_url_edit" placeholder="Support URL" aria-label="support_url" aria-describedby="basic-addon1" >
                              
                           
                </div>
              

              </div>
                <br/>

                <div class="row ">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Support Mobile:</label></div>
                <div class="col-md-6">
                            <input type="text" class="form-control" name="support_mobile" id="support_mobile_edit" placeholder="Support Mobile" aria-label="support_mobile" aria-describedby="basic-addon1">
                       
                              
                           
                </div>
              

              </div>
               <br/>
                 <div class="row ">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Support Email:</label></div>
                <div class="col-md-6">
                            <input type="text" class="form-control" name="support_email" id="support_email_edit" placeholder="Support Email" aria-label="support_email" aria-describedby="basic-addon1" >
                       
                              
                           
                </div>
              

              </div>
               <br/>
                 <div class="row ">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Login Page Description:</label></div>
                <div class="col-md-6">
                            <textarea class="form-control" placeholder="Type Login Page Description" id="login_desc_edit" name="login_desc" style="height: 113%;;" aria-label="login_desc" aria-describedby="basic-addon1" ></textarea>
                       
                              
                           
                </div>
              

              </div>
              
         
              <br/>
            </div>

        
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createsenderid" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="edit_brand_btn">Update</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- credit data upload end-->