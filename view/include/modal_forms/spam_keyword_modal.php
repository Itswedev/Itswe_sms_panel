


<!--Credit modal start -->
<style type="text/css">
  .d_none
  {
    display: none;
  }
</style>
<div class="modal fade" id="addspamkeywordModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New List</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_add_contact"></div>
        <form id="addspamkeywordForm" enctype="multipart/form-data">
            <div class="container-fluid">
            
        <input type="hidden"  name="upload_type" value="single" id="upload_type">
              <!-- <div class="row ">
                  <div class="col-md-4 "></div>
                <div class="col-md-4 "><button type="button" class="btn btn-primary" id="single_btn">Single</button>&nbsp;&nbsp;&nbsp;
                <button type="button" class="btn btn-primary" id="multiple_btn">Multiple</button></div>
              <div class="col-md-4 "></div>

              </div>
              <br/>


          
               <div class="row d_none"  id="multiple_section">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Upload Multiple Keywords:</label></div>
                <div class="col-md-6"><input type="file" class="form-control" name="mobile_file" id="mobile_file" placeholder="Mobile Number" aria-label="mobile" aria-describedby="basic-addon1" ></div>
              

              </div> -->
              <br/>

              <?php
              if($_SESSION['user_role']!='mds_usr')
              {

                ?>
               <div class="row ">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Select Route:</label></div>
                <div class="col-md-6"><select class="form-control" id="route" name="route" data-placeholder="Select a Route..." >                  
                </select></div>
              </div>
              

              <?php
            }


              ?>
              <br/>
               <div class="row " id="single_section">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Keywords:</label></div>
                <div class="col-md-6"><textarea rows="5" cols="5" class="form-control" name="keyword" id="keyword" placeholder="Enter Keywords" aria-label="mobile" aria-describedby="basic-addon1" ></textarea></div>
              

              </div>
              <br/>

               <div class="row">
                  
              
              
                 <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Status:</label></div>
                <div class="col-md-6"><select name="dnd_check" id="dnd_check" class="form-control">
                      <option value="">Select Status</option> 
                      <option value="1">Enable</option>
                      <option value="0">Disable</option>                 
                </select></div>

              </div>
    
           
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

<div class="modal fade" id="editspamkeywordModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Spam Keyword Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_add_contact"></div>
      <form id="editspamkeywordForm" enctype="multipart/form-data" >
            <div class="container-fluid">
            
          <input type="hidden" name="spam_keyword_id" value="" id="spam_keyword_id">
             <input type="hidden"  name="edit_upload_type" value="single" id="edit_upload_type">
     
             <!--  <div class="row ">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Reseller:</label></div>
                <div class="col-md-6">
                  <select class="form-control" id="reseller_dropdown" name="reseller_dropdown"><option value="">Select Reseller</option></select>
                </div>
              

              </div>
              <br/> -->
               <div class="row ">
                  
               <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Select Route:</label></div>
                <div class="col-md-6"><select class="form-control" id="edit_route" name="edit_route" data-placeholder="Select a Route..." >                  
                </select></div>
              

              </div>
              <br/>
              <div class="row ">
                  
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Keywords:</label></div>
                <div class="col-md-6"><textarea rows="5" cols="5" class="form-control" name="edit_keyword" id="edit_keyword" placeholder="Enter Keywords" aria-label="mobile" aria-describedby="basic-addon1" ></textarea></div>

              </div>
            
              <br/>
               
               <div class="row ">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Status:</label></div>
                <div class="col-md-6"><select name="edit_status" id="edit_status" class="form-control">
                      <option value="">Select Status</option> 
                      <option value="1">Enable</option>
                      <option value="0">Disable</option>                 
                </select></div>
              

              </div>
      
              <br/>
            </div>

        
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createsenderid" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="update_spam_keyword_btn">Update</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- credit data upload end-->