<?php 
session_start();
    // include('controller/send_job_report_controller.php');

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    
$minDate=date('Y-m-d', strtotime('-90 days', strtotime(date('d-m-Y'))));
$maxDate=date('Y-m-d');


$user_role=$_SESSION['user_role'];
 
?>


          <input type="hidden" id="user_role" value="<?php echo $user_role; ?>">
          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h4 id="page_name">URL Tracking</h4>
                  </div>
                  <div class="card-body">
                  <table border="0" cellspacing="5" cellpadding="5">
                            <tbody>
                                <tr>
                                <td>From&nbsp:&nbsp&nbsp</td>
                                <td>
                                    <input class="form-control datetimepicker" id="frmDate" type="text" placeholder="yyyy-mm-dd"   name="min" aria-label="frmDate" aria-describedby="basic-addon1" style="width:80%;"   /></td>
                                    <!-- <input type="date" id="frmDate" name="min" ></td> -->
                                <td>To&nbsp:&nbsp&nbsp</td>
                                <td>
                                    <input class="form-control datetimepicker" id="toDate" type="text" placeholder="yyyy-mm-dd"   name="max" aria-label="toDate" aria-describedby="basic-addon1" style="width:80%;"/></td>

                        
                            <input type="hidden" value="<?php echo $_SESSION['user_role']; ?>" id="user_role">

                            <?php

                                if($_SESSION['user_role']=='mds_rs' || $_SESSION['user_role']=='mds_ad')
                                {

                            ?>
                          <td>Select Role</td>
                                <td>
                                   <select class="form-control" id="user_role_dropdown" style="width:100%;"><option value="">Select Role</option>
                                    <option value="All">All</option>
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
                                    <i class="fa-solid fa-download fa-fw"></i>
                                    </button>
                                    <span>

                                    <!-- <input type="date" id="toDate" name="max" onChange="searchData()"></td> -->
                            </tr>
                          
                        </tbody></table><br>
                    <div class="table-responsive theme-scrollbar">
                      <table class="display responsive nowrap w-100" id="url_tracking_list">
                        <thead style="text-align:center;background-color:#f4f7f9;">
                          <tr>
                          <?php 
                              if($user_role!='mds_usr')
                              {
                            ?>
                            <th>Username</th>

                            <?php
                              }
                            ?>
                            <th>Job Id</th>
                            <th>Message</th>
                            <th>Campaign Name</th>
                            <th>Date</th>
                            <th>Click count</th>
                          </tr>
                        </thead>
                        <tbody id="url_tracking_data">     
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Zero Configuration  Ends-->
            </div>

       

        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
        <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src="//cdn.datatables.net/plug-ins/1.10.12/sorting/datetime-moment.js"></script>
        <script src="assets/js/url_tracking.js?=<?=time();?>"></script>

        <script>
    document.addEventListener("DOMContentLoaded", function() {
     flatpickr(".datetimepicker", {
       minDate: <?php echo "'".$minDate."'"; ?>,
       maxDate: <?php echo "'".$maxDate."'"; ?>, // Set your minimum date here
       // Set your maximum date here
        enableTime: false,
            dateFormat: "Y-m-d",
            time_24hr: true,
      //       onChange: function(selectedDates, dateStr, instance) {
      //        var fromDate = moment(document.getElementById("frmDate").value, 'YYYY-MM-DD').format('DD-MMM-YYYY');
      //   var toDate = moment(document.getElementById("toDate").value, 'YYYY-MM-DD').format('DD-MMM-YYYY');
      //   if (table) {
      //       table.columns().every(function() {
      //           var column = this;
      //           if (column.header().textContent.trim() == 'Date') {
      //               column.search('').draw(); // Clear previous search
      //               if (fromDate && toDate) {
      //                   // Combine filters for 'from' and 'to' dates
      //                   column
      //                   .search(fromDate + '|' + toDate, true, false)
      //                   .draw();
      //               }
      //           }
      //       });
      //   } else {
      //       console.error("DataTable instance not found.");
      //   }
      // }
     });
   });
</script>

     