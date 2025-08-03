<?php 
session_start();
    // include('controller/send_job_report_controller.php');

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
   
$minDate=date('Y-m-d', strtotime('-90 days', strtotime(date('d-m-Y'))));

$maxDate=date('Y-m-d');

?>
 
          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h4 id="page_name" style="display:none;">RCS Jobs</h4>
                    <h4>RCS Reports</h4>
                  </div>
                  <div class="card-body">
                  <table border="0" cellspacing="5" cellpadding="5">
                            <tbody>
                                <tr>
                                <td>From&nbsp:&nbsp&nbsp</td>
                                <td>
                                    <input class="form-control datetimepicker" id="frmDate" type="text" placeholder="yyyy-mm-dd"   name="min" aria-label="frmDate" aria-describedby="basic-addon1" style="width:80%;"   onChange="searchData_report()"/></td>
                                    <!-- <input type="date" id="frmDate" name="min" ></td> -->
                                <td>To&nbsp:&nbsp&nbsp</td>
                                <td>
                                    <input class="form-control datetimepicker" id="toDate" type="text" placeholder="yyyy-mm-dd"   name="max" aria-label="toDate" aria-describedby="basic-addon1" style="width:80%;" onChange="searchData_report()"/></td>

                        
                        
                            <input type="hidden" value="<?php echo $_SESSION['user_role']; ?>" id="user_role">

                            <?php

                                if($_SESSION['user_role']=='mds_rs' || $_SESSION['user_role']=='mds_ad')
                                {

                            ?>
                                <td>Select Role</td>
                                <td>
                                    <select class="form-control" id="user_role_dropdown" style="width:100%;"><option value="">Select Role</option>
                                      <!-- <option value="All">All</option> -->
                                      <option value="Reseller">Reseller</option>
                                      <option value="User">User</option>
                                    </select>
                                   
                                </td>
                                 <td><label >Select <span class="role_name">User</span></label></td>
                                <td>
                                    <select class="form-control" id="user_dropdown" style="width:100%;"><option value="">Select User</option></select>  
                                </td>
        <?php
          }

        ?>
                                    <span style="float:right;">
                                    <button type="button" class="btn btn-primary" id="download_report_btn">Download
                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
                                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
                                    </svg> -->
                                    <i class="fa-solid fa-download fa-fw" style="margin-left: 8px;"></i> 
                                    </button>
                                    <span>

                                    <!-- <input type="date" id="toDate" name="max" onChange="searchData()"></td> -->
                            </tr>
                          
                        </tbody></table><br>
                    <div class="table-responsive theme-scrollbar">
                      <table class="display" id="rcs_report_tbl">
                        <thead style="background-color:#f4f7f9;">
                          <tr>
                          <th class="sort w-auto" data-sort="">Sr. No.</th>
                                        <th class="sort w-auto" data-sort="">Job Id</th>
                                        <th class="sort w-auto" data-sort="">Date</th>
                                        
                                        <th class="sort w-auto" data-sort="">User</th>
                                      
                                        <th class="sort" data-sort="" width="35%">Template Name</th>
                                        <th class="sort w-auto" data-sort="">Bill Credit</th>
                                        <th class="sort w-auto" data-sort="">Numbers Count</th>
                            <!--<th>Delievry Count</th>-->
                          </tr>
                        </thead>
                        <tbody class="rcs_job_summary" id="rcs_job_summary">     
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
       minDate: <?php echo "'".$minDate."'"; ?>, // Set your minimum date here
       maxDate: <?php echo "'".$maxDate."'"; ?>, // Set your maximum date here
       dateFormat: "Y-m-d", // Set the desired date format
     });
   });
</script>
        <script src="assets/js/rcs_job_report.js?=<?=time();?>"></script>