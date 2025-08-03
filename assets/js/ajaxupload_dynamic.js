$(function() {

	load_route_dropdown();
	load_sender_id_dropdown();
  load_sender_id();

    $(".default_value_sec").css('display','none');
    


$("#schedule_later_btn").click(function(){
  $("#schedule_later_form").modal('show');
})


// schedule later
$("#schedule_now_btn").click(function(){

  var btn_val=$(this).val();
  setSubmitBtnValue(btn_val);
  
  var schedule_date = $("#datepicker").val();

  if(schedule_date!='')
  {
      $("#is_schedule").val('1');
  }


  var preview=$("#txtpreview").val();
            if(preview=="")
            {
                  swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Please click Message Preview button',
                              footer: ''
                            })

                return false;
            }

            if($('#chk_track').is(":checked")){
              var original_url=$("#original_url").val();
 
              if(original_url=="")
              {
                    swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Please add original url',
                                footer: ''
                              })
  
                  return false;
              }
 
             }
             else if($('#chk_track2').is(":checked"))
             {
               var dynamic_url=$("#dynamic_url").val();
               if(dynamic_url=="")
               {
                     swal.fire({
                                 icon: 'error',
                                 title: 'Oops...',
                                 text: 'Please select dynamic url',
                                 footer: ''
                               })
   
                   return false;
               }
             }
      

      $( "#sendSMSForm" ).validate( {
          rules: {
            az_routeid: "required",
            sid: "required",
            template: "required",
            message: "required",
             


          },
          messages: {
              az_routeid: "Please select Route",
              sid: "Please select sender is",
              template: "Please select template",
              // numbers: "Please Enter Mobile Number",
              message: "Please enter message"
              
              
          },
          errorElement: "em",

          errorPlacement: function ( error, element ) {
              // Add the `invalid-feedback` class to the error element
              error.addClass( "invalid-feedback" );
              error.insertAfter(element.next(".pmd-textfield-focused"));
          },
          highlight: function ( element, errorClass, validClass ) {
              $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
          },
          unhighlight: function (element, errorClass, validClass) {
              $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
          },
          submitHandler: function(form,e) {
          e.preventDefault();
          console.log('Form submitted');

          swal.fire({
          title: 'Are you sure?',
          text: "You want to send this message!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#2c7be5',
          cancelButtonColor: '#748194',
          confirmButtonText: 'Yes',
          showClass: {
              popup: 'animate__animated animate__heartBeat'
          },
          hideClass: {
              popup: 'animate__animated animate__fadeOutUp'
          }
          }).then((result) => {
          if (result.isConfirmed) {
              var full_url = window.location.origin;

   
          $.ajax({
                  url: full_url+'/controller/sending.php',
                  type: 'post',
                  cache: false, 
                  data:$("#sendSMSForm").serialize()+"&btn_send=send_sms",
                   beforeSend: function(){
                   $("#loading_modal").modal('show');
                 },
                 complete: function(){
                  $("#loading_modal").modal('hide');
                 },
                  success: function(data){
                    console.log('test2');

                      data=data.trim();
                     // alert(data);
                     /* console.log(data);
                      swal.fire('',data,'success').then((value) => {
              
                          });*/
                    //  console.log(data);

                      var msg=data.split("|");
                     if(msg[0].trim()=='Message Successfully Send' || msg[0].trim()=='Message Successfully Scheduled')
                     {
                      $("#schedule_later_form").modal('hide');
                     // window.location.reload();
                          if(msg[1]!='0'||msg[1]!=0)
                          {
                           if(msg[1]==undefined)
                           {
                            swal.fire('',msg[0]+"<br/>",'success').then((value) => {
                               
                              $("#sendSMSForm").trigger('reset');
                              window.location.href=full_url+"/dashboard.php?page=scheduled_report";
                           
                           
                          });
                           }
                           else
                           {
                              swal.fire('',msg[0]+"<br/>"+msg[1],'success').then((value) => {
                                
                                $("#sendSMSForm").trigger('reset');
                                window.location.href=full_url+"/dashboard.php?page=scheduled_report";
                            
                            
                            });

                           }
                              
                          }
                          else
                          {
                              swal.fire('',msg[0],'success').then((value) => {
                                //window.location.reload();
                                $("#sendSMSForm").trigger('reset');
                                window.location.href=full_url+"/dashboard.php?page=scheduled_report";
                              });
                          }
                          
                     }
                     else
                     {
                          swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: msg[0],
                            footer: ''
                          })
                     }
               
                      
                  },
                  error: function (xhr, ajaxOptions, thrownError) {
                      var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                      alert(errorMsg);
                      //$('#content').html(errorMsg);
                    }
              });
         

               }
          })
      
      }

      } );
});


function setSubmitBtnValue(value) {
  document.getElementById('submitBtnValue').value = value;
}
$("#importBtn_bulk").click(function(){
    /*alert('text');*/
/*  e.preventDefault();*/
    var full_url = window.location.origin;
    var file_data = $('#uploadfile').prop('files')[0];
    var bar = $('#bar');
    var bar_per = $('#bar_per');
     if(file_data != undefined) {
        var form_data = new FormData();   
        form_data.append('uploadfile', file_data); 
        form_data.append('act','import1');
     $.ajax({
                url: full_url+'/controller/dynamic_sms_function.php',
                type: 'post',
                data:form_data,
                dataType: 'json',
                cache: false,             // To unable request pages to be cached
                contentType: false,
                 processData: false,        // To send DOMDocument or non processed data file it is set to false
                beforeSend: function(){
                    var percentVal = '0 %';
                  bar.width(percentVal);
                  bar_per.html(percentVal);
                
                   },
                   xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function(event) {
                        if (event.lengthComputable) {
                            var percentComplete = Math.round((event.loaded / event.total) * 100);
                            var percentVal = percentComplete + '%';
                            bar.width(percentVal);
                            bar.html(percentVal);
                        }
                    }, false);
                    return xhr;
                },
                   uploadProgress: function(event, position, total, percentComplete) {
                  var percentVal = percentComplete + ' %';
                  bar.width(percentVal);
                  bar.css("width",percentVal);
                 
                },
                complete: function(){
                   // $("#loading_modal").modal('hide');
                   },
                success: function(data){
                  if(data==0)
                  {
                    swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Please check file extension',
                      footer: ''
                    });

                    return false;
                  }
                    var percentVal = '100%';
                bar.width(percentVal);
                bar_per.html(percentVal);
                bar.css("width",percentVal);
                   // console.log(data);
                
                    var response = JSON.parse(JSON.stringify(data));  
           
            var data_len = response['header'].length;
          // console.log(response);
           var placeholder_data = "<option value=''>Select Placeholder</option>";
           var dynamic_url = "<option value=''>Select Dynamic Url</option>";
           $("#dynamicsms_placeholder_dropdown").empty();
           $("#dynamic_url").empty();
          var table_header="<tr>";
           for(var i = 0; i < data_len; i++) {

            table_header+="<th>"+response['header'][i]+"</th>";

            placeholder_data+="<option value='"+response['header'][i]+"'>"+response['header'][i]+"</option>";
            dynamic_url+="<option value='"+response['header'][i]+"'>"+response['header'][i]+"</option>";

                //console.log(response['header'][i]);
           }

           table_header+="</tr>";
           $("#dynamicsms_placeholder_dropdown").append(placeholder_data);
           $("#dynamic_url").append(dynamic_url);

           data_len = response['data'].length;
          // console.log(response['file_name']);
           //$("#table_data").append(table_header);
          var table_data="";
          var header="";
          var numbers="";
          $("#mobile_count").text(data_len);
           for(var i = 0; i < data_len; i++) {
           //   table_header+="<tr>";
           /*   for(var j = 0; j < response['header'].length; j++) {
                 header=response['header'][j];

            table_header+="<td style='word-break: break-all;'>"+response['data'][i][header]+"</td>";

                //console.log(response['data'][i][header]);
           }*/

            var num_header=response['header'][0];
            numbers+=response['data'][i][num_header]+"\n";
            //table_header+="</tr>";
           
                //console.log(response['header'][i]);
           }

 console.log(response);

          
           for(var i = 0; i < 2; i++) {
            
            for(var j = 0; j < response['header'].length; j++) {
                 header=response['header'][j];

            table_header+="<td style='word-break: break-all;'>"+response['data'][i][header]+"</td>";

                //console.log(response['data'][i][header]);
           }

            var num_header=response['header'][0];
           
            table_header+="</tr>";
           
                //console.log(response['header'][i]);
           }
           
           $("#numbers").text('');
           $("#numbers").text(numbers);
          // $("#table_data").remove();
          $("#table_data").append(table_header);

          var table_data3 = response['file_name'];
                $('#upload_file_name').val(table_data3);

           var to_data = response['header'][0];
           console.log("test"+to_data);
            $("#dynamicsms_to_dropdown").empty();
            $("#dynamicsms_to_dropdown").append("<option value='" + to_data + "' selected>" + to_data + "</option>");


                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
    }
})

$("#sid").change(function(){
        var sid=$('#sid option:selected').val();
        if(sid!='')
        {
 
          var full_url = window.location.origin;
          $.ajax({
                    url: full_url+'/controller/bulk_sms_function.php',
                    type: 'post',
                    cache: false, 
                    data:"act=load_template_with_sid&sid="+sid,
                    success: function(data){
                 // console.log(data);
                     if(data!=0)
                     {

                       $('#template').empty();
                       $('#template').html(data);
                        //$("#addtemplateForm").trigger('reset');
                       
                     }
                        
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(errorMsg);
                        //$('#content').html(errorMsg);
                      }
                });
            }
    })

    /*sender id change end*/

    /*url tracking*/
    $("#chk_track").change(function() {

      $("#chk_track2").prop('checked',false);
    valueChanged();
})

$("#chk_track2").change(function() {

  $("#chk_track").prop('checked',false);
valueChanged2();
})



    /*dynamic dropdown change start*/

	$("#template").change(function(){

		var template_id=$("#template").val();
         var full_url = window.location.origin;
		//alert(group_id);

	 
            $.ajax({
                url: full_url+'/controller/template_function.php',
                type: 'post',
                cache: false, 
                data:'type=get_msg_data&temp_id='+template_id,
                dataType:'json',
                success: function(data){
                var res = JSON.parse(JSON.stringify(data));
                 // alert(data);

                 var template_id=res['template_id'];
                 $("#dlt_template").val(template_id);
                 $("#dlt_template").prop('readonly','readonly');
 
                 if(res['msg_data']!='')
                  {
                    var msg_data=res['msg_data'];
                  

                  /*  var count_variables=0;
                    var new_default='';
                    count_variables=msg_data.split("{#var#}");
                    if(count_variables.length>0)
                    {
                      for(var i=1;i<count_variables.length;i++)
                      {
                         new_default+="<input type='text' class='form-control' name='default_value[]' id='default_value' placeholder='Default Value' aria-label='default_value' aria-describedby='basic-addon1' style='width:80%;'><br/>";
                    
                      }


                      $(".default_value_sec").empty();
                      $(".default_value_sec").append(new_default);
                    }*/
                    var char_type=res['char_type'];
                    if(char_type=='Unicode')
                    {
                        $('input:radio[name="char_set"][value="Unicode"]').prop('checked',true);
                        $('input:radio[name="char_set"][value="Text"]').prop('checked',false);
                       // $("#success-outlined").attr('checked','checked');
                    }
                    else
                    {
                         $('input:radio[name="char_set"][value="Unicode"]').prop('checked',false);
                         $('input:radio[name="char_set"][value="Text"]').prop('checked',true);
                    }
                    $("#message").val(res['msg_data']);
                    checkChar();
                  }
                  else{
                    alert('Message Content Not available');
                  }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });	

	})

    /*dynamic dropdown change end*/

    /*schedule start*/

    $("#schedule_sms").click(function(){

    $("#is_schedule").val('1');
        $( "#sendSMSForm" ).validate({
            rules: {
                az_routeid: "required",
                sid: "required",
                scheduleDateTime:"required"
        
            },
            messages: {
                az_routeid: "Please select Route",
                sid: "Please select Route",
                scheduleDateTime:"Please select Date"  
            },
            errorElement: "em",

            errorPlacement: function ( error, element ) {
                // Add the `invalid-feedback` class to the error element
                error.addClass( "invalid-feedback" );
                error.insertAfter(element.next(".pmd-textfield-focused"));
            },
            highlight: function ( element, errorClass, validClass ) {
                $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
            },
            unhighlight: function (element, errorClass, validClass) {
                $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
            },
            submitHandler: function(form,e) {
            	    	
            e.preventDefault();
            //console.log('Form submitted');

            swal.fire({
  title: 'Are you sure?',
  text: "You want to schedule this message!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#2c7be5',
  cancelButtonColor: '#748194',
  confirmButtonText: 'Yes',
  showClass: {
    popup: 'animate__animated animate__heartBeat'
  },
  hideClass: {
    popup: 'animate__animated animate__fadeOutUp'
  }
}).then((result1) => {
  if (result1.isConfirmed) {
     var full_url = window.location.origin;
    
   $.ajax({
                    url: full_url+'/controller/sending.php',
                    type: 'post',
                    cache: false, 
                    data:$("#sendSMSForm").serialize()+"&btn_send=schedule_sms",
                     beforeSend: function(){
                     $("#loading_modal").modal('show');
                   },
                   complete: function(){
                    $("#loading_modal").modal('hide');
                   },
                    success: function(data){
                      //  alert('test'+data);
                        var msg=data.split("|");
                       if(msg[0].trim()=='Message Successfully Scheduled')
                       {
                            swal.fire('',msg[0]+"<br/>"+msg[1],'success').then((value) => {
                            window.location.href=full_url+"/dashboard.php?page=scheduled_report";
                          $("#sendSMSForm").trigger('reset');
                            });
                       }
                       else
                       {
                            swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: msg[0],
                              footer: ''
                            })
                       }
                     
                        
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(errorMsg);
                        //$('#content').html(errorMsg);
                      }
                });
           

  }
})
        
        }

        } );
});

    /*schedule end*/


    $("#dynamic_sms_btn").click(function(){
        $( "#sendSMSForm" ).validate({
            rules: {
                az_routeid: "required",
                sid: "required",
                template: "required",
                message: "required",
               

            },
            messages: {
                az_routeid: "Please select Route",
                sid: "Please select sender is",
                template: "Please select template",
                message: "Please enter message"
                
                
            },
            errorElement: "em",

            errorPlacement: function ( error, element ) {
                // Add the `invalid-feedback` class to the error element
                error.addClass( "invalid-feedback" );
                error.insertAfter(element.next(".pmd-textfield-focused"));
            },
            highlight: function ( element, errorClass, validClass ) {
                $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
            },
            unhighlight: function (element, errorClass, validClass) {
                $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
            },
            submitHandler: function(form,e) {
            e.preventDefault();
          console.log('Form submitted');
            var preview=$("#txtpreview").val();
            if(preview=="")
            {
                  swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Please click Message Preview button',
                              footer: ''
                            })

                return false;
            }

            swal.fire({
  title: 'Are you sure?',
  text: "You want to send this message!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#2c7be5',
  cancelButtonColor: '#748194',
  confirmButtonText: 'Yes',
  showClass: {
    popup: 'animate__animated animate__heartBeat'
  },
  hideClass: {
    popup: 'animate__animated animate__fadeOutUp'
  }
}).then((result) => {
  if (result.isConfirmed) {
     var full_url = window.location.origin;
   $.ajax({
                    url: full_url+'/controller/sending.php',
                    type: 'post',
                    cache: false, 
                    data:$("#sendSMSForm").serialize()+"&btn_send=send_sms",
                     beforeSend: function(){
                     $("#loading_modal").modal('show');
                   },
                   complete: function(){
                    $("#loading_modal").modal('hide');
                   },
                    success: function(data){
                      alert('test dynamic');
                      console.log('asfdh');
                        //alert(data);
                       /* console.log(data);
                        swal.fire('',data,'success').then((value) => {
                
                            });*/
                        console.log(data);

                      //   var msg=data.split("|");
                      //  if(msg[0].trim()=='Message Successfully Send')
                      //  {

                      //       if(msg[1]!='0'||msg[1]!=0)
                      //       {
                      //           //alert('wrong');
                      //           swal.fire('',msg[0]+"<br/>"+msg[1],'success').then((value) => {
                      //             window.location.reload();
                      //             $("#sendSMSForm").trigger('reset');
                      //           });
                      //       }
                      //       else
                      //       {
                      //           swal.fire('',msg[0],'success').then((value) => {
                      //             window.location.reload();
                      //             $("#sendSMSForm").trigger('reset');
                      //           });
                      //       }
                            
                      //  }
                      //  else
                      //  {
                      //       swal.fire({
                      //         icon: 'error',
                      //         title: 'Oops...',
                      //         text: msg[0],
                      //         footer: ''
                      //       })
                      //  }

                       /* swal(data, "", "success").then((value) => {
                        location.reload();
                            });*/
                        //swal("Click on either the button or outside the modal.")

                       // location.reload();
                     
                        
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(errorMsg);
                        //$('#content').html(errorMsg);
                      }
                });
           

			  }
			})
			        
			}

    });
});



        // Fill Placeholder in the SMS Message TextArea
	$("#dynamicsms_placeholder_dropdown").change(function() {
		// Get Value from Insert Placeholder 

        var placeholder_val=$(this).val();
        if(placeholder_val=='')
        {
             $(".default_value_sec").css('display','none');
        }
        else
        {
             $(".default_value_sec").css('display','');
        }
       
		var placeholder = $("#dynamicsms_placeholder_dropdown").val(); //get value from insert placeholder dropdown

		// SMS Message TextArea Value Get
		var message = $("#message").val();
		var $txt = jQuery("#message");
        var caretPos = $txt[0].selectionStart;
        var textAreaTxt = $txt.val();
        var txtToAdd = "{" + placeholder + "}";
        $txt.val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos) );
		//$("#message").append(data);
		// $("#sms_preview").append(table_data2);
		checkChar();
    });


$("#btn_default_val").click(function(){
    var default_value=$("#default_value").val();
    var placeholder = $("#dynamicsms_placeholder_dropdown").val();

    var full_url = window.location.origin;
            $.ajax({
                    url: full_url+'/controller/dynamic_sms_function.php',
                    type: 'post',
                    cache: false, 
                    data:"act=set_default&default_value="+default_value+"&placeholder="+placeholder,
                    success: function(data){
                       
                   /*    alert(data);*/
                      
                     
                        
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(errorMsg);
                        //$('#content').html(errorMsg);
                      }
                });

});


    $("#preview").click(function(){

      var senderid=$("#sid option:selected").text();

    	var file_name=$("#upload_file_name").val();
    	var msg=encodeURIComponent($("#message").val());
      var dynamic_url;
      if($('#chk_track2').is(":checked")){
           dynamic_url=$("#dynamic_url").val();
      }
      else{
        dynamic_url="";
      }

    var full_url = window.location.origin;
    	    $.ajax({
                    url: full_url+'/controller/dynamic_sms_function.php',
                    type: 'post',
                    cache: false, 
                    data:"act=preview1&file_name="+file_name+"&msg="+msg+"&dynamic_url="+dynamic_url+"&senderid="+senderid,
                    success: function(data){
                    	var d = data.split('|||');
                    	$("#preview_area").html('');
                    	$("#preview_area").html(d[0]);
                    	$('#txtpreview').val(d[1]);
                    	$("#preview_modal").modal('show');
                      // alert(data);
                      
                     
                        
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(errorMsg);
                        //$('#content').html(errorMsg);
                      }
                });
    });

});


var d = document, w = window;
Ajax_upload = AjaxUpload = function(button, options){
			if (button.jquery){
				// jquery object was passed
				button = button[0];
			} else if (typeof button == "string" && /^#.*/.test(button)){			
				button = button.slice(1);				
			}

			button = get(button);	
			
			this._input = null;
			this._button = button;
			this._disabled = false;
			this._submitting = false;
			// Variable changes to true if the button was clicked
			// 3 seconds ago (requred to fix Safari on Mac error)
			this._justClicked = false;
			this._parentDialog = d.body;
			
			if (window.jQuery && jQuery.ui && jQuery.ui.dialog){
				var parentDialog = jQuery(this._button).parents('.ui-dialog');
				if (parentDialog.length){
					this._parentDialog = parentDialog[0];
				}
			}

			this._settings = {
				// Location of the server-side upload script
				action: 'upload.php',			
				// File upload name
				name: 'userfile',
				// Additional data to send
				data: {},
				// Submit file as soon as it's selected
				autoSubmit: true,
				// The type of data that you're expecting back from the server.
				// Html and xml are detected automatically.
				// Only useful when you are using json data as a response.
				// Set to "json" in that case. 
				responseType: false,
				// When user selects a file, useful with autoSubmit disabled			
				onChange: function(file, extension){},					
				// Callback to fire before file is uploaded
				// You can return false to cancel upload
				onSubmit: function(file, extension){},
				// Fired when file upload is completed
				// WARNING! DO NOT USE "FALSE" STRING AS A RESPONSE!
				onComplete: function(file, response) {}
			};

			// Merge the users options with our defaults
			for (var i in options) {
				this._settings[i] = options[i];
			}
			
			this._createInput();
			this._rerouteClicks();
		}

AjaxUpload.prototype = {
			setData : function(data){
				this._settings.data = data;
			},
			disable : function(){
				this._disabled = true;
			},
			enable : function(){
				this._disabled = false;
			},
			// removes ajaxupload
			destroy : function(){
				if(this._input){
					if(this._input.parentNode){
						this._input.parentNode.removeChild(this._input);
					}
					this._input = null;
				}
			},				
			/**
			 * Creates invisible file input above the button 
			 */
			_createInput : function(){

				var self = this;
				var input = d.createElement("input");
				input.setAttribute('type', 'file');
				input.setAttribute('name', this._settings.name);
				var styles = {
					'position' : 'absolute'
					,'margin': '-5px 0 0 -175px'
					,'padding': 0
					,'width': '220px'
					,'height': '30px'
					,'fontSize': '14px'								
					,'opacity': 0
					,'cursor': 'pointer'
					,'display' : 'none'
					,'zIndex' :  2147483583 //Max zIndex supported by Opera 9.0-9.2x 
					// Strange, I expected 2147483647					
				};

				for (var i in styles){
					input.style[i] = styles[i];
				}
				
				// Make sure that element opacity exists
				// (IE uses filter instead)
				if ( ! (input.style.opacity === "0")){
					input.style.filter = "alpha(opacity=0)";
				}

			//	var element = document.getElementById('uploadtxt');
			//	element.className += " " + 'hover2';
				
									
				this._parentDialog.appendChild(input);

				addEvent(input, 'change', function(){
					// get filename from input
					var file = fileFromPath(this.value);	
					if(self._settings.onChange.call(self, file, getExt(file)) == false ){
						return;				
					}														
					// Submit form when value is changed
					if (self._settings.autoSubmit){
						self.submit();						
					}						
				});
				
				// Fixing problem with Safari
				// The problem is that if you leave input before the file select dialog opens
				// it does not upload the file.
				// As dialog opens slowly (it is a sheet dialog which takes some time to open)
				// there is some time while you can leave the button.
				// So we should not change display to none immediately
				addEvent(input, 'click', function(){
					self.justClicked = true;
					setTimeout(function(){
						// we will wait 3 seconds for dialog to open
						self.justClicked = false;
					}, 3000);			
				});		
				
				this._input = input;
			},
			_rerouteClicks : function (){
				var self = this;
			
				// IE displays 'access denied' error when using this method
				// other browsers just ignore click()
				// addEvent(this._button, 'click', function(e){
				//   self._input.click();
				// });
						
				var box, dialogOffset = {top:0, left:0}, over = false;							
				addEvent(self._button, 'mouseover', function(e){
					if (!self._input || over) return;
					over = true;
					box = getBox(self._button);
							
					if (self._parentDialog != d.body){
						dialogOffset = getOffset(self._parentDialog);
					}	
				});
				
			
				// we can't use mouseout on the button,
				// because invisible input is over it
				addEvent(document, 'mousemove', function(e){
					var input = self._input;			
					if (!input || !over) return;
					
					if (self._disabled){
						removeClass(self._button, 'hover');
						input.style.display = 'none';
						return;
					}	
												
					var c = getMouseCoords(e);

					if ((c.x >= box.left) && (c.x <= box.right) && 
					(c.y >= box.top) && (c.y <= box.bottom)){			
						input.style.top = c.y - dialogOffset.top + 'px';
						input.style.left = c.x - dialogOffset.left + 'px';
						input.style.display = 'block';
						addClass(self._button, 'hover');				
					} else {		
						// mouse left the button
						over = false;
						if (!self.justClicked){
							input.style.display = 'none';
						}
						removeClass(self._button, 'hover');
					}			
				});			
					
			},
			/**
			 * Creates iframe with unique name
			 */
			_createIframe : function(){
				// unique name
				// We cannot use getTime, because it sometimes return
				// same value in safari :(
				var id = getUID();
				
				// Remove ie6 "This page contains both secure and nonsecure items" prompt 
				// http://tinyurl.com/77w9wh
				var iframe = toElement('<iframe src="javascript:false;" name="' + id + '" />');
				iframe.id = id;
				iframe.style.display = 'none';
				d.body.appendChild(iframe);		
				return iframe;						
			},
			/**
			 * Upload file without refreshing the page
			 */
			submit : function(){
				var self = this, settings = this._settings;	
							
				if (this._input.value === ''){
					// there is no file
					return;
				}
												
				// get filename from input
				var file = fileFromPath(this._input.value);			

				// execute user event
				if (! (settings.onSubmit.call(this, file, getExt(file)) == false)) {
					// Create new iframe for this submission
					var iframe = this._createIframe();
					
					// Do not submit if user function returns false										
					var form = this._createForm(iframe);
					form.appendChild(this._input);
					
					form.submit();
					
					d.body.removeChild(form);				
					form = null;
					this._input = null;
					
					// create new input
					this._createInput();
					
					var toDeleteFlag = false;
					
					addEvent(iframe, 'load', function(e){
							
						if (// For Safari
							iframe.src == "javascript:'%3Chtml%3E%3C/html%3E';" ||
							// For FF, IE
							iframe.src == "javascript:'<html></html>';"){						
							
							// First time around, do not delete.
							if( toDeleteFlag ){
								// Fix busy state in FF3
								setTimeout( function() {
									d.body.removeChild(iframe);
								}, 0);
							}
							return;
						}				
						
						var doc = iframe.contentDocument ? iframe.contentDocument : frames[iframe.id].document;

						// fixing Opera 9.26
						if (doc.readyState && doc.readyState != 'complete'){
							// Opera fires load event multiple times
							// Even when the DOM is not ready yet
							// this fix should not affect other browsers
							return;
						}
						
						// fixing Opera 9.64
						if (doc.body && doc.body.innerHTML == "false"){
							// In Opera 9.64 event was fired second time
							// when body.innerHTML changed from false 
							// to server response approx. after 1 sec
							return;				
						}
						
						var response;
											
						if (doc.XMLDocument){
							// response is a xml document IE property
							response = doc.XMLDocument;
						} else if (doc.body){
							// response is html document or plain text
							response = doc.body.innerHTML;
							if (settings.responseType && settings.responseType.toLowerCase() == 'json'){
								// If the document was sent as 'application/javascript' or
								// 'text/javascript', then the browser wraps the text in a <pre>
								// tag and performs html encoding on the contents.  In this case,
								// we need to pull the original text content from the text node's
								// nodeValue property to retrieve the unmangled content.
								// Note that IE6 only understands text/html
								if (doc.body.firstChild && doc.body.firstChild.nodeName.toUpperCase() == 'PRE'){
									response = doc.body.firstChild.firstChild.nodeValue;
								}
								if (response) {
									response = window["eval"]("(" + response + ")");
								} else {
									response = {};
								}
							}
						} else {
							// response is a xml document
							var response = doc;
						}
																					
						settings.onComplete.call(self, file, response);
								
						// Reload blank page, so that reloading main page
						// does not re-submit the post. Also, remember to
						// delete the frame
						toDeleteFlag = true;
						
						// Fix IE mixed content issue
						iframe.src = "javascript:'<html></html>';";		 								
					});
			
				} else {
					// clear input to allow user to select same file
					// Doesn't work in IE6
					// this._input.value = '';
					d.body.removeChild(this._input);				
					this._input = null;
					
					// create new input
					this._createInput();						
				}
			},		
			/**
			 * Creates form, that will be submitted to iframe
			 */
			_createForm : function(iframe){
				var settings = this._settings;
				
				// method, enctype must be specified here
				// because changing this attr on the fly is not allowed in IE 6/7		
				var form = toElement('<form method="post" enctype="multipart/form-data"></form>');
				form.style.display = 'none';
				form.action = settings.action;
				form.target = iframe.name;
				d.body.appendChild(form);
				
				// Create hidden input element for each data key
				for (var prop in settings.data){
					var el = d.createElement("input");
					el.type = 'hidden';
					el.name = prop;
					el.value = settings.data[prop];
					form.appendChild(el);
				}			
				return form;
			}	
		};


		function addEvent(el, type, fn){
	if (w.addEventListener){
		el.addEventListener(type, fn, false);
	} else if (w.attachEvent){
		var f = function(){
		  fn.call(el, w.event);
		};			
		el.attachEvent('on' + type, f)
	}
}


function getBox(el){
	var left, right, top, bottom;	
	var offset = getOffset(el);
	left = offset.left;
	top = offset.top;
						
	right = left + el.offsetWidth;
	bottom = top + el.offsetHeight;		
		
	return {
		left: left,
		right: right,
		top: top,
		bottom: bottom
	};
}

function getMouseCoords(e){		
	// pageX/Y is not supported in IE
	// http://www.quirksmode.org/dom/w3c_cssom.html			
	if (!e.pageX && e.clientX){
		// In Internet Explorer 7 some properties (mouse coordinates) are treated as physical,
		// while others are logical (offset).
		var zoom = 1;	
		var body = document.body;
		
		if (body.getBoundingClientRect) {
			var bound = body.getBoundingClientRect();
			zoom = (bound.right - bound.left)/body.clientWidth;
		}

		return {
			x: e.clientX / zoom + d.body.scrollLeft + d.documentElement.scrollLeft,
			y: e.clientY / zoom + d.body.scrollTop + d.documentElement.scrollTop
		};
	}
	
	return {
		x: e.pageX,
		y: e.pageY
	};		

}
function valueChanged(){
    var trackingurl='https://vap1.in/abcxyz/xxxxxxx';
    if($('#chk_track').is(":checked")){  
      $(".track_url").css('display','block');
      $(".dynamic_url").css('display','none');
        $(".div_track").css('display','inline');


        var message = $("#message").val();
		    var $txt = jQuery("#message");
        var caretPos = $txt[0].selectionStart;
        var textAreaTxt = $txt.val();
        // var txtToAdd = "{" + placeholder + "}";
        $txt.val(textAreaTxt.substring(0, caretPos) + trackingurl + textAreaTxt.substring(caretPos) );
      //  $("#message").val($("#message").val() + '\n'+trackingurl);
        checkChar();
    }else{
      $("#original_url").val("");
      $(".track_url").css('display','none');
      $(".div_track").css('display','none');

        
       // $("#message").val($("#message").val().replace('\n'+trackingurl, ''));
        checkChar();
    }
};

function valueChanged2(){
  var trackingurl='https://vap1.in/abcxyz/xxxxxxx';
  if($('#chk_track2').is(":checked")){  
    $("#original_url").val("");
      $(".track_url").css('display','none');
      $(".dynamic_url").css('display','block');
      $(".div_track").css('display','inline');
      var message = $("#message").val();
      var $txt = jQuery("#message");
      var caretPos = $txt[0].selectionStart;
      var textAreaTxt = $txt.val();
          // var txtToAdd = "{" + placeholder + "}";
      $txt.val(textAreaTxt.substring(0, caretPos) + trackingurl + textAreaTxt.substring(caretPos) );
     // $("#message").val($("#message").val() + '\n'+trackingurl);
      checkChar();
  }else{
   
    $(".dynamic_url").css('display','none');
      $(".div_track").css('display','none');
      $("#message").val($("#message").val().replace('\n'+trackingurl, ''));
      checkChar();
  }
};


function addClass(ele,cls) {
	if (!hasClass(ele,cls)) ele.className += " "+cls;
}
function removeClass(ele,cls) {
	var reg = new RegExp('(\\s|^)'+cls+'(\\s|$)');
	ele.className=ele.className.replace(reg,' ');
}

function fileFromPath(file){
	return file.replace(/.*(\/|\\)/, "");			
}


function getExt(file){
	return (/[.]/.exec(file)) ? /[^.]+$/.exec(file.toLowerCase()) : '';
}	


var getUID = function(){
	var id = 0;
	return function(){
		return 'ValumsAjaxUpload' + id++;
	}
}();

var toElement = function(){
	var div = d.createElement('div');
	return function(html){
		div.innerHTML = html;
		var el = div.childNodes[0];
		div.removeChild(el);
		return el;
	}
}();


		var d = document, w = window;

		function get(element){
	if (typeof element == "string")
		element = d.getElementById(element);
	return element;
}


	function isNumberKeyOrFloat(evt){
	if(!evt)
        evt = window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode!=97 && charCode!=99 && charCode!=44 && charCode!=8 && charCode!=118 && charCode!=46 &&(charCode < 36 || charCode > 40)) 
    {
        return false
    }
     return true
	}


	function countNo(val,response)
	{
	var value = document.getElementById(val).value;
	var c=0;
	value=value.split('\n');
	for(i=0;i<=value.length;i++)
	{
		if(value[i] && value[i].trim()!="")
		{
		c++;
		}
	}

document.getElementById(response).innerHTML= c;
}

 function load_template_dropdown()
{
    var senderid=$("#sid").val();
    if(senderid=="")
    {
        alert("Please Select Sender ID");
        return false;
    }
    else
    {


     var full_url = window.location.origin;
           $.ajax({
                url: full_url+'/controller/template_function.php',
                type: 'post',
                cache: false, 
                data:'template_type=load_template_dropdown_userid&senderid='+senderid,
                success: function(data){
                	//alert(data);
                   if(data!=0)
                   {
                    $('#template').empty();
                    $('#template').html(data);
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
       }
}



function checkChar() 
{
	var msg2 = $.trim($('#message').val());
	if($.trim($('#signature').val()) != "") {
		msg2 = $.trim($('#message').val() +"\n"+$.trim($('#signature').val()));
	}	
	var charcount = msg2.length;
	if(navigator.appName == "Microsoft Internet Explorer")
	{
		charcount = msg2.length ;//- (msg2.split(/\r/).length) ;
		if(charcount<0)
		charcount=0;
	}
	GlobalMsgCharcount = charcount;
	GlobalSignCharcount = 0;
	$('.msgReplication').html(msg2);
	var SMSMAX = 1000;//$('#MAX_SMS_LENGTH').val();
	
	var udh = 153;
	var SMS = 160;
	var Credit = 1 
	
	if($('#mbl8').val()==1)
	{
			 SMS = 140;
			 udh = 134;			
			 charcount=charcount*4;
			 charcount=charcount/2;   
	}
	//alert(charcount);
	GlobalCharcount = charcount;

	if(charcount>SMS){
		Credit = Math.ceil(charcount/udh);
	}
	//alert(Credit);
	if(charcount > SMSMAX)
	{
		//$("#txtMessageCountexceed").html('Maximum '+SMSMAX+' Character Allowed');
		$("#characters").html('<b>'+charcount+'</b>');
		$("#smsCount").html('<b>'+Credit+'</b>');
	}
	$("#characters").html('<b>'+charcount+'</b>');
	$("#smsCount").html('<b>'+Credit+'</b>');	
}


function load_route_dropdown()
{
        var full_url = window.location.origin;
    
            $.ajax({
                url: full_url+'/controller/manage_gateway_controller.php',
                type: 'post',
                cache: false, 
                data:'list_type=route_dropdown&page=compose',
                success: function(data){
                	//alert(data);
                   if(data!=0)
                   {
                    $('#az_routeid').empty();
                   empty_data="<option value=''>Select Route</option>";
                   data=empty_data+data;
                    $('#az_routeid').html(data);
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
}

function load_sender_id()
{
/*alert('test load senderids');*/
        var full_url = window.location.origin;
     $.ajax({
                url: full_url+'/controller/template_function.php',
                type: 'post',
                cache: false, 
                data:'template_type=load_sender_dropdown',
                success: function(data){
                   /* alert('test load senderids');*/
                    console.log(data);
                   if(data!=0)
                   {
                    /*$('#sender_id').append('<option value="">Select Sender</option>');*/
                    $('#sender_id').empty();
                    $('#sender_id').html(data);
                     $('#sender_id').multiselect('destroy');
                    $('#sender_id').multiselect({
                        columns: 1,
                        placeholder: 'Select Sender Id',
                        search: true,
                        selectAll: true
                    });
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
}

function load_sender_id_dropdown()
{

      var full_url = window.location.origin;
           $.ajax({
                url: full_url+'/controller/sender_id_function.php',
                type: 'post',
                cache: false, 
                data:'type=sender_id_dropdown',
                success: function(data){
                	//alert(data);
                   if(data!=0)
                   {
                    $('#sid').empty();
                    $('#sid').html(data);

                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
}


function addSenderIds() {
    
    if ($('#senderid_id').val().trim() == '') {
        action_message('Please enter senderid', 'error');
        return false;
    }
    if ($('#senderid_id').val().trim().length != 6) {
        action_message('Senderid must be 6 character only.', 'error');
        return false;
    }

        var full_url = window.location.origin;
    $.ajax({
        type: "POST",
        url: full_url+"/controller/sender_id_function.php",
        data: $('#senderidsForm').serialize(),
        beforeSend: function () {
            $('#createsenderid').html('<img src="assets/images/loading.gif" style="width:30%;" />');
        },
        success: function (data)
        {
            $('#createsenderid').html('<input name="" type="button" id="createsenderid" onclick="addSenderIds();" value="Save" />');
            if (data == 'Already Exists') {
                $('#senderid_id').val('');
                $('#senderid_id').focus()
                action_message('Sender ID already in used, please enter another', 'error');
            } else if (data == 'FALSE') {
                action_message('failed! Contact Administrator', 'error');
            } else {
                $('a.close').trigger('click');
                var form_name=$("#form_name").val();
                $('#senderidsForm')[0].reset();

                alert('SenderId succesfully created.');
               
                if(form_name=='bulk_sms')
                {
                    $("#sid").empty();

                    load_sender_id_dropdown();
                }
               

                $('#exampleModal').modal('hide');

               // load_data();
            }
        }
    });
}


 $("#dynamic_sms_btn").click(function(){
        $( "#sendSMSForm" ).validate({
            rules: {
                az_routeid: "required",
                sid: "required",
                template: "required",
                message: "required",
               

            },
            messages: {
                az_routeid: "Please select Route",
                sid: "Please select sender is",
                template: "Please select template",
                message: "Please enter message"
                
                
            },
            errorElement: "em",

            errorPlacement: function ( error, element ) {
                // Add the `invalid-feedback` class to the error element
                error.addClass( "invalid-feedback" );
                error.insertAfter(element.next(".pmd-textfield-focused"));
            },
            highlight: function ( element, errorClass, validClass ) {
                $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
            },
            unhighlight: function (element, errorClass, validClass) {
                $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
            },
            submitHandler: function(form,e) {
            e.preventDefault();
            //console.log('Form submitted');
            var preview=$("#txtpreview").val();
            if(preview=="")
            {
                  swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Please click Message Preview button',
                              footer: ''
                            })

                return false;
            }

            if($('#chk_track').is(":checked")){
             var original_url=$("#original_url").val();

             if(original_url=="")
             {
                   swal.fire({
                               icon: 'error',
                               title: 'Oops...',
                               text: 'Please add original url',
                               footer: ''
                             })
 
                 return false;
             }

            }
            else if($('#chk_track2').is(":checked"))
            {
              var dynamic_url=$("#dynamic_url").val();
              if(dynamic_url=="")
              {
                    swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Please select dynamic url',
                                footer: ''
                              })
  
                  return false;
              }
            }
            
                 

            swal.fire({
  title: 'Are you sure?',
  text: "You want to send this message!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#2c7be5',
  cancelButtonColor: '#748194',
  confirmButtonText: 'Yes',
  showClass: {
    popup: 'animate__animated animate__heartBeat'
  },
  hideClass: {
    popup: 'animate__animated animate__fadeOutUp'
  }
}).then((result) => {
  if (result.isConfirmed) {
     var full_url = window.location.origin;
   $.ajax({
                    url: full_url+'/controller/sending.php',
                    type: 'post',
                    cache: false, 
                    data:$("#sendSMSForm").serialize()+"&btn_send=send_sms",
                     beforeSend: function(){
                     $("#loading_modal").modal('show');
                   },
                   complete: function(){
                    $("#loading_modal").modal('hide');
                   },
                    success: function(data){
                       // alert(data);
                       /* console.log(data);
                        swal.fire('',data,'success').then((value) => {
                
                            });*/
                        console.log(data);

                        var msg=data.split("|");
                       if(msg[0].trim()=='Message Successfully Send')
                       {

                            if(msg[1]!='0'||msg[1]!=0)
                            {
                                //alert('wrong');
                                swal.fire('',msg[0]+"<br/>"+msg[1],'success').then((value) => {
                                  window.location.href=full_url+"/dashboard.php?page=send_job_summary";
                                  $("#sendSMSForm").trigger('reset');
                                });
                            }
                            else
                            {
                                swal.fire('',msg[0],'success').then((value) => {
                                  window.location.href=full_url+"/dashboard.php?page=send_job_summary";
                                  $("#sendSMSForm").trigger('reset');
                                });
                            }
                            
                       }
                       else
                       {
                            swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: msg[0],
                              footer: ''
                            })
                       }

                       /* swal(data, "", "success").then((value) => {
                        location.reload();
                            });*/
                        //swal("Click on either the button or outside the modal.")

                       // location.reload();
                     
                        
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(errorMsg);
                        //$('#content').html(errorMsg);
                      }
                });
           

              }
            })
                    
            }

    });
});



/*$("#dynamic_sms_btn").click(function(){
        $( "#sendSMSForm" ).validate( {
            rules: {
                az_routeid: "required",
                sid: "required",
                message: "required",
               


            },
            messages: {
                az_routeid: "Please select Route",
                sid: "Please select Route",
                message: "Please select Route"
                
                
            },
            errorElement: "em",

            errorPlacement: function ( error, element ) {
                // Add the `invalid-feedback` class to the error element
                error.addClass( "invalid-feedback" );
                error.insertAfter(element.next(".pmd-textfield-focused"));
            },
            highlight: function ( element, errorClass, validClass ) {
                $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
            },
            unhighlight: function (element, errorClass, validClass) {
                $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
            },
            submitHandler: function(form,e) {
            e.preventDefault();
            console.log('Form submitted');
                var full_url = window.location.origin;
           $.ajax({
                    url: full_url+'/controller/sending.php',
                    type: 'post',
                    data:$("#sendSMSForm").serialize(),
                    success: function(data){

                        var msg=data.split("|");
                       if(msg[0].trim()=='Message Successfully Send')
                       {

                            if(msg[1]!='0'||msg[1]!=0)
                            {
                                //alert('wrong');
                                swal.fire('',msg[0]+"<br/>"+msg[1],'success').then((value) => {
                                  window.location.reload();
                                  $("#sendSMSForm").trigger('reset');
                                });
                            }
                            else
                            {
                                swal.fire('',msg[0],'success').then((value) => {
                                  window.location.reload();
                                  $("#sendSMSForm").trigger('reset');
                                });
                            }
                            
                       }
                       else
                       {
                            swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: msg[0],
                              footer: ''
                            })
                       }
                     
                        
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(data);
                        //$('#content').html(errorMsg);
                      }
                });
            return false;
        }

        } );
});*/