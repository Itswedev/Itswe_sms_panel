<?php 
/*session_start();
*/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$login_userrole=$_SESSION['user_role'];

	if(isset($_REQUEST['job_id']) && ($_REQUEST['job_id'])!="")
{
	$job_id=$_REQUEST['job_id'];
   echo "<span id='job_id' style='display:none;'>$job_id</span>";
}
	if(isset($_REQUEST['table_name']) && ($_REQUEST['table_name'])!="")
{
	$table_name=$_REQUEST['table_name'];
   echo "<span id='table_name' style='display:none;'>$table_name</span>";
}
	if(isset($_REQUEST['dtlstable']) && ($_REQUEST['dtlstable'])!="")
{
	$dtlstable=$_REQUEST['dtlstable'];
   echo "<span id='dtlstable' style='display:none;'>$dtlstable</span>";
}
if(isset($_REQUEST['job_date']) && ($_REQUEST['job_date'])!="")
{
	$job_date=$_REQUEST['job_date'];
   echo "<span id='job_date' style='display:none;'>$job_date</span>";
}

?>

 
          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card" style="height:700px;">
                  <div class="card-header">
                  <span id="page_name" style="display:none;">Send Job</span>
                  <!-- <span id="">Campaign</span><br> -->
                  <h4># Campaign Status</h4>
                  </div>

                  <div class="modal" tabindex="-1" role="dialog" id="loading_modal">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                      
                        <div class="modal-body">
                        <br>
                        <h4 style="text-align:center;">We Are Processing Your Request <br> Please Wait.....</h4>
                        <span id="loading"><img src="assets/images/loading1.gif" height="10%" width="100%" /></span>
                        </div>
                      
                      </div>
                    </div>
                  </div>

                  
                  <div class="card-body">

                  <input type="hidden" value="<?php echo $login_userrole; ?>" id="login_userrole">
                  
                  <div class="container">
                    <div class="row">

                      <div class="col-lg-6">
                        <div class="mb-3 row">
                            <label for="job_status" class="col-sm-4 col-form-label">Campaign ID  </label>
                            <div class="col-sm-4">
                              
                              <p id="job_status1"><?php echo @$job_id; ?></p>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="campaign_name" class="col-sm-4 col-form-label">Campaign Name</label>
                            <div class="col-sm-4">
                              <span id="campaign_name"></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="sndr_id" class="col-sm-4 col-form-label">Sender Id</label>
                            <div class="col-sm-4">
                              <span id="sender_id"></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="ip_addr" class="col-sm-4 col-form-label">Ip Address</label>
                            <div class="col-sm-4">
                              <span id="ip_address"></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                          <label for="text_id" class="col-sm-4 col-form-label">Text</label>
                            <div class="col-sm-4">
                              <span id="text"></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                          <label for="date" class="col-sm-4 col-form-label">Timestamp</label>
                            <div class="col-sm-4">
                              <span id="timestamp"></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="total_bill" class="col-sm-4 col-form-label">Total Bill</label>
                              <div class="col-sm-4">
                                <span id="total_bill"></span>
                              </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="txt_type" class="col-sm-4 col-form-label">Text Type</label>
                              <div class="col-sm-4">
                                <span id="text_type"></span>
                              </div>
                        </div>
                        <!-- <div class="mb-3 row">
                            <label for="sms_method" class="col-sm-4 col-form-label">Method</label>
                              <div class="col-sm-4">
                                <span id="method"></span>
                              </div>
                        </div> -->
                        <div class="mb-3 row">
                            <label for="sms_method" class="col-sm-4 col-form-label">Sent Through</label>
                              <div class="col-sm-4">
                                <span id="sent_through"></span>
                              </div>
                        </div>
                      <!-- 	<div class="mb-3 row">
                            <label for="smart" class="col-sm-4 col-form-label">Smart</label>
                              <div class="col-sm-4">
                                <span id="smart"></span>
                              </div>
                        </div> -->
                          <!-- <div class="mb-3 row">
                            <label for="smart" class="col-sm-4 col-form-label">Google Verified</label>
                              <div class="col-sm-4">
                                <span id="gvsms"></span>
                              </div>
                        </div> -->
                        <div class="mb-3 row">
                            <label for="dwnld_report" class="col-sm-4 col-form-label">Download Report</label>
                              <div class="col-sm-4">
                              <button type="button" class="btn btn-primary" id="download_report_btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
                            </svg>
                  
                          </button>
                              </div>
                        </div>
                      </div>

                      <div class="col-lg-6">
                      
                        <div>
                          <!-- <table class="table table-bordered table-striped fs--1 mb-0">
                            <thead>
                              <tr>
                                <th>Status</th>
                                <th>Msg Credit</th>
                              </tr>
                            </thead>
                            <tbody id="msg_status">
                              
                            </tbody>
                          </table> -->
                          <!-- <p id="msg_status"></p> -->
                        </div>
                        <!-- <p id="failed">failed ----</p> -->
                        <!-- <p id="delivered">delivered ----</p> -->
                        <div>
                        
                        <div class="card" style="height: 310px;margin-top:15%;">
                                    <div class="card-header">
                                        <h4 class="card-title">Doughnut Chart</h4>
                                    </div>
                                    <div class="card-body">
                                  <div class="chart-point">
                                    <div class="check-point-area">
                                      
                                      <canvas id="doughnut_chart" style="height:200px;width:200%;"></canvas>
                                    </div>
                                    <ul class="chart-point-list">
                                    
                                    </ul>
										              </div>
                                    </div>
                                </div>
                        <!-- old chart comment -->

                      <!-- <figure class="highcharts-figure">
                      <div id="container"></div>
                      
                      </figure> -->
          

                          <!-- <canvas id="myChart" style="width: 50%;"></canvas> -->

                          
                        </div>
                      </div>

                    </div>
    			        </div>

          
                    
                  </div>
                </div>
                <div class="card" style="height:700px;">
    		<div class="card-body">
    			<div id="action_message" style="display:none"></div>
				<div id="tableExample2" data-list='{"valueNames":["name","email","age"],"page":5,"pagination":true}'>
					<div class="table-responsive">
					  <table class="display responsive nowrap w-100" id="send_job_details_tbl">
					  <thead >
					      <tr>
					        <th  data-sort="name" width="5%">Sr. No.</th>
					        <th  data-sort="">Route</th>
					        <th  data-sort="">Mobile</th>
					        <th  data-sort="">Message</th>
					        <th  data-sort="">Chars</th>
					        <th  data-sort="">Bill</th>
					        <th  data-sort="">Message ID</th>
					        <!-- <th  data-sort="">Refund</th> -->
					        <th  data-sort="">Status</th>
					        <th  data-sort="">Sent</th>
					        <th  data-sort="">DLR</th>
					        <th  data-sort="">Err/Stat</th>
                  <th  data-sort="">Gateway Name</th>
					        <!-- <th class="sort" data-sort="">Smart</th> -->
					      </tr>
					    </thead>
					    <tbody class="send_job" id="send_job_details">

					    </tbody>
					  </table>
					</div>
					<!-- <div class="d-flex justify-content-center mt-3">
						<button class="btn btn-sm btn-falcon-default me-1" type="button" title="Previous" data-list-pagination="prev">
							<span class="fas fa-chevron-left"></span>
						</button>
					  	<ul class="pagination mb-0"></ul>
					  	<button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next" data-list-pagination="next">
					  		<span class="fas fa-chevron-right"> </span>
					  	</button>
					</div> -->
				</div>
    		</div>
    	</div>
              </div>
              <!-- Zero Configuration  Ends-->
            </div>


          <!-- Chart ChartJS plugin files -->
    <script src="assets2/vendor/chart-js/chart.bundle.min.js?=<?=time();?>"></script>
    <script src="assets2/js/plugins-init/chartjs-init.js?=<?=time();?>"></script>


        <script src="assets/js/send_job_report.js?=<?=time();?>"></script>