<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
      
$minDate=date('Y-m-d', strtotime('-90 days', strtotime(date('d-m-Y'))));
$maxDate=date('Y-m-d',strtotime('-1 days'));


?>

<style>
    .tb{
        border: 1px solid black;
    }
    div.dataTables_wrapper {
        margin-bottom: 3em;
    }
    .dt-buttons
    {

    float: right;
    margin-top: -4%;

    }

    .ajax-loader {
  visibility: hidden;
  background-color: rgba(255,255,255,0.7);
  position: absolute;
  z-index: +100 !important;
  width: 100%;
  height:100%;
}

.ajax-loader img {
  position: relative;
  top:28%;
  left:38%;
}
</style>

<div class="ajax-loader">
  <img src="assets/images/loading1.gif" class="img-responsive" />
</div>
 
          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Download Center</h4><span id="page_name" style="display:none;">download report</span>  
                  </div>
                  <div class="card-body">
                    <div class="table-responsive theme-scrollbar">
                    <form name="download_report_form" id="download_report_form" method="post">
                        <input type="hidden" name="list_type" value="download_archive_report">
                        <table border="0" cellspacing="5" cellpadding="5">
                            <tbody>
                              <tr>
                              <td>From:</td>
                              <td>To:</td>
                                  <?php
                                    if($_SESSION['user_role']=='mds_rs' || $_SESSION['user_role']=='mds_ad'|| $_SESSION['user_role']=='mds_adm')
                                    {
                                    ?>
                                    <td style="vertical-align: middle;">Select Role</td>
                                    <td><label >Select <span class="role_name">User</span></label></td>
                                    <?php
                                      }
                                  ?>
                                  <td>Mobile </td>
                                  <td>Sender ID:</td>
                              </tr>
                              
                            <tr>
                                
                                <td>
                                    <input class="form-control datetimepicker" id="frmDate" type="date" placeholder="dd-mm-yyyy"  name="frmDate" style="width:85%;"   onChange="searchData_download_report()"/></td>
                                    <!-- <input type="date" id="frmDate" name="min" ></td> -->
                               
                                <td>
                                    <input class="form-control datetimepicker" id="toDate" type="date" placeholder="dd-mm-yyyy" name="toDate" style="width:85%;" onChange="searchData_download_report()"/></td>

                                    <!-- <input type="date" id="toDate" name="max" onChange="searchData()"></td> -->
                                    <input type="hidden" value="<?php echo $_SESSION['user_role']; ?>" id="user_role">

                            <?php
                                if($_SESSION['user_role']=='mds_rs' || $_SESSION['user_role']=='mds_ad'|| $_SESSION['user_role']=='mds_adm')
                                {
                            ?>
                                
                                          <td>
                                            <select class="form-control" id="user_role_dropdown" style="width:85%;"       name="selected_role"><option value="">Select Role</option>
                                              <!-- <option value="All">All</option> -->
                                              <option value="Reseller">Reseller</option>
                                              <option value="User">User</option>
                                            </select>&nbsp;&nbsp;&nbsp;
                                                          
                                          </td> 
                                          <td>
                                              <select class="form-control" id="user_dropdown" name="select_user_id" style="width:85%;margin-left: 10%;"><option value="">test User</option></select>  
                                          </td>
                                <?php
                                  }
                                ?>
                              
                                 <td>
                                            <input type="text" class="form-control" id="mobile_number" style="width:100%;" placeholder="Enter mobile number" name="mobile_number" />
                                        </td>
                                        
                                        <td>
                                            <input type="text" class="form-control" id="sender_id" style="width:100%;" placeholder="Enter sender id" name="sender_id"  />
                                        </td>

                                <td>
                                     <button type="button" class="btn btn-primary" id="search_submit">Search</button> 
                                   </td>
                               </form>
                         
                              
                                <br/>
                          
                            </tr>
                          
                        </tbody></table>

                        <table class="table table-bordered table-striped fs--1 mb-0" id="download_archive_report_tbl">
                        <thead class="bg-200 text-900">
                          <tr>
                                        <!-- <th class="sort w-auto" data-sort="">Sr. No.</th> -->
                                       
                                     
                                 <?php

                                if($_SESSION['user_role']=='mds_rs' || $_SESSION['user_role']=='mds_ad'|| $_SESSION['user_role']=='mds_adm')
                                {

                            ?>
                                <!-- <th class="sort w-auto" data-sort="">User</th> -->

                            <?php } ?>
                                  <th class="sort w-auto" data-sort="">userid</th>
                                  <th class="sort w-auto" data-sort="">Requested Date</th>
                                  <th class="sort w-auto" data-sort="">From Date</th>
                                  <th class="sort w-auto" data-sort="">To Date</th>
                                  <th class="sort w-auto" data-sort="">Status</th>
                                  <th class="sort w-auto" data-sort="">File Name</th>
                                  <th class="sort w-auto" data-sort="">Download</th>
                                </tr>
                        </thead>
                          
                        <tbody class="download_archive_report_list" >

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
       maxDate: <?php echo "'".$maxDate."'"; ?>, // Set your minimum date here
       // Set your maximum date here
        //enableTime: true,
            dateFormat: "Y-m-d",
            time_24hr: true,
     });
   });
</script>
        <script type="text/javascript" src="assets/js/report_test.js?=<?=time();?>"></script>
  </body>
</html>