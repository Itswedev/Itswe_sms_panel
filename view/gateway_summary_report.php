        
<?php

/*include('include/connection.php');
require('controller/classes/ssp.class.php');
include('include/config.php');*/
$minDate=date('Y-m-d', strtotime('-90 days', strtotime(date('d-m-Y'))));
$maxDate=date('Y-m-d');
?>

          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h4 id="page_name">Gateway Summary Report</h4>
                    <input type="hidden" value="<?php echo $_SESSION['user_role']; ?>" id="user_role">

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
                    
    	            </div>
                  <div class="card-body">
                  <?php
					 if($_SESSION['user_role']=='mds_adm')
        	{

        ?>

           <div class="col-lg-3" style="float:left;">
        	 <label for="date">Select <span class="role_name">Gateway</span></label>
                     <select class="form-control" id="gateway_dropdown" style="width:80%;border-radius: 20px;border-color: #5f9ea0;"><option value="">Select Gateway</option></select>
        </div> 
         <div class="col-lg-3" style="float:left;">
          <label for="date">From: </label>
          <input class="form-control datetimepicker" id="frmDate" type="date" placeholder="yyyy-mm-dd"  style="width:80%;border-radius: 20px;border-color: #5f9ea0;"   />
        </div>
         <div class="col-lg-3" style="float:left;">
          <label for="date">To: </label>
          <input class="form-control datetimepicker" id="toDate" type="date" placeholder="yyyy-mm-dd"  style="width:80%;border-radius: 20px;border-color: #5f9ea0;" />
        </div> 

        <div class="col-lg-3" style="float:left;">
           <label for="date">&nbsp;&nbsp;&nbsp;</label>
          <!-- <input class="form-control btn btn-primary" id="search_report" type="button"  onClick="load_today_gateway_summary_report()" value="Search" style="width:69%;border-radius: 20px;margin-top: 8%;"/><i class="fa-solid fa-magnifying-glass fa-fw"></i>  -->
        <button class="form-control btn btn-primary" id="search_report" type="button" 
          onClick="load_today_gateway_summary_report()" style="width: 69%; border-radius: 20px; margin-top: 8%;">
          <i class="fa-solid fa-magnifying-glass fa-fw"></i> Search
        </button>

        </div> 
        
        <?php
          }

        ?>
      
                    <div class="table-responsive theme-scrollbar">
                      <table class="display" id="basic-1">
                        <thead >
                       
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

        <script>
    document.addEventListener("DOMContentLoaded", function() {
     flatpickr(".datetimepicker", {
       minDate: <?php echo "'".$minDate."'"; ?>, // Set your minimum date here
       maxDate: <?php echo "'".$maxDate."'"; ?>, // Set your maximum date here
       dateFormat: "Y-m-d", // Set the desired date format
     });
   });
</script>

    <script type="text/javascript" src="assets/js/gateway_report.js?=<?=time();?>"></script>
