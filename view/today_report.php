<?php 
/*session_start();*/
/*	include('controller/send_job_report_controller.php');*/
/*
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
*/
	if(isset($_REQUEST['report_type']))
	{
		$report_type=$_REQUEST['report_type'];
	}
	else
	{
		$report_type='total';
	}



	if(isset($_REQUEST['user_role']))
	{
		$user_role=$_REQUEST['user_role'];
	}
	else
	{
		$user_role='';
	}


	if(isset($_REQUEST['selected_role']))
	{
		$selected_role=$_REQUEST['selected_role'];
	}
	else
	{
		$selected_role='';
	}

	if(isset($_REQUEST['uid']))
	{
		$uid=$_REQUEST['uid'];
	}
	else
	{
		$uid='';
	}

	
?>

          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h4 id="page_name">Today Report</h4>
					<span style="float:left;">
                                    <button type="button" class="btn btn-primary" id="download_today_report_btn">Download
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
                                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
                                    </svg>
                
                                    </button>
                                    <span>
                    <input type="hidden" id="report_type" value="<?php echo $report_type; ?>" >
						<input type="hidden" id="user_role" value="<?php echo $user_role; ?>" >
						<input type="hidden" id="uid" value="<?php echo $uid; ?>" >

						<input type="hidden" id="selected_role" value="<?php echo $selected_role; ?>" >
                  </div>
                  <div class="card-body">
                    <div class="table-responsive theme-scrollbar">
                      <table class="display" id="today_report_tbl">
                        <thead style="background-color:#f4f7f9;">
                        <tr>
					        <!-- <th class="sort" data-sort="name" width="5%">Sr. No.</th> -->
					        <th >Route</th>
					        <th >Mobile</th>
							<th >Sender ID</th>
					        <th >Username</th>

					        <th >Chars</th>
					        <th >Bill</th>
					        <th >Job ID</th>
							<th >Gateway Name</th> 
					         <th >Message</th>
					        <!-- <th >Refund</th> -->
					        <th >Status</th>
					        <th >Sent At</th>
					        <th >DLR Time</th>
					        <th >TLV</th>
							
					        <th >Error Code</th>
					        
					      </tr>
                        </thead>
                        <tbody id="today_report_list">                    
                          
                          
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Zero Configuration  Ends-->
            </div>
<!-- Datatable button to download report -->
	<script src="<?php echo $baseURL ; ?>assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo $baseURL ; ?>assets/js/datatable/datatable-extension/dataTables.buttons.min.js"></script>
    <script src="<?php echo $baseURL ; ?>assets/js/datatable/datatable-extension/jszip.min.js"></script>
    <script src="<?php echo $baseURL ; ?>assets/js/datatable/datatable-extension/buttons.bootstrap4.min.js"></script>
    <script src="<?php echo $baseURL ; ?>assets/js/datatable/datatable-extension/buttons.html5.min.js"></script>

    <script type="text/javascript" src="assets/js/chosen.jquery.js?=<?=time();?>"></script>
    <script type="text/javascript" src="assets/js/report.js?=<?=time();?>"></script>
  </body>
</html>