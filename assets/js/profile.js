$(function(){

load_basic_dtls();
$("#save_profile_img_btn").click(function(){

			var file_data = $('#profile_pic_select').prop('files')[0];
			var list_type="update_profile_pic";
            if(file_data != undefined) {
                var full_url = window.location.origin+"/itswe_sms_app";
                var form_data = new FormData();     
                
                form_data.append('profile_pic_select', file_data);
                form_data.append('list_type', list_type);
               
                $.ajax({
                    type: 'POST',
                    url: full_url+"/controller/user_controller.php",
                    contentType: false,
                    processData: false,
                    cache: false, 
                    data: form_data,
                    success:function(response) {
                        
                        if(response == 'success') {
                            Swal.fire("Successful !", "Profile Image uploaded successfully", "success").then((value) => {
                             
                                $("#profile_pic").load(location.href+" #profile_pic");
                                $("#header_profile_pic").load(location.href+" #header_profile_pic");
                            });
                           /*  Swal.fire("Successful !", "Profile Image uploaded successfully", "success");
*/
                            
                        } else {
                            Swal.fire({icon: 'error',title: 'Sorry.... ',text: response})
                            return false;
                           // alert('Something went wrong. Please try again.');
                        }
  
                        $('#profile_pic_select').val('');
                    }
                });
            }
            return false;
	})



/*edit profile details*/

    $("#save_user_profile_btn").click(function(){

            $( "#save_profile_form" ).validate({
            rules: {

                mobile: "required",
                f_name: "required", 
                company_name: "required", 
                email: "required",
              
            },
            messages: {
                
                mobile: "Please enter your mobile number",
                f_name: "Please enter your full name",
                company_name: "Please enter company name",
                email: "Please enter email",
                
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
                var full_url = window.location.origin+"/itswe_sms_app";
                   $.ajax({
                            url: full_url+'/controller/user_controller.php',
                            type: 'post',
                            cache: false, 
                            data:$("#save_profile_form").serialize(),
                            success: function(data){

                                console.log(data);
                                Swal.fire("Successful !", data, "success").then((value) => {
                                      window.location.href="dashboard.php?page=profile";
                                    });
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
    });



});



function load_basic_dtls()
{

   var full_url = window.location.origin+"/itswe_sms_app";
   var dataString="list_type=load_basic_dtls";
    $.ajax({
                    type: 'POST',
                    cache: false, 
                    url: full_url+"/controller/user_controller.php",
                    data: dataString,
                    dataType:'json',
                    success:function(response) {
                         var res = JSON.parse(JSON.stringify(response));

                        if(response!=0)
                        {
                            $("#username").val(res['user_name']);
                            $("#f_name").val(res['client_name']);
                            $("#mobile").val(res['mobile_no']);
                            $("#email_id").val(res['email_id']);
                            $("#company_name").val(res['company_name']);
                            $("#city").val(res['city']);

                            $("#pincode").val(res['pincode']);
                        }
  
                    }
                });


}



function thisFileUpload() {
    document.getElementById("profile_pic_select").click();
  };