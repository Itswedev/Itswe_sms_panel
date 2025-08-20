$(function(){

$("#bind_mode").change(function(){
    if($('#bind_mode').is(":checked")){ 
        $("#bind_mode_val").val('no');
       
        $(".tx_rx_mode").css('display','flex');
        $("#port").prop('readonly', true);
        $("#port").prop('disabled', true);
    }else{
        $(".tx_rx_mode").css('display','none');
        $("#bind_mode_val").val('yes');
        $("#port").prop('readonly', false);
        $("#port").prop('disabled', false);
       
    }

});


   

load_gateway_list();
	$("#save_gateway").click(function(){

     $( "#add_gateway_form" ).validate({

            rules: {
                smsc_id: "required",
                system_type: "required",
                username: "required",
                password: "required",   
                allowed_smsc_id: "required",
                host: "required",
                port: "required",
                tx_mode: "required",
                instances: "required",
                enquiry_interval: "required",
                charset: "required",
                source_ton: "required",
                source_npi: "required",
                destination_ton: "required",
                destination_npi: "required",
                max_pending: "required",
                gateway_status: "required",
                locate: "required"


            },
            messages: {
                smsc_id: "Please enter Gateway name",
                system_type: "Please enter system type",
                username: "Please enter username",
                password: "Please enter password",
                allowed_smsc_id: "Please enter allowed smsc id",
                host: "Please enter host",
                port: "Please enter port",
                tx_mode: "Please enter TX mode",
                instances: "Please enter instances",
                enquiry_interval: "Please enter Enquiry Interval",
                charset: "Please enter charset",
                source_ton: "Please enter Source Ton",
                source_npi: "Please enter Source NPI",
                destination_ton: "Please enter Destination Ton",
                destination_npi: "Please enter Destination NPI",
                max_pending: "Please enter max pending",
                gateway_status: "Please select Gateway status",
                locate: "Please select locate"
                
                
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
            // alert($('#bind_mode_val').val());

            // return false;

               //var full_url = window.location.origin;
                    $.ajax({
                    url: full_url+'/controller/gateway_controller.php',
                    type: 'post',
                    cache: false, 
                    data:$("#add_gateway_form").serialize(),
                    success: function(data){

                        swal.fire('',data,'success').then((value) => {

                            $('#add_gateway_modal').modal('hide');
                                                load_gateway_list();
                                                    });
                        
                     
                        
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

       $(document).on( "click", '.edit_gatway_btn',function(e) {
  
            var id = $(this).data('id');
            //var full_url = window.location.origin;
            $.ajax({
                    url: full_url+'/controller/gateway_controller.php',
                    type: 'post',
                    cache: false, 
                    data:"list_type=load_gateway_edit_form&gateway_id="+id,
                    dataType:'json',
                    success: function(data){

                    var res = JSON.parse(JSON.stringify(data));
                    var status=res['status'];
                    $("#gateway_id").val(res['gateway_id']);
                    $("#conf_file").val(res['conf_file']);
                    $("#log_file").val(res['log_file']);
                    $("#edit_smsc_id").val(res['smsc_id']);
                    $("#edit_system_type").val(res['system_type']);
                    $("#edit_username").val(res['username']);
                    $("#edit_password").val(res['password']);
                    $("#edit_ip_address").val(res['ip_address']);
                    $("#edit_allowed_smsc_id").val(res['allowed_smsc_id']);
                    $("#edit_host").val(res['host']);
                    $("#edit_port").val(res['port']);
                    $("#edit_tx_mode").val(res['tx_mode']);
                    $("#edit_instances").val(res['instances']);
                    $("#edit_enquiry_interval").val(res['enquiry_interval']);
                    $("#edit_charset").val(res['charset']);
                    $("#edit_source_ton").val(res['source_ton']);
                    $("#edit_source_npi").val(res['source_npi']);
                    $("#edit_destination_ton").val(res['destination_ton']);
                    $("#edit_destination_npi").val(res['destination_npi']);
                    $("#edit_max_pending").val(res['max_pending']);
                    $("#edit_locate").val(res['locate']);
                    $(`#edit_gateway_status option[value='${status}']`).prop('selected', true);
                    
                     
                        
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(data);
                        //$('#content').html(errorMsg);
                      }
                });
            
          
   
        });


        $(document).on( "click", '.delete_gateway_btn',function(e) {
  
    var id = $(this).data('id');

           swal.fire({
  title: 'Are you sure?',
  text: "You want to delete this Gateway Details?",
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
    //var full_url = window.location.origin;
                            $.ajax({
                                        url: full_url+'/controller/gateway_controller.php',
                                        type: 'post',
                                        cache: false, 
                                        data:'list_type=delete_gateway&gateway_id='+id,
                                        success: function(data){
                                           
                                           if(data==1)
                                           {
                                                swal.fire('','Gateway Details Deleted Successfully!!','success').then((value) => {
                                                load_gateway_list();
                                                    });
                                           }
                                           else
                                           {
                                                swal.fire({
                                                  icon: 'error',
                                                  title: 'Oops...',
                                                  text: 'Failed to delete gateway details!'
                                                  
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




$("#edit_gateway").click(function(){

     $( "#edit_gateway_form" ).validate({

            rules: {
                smsc_id: "required",
                system_type: "required",
                username: "required",
                password: "required",
                ip_address: "required",
                allowed_smsc_id: "required",
                host: "required",
                port: "required",
                tx_mode: "required",
                instances: "required",
                enquiry_interval: "required",
                charset: "required",
                source_ton: "required",
                source_npi: "required",
                destination_ton: "required",
                destination_npi: "required",
                max_pending: "required",
                gateway_status: "required",
                locate: "required"


            },
            messages: {
                smsc_id: "Please enter Gateway name",
                system_type: "Please enter system type",
                username: "Please enter username",
                password: "Please enter password",
                ip_address: "Please enter ip address",
                allowed_smsc_id: "Please enter allowed smsc id",
                host: "Please enter host",
                port: "Please enter port",
                tx_mode: "Please enter TX mode",
                instances: "Please enter instances",
                enquiry_interval: "Please enter Enquiry Interval",
                charset: "Please enter charset",
                source_ton: "Please enter Source Ton",
                source_npi: "Please enter Source NPI",
                destination_ton: "Please enter Destination Ton",
                destination_npi: "Please enter Destination NPI",
                max_pending: "Please enter max pending",
                gateway_status: "Please select Gateway status",
                locate: "Please select locate"
                
                
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

                //var full_url = window.location.origin;
                
                    $.ajax({
                    url: full_url+'/controller/gateway_controller.php',
                    type: 'post',
                    cache: false, 
                    data:$("#edit_gateway_form").serialize(),
                    success: function(data){

                        if(data==1)
                        {
                             swal.fire('','Gateway Details Updated Successfully!!','success').then((value) => {
                                $('#edit_gateway_modal').modal('hide');
                                load_gateway_list();
                            });
                  
                        }
                        else
                        {
                             swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Failed to Update Gateway Details!'
                              
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


function load_gateway_list()
{
        //var full_url = window.location.origin;
            $.ajax({
                url: full_url+'/controller/gateway_controller.php',
                type: 'post',
                "cache": false, 
                 "processing": true,
            "serverSide": true,
            "searching": false,
                data:'list_type=all_gateway',
                success: function(data){
                
                   if(data!=0)
                   {

                    $('#gateway_list').html(data);
                    $("#gateway_tbl").DataTable();
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
}