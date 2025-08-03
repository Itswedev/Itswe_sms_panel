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


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css">

<div class="card mb-3">
		<?php 
			// echo $_SESSION['rp_id']; 
			// echo $id;
		?>

    <div class="bg-holder d-none d-lg-block bg-card" style="background-image: url(../assets/img/icons/spot-illustrations/corner-4.png);" ></div>
    <!--/.bg-holder-->
    <div class="card-body position-relative">
      <div class="row">
        <div class="col-lg-4">
          <h3 id="page_name">Today Voice Report</h3>  
        </div>
        <div class="col-lg-8">
        </div>      
      </div>
    </div>
</div>

<style>
	.tb{
		border: 1px solid black;
	}
	.dt-center
	{
		vertical-align:middle;
	}
</style>

<!-- <div class="row g-3 mb-3">
    <div class="col-lg-12">

    	<div class="card">
    		<div class="card-body">

    			<div class="container">
    			  
    			</div>
    			
    		</div>
    	</div>

    </div>
</div> -->

<div class="row g-3 mb-3">
    <div class="col-lg-12">
    	<div class="card">
    		<div class="card-body">
    			<div id="action_message" style="display:none"></div>
				<div id="tableExample2" data-list='{"valueNames":["name","email","age"],"page":5,"pagination":true}'>
					<div class="table-responsive scrollbar">
						<input type="hidden" id="report_type" value="<?php echo $report_type; ?>" >
						<input type="hidden" id="user_role" value="<?php echo $user_role; ?>" >
						<input type="hidden" id="uid" value="<?php echo $uid; ?>" >

						<input type="hidden" id="selected_role" value="<?php echo $selected_role; ?>" >
				<!-- 		<table border="0" cellspacing="5" cellpadding="5">
        <tbody><tr>
            <td>From:</td>
            <td><input type="date" id="frmDate" name="min" onChange="searchData()"></td>
            <td>To:</td>
            <td><input type="date" id="toDate" name="max" onChange="searchData()"></td>
        </tr>
        
    </tbody></table> -->
					  <table class="table table-bordered table-striped fs--1 mb-0" id="today_report_tbl">
					    <thead class="bg-200 text-900">
					      <tr>
					        <!-- <th class="sort" data-sort="name" width="5%">Sr. No.</th> -->
					        <th class="sort" data-sort="">Caller ID</th>
					        <th class="sort" data-sort="">Mobile</th>
					        <th class="sort" data-sort="">Username</th>
					       <th class="sort" data-sort="">Voice File</th>
					        <th class="sort" data-sort="">Bill</th>
					        <th class="sort" data-sort="">Job ID</th>
					         <th class="sort" data-sort="">Call Duration</th>
					        <!-- <th class="sort" data-sort="">Refund</th> -->
					        <th class="sort" data-sort="">Status</th>
					        <th class="sort" data-sort="">Date</th>
					        <th class="sort" data-sort="">Call Ans Time</th>
					        <!-- <th class="sort" data-sort="">Smart</th>  -->
					      </tr>
					    </thead>
					    <tbody class="today_report_list" id="today_report_list">

					    </tbody>
					   
					  </table>
					</div>
				<!-- 	<div class="d-flex justify-content-center mt-3">
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
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<?php include('include/datatable_js.php');?>
<script type="text/javascript" src="assets/js/voice_call.js?=<?=time();?>"></script>