<!-- Add Route modal start -->

<div class="modal fade" id="add_route" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Route</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_add_contact"></div>
        <form id="addRouteForm">
            <div class="container-fluid">
                <input type="hidden" name="type"  value="addRoute"  >
                <input name="page" type="hidden" id="page" value="manage_route"  />
                <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
                
              <div class="row">
                
                <div class="col-md-2"><label for="recipient-name" class="col-form-label">Route Name:</label></div>
                <div class="col-md-4"><input type="text"   class="form-control" name="route_name" id="route_name" placeholder=""></div>
                
               <div class="col-md-2 "><label for="recipient-name" class="col-form-label">Status:</label></div>
                <div class="col-md-4"><select name="status" id="status" class="form-control">
                      <option value="">Select Status</option> 
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>                 
                </select></div>

              </div>
             
      <br/>
              <div class="row">
                  
                <div class="col-md-2 "><label for="recipient-name" class="col-form-label">Start Time:</label></div>
                <div class="col-md-4"><input class="form-control datetimepicker" id="start_time" type="text" placeholder="H:m"  name="start_time"/></div>
              
                 <div class="col-md-2 "><label for="recipient-name" class="col-form-label">End Time:</label></div>
                <div class="col-md-4"><input class="form-control datetimepicker" id="end_time" type="text" placeholder="H:m"  name="end_time"/></div>
              </div>
            
              <br/>
             
               <div class="row">
                  
                <div class="col-md-2"><label for="recipient-name" class="col-form-label">Rate:</label></div>
                <div class="col-md-4"><input type="text"   class="form-control" name="rate" id="rate"></div>
              
                 <div class="col-md-2 "><label for="recipient-name" class="col-form-label">Sender ID:</label></div>
                <div class="col-md-4"><select name="sender_id" id="sender_id" class="form-control">
                      <option value="">Select Sender Option</option> 
                      <option value="1">Yes</option>
                      <option value="0">No</option>                 
                </select></div>

              </div>
              
              <br/>

               <div class="row">
                  
              
              
                 <div class="col-md-2 "><label for="recipient-name" class="col-form-label">DND Check:</label></div>
                <div class="col-md-4"><select name="dnd_check" id="dnd_check" class="form-control">
                      <option value="">Select DND Option</option> 
                      <option value="1">Enable</option>
                      <option value="0">Disable</option>                 
                </select></div>

              </div>
              
              <br/>
              
             
              <br/>
            </div>

       
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createsenderid" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="save_route">Save</button>
      </div>
       </form>
    </div>
  </div>
</div>
<!-- Add route modal end -->

<!-- Edit Route modal start -->

<div class="modal fade" id="edit_route_modal" name="edit_route_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Route</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_add_contact"></div>
        <form id="editRouteForm">
            <div class="container-fluid">
                <input type="hidden" name="type" value="editRoute">
                 <input type="hidden" name="route_id" id="edit_route_id"  value="">
                <input name="page" type="hidden" id="page" value="manage_route"  />
                <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
              <div class="row">
                
                <div class="col-md-2"><label for="recipient-name" class="col-form-label">Route Name:</label></div>
                <div class="col-md-4"><input type="text"   class="form-control" name="route_name" id="edit_route_name" placeholder=""></div>
                
               <div class="col-md-2 "><label for="recipient-name" class="col-form-label">Status:</label></div>
                <div class="col-md-4"><select name="status" id="edit_status" class="form-control">
                      <option value="">Select Status</option> 
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>                 
                </select></div>

              </div>
             
      <br/>
              <div class="row">
                  
                <div class="col-md-2 "><label for="recipient-name" class="col-form-label">Start Time:</label></div>
                <div class="col-md-4"><input class="form-control datetimepicker" id="edit_start_time" type="text" placeholder="H:m" data-options='{"disableMobile":true,"enableTime":true,"noCalendar":true,"dateFormat":"H:i","time_24hr": "true"}' name="start_time"/></div>
              
                 <div class="col-md-2 "><label for="recipient-name" class="col-form-label">End Time:</label></div>
                <div class="col-md-4"><input class="form-control datetimepicker" id="edit_end_time" type="text" placeholder="H:m" data-options='{"disableMobile":true,"enableTime":true,"noCalendar":true,"dateFormat":"H:i","time_24hr": "true"}' name="end_time"/></div>
              </div>
            
              <br/>
             
               <div class="row">
                  
                <div class="col-md-2"><label for="recipient-name" class="col-form-label">Rate:</label></div>
                <div class="col-md-4"><input type="text"   class="form-control" name="rate" id="edit_rate"></div>
              
                 <div class="col-md-2 "><label for="recipient-name" class="col-form-label">Sender ID:</label></div>
                <div class="col-md-4"><select name="sender_id" id="edit_sender_id" class="form-control">
                      <option value="">Select Sender Option</option> 
                      <option value="1">Yes</option>
                      <option value="0">No</option>                 
                </select></div>

              </div>
              
              <br/>

              <div class="row">

                <div class="col-md-2 "><label for="recipient-name" class="col-form-label">DND Check:</label></div>
                <div class="col-md-4"><select name="dnd_check" id="edit_dnd_check" class="form-control">
                      <option value="">Select DND Option</option> 
                      <option value="1">Enable</option>
                      <option value="0">Disable</option>                 
                </select></div>

              </div>
              
              <br/>
              
             
              <br/>
            </div>

       
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createsenderid" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="edit_route">Save</button>
      </div>
     </form>
    </div>
  </div>
</div>
<!-- Edit route modal end -->

<!-- Create New Route Plan modal start -->

<div class="modal fade" id="create_route_plan_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Routing Plan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_add_contact"></div>
        <form id="addRouteplanForm">
            <div class="container-fluid">
                <input type="hidden" name="type"  value="create_routing_plan"  >
                <input name="page" type="hidden" id="page" value="route_plan"  />
                <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
              <div class="row">
                
                <div class="col-md-2"><label for="recipient-name" class="col-form-label">Plan Name:</label></div>
                <div class="col-md-6">
                  <select name="plan_name" id="plan_name" class="form-control">
                      
                                
                </select></div>


             

              </div>
             
      <br/>
              <div class="row">
                
                <div class="col-md-2"><label for="recipient-name" class="col-form-label">Route:</label></div>
                <div class="col-md-6">
                  <select name="route_dropdown" id="route_dropdown" class="form-control">
                      
                                
                </select></div>
             

              </div>
            
              <br/>
             
              
              <div class="row">
                
              <div class="col-md-2"><label for="recipient-name" class="col-form-label">Gateway:</label></div>
                <div class="col-md-6">
                  <select name="gateway_name[]" id="gateway_name" class="form-control gateway_id" multiple>
                     
                                
                </select></div>
             

              </div>
              <br/>

               <div class="row">
                
              <div class="col-md-2"><label for="recipient-name" class="col-form-label">Status:</label></div>
                <div class="col-md-6">
                  <select name="status" id="status" class="form-control">
                     <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                </select></div>
             

              </div>
              <br/>
              
             
              <br/>
            </div>

        
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createsenderid" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="create_route_plan_save">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Create New Route Plan end -->

<!-- Edit New Route Plan modal start -->
<div class="modal fade" id="edit_route_plan_modal" name="edit_route_plan_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Routing Plan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_add_contact"></div>
        <form id="editRouteplanForm">
            <div class="container-fluid">
                <input type="hidden" name="type"  value="edit_routing_plan"  >
                <input type="hidden" name="rp_id" id="rp_id"  value=""  >
                <input name="page" type="hidden" id="page" value="route_plan"  />
                <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
              <div class="row">
                
                <div class="col-md-2"><label for="recipient-name" class="col-form-label">Plan Name:</label></div>
                <div class="col-md-6">
                  <select name="plan_name" id="edit_plan_name" class="form-control">
                      
                                
                </select></div>


             

              </div>
             
      <br/>
              <div class="row">
                
                <div class="col-md-2"><label for="recipient-name" class="col-form-label">Route:</label></div>
                <div class="col-md-6">
                  <select name="route_dropdown" id="edit_route_dropdown" class="form-control">
                      
                                
                </select></div>
             

              </div>
            
              <br/>
             
              
              <div class="row">
                
              <div class="col-md-2"><label for="recipient-name" class="col-form-label">Gateway:</label></div>
                <div class="col-md-6">
                  <select name="gateway_name[]" id="edit_gateway_name" class="form-control gateway_id" multiple>
                     
                                
                </select></div>
             

              </div>
              <br/>

               <div class="row">
                
              <div class="col-md-2"><label for="recipient-name" class="col-form-label">Status:</label></div>
                <div class="col-md-6">
                  <select name="status" id="edit_status" class="form-control">
                     <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                </select></div>
             

              </div>
              <br/>
              
             
              <br/>
            </div>

        
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createsenderid" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="edit_route_plan_save">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Edit New Route Plan end -->

<!-- Add plan modal start -->
<div class="modal fade" id="add_plan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Plan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_add_contact"></div>
        <form id="create_plan_form">
            <div class="container-fluid">
                 <input type="hidden" name="createplan" id="type" value="createplan">
                <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
              <div class="row">
                
                <div class="col-md-2"><label for="recipient-name" class="col-form-label">Plan Name:</label></div>
                <div class="col-md-4"><input type="text" required="required"  class="form-control" name="p_name" id="p_name" placeholder="Plan Name"></div>

                <div class="col-md-2"><label for="recipient-name" class="col-form-label">Status:</label></div>
                <div class="col-md-4">
                  <select name="plan_status" id="plan_status" class="form-control">
                     <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                </select>
              </div>
                
         
              </div>
             
    
              <br/>
              
             
              <br/>
            </div>

        </form>
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createsenderid" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save_plan">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- Add plan modal end -->

<!-- plan details edit modal start -->
<div class="modal fade" id="edit_plan" name="edit_plan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Plan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_add_contact"></div>
        <form id="edit_plan_form">
            <div class="container-fluid">
                 <input type="hidden" name="list_type" id="list_type" value="editplan">
                  <input type="hidden" name="pid" id="pid" value="">
                <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
              <div class="row">
                
                <div class="col-md-2"><label for="recipient-name" class="col-form-label">Plan Name:</label></div>
                <div class="col-md-4"><input type="text" required="required"  class="form-control" name="p_name" id="edit_p_name" placeholder="Plan Name"></div>

                <div class="col-md-2"><label for="recipient-name" class="col-form-label">Status:</label></div>
                <div class="col-md-4">
                  <select name="plan_status" id="edit_plan_status" class="form-control">
                     <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                </select>
              </div>
                
         
              </div>
             
    
              <br/>
              
             
              <br/>
            </div>

        </form>
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createsenderid" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="edit_plan_btn">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- plan details edit modal end -->


<!-- Add gateway modal start -->
<div class="modal fade" id="add_gateway_modal" name="add_gateway_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Gateway Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_add_contact"></div>
        <form id="add_gateway_form" action="#" name="add_gateway_form" method="POST">
          <input type="hidden" name="add_gateway" id="add_gateway" value="add_gateway">
          <div class="row g-3 mb-3">
            <div class="col-lg-12">
              <div class="card">                
                <div class="card-body">
                   <div id="action_message" style="display:none"></div>
                   <div class="row">
                    <div class="col-sm-2"><label for="recipient-name" class="col-form-label">TX / RX Mode</label> <div class="form-check-size">
                            <div class="form-check form-switch form-check-inline">
                              <input type="hidden" name="bind_mode_val" value="yes" id="bind_mode_val">
                              <input class="form-check-input switch-primary check-size" type="checkbox" role="switch"  name="bind_mode" value="yes" id="bind_mode">
                            </div>
                    
                      </div></div>
                    <div class="col-sm-2">
                    
                    </div>
                      
                    </div>
                    <br>
                    <div class="row mb-3 tx_rx_mode" >
                        <div class="col-sm-2">
                          <label for="inputEmail3" class="form-label">TX Port</label>
                          <input type="text"   class="form-control" name="tx_port" id="tx_port" placeholder="TX Port">
                        </div>
                        <div class="col-sm-2">
                          <label for="inputEmail3" class="form-label">RX Port</label>
                          <input type="text"   class="form-control" name="rx_port" id="rx_port" placeholder="RX Port">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-2">
                          <label for="inputEmail3" class="form-label">Gateway Name</label>
                          <input type="text"   class="form-control" name="smsc_id" id="smsc_id" placeholder="Gateway Name">
                        </div>
                        <div class="col-sm-2">
                          <label for="inputEmail3" class="form-label">System Type</label>
                          <input type="text"   class="form-control" name="system_type" id="system_type" placeholder="System Type">
                        </div>
                        <div class="col-sm-2">
                          <label for="inputEmail3" class="form-label">Username</label>
                          <input type="text"   class="form-control" name="username" id="username" placeholder="Username">
                        </div>
                        <div class="col-sm-2">
                          <label for="inputEmail3" class="form-label">Password</label>
                          <input type="text"   class="form-control" name="password" id="password" placeholder="Password">
                        </div>
                         <!-- <div class="col-sm-2">
                          <label for="inputEmail3" class="form-label">IP Address</label>
                          <input type="text"   class="form-control" name="ip_address" id="ip_address" placeholder="IP Address">
                        </div> -->
                         <div class="col-sm-2">
                          <label for="inputEmail3" class="form-label">Allowed SMSC ID</label>
                          <input type="text"   class="form-control" name="allowed_smsc_id" id="allowed_smsc_id" placeholder="Allowed SMSC ID">
                        </div>
                        <div class="col-sm-2">
                          <label for="inputEmail3" class="form-label">Locate</label>
                          <select class="form-control" name="locate" id="locate">
                            <option value="">Select Locate</option>
                            <option value="smsc" selected>SMSC</option>
                            <option value="otp">otp</option>
                          </select>
                        </div>
                    </div>
                    <br/>
                    <div class="row mb-3">
                      <div class="col-sm-2">
                        <label for="inputEmail3" class="form-label">HOST</label>
                        <input type="text"   class="form-control" name="host" id="host" placeholder="HOST name">
                      </div>
                      <div class="col-sm-2">
                        <label for="inputEmail3" class="form-label">TRX PORT</label>
                        <input type="text"   class="form-control" name="port" id="port" placeholder="Port Number">
                      </div>
                      <!-- <div class="col-sm-2">
                        <label for="inputEmail3" class="form-label">TX Mode</label>
                        <input type="text"   class="form-control" name="tx_mode" id="tx_mode" placeholder="TX Mode">
                      </div> -->
                      <div class="col-sm-2">
                        <label for="inputEmail3" class="form-label">Instances</label>
                        <input type="text"   class="form-control" name="instances" id="instances" placeholder="Instances">
                      </div>
                      <div class="col-sm-2">
                        <label for="inputEmail3" class="form-label">Enquiry Interval</label>
                        <input type="text"   class="form-control" name="enquiry_interval" id="enquiry_interval" placeholder="Enquiry Interval">
                      </div>
                      <div class="col-sm-2">                     
                       <label for="inputEmail3" class="form-label">Charset</label>
                        <input type="text"   class="form-control" name="charset" id="charset" placeholder="Charset">
                      </div>
                    </div>
                    <br/>
                    <div class="row mb-3">
                      <div class="col-sm-2">
                        <label for="inputEmail3" class="form-label">Source TON</label>
                        <input type="text"   class="form-control" name="source_ton" id="source_ton" placeholder="Source TON">
                      </div>
                      <div class="col-sm-2">
                        <label for="inputEmail3" class="form-label">Source NPI</label>                       
                        <input type="text"   class="form-control" name="source_npi" id="source_npi" placeholder="Source NPI">
                      </div>
                      <div class="col-sm-2">
                        <label for="inputEmail3" class="form-label">Destination TON</label>                       
                        <input type="text"   class="form-control" name="destination_ton" id="destination_ton" placeholder="Destination Ton">
                      </div>
                      <div class="col-sm-2">
                        <label for="inputEmail3" class="form-label">Destination NPI</label>                       
                        <input type="text"   class="form-control" name="destination_npi" id="destination_npi" placeholder="Destination NPI">
                      </div>                   
                      <div class="col-sm-2">
                        <label for="inputEmail3" class="form-label">Max Pending</label>                       
                        <input type="text"   class="form-control" name="max_pending" id="max_pending" placeholder="Max Pending">
                      </div>
                      <div class="col-sm-2">
                        <label for="inputEmail3" class="form-label">Status</label>                       
                        <select name="gateway_status" id="gateway_status" class="form-control">
                          <option value="">Select Status</option>
                          <option value="1">Active</option>
                          <option value="0">Inactive</option>
                        </select>
                      </div>
                    </div>
              </div>
              </div>
            </div>
          </div>
       
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createsenderid" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="save_gateway">Save</button>
      </div>
       </form>
    </div>
  </div>
</div>
<!-- Add Gateway modal end -->

<!-- Edit Gateway Modal Start -->
<div class="modal fade" id="edit_gateway_modal" name="edit_gateway_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Gateway Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_add_contact"></div>
        <form id="edit_gateway_form" action="#" name="edit_gateway_form" method="POST">
         <input type="hidden" name="list_type" value="update_gateway">
         <input type="hidden" name="gateway_id" id="gateway_id" value="">
         <input type="hidden" name="conf_file" id="conf_file" value="">
         <input type="hidden" name="log_file" id="log_file" value="">
          <div class="row g-3 mb-3">
            <div class="col-lg-12">
              <div class="card">                
                <div class="card-body">
                   <div id="action_message" style="display:none"></div>
                    <div class="row mb-3">
                        <div class="col-sm-2">
                          <label for="inputEmail3" class="form-label">Gateway Name</label>
                          <input type="text"   class="form-control" name="smsc_id" id="edit_smsc_id" placeholder="Gateway Name" readonly>
                        </div>
                        <div class="col-sm-2">
                          <label for="inputEmail3" class="form-label">System Type</label>
                          <input type="text"   class="form-control" name="system_type" id="edit_system_type" placeholder="System Type">
                        </div>
                        <div class="col-sm-2">
                          <label for="inputEmail3" class="form-label">Username</label>
                          <input type="text"   class="form-control" name="username" id="edit_username" placeholder="Username">
                        </div>
                        <div class="col-sm-2">
                          <label for="inputEmail3" class="form-label">Password</label>
                          <input type="text"   class="form-control" name="password" id="edit_password" placeholder="Password">
                        </div>
                         <!-- <div class="col-sm-2">
                          <label for="inputEmail3" class="form-label">IP Address</label>
                          <input type="text"   class="form-control" name="ip_address" id="edit_ip_address" placeholder="IP Address">
                        </div> -->
                         <div class="col-sm-2">
                          <label for="inputEmail3" class="form-label">Allowed SMSC ID</label>
                          <input type="text"   class="form-control" name="allowed_smsc_id" id="edit_allowed_smsc_id" placeholder="Allowed SMSC ID" readonly>
                        </div>
                         <div class="col-sm-2">
                          <label for="inputEmail3" class="form-label">Locate</label>
                          <select class="form-control" name="locate" id="edit_locate">
                            <option value="">Select Locate</option>
                            <option value="smsc" selected>SMSC</option>
                            <option value="otp">otp</option>
                          </select>
                        </div>
                    </div>
                    <br/>
                    <div class="row mb-3">
                      <div class="col-sm-2">
                        <label for="inputEmail3" class="form-label">HOST</label>
                        <input type="text"   class="form-control" name="host" id="edit_host" placeholder="HOST name">
                      </div>
                      <div class="col-sm-2">
                        <label for="inputEmail3" class="form-label">PORT</label>
                        <input type="text"   class="form-control" name="port" id="edit_port" placeholder="Port Number">
                      </div>
                      <div class="col-sm-2">
                        <label for="inputEmail3" class="form-label">TX Mode</label>
                        <input type="text"   class="form-control" name="tx_mode" id="edit_tx_mode" placeholder="TX Mode">
                      </div>
                      <div class="col-sm-2">
                        <label for="inputEmail3" class="form-label">Instances</label>
                        <input type="text"   class="form-control" name="instances" id="edit_instances" placeholder="Instances">
                      </div>
                      <div class="col-sm-2">
                        <label for="inputEmail3" class="form-label">Enquiry Interval</label>
                        <input type="text"   class="form-control" name="enquiry_interval" id="edit_enquiry_interval" placeholder="Enquiry Interval">
                      </div>
                      <div class="col-sm-2">                     
                       <label for="inputEmail3" class="form-label">Charset</label>
                        <input type="text"   class="form-control" name="charset" id="edit_charset" placeholder="Charset">
                      </div>
                    </div>
                    <br/>
                    <div class="row mb-3">
                      <div class="col-sm-2">
                        <label for="inputEmail3" class="form-label">Source TON</label>
                        <input type="text"   class="form-control" name="source_ton" id="edit_source_ton" placeholder="Source TON">
                      </div>
                      <div class="col-sm-2">
                        <label for="inputEmail3" class="form-label">Source NPI</label>                       
                        <input type="text"   class="form-control" name="source_npi" id="edit_source_npi" placeholder="Source NPI">
                      </div>
                      <div class="col-sm-2">
                        <label for="inputEmail3" class="form-label">Destination TON</label>                       
                        <input type="text"   class="form-control" name="destination_ton" id="edit_destination_ton" placeholder="Destination Ton">
                      </div>
                      <div class="col-sm-2">
                        <label for="inputEmail3" class="form-label">Destination NPI</label>                       
                        <input type="text"   class="form-control" name="destination_npi" id="edit_destination_npi" placeholder="Destination NPI">
                      </div>                   
                      <div class="col-sm-2">
                        <label for="inputEmail3" class="form-label">Max Pending</label>                       
                        <input type="text"   class="form-control" name="max_pending" id="edit_max_pending" placeholder="Max Pending">
                      </div>
                      <div class="col-sm-2">
                        <label for="inputEmail3" class="form-label">Status</label>                       
                        <select name="gateway_status" id="edit_gateway_status" class="form-control">
                          <option value="">Select Status</option>
                          <option value="1">Active</option>
                          <option value="0">Inactive</option>
                        </select>
                      </div>
                    </div>
              </div>
              </div>
            </div>
          </div>
       
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createsenderid" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="edit_gateway">Save</button>
      </div>
    </form>
    </div>
  </div>
</div>
<!-- Edit Gateway Modal End -->

<!-- Add sender routing modal start -->

<div class="modal fade" id="add_sender_routing_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Sender Routing</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_add_contact"></div>
        <form id="sender_routing_form">
            <div class="container-fluid">
                 <input type="hidden" name="type" id="type" value="add_sender_routing">
                <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
              <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-3"><label for="recipient-name" class="col-form-label">Username:</label></div>
                <div class="col-md-4">
                  <select class="form-control" id="username_senderid" name="username_senderid" data-placeholder="Select a Username..." >
                  
                  </select>
                </div>               
         
              </div>



             
    
              <br/>
               <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-3"><label for="recipient-name" class="col-form-label">Sender ID:</label></div>
                <div class="col-md-4">
                  <select name="sender_id1" id="sender_id1" class="form-control sender_id1">
                     </select>
              </div>
                
         
              </div>
             
              <br/>

               <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-3"><label for="recipient-name" class="col-form-label">Gateway Name:</label></div>
                <div class="col-md-4">
                  <select name="gateway_id" id="sender_gateway_id" class="form-control sender_gateway_id">
                    <option value="">Select Gateway</option>
                     </select>
              </div>
                
         
              </div>
              <br/>
<!-- 
              <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-3"><label for="recipient-name" class="col-form-label">Status:</label></div>
                <div class="col-md-4">
                  <select name="sender_route_status" id="sender_route_status" class="form-control">
                      <option value="">Select Status</option> 
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>       
                  </select>
              </div>
                
         
              </div> -->
            </div>

        
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createsenderid" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="save_sender_routing">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Add sender routing end -->

<!-- Edit sender routing modal start -->
<div class="modal fade" id="edit_sender_routing_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Sender Routing</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_add_contact"></div>
        <form id="edit_sender_routing_form">
            <div class="container-fluid">
                 <input type="hidden" name="type" id="type" value="edit_sender_routing">
                 <input type="hidden" name="srid" id="srid" value="">
                <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
              <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-3"><label for="recipient-name" class="col-form-label">Username:</label></div>
                <div class="col-md-4"> <select class="form-control" id="edit_username_senderid" name="edit_username_senderid" data-placeholder="Select a Username..." >
                  
                  </select></div>               
         
              </div>



             
    
              <br/>
               <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-3"><label for="recipient-name" class="col-form-label">Sender ID:</label></div>
                <div class="col-md-4">
                  <select name="sender_id1" id="edit_sender_id1" class="form-control sender_id1">
                     </select>
              </div>
                
         
              </div>
             
              <br/>

               <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-3"><label for="recipient-name" class="col-form-label">Gateway Name:</label></div>
                <div class="col-md-4">
                  <select name="gateway_id" id="edit_gateway_id" class="form-control sender_gateway_id">
                    <option value="">Select Gateway</option>
                     </select>
              </div>
                
         
              </div>
              <br/>

             <!--  <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-3"><label for="recipient-name" class="col-form-label">Status:</label></div>
                <div class="col-md-4">
                  <select name="sender_route_status" id="edit_sender_route_status" class="form-control">
                      <option value="">Select Status</option> 
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>       
                  </select>
              </div>
                
         
              </div> -->
            </div>

        
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createsenderid" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="edit_sender_routing">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- Edit sender routing end -->

<!-- Add smpp error code modal start -->

<div class="modal fade" id="add_smpp_error_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add SMPP Error Code</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_add_contact"></div>
        <form id="smpp_error_form">
            <div class="container-fluid">
                 <input type="hidden" name="type" id="type" value="add_smpp_error_code">
                <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
              <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-3"><label for="recipient-name" class="col-form-label">Error Code:</label></div>
                <div class="col-md-4"><input type="text" required="required"  class="form-control" name="error_code" id="error_code" placeholder="Error Code"></div>               
         
              </div>

              <br/>
               <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-3"><label for="recipient-name" class="col-form-label">Status:</label></div>
                <div class="col-md-4"><input type="text" required="required"  class="form-control" name="error_status" id="error_status" placeholder="Error Status"></div>               
         
              </div>

              <br/>

               <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-3"><label for="recipient-name" class="col-form-label">Gateway Name:</label></div>
                <div class="col-md-4">
                <input class="form-control some_class_name" name="upload_gateway_id_dropdown" id="gateway_id" placeholder="Select Gateway Id" >
                  <input type="hidden" id="upload_gateway_id2" name="gateway_id">
                  <!-- <select name="gateway_id" id="gateway_id"  class="form-control gateway_id">
                    <option>Select Gateway</option>
                     </select> -->
              </div>
                
         
              </div>
              <br/>

          <!--     <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-3"><label for="recipient-name" class="col-form-label">Status:</label></div>
                <div class="col-md-4">
                  <select name="sender_route_status" id="sender_route_status" class="form-control">
                      <option>Select Status</option> 
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>       
                  </select>
              </div>
                
         
              </div> -->
            </div>

        </form>
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createsenderid" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save_empp_error">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- Add smpp error code end -->



<!-- upload smpp error code modal start -->

<div class="modal fade" id="upload_smpp_error_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload SMPP Error Code</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_add_contact"></div>
        <form id="upload_smpp_error_form" method="post" enctype="multipart/form-data">
            <div class="container-fluid">
              <input type="hidden" name="type" id="type" value="upload_smpp_error_code">
              <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
              <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-3"><label for="recipient-name" class="col-form-label">Browse File:</label></div>
                <div class="col-md-6"><input type="file" class="form-control" name="upload_error_code" id="upload_error_code" placeholder="" value="Upload Senderid"></div>
              
                <span style="margin-left:43%;">Only csv format files are  allowed to import</span>
                <span style="margin-left:43%;"><a href="downloads/error_code.csv" download>Download Sample File</a></span>
               
              </div>

              <br/>
              

               <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-3"><label for="recipient-name" class="col-form-label">Gateway Name:</label></div>
                <div class="col-md-4">
                  <!-- <select name="upload_gateway_id" id="upload_gateway_id"  class="form-control gateway_id">
                    <option>Select Gateway</option>
                     </select> -->


                  <input class="form-control some_class_name" name="upload_gateway_id_dropdown" id="upload_gateway_id_dropdown" placeholder="Select Gateway Id" >
                  <input type="hidden" id="upload_gateway_id" name="upload_gateway_id">
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
        <button type="button" class="btn btn-primary" id="upload_empp_error">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- Add smpp error code end -->
