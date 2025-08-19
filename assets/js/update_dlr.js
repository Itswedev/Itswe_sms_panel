$( document ).ready(function(){
    //Perform Ajax request.
   
   load_username_dropdown();
   $('#username_senderid').change(function(){
    var full_url = window.location.origin+"/itswe_sms_app";
    var userid=$('#username_senderid').val();
    $.ajax({
        url: full_url+'/controller/update_dlr_controller.php',
        type: 'post',
        cache: false,
        data:'list_type=load_job_id&userid='+userid,
        success: function(data){
        
           if(data!=0)
           {
            $('#camp_id').empty();
            $('#camp_id').html(data);

        //    $("#username_senderid").chosen(); 
           $("#camp_id").css('width','100%');


         

           }
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            alert(errorMsg);
            //$('#content').html(errorMsg);
          }
    });


   })



   $('#camp_id').change(function(){
    var full_url = window.location.origin+"/itswe_sms_app";
    var camp_id=$('#camp_id').val();
    $.ajax({
        url: full_url+'/controller/update_dlr_controller.php',
        type: 'post',
        cache: false,
        data:'list_type=load_old_status&camp_id='+camp_id,
        success: function(data){
        
           if(data!=0)
           {
            $('#old_status').empty();
            $('#old_status').html(data);
        //    $("#username_senderid").chosen(); 
           $("#old_status").css('width','100%');
           }
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            alert(errorMsg);
            //$('#content').html(errorMsg);
          }
    });


   })



   $('#old_status').change(function(){
    var full_url = window.location.origin+"/itswe_sms_app";
    var old_status=$('#old_status').val();
    var camp_id=$('#camp_id').val();
    $.ajax({
        url: full_url+'/controller/update_dlr_controller.php',
        type: 'post',
        cache: false,
        data:'list_type=load_from_error&old_status='+old_status+'&camp_id='+camp_id,
        success: function(data){
        
           if(data!=0)
           {
            $('#from_error').empty();
            $('#from_error').html(data);
        //    $("#username_senderid").chosen(); 
            $("#from_error").css('width','100%');
           }
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            alert(errorMsg);
            //$('#content').html(errorMsg);
          }
    });


   })

   $("#save_user_btn").click(function(){

    $( "#update_dlr_form" ).validate({

        rules: {
            user_name: "required",
            camp_id: "required",
            rows_count: "required",
            from_status: "required",
            to_status: "required",
        },
        messages: {
            user_name: "Please enter Route name",
            camp_id: "Please select route",
            rows_count: "Please enter rate",
            from_status: "Please select sender id",
            to_status: "Please select dnd",
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

                    var full_url = window.location.origin+"/itswe_sms_app";
                    var rows_count=$("#rows_count").val();

                    $.ajax({
                        url: full_url+'/controller/update_dlr_controller.php',
                        type: 'post',
                        cache: false, 
                        data:$("#update_dlr_form").serialize(),
                        success: function(data){
                            if(data==1)
                                {
                                    swal.fire('',rows_count+' DLR Updated Successfully!!','success').then((value) => {
                                       window.location.reload();
                                    });
                          
                                }
                                else
                                {
                                     swal.fire({
                                      icon: 'error',
                                      title: 'Oops...',
                                      text: 'Failed to Update DLR Details!'
                                      
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

        });

                

    });



});


function load_username_dropdown()
{
        var full_url = window.location.origin+"/itswe_sms_app";
            $.ajax({
                url: full_url+'/controller/user_controller.php',
                type: 'post',
                cache: false,
                data:'list_type=only_user&page=only_user',
                success: function(data){
                
                   if(data!=0)
                   {
                    $('#username_senderid').empty();
                    $('#username_senderid').html(data);

                //    $("#username_senderid").chosen(); 
                   $("#username_senderid_chosen").css('width','100%');


                 

                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
}