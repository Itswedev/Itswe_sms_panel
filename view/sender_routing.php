
          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Sender</h4>
                    <button id="gradientButtons1" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#add_sender_routing_modal" id="add_sender_rounting_btn"><i class="fa-solid fa-circle-plus fa-fw" style="margin-right: 8px;"></i>Add Routing</button>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive theme-scrollbar">
                      <table class="display" id="sender_routing_tbl">
                        <thead style="background-color:#f4f7f9;">
                          <tr>
                            <th>User Name</th>
                            <th>Sender Id</th>
                            <th>Gateway Name</th>
                            <th>Created Date</th>
                            <!--<th>Action</th>-->
                            <!--<th>Call Barred</th>-->
                            <!--<th>Call Barred</th>-->
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody class="sender_routing_list" id="sender_routing_list">
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
    <script type="text/javascript" src="assets/js/chosen.jquery.js?=<?=time();?>"></script>
    <script type="text/javascript" src="assets/js/sender_routing.js?=<?=time();?>"></script>
