<!-- Add Contact modal start -->

<div class="modal fade" id="add_contact" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Contact</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_add_contact"></div>
        <form id="IndContactForm">
            <div class="container-fluid">
              <input type="hidden" name="type"  value="IndContactForm"  >
          <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
              <div class="row">
                  <div class="col-md-2"></div>
                <div class="col-md-4"><label for="recipient-name" class="col-form-label">Select Group Name:</label></div>
                <div class="col-md-4"> <select id="select_group" name="select_group[]" class="form-select select_group" style="width: 86%;float: left;" >
                        
                          
                       
                          </select></div>
                <div class="col-md-3 "></div>
              

              </div>
              <br/>
              <hr>
               <input name="page" type="hidden" id="page" value="group"  />
     
               <div class="row individual_form">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Person Name:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="person_name" id="person_name" placeholder=""></div>
              

              </div>
              <div class="row individual_form">
                  <br>
              </div>
             
               <div class="row individual_form">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Contact No.:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" name="contactno" id="contactno"></div>
              

              </div>
              
              <div class="row multiple_form" style="display:none;">
                  
                <div class="col-md-2 "><label for="recipient-name" class="col-form-label">Mobile No.:</label></div>
                <div class="col-md-10"><textarea class="form-control" placeholder="Type Numbers Separeated by New Line" maxlength="1000" name="mobile_nos" id="mbl1"  style="height: 100px" ></textarea>
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
        <button type="button" class="btn btn-primary" onclick="addIndNumber();">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- Add Contact modal end -->

<!-- New Group modal start -->

<div class="modal fade" id="create_group" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create New Group</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_addgroup"></div>
        <form id="grp_crt_Form" name="create_group">
            <div class="container-fluid">
            <input type="hidden" name="creategrp" id="creategrp" value="creategrp"  >
          <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
          
               <div class="row individual_form">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Group Name:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" id="g_name" name="g_name" placeholder=""></div>
              

              </div>
              <div class="row individual_form">
                  <br>
              </div>
             
               <div class="row individual_form">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Description:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" id="descript" name="descript"></div>
              

              </div>
              
           
            </div>

        </form>
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createsenderid" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary saveGroupData" onclick="add_group()" >Save</button>
      </div>
    </div>
  </div>
</div>

<!-- New Group modal end -->


<!-- show mobile number modal start -->

<div class="modal fade" id="show_mobile_numbers" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Group Contact List</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_addgroup"></div>
       <table class="table table-hover table-primary"  id="tbl_contact_list">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Contact No.</th>
  
    </tr>
  </thead>
 
</table>
      </div>
     
    </div>
  </div>
</div>

<!-- show mobile numbers Group modal end -->

<!-- Group Import start -->

<div class="modal fade" id="group_with_contacts" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create New Group With Contacts</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error"></div>
        <form id="upload_group_form">
            <div class="container-fluid">
           
               <input type="hidden" name="mod" value="groupWithContacts"  />
          <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
             <div class="row individual_form">
              <div class="col-md-4"> 
               <label for="recipient-name" class="col-form-label">Select Group:</label>
                </div>
                <div class="col-md-4"> 
                <select id="select_group_contact" name="select_group_import[]" class="form-select select_group" style="width: 86%;float: left;" >
                          
                          
                       
                          </select>
                </div>

              </div>
            <div class="row">
              <div class="col-md-4"> 
              &nbsp;
                </div>
                <div class="col-md-4"> 
                 &nbsp;
                </div>
                <div class="col-md-4"> 
                 &nbsp;
                </div>

              </div>
               <div class="row individual_form">

                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Import Numbers:</label></div>
                <div class="col-md-6">
                <input type="file" class="form-control" name="uploadfile" id="uploadfile" placeholder="" value="Import Contact">  
              
                </div>
              
                <span style="margin-left:33%;">Only csv format files are allowed to import</span>
                <span style="margin-left:43%;"><a href="downloads/group.csv" download>Download Sample File</a></span>
               
              </div>
              
              <div class="col-md-6">
            <br/>
            <button type="button" class="btn btn-outline-primary" value="" id="importBtn_bulk1" style="width: 72%;">
              Submit
            </button>

          </div>

               
              
           
            </div>

        </form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>

<!-- Group import end -->

<!-- Edit Group modal start -->

<div class="modal fade" id="edit_group" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Group Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_addgroup"></div>
        <form id="grp_edit_form">
            <div class="container-fluid">
            <input type="hidden" name="type" id="type" value="updategrp"  >
            <input type="hidden" name="gid" id="gid" value=""  >
          <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
          
               <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Group Name:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" id="edit_g_name" name="g_name" placeholder=""></div>
              

              </div>
              <div class="row">
                  <br>
              </div>
             
               <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Description:</label></div>
                <div class="col-md-6"><input type="text" class="form-control" id="edit_descript" name="descript"></div>
              

              </div>
              
           
            </div>

       
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createsenderid" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary"  id="editGroupData">Save</button>
      </div>
       </form>
    </div>
  </div>
</div>

<!-- Edit Group modal end -->
<!-- Group data upload start -->

<div class="modal fade" id="upload_with_contacts" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Contacts</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error"></div>
        <form id="upload_group_form">
            <div class="container-fluid">
             
              
          <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
          <input type="hidden" name="single_gid" value="" id="single_gid" />
       
               <div class="row individual_form">

                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Import Numbers:</label></div>
                <div class="col-md-6"><input type="file" class="form-control" name="upload_contact" id="uploadBtn_group" placeholder="" value="Upload Contact"></div>
              
                <span style="margin-left:33%;">Only txt,xls,csv format files are   allowed to import</span>
              </div>
              
              
<div class="col-md-6">
  <br/>
  <button type="button" class="btn btn-outline-primary" value="" id="importBtn_bulk" style="width: 72%;">
    Submit
  </button>

</div>

               
              
           
            </div>

        </form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>
<!-- Group data upload end -->