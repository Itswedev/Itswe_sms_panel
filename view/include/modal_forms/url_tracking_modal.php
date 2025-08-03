<!-- Add Contact modal start -->

<div class="modal fade" id="add_url_tracking" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">URL Tracking</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error_add_contact"></div>
       <div class="row g-3 mb-3">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div id="action_message" style="display:none"></div>


                <ul class="nav nav-pills" id="pill-myTab" role="tablist">
                  <li class="nav-item"><a class="nav-link active" id="pill-home-tab" data-bs-toggle="tab" href="#pill-tab-home" role="tab" aria-controls="pill-tab-home" aria-selected="true">Original URL</a></li>
                  <li class="nav-item"><a class="nav-link" id="pill-profile-tab" data-bs-toggle="tab" href="#pill-tab-profile" role="tab" aria-controls="pill-tab-profile" aria-selected="false">Upload Image</a></li>
                 
                </ul>
<div class="tab-content border p-3 mt-3" id="pill-myTabContent">
  <div class="tab-pane fade show active" id="pill-tab-home" role="tabpanel" aria-labelledby="home-tab" style="overflow-x:auto;">     

                <table class="table table-bordered table-striped fs--1 mb-0" id="daily_mis_report_tbl">
                                        <thead>
                                         
                                        </thead>
                                        <tbody id="daily_mis_report"> 
                                        <form >       
                        <input name="original_url" type="text" id="original_url_txt" title="Please enter Original URL" placeholder="Enter your original URL" class="form-control " style="width:40%;" />
                        <br/>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="btn_txt_url">Save</button>
                      </form></tbody>
                                        
                </table>
                </div>
              <div class="tab-pane fade" id="pill-tab-profile" role="tabpanel" aria-labelledby="profile-tab" style="overflow-x:auto;">
                        <table class="table table-bordered table-striped fs--1 mb-0">
                                        <thead>
                                          
                                        </thead>
                                        <tbody id="monthly_mis_report">
                                          <form>       
                        <input name="original_url" type="file" id="original_url_img" title="Please upload image" placeholder="Please upload image" class="form-control " style="width:40%;" />
                        <br/>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="btn_img_url">Save</button>
                      </form>
                                        </tbody>
                        </table>
              </div>
             

            
      </div>
    </div>
  </div>
</div>
</div>
</div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createsenderid" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
<!-- Add Contact modal end -->
