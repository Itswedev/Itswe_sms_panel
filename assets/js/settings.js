$(function(){

      load_settings();
	  load_route_dropdown();
	  load_sender_dropdown();
	  load_template_dropdown();

	     $("#low_balance").change(function(event){
      	//alert('ajsg');
        if($(this).is(':checked')) { 
        	$("#low_balance_amt").attr("readonly", false); 
            $("#low_balance_mobile").attr("readonly", false); 
        }
        else
        {
        	$("#low_balance_amt").attr("readonly", true); 
            $("#low_balance_mobile").attr("readonly", true); 
        }
    });



	     $("#question_repeat").click(function(){

		var repeat_section=$(".repeat_section:last");

		var card_name=$(".card_count:last").html();
		var card_name_arr=card_name.split(" ");
		var card_count=parseInt(card_name_arr[1]);
		card_count=card_count+1;
		
		if(card_count<=10)
		{
		 $(repeat_section).clone().addClass('duplicate').insertAfter(repeat_section);
		 $(".card_count:last").html("#Question "+card_count);
		 $(".card_remove:first").css('display','none');
		}
		else
		{
			alert('Cannot add more than 10 questions');
		}
		
	})


	     	  $(document).on('click', '.question_remove', function(){
       $(this).closest('.repeat_section').remove();
    });

 $(document).on('change', '#login_otp', function(){
  
        if($(this).is(':checked')) { 
            $(".login_otp_type").css('display','');
            $("#security_question").prop('checked',false);
            $("#security_question").prop('disabled','disabled');
            $(".que").prop('disabled','disabled');
        }
        else
        {
            $(".login_otp_type").css('display','none');
            $("#security_question").removeAttr('disabled');
             /*$(".que").removeAttr('disabled');*/
        }
    

 });


 $(document).on('change', '#security_question', function(){


        if($(this).is(':checked')) { 
            $(".login_otp_type").css('display','none');
            $("#login_otp").prop('disabled','disabled');
            $(".que").removeAttr('disabled');
        }
        else
        {
           // $(".login_otp_type").css('display','');
            $("#login_otp").removeAttr('disabled');
            $(".que").prop('disabled','disabled');
        }
    

      });

 $(document).on('click', '#save_question_btn', function(e){

     // e.preventDefault();
    var dataString="list_type=update_settings";
    var security_question='';
    if($("#low_balance").is(':checked'))
    {
        var low_balance='Yes';
        var low_bal_limit=$("#low_balance_amt").val();
        var low_bal_mobile=$("#low_balance_mobile").val();
        //alert(low_bal_mobile);
        if(low_bal_limit=='' || low_bal_limit==0)
        {
            Swal.fire({icon: 'error',title: 'Sorry...',text: 'Please set low balance limit'});
            return false;
        }
        if(low_bal_mobile=='')
        {
            
            Swal.fire({icon: 'error',title: 'Sorry...',text: 'Please enter mobile number for low balance alert'});
            return false;
        }
        else
        {
            var count_mobile_nos=low_bal_mobile.split(",");
            
            if(count_mobile_nos.length>2)
            {
                Swal.fire({icon: 'error',title: 'Sorry...',text: 'The maximum limit of mobile numbers is two.'});
                return false;
            }
        }
        

        dataString+="&low_balance="+low_balance+"&low_bal_limit="+low_bal_limit+"&low_bal_mobile="+low_bal_mobile;
       //alert(dataString);
    }
    else
    {
        var low_balance='No';
        dataString+="&low_balance="+low_balance+"&low_bal_limit=0";
    }

    if($("#login_alert").is(':checked'))
    {
        var login_alert='Yes';     
        dataString+="&login_alert="+login_alert;
    }
    else
    {
        var login_alert='No';
        dataString+="&login_alert="+login_alert;
    }

    if($("#login_otp").is(':checked'))
    {
        var login_otp='Yes';     
        var mobile,email,whatsapp="";

        dataString+="&login_otp="+login_otp;

        if($("#login_otp_mobile").is(":checked"))
        {
            mobile='Yes';
        }
        else
        {
            mobile='No';
        }


         if($("#login_otp_email").is(":checked"))
        {
            email='Yes';
        }
        else
        {
            email='No';
        }


         if($("#login_otp_whatsapp").is(":checked"))
        {
            whatsapp='Yes';
        }
        else
        {
            whatsapp='No';
        }

        dataString+="&mobile="+mobile+"&email="+email+"&whatsapp="+whatsapp;
    }
    else
    {
        var login_otp='No';
        var mobile='No';
        var email='No';
        var whatsapp='No';
        dataString+="&login_otp="+login_otp+"&mobile="+mobile+"&email="+email+"&whatsapp="+whatsapp;
    }

     if($("#daily_usage").is(':checked'))
    {
        var daily_usage='Yes';     
        dataString+="&daily_usage="+daily_usage;
    }
    else
    {
        var daily_usage='No';
        dataString+="&daily_usage="+daily_usage;
    }
   
    if($("#security_question").is(':checked')) {
        /*security question = yes*/
             $( "#save_alert_module_form" ).validate({
                    rules: {
                        
                        questions1: "required",
                        questions2: "required",
                        questions3: "required",
                        answers1: "required",
                        answers2: "required",
                        answers3: "required",
                        
                    },
                    messages: {
                                    
                        questions1: "Please select Route",
                        questions2: "Please select Route",
                        questions3: "Please select Route",
                        answers1: "Please select Route",
                        answers2: "Please select Route",
                        answers3: "Please select Route",
                        
                       
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
                   
                          swal.fire({
                          title: 'Are you sure?',
                          text: "You'd want to save your settings!",
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
                            security_question='Yes';
                            var que1,que2,que3,ans1,ans2,ans3="";
                            
                            que1=$("#questions1").val();
                            que2=$("#questions2").val();
                            que3=$("#questions3").val();

                            if((que1==que2) || (que1==que3) || (que2==que3))
                            {
                                Swal.fire({icon: 'error',title: 'Oops...',text: 'Kindly choose a different question'});
                                return false;
                            }

                             ans1=$("#answers1").val();
                            ans2=$("#answers2").val();
                            ans3=$("#answers3").val();
                            dataString+="&security_question="+security_question;
                            dataString+="&que1="+que1+"&que2="+que2+"&que3="+que3+"&ans1="+ans1+"&ans2="+ans2+"&ans3="+ans3;
                             var full_url = window.location.origin+"/itswe_sms_app";
                             

                               $.ajax({
                                        url: full_url+'/controller/settings_controller.php',
                                        type: 'post',
                                        cache: false,
                                        data:dataString,
                                        success: function(data){
                                         /*  alert(data);*/
                                           if(data==1)
                                           {
                                            Swal.fire("Successful !", 'Settings updated successfully', "success").then((value) => {
                                                 window.location.href="dashboard.php?page=settings";
                                                  $("#save_alert_module_form").trigger('reset');
                                                });
                                           }
                                           else
                                           {
                                            Swal.fire({icon: 'error',title: 'Sorry...',text: 'Failed to change settings'});
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
                      });



                }
            });



    }
    else
    {
        /*security question =no*/
        e.preventDefault();
                    swal.fire({
                          title: 'Are you sure?',
                          text: "You'd want to save your settings!",
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
                    }).then((result2) => {
                     
                          if (result2.isConfirmed) {


                              security_question='No';
            dataString+="&security_question="+security_question;

           /* alert(dataString);*/
           
           var full_url = window.location.origin+"/itswe_sms_app";
                              $.ajax({
                                        url: full_url+'/controller/settings_controller.php',
                                        type: 'post',
                                        cache: false,
                                        data:dataString,
                                        success: function(data){
                                         /*  alert(data);*/
                                           if(data==1)
                                           {
                                            Swal.fire("Successful !", 'Settings updated successfully', "success").then((value) => {
                                                  window.location.href="dashboard.php?page=settings";
                                                  $("#save_alert_module_form").trigger('reset');
                                                });
                                           }
                                           else
                                           {
                                            Swal.fire({icon: 'error',title: 'Sorry...',text: 'Failed to change settings'});
                                           }
                                         
                                            
                                        },
                                        error: function (xhr, ajaxOptions, thrownError) {
                                            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                                            alert(errorMsg);
                                            //$('#content').html(errorMsg);
                                          }
                                    });
                                return false;


                          }
                      });

    }

});

$("#change_password_btn").click(function(){
                $( "#update_password_form" ).validate( {
                    rules: {
                        
                        old_password: "required",
                        new_password: "required",
                        confirm_password: "required",
                    },
                    messages: {
                  
                        old_password: "Please select Route",
                        new_password: "Please select sender is",
                        confirm_password: "Please select template",
                       
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
                          text: "You'd like to change your password!",
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

                                 var full_url = window.location.origin+"/itswe_sms_app";

                                   
                                   $.ajax({
                                            url: full_url+'/controller/settings_controller.php',
                                            type: 'post',
                                            cache: false,
                                            data:$("#update_password_form").serialize(),
                                            success: function(data){

                                               //alert(data);
                                                if(data==1)
                                                {
                                                    Swal.fire("Successfull!", "Your password has been successfully updated.", "success").then((value) => {
                                                         $("#update_password_form").trigger('reset');
                                                      
                                                    });
                                                }
                                                else
                                                {
                                                     Swal.fire({icon: 'error',title: 'Oops...',text: data});
                                                }
                                                
                                                //swal("Click on either the button or outside the modal.")

                                               // location.reload();
                                             
                                                
                                            },
                                            error: function (xhr, ajaxOptions, thrownError) {
                                                var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                                                alert(data);
                                                //$('#content').html(errorMsg);
                                              }
                                        });
            
            return false;

                          }
                        })
                
                }

                });
            });




$("#change_api_key_btn").click(function(){
                $( "#update_apikey_form" ).validate( {
                    rules: {                    
                        api_key: "required",
                    },
                    messages: {
                        api_key: "Please enter API key",
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
                          text: "You'd like to change your API Key!",
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

                                 var full_url = window.location.origin+"/itswe_sms_app";

                                   
                                   $.ajax({
                                            url: full_url+'/controller/settings_controller.php',
                                            type: 'post',
                                            cache: false,
                                            data:$("#update_apikey_form").serialize(),
                                            success: function(data){

                                               //alert(data);
                                                if(data==1)
                                                {
                                                    Swal.fire("Successfull!", "Your API Key has been successfully updated.", "success").then((value) => {
                                                        /* $("#update_apikey_form").trigger('reset');*/
                                                        location.reload();
                                                      
                                                    });
                                                }
                                                else
                                                {
                                                     Swal.fire({icon: 'error',title: 'Oops...',text: data});
                                                }
                                                
                                                //swal("Click on either the button or outside the modal.")

                                               // location.reload();
                                             
                                                
                                            },
                                            error: function (xhr, ajaxOptions, thrownError) {
                                                var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                                                alert(errorMsg);
                                                //$('#content').html(errorMsg);
                                              }
                                        });
            
            return false;

                          }
                        })
                
                }

                });
            });



$("#api_key_btn").click(function(){
    
    var api_key=makeid();
    $("#api_key").val(api_key);
   
});

});


function load_settings()
{
var full_url = window.location.origin+"/itswe_sms_app";
var low_balance,low_bal_limit,login_alert,login_otp,daily_usage,security_question,que1,que2,que3,ans1,ans2,ans3;
            $.ajax({
                 url: full_url+'/controller/settings_controller.php',
                type: 'post',
                cache: false,
                data:'list_type=load_settings',
                dataType:'json',
                success: function(data){
                    var res = JSON.parse(JSON.stringify(data));
                    console.log(data);
                    //alert(res['id'][0]);
                    
                 if(data!=0)
                   {
                        low_balance=res[0]['low_balance'];
                       
                        if(low_balance=='Yes')
                        {
                            low_bal_limit=res[0]['low_bal_limit'];
                            $("#low_balance_amt").val(low_bal_limit);
                            $("#low_balance_amt").removeAttr('readonly');
                            low_bal_mobile=res[0]['low_bal_mobile'];
                            $("#low_balance_mobile").val(low_bal_mobile);
                            $("#low_balance_mobile").removeAttr('readonly');
                            $("#low_balance").prop('checked','checked');
                        }
                        else
                        {
                            $("#low_balance").prop('checked',false);
                            
                        }

                        login_alert=res[0]['login_alert'];
                        if(login_alert=='Yes')
                        {
                            
                            $("#login_alert").prop('checked','checked');
                        }
                        else
                        {
                            $("#login_alert").prop('checked',false);
                        }


                        login_otp=res[0]['login_otp'];
                        if(login_otp=='Yes')
                        {
                            $(".login_otp_type").css('display','');
                            
                            $("#login_otp").prop('checked','checked');
                             mobile=res[0]['mobile_otp'];
                             email=res[0]['email_otp'];
                             whatsapp=res[0]['whatsapp_otp'];
                            if(mobile=='Yes')
                            {
                                
                                $("#login_otp_mobile").prop('checked','checked');
                                
                            }
                            else
                            {
                                $("#login_otp_mobile").prop('checked',false);
                            }


                            if(email=='Yes')
                            {
                                
                                $("#login_otp_email").prop('checked','checked');
                                
                            }
                            else
                            {
                                $("#login_otp_email").prop('checked',false);
                            }


                             if(whatsapp=='Yes')
                            {
                                
                                $("#login_otp_whatsapp").prop('checked','checked');
                                
                            }
                            else
                            {
                                $("#login_otp_whatsapp").prop('checked',false);
                            }

                        }
                        else
                        {
                            $("#login_otp").prop('checked',false);
                        }
                        


                        daily_usage=res[0]['daily_usage'];
                        if(daily_usage=='Yes')
                        {
                            
                            $("#daily_usage").prop('checked','checked');
                        }
                        else
                        {
                            $("#daily_usage").prop('checked',false);
                        }



                        /*security question*/

                        security_question=res[0]['security_questions'];
                        if(security_question=='Yes')
                        {
                            que1=res[0]['que1'];
                             que2=res[0]['que2'];
                              que3=res[0]['que3'];


                            ans1=res[0]['ans1'];
                            ans2=res[0]['ans2'];
                            ans3=res[0]['ans3'];


                            $(`#questions1 option[value='${que1}']`).prop('selected', true);
                            $("#answers1").val(ans1);

                            $(`#questions2 option[value='${que2}']`).prop('selected', true);
                            $("#answers2").val(ans2);

                            $(`#questions3 option[value='${que3}']`).prop('selected', true);
                            $("#answers3").val(ans3);

                            $("#security_question").prop('checked','checked');
                            $(".que").removeAttr('disabled');

                        }
                        else
                        {
                            $("#security_question").prop('checked',false);
                             $(".que").prop('disabled','disabled');

                        }
                      
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });


}
function makeid() {
  var text = "";
  var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

  for (var i = 0; i < 12; i++)
    text += possible.charAt(Math.floor(Math.random() * possible.length));

  return text;
}


function load_route_dropdown()
{
      var full_url = window.location.origin+"/itswe_sms_app";
            $.ajax({
                url: full_url+'/controller/manage_gateway_controller.php',
                type: 'post',
                cache: false,
                data:'list_type=route_dropdown',
                success: function(data){
               // alert(data);
                   if(data!=0)
                   {
                    $('#route').empty();
                    data_dropdown="<option value=''>Select Route</select>"+data;
                    $('#route').html(data_dropdown);


                                 /*  $('#route').multiselect({
                            columns: 1,
                            placeholder: 'Select Route Id',
                            search: true,
                            selectAll: true
                        });*/
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}

function load_sender_dropdown()
{
      var full_url = window.location.origin+"/itswe_sms_app";
            $.ajax({
                url: full_url+'/controller/manage_gateway_controller.php',
                type: 'post',
                cache: false,
                data:'list_type=load_sender_id_list',
                success: function(data){
              
                   if(data!=0)
                   {
                    
                    $('#sender_id').html(data);


                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}

function load_template_dropdown()
{
      var full_url = window.location.origin+"/itswe_sms_app";
            $.ajax({
                url: full_url+'/controller/manage_gateway_controller.php',
                type: 'post',
                cache: false,
                data:'list_type=load_template_id_list',
                success: function(data){
              
                   if(data!=0)
                   {
                    
                    $('#template_id').html(data);


                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}