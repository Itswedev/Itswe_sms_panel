
          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Error Code</h4>
                    <button id="gradientButtons1" class="btn-pill   btn btn-primary-gradien"  data-bs-toggle="modal" data-bs-target="#add_smpp_error_modal" style="
                    position: relative;
                    float: right;
                    margin-top: -2%;
                    margin-right: 25%;
                    ">Add error code</button>
                    <button class='btn-pill btn btn-primary-gradien upload_btn' id='upload_error_btn' data-bs-toggle="modal" data-bs-target="#upload_smpp_error_modal" style="
                    position: relative;
                    float: right;
                    margin-top: -2%;
                    margin-right: 2%;
                    ">Import <i class='fas fa-file-upload'></i></button>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive theme-scrollbar">
                      <table class="display" id="smpp_error_code">
                        <thead style="background-color:#f4f7f9;">
                          <tr>
                            <th>Sr No</th>
                            <th>Error Code</th>
                            <th>Gateway Name</th>
                            <th>Error Status</th>
                            <th>Status</th>
                            <th>Created Date</th>
                            <!--<th>Call Barred</th>-->
                            <!-- <th>Action</th> -->
                          </tr>
                        </thead>
                        <tbody class="smpp_error_code_list" id="smpp_error_code_list">
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Zero Configuration  Ends-->
            </div>

    <?php include_once('include/modal_forms/manage_gateway_modal.php'); ?>
    <script type="text/javascript" src="assets/js/smpp_error.js?=<?=time();?>"></script>
  </body>
</html>