
<div class="page-body">
          <!-- Container-fluid starts-->
          <div class="container-fluid default-dashboard"> 
          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h4 id="page_name">RCS MIS Report</h4>
                    <input type="hidden" value="<?php echo $_SESSION['user_role']; ?>" id="user_role">
                    <?php

if($_SESSION['user_role']=='mds_rs' || $_SESSION['user_role']=='mds_ad')
{

?>
<div class="col-lg-4">
  <label for="date">Select Role</label>
         <select class="form-control" id="user_role_dropdown_mis" style="width:80%;"><option value="">Select Role</option>
          <option value="All">All</option>
          <option value="mds_rs">Reseller</option>
          <option value="mds_usr">User</option>
        </select>

</div> 
<div class="col-lg-4">
 <label for="date">Select <span class="role_name">User</span></label>
         <select class="form-control" id="user_dropdown_mis" style="width:80%;"><option value="">Select User</option></select>
</div> 
<?php
}
        else if($_SESSION['user_role']=='mds_adm')
{

?>

<div class="col-lg-4">
 <label for="date">Select <span class="role_name">User</span></label>
         <select class="form-control" id="user_dropdown_list" style="width:80%;"><option value="">Select User</option></select>
</div> 
<?php
}

?>

                  </div>
                  <div class="card-body">
                  <div class="row g-3 mb-3">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div id="action_message" style="display:none"></div>


  <ul class="nav nav-pills" id="pill-myTab" role="tablist">
  <li class="nav-item"><a class="nav-link active" id="pill-home-tab" data-bs-toggle="tab" href="#pill-tab-home" role="tab" aria-controls="pill-tab-home" aria-selected="true">Daily</a></li>
  <li class="nav-item"><a class="nav-link" id="pill-profile-tab" data-bs-toggle="tab" href="#pill-tab-profile" role="tab" aria-controls="pill-tab-profile" aria-selected="false">Monthly</a></li>
  <li class="nav-item"><a class="nav-link" id="pill-contact-tab" data-bs-toggle="tab" href="#pill-tab-contact" role="tab" aria-controls="pill-tab-contact" aria-selected="false">Yearly</a></li>
  <!-- <li class="nav-item"><a class="nav-link" id="pill-senderid-tab" data-bs-toggle="tab" href="#pill-tab-senderid" role="tab" aria-controls="pill-tab-senderid" aria-selected="false">Senderid Wise</a></li>
  <li class="nav-item"><a class="nav-link" id="pill-template-tab" data-bs-toggle="tab" href="#pill-tab-template" role="tab" aria-controls="pill-tab-template" aria-selected="false">Template wise Summary</a></li> -->
  <li class="nav-item"><a class="nav-link" id="pill-custom-tab" data-bs-toggle="tab" href="#pill-tab-custom" role="tab" aria-controls="pill-tab-custom" aria-selected="false">Customized Summary</a></li>
</ul>
<div class="tab-content border p-3 mt-3" id="pill-myTabContent">
  <div class="tab-pane fade show active" id="pill-tab-home" role="tabpanel" aria-labelledby="home-tab" style="overflow-x:auto;">     
  <button type="button" class="btn btn-primary" id="download_daily_report_btn" onclick="downloadTableAsCSV('daily_mis_report_tbl', 'daily_mis_report.csv')">Download
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
                                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
    </svg>      
  </button>
  <table class="table table-bordered table-striped fs--1 mb-0" id="daily_mis_report_tbl">
                            <thead>
                             
                            </thead>
                            <tbody id="daily_mis_report"></tbody>
                            
  </table>
    </div>
  <div class="tab-pane fade" id="pill-tab-profile" role="tabpanel" aria-labelledby="profile-tab" style="overflow-x:auto;">
  <button type="button" class="btn btn-primary" id="download_monthly_report_btn" onclick="downloadTableAsCSV('monthly_mis_tbl', 'monthly_mis_report.csv')">Download
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
                                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
    </svg>      
  </button>
            <table class="table table-bordered table-striped fs--1 mb-0" id="monthly_mis_tbl">
                            <thead>
                              
                            </thead>
                            <tbody id="monthly_mis_report">
                            </tbody>
            </table>
  </div>
  <div class="tab-pane fade" id="pill-tab-contact" role="tabpanel" aria-labelledby="contact-tab" style="overflow-x:auto;">
  <button type="button" class="btn btn-primary" id="download_daily_report_btn" onclick="downloadTableAsCSV('yearly_mis_report_tbl', 'yearly_mis_report.csv')">Download
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
                                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
    </svg>      
  </button>
            <table class="table table-bordered table-striped fs--1 mb-0" id="yearly_mis_report_tbl">
                            <thead>
                              
                            </thead>
                            <tbody id="yearly_mis_report">
                            </tbody>
            </table>
  </div>

   <!-- <div class="tab-pane fade" id="pill-tab-senderid" role="tabpanel" aria-labelledby="contact-tab" style="overflow-x:auto;">
   <button type="button" class="btn btn-primary" id="download_daily_report_btn" onclick="downloadTableAsCSV('senderidwise_mis_report_tbl', 'senderidwise_mis_report.csv')">Download
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
                                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
    </svg>      
  </button>
            <table class="table table-bordered table-striped fs--1 mb-0" id="senderidwise_mis_report_tbl">
                            <thead>
                              
                            </thead>
                            <tbody id="senderid_mis_report">
                            </tbody>
            </table>
  </div> -->
  <!-- <div class="tab-pane fade" id="pill-tab-template" role="tabpanel" aria-labelledby="contact-tab" style="overflow-x:auto;">
  <button type="button" class="btn btn-primary" id="download_daily_report_btn" onclick="downloadTableAsCSV('templatewise_mis_report_tbl', 'templatewise_mis_report.csv')">Download
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
                                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
    </svg>      
  </button>
            <table class="table table-bordered table-striped fs--1 mb-0" id="templatewise_mis_report_tbl">
                            <thead>
                              
                            </thead>
                            <tbody id="template_mis_report">
                            </tbody>
            </table>
  </div> -->
  <div class="tab-pane fade" id="pill-tab-custom" role="tabpanel" aria-labelledby="contact-tab" style="overflow-x:auto;">
  <button type="button" class="btn btn-primary" id="download_daily_report_btn" onclick="downloadTableAsCSV('customize_mis_report_tbl', 'customize_mis_report.csv')">Download
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
                                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
    </svg>      
  </button>
                            <form name="custom_mis_form" id="custom_mis_form" method="post">
                                <table border="0" cellspacing="5" cellpadding="5">
                            <tbody>
                                <tr>
                                <td>From:</td>
                                <td>
                                    <input class="form-control datetimepicker" id="frmDate" type="text" placeholder="yyyy-mm-dd" name="min" style="width:80%;" /></td>
                                    <!-- <input type="date" id="frmDate" name="min" ></td> -->
                                <td>To:</td>
                                <td>
                                    <input class="form-control datetimepicker" id="toDate" type="text" placeholder="yyyy-mm-dd" name="max" style="width:80%;"/></td>

                                <td>
                                     <input type="hidden"  name="list_type" value="custom_report">
                                     <input type="hidden"  name="selected_userid" id="selected_userid_dt" value="">
                                     <input type="hidden"  name="selected_user_role" id="selected_user_role_dt" value="">
                                     
                                     <button type="button" class="btn btn-primary" id="search_custom_submit">Search</button> 
                                   </td>


                               </form>
                      

                           
                                    <!-- <input type="date" id="toDate" name="max" onChange="searchData()"></td> -->
                            </tr>
                          
                        </tbody></table>

            <table class="table table-bordered table-striped fs--1 mb-0" id="customize_mis_report_tbl">
                            <thead>
                              
                            </thead>
                            <tbody id="custom_mis_report">
                            </tbody>
            </table>
  </div>
</div>
		
            </div>
        </div>
    </div>
</div>
                  </div>
                </div>
              </div>
              <!-- Zero Configuration  Ends-->
            </div>
          </div>
          <!-- Container-fluid Ends-->
        </div>
        <script>
    document.addEventListener("DOMContentLoaded", function() {
     flatpickr(".datetimepicker", {
       minDate: <?php echo "'".$minDate."'"; ?>, // Set your minimum date here
       // Set your maximum date here
        //enableTime: true,
            dateFormat: "Y-m-d",
            time_24hr: true,
     });
   });
</script>
        <script type="text/javascript" src="assets/js/chosen.jquery.js?=<?=time();?>"></script>
        <script src="assets/js/rcs_mis_report.js?=<?=time();?>"></script>
        