 
          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Support Ticket</h4>
                  </div>
                  <br>
                  <div class="row" style="margin-left: 2%;">
                  <div class="col col-sm-5">
                  <div class="mb-3">
                  <label class="form-label" for="exampleInputPassword6">Query</label>
                  <input class="form-control btn-pill" name="campaign_name" id="campaign_name" placeholder="Query Type" type="text" >
                  </div>
                </div>
              </div>

              <div class="row" style="margin-left: 2%;">
                  <div class="col col-sm-5">
                  <div class="mb-3">
                  <label class="form-label">Query Description</label>
                            <textarea class="form-control btn-pill" rows="5" placeholder="Type Query Here"></textarea>
                              <div class="form-check form-switch form-check-inline" style="position: absolute; margin-top: 22px;left: 54%;">
                          </div>
                  </div>
                </div>
              </div>
              <div class="row" style="margin-left: 2%;">
              <div>
              <button type="submit" class="btn btn-primary pmd-ripple-effect" name="input-form-submit" value="Subscribe" id="save_user_btn" style="margin-left: 1%;">Save</button>
              <br>
              <br>


              <div class="table-responsive theme-scrollbar">
                      <table class="display" id="sender_id_tbl">
                        <thead style="background-color:#f4f7f9;">
                          <tr>
                          <?php
                    $user_role=$_SESSION['user_role'];
                    if($user_role=='mds_adm')
                    {
                      echo '<th>Username</th>';
                    } 
                  ?>
                            <th>Ticke ID</th>
                            <th>Query</th>
                            <th>Solution</th>
                            <th>Created Date</th>
                            <th>Closed Date</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody class="">

				                </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Zero Configuration  Ends-->
            </div>
          </div>
          <!-- Container-fluid Ends-->
        </div>
       
   
    
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js?=<?=time();?>"></script>
        
        <script src="<?php echo $baseURL ; ?>assets/js/datatable/datatables/jquery.dataTables.min.js?<?= time() ; ?>"></script>
    <script src="<?php echo $baseURL ; ?>assets/js/datatable/datatables/datatable.custom.js?<?= time() ; ?>"></script>
    <script src="<?php echo $baseURL ; ?>assets/js/datatable/datatables/datatable.custom1.js?<?= time() ; ?>"></script>
    
        
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js?=<?=time();?>"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>  
    
        <script src="assets/js/form-validation-custom.js?=<?=time();?>"></script>
        <script type="text/javascript" src="assets/js/chosen.jquery.js?=<?=time();?>"></script> 
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>  
       
   
        <?php include_once('include/modal_forms/sender_id_modal.php'); ?>
        <!-- <?php //include_once('include/included_js.php'); ?> -->
        
        <script type="text/javascript" src="assets/js/chosen.jquery.js?=<?=time();?>"></script>

        <script src="assets/js/sender_id_function.js?<?php time(); ?>"></script>
              </div>
              </div>
                  </div>
              <!-- Zero Configuration  Ends-->
            </div>
