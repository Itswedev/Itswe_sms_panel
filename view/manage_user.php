          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                  <span id="page_name" style="display:none;">manage_user</span>
                    <h4>Manage User</h4>
                    <!--<button id="gradientButtons1" class="btn-pill   btn btn-primary-gradien"  data-bs-toggle="modal" data-bs-target="#add_route" style="
                    position: relative;
                    float: right;
                    margin-top: -2%;
                    margin-right: 25%;
                    ">Add New User</button>-->
                    <a class="btn btn-primary" href='dashboard.php?page=add_new_user' type='button' aria-haspopup='true' aria-expanded='false'><i class="fa-solid fa-circle-plus fa-fw" style="margin-right: 8px;"></i>Add New User</a>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive theme-scrollbar">
                      <table class="display" id="user_tbl">
                        <thead style="background-color:#f4f7f9;">
                          <tr>
                            <th>Sr No</th>
                            <th>Username</th>
                            <th>Parent</th>
                            <th>Route(Bal)</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Created Date</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody class="user_list" id="user_list">

                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Zero Configuration  Ends-->
            </div>
     
       


    <?php include_once('../include/included_js.php'); ?>

  <script src="assets/js/utility.js?<?php echo time(); ?>"></script>
