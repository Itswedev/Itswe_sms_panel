$(function(){

//load_sender_id_list();
// $(".sender_id1").chosen(); 
$("#sender_id1_chosen").css('width','100%');

$("#edit_sender_id1_chosen").css('width','100%');
load_username_dropdown();
load_gateway_dropdown();
load_sender_id_routing();


	$("#save_sender_routing").click(function(){

			
 $( "#sender_routing_form" ).validate({

            rules: {
                username: "required",
                sender_id1: "required",
                gateway_id: "required",
                sender_route_status: "required",
               
               
            


            },
            messages: {
                username: "Please enter Plan name",
                sender_id1: "Please select route",
                gateway_id: "Please select Gateway name",
                sender_route_status: "Please select status",
              
              
                
                
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
        			$.ajax({
                        url: full_url+'/controller/manage_gateway_controller.php',
                        type: 'post',
                        cache: false,
                        data:$("#sender_routing_form").serialize(),
                        success: function(data){
                          /*  alert(data);*/
                              if(data==1)
                               {
                                    swal.fire('','Sender Routing Details added successfully!!','success').then((value) => {
                                    $("#add_sender_routing_modal").modal('hide');
                                    load_sender_id_routing();
                                     });
                                }
                                else
                                {
                                     swal.fire({
                                       icon: 'error',
                                       title: 'Oops...',
                                       text: 'Failed to add sender routing details!'
                                       
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



$(document).on( "click", '.delete_sender_routing_btn',function(e) {
  
    var id = $(this).data('id');

           swal.fire({
  title: 'Are you sure?',
  text: "You want to delete this sender routing details?",
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
                                        url: full_url+'/controller/manage_gateway_controller.php',
                                        type: 'post',
                                        cache: false,
                                        data:'type=deleteSenderRouting&srid='+id,
                                        success: function(data){
                                           
                                           if(data==1)
                                           {
                                                swal.fire('','Sender Routing Details Deleted Successfully!!','success').then((value) => {
                                                load_sender_id_routing();
                                                    });
                                           }
                                           else
                                           {
                                                swal.fire({
                                                  icon: 'error',
                                                  title: 'Oops...',
                                                  text: 'Failed to delete sender routing details!'
                                                  
                                                });
                                           }
                                         
                                          
                                            
                                        },
                                        error: function (xhr, ajaxOptions, thrownError) {
                                            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                                            alert(data);
                                            //$('#content').html(errorMsg);
                                          }
                                    });
                        }
                });

   
    });

/*edit sender routing details*/



        $(document).on( "click", '.edit_sender_routing_btn',function(e) {
            
  
            var id = $(this).data('id');
            var userid=$(this).data('userid');
            var status=$(this).data('status');
            var gateway=$(this).data('gateway');
            var senderid=$(this).data('senderid');
            //var gateway_id=gateway.split(",");
            $("#srid").val(id); 
             $(`#edit_username_senderid option[value='${userid}']`).prop('selected', true);
              $(`#edit_username_senderid`).trigger("chosen:updated");



            $(`#edit_sender_id1 option[value='${senderid}']`).prop('selected', true);

            $(`#edit_sender_id1`).trigger("chosen:updated");
            $(`#edit_gateway_id option[value='${gateway}']`).prop('selected', true);
            $(`#edit_gateway_id`).trigger("chosen:updated");
          //  $(`#edit_sender_route_status_chosen option[value='${status}']`).prop('selected', true);
           
   
        });


$("#edit_sender_routing").click(function(){

            
 $( "#edit_sender_routing_form" ).validate({

            rules: {
                edit_username_senderid: "required",
                sender_id1: "required",
                gateway_id: "required",
                sender_route_status: "required",
              
            },
            messages: {
                edit_username_senderid: "Please enter Plan name",
                sender_id1: "Please select route",
                gateway_id: "Please select Gateway name",
                sender_route_status: "Please select status",  
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
                    $.ajax({
                    url: full_url+'/controller/manage_gateway_controller.php',
                    type: 'post',
                    cache: false,
                    data:$("#edit_sender_routing_form").serialize(),
                    success: function(data){

                       if(data==1)
                            {
                                 swal.fire('','Sender Routing Details Updated Successfully!!','success').then((value) => {
                                    $('#edit_sender_routing_modal').modal('hide');
                                    load_sender_id_routing();
                                });
                      
                            }
                            else
                            {
                                 swal.fire({
                                  icon: 'error',
                                  title: 'Oops...',
                                  text: 'Failed to Update Sender Routing Details!'
                                  
                                });
                            }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(data);
                        //$('#content').html(errorMsg);
                    }
                });

             }

        });



        });


function load_username_dropdown()
{
        var full_url = window.location.origin+"/itswe_sms_app";
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


                   $('#edit_username_senderid').empty();
                    $('#edit_username_senderid').html(data);

                //    $("#edit_username_senderid").chosen(); 
                   $("#edit_username_senderid_chosen").css('width','100%');

                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
}

$("#username_senderid").change(function(){

    var userid=$("#username_senderid").val();


    var full_url = window.location.origin+"/itswe_sms_app";
            $.ajax({
                url: full_url+'/controller/manage_gateway_controller.php',
                type: 'post',
                cache: false,
                data:'list_type=load_sender_id_list_by_userid&userid='+userid,
                success: function(data){
                
                   if(data!=0)
                   {
                    $('.sender_id1').empty();
                   
                    $('.sender_id1').append(data);
                     

                      $(`#sender_id1`).trigger("chosen:updated");
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
});

$("#edit_username_senderid").change(function(){

    var userid=$("#edit_username_senderid").val();


    var full_url = window.location.origin+"/itswe_sms_app";
            $.ajax({
                url: full_url+'/controller/manage_gateway_controller.php',
                type: 'post',
                cache: false,
                data:'list_type=load_sender_id_list_by_userid&userid='+userid,
                success: function(data){
                
                   if(data!=0)
                   {
                    $('.sender_id1').empty();
                   
                    $('.sender_id1').append(data);
                     

                      $(`#edit_sender_id1`).trigger("chosen:updated");
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
});


/*
    $("#edit_sender_routing").click(function(){
        $( "#edit_sender_routing_form" ).validate({

            rules: {
                edit_senderid_username: "required",
                edit_sender_id1: "required",
                edit_gateway_id: "required",
                edit_sender_route_status: "required",
            },
            messages: {
                edit_senderid_username: "Please enter Plan name",
                edit_sender_id1: "Please select route",
                edit_gateway_id: "Please select Gateway name",
                edit_sender_route_status: "Please select status",    
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
           


            $.ajax({
                url: 'controller/manage_gateway_controller.php',
                type: 'post',
                data:$("#edit_sender_routing_form").serialize(),
                success: function(data){

                   if(data==1)
                        {
                             swal.fire('','Sender Routing Details Updated Successfully!!','success').then((value) => {
                                $('#edit_sender_routing_modal').modal('hide');
                                load_sender_id_routing();
                            });
                  
                        }
                        else
                        {
                             swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Failed to Update Sender Routing Details!'
                              
                            });
                        }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                }
            });
        }

        });


        });*/

})

function load_sender_id_list()
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
                    $('.sender_id1').empty();
                   
                    $('.sender_id1').append(data);
                    //  $(".sender_id1").chosen(); 
                   $("#sender_id1_chosen").css('width','100%');

                   $("#edit_sender_id1_chosen").css('width','100%');
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}

function load_sender_id_routing()
{

    var full_url = window.location.origin+"/itswe_sms_app";

        $('#sender_routing_tbl').DataTable( {
        "processing": true,
        "serverSide": true,
        "responsive": true,
         "ajax": {
                    "type":"POST",
                    "url":full_url+"/controller/manage_gateway_controller.php",
                    "data":function (post) {
                            post.list_type='all_sender_id_routing';
                    

                           
                           
                        }
                  
         },
         "order": [[ 3, "desc" ]],
         "columnDefs": [
                        {"className": "dt-center", "targets": "_all"}
            ],
          "bDestroy": true

        });


  /*  var full_url = window.location.origin+"/itswe_sms_app";
             $.ajax({
                url: full_url+'/controller/manage_gateway_controller.php',
                type: 'post',
                data:'list_type=all_sender_id_routing',
                success: function(data){
                
                   if(data!=0)
                   {

                    $('#sender_routing_list').html(data);
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });*/
}

function load_gateway_dropdown()
{
    

    var full_url = window.location.origin+"/itswe_sms_app";
            $.ajax({
                url: full_url+'/controller/manage_gateway_controller.php',
                type: 'post',
                cache: false,
                data:'list_type=load_gateway_dropdown',
                success: function(data){
               
                  
                
                $('.sender_gateway_id').append(data);
                //  $(".sender_gateway_id").chosen(); 
                   $("#sender_gateway_id_chosen").css('width','100%');
                   
                    $("#edit_gateway_id_chosen").css('width','100%');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}