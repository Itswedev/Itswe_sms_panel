
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/sweetalert2.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css">
   

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
                  </div>
                  <div class="card-body">
                    <div class="table-responsive theme-scrollbar">
                      <table class="display" id="sender_id_tbl">
                        <thead>
                          <tr>
                            <th>Username</th>
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

   
    
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js?=<?=time();?>"></script>
        
        <script src="<?php echo $baseURL ; ?>assets/js/datatable/datatables/jquery.dataTables.min.js?<?= time() ; ?>"></script>
    <script src="<?php echo $baseURL ; ?>assets/js/datatable/datatables/datatable.custom.js?<?= time() ; ?>"></script>
    <script src="<?php echo $baseURL ; ?>assets/js/datatable/datatables/datatable.custom1.js?<?= time() ; ?>"></script>
    
        
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js?=<?=time();?>"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>  
    
        <script src="assets/js/form-validation-custom.js?=<?=time();?>"></script>
        <script type="text/javascript" src="assets/js/chosen.jquery.js?=<?=time();?>"></script> 
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>  
       
   
        <?php include_once('include/modal_forms/sender_id_modal.php'); ?>
        <!-- <?php //include_once('include/included_js.php'); ?> -->
        
        <script type="text/javascript" src="assets/js/chosen.jquery.js?=<?=time();?>"></script>

        <script src="assets/js/sender_id_function.js?<?php time(); ?>"></script>
        
  