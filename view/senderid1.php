
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="assets/css/vendors/sweetalert2.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css">
   
        <div class="page-body">
          <!-- Container-fluid starts-->
          <div class="container-fluid default-dashboard"> 
          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Manage SenderId</h4>
                    <button id="gradientButtons1" class="btn-pill   btn btn-primary-gradien"  data-bs-toggle="modal" data-bs-target="#exampleModal" style="
                    position: relative;
                    float: right;
                    margin-top: -2%;
                    margin-right: 25%;
                    ">Add Sender</button>
                     <button class='btn-pill btn btn-primary-gradien upload_btn' id='upload_senderid' data-bs-toggle="modal" data-bs-target="#upload_sender_modal" style="
                    position: relative;
                    float: right;
                    margin-top: -2%;
                    margin-right: 2%;
                    ">Import <i class='fas fa-file-upload'></i></button>


                                    <button type="button" class="btn-pill btn btn-primary" id="download_report_btn" style=" position: relative;
                    float: right;
                    margin-top: -2%;
                    margin-right: 2%;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
                                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
                                    </svg>
                
                                    </button>
                                    
                  </div>
                  <div class="card-body">
                    <div class="table-responsive theme-scrollbar">
                      
                      <table class="display" id="sender_id_tbl">
                        <thead>
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
          </div>
          <!-- Container-fluid Ends-->
        </div>
       
   
    
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js?=<?=time();?>"></script>
        
        <script src="<?php echo $baseURL ; ?>assets/js/datatable/datatables/jquery.dataTables.min.js?<?= time() ; ?>"></script>
    <script src="<?php echo $baseURL ; ?>assets/js/datatable/datatables/datatable.custom.js?<?= time() ; ?>"></script>
    <script src="<?php echo $baseURL ; ?>assets/js/datatable/datatables/datatable.custom1.js?<?= time() ; ?>"></script>
    
        
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js?=<?=time();?>"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>  
    
        <script src="assets/js/form-validation-custom.js?=<?=time();?>"></script>
        <script type="text/javascript" src="assets/js/chosen.jquery.js?=<?=time();?>"></script> 
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>  
        <script type="text/javascript" src="assets/js/chosen.jquery.js?=<?=time();?>"></script>
        <script src="assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/dataTables.buttons.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/jszip.min.js"></script>
    <!-- <script src="assets/js/datatable/datatable-extension/buttons.colVis.min.js"></script> -->
    <!-- <script src="assets/js/datatable/datatable-extension/pdfmake.min.js"></script> -->
    <!-- <script src="assets/js/datatable/datatable-extension/vfs_fonts.js"></script>
    <script src="assets/js/datatable/datatable-extension/dataTables.autoFill.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/dataTables.select.min.js"></script> -->
    <script src="assets/js/datatable/datatable-extension/buttons.bootstrap4.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/buttons.html5.min.js"></script>
    <!-- <script src="assets/js/datatable/datatable-extension/buttons.print.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/dataTables.bootstrap4.min.js"></script> -->
    <!-- <script src="assets/js/datatable/datatable-extension/dataTables.responsive.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/responsive.bootstrap4.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/dataTables.keyTable.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/dataTables.colReorder.min.js"></script> -->
    <!-- <script src="assets/js/datatable/datatable-extension/dataTables.fixedHeader.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/dataTables.rowReorder.min.js"></script>
    <script src="assets/js/datatable/datatable-extension/dataTables.scroller.min.js"></script> -->
    <!-- <script src="assets/js/custome.js"></script>
         -->
        <!-- <?php //include_once('include/included_js.php'); ?> -->
        
    
        <script src="assets/js/sender_id_function1.js?<?php time(); ?>"></script>
        
        <?php include_once('include/modal_forms/sender_id_modal.php'); ?>
        
  