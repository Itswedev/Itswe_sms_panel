<?php
   
   $minDate=date('Y-m-d H:i');
?>

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="assets/css/vendors/sweetalert2.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css">
<style>
  table, th, td {
  border: 1px solid black;
}
  </style>

          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Bulk SMS</h4>
                  </div>

                  <div class="modal" tabindex="-1" role="dialog" id="loading_modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="margin-top: 45%;">
     
      <div class="modal-body">
        <br>
        <h4 style="text-align:center;">We Are Processing Your Request <br> Please Wait.....</h4>
       <span id="loading"><img src="assets/images/loading1.gif" height="10%" width="100%" /></span>
      </div>
     
    </div>
  </div>
</div>
                  <div class="card-body">
                     <form class="form theme-form dark-inputs" id="sendSMSForm"  name="sendSMSForm" method="POST">
                     <input type="hidden" name="type" id="type" value="sendSMSsave">
                      <div class="row">
                      <div class="col"><div class="card-body">
                       <div class="row">
                        <div class="col-6">
                          <div class="mb-4">
                          
                            <label class="form-label" for="exampleFormControlSelect7">Route</label>
                            <select class="form-select btn-pill digits" name="az_routeid" id="az_routeid">
                              
                            </select>
                          </div>
                        </div>

                        <div class="col-6">
                          <div class="mb-3">
                            <label class="form-label" for="exampleFormControlInput5">Header</label>
                            <select class="form-select btn-pill digits" name="sid" id="sid">
                              
                            </select>
                          </div>
                        </div>


                        
                        
                      </div>
                      <div class="row">
                      
                      </div>
                  
                     
                      <div class="row">
                        <div class="col-6 mobile_number">
                          <div class="mb-3">
                            <label class="form-label" for="formFileSimple">Mobile Numbers</label>
                            <textarea class="form-control btn-pill" id="numbers" name="numbers" rows="5" onKeyPress="return isNumberKeyOrFloat(event);" onkeyup="countNo('numbers','counti')"></textarea>
                            <br>
                             <button class="btn btn-outline-primary btn-sm mb-1" id="msg-btn-mb-cnt" value="Characters" type="button" onclick="myFunc();" style="
                              border-radius: 20px;">
                              No's : <span class="" id="counti">0</span></button>&nbsp;&nbsp;
                              <button class="btn btn-outline-primary btn-sm mb-1" id="select_template" value="Select Template" type="button"  style="
                              border-radius: 20px;">
                              Select Template </button>
                          </div>
                          
                        </div>
                        <div class="col-6">
                          <div class="mb-3"> 
                            <!-- <label class="form-label">Message Text</label> -->
                            <div class="row"> 
                              <div class="col">  
                              <label class="form-label" for="formFileSimple">Template</label>
                              <select id="template" class="form-select btn-pill" name="template">
                              <option value="">Select Template</option>
                              </select>
                              </div>
                              <!-- <div class="col">
                              <label class="form-label" for="formFileSimple">Template Id</label>
                              <input class="form-control btn-pill" id="dlt_template" type="text" placeholder="DLT Template" name="dlt_template">
                              </div> -->
                            </div>
                            <div class="row">
                            <div class="col">
                            <div class="mb-3">
                            </div>
                            </div>
                            </div>
                            <div class="row">
                              <div class="col">
                                <div class="mb-3">
                                  <label class="form-label" for="exampleInputPassword6">Campaign Name</label>
                                  <input class="form-control btn-pill" name="campaign_name" id="campaign_name" placeholder="Campaign Name" type="text" >
                                </div>
                          <br>
                          <div class="mb-3 d-flex gap-3 checkbox-checked">
                            <div class="form-check">
                              <input class="form-check-input" name="char_set"  id="flexRadioDefault1" type="radio" name="flexRadioDefault" checked value="Text">
                              <label class="form-check-label mb-0" for="flexRadioDefault1">Text </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" name="char_set"  id="flexRadioDefault2" type="radio" name="flexRadioDefault"  value="Unicode">
                              <label class="form-check-label mb-0" for="flexRadioDefault2">Unicode</label>
                            </div>
                          </div>






                              </div>
                            </div>

                          </div>
                        </div>

                        
                        
                      </div>
                      
                    <!-- message text -->
                    
                      

                      <div class="row"> 
                
                      </div>
                      <div class="row">
                        <div class="col">
                          <div class="mb-3">
                              <label class="form-label">Message Text</label>
                              <textarea class="form-control btn-pill" rows="5" placeholder="Type Message Here" maxlength="1000" name="message" id="mbl1" onkeypress="checkChar()" onkeyup="checkChar()" onblur="checkChar()"></textarea>  
                              <button class="btn btn-outline-primary btn-sm mt-3 w-auto" id="msg-btn-char-cnt" value="Characters" type="button" onclick="myFunc();" style="border-radius: 20px;">
                                                      Characters : <span class="length" id="characters">0</span></button>&nbsp;&nbsp;
                              <button class="btn btn-outline-primary btn-sm mt-3 w-auto" id="msg-btn-sms-cnt" type="button" onclick="myFunc();" style="
                                border-radius: 20px;">
                                                      SMS Count : <span class="messages" id="smsCount" name="txtMessageCount" >0</span></button>
                                                      <input type="hidden" id="msg_credit" name="msg_credit" value="0">
                                                      <input type="hidden" id="msg_chars" name="msg_chars" value="0">
                                <div class="form-check form-switch form-check-inline" style="position: absolute; margin-top: 1.4%;left: 21%;">
                                              
                                  <input name="original_url" type="text" id="original_url"  class="form-control div_track" style="width:40%;display: none;" readonly />
                                  <input class="form-check-input switch-primary check-size" type="checkbox" role="switch" id="chk_track" name="chk_track" value="tracking_url_btn" style="margin-left: 0%;">
                                  <label class="form-label" for="exampleInputPassword6" style="margin-left: 5px;">Tracking Link</label>
                                </div>
                          </div>  
                                              
                            <div class="row">
                            <div class="col">
                            <div class="mb-3"> 
                            <div class="row">
                            <div class="col">
                            <button class="btn btn-primary" id="send_sms" name="btn_send_sms" type="submit" value="send now"><i class="fa-solid fa-paper-plane fa-fw" style="margin-right:8px;"></i>Send Now</button>
                            </div>
                            <div class="col">
                            <button class="btn btn-secondary" type="button" id="schedule_later_btn"><i class="fa-solid fa-hourglass fa-fw" style="margin-right: 8px;"></i>Schedule</button>
                            </div>
                            <div class="col">
                            <button class="btn btn-danger" type="reset" value="Cancel"><i class="fa-solid fa-ban fa-fw" style="margin-right: 8px;"></i>cancel</button>
                            </div>
                            </div>
                          </div>
                        </div>

                        

                      </div>
                        </div>
                      </div>
              
                    </div></div>
                      <div class="col"><div class="card-body">
                       <div class="row">
                        <div class="col">
                        
                         
                        </div>
                       
                       
                      </div>
                      <div class="row">
                        <div class="col">
                        <div class="progress sm-progress-bar overflow-visible" style="width: 63%;">
                                  <div class="progress-bar-animated small-progressbar bg-primary rounded-pill progress-bar-striped" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="bar"><span class="txt-primary progress-label" id="bar_per">0</span><span class="animate-circle"></span></div>
                        </div>
                          <div class="mb-3">
                          <label class="form-label" for="formFileSimple">Upload (csv or xlsx) &nbsp;<a href="sample_csv_files/sample-bulk.csv" >download sample </a></label>
                              <div class="row">
                                <div class="col">
                                  <input class="form-control btn-pill px-4" id="uploadfile" name="uploadfile" type="file" style="margin-top:-3%">
                                </div>
                                <div class="col">
                                  <button type="button" class="csv_xls_txt btn btn-outline-primary" value="" id="importBtn_bulk" style="height:36px;margin-top:-2%;">
                                  <!-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-upload"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg> -->
                                  <i class="fa-solid fa-upload fa-fw" style="margin-left: 4%;"></i>
                                </div>
                               
                                
                              </div>

                          </div>
                          
                         
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <div class="mb-3">
                            <label class="form-label" for="exampleInputPassword6">Group</label>
                            <select id="group_id" class="form-select btn-pill" name='group_id[]' style="width:48%;">                         
                          </select>
                          </div>
                        </div>
                      </div>
                     
                      <div class="row">
                        <div class="col">
                          <div class="mb-0">
                          
                        </div>
                        </div>
                      </div>
                      <div class="row"> 
                        <div class="col">
                          <div class="mb-3"> 
                            <label class="form-label">Test Number</label>
                            <div class="row">
                            <div class="col">
                            <input class="form-control btn-pill" type="text" name="test_numbers"  id="test_numbers" placeholder="Type number to test the message" aria-label="default input example">
                          </div>
                          <div class="col">
                          <button id="send_test_msg" class="btn btn-success" name="send_test_msg" type="submit" value="btn_test" >Test Message<i class="fa-solid fa-check-double fa-fw" style="margin-left: 8px;"></i></button>
                          </div>
                          </div>
                          </div>
                        </div>
                      </div>
                      <input type="hidden" name="is_schedule" id="is_schedule" value="">
                      <!-- <div class="row">
                          <div class="col">
                          <div class="mb-3">
                            <label class="form-label" for="exampleInputPassword6">Schedule</label>
                            <input type="hidden" name="is_schedule" id="is_schedule" value="">
                            <input class="form-control datetimepicker btn-pill" id="datepicker" type="text" placeholder="dd/mm/YYYY HH:MM"   name="scheduleDateTime" style="width:80%;"/>
                             <input class="form-control btn-pill" id="datepicker" type="datetime-local" value="" name="scheduleDateTime"> 
                          </div>
                        </div>
                      </div> -->

                      <div class="row">
                        <div class="col">
                          <div>                          
                          </div>
                        </div>
                      </div>
                      <input type="hidden" id="submitBtnValue" name="submitBtnValue" value="">
                    </div></div>  

                      </div>
                        
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js?=<?=time();?>"></script>
        
        <script src="<?php echo $baseURL ; ?>assets/js/datatable/datatables/jquery.dataTables.min.js?<?= time() ; ?>"></script>
    <script src="<?php echo $baseURL ; ?>assets/js/datatable/datatables/datatable.custom.js?<?= time() ; ?>"></script>
    <script src="<?php echo $baseURL ; ?>assets/js/datatable/datatables/datatable.custom1.js?<?= time() ; ?>"></script>
                  <?php include_once('include/modal_forms/schedule_later_modal.php');
                  ?>
                    
                   
                  </form>
                  </div>
                </div>
              </div>
              <!-- Zero Configuration  Ends-->
            </div>
          </div>
       
<?php 
$_SESSION['form_name']='bulk_sms';
include_once('include/modal_forms/url_tracking_modal.php');

?>
     <script>
    document.addEventListener("DOMContentLoaded", function() {
     flatpickr(".datetimepicker", {
       minDate: <?php echo "'".$minDate."'"; ?>, // Set your minimum date here
       // Set your maximum date here
        enableTime: true,
            dateFormat: "d/m/Y h:i K",
            time_24hr: false,
     });
   });
</script>
        <script src="assets/js/bulk_sms_function.js?=<?=time();?>"></script>
 <script src="assets/js/ajaxupload.js?=<?=time();?>"></script>
<!--  <script src="assets/js/sender_id_function.js?=<?=time();?>"></script> -->

<script src="assets/js/jquery.multiselect.js?=<?=time();?>"></script>