<?php
$profile_pic=$_SESSION['profile_pic'];


?>
<link rel="stylesheet" type="text/css" href="assets/css/vendors/sweetalert2.css">
   
<div class="page-body">

<input type="hidden" name="login_user_role" id="login_user_role" value="<?php echo $_SESSION['user_role']; ?>">
         <div class="card mb-3">
            <div class="bg-holder d-none d-lg-block bg-card" style="" ></div>
            <!--/.bg-holder-->
            <div class="card-body position-relative">
              <div class="row">
                <div class="col-lg-4">
                  <h3><span id="page_name" style="display:none;">profile</span>#Profile & Account Details </h3>

                </div>
                  <div class="col-lg-8">
               <!--   <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_route" id="add_route_btn" style="float:right;">+ Add Route </button> -->


                </div>

              </div>
            </div>
          </div>

          <div class="row g-3 mb-3">

            <div class="col-lg-12">
              <div class="card" >

                <div class="card-body">

                   <ul class="nav nav-pills" id="pill-myTab" role="tablist">
                      <li class="nav-item"><a class="nav-link active" id="pill-home-tab" data-bs-toggle="tab" href="#pill-tab-home" role="tab" aria-controls="pill-tab-home" aria-selected="true">Basic Details</a></li>
                      <li class="nav-item settings"><a class="nav-link" id="pill-profile-tab" data-bs-toggle="tab" href="#pill-tab-profile" role="tab" aria-controls="pill-tab-profile" aria-selected="false">Profile Image</a></li>


                    </ul>

                    <div class="tab-content border p-3 mt-3" id="pill-myTabContent">
  <div class="tab-pane fade show active" id="pill-tab-home" role="tabpanel" aria-labelledby="home-tab">
     <form id="save_profile_form"  name="save_profile_form" method="POST">
       <input type="hidden" name="list_type" value="update_user_profile">
         <div class="row g-3 mb-3">

            <div class="col-lg-12">
              <div class="card" >

                <div class="card-body">
                <div class="container-fluid">
               <div class="row">
                <input type="hidden" name="userid" id="userid" value="<?php echo $_REQUEST['edit_userid']?>">
                 <input type="hidden" name="type" value="save_profile">
                        <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Username</label>
                        </div>
                      <div class="pmd-textfield col col-sm-3" >
                            <input type="text" class="form-control" aria-label="username" aria-describedby="basic-addon1" id="username" name="username" readonly>
                        </div>
                               <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Full Name</label>
                        </div>
                        <div class="col col-sm-3">
                           <input type="text" class="form-control" name="f_name" id="f_name" placeholder="Enter Full Name">

                        </div>
                      <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Mobile No.</label>
                        </div>
                        <div class="col col-sm-3">
                           <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Enter Mobile Number">


                           </div>


                </div>
                <br/>

                  <div class="row">



                      <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Email</label>
                        </div>
                        <div class="col col-sm-3">
                           <input type="text" class="form-control" name="email" id="email_id" placeholder="Enter Email">

                        </div>
                          <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Company Name</label>
                        </div>
                        <div class="col col-sm-3">
                           <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Company Name">

                        </div>
                        <div class="col col-sm-1">
                        <label for="inputEmail3" class="">City</label>
                        </div>
                        <div class="col col-sm-3">
                           <input type="text" class="form-control" name="city" id="city" placeholder="Enter City">
                        </div>
                </div>
                <br/>



                  <div class="row">


                  <div class="col col-sm-1">
                          <label for="inputEmail3" class="">Pincode</label>
                        </div>
                        <div class="col col-sm-3">
                           <input type="text" class="form-control" name="pincode" id="pincode" placeholder="Enter Pincode">

                        </div>


                </div>
                <br/>


                <div class="row">
                        <div class="col col-sm-1">

                        </div>
                        <div class="col col-sm-3">
                          <button type="submit" class="btn btn-primary pmd-ripple-effect" name="input-form-submit" value="Subscribe" id="save_user_profile_btn">Save</button>


                        </div>
                </div>
                <br/>



                  </div>

                </div>
            </div>
          </div>
        </div>
 </form>
</div>

<div class="tab-pane fade settings" id="pill-tab-profile" role="tabpanel" aria-labelledby="profile-tab">
  <div class="tab-pane fade show active" id="pill-tab-home" role="tabpanel" aria-labelledby="home-tab">
    <form id="save_profile_pic_form"  name="save_profile_pic_form" method="POST" enctype="multipart/form-data">

        <div class="row g-3 mb-3">

           <div class="col-lg-12">
             <div class="card" >

               <div class="card-body">


                 <div class="container-fluid">
                     <div class="row">
                       <div class="col col-sm-4">

                       </div>
                       <div class="col col-sm-4" id="profile_pic">
                       <img class="rounded-circle img-thumbnail shadow-sm" src="assets/images/profile/<?php echo $profile_pic; ?>" width="200" alt="" >

                       </div>
                        <div class="col col-sm-4">


                       </div>
                    </div>
                    <br><br/>
                     <div class="row">
                       <div class="col col-sm-4">

                       </div>
                       <div class="col col-sm-4">
                       <input type="file" id="profile_pic_select" style="display:none;"  name="profile_pic_select"/>
                       <input type="button" id="button" name="button" value="Choose Image " onclick="thisFileUpload();" class="btn btn-primary pmd-ripple-effect">
                       <button type="submit" class="btn btn-primary pmd-ripple-effect" name="input-form-submit" value="Subscribe" id="save_profile_img_btn">Save</button>

                       </div>
                        <div class="col col-sm-4">

                        </div>
                     </div>

                  </div>
                </div>
              </div>
            </div>
          </div>

                    </form>
                    </div>
                    </div>

                      </div>
                    </div>
                    </div>
                    </div>



                    </div>

                </div>



              </div>
            </div>
          </div>

</die>


<script src="assets/js/profile.js?=<?=time();?>"></script>