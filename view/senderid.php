<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

?>
<link rel="stylesheet" type="text/css" href="assets/css/vendors/sweetalert2.css">

          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Manage SenderId</h4>
                    <button id="gradientButtons1" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#exampleModal" style="
                    position: relative;
                    float: right;
                    margin-top: -1%;
                    margin-right: 25%;
                    "><i class="fa-solid fa-circle-plus fa-fw" style="margin-right: 8px;"></i>Add Sender</button>
                     <button class='btn btn-primary' id='upload_senderid' data-bs-toggle="modal" data-bs-target="#upload_sender_modal" style="
                    position: relative;
                    float: right;
                    margin-top: -1%;
                    margin-right: 2%;
                    ">Import <i class="fa-solid fa-upload fa-fw" style="margin-right: 8px;"></i></button>
                    <button class='btn btn-primary' id='download_senderid' style="
                    position: relative;
                    float: right;
                    margin-top: -1%;
                    margin-right: 2%;
                    ">Export <i class="fa-solid fa-download fa-fw" style="margin-right: 8px;"></i> </button>

                                    
                  </div>
                  <div class="card-body">
                    <div class="table-responsive theme-scrollbar">
                      
                      <table class="display" id="sender_id_tbl">
                        <thead style="background-color:#f4f7f9;">
                          <tr>
                          <?php
                    $user_role=$_SESSION['user_role'];
                    if($user_role=='mds_adm')
                    {
                      echo '<th>Username</th>';
                    } 
                  ?>
                            <th>SenderId</th>
                            <th>PE ID</th>
                            <th>Header ID</th>
                            <th>Description</th>
                            <th>Created Date</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody class="sender_list">

				                </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Zero Configuration  Ends-->
            </div>
        
    
      

    
        
        <!-- <?php //include_once('include/included_js.php'); ?> -->
        
    
        <script src="assets/js/sender_id_function.js?=<?php time(); ?>"></script>
        
        <?php include_once('include/modal_forms/sender_id_modal.php'); ?>
        
  
        

        
  