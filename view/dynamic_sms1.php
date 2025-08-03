 
          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Dynamic SMS</h4>
                  </div>

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
                  <div class="card-body">
                    
                  <table class="table table-border">
                    <tbody id="table_data">
                    </tbody>
                  </table>
                  <hr width="100%">     
                
                    <a href="sample_csv_files/sample-dynamic.csv" style="margin-left:4%;">download sample file</a>

                   
                     <form class="form theme-form dark-inputs" id="sendSMSForm"  name="sendSMSForm" method="POST" enctype="multipart/form-data">
                      
                     <input type="hidden" name="type" id="type" value="sendDynamicSMSSave">  
                    <input type="hidden" name="upload_file_name" id="upload_file_name" value="">  
                    <input id="txtpreview" name="txtpreview" type="hidden" value="">  

                      <div class="row">
                      <div class="col"><div class="card-body">
                       <div class="row" style="margin-left:1%;">
                        <div class="col">
                          <div class="mb-4">
                          
                           
                               
                             
                                <label class="form-label" for="exampleFormControlSelect7">Upload File</label> 
                            <input class="form-control btn-pill px-4" id="uploadfile" name="uploadfile" type="file" style="width:25%;">
                            <!-- <div class="btn btn-outline-primary ms-2" style="
                  position: relative;
                  left: 26%;margin-top: -6%;">  -->
                  <button type="button" class="btn btn-outline-primary ms-2" value="" id="importBtn_bulk" style="
                  position: relative;
                  left: 26%;margin-top: -6%;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-upload"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>Upload 
                  </button> 
                  <br>
                  <div class="progress sm-progress-bar overflow-visible" style="width: 25%;">
                                    <div class="progress-bar-animated small-progressbar bg-primary rounded-pill progress-bar-striped" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="bar">
                                      <span class="txt-primary progress-label" id="bar_per">0</span>
                                      <span class="animate-circle"></span>
                                    </div>
                                </div>
                <!-- </div> -->
                              
                            
                          </div>
                        </div>
                        
                        
                      </div>
                      <div class="row">
                      <div class="col"><div class="card-body">
                       <div class="row">
                        <div class="col">
                          <div class="mb-4">
                          
                            <label class="form-label" for="exampleFormControlSelect7">Message Route</label>
                            <select class="form-select btn-pill digits" name="az_routeid" id="az_routeid">
                              
                            </select>
                          </div>
                        </div>
                        
                        
                      </div>
                      <div class="row"> 
                        <div class="col"> 
                          <div class="mb-3 d-flex gap-3 checkbox-checked">
                            <div class="form-check">
                              <input class="form-check-input" id="flexRadioDefault1"  name="char_set" type="radio" name="flexRadioDefault" checked value="Text">
                              <label class="form-check-label mb-0" for="flexRadioDefault1">Text </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" id="flexRadioDefault2" name="char_set" type="radio" name="flexRadioDefault" value="Unicode">
                              <label class="form-check-label mb-0" for="flexRadioDefault2">Unicode</label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <div class="mb-3">
                            <label class="form-label" for="exampleInputPassword6">To</label>
                            <select name="dynamicsms_to_dropdown" id="dynamicsms_to_dropdown" class="form-select btn-pill ">
                    <option value="">Select</option>
                    <!-- <option value=""></option> -->
                  </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <div>
                            <label class="form-label" for="exampleFormControlTextarea9">Message Text</label>
                            <textarea class="form-control btn-pill" rows="5" placeholder="Type Message Here" maxlength="1000" name="message" id="message" onkeypress="checkChar()" onkeyup="checkChar()" onblur="checkChar()"></textarea>  
                          </div>
                          <div class="row"> 
                          <div class="col">
                          <div class="mb-3"> 
                            <div class="row">
                            <div class="col">
                            <button class="btn btn-outline-primary-2x mt-3" type="button" title="btn btn-outline-primary-2x" style="width:102%;">Characters: <span class="length" id="characters"> 0 </span></button>
                            </div>
                            <div class="col">
                            <button class="btn btn-outline-primary-2x mt-3" type="button" title="btn btn-outline-primary-2x">Sms Count: <span class="messages" id="smsCount" name="txtMessageCount">0</span></button>
                            </div>
                            <div class="col">
                            <button class="btn btn-outline-primary-2x mt-3" type="button" title="btn btn-outline-primary-2x" id="preview" name="preview" >Text Preview</button>
                            </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                      
                         
                            <div class="col">
                            <button class="btn btn-primary-gradien mt-3" id="dynamic_sms_btn" type="submit">Send Now</button>
                            </div>
                            <div class="col">
                            <button class="btn btn-primary-gradien mt-3" type="button" id="schedule_later_btn">Schedule</button>
                            </div>
                            <div class="col">
                           </div>
                           <input type="hidden" id="submitBtnValue" name="submitBtnValue" value="">

                        
                      </div>
                        </div>
                      </div>
                    
                    </div></div>
                      <div class="col"><div class="card-body">
                      <div class="row">
                        <div class="col">
                          <div class="mb-3">
                            <label class="form-label" for="exampleFormControlInput5">Sender Id</label>
                            <select class="form-select btn-pill digits" name="sid" id="sid">
                              
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <div class="mb-3">
                            <label class="form-label" for="exampleFormControlInput5">Template Id</label>
                            <select class="form-select btn-pill digits" name="template" id="template">
                              
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <div class="mb-3">
                            <label class="form-label" for="exampleFormControlInput5">Values</label>
                            <select class="form-select btn-pill " name="dynamicsms_placeholder_dropdown" id="dynamicsms_placeholder_dropdown">
                              
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                          <div class="col">
                          <div class="mb-3">
                            <!-- <label class="form-label" for="exampleInputPassword6">Schedule</label> -->
                            <input type="hidden" name="is_schedule" id="is_schedule" value="">
                            <!-- <input class="form-control datetimepicker btn-pill" id="datepicker" name="scheduleDateTime" type="datetime-local" value=""> -->
                          </div>
                        </div>
                      </div>
                      <div class="form-check form-switch form-check-inline">
                              <input class="form-check-input switch-primary check-size" type="checkbox" role="switch"  id="chk_track" name="chk_track" value="tracking_url_btn">
                              <label class="form-label" for="exampleInputPassword6">Tracking URL</label>

                              
                      </div>

                      <div class="form-check form-switch form-check-inline">
                              <input class="form-check-input switch-primary check-size" type="checkbox" role="switch"  id="chk_track2" name="chk_track" value="dynamic_tracking_url_btn">
                              <label class="form-label" for="exampleInputPassword6">Dynamic Tracking URL</label>

                              
                      </div>
                      <div class="row track_url" style="display:none;">
                          <div class="col">
                          <div class="mb-3">
                            <label class="form-label" for="exampleInputPassword6">Original URL</label>
                            <input class="form-control btn-pill" name="original_url" id="original_url" placeholder="Enter your original URL" type="text" >
                            </div>
                          </div>
                        </div>

                        <div class="row dynamic_url" style="display:none;">
                          <div class="col">
                          <div class="mb-3">
                            <label class="form-label" for="exampleInputPassword6">Dynamic URL</label>
                            <select class="form-select btn-pill " name="dynamic_url" id="dynamic_url">
                              
                            </select>
                            </div>
                          </div>
                        </div>
                     
                     
                      
                          
                        <div class="row">
                          <div class="col">
                          <div class="mb-3">
                            <label class="form-label" for="exampleInputPassword6">Campaign Name</label>
                            <input class="form-control btn-pill" name="campaign_name" id="campaign_name" placeholder="Campaign Name" type="text" >
                            </div>
                          </div>
                        </div>
                          </div>
                        </div>
                      </div>
                      
                 
                     
                      <!--<div class="row">
                        <div class="col">
                          <div class="mb-3">
                          
                        </div>
                        </div>
                      </div>-->                      
                      <div class="row">
                        <div class="col">
                          <div>                          
                          </div>
                        </div>
                      </div>
                    
                    </div></div>  

                      </div>
                    
                    
                    <!--<div class="card-footer text-end">  
                      <button class="btn btn-primary me-3" type="submit">Send SMS</button>
                      OR&nbsp;&nbsp;&nbsp;<button class="btn btn-primary me-3" type="submit">Schedule For later</button>
                      OR&nbsp;&nbsp;&nbsp;
                      <input class="btn btn-light" type="reset" value="Cancel">
                    </div>-->
                    <?php include_once('include/modal_forms/schedule_later_modal.php');
                  ?>
                  </form>
                  </div>
                </div>
              </div>
              <!-- Zero Configuration  Ends-->
            </div>
        
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
<?php
include_once('include/modal_forms/compose_modal.php'); 

?>

<script src="assets/js/ajaxupload_dynamic_test.js?=<?=time();?>"></script>
<script src="assets/js/sender_id_function.js?=<?=time();?>"></script>
<!--  <script src="assets/js/sender_id_function.js?=<?=time();?>"></script> -->

<!-- <script src="assets/js/jquery.multiselect.js?=<?=time();?>"></script> -->