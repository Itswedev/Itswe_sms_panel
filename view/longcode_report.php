<?php 
session_start();
    // include('controller/send_job_report_controller.php');

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    
$minDate=date('Y-m-d', strtotime('-90 days', strtotime(date('d-m-Y'))));
$maxDate=date('Y-m-d');



 
?>


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css">
<style type="text/css">
    .dt-buttons
    {

    float: right;
    margin-top: -4%;

    }
</style>
<div class="card mb-3">
    <div class="bg-holder d-none d-lg-block bg-card" style="background-image: url(../assets/img/icons/spot-illustrations/corner-4.png);" ></div>
    <!--/.bg-holder-->
    <div class="card-body position-relative">
      <div class="row">
        <div class="col-lg-4">
          <h3 id="page_name"># Longcode Report</h3>  
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

    div.dataTables_wrapper {
        margin-bottom: 3em;
    }
</style>

<!-- <div class="row g-3">
    <div class="col-lg-12">
        <div class="card mb-3">
            <div class="card-body">

                <div class="row">
                <form method="POST"> 
                        <div class="col-md-2">
                          <label for="frmDate">From</label>
                          <input type="date" id="frmDate" name="min" onChange="searchData()">
                        </div>
                        <div class="col-md-2">
                          <label for="To">To</label><br>
                          <input type="date" id="toDate" name="max" onChange="searchData()">
                        </div>
                       
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

                            <table border="0" cellspacing="5" cellpadding="5">
                            <tbody>
                                <tr>
                                <td>From&nbsp:&nbsp&nbsp</td>
                                <td>
                                    <input class="form-control datetimepicker" id="frmDate" type="text" placeholder="yyyy-mm-dd"  data-options='{"disableMobile":true,"enableTime":false,"dateFormat":"Y-m-d","minDate": "<?php echo $minDate; ?>","maxDate": "<?php echo $maxDate; ?>"}' name="min" aria-label="frmDate" aria-describedby="basic-addon1" style="width:80%;"   onChange="load_longcode_report()"/></td>
                                    <!-- <input type="date" id="frmDate" name="min" ></td> -->
                                <td>To&nbsp:&nbsp&nbsp</td>
                                <td>
                                    <input class="form-control datetimepicker" id="toDate" type="text" placeholder="yyyy-mm-dd"  data-options='{"disableMobile":true,"enableTime":false,"dateFormat":"Y-m-d","minDate": "<?php echo $minDate; ?>","maxDate": "<?php echo $maxDate; ?>"}' name="max" aria-label="toDate" aria-describedby="basic-addon1" style="width:80%;" onChange="load_longcode_report()"/></td>
                                    <td>Service Number&nbsp:&nbsp&nbsp</td>
                                    <td>
                                        
                                    <select class="form-control" id="service_number" style="width:100%;"><option value="">Select Service Number</option>
                                      <option value="All" selected>All</option>
                                     
                                    </select>
                                   
                                </td>
                        
                            <input type="hidden" value="<?php echo $_SESSION['user_role']; ?>" id="user_role">

                           
                                    <span style="float:right;">
                                    <button type="button" class="btn btn-primary" id="download_report_btn">Download
                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
                                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
                                    </svg> -->

                                    <i class="fa-solid fa-download fa-fw"></i>
                
                                    </button>
                                    <span>
                            </tr>
                          
                        </tbody></table><br>
                            <!-- <input type="text" id="report_type" value="<?php //echo $report_type; ?>"> -->
                            <table class="table table-bordered table-striped fs--1 mb-0" id="longcode_summary_tbl">
                                <thead class="bg-200 text-900">
                                    <tr>
                                       
                                       <th class="sort w-auto" data-sort="">Username</th>
                                        <th class="sort w-auto" data-sort="">Longcode</th>
                                        <th class="sort w-auto" data-sort="">Sender</th>
                                        <th class="sort w-auto" data-sort="">Keyword</th>
                                        <th class="sort w-auto" data-sort="">Message</th>
                                        <th class="sort w-auto" data-sort="">Timestamp</th>
                                       
                                    </tr>
                                </thead>
                                <tbody class="longcode_summary_report" id="longcode_summary_report">
                                    
                                </tbody>
                               
                            </table>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<?php include('include/datatable_js.php');?>

<script src="assets/js/longcode.js?=<?=time();?>"></script>
