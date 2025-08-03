<div class="modal fade" id="schedule_later_form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Schedule For Later</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="action_message_error"></div>
        <!-- <form id="senderidsForm" class="needs-validation custom-input" novalidate=""> -->
            <div class="container-fluid">
              <!-- <input type="hidden" name="type" value="saveSenderId"  />
              <input type="hidden" name="form_name" id="form_name" value="<?php echo $form_name; ?>"  />
          <input type="hidden" name="userid" value="<?php echo $_SESSION['user_id']; ?>"  /> -->
            <div class="row">
                          <div class="col">
                          <div class="mb-3">
                            <label class="form-label" for="exampleInputPassword6">Schedule 1</label>
                           
                            <input class="form-control datetimepicker btn-pill" id="datepicker" type="text" placeholder="YYYY-mm-dd HH:MM" data-options='{"disableMobile":true,"enableTime":true,"dateFormat":"d/m/Y H:i"}'   name="scheduleDateTime[]" style="width:80%;"/>
                            <!-- <input class="form-control btn-pill" id="datepicker" type="datetime-local" value="" name="scheduleDateTime[]> -->
                          </div>
                        </div>
            </div>
            <div class="row">
                          <div class="col">
                          <div class="mb-3">
                            <label class="form-label" for="exampleInputPassword6">Schedule 2</label>
                           
                            <input class="form-control datetimepicker btn-pill" id="datepicker2" type="text" placeholder="YYYY-mm-dd HH:MM"  data-options='{"disableMobile":true,"enableTime":true,"dateFormat":"d/m/Y H:i"}'  name="scheduleDateTime[]" style="width:80%;"/>
                            <!-- <input class="form-control btn-pill" id="datepicker" type="datetime-local" value="" name="scheduleDateTime[]> -->
                          </div>
                        </div>
            </div>
            <div class="row">
                          <div class="col">
                          <div class="mb-3">
                            <label class="form-label" for="exampleInputPassword6">Schedule 3</label>
                           
                            <input class="form-control datetimepicker btn-pill" id="datepicker3" type="text" placeholder="YYYY-mm-dd HH:MM" data-options='{"disableMobile":true,"enableTime":true,"dateFormat":"d/m/Y H:i"}'   name="scheduleDateTime[]" style="width:80%;"/>
                            <!-- <input class="form-control btn-pill" id="datepicker" type="datetime-local" value="" name="scheduleDateTime[]> -->
                          </div>
                        </div>
            </div>
            <div class="row">
                          <div class="col">
                          <div class="mb-3">
                            <label class="form-label" for="exampleInputPassword6">Schedule 4</label>
                           
                            <input class="form-control datetimepicker btn-pill" id="datepicker4" type="text" placeholder="YYYY-mm-dd HH:MM"  data-options='{"disableMobile":true,"enableTime":true,"dateFormat":"d/m/Y H:i"}'  name="scheduleDateTime[]" style="width:80%;"/>
                            <!-- <input class="form-control btn-pill" id="datepicker" type="datetime-local" value="" name="scheduleDateTime[]> -->
                          </div>
                        </div>
            </div>

            Note : Filling each schedule date will divide the whole campaign in parts based on date filled up.
e.g : if you fill two dates and campaing size is 1lac then whole campaign will divide in two campaigns with filled up date 50k/50k.
            </div>

        
      </div>
      <div class="modal-footer">
        <div class="mirror_edit_ok_btn" id="createsenderid" style="text-align: center;">
        </div>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="submitBtnValue" id="schedule_now_btn" value="Schedule Now">Schedule Now</button>
      </div>
      <!-- </form> -->
    </div>
  </div>
</div>