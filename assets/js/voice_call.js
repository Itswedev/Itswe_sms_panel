

var table;
var frmDate = "";
var toDate = ""; 
var today_report_type="";

$( document ).ready(function(){


    
    var page_name=$("#page_name").html();



         $(document).on( "click", '.delete_message_job_btn',function(e) {

            
            var msg_id = $(this).data('id');
            var table_name = $(this).data('tblname');
            
            // alert(table_name);

        swal.fire({
  title: 'Are you sure?',
  text: "You want to delete this schedule!",
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
    var full_url = window.location.origin;
               $.ajax({
                url: full_url+'/controller/multimedia_controller.php',
                type: 'post',
                cache: false, 
                data:'type=delete_schedule&msg_id='+msg_id+'&table_name='+table_name,
                success: function(data){
                   swal.fire('',data,'success').then((value) => {
                             location.reload();
                            });
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




    if(page_name=='# Voice Call Report')
    {
        load_voice_job_data();


        $(document).on('click','#download_report_btn',function(){
            alert('test');
            
            var list_type="send_job_summary_report"; 
            var full_url = window.location.origin;

            var data_string="list_type="+list_type+"&frmDate="+frmDate+"&toDate="+toDate;
                 $.ajax({
                    url: full_url+"/controller/download_voice_report_controller.php",
                    type: 'post',
                    data: data_string,
                    cache: false,
                    success: function(data){
                    window.open(full_url+"/controller/download_voice_report_controller.php?"+data_string);
    
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(errorMsg);
                        //$('#content').html(errorMsg);
                      }
                });


            
            })
    }
    else if(page_name=='Send Voice Job')
    {
        load_voice_job_dtl_data();
         var job_id=$("#job_id").text();
         var job_date=$("#job_date").text();
         $(document).on('click','#download_report_btn',function(){
            
            
            var list_type="download_report"; 
            var full_url = window.location.origin;

            var data_string="list_type="+list_type+"&frmDate="+frmDate+"&toDate="+toDate+"&job_id="+job_id+"&job_date="+job_date;
                 $.ajax({
                    url: full_url+"/controller/download_voice_report_controller.php",
                    type: 'post',
                    data: data_string,
                    cache: false,
                    success: function(data){
                    window.open(full_url+"/controller/download_voice_report_controller.php?"+data_string);
    
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(errorMsg);
                        //$('#content').html(errorMsg);
                      }
                });


            
            })
      
    }
     else if(page_name=='Today Voice Summary Report')
    {
        
        var user_role=$("#user_role").val();
        if(user_role=="mds_rs" || user_role=="mds_ad" || user_role=="mds_adm")
        {
            $("#user_dropdown").change(function(){
       
            load_today_summary_report();

            })
        }
        else
        {
            load_today_summary_report();
        }


           $(document).on("change","#user_role_dropdown", function (e) {

        var user_role=$("#user_role_dropdown").val();

        if(user_role!='All')
        {
            load_users();
        }
        else
        {
            if(page_name=='Today Voice Summary Report')
            {
                load_today_summary_report();
            }
            else if(page_name=='Scheduled Voice Report')
            {
                load_scheduled_report();
            }
            
        }
        
        });
      
    }
    else if(page_name=='Scheduled Voice Report')
    {

        load_scheduled_report();
    }
    else if(page_name=='Today Voice Report')
    {

         //today_report_type="total";
         var list_type="today_report";
         var today_report=$("#report_type").val();
          var selected_role=$("#selected_role").val();

 var user_role=$("#user_role").val();

 var uid=$("#uid").val();
         var full_url = window.location.origin;
         table= $('#today_report_tbl').DataTable( {
        "processing": true,
        "serverSide": true,
        "responsive": true,
         "ajax": {
                    "type":"POST",
                    "url":full_url+"/controller/multimedia_controller.php",
                    "data":function (post) {
                                post.type=list_type;
                                post.report_type=today_report;
                                post.user_role=user_role; 
                                post.uid=uid; 
                                post.selected_role=selected_role;    
                                if(frmDate!="" && toDate!="")
                                {
                                     post.frmDate = frmDate;
                                    post.toDate = toDate;
                                }
                     
                        }
         },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, 500]],
         "order": [[ 0, "desc" ]],
          "columnDefs": [
                        {"className": "dt-center", "targets": "_all"}
            ]

        } );

    }
    else
    {

         $("#voice_file").change(function(){
                
                var file_id=$(this).val();

                var full_url = window.location.origin;
                var dataString="";
                dataString="type=load_duration&file_id="+file_id;
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
                                $('#disp_duration').empty();
                                $('#disp_duration').html(data);
                               }
                                
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                                alert(errorMsg);
                                //$('#content').html(errorMsg);
                              }
                        });
                       

            })


         $(".response").css('display','none');
         $(".sms_api").css('display','none');

         $("#get_response").change(function(event){


        if($('#get_response').is(":checked")){  
           
            load_sender_id();
              load_route_id();
             $("#username_senderid").change(function(event){
            load_sender_id();
             load_route_id();
        });

             $(".response").css('display','');
             $(".sms_api").css('display','none');
             $("#sms_api").prop("checked", false);

           
    }
    else
    {
        $(".response").css('display','none');
        $(".sms_api").css('display','none');
        $("#sms_api").prop("checked", false);
    }
});



 $("#sms_api").change(function(event){


        if($('#sms_api').is(":checked")){  
           
           
            $(".sms_api").css('display','');
             $(".response").css('display','none');
             $("#get_response").prop("checked", false);

           
    }
    else
    {
        $(".response").css('display','none');
        $(".sms_api").css('display','none');
         $("#get_response").prop("checked", false);

    }
});


$("#edit_get_response").change(function(event){


        if($('#edit_get_response').is(":checked")){  

           
            load_sender_id();
              load_route_id();
             $("#username_senderid").change(function(event){
            load_sender_id();
             load_route_id();
        });

             $(".edit_response").css('display','');

           
    }
    else
    {
        $(".edit_response").css('display','none');
    }
});


    $("#dtmf").change(function(event){
    if($('#dtmf').is(":checked")){  
           
             $("#wait_duration").css('display','');
    }
    else
    {
        $("#wait_duration").css('display','none');
    }
});


    $("#simple").change(function(event){
    if($('#simple').is(":checked")){  
           
             $("#wait_duration").css('display','none');
    }
    else
    {
        $("#wait_duration").css('display','');
    }
});



        $("#call_latching").change(function(event){
    if($('#call_latching').is(":checked")){  
           
             $("#wait_duration").css('display','none');
    }
    else
    {
        $("#wait_duration").css('display','');
    }
});


        
        
          load_caller_id_dtls();
        load_multimedia_dtls();
      
       load_username_dropdown();
       load_caller_id_dropdown();
       load_voice_file_dropdown();
       load_group_dropdown();
    }

        $(document).on("click",".report_type", function (e) {
        var report_status=$(this).attr('name');
        var user_role = $(this).data('role');
        var selected_role = $(this).data('selected_role');

        var uid = $(this).data('uid');
        //sessionStorage.setItem("report_type",report_status);
        window.location.href="dashboard.php?page=today_voice_report&report_type="+report_status+"&user_role="+user_role+"&uid="+uid+"&selected_role="+selected_role;
});


function load_today_summary_report()
{
    //alert('summary');
    var full_url = window.location.origin;
    var selected_role=$("#user_role_dropdown").val();
    var user_role=$("#user_role").val();
    var u_id=$("#user_dropdown").val();
    var dataString="";
    if(user_role=='mds_rs' || user_role=='mds_ad' || user_role=='mds_adm')
    {
        dataString='type=load_today_summary'+'&user_role='+user_role+'&u_id='+u_id+'&selected_role='+selected_role;
    }
    else
    {
       dataString= 'type=load_today_summary'+'&user_role='+user_role;
    }


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
                    /*console.log(data);*/
                   if(data!=0)
                   {
                    $('#today_summary_list').empty();
                    $('#today_summary_list').html(data);
                   }
                    
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
    
    var full_url = window.location.origin;
   
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
    
    var full_url = window.location.origin;
   
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

 $("#sid").change(function(){

        var sid=$('#sid option:selected').val();
        /*alert(sid);*/
        if(sid!='')
        {
            var selected_user=$("#username_senderid").val();

 
         var full_url = window.location.origin;
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


  $("#edit_sid").change(function(){

        var sid=$('#edit_sid option:selected').val();
        /*alert(sid);*/
        if(sid!='')
        {
            var selected_user=$("#edit_userid").val();

 
         var full_url = window.location.origin;
   $.ajax({
                    url: full_url+'/controller/multimedia_controller.php',
                    type: 'post',
                    cache: false, 
                    data:"type=load_template_with_sid&sid="+sid+"&selected_userid="+selected_user,
                    success: function(data){
                  console.log(data);
                     if(data!=0)
                     {

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
function load_scheduled_report()
{
        var type="schedule_report";
        var full_url = window.location.origin;
        var selected_role=$("#user_role_dropdown").val();
        var user_role=$("#user_role").val();
        var u_id=$("#user_dropdown").val();
         table= $('#scheduled_report_tbl').DataTable({
        "processing": true,
        "serverSide": true,
         "ajax": {
                    "type":"POST",
                    "url":full_url+"/controller/multimedia_controller.php",
                    "data":function (post) {
                            post.type=type;
                            post.user_role=user_role;
                            post.u_id=u_id; 
                            post.selected_role=selected_role; 

                            if(frmDate!="" && toDate!="")
                            {
                                 post.frmDate = frmDate;
                                post.toDate = toDate;
                            }
                           
                        }
         },
          "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, 500]],
          stateSave: false,
         "order": [[ 0, "desc" ]],
         "bDestroy": true
        

        });

        table.column(8).visible(false);
}




function load_users()
{
    var full_url = window.location.origin;

    var role=$("#user_role_dropdown").val();
    $(".role_name").text(role);
           $.ajax({
                url: full_url+'/controller/user_controller.php',
                type: 'post',
                cache: false, 
                data:'list_type=load_userslist&role='+role,
                async:true,

                success: function(data){
                  /*alert(data);*/
                  $("#user_dropdown").empty();
                  $("#user_dropdown").append(data);

                //  $(`#user_dropdown_chosen`).trigger("chosen:updated");
                //    $("#user_dropdown_chosen").css('width','100%');

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
}

       $("#importBtn_bulk").click(function(){
/*	e.preventDefault();*/
	var full_url = window.location.origin;
	var file_data = $('#uploadfile').prop('files')[0];
	var bar = $('#bar');
     if(file_data != undefined) {
     	var form_data = new FormData();   
     	form_data.append('uploadfile', file_data); 
     	form_data.append('act','import3');
	 $.ajax({
                url: full_url+'/controller/multimedia_controller.php',
                type: 'post',
                data:form_data,
	            cache: false,             // To unable request pages to be cached
	            contentType: false,
                 processData: false,        // To send DOMDocument or non processed data file it is set to false
                beforeSend: function(){
                    var percentVal = '0%';
			      bar.width(percentVal);
			      bar.html(percentVal);
			    
                   },
                   uploadProgress: function(event, position, total, percentComplete) {
			      var percentVal = percentComplete + '%';
			      bar.width(percentVal);
			       bar.html(percentVal);
			     
			    },
                complete: function(){
                   // $("#loading_modal").modal('hide');
                   },
                success: function(data){
                	//alert(data);
                	var percentVal = '100%';
      			bar.width(percentVal);
      			 bar.html(percentVal);
                  /*console.log(data);*/
                  var d = data.split('|');
			$('#numbers').val(d[0].trim());
			$('#counti').html(d[1]);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
	}
})

/*send call*/

$("#send_call").click(function(){
        $( "#sendCALLForm" ).validate( {
            rules: {
                voice_file: "required",
                retry_attempt: "required",
                retry_duration: "required",
                numbers: "required",
              


            },
            messages: {
                voice_file: "Please select Route",
                numbers: "Please Enter Mobile Number",
                retry_attempt: "Please Select Retry Attempt",
                retry_duration: "Please Select Retry Duration",
                
                
                
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
            /*console.log('Form submitted');*/
            if($('#vsms').is(':checked')) { 
                /*console.log($("#caller_id").val());*/
                    var caller_id=$("#caller_id").val();
                    if(caller_id=='')
                    {
                         swal.fire({
                              icon: 'error',
                              title: 'Error...',
                              text: 'Please Select Caller ID',
                              footer: ''
                            });

                         return false;
                    }

            
            }
            

            if($('#dtmf').is(':checked')) { 
                /*console.log($("#caller_id").val());*/
                    var wait_duration=$("#wait_duration").val();
                    if(wait_duration=='')
                    {
                         swal.fire({
                              icon: 'error',
                              title: 'Error...',
                              text: 'Please Select wait duration',
                              footer: ''
                            });

                         return false;
                    }

            
            }
            

            swal.fire({
  title: 'Are you sure?',
  text: "You want to send this call!",
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
     var full_url = window.location.origin;
   $.ajax({
                    url: full_url+'/controller/sending1.php',
                    type: 'post',
                    cache: false, 
                    data:$("#sendCALLForm").serialize()+"&btn_send=send_call",
                     beforeSend: function(){
                     $("#loading_modal").modal('show');
                   },
                   complete: function(){
                    $("#loading_modal").modal('hide');
                   },
                    success: function(data){
                      //  alert(data);
                       /* console.log(data);
                        swal.fire('',data,'success').then((value) => {
                
                            });*/
                        /*console.log(data);*/

                        var msg=data.split("|");
                       if(msg[0].trim()=='Call Successfully Send')
                       {

                            if(msg[1]!='0'||msg[1]!=0)
                            {
                                //alert('wrong');
                                swal.fire('',msg[0]+"<br/>"+msg[1],'success').then((value) => {
                                  window.location.reload();
                                  $("#sendCALLForm").trigger('reset');
                                });
                            }
                            else
                            {
                                swal.fire('',msg[0],'success').then((value) => {
                                  window.location.reload();
                                  $("#sendCALLForm").trigger('reset');
                                });
                            }
                            
                       }
                       else
                       {
                            swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: msg[0],
                              footer: ''
                            })
                       }                     
                        
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.thrownError;
                        alert(errorMsg);
                        //$('#content').html(errorMsg);
                      }
                });
           

			  }
			})
        
        }

        });
});


// schedule later start

$("#schedule_now_btn").click(function(){


    
  var btn_val=$(this).val();
  setSubmitBtnValue(btn_val);
  
  var schedule_date = $("#datepicker").val();

  if(schedule_date!='')
  {
      $("#is_schedule").val('1');
  }


    $( "#sendCALLForm" ).validate( {
        rules: {
            voice_file: "required",
            retry_attempt: "required",
            retry_duration: "required",
            numbers: "required",
          


        },
        messages: {
            voice_file: "Please select Route",
            numbers: "Please Enter Mobile Number",
            retry_attempt: "Please Select Retry Attempt",
            retry_duration: "Please Select Retry Duration",
            
            
            
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
        /*console.log('Form submitted');*/
        if($('#vsms').is(':checked')) { 
            /*console.log($("#caller_id").val());*/
                var caller_id=$("#caller_id").val();
                if(caller_id=='')
                {
                     swal.fire({
                          icon: 'error',
                          title: 'Error...',
                          text: 'Please Select Caller ID',
                          footer: ''
                        });

                     return false;
                }

        
        }
        

        if($('#dtmf').is(':checked')) { 
            /*console.log($("#caller_id").val());*/
                var wait_duration=$("#wait_duration").val();
                if(wait_duration=='')
                {
                     swal.fire({
                          icon: 'error',
                          title: 'Error...',
                          text: 'Please Select wait duration',
                          footer: ''
                        });

                     return false;
                }

        
        }
        

        swal.fire({
title: 'Are you sure?',
text: "You want to send this call!",
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
 var full_url = window.location.origin;
$.ajax({
                url: full_url+'/controller/sending1.php',
                type: 'post',
                cache: false, 
                data:$("#sendCALLForm").serialize()+"&btn_send=schedule_call",
                 beforeSend: function(){
                 $("#loading_modal").modal('show');
               },
               complete: function(){
                $("#loading_modal").modal('hide');
               },
                success: function(data){
               

                    var msg=data.split("|");
                   if(msg[0].trim()=='Call Successfully Scheduled')
                   {

                        if(msg[1]!='0'||msg[1]!=0)
                        {
                            //alert('wrong');
                            swal.fire('',msg[0]+"<br/>"+msg[1],'success').then((value) => {
                              window.location.reload();
                              $("#sendCALLForm").trigger('reset');
                            });
                        }
                        else
                        {
                            swal.fire('',msg[0],'success').then((value) => {
                              window.location.reload();
                              $("#sendCALLForm").trigger('reset');
                            });
                        }
                        
                   }
                   else
                   {
                        swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: msg[0],
                          footer: ''
                        })
                   }                     
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.thrownError;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
       

          }
        })
    
    }

    });
});

//schedule later end



/*Schedule Call*/

$("#schedule_call").click(function(){

     $("#is_schedule").val('1');
        $( "#sendCALLForm" ).validate( {
            rules: {
                voice_file: "required",
                retry_attempt: "required",
                retry_duration: "required",
                numbers: "required",
                scheduleDateTime: "required",


            },
            messages: {
                voice_file: "Please select Route",
                numbers: "Please Enter Mobile Number",
                retry_attempt: "Please Select Retry Attempt",
                retry_duration: "Please Select Retry Duration",
                scheduleDateTime: "Please Select Schedule Date",
                
                
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
            /*console.log('Form submitted');*/
            if($('#vsms').is(':checked')) { 
                /*console.log($("#caller_id").val());*/
                    var caller_id=$("#caller_id").val();
                    if(caller_id=='')
                    {
                         swal.fire({
                              icon: 'error',
                              title: 'Error...',
                              text: 'Please Select Caller ID',
                              footer: ''
                            });

                         return false;
                    }

            
            }
            

            swal.fire({
  title: 'Are you sure?',
  text: "You want to schedule this call!",
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
     var full_url = window.location.origin;
   $.ajax({
                    url: full_url+'/controller/sending1.php',
                    type: 'post',
                    cache: false, 
                    data:$("#sendCALLForm").serialize()+"&btn_send=schedule_call",
                     beforeSend: function(){
                     $("#loading_modal").modal('show');
                   },
                   complete: function(){
                    $("#loading_modal").modal('hide');
                   },
                    success: function(data){
                        var msg=data.split("|");
                       if(msg[0].trim()=='Call Successfully Scheduled')
                       {

                            if(msg[1]!='0'||msg[1]!=0)
                            {
                                //alert('wrong');
                                swal.fire('',msg[0]+"<br/>"+msg[1],'success').then((value) => {
                                  window.location.reload();
                                  $("#sendCALLForm").trigger('reset');
                                });
                            }
                            else
                            {
                                swal.fire('',msg[0],'success').then((value) => {
                                  window.location.reload();
                                  $("#sendCALLForm").trigger('reset');
                                });
                            }
                            
                       }
                       else
                       {
                            swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: msg[0],
                              footer: ''
                            })
                       }

                    
                     
                        
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.thrownError;
                        alert(errorMsg);
                        //$('#content').html(errorMsg);
                      }
                });
           

              }
            })
        
        }

        });
});

$("#vsms").change(function(event){
        if($('#vsms').is(':checked')) { 
          $("#caller_id").css('display','');

    }
    else
        {
            $("#caller_id").css('display','none');
        }
    });

       $(".msg_format").change(function(){

		var msg_format_type=$(this).val();
		if(msg_format_type=='numbers')
		{
			$("#msg_format_lbl").html('Numbers');
			$('.numbers').css('display','');
			$('.csv_xls_txt').css('display','none');
			$('#number_area').css('display','');
			$('.groups').css('display','none');
			$('#add_group_btn').css('display','none');
			$('#importBtn').css('margin-top','');
			$('#number_area').css('margin-top','');
			$('#msg-btn-mb-cnt').css('display','');
			$('#numbers').val('');
			$('#numbers').css('display','');
			$("#counti").html(0);
			$('#muliselect_div').css('display','none');

		}
		else if(msg_format_type=='groups')
		{
			$("#msg_format_lbl").html('Select Groups');
			$('#numbers').css('display','none');
			$('.csv_xls_txt').css('display','none');
			$('.groups').css('display','');
			$('#number_area').css('display','none');

			$('#add_group_btn').css('display','');
			$('#importBtn').css('margin-top','');
			$('#msg-btn-mb-cnt').css('display','');
			$("#counti").html(0);
			$('#muliselect_div').css('display','');

		}
		else if(msg_format_type=='csv_xls_txt')
		{
			$("#msg_format_lbl").html('Upload File');
			$('#numbers').css('display','none');
			$('.csv_xls_txt').css('display','');
			$('#number_area').css('display','none');

			$('.groups').css('display','none');
			$('#add_group_btn').css('display','none');
			$('#msg-btn-mb-cnt').css('display','');
			$('#importBtn').css('margin-top','-4%');
			$('#muliselect_div').css('display','none');
			
			
		}
	})


	    $("#save_multimedia_btn").click(function(){

            $( "#addmultimediaForm" ).validate( {
            rules: {
                username_senderid: "required",
               
                file_name: "required",
                multimedia_file: "required",
            
            },
            messages: {
                username_senderid: "Please select Username",
               
                file_name: "Please enter your file name",
                multimedia_file: "Please select file",
               
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

        		 var file_data = $('#multimedia_file').prop('files')[0];
                 var senderid=$("#sid").val();
                 var template_id=$("#template").val();
                  var route_id=$("#route_id").val();
                var get_response='No';
                var sms_api='No';
                /* alert(get_response);*/

                  if($('#get_response').is(":checked")) 
                {
                    if(senderid=='' || template_id=='' || route_id=='')
                    {
                        alert('Please select Senderid, Route Id , Template Id!! ');
                        return false;
                    }

                      get_response='Yes';
                 }
                 else
                 {
                    get_response='No';
                 }

                if($('#sms_api').is(":checked")) 
                {
                    var client_api=$("#client_api").val();
                    if(client_api=='')
                    {
                        alert('Please enter an api !! ');
                        return false;
                    }
                    sms_api='Yes';

                }
                else
                {
                    sms_api='No';
                }

            if(file_data != undefined) {

            	 var form_data = new FormData();     
                 form_data.append('multimedia_file', file_data);

               /* var reseller_dropdown=$("#reseller_dropdown").val();*/
                var file_name=$("#file_name").val();
                var username_senderid=$("#username_senderid").val();
               
              
               /* form_data.append('reseller_dropdown',reseller_dropdown);*/
               // form_data.append('file_name',file_name);
                form_data.append('selected_userid',username_senderid);
              
				form_data.append('type','savemultimedia');
                form_data.append('senderid',senderid);
                form_data.append('template_id',template_id);
                form_data.append('route_id',route_id);
                form_data.append('get_response',get_response);
                form_data.append('sms_api',sms_api);
                form_data.append('client_api',client_api);
              }

                    var full_url = window.location.origin;
                    $.ajax({
                            url: full_url+'/controller/multimedia_controller.php',
                            type: 'post',
                            cache: false,
                            data:form_data,
		                    contentType: false,
                    		processData: false,
                            success: function(data){

                               /*console.log(data);*/
                               if(data==1)
                                {
                                    Swal.fire("Successful !",'File details added successfully','success').then((value) => {
                                     $("#create_multimedia_modal").modal('hide');

                                                 $("#addmultimediaForm").trigger('reset');
                                         window.location.reload(full_url+'/view/include/modal_forms/multimedia_modal.php');
                                                //load_template_list();
                                    });
                                        
                                }
                                else if(data==2)
                                {
                                    swal.fire({
                                                icon: 'error',
                                                title: 'Sorry...',
                                                text: 'File already exists!'            
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




	    $("#save_caller_id_btn").click(function(){

            $( "#addcalleridForm" ).validate( {
            rules: {
                callerid_username_senderid: "required",
               
                caller_id: "required"
               
            
            },
            messages: {
                callerid_username_senderid: "Please select Username",
               
                caller_id: "Please enter your file name"
               
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
                    $.ajax({
                            url: full_url+'/controller/multimedia_controller.php',
                            type: 'post',
                            cache: false,
                            data:$( "#addcalleridForm" ).serialize(),
                            success: function(data){

                              /* console.log(data);*/
                               if(data==1)
                                {
                                    Swal.fire("Successful !",'Caller ID details added successfully','success').then((value) => {
                                     $("#create_multimedia_modal").modal('hide');

                                                 $("#addcalleridForm").trigger('reset');
                                         window.location.reload(full_url+'/view/include/modal_forms/multimedia_modal.php');
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




});

$("#group_id").change(function(){

		var group_id=$("#group_id").val();
		//alert(group_id);
        var full_url = window.location.origin;
	
            $.ajax({
                url: full_url+'/controller/group_function.php',
                type: 'post',
                cache: false, 
                data:'type=fetch_group_contacts&group_id='+group_id,
                success: function(data){
                
                 // alert(data);

                  if(data!='1')
                  {
                  	var d = data.split('|');
					$('#numbers').val(d[0].trim());
					$('#counti').html(d[1]);
                  }
                  else{
                  	alert('Contact Number list empty in this group');
                  }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });	

	});


    function setSubmitBtnValue(value) {
        document.getElementById('submitBtnValue').value = value;
      }
      


function load_group_dropdown()
{
     var full_url = window.location.origin;
            $.ajax({
                url: full_url+'/controller/group_function.php',
                type: 'post',
                cache: false, 
                data:'list_type=dropdown',
                success: function(data){
                
                   if(data!=0)
                   {
                    $('#group_id').empty();
                   
                    $('#group_id').append(data);
                   }

                    //  $('#group_id').multiselect({

					//     columns: 1,
					//     placeholder: 'Select Group Name',
					//     search: true,
					//     selectAll: true
					// });

                    //  $('#muliselect_div').css('display','none');  
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}



function load_caller_id_dtls()
{
	var full_url = window.location.origin;


           $.ajax({
                url: full_url+'/controller/multimedia_controller.php',
                type: 'post',
                cache: false, 
                data:'type=all_caller_id',
                async:true,

                success: function(data){
                  //console.log(data);
                $('#callerid_tbl_body').empty();
                $('#callerid_tbl_body').append(data);
                $('#callerid_list_tbl').DataTable();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });

}

function load_caller_id_dropdown()
{
	var full_url = window.location.origin;


           $.ajax({
                url: full_url+'/controller/multimedia_controller.php',
                type: 'post',
                cache: false, 
                data:'type=caller_id_dropdown',
                async:true,

                success: function(data){
               
                $('#caller_id').empty();
                $('#caller_id').append(data);
               
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });

}


function load_voice_job_data()
{       

         var user_role=$("#user_role").val();
        
         // var selected_role="";
         // var uid="";
         // selected_role=$("#user_role_dropdown").val();
         // uid=$("#user_dropdown").val();

        var list_type="voice_call_summary_report"; 
        var full_url = window.location.origin;
        table= $('#voice_call_summary_tbl').DataTable({
            "processing": true,
            "serverSide": true,
            "cache":false,
            "ajax":{
                    "type":"POST",
                    "url":full_url+"/controller/multimedia_controller.php",
                    "data":function (post) {
                        post.type=list_type;
                        post.user_role=user_role;
                        /*post.user_role=user_role;
                        post.selected_role=selected_role;*/
                       /* post.uid=uid;*/
                        if(frmDate!="" && toDate!=""){
                          
                            post.frmDate = frmDate;
                            post.toDate = toDate;
                        }
                    }
                },
            "order": [[ 1, "desc" ]],
            "columnDefs": [
                        {"className": "dt-center", "targets": "_all"},
                        { 'visible': false, 'targets': [8] }
            ],
            "bDestroy": true
        });
}

function load_voice_job_dtl_data()
{

        var job_id=$("#job_id").text();

        var table_name=$("#table_name").text();
        var dtlstable=$("#dtlstable").text();
        var job_date=$("#job_date").text();
        var full_url = window.location.origin;
        /*alert(job_date);*/
        $.ajax({
        url: full_url+'/controller/multimedia_controller.php',
        type: 'post',
        cache: false,
        data:'type=send_voice_job_data&job_id='+job_id+"&table_name="+table_name+"&job_date="+job_date,
        dataType:'json',
        success: function(data){
            var res = JSON.parse(JSON.stringify(data));

            console.log(data);

            $("#sender_id").html(res[0]['caller_id']);
            $("#download").html("<a href='#'>download_send_job_"+job_id+"</a>");
            if(res[0]['campaign_name']!='')
            {
                $("#campaign_name").html(res[0]['campaign_name']);
            }
            else
            {
                $("#campaign_name").html('NA');
            }

            


            if(res[0]['auto_response']!='' || res[0]['auto_response']!=null )
            {
                $("#auto_response").html(res[0]['auto_response']);
            }
            else
            {
                $("#auto_response").html('No');
            }
            $("#call_method").html(res[0]['call_method']);


            //var msg=decodeURI(res[0]['message']);
            $("#text").html(res[1]['msg']);
            $("#ip_address").html(res[0]['ip_address']);
            var text_type="";
            if(res[0]['unicode_type']==0)
            {
                text_type="Text";
            }
            else
            {
                text_type="Unicode";
            }
            $("#text_type").html(text_type);
            $("#timestamp").html(res[0]['sent_at']);
            $("#method").html(res[0]['method']);
            $("#gvsms").html(res[0]['vsms']);

            
            var sub=0,deli=0,rej=0,fail=0,null_stat=0;
            var send_job_dtls="";
            var charset="";
            var total_bill=0;
            var dlr_status="";
            var status_credit=0;
            var status_data="";
            var credit_count=0;
            var chart_data="";
            var chart_status="";
            var series1 = [];
            for(var i=1;i<res.length;i++)
            {
                total_bill+=parseInt(res[i]['sum_msgcredit']);
                //console.log(total_bill);
                dlr_status=res[i]['status'];
                status_credit=parseInt(res[i]['sum_msgcredit']);
                credit_count=parseInt(res[i]['msgcredit']);
                status_data+="<tr><td>"+dlr_status+"</td><td>"+status_credit+"</td></tr>";
                if(i==(res.length-1))
                {
                    chart_data+="{name:'"+dlr_status+"',y:"+status_credit+"},";
                    chart_status="['"+dlr_status+"',"+parseInt(10)+"]";
                }
                else
                {
                    chart_data+="{name:'"+dlr_status+"',y:"+status_credit+"},";
                    chart_status="['"+dlr_status+"',"+parseInt(10)+"]";

                }

                    
                series1.push({
                    name: dlr_status,
                    y:status_credit
                });
                

                /*if(res[i]['unicode_type']==0)
                {
                    charset="Text";
                }
                else
                {
                    charset="Unicode";
                }*/


            }
            //console.log(series1);
            $("#msg_status").append(status_data);
            $("#total_bill").html(total_bill);
            
Highcharts.chart('container', {
  chart: {
    type: 'pie',
    options3d: {
      enabled: true,
      alpha: 45,
      beta: 0
    }
  },
  title: {
    text: 'Job Status'
  },
  accessibility: {
    point: {
      valueSuffix: '%'
    }
  },
  tooltip: {
    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      depth: 35,
      dataLabels: {
        enabled: true,
        format: '{point.name}'
      }
    }
  },
  series: [{
    type: 'pie',
    name: 'Job Status',
    data: 
        series1
    }]
});


            /*$("#msg_credit").html(res[0]['msgcredit']);
            $("#msg_status").html(res[0]['msgcredit']);*/
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
              console.log(errorMsg);
            
        }
    });


        var list_type="send_voice_job_table_dtls"; 
        var full_url = window.location.origin;
        table= $('#send_job_details_tbl').DataTable({
            "processing": true,
            "serverSide": true,

            "ajax":{
                    "type":"POST",
                    "url":full_url+"/controller/multimedia_controller.php",
                    "data":function (post) {
                        post.type=list_type;
                        post.job_id=job_id;
                        post.job_date=job_date;
                        if(frmDate!="" && toDate!=""){
                            post.frmDate = frmDate;
                            post.toDate = toDate;
                        }
                    }
                },
          /*    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, 75]],*/
          /*    "dom": 'Blfrtip',*/
            "buttons":[{
                    extend: 'collection',
                    className: 'exportButton btn btn-primary',
                    text: 'Data Export',
                    titleAttr: 'Send Job Report',
                    buttons: [{ extend: 'csv', className: 'btn btn-primary',title:'Send Job Report',exportOptions: { modifier: { page: 'all', search: false } } },
                        { extend: 'excel', className: 'btn btn-primary',title:'Send Job Report' },
                        { extend: 'pdf', className: 'btn btn-primary',title:'Send Job Report' },
                        { extend: 'print', className: 'btn btn-primary',title:'Send Job Report' },],
                
                }],
            stateSave: false,
            "order": [[ 0, "desc" ]],
            "columnDefs": [
                        {"className": "dt-center", "targets": "_all"},
                        { /*'visible': false, 'targets': [3]*/}
            ]
        });



}
function load_multimedia_dtls()
{
	var full_url = window.location.origin;


           $.ajax({
                url: full_url+'/controller/multimedia_controller.php',
                type: 'post',
                cache: false, 
                data:'type=all_multimedia',
                async:true,

                success: function(data){
                /*  console.log(data)*/
                $('#tbl_body').empty();
                $('#tbl_body').append(data);
                $('#mulitmedia_list_tbl').DataTable();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });


	/*$('#mulitmedia_list_tbl').DataTable( {
        "processing": true,
        "serverSide": true,
        "responsive": true,
         "ajax": {
                    "type":"POST",
                    "cache":false,
                    "url":full_url+"/controller/multimedia_controller.php",
                    "data":function (post) {
                            post.type='all_multimedia';
      
                        }
                  
         },
         "order": [[ 2, "desc" ]],
         "columnDefs": [
                        {"className": "dt-center", "targets": "_all"},
                        { 'targets': 0, 'visible': false }
            ]

        } );*/

function load_edit_route_id(userid,route_id)
{
    
    var full_url = window.location.origin;
    var selected_user=userid;
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
                    $('#edit_route_id').empty();
                    $('#edit_route_id').html(data);
                     $(`#edit_route_id option[value='${route_id}']`).prop('selected', true);
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
}


function load_edit_sender_id(userid,sender_id)
{
    
    var full_url = window.location.origin;
   
    var selected_user=userid;
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
                    $('#edit_sid').empty();
                    $('#edit_sid').html(data);
                    $(`#edit_sid option[value='${sender_id}']`).prop('selected', true);
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
}

$(document).on( "click", '.edit_admin_mulitmedia_btn',function(e) {
    // $(".auto_response").css('display','none');
    $(".edit_response").css('display','none');
    var id = $(this).data('id');
    var original_filename = $(this).data('original_filename');
    var status = $(this).data('status');
     var voice_id = $(this).data('voice_id');
      var ivr_id = $(this).data('ivr_id');
      var ivr_id2 = $(this).data('ivr_id2');
      var userid = $(this).data('userid');
      var sender_id = $(this).data('sender_id');
      var template_id = $(this).data('template_id');
      var template_name = $(this).data('template_name');
      var route_id = $(this).data('route_id');
      var sms_api = $(this).data('sms_api');
      var client_api = $(this).data('client_api');
      var temp_val="<option value='"+template_id+"'>"+template_name+"</option>";
      $("#edit_userid").val(userid);


      var get_response = $(this).data('get_response');

      if(get_response=='Yes')
      {
        $("#edit_get_response").prop('checked','checked');
        $(".edit_response").css('display','');
        $("#edit_template").empty();
        $("#edit_template").append(temp_val);
        load_edit_sender_id(userid,sender_id);
        load_edit_route_id(userid,route_id);


        $("#edit_sms_api").prop('checked','');
        $(".edit_sms_api").css('display','none');
        $("#edit_client_api").empty();
        
      }
      

      if(sms_api=='Yes')
      {
        $("#edit_sms_api").prop('checked','checked');
        $(".edit_sms_api").css('display','');
        $("#edit_client_api").empty();
        $("#edit_client_api").append(client_api);

        $("#edit_get_response").prop('checked','');
        $(".edit_response").css('display','none');
        $("#edit_template").empty();
      }
      
  if(ivr_id=='')
  {
    ivr_id=0;
  }
  
    $("#admin_file_id").val(id);
    $("#admin_edit_file_name").val(original_filename);
    $("#admin_edit_voice_id").val(voice_id);
    $("#admin_edit_ivr_id").val(ivr_id);
    $("#admin_edit_ivr_id2").val(ivr_id2);
    /*$("#admin_edit_source_type").val($(this).data('source_type'));
    $("#admin_edit_campaign_type").val($(this).data('campaign_type'));
    $("#admin_edit_file_type").val($(this).data('filetype'));
    $("#admin_edit_ukey").val($(this).data('ukey'));
    $("#admin_edit_service_no").val($(this).data('service_no'));

    $("#admin_edit_ivrtemplateid").val($(this).data('ivrtempid'));

	$("#admin_edit_retryattempt").val($(this).data('retryatmpt'));
	$("#admin_edit_retryduration").val($(this).data('retryduration'));*/

	 $(`#admin_edit_status option[value='${status}']`).prop('selected', true);


   
});

$(document).on( "click", '.edit_caller_id_btn',function(e) {
  
    var id = $(this).data('id');
    var caller_id = $(this).data('caller_id');
    var status = $(this).data('status');
  
    $("#caller_dtl_id").val(id);
    $("#edit_caller_id").val(caller_id);
  

	 $(`#edit_callerid_status option[value='${status}']`).prop('selected', true);


   
});


$("#update_multimedia").click(function(){
	 var full_url = window.location.origin;
				        $( "#updatemultimediaForm" ).validate( {
		            rules: {
		            	
		                company_name: "required",
		                tag_line: "required",
		                web_url: "required",
		                
		                support_url: "required",
		                support_mobile: "required",
		                support_email: "required",
		                login_desc: "required",
		               


		            },
		            messages: {
		          
		                company_name: "Please select Route",
		                tag_line: "Please select sender is",
		                web_url: "Please select template",
		                
		                support_url: "Please enter message",
		                support_mobile: "Please enter message",
		                support_email: "Please enter message",
		                login_desc: "Please enter message"
		             
		                
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
						  text: "You want to update this branding details!",
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

		        var file_data = $('#uploadfile_edit').prop('files')[0];
 				var form_data = new FormData();
            		if(file_data != undefined) {
              
                 		form_data.append('company_logo', file_data);
                 	}
               /* var reseller_dropdown=$("#reseller_dropdown").val();*/
                var company_name=$("#company_name_edit").val();
                 var brand_id=$("#brand_id").val();
                var tag_line=$("#tag_line_edit").val();
                var web_url=$("#web_url_edit").val();
                var support_url=$("#support_url_edit").val();
                var support_mobile=$("#support_mobile_edit").val();
                var support_email=$("#support_email_edit").val();
                var login_desc=$("#login_desc_edit").val();

              
               /* form_data.append('reseller_dropdown',reseller_dropdown);*/
                form_data.append('company_name',company_name);
                form_data.append('brand_id',brand_id);
                form_data.append('tag_line',tag_line);
                form_data.append('web_url',web_url);
                form_data.append('support_url',support_url);
                form_data.append('support_mobile',support_mobile);
                form_data.append('support_email',support_email);
                form_data.append('login_desc',login_desc);

 				form_data.append('list_type','edit_branding');

 					$.ajax({
		                    url: full_url+'/controller/branding.php',
		                    type: 'POST',
		                    data:form_data,
		                    cache: false, 
		                     contentType: false,
                    		processData: false,
		                     beforeSend: function(){
		                     /*$("#loading_modal").modal('show');*/
		                   },
		                   complete: function(){
		                    /*$("#loading_modal").modal('hide');*/
		                   },
		                    success: function(data){
		                  	//alert(data);
		                       if(data==1)
		                       {
		                            swal.fire('Success','Branding details updated successfully','success').then((value) => {
		                            /*	load_branding_dtls();*/
		                              /*window.location.reload();*/
		                              $("#editbrandingForm").trigger('reset');
		                              $('#editbrandingModel').modal('hide');
                                
                                window.location.reload(full_url+'/dashboard.php?page=branding');
		                            });
		                       }
		                       else
		                       {
		                            swal.fire({
		                              icon: 'error',
		                              title: 'Oops...',
		                              text: data,
		                              footer: ''
		                            })
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

						}

		        });
		    });



$("#update_caller_id").click(function(){
	 var full_url = window.location.origin;
				        $( "#updatecalleridForm" ).validate( {
		            rules: {
		            	
		                edit_caller_id: "required",
		                edit_callerid_status: "required"
		            
		            },
		            messages: {
		          
		                edit_caller_id: "Please select Route",
		                edit_callerid_status: "Please select sender is"
		                
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
						  text: "You want to update this Caller ID details!",
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

 					$.ajax({
		                    url: full_url+'/controller/multimedia_controller.php',
		                    type: 'POST',
		                    data:$("#updatecalleridForm").serialize(),
		                    cache: false, 
		                     
		                     beforeSend: function(){
		                     /*$("#loading_modal").modal('show');*/
		                   },
		                   complete: function(){
		                    /*$("#loading_modal").modal('hide');*/
		                   },
		                    success: function(data){
		                  /*	alert(data);*/
		                       if(data==1)
		                       {
		                            swal.fire('Success','Caller ID details updated successfully','success').then((value) => {
		                            /*	load_branding_dtls();*/
		                              /*window.location.reload();*/
		                              $("#updatecalleridForm").trigger('reset');
		                              $('#edit_caller_id_modal').modal('hide');
                                
                                window.location.reload(full_url+'/dashboard.php?page=caller_id');
		                            });
		                       }
		                       else
		                       {
		                            swal.fire({
		                              icon: 'error',
		                              title: 'Oops...',
		                              text: data,
		                              footer: ''
		                            })
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

						}

		        });
		    });



            $("#schedule_later_btn").click(function(){
                $("#schedule_later_form").modal('show');
              })
              
              function setSubmitBtnValue(value) {
                document.getElementById('submitBtnValue').value = value;
              }



/*delete schedule*/


    


$("#admin_update_multimedia").click(function(){
	 var full_url = window.location.origin;
				        $( "#updateadminmultimediaForm" ).validate( {
		            rules: {
		            	
		                admin_edit_file_name: "required",
		              
		            },
		            messages: {
		          
		                admin_edit_file_name: "Please select Route",
		               
		                
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
						  text: "You want to update this Multimedia details!",
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

		        var file_data = $('#admin_edit_file').prop('files')[0];
 				var form_data = new FormData();
            		if(file_data != undefined) {
              
                 		form_data.append('multimedia_file', file_data);
                 	}
               /* var reseller_dropdown=$("#reseller_dropdown").val();*/

               


                var admin_edit_file_name=$("#admin_edit_file_name").val();
                var admin_file_id=$("#admin_file_id").val();
                var status=$("#admin_edit_status").val();

                var voice_id=$("#admin_edit_voice_id").val();
                var ivr_id=$("#admin_edit_ivr_id").val();
                var ivr_id2=$("#admin_edit_ivr_id2").val();

                var senderid=$("#edit_sid").val();
                var template_id=$("#edit_template").val();
                var route_id=$("#edit_route_id").val();
                var sms_api=$("#edit_sms_api").val();
                var client_api=$("#edit_client_api").val();
                var get_response="";


                if($('#edit_get_response').is(":checked")) 
                {
                    if(senderid=='' || template_id=='' || route_id=='')
                    {
                        alert('Please select Senderid, Route Id , Template Id!! ');
                        return false;
                    }

                      get_response='Yes';
                 }
                 else
                 {
                    get_response='No';
                 }


                  if($('#edit_sms_api').is(":checked")) 
                  {
                    if(client_api=='')
                    {
                        alert('Please Enter an API!! ');
                        return false;
                    }

                      sms_api='Yes';
                 }
                 else
                 {
                    sms_api='No';
                 }


              
               /* form_data.append('reseller_dropdown',reseller_dropdown);*/
                form_data.append('admin_file_id',admin_file_id);
                form_data.append('admin_edit_file_name',admin_edit_file_name);
               
                form_data.append('status',status);
                form_data.append('voice_id',voice_id);
                form_data.append('ivr_id',ivr_id);
                form_data.append('ivr_id2',ivr_id2);
                form_data.append('type','admin_update');
                 form_data.append('senderid',senderid);
                form_data.append('template_id',template_id);
                form_data.append('route_id',route_id);
                form_data.append('get_response',get_response);
                form_data.append('sms_api',sms_api);
                form_data.append('client_api',client_api);

 				
 					$.ajax({
		                    url: full_url+'/controller/multimedia_controller.php',
		                    type: 'POST',
		                    data:form_data,
		                    cache: false, 
		                     contentType: false,
                    		processData: false,
		                     beforeSend: function(){
		                     /*$("#loading_modal").modal('show');*/
		                   },
		                   complete: function(){
		                    /*$("#loading_modal").modal('hide');*/
		                   },
		                    success: function(data){
		                  	// alert(data);
		                       if(data==1)
		                       {
		                            swal.fire('Success','Multimedia details updated successfully','success').then((value) => {
		                            /*	load_branding_dtls();*/
		                              /*window.location.reload();*/
		                              $("#updateadminmultimediaForm").trigger('reset');
		                              $('#edit_admin_multimedia_modal').modal('hide');
                                
                                window.location.reload(full_url+'/dashboard.php?page=multimedia');
		                            });
		                       }
		                       else
		                       {
		                            swal.fire({
		                              icon: 'error',
		                              title: 'Oops...',
		                              text: data,
		                              footer: ''
		                            })
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

						}

		        });
		    });

        $(document).on( "click", '.delete_multimedia_btn',function(e) {
  
    var id = $(this).data('id');
     var file_name = $(this).data('filename');

   
           swal.fire({
  title: 'Are you sure?',
  text: "You want to delete this Multimedia Details!",
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
        var full_url = window.location.origin;

                            $.ajax({
                                        url: full_url+'/controller/multimedia_controller.php',
                                        type: 'post',
                                        cache: false, 
                                        data:'type=delete_file&file_id='+id+'&filename='+file_name,
                                        success: function(data){
                                           
                                           if(data==1)
                                           {
                                                swal.fire('Success','Multimedia Details Deleted Successfully!!','success').then((value) => {

                                                 window.location.reload(full_url+'/dashboard.php?page=multimedia');
                                                    });
                                           }
                                           else
                                           {
                                                swal.fire({
                                                  icon: 'error',
                                                  title: 'Oops...',
                                                  text: 'Failed to delete Multimedia details!'
                                                  
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




}

        $(document).on( "click", '.delete_caller_id_btn',function(e) {
  
    var id = $(this).data('id');
    
           swal.fire({
  title: 'Are you sure?',
  text: "You want to delete this Caller ID Details!",
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
        var full_url = window.location.origin;

                            $.ajax({
                                        url: full_url+'/controller/multimedia_controller.php',
                                        type: 'post',
                                        cache: false, 
                                        data:'type=delete_caller_id&caller_dtls_id='+id,
                                        success: function(data){
                                           
                                           if(data==1)
                                           {
                                                swal.fire('Success','Caller ID Details Deleted Successfully!!','success').then((value) => {

                                                 window.location.reload(full_url+'/dashboard.php?page=caller_id');
                                                    });
                                           }
                                           else
                                           {
                                                swal.fire({
                                                  icon: 'error',
                                                  title: 'Oops...',
                                                  text: 'Failed to delete Caller ID details!'
                                                  
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

function load_username_dropdown()
{
        var full_url = window.location.origin;
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
                //    $("#username_senderid_chosen").css('width','100%');

                    $('#callerid_username_senderid').empty();
                    $('#callerid_username_senderid').html(data);

                //    $("#callerid_username_senderid").chosen(); 
                //    $("#callerid_username_senderid_chosen").css('width','100%');


                 

                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
}



	function isNumberKeyOrFloat(evt){
	if(!evt)
        evt = window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode!=97 && charCode!=99 && charCode!=44 && charCode!=8 && charCode!=118 && charCode!=46 &&(charCode < 36 || charCode > 40)) {
         return false
     }
     return true
	}

	function countNo(val,response)
	{
		var value = document.getElementById(val).value;
		var c=0;
		value=value.split('\n');
		for(i=0;i<=value.length;i++)
		{
			if(value[i] && value[i].trim()!="")
			{
			c++;
			}
		}
		document.getElementById(response).innerHTML= c;
	}

    

function load_voice_file_dropdown()
{
        var full_url = window.location.origin;
            $.ajax({
                url: full_url+'/controller/multimedia_controller.php',
                type: 'post',
                cache: false,
                data:'type=dropdown_voice',
                success: function(data){
                
                   if(data!=0)
                   {
                    $('#voice_file').empty();
                    $('#voice_file').html(data);

                  
                   

                 

                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
}

function searchData_report() {
    /*alert('sdf');*/
    frmDate = ($("#frmDate").val()) ? $("#frmDate").val() : '';
   
    toDate = ($("#toDate").val()) ? $("#toDate").val() : '';
    table.draw();
}