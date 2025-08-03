        

          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Plan</h4>
                    <button id="gradientButtons1" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#add_plan" ><i class="fa-solid fa-circle-plus fa-fw" style="margin-right: 8px;"></i> Create Plan</button>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive theme-scrollbar">
                      <table class="display" id="plan_tbl">
                        <thead style="background-color:#f4f7f9;">
                          <tr>
                            <th>Sr No</th>
                            <th>Plan Name</th>
                            <th>Status</th>
                            <th>Created Date</th>
                            
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody class="plan" id="plan">
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Zero Configuration  Ends-->
            </div>

        <!-- footer start-->
       <?php include('../include/footer.php'); ?>

    <?php include_once('include/modal_forms/manage_gateway_modal.php'); ?>
    <script type="text/javascript" src="assets/js/plan.js?=<?=time();?>"></script>
