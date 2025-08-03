

          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Manage Credits</h4>
                    <button id="gradientButtons1" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#credit_modal" ><i class="fa-solid fa-credit-card fa-fw" style="margin-right: 8px;"></i>Add Credits</button>
                   
                  </div>
                  <div class="card-body">
                    <div class="table-responsive theme-scrollbar">
                      <table class="display" id="credit_tbl">
                        <thead style="background-color:#f4f7f9;">
                          <tr>
                            <th>sr no</th>
                            <th>Username</th>
                            <th>Credit type</th>
                            <th>Credit Assign</th>
                            <th>Balance</th>
                            <th>Remark</th>
                            <th>Created at</th>
                            <!--<th>Action</th>-->
                          </tr>
                        </thead>
                        <tbody class="credit_list" id="credit_list">
                      
                          
                          
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Zero Configuration  Ends-->
            </div>

       

      


    <?php include_once('include/modal_forms/credit_modal.php'); ?>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js?=<?=time();?>"></script>
    
    <script src="assets/js/tagify.js"></script>
    <script src="assets/js/tagify.polyfills.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify@4.9.8/dist/tagify.min.js"></script> -->
    <script type="text/javascript" src="assets/js/credit.js?=<?=time();?>"></script>
    
  