<?php
//include('controller/manage_gateway_controller.php');
$user_role=$_SESSION['user_role'];
 ?>
<div class="page-body">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css">

<link rel="stylesheet" type="text/css" href="assets/css/jquery.multiselect.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css" />
         <div class="card mb-3">
            <div class="bg-holder d-none d-lg-block bg-card" style="background-image: url(../assets/img/icons/spot-illustrations/corner-4.png);" ></div>
            <!--/.bg-holder-->
            <div class="card-body position-relative">
              <div class="row">
                <div class="col-lg-4">
                  <h3><span id="page_name" style="display:none;">url_tracking_dtls</span>URL Tracking Details</h3>

                </div>
                  <div class="col-lg-8">
                <span style="float:right;">
                                    <button type="button" class="btn btn-primary" id="download_url_tracking_btn">Download
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
                                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
                                    </svg>

                                    </button>
                                    <span>

                 <!--  <a class='btn mb-2 btn-primary' href='dashboard.php?page=add_new_user' type='button' aria-haspopup='true' aria-expanded='false' style="float:right;">Add New User</a> -->
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

            <table class="table table-bordered table-striped fs--1 mb-0" id="url_tracking_dtls_list">
              <thead class="bg-200 text-900" style='text-align:center;'>
                <tr>


                  <th class="sort" data-sort="age">Mobile Number</th>
                  <th class="sort" data-sort="email">Browser</th>
                  <th class="sort" data-sort="email">IP Address</th>
                  <th class="sort" data-sort="email">City</th>
                   <th class="sort" data-sort="age">Click Count</th>

                   <th class="sort" data-sort="email">Clickable Date</th>
                </tr>
              </thead>
              <tbody id="url_tracking_dtls_data"></tbody>
            </table>
          </div>

        </div>
                </div>
              </div>
            </div>
        </div>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<?php include('include/datatable_js.php');?>



<script src="assets/js/url_tracking.js"></script>

</div>