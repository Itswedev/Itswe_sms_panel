

<!-- reschedule campaign -->
<div class="modal fade" id="reschedule_form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Reschedule Campaign</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error"></div>
        <!-- <form id="rescheduleForm" class="needs-validation custom-input" novalidate=""> -->
            <div class="container-fluid">
               <input type="hidden" name="type" id="msg_job_id"  />
               <input type="hidden" name="type" id="old_date"  />
               <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  />
              <!--<input type="hidden" name="form_name" id="form_name" value="<?php echo $form_name; ?>"  />
          <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  /> -->
            <div class="row">
                          <div class="col">
                          <div class="mb-3">
                            <label class="form-label" for="exampleInputPassword6">Reschedule Date</label>
                           
                            <input class="form-control datetimepicker btn-pill" id="datepicker" type="text" placeholder="YYYY-mm-dd HH:MM"   name="scheduleDateTime[]" style="width:80%;"/>
                            
                          </div>
                        </div>
            </div>
              
            </div>

        
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createsenderid" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="submitBtnValue" id="reschedule_now_btn" value="Reschedule">Reschedule Save</button>
      </div>
      <!-- </form> -->
    </div>
  </div>
</div>