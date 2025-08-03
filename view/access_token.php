
<link rel="stylesheet" type="text/css" href="assets/css/vendors/sweetalert2.css">
   
 
     <div class="row">
         <!-- Zero Configuration  Starts-->
         <div class="col-sm-12">
           <div class="card">
             <div class="card-header">
               <h4>Access Token</h4>
               <button id="gradientButtons1" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-circle-plus fa-fw" style="margin-right: 8px;"></i>Generate Token</button>
             </div>
             <div class="card-body">
               <div class="table-responsive theme-scrollbar">
                 <table class="display" id="access_token_tbl">
                   <thead style="background-color:#f4f7f9;">
                     <tr>
                       <th>Username</th>
                       <th>Client ID</th>
                       <th>Client Secret</th>
                       <th>Bot Type</th>
                       <th>Date</th>
                       <!--<th>Action</th>-->
                     </tr>
                   </thead>
                   <tbody class="access_token_list">

                           </tbody>
                 </table>
               </div>
             </div>
           </div>
         </div>
         <!-- Zero Configuration  Ends-->
       </div>
  


   <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js?=<?=time();?>"></script>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js?=<?=time();?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>  

<script src="assets/js/form-validation-custom.js?=<?=time();?>"></script>
<script type="text/javascript" src="assets/js/chosen.jquery.js?=<?=time();?>"></script> 
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>  


<?php include_once('include/modal_forms/access_token_modal.php'); ?>
<!-- <?php //include_once('include/included_js.php'); ?> -->
<script type="text/javascript" src="assets/js/chosen.jquery.js?=<?=time();?>"></script>

<script src="assets/js/access_token.js?=<?=time();?>"></script>
