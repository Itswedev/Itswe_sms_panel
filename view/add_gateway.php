<style>
  .tx_rx_mode
  {
    display:none;
  }
  </style>


          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Gateway</h4>
                    <button id="gradientButtons1" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#add_gateway_modal"><i class="fa-solid fa-circle-plus fa-fw" style="margin-right: 8px;"></i>Add Gateway</button>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive theme-scrollbar">
                      <table class="display" id="gateway_tbl">
                        <thead style="background-color:#f4f7f9;">
                          <tr>
                            <th>Sr No</th>
                            <th>Gateway Name</th>
                            <th>Type</th>
                            <th>Host</th>
                            <th>Status</th>
                            <th>Created Date</th>
                            <!--<th>Call Barred</th>-->
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody class="gateway_list" id="gateway_list">
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Zero Configuration  Ends-->
            </div>

 
    <?php include_once('include/modal_forms/manage_gateway_modal.php'); ?>
    <script type="text/javascript" src="assets/js/gateway.js?=<?=time();?>"></script>
  </body>
</html>