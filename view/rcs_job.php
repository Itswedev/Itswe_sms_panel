<?php 
/*session_start();
*/
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
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

<link rel="stylesheet" type="text/css" href="assets/css/vendors/sweetalert2.css">
   

     <div class="row">
         <!-- Zero Configuration  Starts-->
         <div class="col-sm-12">
           <div class="card">
             <div class="card-header">
             <h4>#Job Status : </h4><span style="display:none;" id="page_name">RCS Job</span>
              </div>
              </div>
              </div>
              </div>
   <div class="row g-3 mb-3" id="rcs_job_dtls_download">
    <div class="col-lg-12">

    

    	<div class="card">
    		<div class="card-body">

    		

    			<div class="container">
    				<div class="row">

	    				<div class="col-lg-6">
	    					<div class="mb-3 row">
	    					   	<label for="job_status" class="col-sm-4 col-form-label">Job ID</label>
	    					   	<div class="col-sm-4">
	    					   		
	    					   		<p id="job_status1"><?php echo @$job_id; ?></p>
	    					   	</div>
	    					</div>
							
								<div class="mb-3 row">
								   	<label for="ip_addr" class="col-sm-4 col-form-label">Ip Address</label>
								   	<div class="col-sm-4">
								   		<span id="ip_address"></span>
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
								   	<label for="sms_method" class="col-sm-4 col-form-label">Method</label>
								   		<div class="col-sm-4">
							   	   		<span id="method"></span>
							   	   	</div>
							  	</div>
						
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
								  <table class="table table-bordered table-striped fs--1 mb-0">
	    							<thead>
	    								<tr>
	    									<th>Status</th>
	    									<th>Msg Credit</th>
	    								</tr>
	    							</thead>
	    							<tbody id="msg_status">
	    								
	    							</tbody>
	    						</table>
	    						<!-- <p id="msg_status"></p> -->
	    					</div>
	    					<!-- <p id="failed">failed ----</p> -->
	    					<!-- <p id="delivered">delivered ----</p> -->
	    					<div>

						<figure class="highcharts-figure">
						<div id="container"></div>
						
						</figure>
  

<script type="text/javascript">
 
</script>
	    					  <!-- <canvas id="myChart" style="width: 50%;"></canvas> -->
	    					</div>
	    				</div>

	    			</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-lg-12">
    	<div class="card">
    		<div class="card-body">
    			<div id="action_message" style="display:none"></div>
				<div id="tableExample2" data-list='{"valueNames":["name","email","age"],"page":5,"pagination":true}'>
					<div class="table-responsive scrollbar">
					  <table class="table table-bordered table-striped fs--1 mb-0 table2excel_with_colors" id="rcs_job_details_tbl">
					    <thead class="bg-200 text-900">
					      <tr>
					        <th class="sort" data-sort="name" width="5%">Sr. No.</th>
					        <!-- <th class="sort" data-sort="">Route</th> -->
					        <th class="sort" data-sort="">Mobile</th>
					      <!--   <th class="sort" data-sort="">Circle</th> -->
					        
					        <th class="sort" data-sort="">Bill</th>
					        <th class="sort" data-sort="">Message ID</th>
					        <!-- <th class="sort" data-sort="">Refund</th> -->
					        
					        <th class="sort" data-sort="">Date</th>
					        <th class="sort" data-sort="">Status</th>
				
					        <!-- <th class="sort" data-sort="">Smart</th> -->
					      </tr>
					    </thead>
					    <tbody class="rcs_job" id="rcs_job_details">

					    </tbody>
					  </table>
					</div>
					<div class="d-flex justify-content-center mt-3">
						<button class="btn btn-sm btn-falcon-default me-1" type="button" title="Previous" data-list-pagination="prev">
							<span class="fas fa-chevron-left"></span>
						</button>
					  	<ul class="pagination mb-0"></ul>
					  	<button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next" data-list-pagination="next">
					  		<span class="fas fa-chevron-right"> </span>
					  	</button>
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

  


   <!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js?=<?=time();?>"></script>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js?=<?=time();?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>  

<script src="assets/js/form-validation-custom.js?=<?=time();?>"></script>
<script type="text/javascript" src="assets/js/chosen.jquery.js?=<?=time();?>"></script> 
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>   -->



<script src="assets/js/rcs_job_report.js?=<?=time();?>"></script>

