<?php 
/*include('controller/sender_id_function.php');
include('controller/template_function.php');*/
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
error_reporting(0);
 $user_role=$_SESSION['user_role'];
 ?>
   <link rel="stylesheet" type="text/css" href="assets/css/chosen.css">

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css">
<style type="text/css">
    .dt-buttons
    {

    float: right;
    margin-top: -4%;


    }

    .text-wrap{
    white-space:normal;
}
.width-200{
    width:200px;
}
</style>
<link rel="stylesheet" type="text/css" href="assets/css/jquery.multiselect.css">

         <div class="card mb-3">
            <div class="bg-holder d-none d-lg-block bg-card" style="background-image: url(../assets/img/icons/spot-illustrations/corner-4.png);" ></div>
            <!--/.bg-holder-->
            <div class="card-body position-relative">
              <div class="row">
                <div class="col-lg-8">
                  <h3>#Multimedia Details</h3>
                  
                </div>
                  <div class="col-lg-4">
                 <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create_multimedia_modal" style="margin-left:49%"><i class="fa-solid fa-circle-plus fa-fw" style="margin-right: 8px;"></i>Add Multimedia</button>
                 
                
                </div>
              </div>
            </div>
          </div>



        <div class="row g-3 mb-3">
            
            <div class="col-lg-12">
              <div class="card" >
                
                <div class="card-body">

                  <div id="action_message" style="display:none"></div>

                    
        <div id="tableExample2" data-list='{"valueNames":["name","email","age"],"page":5,"pagination":true}'>
          <div class="table-responsive scrollbar">
            <input type="hidden" name="user_role" value="<?php echo $user_role; ?>" id="user_role">
            <table class="table table-bordered table-striped fs--1 mb-0" id="mulitmedia_list_tbl">
              <thead class="bg-200 text-900">
                <tr>
              
                  <?php
                    $login_user=$_SESSION['user_id'];

                    if($login_user==1 || $login_user==5501)
                    {
                      echo '<th class="sort" data-sort="email">Username</th>';
                    } 
                  ?>         
                  <th class="sort" data-sort="email">File Name</th>
                  <th class="sort" data-sort="email">Voice ID</th>
                  <th class="sort" data-sort="email">K IVR ID</th>
                  <th class="sort" data-sort="email">T IVR ID</th>
                  <th class="sort" data-sort="email">Duration (In Seconds)</th>
                  <th class="sort" data-sort="age" >Status</th>
                  <th class="sort" data-sort="age" >Approved By</th>
                  <th class="sort" data-sort="age" >Date</th> 
                  <th class="sort" data-sort="age">Action</th>
                  

                </tr>
              </thead>
                <tbody id="tbl_body"></tbody>
            
            </table>
          </div>
         
        </div>
                </div>
              </div>
            </div>
        </div>




<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<?php include('include/datatable_js.php');?>


<?php include('include/modal_forms/multimedia_modal.php');?>
<script type="text/javascript" src="assets/js/chosen.jquery.js"></script>
<script src="assets/js/jquery.multiselect.js"></script>
<script src="assets/js/voice_call.js?=<?=time();?>"></script>


