<?php
session_start();
$username=$_SESSION['user_name'];
$api_key=$_SESSION['api_key'];
// $web_url=$_SESSION['web_url'];
$web_url=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
?>
<link rel="stylesheet" type="text/css" href="assets/css/vendors/sweetalert2.css">
   
   <div class="page-body">
   <div class="card mb-3">
            <div class="bg-holder d-none d-lg-block bg-card" style="background-image: url(../assets/img/icons/spot-illustrations/corner-4.png);" ></div>
            <!--/.bg-holder-->
            <div class="card-body position-relative">
              <div class="row">
                <div class="col-lg-8">
                  <h3><span id="page_name">HTTP-API</span></h3>
                  
                </div>
                  <div class="col-lg-4">
                  
                </div>
              </div>
            </div>
          </div>



        <div class="row g-3 mb-3">
            
            <div class="col-lg-12">
              <div class="card" >
                
                <div class="card-body">

                  <div id="action_message" style="display:none"></div>

        <ul class="nav nav-pills" id="pill-myTab" role="tablist">
  <li class="nav-item"><a class="nav-link active" id="pill-home-tab" data-bs-toggle="tab" href="#pill-tab-home" role="tab" aria-controls="pill-tab-home" aria-selected="true">API</a></li>
  <li class="nav-item"><a class="nav-link" id="pill-self-tab" data-bs-toggle="tab" href="#pill-tab-self" role="tab" aria-controls="pill-tab-self" aria-selected="false">Document</a></li>
  
  
</ul>

<div class="tab-content border p-3 mt-3" id="pill-myTabContent">


  <div class="tab-pane fade show active" id="pill-tab-home" role="tabpanel" aria-labelledby="home-tab" style="overflow-x:auto;">     
				<div id="tableExample2" data-list='{"valueNames":["name","email","age"],"page":5,"pagination":true}'>
				  <div class="table-responsive scrollbar">
          <div class="accordion" id="accordionExample">
          <div class="accordion-item">
                        <h2 class="accordion-header" id="heading1"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">Send SMS HTTP API - Simple Text Message</button></h2>
                        <div class="accordion-collapse collapse show" id="collapse1" aria-labelledby="heading1" data-bs-parent="#accordionExample">
                          <div class="accordion-body"><?php echo $web_url; ?>/api.php?username=<?php echo $username; ?>&apikey=<?php echo $api_key; ?>&senderid=senderid&route=route_name&mobile=mobile_number&text=message</div>
                        </div>
                      </div>
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="heading5"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="true" aria-controls="collapse5">Send SMS HTTP API - With Template Id & PEID</button></h2>
                        <div class="accordion-collapse collapse" id="collapse5" aria-labelledby="heading5" data-bs-parent="#accordionExample">
                          <div class="accordion-body"><?php echo $web_url; ?>/api.php?username=<?php echo $username; ?>&apikey=<?php echo $api_key; ?>&senderid=senderid&route=route_name&mobile=mobile_number&text=message&TID=template_id&PEID=peid</div>
                        </div>
                      </div>
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="heading2"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="true" aria-controls="collapse2">Send SMS HTTP API - Unicode Message</button></h2>
                        <div class="accordion-collapse collapse" id="collapse2" aria-labelledby="heading2" data-bs-parent="#accordionExample">
                          <div class="accordion-body"><?php echo $web_url; ?>/api.php?username=<?php echo $username; ?>&apikey=<?php echo $api_key; ?>&senderid=senderid&route=route_name&mobile=mobile_number&text=message&msgtype=unicode</div>
                        </div>
                      </div>
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="heading3"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="true" aria-controls="collapse3">Send SMS HTTP API - with Group </button></h2>
                        <div class="accordion-collapse collapse" id="collapse3" aria-labelledby="heading3" data-bs-parent="#accordionExample">
                          <div class="accordion-body"><?php echo $web_url; ?>/api.php?username=<?php echo $username; ?>&apikey=<?php echo $api_key; ?>&senderid=senderid&route=route_name&text=message&group=group_name</div>
                        </div>
                      </div>
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="heading4"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="true" aria-controls="collapse4">Send SMS HTTP API - Response Format (HTML / XML / JSON )</button></h2>
                        <div class="accordion-collapse collapse" id="collapse4" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                          <div class="accordion-body"><?php echo $web_url; ?>/api.php?username=<?php echo $username; ?>&apikey=<?php echo $api_key; ?>&senderid=senderid&route=route_name&mobile=mobile_number&text=message&format=json</div>
                        </div>
                      </div>
                      <!-- <div class="accordion-item">
                        <h2 class="accordion-header" id="heading6"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="true" aria-controls="collapse6">Send SMS HTTP API - For Google Verified SMS</button></h2>
                        <div class="accordion-collapse collapse" id="collapse6" aria-labelledby="heading6" data-bs-parent="#accordionExample">
                          <div class="accordion-body"><?php echo $web_url; ?>/api.php?username=<?php echo $username; ?>&apikey=<?php echo $api_key; ?>&senderid=senderid&route=route_name&mobile=mobile_number&text=message&vsms=Yes</div>
                        </div>
                      </div> -->
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="heading7"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="true" aria-controls="collapse7">Send SMS HTTP API - Schedule SMS ('dd/mm/YYYY 00:00:00')</button></h2>
                        <div class="accordion-collapse collapse" id="collapse7" aria-labelledby="heading7" data-bs-parent="#accordionExample">
                          <div class="accordion-body"><?php echo $web_url; ?>/api.php?username=<?php echo $username; ?>&apikey=<?php echo $api_key; ?>&senderid=senderid&route=route_name&mobile=mobile_number&text=message&schedule=schedule_date_time</div>
                        </div>
                      </div>
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="heading8"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8" aria-expanded="true" aria-controls="collapse8">Get SMS Response API </button></h2>
                        <div class="accordion-collapse collapse" id="collapse8" aria-labelledby="heading8" data-bs-parent="#accordionExample">
                          <div class="accordion-body"><?php echo $web_url; ?>/api_resp.php?username=<?php echo $username; ?>&apikey=<?php echo $api_key; ?>&format=json/html&message_id=MessageID</div>
                        </div>
                      </div>
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="heading9"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9" aria-expanded="true" aria-controls="collapse9">Get Route Balance API </button></h2>
                        <div class="accordion-collapse collapse" id="collapse9" aria-labelledby="heading9" data-bs-parent="#accordionExample">
                          <div class="accordion-body"><?php echo $web_url; ?>/api_balance.php?username=<?php echo $username; ?>&apikey=<?php echo $api_key; ?>&format=json/html</div>
                        </div>
                      </div>
        
          </div>
				  </div>
				  <div class="d-flex justify-content-center mt-3"><button class="btn btn-sm btn-falcon-default me-1" type="button" title="Previous" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
				    <ul class="pagination mb-0"></ul><button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next" data-list-pagination="next"><span class="fas fa-chevron-right"> </span></button>
				  </div>
				</div>
			</div>




  		<div class="tab-pane fade" id="pill-tab-self" role="tabpanel" aria-labelledby="self-tab" style="overflow-x:auto;">
				<div id="tableExample2" data-list='{"valueNames":["name","email","age"],"page":5,"pagination":true}'>
				  <div class="table-responsive scrollbar">
				    <h2 style="text-align: center">Developer Guide</h2>
            <br>
            <br>
            <h4>Introduction</h4>
            VAPIO has HTTP SMS service is designed to let end user send across SMS messages using HTTP interface. The API supports custom UDH, message scheduling and various other advance features. The API is specially designed to let user send
            custom UDH while sending messages.
            <br>
            <br>
            <h4>Character set support</h4>
            GSM network supports GSM character set. Other than this VAPIO has HTTP API support sending messages in Unicode using Unicode-16 Big-Ending and UTF-8 format.
            <br>
            <br>
            <h4>Message Length</h4>
            For standard Latin character set 160 characters per SMS is supported. For Unicode messaging only 70 characters per SMS is supported. For Binary messaging 140 characters including UDH is supported.
            <br>
            To send long messages that auto-concatenate on mobile phone, use UDH according to Smart messaging guide.
            <br>
            <br>
            <h4>Authorizations</h4>

          <ul style="list-style-type:disc;padding-left: 25px;">
            <li>You must use a valid API Key to send requests to the API endpoints.</li>
            <li>The API only responds to HTTPS-secured communications. Any requests sent via HTTP return an HTTP 301 redirect to the corresponding HTTPS resources.</li>
            <li>The API returns request responses in JSON format. When an API request returns an error, it is sent in the JSON response as an error key.</li>
            <li>The API may return error messages in case of invalid parameters, authentication failures, or other issues. Make sure to handle these errors appropriately in your application.</li>
          </ul>
            <br>
            <h4>Rate Limit</h4>
          <ul style="list-style-type:disc;padding-left: 25px;">
            <li>Ensure that you abide by any rate limits imposed by the API to avoid being blocked or restricted</li>
          </ul>
            <br>
            <br>
            <h4>Getting Started</h4>
            <br>
            <h5>Base URL:</h5>
        <span style="font-family:'Courier New';">&emsp;
            https://sms.vapio.io/api.php?
        </span>
          <br>
          <br>

            <h5>Example request:</h5>
	        <span style="font-family:'Courier New';">&emsp;
              GET request https://sms.vapio.io/api.php?username=abc&apikey=dOIni1jnnMFT&senderid=senderid&route=route_name&mobile=mobile_number&text=message
          </span>
          <br>
          <br>
          <h5>Curl Request</h5>
        <span style="font-family:'Courier New';">&emsp;
          curl -X POST \<br>
          'https://vapio.in/api.php' \<br>
          -d 'username=your username' \<br>
          -d 'apikey=your api key' \<br>
          -d 'senderid=your sender id' \<br>
          -d 'route=Route which is asign to you' \<br>
          -d 'mobile=xxxxxxxxxx' \<br>
          -d 'format=json' \<br>
          -d 'TID=Template ID' \<br>
          -d 'text=Message Text
        </span>
          <br>
          <br>  
          <h4>API Parameters</h4>
          <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
    <table>
        <tr>
            <th>Parameter</th>
            <th>Type</th>
            <th>Description</th>
        </tr>
        <tr>
            <td>username</td>
            <td>Mandatory</td>
            <td>Enter your username here, or get in touch with <em>VAPIO</em>.</td>
        </tr>
        <tr>
            <td>apikey</td>
            <td>Mandatory</td>
            <td>The account or login on the site that <em>VAPIO</em> provided has an API key associated with it.</td>
        </tr>
        <tr>
            <td>senderid</td>
            <td>Mandatory</td>
            <td>Enter your DLT-approved sender name here. Sender IDs can be either six numbers or six alphabets.</td>
        </tr>
        <tr>
            <td>route</td>
            <td>Mandatory</td>
            <td>Input the route name that <em>VAPIO</em> assigned; it may be (TRANS, PROMO, OTP).</td>
        </tr>
        <tr>
            <td>mobile</td>
            <td>Mandatory</td>
            <td>The recipient number. A comma is used to separate multiple numbers.</td>
        </tr>
        <tr>
            <td>text</td>
            <td>Mandatory</td>
            <td>Text that needs to be sent on mobile handset. (template should be approved on DLT) </td>
        </tr>
        <tr>
            <td>format</td>
            <td>optional</td>
            <td>success failed response can get with html/json/xml format</td>
        </tr>
        <tr>
            <td>msgtype</td>
            <td>optional</td>
            <td>in case you want to send the message other than english language you must use this parameter along with value unicode</td>
        </tr>
        <tr>
            <td>group</td>
            <td>optional</td>
            <td>You have to input your group name which created in your account.</td>
        </tr>
        <tr>
            <td>TID</td>
            <td>optional</td>
            <td>You can pass template id which you get from DLT portal for your approve template</td>
        </tr>
        <tr>
            <td>PEID</td>
            <td>optional</td>
            <td>you can pass PEID which you get from DLT portal for your approve template</td>
        </tr>
        <tr>
            <td>schedule</td>
            <td>optional</td>
            <td>you can schedule your SMS by passing the date time with format (dd/mm/YYYY hh:mm:ss)</td>
        </tr>
    </table>
        <br>
    <h4>API Responses</h4>
        The API responds with a success message or an error message indicating the status of the message delivery. Below are response messages from API.
        <br>
        <br>
     <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
    <table>
        <tr>
            <th>Response</th>
            <th>Description</th>
        </tr>
        <tr>
            <td>Message Submitted Successfully</td>
            <td>The server accepted the message, and it was  successfully transmitted to the operator</td>
        </tr>
        <tr>
            <td>Provide username and API key</td>
            <td>API key or username is empty</td>
        </tr>
        <tr>
            <td>Invalid username and API Key</td>
            <td>Incorrect username or API key Verify the credentials, please</td>
        </tr>
        <tr>
            <td>Sender ID Wrong!!</td>
            <td>You submitted an incorrect sender name that  was not authorised for your account.</td>
        </tr>
        <tr>
            <td>Undefined Route</td>
            <td>You submitted an incorrect route name that was not authorised for your account.</td>
        </tr>
        <tr>
            <td>Invalid Mobile Number</td>
            <td>Incorrect mobile number was entered. Mobile number must have a country code or 10 digits</td>
        </tr>
        <tr>
            <td>Template Mismatch!!</td>
            <td>You entered a message that wasn't authorised for your account</td>
        </tr>
        <tr>
            <td>No contacts available in this group</td>
            <td>In the group name given, there are no contacts</td>
        </tr>
        <tr>
            <td>Please Assign Mobile Number</td>
            <td>You missed to enter a recipient number</td>
        </tr>
        <tr>
            <td>Routing failed</td>
            <td>message routing failed</td>
        </tr>
        <tr>
            <td>Provide Route</td>
            <td>You have not entered route</td>
        </tr>
        <tr>
            <td>Text Should not be an empty</td>
            <td>No texts were entered by you</td>
        </tr>
        <tr>
            <td>Please check schedule date & time</td>
            <td>your schedule time is less than current time</td>
        </tr>
        <tr>
            <td>less balance /insufficient credits</td>
            <td>your credit balance is low</td>
        </tr>
        <tr>
            <td>sender id cannot be blank</td>
            <td>You had missed the sender's name</td>
        </tr>
    </table>    
            
				  </div>
				  <div class="d-flex justify-content-center mt-3"><button class="btn btn-sm btn-falcon-default me-1" type="button" title="Previous" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
				    <ul class="pagination mb-0"></ul><button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next" data-list-pagination="next"><span class="fas fa-chevron-right"> </span></button>
				  </div>
				</div>
			</div>




		</div>
                </div>
              </div>
            </div>
        </div>



   </div>
  




