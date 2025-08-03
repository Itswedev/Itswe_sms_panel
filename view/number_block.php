
          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h4 id="page_name">#Number Block</h4>
                    <button id="gradientButtons1" class="btn-pill   btn btn-primary"  data-bs-toggle="modal" data-bs-target="#addblocknumberModel"><i class="fa-solid fa-circle-plus fa-fw" style="margin-right: 8px;"></i>Add New</button>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive theme-scrollbar">
                      <table class="display" id="number_block_tbl">
                        <thead style="background-color:#f4f7f9;">
                          <tr>
                           
                            <th>Date</th>
                            <?php 
                                        if($_SESSION['user_role']=='mds_adm')
                                        {
                                ?>
                                            <th>Username</th>
                                <?php
                                        }

                            ?>
                                        <th>Mobile Number</th>
                                        <th>Status</th>
                                         <th>Action</th>
                          </tr>
                        </thead>
                        <tbody class="number_block_dtls" id="number_block_dtls">
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
       <?php include_once('include/modal_forms/number_block_modal.php'); ?>
<script src="assets/js/number_block.js"></script>
