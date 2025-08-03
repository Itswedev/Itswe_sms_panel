

          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Branding</h4>
                    <button id="gradientButtons1" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#brandingModel
                    "><i class="fa-solid fa-circle-plus fa-fw" style="margin-right: 8px;"></i> Add Branding</button>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive theme-scrollbar">
                      <table class="display" id="brand_tbl">
                        <thead style="background-color:#f4f7f9;">
                          <tr>
                            <th>Sr.no</th>
                            <th>Company Name</th>
                            <th>Tagline</th>
                            <th>Website Address</th>
                            <th>Support URL</th>
                            <th>Support Mobile</th>
                            <th>Support e-Mail</th>
                            <th>Login Page Desc</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody class="brand_list" id="brand_list">
                                    
                          
                          
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Zero Configuration  Ends-->
            </div>

    <?php include_once('include/modal_forms/branding_modal.php'); ?>
    <script src="assets/js/branding.js?=<?=time();?>"></script>
  </body>
</html>