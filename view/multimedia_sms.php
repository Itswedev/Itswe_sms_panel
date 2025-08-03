 <?php 
 session_start();
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
error_reporting(0);
/*include('controller/sender_id_function.php');*/
/*include('controller/template_function.php');*/

  ?>

  <link rel="stylesheet" type="text/css" href="assets/css/jquery.multiselect.css">
  <style type="text/css">
    #muliselect_div
    {
      width: 80%;
    }
  </style>
     <div class="card mb-3">
            <div class="bg-holder d-none d-lg-block bg-card" style="background-image: url(assets/img/icons/spot-illustrations/corner-4.png);" ></div>
            <!--/.bg-holder-->
            <div class="card-body position-relative">
              <div class="row">
                <div class="col-lg-8">
                   <h3 ><!-- <span class="typed-text fw-bold ms-1" data-typed-text='["Bulk SMS"]'></span> -->#Voice Call</h3>
                  <span class="page_name" style="display:none;">multimedia_sms</span>
                </div>
              </div>
            </div>
          </div>

<div class="modal" tabindex="-1" role="dialog" id="loading_modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     
      <div class="modal-body">
       <span id="loading"><img src="assets/images/message_send.gif" height="10%" width="100%" /></span>
      </div>
     
    </div>
  </div>
</div>



 <form id="sendCALLForm"  name="sendCALLForm" method="POST">
                         <input type="hidden" name="type" id="type" value="sendCALLsave">
                         <input type="hidden" id="submitBtnValue" name="submitBtnValue" value="">
          <div class="row g-3 mb-3">
            
            <div class="col-lg-12">
              <div class="card" style="background-image: url(assets/img/icons/spot-illustrations/corner-4.png);background-position: right;background-repeat: no-repeat;">
                
                <div class="card-body">
                  
                     <div class="row mb-3">
                      <div class="col col-md-1">
                          <label for="inputEmail3" class="">Select File</label>
                        </div>
                        <div class="pmd-textfield col col-md-4" >
                        <select  class="form-select " name="voice_file" id="voice_file" aria-label="voice_file" aria-describedby="basic-addon1" style="width:80%;">
                          <option value="" selected >Select File</option>
                                                                    
                          
                        </select>
                        <br>
                        <label for="inputEmail3" class="">Duration : </label><label for="inputEmail3" class="" id="disp_duration"> 0</label> <label for="inputEmail3" class=""> sec</label>
                        </div>

                           <div class="col col-md-1">
                          <label for="inputEmail3" class="">Campaign Name</label>
                        </div>
                        <div class="pmd-textfield col col-md-4" >
                             <input type="text" class="form-control" name="campaign_name" id="campaign_name" placeholder="Campaign Name" aria-label="campaign_name" aria-describedby="basic-addon1" style="width:80%;">
                          
                            
                        </div>
                       
                     </div>

                     <div class="row mb-3">
                      <div class="col col-md-1">
                          <label for="inputEmail3" class="">Retry Attempt</label>
                        </div>
                        <div class="pmd-textfield col col-md-4" >
                          <select  class="form-select " name="retry_attempt" id="retry_attempt" aria-label="retry_attempt" aria-describedby="basic-addon1" style="width:80%;">
                          <option value="" selected >Select Retry Attempt</option>
                          <option value="0"  >0</option>
                          <option value="1"  >1</option>
                          <option value="2"  >2</option>
                          <option value="3"  >3</option>
                                                                    
                          
                        </select>
                        </div>

                           <div class="col col-md-1">
                          <label for="inputEmail3" class="">Retry Duration</label>
                        </div>
                        <div class="pmd-textfield col col-md-4" >
                             <select  class="form-select " name="retry_duration" id="retry_duration" aria-label="retry_duration" aria-describedby="basic-addon1" style="width:80%;">
                          <option value="" selected >Select Duration</option>
                          <option value="0"  >0</option>
                          <option value="15"  >15 Mins</option>
                          <option value="30"  >30 Mins</option>
                          <option value="60"  >1 Hour</option>
                                                                    
                          
                        </select>
                            
                        </div>
                       
                     </div>

                     <div class="row mb-3">
                      <div class="col col-md-1">
                          <label for="inputEmail3" class="">Number Format</label>
                        </div>
                        <div class="pmd-textfield col col-md-4" >
                               <div class="form-check form-check-inline">
                        <input class="form-check-input msg_format" type="radio" name="msg_format" id="numbers_lbl" value="numbers" checked>
                        <label class="form-check-label" for="numbers" id="numbers_lbl2" >Numbers</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input msg_format" type="radio" name="msg_format" id="groups_lbl" value="groups">
                    <label class="form-check-label" for="groups"  id="group_lbl2">Groups</label>
                  </div>


                  <div class="form-check form-check-inline">
                   <input class="form-check-input msg_format" type="radio" name="msg_format" id="file_type_lbl" value="csv_xls_txt">
                    <label class="form-check-label" for="file_type">CSV </label>
                  </div>

                </div>

                  
                      
                           <div class="col col-md-1">
                          <label for="inputEmail3" class="">Caller</label>
                        </div>
                        <div class="pmd-textfield col col-md-4" >
                             <span class="form-check form-switch"><input class="form-check-input" id="vsms" name="vsms" value="vsms" type="checkbox"  /><label class="form-check-label" for="flexSwitchCheckChecked">On</label>
                            <select  class="form-select " name="caller_id" id="caller_id" aria-label="retry_duration" aria-describedby="basic-addon1" style="    width: 51%; margin-top: -9%; margin-left: 28%;display: none;">
                          <option value="" selected >Select Caller ID</option>
                         <!--  <option value="07447120331">07447120331</option> -->
                          
                                                                    
                          
                        </select>
                        </div>

                     
                  
                     

                     </span>
                     <!--  <span class="form-check form-switch" style="margin-left: 40%;margin-top: -10%;">
                        <input class="form-check-input" id="chk_track" name="chk_track" value="tracking_url_btn" type="checkbox"  /><label class="form-check-label" for="flexSwitchCheckChecked">Tracking URL</label>
                     </span> -->
                    
                      
               

                       
                     </div>



                     <div class="row mb-3">
                      <div class="col col-md-1">
                          <label for="inputEmail3" class="">Method</label>
                        </div>
                        
                  
                      
                  <div class="pmd-textfield col col-md-4" >
                    <div class="form-check form-check-inline">
                        <input class="form-check-input method" type="radio" name="method" id="simple" value="Simple" checked>
                        <label class="form-check-label" for="numbers" id="numbers_lbl3" >Simple&nbsp;&nbsp;&nbsp;&nbsp;</label>
                  </div>
                  
                  <div class="form-check form-check-inline">
                    <input class="form-check-input method" type="radio" name="method" id="dtmf" value="DTMF">
                    <label class="form-check-label" for="groups"  id="group_lbl2">DTMF&nbsp;&nbsp;&nbsp;&nbsp;</label>
                  </div>

                  <div class="form-check form-check-inline">
                    <input class="form-check-input method" type="radio" name="method" id="call_latching" value="call latching">
                    <label class="form-check-label" for="groups"  id="group_lbl4">Call Latch</label>
                  </div>

                  <div class="form-check form-check-inline">
                   <select class="form-select " name="wait_duration" id="wait_duration" aria-label="retry_duration" aria-describedby="basic-addon1" style="width: 91%; margin-top: -9%; margin-left: -4%;display:none;">
                          <option value="" selected >Wait Duration</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                    </select>
                  </div>

                </div>


                    
                       
                     </div>



                     <div class="row mb-3">
                      <div class="col col-md-1">
                          <label for="inputEmail3" id="msg_format_lbl">Numbers</label>
                        </div>
                        <div class="pmd-textfield col col-md-4" >
                        

                        <textarea class="form-control" placeholder="Type Numbers Separeated by New Line" id="numbers" name="numbers" style="height: 113%;width: 80%;" onKeyPress="return isNumberKeyOrFloat(event);" onkeyup="countNo('numbers','counti')" aria-label="numbers" aria-describedby="basic-addon1" ></textarea>

                          <select id="group_id" class="" name='group_id[]' style="display: none;width: 80%;float: left;" aria-label="group_id" aria-describedby="basic-addon1" multiple>                         
                          </select>
                          <!-- <form id="#upload_file_form" name="form1"enctype="multipart/form-data" method="POST"> -->
                           <input type="file" class="form-control csv_xls_txt" id="uploadfile" name="uploadfile" style="display:none;width: 65%;float: left;" >
                           <!-- <input type="hidden" name="act" value="import3"> -->
                             <button type="button" class="csv_xls_txt btn btn-outline-primary" value="" id="importBtn_bulk" style="display:none;width: 15%;">
                              <span class="fas fa-upload me-1" data-fa-transform="shrink-3"></span>
                            </button>
                            
                           <div class="progress mb-3 csv_xls_txt" style="height:15px;width: 80%;display:none;">

                            <div class="progress-bar csv_xls_txt" role="progressbar" style="display:none;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" id="bar"></div>
                          </div>
                         <!-- </form> -->
                           <br>
                             <button class="btn btn-outline-primary btn-sm mb-1" id="msg-btn-mb-cnt" value="Characters" type="button" onclick="myFunc();">
                              No's : <span class="" id="counti">0</span></button>

                        </div>

                          <div class="col col-md-1">
                          <!-- <label for="inputEmail3" class="">Schedule Call</label> -->
                        </div>
                        <div class="pmd-textfield col col-md-4" >
                            <input type="hidden" name="is_schedule" id="is_schedule" value="">
                           <!-- <input class="form-control datetimepicker" id="datepicker" type="text" placeholder="dd/mm/yyyy H:i"  data-options='{"disableMobile":true,"enableTime":true,"dateFormat":"d/m/Y H:i"}' name="scheduleDateTime" aria-label="scheduleDateTime" aria-describedby="basic-addon1" style="width:80%;"/>
                           -->
                        </div>


                        

                       
                     </div>
                     <br>
                      <br>
                       <br>
                       <div class="row mb-3">
                   

                   
                      


                     </div>

                     <div class="row mb-3">
                    
                      
                           <div class="col col-md-1">
                        
                        </div>
                        <div class="pmd-textfield col col-md-4" >
                           <button type="submit" class="btn btn-primary btn_send" id="send_call" name="btn_send_sms"><i class="fa-solid fa-paper-plane fa-fw" style="margin-right: 8px;"></i>Send Call</button>&nbsp;&nbsp;&nbsp;
                           <button type="button" class="btn btn-secondary" id="schedule_later_btn"><i class="fa-solid fa-hourglass fa-fw" style="margin-right: 8px;"></i>Schedule Call</button>
                            <!-- <button type="submit" class="btn btn-secondary btn_send" id="schedule_call" name="btn_schedule_sms">Schedule Call</button>
                           -->
                        </div>

                   
                     </div>


                     <?php include_once('include/modal_forms/schedule_later_modal.php');
                  ?>
                    
              </div>
            </div>
          </div>
        </div>




  </form>


<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>


<script type="text/javascript" src="assets/js/chosen.jquery.js"></script>
<script src="assets/js/jquery.multiselect.js"></script>
<script src="assets/js/voice_call.js?=<?=time();?>"></script>