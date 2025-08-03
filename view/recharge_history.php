
<link rel="stylesheet" type="text/css" href="assets/css/vendors/sweetalert2.css">
   
   <div class="page-body">
   <div class="card mb-3">
            <div class="bg-holder d-none d-lg-block bg-card" style="background-image: url(../assets/img/icons/spot-illustrations/corner-4.png);" ></div>
            <!--/.bg-holder-->
            <div class="card-body position-relative">
              <div class="row">
                <div class="col-lg-8">
                  <h3><span id="page_name">Recharge History</span></h3>
                  
                </div>
                  <div class="col-lg-4">
                  	<?php
                  	$user_role=$_SESSION['user_role'];
                  	if($user_role!='mds_usr')
                  	{
                  	?>

                <!--  <a  href="dashboard.php?page=add_remove_credits" class="btn btn-primary" id="add_credit_debit_btn">Add Credit / Debit</a> -->
                 <?php 
               }
                  ?>
                </div>
              </div>
            </div>
          </div>



        <div class="row g-3 mb-3">
            
            <div class="col-lg-12">
              <div class="card" >
                
                <div class="card-body">

                  <div id="action_message" style="display:none"></div>

        <ul class="nav nav-pills" id="pill-myTab" role="tablist">
  <li class="nav-item"><a class="nav-link active" id="pill-home-tab" data-bs-toggle="tab" href="#pill-tab-home" role="tab" aria-controls="pill-tab-home" aria-selected="true">Others</a></li>
  <li class="nav-item"><a class="nav-link" id="pill-self-tab" data-bs-toggle="tab" href="#pill-tab-self" role="tab" aria-controls="pill-tab-self" aria-selected="false">Self</a></li>
  
</ul>

<div class="tab-content border p-3 mt-3" id="pill-myTabContent">


  <div class="tab-pane fade show active" id="pill-tab-home" role="tabpanel" aria-labelledby="home-tab" style="overflow-x:auto;">     
				<div id="tableExample2" data-list='{"valueNames":["name","email","age"],"page":5,"pagination":true}'>
				  <div class="table-responsive scrollbar">
				    <table class="display" id="recharge_history_tbl">
				      <thead class="bg-200 text-900">
				        <tr>
				          
				           <th class="sort" data-sort="age">Date</th>
				           <th class="sort" data-sort="age">Username</th>
				          <th class="sort" data-sort="email">Route</th>
				          <th class="sort" data-sort="age">Credit Type</th>
				          <th class="sort" data-sort="age">Added Bal.</th>
				          <!-- <th class="sort" data-sort="age">New Bal.</th> -->
				          <th class="sort" data-sort="age">Remark</th>
				         
				         
				        </tr>
				      </thead>
				      <tbody class="recharge_history_list">

				      </tbody>
				    </table>
				  </div>
				  <div class="d-flex justify-content-center mt-3"><button class="btn btn-sm btn-falcon-default me-1" type="button" title="Previous" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
				    <ul class="pagination mb-0"></ul><button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next" data-list-pagination="next"><span class="fas fa-chevron-right"> </span></button>
				  </div>
				</div>
			</div>




  		<div class="tab-pane fade" id="pill-tab-self" role="tabpanel" aria-labelledby="self-tab" style="overflow-x:auto;">
				<div id="tableExample2" data-list='{"valueNames":["name","email","age"],"page":5,"pagination":true}'>
				  <div class="table-responsive scrollbar">
				    <table class="display" id="recharge_history_self_tbl">
				      <thead class="bg-200 text-900">
				        <tr>
				          
				           <th class="sort" data-sort="age">Date</th>
				           <th class="sort" data-sort="age">Username</th>
				          <th class="sort" data-sort="email">Route</th>
				          <th class="sort" data-sort="age">Credit Type</th>
				          <th class="sort" data-sort="age">Added Bal.</th>
				          <!-- <th class="sort" data-sort="age">New Bal.</th> -->
				          <th class="sort" data-sort="age">Remark</th>
				         
				         
				        </tr>
				      </thead>
				      <tbody class="recharge_history_list_self">

				      </tbody>
				    </table>
				  </div>
				  <div class="d-flex justify-content-center mt-3"><button class="btn btn-sm btn-falcon-default me-1" type="button" title="Previous" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
				    <ul class="pagination mb-0"></ul><button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next" data-list-pagination="next"><span class="fas fa-chevron-right"> </span></button>
				  </div>
				</div>
			</div>




		</div>
                </div>
              </div>
            </div>
        </div>



   </div>
  



   <script src="assets/js/utility.js?=<?=time();?>"></script>
