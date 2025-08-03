<style type="text/css">
  .txt_border {
    outline: 0;
    border-width: 0 0 2px;
    border-color: blue;
    width:80% ;
  }
  .txt_border:focus {
    border-color: green
  }
  </style>
   <link rel="stylesheet" type="text/css" href="assets/css/jquery.multiselect1.css">
  <div class="card mb-3" style="height:65px;">
   
  
      <div class="bg-holder d-none d-lg-block bg-card" style="background-image: url(assets/img/icons/spot-illustrations/corner-4.png);" ></div>
      <!--/.bg-holder-->
      <div class="card-body position-relative">
        <div class="row">
          <div class="col-lg-4">
            <h4 id="page_name"># RCS SMS</h4>  
          </div>
          <div class="col-lg-8">
          </div>      
        </div>
      </div>
  </div>
  
  <div class="row g-3 mb-3" >
      <div class="col-lg-12">
        <div class="card" style="background-image: url(assets/img/icons/spot-illustrations/corner-2.png);background-position: right;background-repeat: no-repeat;">
          <div class="card-body" >
  
                <div class="container" >
                  <form id="sendRCSSMSForm"  name="sendRCSSMSForm" method="POST">
                    <input type="hidden" name="type" value="sendRCSSMS">
                    <input type="hidden" name="is_schedule" id="is_schedule" value="">
                  <div class="row">
                    <div class="col-4">
                    <label class="form-label" >Bot Type<span style="color:red;">*</span></label>
                    <select class="form-select suggestion_dropdown" name="bot_type" id="bot_type" >
                                    <option value="">Select Bot Type</option>
                                    <option value="Trans">Trans</option>
                                    <option value="Promo">Promo</option>
                                    <option value="Otp">OTP</option>
                      </select>
                       
                      <div class="invalid-feedback">Please select suggestion</div>
                    </div>
                  
                  <div class="col-4">
                     <label class="form-label"  >Template<span style="color:red;">*</span></label> 
                     <select class="form-select suggestion_dropdown" name="template" id="template" >
                                    <option value="">Select Template</option>
                                   
                      </select>
                       <div class="invalid-feedback">You must add message title (min 10 characters)</div>
                    
  
  
                    </div>
                 
                 
                  </div>
  
                  <br/>
  
                    <div class="row">
                    
                     <div class="col-4">
                      <label class="form-label" for="bootstrap-wizard-validation-wizard-password">Message Format</label>
                            <br/>
                           <input class="form-check-input msg_format " type="radio" name="msg_format" id="numbers_lbl" value="numbers" checked>
                          <label class="form-check-label" for="numbers" id="numbers_lbl2" >Numbers</label>
                          &nbsp;
                          <input class="form-check-input msg_format" type="radio" name="msg_format" id="groups_lbl" value="groups">
                      <label class="form-check-label" for="groups"  id="group_lbl2">Groups</label>&nbsp;
                           <input class="form-check-input msg_format " type="radio" name="msg_format" id="file_type_lbl" value="csv_xls_txt"> &nbsp;
                      <label class="form-check-label" for="file_type">CSV / XLS / TXT</label>
                      
                        
  
                    </div>
               
  
             <!--    <div class="col-6">
                   <label class="form-label" id="msg_format_lbl" >Mobile Number<span style="color:red;">*</span></label>   <textarea class="form-control" placeholder="Type Numbers Separeated by New Line" id="numbers" name="numbers" rows="4" onKeyPress="return isNumberKeyOrFloat(event);" onkeyup="countNo('numbers','counti')" aria-label="numbers" aria-describedby="basic-addon1" ></textarea>
                         <div class="invalid-feedback">Please add mobile numbers</div>
  
                            <select id="group_id" class="" name='group_id[]' style="display: none;float: left;" aria-label="group_id" aria-describedby="basic-addon1" multiple>                         
                            </select>
  
                             <input type="file" class="form-control csv_xls_txt" id="importBtn_bulk" name="uploadfile" style="display:none;">
                             <br>
                               <button class="btn btn-outline-primary btn-sm mb-1" id="msg-btn-mb-cnt" value="Characters" type="button" onclick="myFunc();">
  
                                No's : <span class="" id="counti">0</span></button>
  
  
                                <input type="button" class="btn btn-primary carousal_btn" style="float:right;display: none;" id="card_repeat" value="+">
                   
                </div> -->
                  </div>
            
                           <hr width="100%">
                    <div class="row">
                    <div class="col-4">
                        <span class="open_url" style="display:none;">
                       <!-- <label class="form-label url" for="bootstrap-wizard-wizard-url" >Web URL</label --><input class=" txt_border" type="text" name="open_web_url" maxlength="200" placeholder="Web URL"  />
                       
                      <!--  <input class="form-control postback_reply" type="text" name="suggested_reply" maxlength="200" placeholder="URL Reply" pattern="^([a-zA-Z0-9_.-]){5,180}$"  id="bootstrap-wizard-validation-wizard-email" data-wizard-validate-email="true" /> -->
                       
                            <div class="invalid-feedback ">You must add URL</div>
                          
                          </span>
                        </div>
                         <div class="col-4">
                        <span class="open_url" style="display:none;">
                       <!-- <label class="form-label url" for="bootstrap-wizard-wizard-url" >Web URL</label --><input class=" txt_border" type="text" name="open_url_title" maxlength="200" placeholder="Web URL Title"  />
                       
                      <!--  <input class="form-control postback_reply" type="text" name="suggested_reply" maxlength="200" placeholder="URL Reply" pattern="^([a-zA-Z0-9_.-]){5,180}$"  id="bootstrap-wizard-validation-wizard-email" data-wizard-validate-email="true" /> -->
                       
                            <div class="invalid-feedback ">You must add URL</div>
                          
                          </span>
                        </div>
                      </div>
  
                      <div class="row">
                           <div class="col-4">
                   <label class="form-label" id="msg_format_lbl" >Mobile Number<span style="color:red;">*</span></label>   <textarea class="form-control" placeholder="Type Numbers Separeated by New Line" id="numbers" name="numbers" rows="4" onKeyPress="return isNumberKeyOrFloat(event);" onkeyup="countNo('numbers','counti')" aria-label="numbers" aria-describedby="basic-addon1" ></textarea>
                         <div class="invalid-feedback">Please add mobile numbers</div>
  
                            <select id="group_id" class="" name='group_id[]' style="display: none;float: left;" aria-label="group_id" aria-describedby="basic-addon1" multiple>                         
                            </select>
  
                             <input type="file" class="form-control csv_xls_txt" id="importBtn_bulk" name="uploadfile" style="display:none;">
                             <br>
                               <button class="btn btn-outline-primary btn-sm mb-1" id="msg-btn-mb-cnt" value="Characters" type="button" onclick="myFunc();">
  
                                No's : <span class="" id="counti">0</span></button>
  
  
                                <input type="button" class="btn btn-primary carousal_btn" style="float:right;display: none;" id="card_repeat" value="+">
                   
                </div>
  
                   <div class="col-4 template_msg">
                   <label class="form-label" id="msg_lbl" >Message<span style="color:red;">*</span></label>   <textarea class="form-control" placeholder="Template message" id="message" name="message" rows="4"  aria-label="message" aria-describedby="basic-addon1" readonly></textarea>
                                         <input type="hidden" name="sms_type" id="sms_type" value="simple">
                    </div>
  
                    <div class="col-4 template_msg">
                   <label class="form-label" id="msg_lbl" >Variable Values</label>  
                   <table id="dynamicTable" border="1">
                      <thead style="border:1px solid black;">
                          <tr style="border:1px solid black;">
                              <th>Variable</th>
                              <th>Value</th>
                          </tr>
                      </thead>
                      <tbody style="border:1px solid black;"></tbody>
                  </table>
                                         
                    </div>
                      </div>
  
                      <!-- Dial Action start-->
                       <div class="row">
                    <div class="col-4">
                        <span class="dial_action" style="display:none;">
                       <!-- <label class="form-label url" for="bootstrap-wizard-wizard-url" >Web URL</label --><input class=" txt_border" type="text" name="dial_title1" maxlength="200" placeholder="Dial Title"  />
                       
                     
                       
                            <div class="invalid-feedback ">You must add Dial Title</div>
                          
                          </span>
                        </div>
                         <div class="col-4">
                        <span class="dial_action" style="display:none;">
                       <!-- <label class="form-label url" for="bootstrap-wizard-wizard-url" >Web URL</label --><input class=" txt_border" type="text" name="dial_number" maxlength="200" placeholder="Dial Number"  />
                       
                            <div class="invalid-feedback ">You must add Dial Number</div>
                          
                          </span>
                        </div>
                      </div>
  
                      <!-- Dial Action End -->
                           <span class="repeat_section carousal ">
                             <input type="button" class="btn btn-danger card_remove" style="float:right;display: none;" value="-" id="remove1"/>
                            <br/>
                            <span ><b class="card_count carousal" style="display:none;">#Card 1</b></span>
                            <br/>
                  <div class="row">
                    <div class="col-4">
                      <span class="title" style="display: none;">
                   <!--   <label class="title" >Card Title<span style="color:red;">*</span></label> --><input class="title txt_border" type="text" name="card_title[]" maxlength="200" placeholder="Card Title" pattern="^([a-zA-Z0-9_.-]){5,180}$"  id="title" />
                            <div class="invalid-feedback">You must add Card Title (min 10 characters)</div>
  
                      </span>
  
                    
                    </div>
                    <div class="col-4">
                       <span class="url"  style="display: none;">
                       <!-- <label class="form-label url" for="bootstrap-wizard-wizard-url" >Web URL</label --><input class="url txt_border" type="text" name="web_url[]" maxlength="200" placeholder="Web URL" pattern=""   />
                       
                      <!--  <input class="form-control postback_reply" type="text" name="suggested_reply" maxlength="200" placeholder="URL Reply" pattern="^([a-zA-Z0-9_.-]){5,180}$"  id="bootstrap-wizard-validation-wizard-email" data-wizard-validate-email="true" /> -->
                       
                            <div class="invalid-feedback url">You must add URL</div>
                          
                          </span>
                    </div>
                    <div class="col-4">
                      <span class="url"  style="display: none;">
                       <!-- <label class="form-label url" for="bootstrap-wizard-wizard-url" >URL Title</label> -->
                       
                        <input class="txt_border url_title" type="text" name="url_title[]" maxlength="200" placeholder="Web URL Title" pattern="^([a-zA-Z0-9_.-]){5,180}$" />
                       
                      <!--  <input class="form-control postback_reply" type="text" name="suggested_reply" maxlength="200" placeholder="URL Reply" pattern="^([a-zA-Z0-9_.-]){5,180}$"  id="bootstrap-wizard-validation-wizard-email" data-wizard-validate-email="true" /> -->
                       
                            <div class="invalid-feedback url">You must add URL</div>
                          
                          </span>
                    </div>
                  </div>
  
                
                  <br>
  
                  <div class="row">
                    <div class="col-4">
                          <span class="image_url"  style="display: none;">
                       <!-- <label class="form-label postback_reply" for="bootstrap-wizard-wizard-email" >Card Image URL<span style="color:red;">*</span></label> --><input class="postback_reply txt_border" type="text" name="image_url[]" maxlength="200" placeholder="Card Image URL" />
                            <div class="invalid-feedback postback_reply">You must add card image URL</div>
                    </span>
  
                    </div>
                    <div class="col-4">
                        <span style="display:none;" class="rich_dial_number">
                           <!--  <label class="form-label rich_dial_number" for="bootstrap-wizard-wizard-number" >Dial Number</label> --><input class="txt_border rich_dial_number" type="text" name="rich_dial_number[]" maxlength="13" placeholder="Enter Dial Number" value="" />
                            <div class="invalid-feedback">You must add dial number</div>
  
                             
                       
                 
                       
                      </span>
                    </div>
                     <div class="col-4">
  
                    <span style="display:none;" class="rich_dial_number">
                            <!-- <label class="form-label rich_dial_number" for="bootstrap-wizard-wizard-number" >Dial Number</label> -->
                           
                             
                        <input class="txt_border" type="text" name="dial_title[]" maxlength="200" placeholder="Dial Action Title" pattern="^([a-zA-Z0-9_.-]){5,180}$"/>
                         <div class="invalid-feedback">You must add dial number</div>
  
                 
                       
                      </span>
                    </div>
                   
                  </div>
  
              
                <br>
  
                  <div class="row">
                    <div class="col-4">
                         <span class="thumbnail_url"  style="display: none;">
                      <!--  <label class="form-label postback_reply" for="bootstrap-wizard-wizard-email" >Thumbnail URL<span style="color:red;">*</span></label> --><input class="txt_border postback_reply" type="text" name="thumbnail_url[]" maxlength="200" placeholder="Thumbnail URL"   id="thumbnail_url" />
                            <div class="invalid-feedback">You must add thumbnail URL</div>
                      </span>
                    </div>
                    <div class="col-4"><span class="message_desc"  style="display: none;">
                      <!--  <label class="form-label postback_reply" for="bootstrap-wizard-wizard-email" >Thumbnail URL<span style="color:red;">*</span></label> --><input class="txt_border postback_reply" type="text" name="card_content[]" maxlength="500" placeholder="Card Description"   id="card_desc" />
                            <div class="invalid-feedback">You must add message desc</div>
                      </span></div>
                    <div class="col-4">
                       <!-- <button type="submit" class="btn btn-primary" id="send_rcs_sms">Send SMS</button>
                       <button type="reset" class="btn btn-secondary" id="cancel">Clear</button> -->
                    </div>
                     
                  </div>
                  <hr width="100%" class="carousal" style="display:none;">
                </span>
                  <br>
  
  
  
                  <div class="row">
                    <div class="col-4">
                        
                    </div>
                    <div class="col-4">
                       <button type="submit" class="btn btn-primary" id="send_rcs_sms"><i class="fa-solid fa-paper-plane fa-fw" style="margin-right: 8px;"></i>Send SMS</button>&nbsp;&nbsp;&nbsp;
                       <button type="reset" class="btn btn-secondary" id="cancel"><i class="fa-solid fa-ban fa-fw" style="margin-right: 8px;"></i>Clear</button>
                    </div>
                    <div class="col-4">
                      
                    </div>
                     
                  </div>
                  
  
                  <br>
  
                </form>
              </div>
            </div>
          </div>
        </div>
  </div>
  
   <script src="assets/js/rcs_sms.js"></script>
   <script src="assets/js/ajaxupload.js"></script>
   <script src="assets/js/jquery.multiselect.js"></script>