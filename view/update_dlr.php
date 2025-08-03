 

          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Update DLR</h4>
                  </div>
                  <br>
                  <div class="row" style="margin-left: 2%;">
                  <form id="update_dlr_form">
                  <input type="hidden" name="list_type"  value="update_dlr"  >
                  <div class="col col-sm-3">
                  <div class="mb-3">
                    <label class="form-label" for="campaign_name1">Username Name</label>
                    <!-- <input class="form-control btn-pill" placeholder="Select User" type="text"> -->
                    <select class="form-select btn-pill" id="username_senderid" name="user_name" required></select>
                  </div>
                </div>
               
                <div class="col col-sm-3">
                  <div class="mb-3">
                    <label class="form-label" for="campaign_name2">Campaign ID</label>
                    <select class="form-select btn-pill" id="camp_id" name="camp_id" required></select>
                  </div>
                </div>
                <div class="col col-sm-3">
                  <div class="mb-3">
                    <label class="form-label" for="campaign_name3">Rows</label>
                    <input class="form-control btn-pill" placeholder="Rows To Update"  type="text" name="rows_count" id="rows_count" required>
                  </div>
                </div>
              </div>

              <div class="row" style="margin-left: 2%;">
                  <div class="col col-sm-4">
                  <div class="mb-3">
                    <label class="form-label" for="campaign_name1">From Status</label>
                    <select class="form-select btn-pill" id="old_status" name="from_status" required></select>
                  </div>
                </div>
                <div class="col col-sm-4">
                  <div class="mb-3">
                    <label class="form-label" for="campaign_name2">To Status</label>
                    <input class="form-control btn-pill" placeholder="To Status" type="text" name="to_status" required>
                  </div>
                </div>
              </div>
              <div class="row" style="margin-left: 2%;">
                <div class="col col-sm-4">
                  <div class="mb-3">
                    <label class="form-label" for="campaign_name3">From Error code</label>
                    <select class="form-select btn-pill" id="from_error" name="from_error" required></select>
                  </div>
                </div>
                <div class="col col-sm-4">
                  <div class="mb-3">
                    <label class="form-label" for="campaign_name3">To Error code</label>
                    <input class="form-control btn-pill" placeholder="To Error" type="text" name="to_error_code" required>
                  </div>
                </div>
              </div>
              <div>
              <button type="submit" class="btn btn-primary pmd-ripple-effect" name="input-form-submit" value="Subscribe" id="save_user_btn" style="margin-left: 3%;">Update</button>
              <br>
              <br>
            </form>
              </div>
              </div>
                  </div>
              <!-- Zero Configuration  Ends-->
            </div>


        <script src="assets/js/update_dlr.js?=<?=time();?>"></script>