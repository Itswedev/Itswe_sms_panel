$( document ).ready(function(){
            //Perform Ajax request.
           load_data();
           load_username_dropdown();


$("#addRCSTemplate").click(function(){
               $( "#addtemplateForm" ).validate({

            rules: {
                client_id: "required",
                client_secret: "required",

            },
            messages: {
                client_id: "Please enter Client ID",
                client_secret: "Please select route",
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
           

            var full_url = window.location.origin;

            /*var page_name=$(".page_name").text();*/
            $.ajax({
                url: full_url+'/controller/rcs_function.php',
                type: 'post',
                cache: false,
                data:$("#addtemplateForm").serialize(),
                success: function(data){
                    data=data.trim();
                    if(data=='Success')
                        {
                             swal.fire('Success','RCS Template Added Successfully!!','success').then((value) => {
                                $('#exampleModal').modal('hide');
                                 $("#addtemplateForm").trigger('reset');
                                 window.location.reload(full_url+'/view/include/modal_forms/rcs_template_modal.php');
                                load_data();
                               
                            });
                  
                        }
                        else
                        {
                             swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Failed to add rcs template!'
                              
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
        var full_url = window.location.origin;
            $.ajax({
                url: full_url+'/controller/user_controller.php',
                type: 'post',
                cache: false,
                data:'list_type=dropdown_user&page=add_credit',
                success: function(data){
                    data=data.trim();
                
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

function load_data()
{
        var full_url = window.location.origin;

        $('#rcs_temp_tbl').DataTable( {
        "processing": true,
        "serverSide": true,
        "responsive": true,
         "ajax": {
                    "type":"POST",
                    "url":full_url+"/controller/rcs_function.php",
                    "data":function (post) {
                            post.sender_type='all_rcs_template';
                    

                           
                           
                        }
                  
         },
         "order": [[ 0, "desc" ]],
         "bDestroy": true,
         "columnDefs": [
                        {"className": "dt-center", "targets": "_all"}
            ]

        });

}











function action_message(msg, type) {
    if (type == 'success') {
        var message = '<span class="asm">' + msg + '</span>';
        $('#action_message').html(message);
        $('#action_message').show();
        $("#action_message").fadeOut(5000);
        // return false;
    }
    if (type == 'error') {
        var message = '<span class="awm">' + msg + '</span>';
        $('#action_message_error').html(message);
        $('#action_message_error').show();
        $("#action_message_error").fadeOut(5000);
        // return false;
    }
}