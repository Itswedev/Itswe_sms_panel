$(function(){
    load_route_list();
    load_sender_id_list();
    load_route_plan();
    load_route_plan_form();
    load_route_plan_edit_form();

    $("#route_dropdown").change(function() {
            var route=$(this).val();
            if(route==7)
            {
                load_gateway();
            }
            else
            {
                load_other_gateway();
            }
})

     $("#edit_route_dropdown").change(function() {
            var route=$(this).val();
           
            if(route==7)
            {
                load_gateway2();
            }
            else
            {
                load_other_gateway2();
            }
})

     $('#searchInput').bind("keyup change", function(){
        table.draw();
    });


		$("#save_route").click(function(){
               $( "#addRouteForm" ).validate({

            rules: {
                route_name: "required",
                status: "required",
                rate: "required",
                sender_id: "required",
                dnd_check: "required",
               
            


            },
            messages: {
                route_name: "Please enter Route name",
                status: "Please select route",
                rate: "Please enter rate",
                sender_id: "Please select sender id",
                dnd_check: "Please select dnd",
              
                
                
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
                data:$("#addRouteForm").serialize(),
                success: function(data){
                    alert(data);
                    // console.log(data);
                    location.reload();
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

        $("#edit_route").click(function(){
               $( "#editRouteForm" ).validate({

            rules: {
                route_name: "required",
                status: "required",
                rate: "required",
                sender_id: "required",
                dnd_check: "required",
               
            


            },
            messages: {
                route_name: "Please enter Route name",
                status: "Please select route",
                rate: "Please enter rate",
                sender_id: "Please select sender id",
                dnd_check: "Please select dnd",
              
                
                
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
                data:$("#editRouteForm").serialize(),
                success: function(data){

                   if(data==1)
                        {
                            swal.fire('','Route Details Updated Successfully!!','success').then((value) => {
                                $('#edit_route_modal').modal('hide');
                                load_route_list();
                            });
                  
                        }
                        else
                        {
                             swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Failed to Update Route Details!'
                              
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

$(document).on( "click", '.delete_route_btn',function(e) {
  
    var id = $(this).data('id');

           swal.fire({
  title: 'Are you sure?',
  text: "You want to delete this route details?",
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
                                        data:'type=deleteRoute&rid='+id,
                                        success: function(data){
                                           
                                           if(data==1)
                                           {
                                                swal.fire('','Route Details Deleted Successfully!!','success').then((value) => {
                                                load_route_list();
                                                    });
                                           }
                                           else
                                           {
                                                swal.fire({
                                                  icon: 'error',
                                                  title: 'Oops...',
                                                  text: 'Failed to delete route details!'
                                                  
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



$(document).on( "click", '.delete_route_plan_btn',function(e) {
  
    var id = $(this).data('id');

           swal.fire({
  title: 'Are you sure?',
  text: "You want to delete this route plan details?",
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
                                        data:'type=deleteRoutePlan&rpid='+id,
                                        success: function(data){
                                           
                                           if(data==1)
                                           {
                                                swal.fire('','Route Plan Details Deleted Successfully!!','success').then((value) => {
                                                load_route_plan();
                                                    });
                                           }
                                           else
                                           {
                                                swal.fire({
                                                  icon: 'error',
                                                  title: 'Oops...',
                                                  text: 'Failed to delete route plan details!'
                                                  
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


        $("#create_route_plan_save").click(function(){

            $( "#addRouteplanForm" ).validate({

            rules: {
                plan_name: "required",
                route_dropdown: "required",
                gateway_name: "required",
                status: "required",
               
               
            


            },
            messages: {
                plan_name: "Please enter Plan name",
                route_dropdown: "Please select route",
                gateway_name: "Please select Gateway name",
                status: "Please select status",
              
              
                
                
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
           
            var gateway_name=$("#gateway_name").val();


            if(gateway_name!='')
            {
                    var full_url = window.location.origin+"/itswe_sms_app";
                $.ajax({
                    url: full_url+'/controller/manage_gateway_controller.php',
                    type: 'post',
                    cache: false,
                    data:$("#addRouteplanForm").serialize(),
                    success: function(data){
                        if(data==1)
                                               {
                                                    swal.fire('','Route Plan Details Added Successfully!!','success').then((value) => {
                                                    $("#create_route_plan_modal").modal('hide');
                                                    load_route_plan();
                                                        });
                                               }
                                               else
                                               {
                                                    swal.fire({
                                                      icon: 'error',
                                                      title: 'Oops...',
                                                      text: 'Failed to add route plan details!'
                                                      
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
            else
            {
                swal.fire({
                                                      icon: 'error',
                                                      title: 'Oops...',
                                                      text: 'Please select gateway name!'
                                                      
                                                    });
            }



            }

        });


        });

                $("#edit_route_plan_save").click(function(){

            $( "#editRouteplanForm" ).validate({

            rules: {
                edit_plan_name: "required",
                edit_route_dropdown: "required",
                edit_gateway_name: "required",
                edit_status: "required",
               
               
            


            },
            messages: {
                edit_plan_name: "Please enter Plan name",
                edit_route_dropdown: "Please select route",
                edit_gateway_name: "Please select Gateway name",
                edit_status: "Please select status",
              
              
                
                
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
           
            var gateway_name=$("#edit_gateway_name").val();


            if(gateway_name!='')
            {
                    var full_url = window.location.origin+"/itswe_sms_app";
                $.ajax({
                    url: full_url+'/controller/manage_gateway_controller.php',
                    type: 'post',
                    cache: false,
                    data:$("#editRouteplanForm").serialize(),
                    success: function(data){
                        if(data==1)
                                               {
                                                    swal.fire('','Route Plan Details Updated Successfully!!','success').then((value) => {
                                                    $("#edit_route_plan_modal").modal('hide');
                                                    load_route_plan();
                                                        });
                                               }
                                               else
                                               {
                                                    swal.fire({
                                                      icon: 'error',
                                                      title: 'Oops...',
                                                      text: 'Failed to update route plan details!'
                                                      
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
            else
            {
                swal.fire({
                                                      icon: 'error',
                                                      title: 'Oops...',
                                                      text: 'Please select gateway name!'
                                                      
                                                    });
            }



            }

        });


        });



        $("#save_sender_routing").click(function(){   
            var full_url = window.location.origin+"/itswe_sms_app";        
            $.ajax({
                url: full_url+'/controller/manage_gateway_controller.php',
                type: 'post',
                cache: false,
                data:$("#sender_routing_form").serialize(),
                success: function(data){
                    alert(data);                   
                    location.reload();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                }
            });
        });


        $(document).on( "click", '.edit_route_btn',function(e) {
  
            var id = $(this).data('id');
            var r_name=$(this).data('rname');
            var status=$(this).data('status');
            var start_time=$(this).data('starttime');
            var end_time=$(this).data('endtime');
            var rate=$(this).data('rate');
            var senderid=$(this).data('senderid');
            var dnd=$(this).data('dnd');

            $("#edit_route_id").val(id);
            $("#edit_route_name").val(r_name);
            $("#edit_status").val(status);
            $("#edit_rate").val(rate);
            if(end_time!='')
            {
                $("#edit_end_time").val(end_time);
            }
            else
            {
                $("#edit_end_time").val('');
            }
           
            if(start_time!='')
            {
                $("#edit_start_time").val(start_time);
            }
            else
            {
                 $("#edit_start_time").val('');
            }
           
          
            $(`#edit_status option[value='${status}']`).prop('selected', true);
            $(`#edit_sender_id option[value='${senderid}']`).prop('selected', true);
            $(`#edit_dnd_check option[value='${dnd}']`).prop('selected', true);
          
           
         
          
   
        });



        $(document).on( "click", '.edit_route_plan_btn',function(e) {
            
  
            var id = $(this).data('id');
            var rid=$(this).data('route');
            var status=$(this).data('status');
            var gateway=$(this).data('gateway');
            var plan_id=$(this).data('plan');
            //var gateway_id=gateway.split(",");

           $("#edit_gateway_name option:selected").prop("selected", false); 
          
           const gateway_id=gateway.toString().split(',');
          
              for(var i=0;i<gateway_id.length;i++)
              {
                console.log(gateway_id[i]);
                 $(`#edit_gateway_name option[value='${gateway_id[i]}']`).prop('selected', true);
              }


                 
            //    $('#edit_gateway_name').multiselect({
            //             columns: 1,
            //             refresh:true,
            //             placeholder: 'Select Gateway Name',
            //             search: true,
            //             selectAll: true
            //         });  
          $("#rp_id").val(id);
 
            $(`#edit_route_dropdown option[value='${rid}']`).prop('selected', true);
            $(`#edit_status option[value='${status}']`).prop('selected', true);
            $(`#edit_plan_name option[value='${plan_id}']`).prop('selected', true);
   
        });
});

function load_group_list()
{
    var full_url = window.location.origin+"/itswe_sms_app";
             $.ajax({
                url: full_url+'/controller/group_function.php',
                type: 'post',
                cache: false,
                data:'list_type=all',
                success: function(data){
                
                   if(data!=0)
                   {

                    $('#group_list').html(data);
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}

function load_route_list()
{
        var list_type="all"; 
           var full_url = window.location.origin+"/itswe_sms_app";
            $.ajax({
                url: full_url+'/controller/manage_gateway_controller.php',
                type: 'post',
                cache: false,
                data:'list_type=all',
                success: function(data){
                
                   if(data!=0)
                   {

                    $('#route_list').html(data);
                    $("#manage_route_tbl").DataTable();
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert("error"+data);
                    //$('#content').html(errorMsg);
                  }
            });
}


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
                    $('#sender_id1').empty();
                    $('#sender_id1').append(data['plan']);
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}

function load_route_plan()
{
    
         var full_url = window.location.origin+"/itswe_sms_app";
/*          var list_type="all_plan"; 
        table= $('#routing_plan_tbl').DataTable({
            "processing": true,
            "serverSide": true,
            "searching": false,
            "cache":true,
            "ajax":{
                    "type":"POST",
                    "url":full_url+"/controller/manage_gateway_controller.php",
                    "data":function (post) {
                        post.list_type=list_type;
                        return $.extend( {}, post, {
                       "search_keywords": $("#searchInput").val()
                       
                     } );
                      
                    }
                },
            "order": [[ 4, "desc" ]],
            /*"columnDefs": [
                        {"className": "dt-center", "targets": "_all"},
                       /* { 'visible': false, 'targets': [9] }
            ],
            "columnDefs": [
                        {"className": "dt-center", "targets": "_all"},
                        {
                            "render" : function (data, type, row) {
                                return data;
                            },
                            "targets": 1
                        }
                ],
            "bDestroy": true
        });*/
            $.ajax({
                url: full_url+'/controller/manage_gateway_controller.php',
                type: 'post',
                cache: false,
                "processing": true,
            "serverSide": true,
            "searching": false,
                data:'list_type=all_plan',
                success: function(data){
                
                   if(data!=0)
                   {

                    $('#route_plan').html(data);
                    $("#routing_plan_tbl").DataTable();
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}


function load_route_plan_form()
{
        var full_url = window.location.origin+"/itswe_sms_app";
    
            $.ajax({
                url: full_url+'/controller/manage_gateway_controller.php',
                type: 'post',
                cache: false,
                data:'list_type=create_plan_form',
                dataType:'JSON',
                success: function(data){
                
                  /* if(data!=0)
                   {*/
                    var response=JSON.parse(JSON.stringify(data));
                    
                   $('#plan_name').empty();
                    $('#plan_name').append(response['plan']);


                     $('#route_dropdown').empty();
                     $("#route_dropdown").append('<option value="">Select Route</option>');
                    $('#route_dropdown').append(response['route']);


                     $('#gateway_name').empty();
                     
                    $('#gateway_name').append(response['gateway']);


                     $('#gateway_name').multiselect({
                        columns: 1,
                        placeholder: 'Select Gateway Name',
                        search: true,
                        selectAll: true
                    });

                   //}
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(xhr.responseText);
                    //$('#content').html(errorMsg);
                  }
            });
}


function load_gateway()
{
        var full_url = window.location.origin+"/itswe_sms_app";
    
            $.ajax({
                url: full_url+'/controller/manage_gateway_controller.php',
                type: 'post',
                cache: false,
                data:'list_type=load_voice_gateway',
                dataType:'JSON',
                success: function(data){
               
                  /* if(data!=0)
                   {*/
                    var response=JSON.parse(JSON.stringify(data));


                     $('#gateway_name').empty();
                     
                    $('#gateway_name').append(response['gateway']);
                     $('#gateway_name').multiselect('reload');

                     $('#gateway_name').multiselect({
                        columns: 1,
                        placeholder: 'Select Gateway Name',
                        search: true,
                        selectAll: true
                    });

                   //}
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                   // console.log(xhr.responseText);
                    //$('#content').html(errorMsg);
                  }
            });
}

function load_gateway2()
{
        var full_url = window.location.origin+"/itswe_sms_app";
    
            $.ajax({
                url: full_url+'/controller/manage_gateway_controller.php',
                type: 'post',
                cache: false,
                data:'list_type=load_voice_gateway',
                dataType:'JSON',
                success: function(data){
               
                  /* if(data!=0)
                   {*/
                    var response=JSON.parse(JSON.stringify(data));


                     $('#edit_gateway_name').empty();
                     
                    $('#edit_gateway_name').append(response['gateway']);
                     $('#edit_gateway_name').multiselect('reload');

                     $('#edit_gateway_name').multiselect({
                        columns: 1,
                        placeholder: 'Select Gateway Name',
                        search: true,
                        selectAll: true
                    });

                   //}
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                   // console.log(xhr.responseText);
                    //$('#content').html(errorMsg);
                  }
            });
}

function load_other_gateway()
{
        var full_url = window.location.origin+"/itswe_sms_app";
    
            $.ajax({
                url: full_url+'/controller/manage_gateway_controller.php',
                type: 'post',
                cache: false,
                data:'list_type=load_other_gateway',
                dataType:'JSON',
                success: function(data){
               
                  /* if(data!=0)
                   {*/
                    var response=JSON.parse(JSON.stringify(data));


                     $('#gateway_name').empty();
                     
                    $('#gateway_name').append(response['gateway']);
                     $('#gateway_name').multiselect('reload');

                     $('#gateway_name').multiselect({
                        columns: 1,
                        placeholder: 'Select Gateway Name',
                        search: true,
                        selectAll: true
                    });

                   //}
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                   // console.log(xhr.responseText);
                    //$('#content').html(errorMsg);
                  }
            });
}


function load_other_gateway2()
{
        var full_url = window.location.origin+"/itswe_sms_app";
    
            $.ajax({
                url: full_url+'/controller/manage_gateway_controller.php',
                type: 'post',
                cache: false,
                data:'list_type=load_other_gateway',
                dataType:'JSON',
                success: function(data){
               
                  /* if(data!=0)
                   {*/
                    var response=JSON.parse(JSON.stringify(data));


                     $('#edit_gateway_name').empty();
                     
                    $('#edit_gateway_name').append(response['gateway']);
                     $('#edit_gateway_name').multiselect('reload');

                     $('#edit_gateway_name').multiselect({
                        columns: 1,
                        placeholder: 'Select Gateway Name',
                        search: true,
                        selectAll: true
                    });

                   //}
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                   // console.log(xhr.responseText);
                    //$('#content').html(errorMsg);
                  }
            });
}

function load_route_plan_edit_form()
{
        var full_url = window.location.origin+"/itswe_sms_app";
    
            $.ajax({
                url: full_url+'/controller/manage_gateway_controller.php',
                type: 'post',
                cache: false,
                data:'list_type=create_plan_form',
                dataType:'JSON',
                success: function(data){
                // console.log(data);
                  /* if(data!=0)
                   {*/
                    var response=JSON.parse(JSON.stringify(data));
                    
                   $('#edit_plan_name').empty();
                    $('#edit_plan_name').append(response['plan']);


                     $('#edit_route_dropdown').empty();
                     $("#edit_route_dropdown").append('<option value="">Select Route</option>');
                    $('#edit_route_dropdown').append(response['route']);


                     $('#edit_gateway_name').empty();
                     
                    $('#edit_gateway_name').append(response['gateway']);

/*
                     $('#edit_gateway_name').multiselect({
                        columns: 1,
                        placeholder: 'Select Gateway Name',
                        search: true,
                        selectAll: true
                    });*/

                   //}
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(xhr.responseText);
                    //$('#content').html(errorMsg);
                  }
            });
}
