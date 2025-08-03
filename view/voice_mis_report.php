<?php 
    

/*    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);*/
    error_reporting(0);
?>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script> -->
<link rel="stylesheet" type="text/css" href="assets/css/chosen.css">

<div class="card mb-3">
    <div class="bg-holder d-none d-lg-block bg-card" style="background-image: url(../assets/img/icons/spot-illustrations/corner-4.png);" ></div>
    <!--/.bg-holder-->
    <div class="card-body position-relative">
      <div class="row">
        <div class="col-lg-4">
          <h3 id="page_name">Voice MIS Report</h3>  
        </div>
      
        <input type="hidden" value="<?php echo $_SESSION['user_role']; ?>" id="user_role">

        <?php

            if($_SESSION['user_role']=='mds_rs' || $_SESSION['user_role']=='mds_ad')
            {

        ?>
          <div class="col-lg-4">
              <label for="date">Select Role</label>
                     <select class="form-control" id="user_role_dropdown_mis" style="width:80%;"><option value="">Select Role</option>
                      <option value="All">All</option>
                      <option value="mds_rs">Reseller</option>
                      <option value="mds_usr">User</option>
                    </select>

        </div> 
        <div class="col-lg-4">
             <label for="date">Select <span class="role_name">User</span></label>
                     <select class="form-control" id="user_dropdown_mis" style="width:80%;"><option value="">Select User</option></select>
        </div> 
        <?php
          }
                    else if($_SESSION['user_role']=='mds_adm')
            {

        ?>
          <!-- <div class="col-lg-4">
              <label for="date">Select Role</label>
                     <select class="form-control" id="user_role_dropdown" style="width:80%;"><option value="">Select Role</option>
                      <!-- <option value="All">All</option> 
                      <option value="All">All</option>
                      <option value="Admin">Admin</option>
                      <option value="Reseller">Reseller</option>
                      <option value="User">User</option>
                    </select>

        </div> --> 
        <div class="col-lg-4">
             <label for="date">Select <span class="role_name">User</span></label>
                     <select class="form-control" id="user_dropdown_list" style="width:80%;"><option value="">Select User</option></select>
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
</style>


<div class="row g-3 mb-3">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div id="action_message" style="display:none"></div>


                <ul class="nav nav-pills" id="pill-myTab" role="tablist">
  <li class="nav-item"><a class="nav-link active" id="pill-home-tab" data-bs-toggle="tab" href="#pill-tab-home" role="tab" aria-controls="pill-tab-home" aria-selected="true">Daily</a></li>
  <li class="nav-item"><a class="nav-link" id="pill-profile-tab" data-bs-toggle="tab" href="#pill-tab-profile" role="tab" aria-controls="pill-tab-profile" aria-selected="false">Monthly</a></li>
  <li class="nav-item"><a class="nav-link" id="pill-contact-tab" data-bs-toggle="tab" href="#pill-tab-contact" role="tab" aria-controls="pill-tab-contact" aria-selected="false">Yearly</a></li>
  <!-- <li class="nav-item"><a class="nav-link" id="pill-senderid-tab" data-bs-toggle="tab" href="#pill-tab-senderid" role="tab" aria-controls="pill-tab-senderid" aria-selected="false">Senderid Wise</a></li> -->
  <li class="nav-item"><a class="nav-link" id="pill-custom-tab" data-bs-toggle="tab" href="#pill-tab-custom" role="tab" aria-controls="pill-tab-custom" aria-selected="false">Customised Summary</a></li>
</ul>
<div class="tab-content border p-3 mt-3" id="pill-myTabContent">
  <div class="tab-pane fade show active" id="pill-tab-home" role="tabpanel" aria-labelledby="home-tab" style="overflow-x:auto;">     

    <table class="table table-bordered table-striped fs--1 mb-0" id="daily_mis_report_tbl">
                            <thead>
                             
                            </thead>
                            <tbody id="daily_mis_report"></tbody>
                            
    </table>
    </div>
  <div class="tab-pane fade" id="pill-tab-profile" role="tabpanel" aria-labelledby="profile-tab" style="overflow-x:auto;">
            <table class="table table-bordered table-striped fs--1 mb-0">
                            <thead>
                              
                            </thead>
                            <tbody id="monthly_mis_report">
                            </tbody>
            </table>
  </div>
  <div class="tab-pane fade" id="pill-tab-contact" role="tabpanel" aria-labelledby="contact-tab" style="overflow-x:auto;">
            <table class="table table-bordered table-striped fs--1 mb-0" id="">
                            <thead>
                              
                            </thead>
                            <tbody id="yearly_mis_report">
                            </tbody>
            </table>
  </div>

   <!-- <div class="tab-pane fade" id="pill-tab-senderid" role="tabpanel" aria-labelledby="contact-tab" style="overflow-x:auto;">
            <table class="table table-bordered table-striped fs--1 mb-0" id="">
                            <thead>
                              
                            </thead>
                            <tbody id="senderid_mis_report">
                            </tbody>
            </table>
  </div> -->
  <div class="tab-pane fade" id="pill-tab-custom" role="tabpanel" aria-labelledby="contact-tab" style="overflow-x:auto;">
                            <form name="custom_mis_form" id="custom_mis_form" method="post">
                                <table border="0" cellspacing="5" cellpadding="5">
                            <tbody>
                                <tr>
                                <td>From:</td>
                                <td>
                                    <input class="form-control datetimepicker" id="frmDate" type="text" placeholder="yyyy-mm-dd"  data-options='{"disableMobile":true,"enableTime":false,"dateFormat":"Y-m-d","minDate": "<?php echo $minDate; ?>","maxDate": "<?php echo $maxDate; ?>"}' name="min" aria-label="frmDate" aria-describedby="basic-addon1" style="width:80%;" /></td>
                                    <!-- <input type="date" id="frmDate" name="min" ></td> -->
                                <td>To:</td>
                                <td>
                                    <input class="form-control datetimepicker" id="toDate" type="text" placeholder="yyyy-mm-dd"  data-options='{"disableMobile":true,"enableTime":false,"dateFormat":"Y-m-d","minDate": "<?php echo $minDate; ?>","maxDate": "<?php echo $maxDate; ?>"}' name="max" aria-label="toDate" aria-describedby="basic-addon1" style="width:80%;"/></td>

                                <td>
                                     <input type="hidden"  name="list_type" value="custom_report">
                                     <input type="hidden"  name="selected_userid" id="selected_userid_dt" value="">
                                     <input type="hidden"  name="selected_user_role" id="selected_user_role" value="">
                                     
                                     <button type="button" class="btn btn-primary" id="search_custom_submit">Search</button> 
                                   </td>


                               </form>
                      

                           
                                    <!-- <input type="date" id="toDate" name="max" onChange="searchData()"></td> -->
                            </tr>
                          
                        </tbody></table>
            <table class="table table-bordered table-striped fs--1 mb-0" id="">
                            <thead>
                              
                            </thead>
                            <tbody id="custom_mis_report">
                            </tbody>
            </table>
  </div>
</div>
		
            </div>
        </div>
    </div>
</div>

<script>

//     $("#tabs").tabs();

     


</script>

<script type="text/javascript" src="assets/js/chosen.jquery.js?=<?=time();?>"></script>

<script src="assets/js/voice_mis_report.js?=<?=time();?>"></script>