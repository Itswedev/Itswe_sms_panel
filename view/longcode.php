        
   <link rel="stylesheet" type="text/css" href="assets/css/chosen.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css">

         <div class="card mb-3">
            <div class="bg-holder d-none d-lg-block bg-card" style="background-image: url(../assets/img/icons/spot-illustrations/corner-4.png);" ></div>
            <!--/.bg-holder-->
            <div class="card-body position-relative">
              <div class="row">
                <div class="col-lg-4">
                  <h3 id="page_name"># Longcode Details</h3>
                  
                </div>
                  <div class="col-lg-8">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#longcode_modal" id="create_gateway_btn" style="float:right;"><i class="fa-solid fa-circle-plus fa-fw" style="margin-right: 8px;"></i> Add New Longcode </button>
                  </div>
              </div>
            </div>
          </div>
        <div class="row g-3 mb-3">
            
            <div class="col-lg-12">
              <div class="card" >
                
                <div class="card-body">

                  <div id="action_message" style="display:none"></div>

                    
        <div id="tableExample2" data-list='{"valueNames":["name","email","age"],"id="page_name"":5,"pagination":true}'>
          <div class="table-responsive scrollbar">
            <table class="table table-bordered table-striped fs--1 mb-0" id="longcode_tbl">
              <thead class="bg-200 text-900" >
                <tr>
                  
                  <th class="sort" data-sort="email">Username</th>
                  <th class="sort" data-sort="age">Longcode</th>
                  <th class="sort" data-sort="age">End point</th>
                 
                  <th class="sort" data-sort="age">Status</th>
                 
                  <th class="sort" data-sort="age">Create Date</th>
                  
                  <th class="sort" data-sort="age">Action(s)</th>
                </tr>
              </thead>
              <tbody class="gateway_list" id="longcode_list">

              </tbody>
            </table>
          </div>
          <div class="d-flex justify-content-center mt-3"><button class="btn btn-sm btn-falcon-default me-1" type="button" title="Previous" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
            <ul class="pagination mb-0"></ul><button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next" data-list-pagination="next"><span class="fas fa-chevron-right"> </span></button>
          </div>
        </div>
                </div>
              </div>
            </div>
        </div>

<?php include_once('include/modal_forms/longcode_modal.php'); ?>



<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>

<?php include('include/datatable_js.php');?>
<script type="text/javascript" src="assets/js/chosen.jquery.js"></script>
<script src="assets/js/jquery.multiselect.js"></script>
<script type="text/javascript" src="assets/js/longcode.js?=<?=time();?>"></script>