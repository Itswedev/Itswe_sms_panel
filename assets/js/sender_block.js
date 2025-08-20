var table;
$(function(){
    
table = $("#sender_block_tbl").DataTable();
load_sender_id_block();

$("#save_sender_id").click(function(){
			
 $( "#sender_block_form" ).validate({

            rules: {
                sender_id1: "required",
            },
            messages: {
                sender_id1: "Please select route",
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
        			$.ajax({
                        url: full_url+'/controller/sender_id_function.php',
                        type: 'post',
                        cache: false,
                        data:$("#sender_block_form").serialize(),
                        success: function(data){
                            /*alert(data);*/
                              if(data=='Success')
                               {
                                    swal.fire('','Sender ID Block successfully!!','success').then((value) => {
                                    $("#add_sender_routing_modal").modal('hide');
                                    load_sender_id_block();
                                     });
                                }
                                else if(data=='Already Exists')
                                {
                                    swal.fire({
                                       icon: 'error',
                                       title: 'Oops...',
                                       text: 'Senderid Already blocked!'
                                       
                                     });
                                }
                                else
                                {
                                     swal.fire({
                                       icon: 'error',
                                       title: 'Oops...',
                                       text: 'Failed to block sender id details!'
                                       
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


function load_sender_id_block()
{
    //var full_url = window.location.origin;
    $.ajax({
        url: full_url + '/controller/sender_id_function.php',
        type: 'post',
        cache: false,
        data: 'type=all_sender_id_block',
        success: function(data) {
            
            if (data !== '0') {
                // Clear the existing DataTable
                table.clear();

                // Append the new data directly to the DataTable
                table.rows.add($(data)).draw();
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            alert(errorMsg);
        }
    });
}
