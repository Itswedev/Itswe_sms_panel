
<?php

/*include('include/connection.php');
require('controller/classes/ssp.class.php');
include('include/config.php');*/
?>


<link rel="stylesheet" type="text/css" href="assets/css/chosen.css">
<style type="text/css">
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
  <img src="assets/images/loading_report.gif" class="img-responsive" />
</div>


<div class="card mb-3">
    <div class="bg-holder d-none d-lg-block bg-card" style="background-image: url(../assets/img/icons/spot-illustrations/corner-4.png);" ></div>
    <!--/.bg-holder-->
    <div class="card-body position-relative">
      <div class="row">
        <div class="col-lg-4">
          <h3 id="page_name">Today Voice Summary Report</h3>  
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
                     <select class="form-control" id="user_role_dropdown" style="width:80%;"><option value="">Select Role</option>
                      <!-- <option value="All">All</option> -->
                      <option value="All">All</option>
                      <option value="Admin">Admin</option>
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

        ?>

      </div>
     
    </div>
</div>

<style>
	.tb{
		border: 1px solid black;
	}
</style>


<div class="row g-3 mb-3">
    <div class="col-lg-12">
    	<div class="card">
    		<div class="card-body">
    			<div id="action_message" style="display:none"></div>
				<div id="tableExample2" data-list='{"valueNames":["name","email","age"],"page":5,"pagination":true}'>
					<div class="table-responsive scrollbar">
					  <table class="table table-bordered table-striped fs--1 mb-0">
					    <thead class="bg-200 text-900">
					      <tr>
			
					      </tr>
					    </thead>
					    <tbody id="today_summary_list"></tbody>

					  </table>
					</div>
					
				</div>
    		</div>
    	</div>
    </div>
</div>
<script type="text/javascript" src="assets/js/chosen.jquery.js?=<?=time();?>"></script>
<script type="text/javascript" src="assets/js/voice_call.js?=<?=time();?>"></script>
