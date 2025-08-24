        

          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Manage Hash</h4>
                    <button id="gradientButtons1" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#add_plan" ><i class="fa-solid fa-circle-plus fa-fw" style="margin-right: 8px;"></i> Create Hash</button>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive theme-scrollbar">
                      <table class="display" id="plan_tbl">
                        <thead style="background-color:#f4f7f9;">
                          <tr>
                            <th>Sr No</th>
                            <th>Username Name</th>
                            <th>PE</th>
                            <th>TM</th>
                            <th>TMD</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody class="hash" id="hash">
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

    <?php include_once('include/modal_forms/hash_model.php'); ?>

    <script type="text/javascript" src="assets/js/hash.js?=<?=time();?>"></script>
