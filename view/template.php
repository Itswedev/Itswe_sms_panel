
  
        <!-- Page Sidebar Ends--> 
          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Manage Templates</h4>
                    <button id="gradientButtons1" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#create_template_modal" style="
                    position: relative;
                    float: right;
                    margin-top: -1%;
                    margin-right: 25%;
                    "><i class="fa-solid fa-circle-plus fa-fw" style="margin-right: 8px;"></i>Add Template</button>
                    <button class='btn btn-primary' id='upload_temp' data-bs-toggle="modal" data-bs-target="#upload_template_modal" style="
                    position: relative;
                    float: right;
                    margin-top: -1%;
                    margin-right: 2%;
                    ">Import <i class="fa-solid fa-upload fa-fw" style="margin-left: 8px;"></i></button>

                    <button class='btn btn-primary' id='download_temp'  style="
                    position: relative;
                    float: right;
                    margin-top: -1%;
                    margin-right: 2%;
                    ">Export <i class="fa-solid fa-download fa-fw" style="margin-left: 8px;"></i></button>

                   
                 
                  </div>
                  <input type="hidden" name="user_role" value="<?php echo $user_role; ?>" id="user_role">
                  <div class="card-body">
                    <div class="table-responsive theme-scrollbar">
                   
                    <table class="table table-bordered table-striped fs--1 mb-0" id="template_list_tbl">
                      <thead class="bg-200 text-900" style="background-color:#f4f7f9;">
                      <tr>
                 
                      <?php
                          $login_user=$_SESSION['user_id'];
                          if($login_user==1)
                          {
                            echo '<th class="sort" data-sort="email">Username</th>';
                          } 
                      ?>
         
                  <th class="sort" data-sort="email">Template Name</th>
                 
                  <th class="sort" data-sort="age" >Template ID</th>
                  <th class="sort" data-sort="age" width="20%">Content Type</th>
                  <th class="sort" data-sort="age" width="10%">Category Type</th>
                  <th class="sort" data-sort="age">Sender ID</th>
                  <th class="sort" data-sort="age" width="30%">Template Content</th>
                  <th class="sort" data-sort="age">Create Date</th>
                  <th class="sort" data-sort="age">Char Type</th>
                  <th class="sort" data-sort="age">Action</th>

                </tr>
              </thead>
            
            </table>
                    </div>
                  </div>



                  
                </div>


              </div>
              <!-- Zero Configuration  Ends-->
            </div>

       

        <script src="assets/js/template_id_function.js?=<?=time();?>"></script>
    <?php include('include/modal_forms/template_modal.php');?>
 
    
  </body>
</html>