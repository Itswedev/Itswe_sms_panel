
<!--Edit cut off modal-->

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="editcutoffModel">
  <div class="modal-dialog modal-xl">
       <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Cut Off Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_add_contact"></div>
          <form id="edit_cut_off_form"  name="edit_cut_off_form" method="POST">
                 <input type="hidden" name="list_type" value="edit_cut_off_module">
                 <input type="hidden" name="edit_cut_off_id"  id="edit_cut_off_id" value="">
                  <input type="hidden" name="old_route"  id="old_route" value="">
               
                  <div class="container-fluid">
                  
                
                     <div class="input-group pmd-input-group mb-3 row">
                      <div class="col col-sm-2">
                           <label for="inputEmail3" class="">Route</label>
                        </div>
                        <div class="pmd-textfield col col-sm-3" >
                   <select name="edit_route_cutoff" id="edit_route_cutoff" class="form-control">
                            
                           </select>
                </div>
                <div class="col col-sm-2">
                          <label for="inputEmail3" class="">Cutt-Off Status</label>
                        </div>
                        <div class="pmd-textfield col col-sm-3" >
                   <select name="edit_cut_off_status" id="edit_cut_off_status" class="form-control">
                             <option value="">Select Status</option>
                             <option value="Delivered">Delivered</option>
                              <option value="Failed">Failed</option>
                               <option value="Submitted">Submitted</option>
                             
                           </select>
                </div>
                 </div>
                   <div class="input-group pmd-input-group mb-3 row">
                <div class="col col-sm-2">
                          <label for="inputEmail3" class="">Cutting Throughput</label>
                        </div>
                        <div class="pmd-textfield col col-sm-3" >
                    <input type="text" class="form-control" name="edit_c_throughput" id="edit_c_throughput" placeholder="eg. 50-60">
                </div>
                <div class="col col-sm-2">
                          <label for="inputEmail3" class="">Cutting Min Value</label>
                        </div>
                <div class="pmd-textfield col col-sm-3" >
                  <input type="text" class="form-control" name="edit_c_min_val" id="edit_c_min_val" placeholder="eg. 10000">
                </div>
               

                    
            </div>
          
            <div class="form-group">
                <button type="submit" class="btn btn-primary pmd-ripple-effect" name="input-form-submit" value="Subscribe" id="edit_cut_off">Save</button>
                <button type="reset" class="btn btn-secondary pmd-ripple-effect" name="input-form-submit" value="Clear" id="clear">Clear</button>
            </div>

                    
                  </div>
                   </form>
                    </div>
  </div>
  </div>
</div>