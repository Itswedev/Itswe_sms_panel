<?php 


/*
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);*/


        
$minDate=date('Y-m-d', strtotime('-90 days', strtotime(date('d-m-Y'))));
$maxDate=date('Y-m-d',strtotime('-2 days'));


?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css">

<link rel="stylesheet" type="text/css" href="assets/css/chosen.css">
<div class="card mb-3">
    <div class="bg-holder d-none d-lg-block bg-card" style="background-image: url(../assets/img/icons/spot-illustrations/corner-4.png);" ></div>
    <!--/.bg-holder-->
    <div class="card-body position-relative">
      <div class="row">
        <div class="col-lg-4">
          <h3 id="page_name">Scheduled Voice Report</h3>  
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
    div.dataTables_wrapper {
        margin-bottom: 3em;
    }
    .dt-buttons
    {

    float: right;
    margin-top: -4%;

    }
</style>



<div class="row g-3 mb-3">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div id="action_message" style="display:none"></div>
                <div id="tableExample2" data-list='{"valueNames":["name","email","age"],"page":5,"pagination":true}'>
                    <div class="table-responsive scrollbar">
                        
                        <table border="0" cellspacing="5" cellpadding="5">
                            <tbody><tr>
                                                           
                             <td>From&nbsp:&nbsp&nbsp</td>
                                <td>
                                    <input class="form-control datetimepicker" id="frmDate" type="text" placeholder="dd-mm-yyyy"  data-options='{"disableMobile":true,"enableTime":false,"dateFormat":"Y-m-d","minDate": "<?php //echo $minDate; ?>","maxDate": "<?php //echo $maxDate; ?>"}' name="min" aria-label="frmDate" aria-describedby="basic-addon1" style="width:80%;"   onChange="searchData_report()"/>
                                    <!--  <input type="date" id="frmDate" name="min" > --></td> 
                                <td>To&nbsp:&nbsp&nbsp</td>
                                <td>
                                    <input class="form-control datetimepicker" id="toDate" type="text" placeholder="dd-mm-yyyy"  data-options='{"disableMobile":true,"enableTime":false,"dateFormat":"Y-m-d","minDate": "<?php //echo $minDate; ?>","maxDate": "<?php //echo $maxDate; ?>"}' name="max" aria-label="toDate" aria-describedby="basic-addon1" style="width:80%;" onChange="searchData_report()"/>
                                     <!-- <input type="date" id="toDate" name="max" onChange="searchData()"> --></td> 

                                     <!-- <input type="hidden" value="<?php //echo $_SESSION['user_role']; ?>" id="user_role"> -->

                           <!--  <?php

                                if($_SESSION['user_role']=='mds_rs' || $_SESSION['user_role']=='mds_ad')
                                {

                            ?>
                                 
                                <?php
                                  }

                                ?> -->

                                <span style="float:right;">
                                    <button type="button" class="btn btn-primary" id="download_report_btn">Download
                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
                                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
                                    </svg> -->
                                    <i class="fa-solid fa-download fa-fw" style="margin-left: 8px;"></i> 
                                    </button>
                                    <span>

                            </tr>
                          
                        </tbody></table><br>
                      <table class="table table-bordered table-striped fs--1 mb-0" id="scheduled_report_tbl">
                        <thead class="bg-200 text-900">
                          <tr>
                            
                          <th class="sort" data-sort="">Sr.No</th>
                            <th class="sort" data-sort="">User</th>
                             <th class="sort" data-sort="">Job Id</th>
                              <th class="sort" data-sort="">Voice File</th>
                              <th class="sort" data-sort="">Created Date</th>
                            <th class="sort" data-sort="">Sent Date</th>
                            <th class="sort" data-sort="">Bill Count</th>
                          
                            
                            <!-- <th class="sort" data-sort="">numbers count</th> -->
                            <th class="sort" data-sort="">Action</th>
                          </tr>
                        </thead>
                          
                        <tbody class="schedule_report" >

                        </tbody>
                         
                      </table>
                    </div>
                
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js?=<?=time();?>"></script>
<?php include('include/datatable_js.php');?>

<script type="text/javascript" src="assets/js/chosen.jquery.js?=<?=time();?>"></script>
<script src="assets/js/voice_call.js?=<?=time();?>"></script>