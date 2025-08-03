
          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Contact Groups</h4>
                    <div class="row">
                <div class="col-lg-4">

                </div>
                  <div class="col-lg-2">
                 <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_contact" id="add_contact_btn" style="
                    position: relative;
                    float: right;
                    margin-top: -1%;
                    margin-right: 150%;
                    width:229%;
                    "><i class="fa-solid fa-circle-plus fa-fw" style="margin-right: 8px;"></i> Add Contact </button>


                </div>
                <div class="col-lg-2">
                 <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create_group" style="
                    position: relative;
                    float: right;
                    margin-top: -1%;
                    margin-right: 56%;
                    width:190%;"><i class="fa-solid fa-circle-plus fa-fw" style="margin-right: 8px;"></i>New Group </button>


                </div>
                <div class="col-lg-4">
                 <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#group_with_contacts" id="group_with_contact_btn" style="
                    position: relative;
                    float: right;
                    margin-top: -1%;
                    margin-right: 2%;
                    width:120%;"><i class="fa-solid fa-circle-plus fa-fw" style="margin-right: 8px;"></i>Group With Contacts</button>


                </div>
              </div>
            </div>
                    
                  
                  <div class="card-body">
                    <div class="table-responsive theme-scrollbar">
                      <table class="display" id="gateway_tbl">
                        <thead>
                          <tr>
                                          <th class="sort" data-sort="name" width="5%">Sr. No.</th>
                                          <th class="sort" data-sort="email">Group Name</th>
                                          <th class="sort" data-sort="age">Description</th>
                                          <th class="sort" data-sort="age">Count</th>

                                          <th class="sort" data-sort="age">Create Date</th>

                                          <th class="sort" data-sort="age">Action(s)</th>
                                        </tr>
                        </thead>
                        <tbody class="group_list" id="group_list">

                                      </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Zero Configuration  Ends-->
            </div>
 
        <?php include_once('include/modal_forms/group_modal.php'); ?>
        <script src="assets/js/ajaxupload_group.js?=<?=time();?>"></script>
        <script src="assets/js/group.js?=<?=time();?>"></script>
        <script src="assets/js/jquery.multiselect.js?=<?=time();?>"></script>
  </body>
</html>