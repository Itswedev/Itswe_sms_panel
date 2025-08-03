<?php 


/*
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);*/


        
$minDate=date('Y-m-d', strtotime('-90 days', strtotime(date('d-m-Y'))));
$maxDate=date('Y-m-d',strtotime('-2 days'));


?>


 
          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header"> 
                    <h4 id="page_name">Scheduled Report</h4>
                    <input type="hidden" value="<?php echo $_SESSION['user_role']; ?>" id="user_role">

                    
                          </div>

                  <div class="modal" tabindex="-1" role="dialog" id="loading_modal">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content" style="margin-top: 45%;">
                      
                        <div class="modal-body">
                          <br>
                          <h4 style="text-align:center;">We Are Processing Your Request <br> Please Wait.....</h4>
                        <span id="loading"><img src="assets/images/loading1.gif" height="10%" width="100%" /></span>
                        </div>
                      
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                  <?php

if($_SESSION['user_role']=='mds_rs' || $_SESSION['user_role']=='mds_ad')
{

?>
<div class="col-lg-4" style="float:left;">
  <label for="date">Select Role</label>
         <select class="form-control" id="user_role_dropdown" style="width:80%;"><option value="">Select Role</option>
          <!-- <option value="All">All</option> -->
          <option value="Reseller">Reseller</option>
          <option value="User">User</option>
        </select>

</div> 
<div class="col-lg-3" style="float:left;">
 <label for="date">Select <span class="role_name">User</span></label>
         <select class="form-control" id="user_dropdown" style="width:80%;"><option value="">Select User</option></select>
</div> 
<?php
}
else if($_SESSION['user_role']=='mds_adm')
{

?>
<div class="col-lg-3" style="float:left;">
  <label for="date">Select Role</label>
         <select class="form-control" id="user_role_dropdown" style="width:80%;"><option value="">Select Role</option>
          <!-- <option value="All">All</option> -->
          <option value="All">All</option>
          <option value="Admin">Admin</option>
          <option value="Reseller">Reseller</option>
          <option value="User">User</option>
        </select>

</div> 
<div class="col-lg-3" style="float:left;">
 <label for="date">Select <span class="role_name">User</span></label>
         <select class="form-control" id="user_dropdown" style="width:80%;"><option value="">Select User</option></select>
</div> 
<?php
}

?>


<table border="0" cellspacing="5" cellpadding="5">
                            <tbody><tr>
                                                           
                            <td><label style="margin-top:75%;">From:&nbsp;&nbsp;</label></td>
                                <td>
                                    <input class="form-control datetimepicker" id="frmDate" type="text" placeholder="dd-mm-yyyy"   name="min" aria-label="frmDate" aria-describedby="basic-addon1" style="width:80%; margin-top:16%;"   onChange="searchData()"/>
                                    <!--  <input type="date" id="frmDate" name="min" > --></td> 
                                    <td><label style="margin-top:130%;">To:&nbsp;&nbsp;</label></td>
                                <td>
                                    <input class="form-control datetimepicker" id="toDate" type="text" placeholder="dd-mm-yyyy"   name="max" aria-label="toDate" aria-describedby="basic-addon1" style="width:80%;margin-top:16%;" onChange="searchData()"/>
                                     <!-- <input type="date" id="toDate" name="max" onChange="searchData()"> --></td> 

                                     <!-- <input type="hidden" value="<?php //echo $_SESSION['user_role']; ?>" id="user_role"> -->

                           <!--  <?php

                                if($_SESSION['user_role']=='mds_rs' || $_SESSION['user_role']=='mds_ad')
                                {

                            ?>
                                
                                <?php
                                  }

                                ?> -->

                                <span style="float:right;">
                                    <!-- <button type="button" class="btn btn-primary" id="download_report_btn">Download -->
                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16"> -->
                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
                                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
                                    </svg>
                
                                    </button>
                                    <span>

                            </tr>
                          
                        </tbody></table> 
                                  <br/>
                    <div class="table-responsive theme-scrollbar">
                      <table class="display responsive nowrap w-100" id="scheduled_report_tbl">
                        <thead style="background-color:#f4f7f9;">
                        <tr>
                            <th class="sort" data-sort="">Sr.No</th>
                          
                            <th class="sort" data-sort="">User</th>
                             <th class="sort" data-sort="">Message Id</th>
                              <th class="sort" data-sort="">Message</th>
                              <th class="sort" data-sort="">Created Date</th>
                            <th class="sort" data-sort="">Sent Date</th>
                            <th class="sort" data-sort="">Bill Count</th>
                            <th class="sort" data-sort="">numbers count</th>
                            <th class="sort" data-sort="">Senderid</th>
                            <th class="sort" data-sort="">Status</th>
                            <th class="sort" data-sort="">Error Code</th>
                          
                            <th class="sort" data-sort="">Action</th>
                            
                          </tr>
                        </thead>
                        <tbody class="schedule_report">                   
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Zero Configuration  Ends-->
            </div>

        <script>
    document.addEventListener("DOMContentLoaded", function() {
     flatpickr(".datetimepicker", {
       minDate: <?php echo "'".$minDate."'"; ?>,
      //  maxDate: <?php echo "'".$maxDate."'"; ?>, // Set your minimum date here
       // Set your maximum date here
       enableTime: true,
          dateFormat: "Y-m-d h:i K",
            time_24hr: false,
     });
   });
</script>
<?php include_once('include/modal_forms/reschedule_modal.php');
                  ?>
    <script type="text/javascript" src="assets/js/chosen.jquery.js?=<?=time();?>"></script>
    <script type="text/javascript" src="assets/js/report.js?=<?=time();?>"></script>
  </body>
</html>