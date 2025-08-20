$( document ).ready(function(){
            //Perform Ajax request.
           load_data();
           load_username_dropdown();




$("#addAccessToken").click(function(){
               $( "#accesstokenForm" ).validate({

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
           

            //var full_url = window.location.origin;

            /*var page_name=$(".page_name").text();*/
            $.ajax({
                url: full_url+'/controller/rcs_function.php',
                type: 'post',
                cache: false,
                data:$("#accesstokenForm").serialize(),
                success: function(data){
                    data = data.trim();
                    if(data=='Success')
                        {
                             swal.fire('Success','Access Token Generated Successfully!!','success').then((value) => {
                                $('#exampleModal').modal('hide');
                                 $("#accesstokenForm").trigger('reset');
                                 window.location.reload(full_url+'/view/include/modal_forms/access_token_modal.php');
                                load_data();
                               
                            });
                  
                        }
                        else
                        {
                             swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Failed to generate access token!'
                              
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
        //var full_url = window.location.origin;
            $.ajax({
                url: full_url+'/controller/user_controller.php',
                type: 'post',
                cache: false,
                data:'list_type=dropdown_user&page=add_credit',
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

function load_data()
{
        //var full_url = window.location.origin;

        $('#access_token_tbl').DataTable( {
        "processing": true,
        "serverSide": true,
        "responsive": true,
         "ajax": {
                    "type":"POST",
                    "url":full_url+"/controller/rcs_function.php",
                    "data":function (post) {
                            post.sender_type='all_access_token';
                    

                           
                           
                        }
                  
         },
         "order": [[ 0, "desc" ]],
         "bDestroy": true,
         "columnDefs": [
                        {"className": "dt-center", "targets": "_all"}
            ]

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

        //var full_url = window.location.origin;
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

                action_message('SenderId succesfully created.', 'success');
               
                if(form_name=='bulk_sms')
                {
                    $("#sid").empty();

                    load_senderid_dropdown(form_name);
                }
                var page = $('.pactive').attr('p');


                $('#exampleModal').modal('hide');

                load_data();
            }
        }
    });
}


function editSenderIds() {
    
    if ($('#edit_senderid_id').val().trim() == '') {
        alert('Please enter senderid');
        return false;
    }
    if ($('#edit_senderid_id').val().trim().length != 6) {
        alert('Senderid must be 6 character only.');
        return false;
    }

    //var full_url = window.location.origin;
    $.ajax({
        type: "POST",
        url: full_url+"/controller/sender_id_function.php",
        data: $('#senderidsEditForm').serialize(),
        beforeSend: function () {
           // $('#createsenderid').html('<img src="assets/images/loading.gif" style="width:30%;" />');
        },
        success: function (data)
        {
            
            if (data == 'Already Exists') {
                $('#edit_senderid_id').val('');
                $('#edit_senderid_id').focus()
                alert('Sender ID already in used, please enter another');
            } else if (data == 'FALSE') {
                alert('failed! Contact Administrator');
            } else {
                $('a.close').trigger('click');
                var form_name=$("#form_name").val();
               // $('#senderidsEditForm')[0].reset();

                alert('SenderId succesfully updated.');
               
               
               


                $('#edit_sender_id').modal('hide');

                load_data();
            }
        }
    });
}


function load_senderid_dropdown(form_name)
{
        //var full_url = window.location.origin;
     $.ajax({
                url: full_url+'/controller/sender_id_function.php',
                type: 'post',
                cache: false,
                data:'sender_type=load_sender_dropdown',
                success: function(data){
                   // console.log(data);
                   if(data!=0)
                   {
                    $('#sid').append('<option value="">Sender Id</option>');
                    $('#sid').append(data);
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
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