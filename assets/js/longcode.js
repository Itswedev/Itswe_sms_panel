var table;

var frmDate = "";
var toDate = ""; 

$( document ).ready(function(){

    var page_name=$("#page_name").html();


       

    if(page_name=='# Longcode Details')
    {
            load_longcode_dtls();
            load_username_dropdown();

         $(".response").css('display','none');
    }
    else if(page_name=='# Longcode Report')
    {

            frmDate = $("#frmDate").val();
          toDate = $("#toDate").val();
        load_service_number_dropdown();
        load_longcode_report();

    }

     $("#service_number").change(function(event){
        load_longcode_report();
     });

    $("#get_reponse").change(function(event){
            if($('#get_reponse').is(":checked")){  
                $("#end_point_config").prop('checked',false);
                load_sender_id();
                load_route_id();
                $("#username_senderid").change(function(event){
                load_sender_id();
                load_route_id();
            });

                 $(".response").css('display','');
                 $(".end_point_dtls").css('display','none');

               
        }
        else
        {
             $("#end_point_config").prop('checked',true);
            $(".response").css('display','none');
            $(".end_point_dtls").css('display','');
        }
    });



        $(document).on( "click", '.edit_admin_mulitmedia_btn',function(e) {
           
  
            var id = $(this).data('id');
            var uid=$(this).data('uid');
            var longcode=$(this).data('longcode');
            var get_response=$(this).data('get_response');
            var end_point=$(this).data('end_point');
            var end_point_config=$(this).data('end_point_config');
            var status=$(this).data('status');
            var format=$(this).data('format');
            
            if(get_response=='Yes')
            {
                $("#edit_get_reponse").prop('checked','checked');
                $(".response").css('display','');
                 $(".end_point_dtls").css('display','none');

            }
            else
            {
                 $("#edit_get_reponse").prop('checked',false);
                $(".response").css('display','none');
                $(".end_point_dtls").css('display','');
            }


            if(end_point_config=='Yes')
            {
                $("#edit_end_point_config").prop('checked','checked');
            }
            else
            {
                $("#edit_end_point_config").prop('checked',false);
            }


            if(format=='simple')
            {
                $("#edit_format1").prop('checked','checked');
                 $("#edit_format2").prop('checked',false);
            }
            else
            {
               $("#edit_format1").prop('checked',false);
                $("#edit_format2").prop('checked','checked'); 
            }

            $("#edit_id").val(id);
            $("#edit_longcode").val(longcode);
            $("#edit_end_point").text(end_point);
            // $("#edit_error_status").val(err_status);
            // var gateway_arr = gateway_name.split(','); 


            // Preselect the option with the specified value
            $(`#edit_username_senderid option[value='${uid}']`).prop('selected', true);
            $('#edit_username_senderid').trigger("chosen:updated");
            //$(`#edit_gateway_name option[value='smartpingOTP']`).prop('selected', true);
            $("#edit_admin_multimedia_modal").modal('show');
    
        });


 $("#end_point_config").change(function(event){
            if($('#end_point_config').is(":checked")){  
                $("#get_reponse").prop('checked',false);
                  $(".response").css('display','none');
                  $(".end_point_dtls").css('display','');
                 //$(".response").css('display','');
        }
        else
        {
            $("#get_reponse").prop('checked',true);

              $(".response").css('display','');
              $(".end_point_dtls").css('display','none');
            //$(".response").css('display','none');
        }
    });




     $("#sid").change(function(){

        var sid=$('#sid option:selected').val();
        /*alert(sid);*/
        if(sid!='')
        {
            var selected_user=$("#username_senderid").val();

 
         //var full_url = window.location.origin;
   $.ajax({
                    url: full_url+'/controller/multimedia_controller.php',
                    type: 'post',
                    cache: false, 
                    data:"type=load_template_with_sid&sid="+sid+"&selected_userid="+selected_user,
                    success: function(data){
                  console.log(data);
                     if(data!=0)
                     {

                       $('#template').empty();
                       $('#template').html(data);

                       $('#edit_template').empty();
                       $('#edit_template').html(data);
                        //$("#addtemplateForm").trigger('reset');
                       
                     }
                        
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(data);
                        //$('#content').html(errorMsg);
                      }
                });
            }
    })


            $("#save_longcode").click(function(){

                $( "#add_longcode_form" ).validate( {
                rules: {
                    longcode: "required",
                },
                messages: {
                    longcode: "Please select Username",
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
                            url: full_url+'/controller/longcode_controller.php',
                            type: 'post',
                            cache: false,
                            data:$( "#add_longcode_form" ).serialize(),
                            success: function(data){
                               /* alert(data);*/
                              /* console.log(data);*/
                               if(data==1)
                                {
                                    Swal.fire("Successful !",'Longcode details added successfully','success').then((value) => {
                                     $("#longcode_modal").modal('hide');

                                                 $("#add_longcode_form").trigger('reset');
                                         window.location.reload(full_url+'/view/include/modal_forms/longcode_modal.php');
                                                //load_template_list();
                                    });
                                        
                                }
                                else
                                {
                                    swal.fire({
                                                icon: 'error',
                                                title: 'Oops...',
                                                text: data            
                                            });
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

    });


    $("#update_longcode").click(function(){

        $( "#edit_longcode_form" ).validate( {
        rules: {
            longcode: "required",
        },
        messages: {
            longcode: "Please select Username",
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
                    url: full_url+'/controller/longcode_controller.php',
                    type: 'post',
                    cache: false,
                    data:$( "#edit_longcode_form" ).serialize(),
                    success: function(data){
                       /* alert(data);*/
                      /* console.log(data);*/
                       if(data==1)
                        {
                            Swal.fire("Successful !",'Longcode details updated successfully','success').then((value) => {
                             $("#edit_admin_multimedia_modal").modal('hide');

                                         $("#edit_longcode_form").trigger('reset');
                                 window.location.reload(full_url+'/view/include/modal_forms/longcode_modal.php');
                                        //load_template_list();
                            });
                                
                        }
                        else
                        {
                            swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: data            
                                    });
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

});

            $(document).on('click','#download_report_btn',function(){
            
            var list_type="download_longcode_report"; 
            //var full_url = window.location.origin;

            frmDate = ($("#frmDate").val()) ? $("#frmDate").val() : '';

    toDate = ($("#toDate").val()) ? $("#toDate").val() : '';
    var service_number=$("#service_number").val();
            var data_string="type="+list_type+"&frmDate="+frmDate+"&toDate="+toDate+"&service_number="+service_number;
                 $.ajax({
                    url: full_url+"/controller/longcode_controller.php",
                    type: 'post',
                    data: data_string,
                    cache: false,
                    success: function(data){
                    window.open(full_url+"/controller/longcode_controller.php?"+data_string);
    
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(errorMsg);
                        //$('#content').html(errorMsg);
                      }
                });


            
            })





        $(document).on( "click", '.delete_longcode_btn',function(e) {
  
    var id = $(this).data('id');
    

   
           swal.fire({
  title: 'Are you sure?',
  text: "You want to delete this Longcode Details!",
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
                                        url: full_url+'/controller/longcode_controller.php',
                                        type: 'post',
                                        cache: false, 
                                        data:'type=delete_longcode&id='+id,
                                        success: function(data){
                                           
                                           if(data==1)
                                           {
                                                swal.fire('Success','Longcode Details Deleted Successfully!!','success').then((value) => {

                                                 window.location.reload(full_url+'/dashboard.php?page=longcode');
                                                    });
                                           }
                                           else
                                           {
                                                swal.fire({
                                                  icon: 'error',
                                                  title: 'Oops...',
                                                  text: 'Failed to delete Longcode details!'
                                                  
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

function load_longcode_dtls()
{
    //var full_url = window.location.origin;


           $.ajax({
                url: full_url+'/controller/longcode_controller.php',
                type: 'post',
                cache: false, 
                data:'type=all_longcode',
                async:true,

                success: function(data){
                /*  console.log(data)*/
                $('#longcode_list').empty();
                $('#longcode_list').append(data);
                $('#longcode_tbl').DataTable();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
}
// function searchData_report() {
//     /*alert('sdf');*/
//     frmDate = ($("#frmDate").val()) ? $("#frmDate").val() : '';
   
//     toDate = ($("#toDate").val()) ? $("#toDate").val() : '';
//     table.draw();
// }


function load_longcode_report()
{
    //var full_url = window.location.origin;
    frmDate = ($("#frmDate").val()) ? $("#frmDate").val() : '';

    toDate = ($("#toDate").val()) ? $("#toDate").val() : '';
    var service_number=$("#service_number").val();
           $.ajax({
                url: full_url+'/controller/longcode_controller.php',
                type: 'post',
                cache: false, 
                data:'type=longcode_report&service_number='+service_number+"&frmDate="+frmDate+"&toDate="+toDate,
                async:true,

                success: function(data){
                /*  console.log(data)*/
                $('#longcode_summary_report').empty();
                $('#longcode_summary_report').append(data);
                $('#longcode_summary_tbl').DataTable();
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
    
    //var full_url = window.location.origin;
   
    var selected_user=$("#username_senderid").val();
    var dataString="";
    dataString="selected_userid="+selected_user+"&type=load_sender_id";


     $.ajax({
                url: full_url+'/controller/multimedia_controller.php',
                type: 'post',
                data:dataString,
                cache: false,
                    beforeSend: function(){
                     $('.ajax-loader').css("visibility", "visible");
                   },
                   complete: function(){
                    $('.ajax-loader').css("visibility", "hidden");
                   },
                success: function(data){
                    console.log(data);
                   if(data!=0)
                   {
                    $('#sid').empty();
                    $('#sid').html(data);

                     $('#edit_sid').empty();
                    $('#edit_sid').html(data);
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
}


function load_route_id()
{
    
    //var full_url = window.location.origin;
   
    var selected_user=$("#username_senderid").val();
    var dataString="";
    dataString="selected_userid="+selected_user+"&type=load_route_id";


     $.ajax({
                url: full_url+'/controller/multimedia_controller.php',
                type: 'post',
                data:dataString,
                cache: false,
                    beforeSend: function(){
                     $('.ajax-loader').css("visibility", "visible");
                   },
                   complete: function(){
                    $('.ajax-loader').css("visibility", "hidden");
                   },
                success: function(data){
                    console.log(data);
                   if(data!=0)
                   {
                    $('#route_id').empty();
                    $('#route_id').html(data);


                    $('#edit_route_id').empty();
                    $('#edit_route_id').html(data);
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
}

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

                   $("#username_senderid").chosen(); 
                   $("#username_senderid_chosen").css('width','100%');


                   $('#edit_username_senderid').empty();
                    $('#edit_username_senderid').html(data);

                   $("#edit_username_senderid").chosen(); 
                   $("#edit_username_senderid_chosen").css('width','100%');

                    $('#callerid_username_senderid').empty();
                    $('#callerid_username_senderid').html(data);

                   $("#callerid_username_senderid").chosen(); 
                   $("#callerid_username_senderid_chosen").css('width','100%');

                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
}

function load_service_number_dropdown()
{
        //var full_url = window.location.origin;
            $.ajax({
                url: full_url+'/controller/longcode_controller.php',
                type: 'post',
                cache: false,
                data:'type=load_service_number',
                success: function(data){

                   if(data!=0)
                   {
                    $('#service_number').empty();
                    $('#service_number').html(data);

                   $("#service_number").chosen(); 
                   $("#service_number_chosen").css('width','100%');

                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
}
