<!-- Credit modal start -->

<div class="modal fade" id="longcode_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Longcode Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_add_contact"></div>
        <form id="add_longcode_form" >
            <div class="container-fluid">
            
              <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
              
               <input name="page" type="hidden" id="page" value="credit"  />
               <input name="type" type="hidden" id="type" value="save_longcode"  />
     

                <?php
                    $login_user=$_SESSION['user_id'];
                    if($login_user==1)
                    {
                      ?>
                             <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Username:</label></div>
                <div class="col-md-7">
                  <select class="form-control" id="username_senderid" name="username_senderid" data-placeholder="Select a Username..." >
                  
                  </select>
                </div>               
         
              </div>
              <br/>
                      <?php
                    } 
                  ?>
              <div class="row ">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Longcode:</label></div>
                <div class="col-md-7">
                   <input type="text" class="form-control" name="longcode" id="longcode" placeholder="Lomgcode"  min="1"  oninput="this.value=this.value.replace(/[^0-9]/g,'');" >

                </div>
              

              </div>
               <br/>
             
                
            <div class="row">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label"></label></div>
                <div class="col-md-4"> <span class="form-check form-switch"><input class="form-check-input" id="get_reponse" name="get_reponse" value="Yes" type="checkbox"  /><label class="form-check-label" for="flexSwitchCheckChecked">Auto Response</label></span></div>
                <div class="col-md-4"> <span class="form-check form-switch"><input class="form-check-input" id="end_point_config" name="end_point_config" value="Yes" type="checkbox"  checked /><label class="form-check-label" for="flexSwitchCheckChecked">End-Point Config</label></span></div>
              

              </div>

              <br/>
               <div class="row end_point_dtls">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">Format</label></div>
                 <div class="col-md-4"> <span class="form-check form-switch"><input class="form-check-input" id="format1" name="format" value="simple" type="radio" checked="" /><label class="form-check-label" for="flexSwitchCheckChecked">Simple Parameter</label></span></div>
                <div class="col-md-4"> <span class="form-check form-switch"><input class="form-check-input" id="format2" name="format" value="json" type="radio"   /><label class="form-check-label" for="flexSwitchCheckChecked">Json</label></span></div>
              

              </div>
                <br/>

              <div class="row end_point_dtls">
                  
                <div class="col-md-4 "><label for="recipient-name" class="col-form-label">End-Point</label></div>
                <div class="col-md-7"> 
                  <textarea rows="7" cols="5" class="form-control" name="end_point" id="end_point" placeholder="End-Point" ></textarea>
                  
                </div>
              

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
        <div class="mirror_edit_ok_btn" id="createsenderid" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="save_longcode">Save</button>
      </div>
    </form>
    </div>
  </div>
</div>
