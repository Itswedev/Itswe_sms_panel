<style>
td{
   text-align:center;
  }
  </style>
          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h4 id="page_name">Today Summary Report</h4>
                    <button type="button" class="btn btn-primary" id="download_daily_report_btn" onclick="downloadTableAsCSV('basic-1', 'Today_summary_report.csv')" style="float:right; margin-top:2.2%">Download
                      <!-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                                      <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
                                                      <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
                      </svg>       -->
                    <i class="fa-solid fa-download fa-fw"></i>
                    </button>
                    <div class="modal" tabindex="-1" role="dialog" id="loading_modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="margin-top: 45%;">
     
      <div class="modal-body">
        <br>
        <h4 style="text-align:center;">We Are Processing Your Request <br> Please Wait.....</h4>
       <span id="loading"><img src="assets/images/loading1.gif" height="10%" width="50%" /></span>
      </div>
     
    </div>
  </div>
</div>
                    <input type="hidden" value="<?php echo $_SESSION['user_role']; ?>" id="user_role">
                    <?php

        	if($_SESSION['user_role']=='mds_rs' || $_SESSION['user_role']=='mds_ad')
        	{

        ?>
          <div class="col-lg-4">
        	  <label for="date">Select Role</label>
                     <select class="form-control" id="user_role_dropdown" style="width:80%;"><option value="">Select Role</option>
                      <!-- <option value="All">All</option> -->
                      <option value="Reseller">Reseller</option>
                      <option value="User">User</option>
                    </select>

        </div> 
        <div class="col-lg-4">
        	 <label for="date">Select <span class="role_name">User</span></label>
                     <select class="form-control" id="user_dropdown" style="width:80%;"><option value="">Select User</option></select>
        </div> 
        <?php
          }
					else if($_SESSION['user_role']=='mds_adm')
        	{

        ?>
          <div class="col-lg-4">
        	  <label for="date">Select Role</label>
                     <select class="form-control" id="user_role_dropdown" style="width:80%;border-radius: 20px;border-color: #5f9ea0;"><option value="">Select Role</option>
                      <!-- <option value="All">All</option> -->
                      <option value="All">All</option>
                      <option value="Admin">Admin</option>
                      <option value="Reseller">Reseller</option>
                      <option value="User">User</option>
                    </select>

        </div> 
        <div class="col-lg-4">
        	 <label for="date">Select <span class="role_name">User</span></label>
                     <select class="form-control" id="user_dropdown" style="width:80%;border-radius: 20px;border-color: #5f9ea0;"><option value="">Select User</option></select>
        </div> 
        <?php
          }

        ?>
 
            </div>
             
                  <div class="card-body">

                    <div class="table-responsive theme-scrollbar">
                      <table class="table table-bordered verticle-middle table-responsive-sm">
                        <thead>
                          
                        </thead>
                        <tbody id="today_summary_list">                    
                          
                          
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Zero Configuration  Ends-->
            </div>
    <script type="text/javascript" src="assets/js/chosen.jquery.js?=<?=time();?>"></script>
    <script type="text/javascript" src="assets/js/report.js?=<?=time();?>"></script>
  </body>
</html>