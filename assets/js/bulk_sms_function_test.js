$(document).ready(function(){



	         
    load_route_dropdown();
    load_sender_id_dropdown();
    load_sender_id();
    load_group_dropdown();
    
    
    /*load_template_dropdown();*/
    
    
    
     var full_url = window.location.origin+"/itswe_sms_app";
       $.ajax({
                        url: full_url+'/controller/bulk_sms_function.php',
                        type: 'post',
                        cache: false, 
                        data:"act=load_gvsms_btn",
                        success: function(data){
                        //console.log(data);
                         if(data!=0)
                         {
    
                            if(data=="Yes")
                            {
                                $("#vsms").prop('disabled','');
                            }
                            else if(data=="No")
                            {
                                $("#vsms").prop('disabled','disabled');
                            }
                         }
                            
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                            alert(errorMsg);
                            //$('#content').html(errorMsg);
                          }
                    });
    
    
    /*$("#chk_track").change(function() {
        valueChanged();
    })*/
    
        $("#az_routeid").change(function(){
            var route_name=$('#az_routeid option:selected').text();
            if(route_name=='RCS')
            {
     
             var full_url = window.location.origin+"/itswe_sms_app";
       $.ajax({
                        url: full_url+'/controller/bulk_sms_function.php',
                        type: 'post',
                        cache: false, 
                        data:"act=load_rcs_page",
                        success: function(data){
                       
                         if(data!=0)
                         {
    
                            if(data=="Yes")
                            {
                                 window.location.href="dashboard.php?page=rcs";
                            }
                           
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
    
    
    
    
        $("#sid").change(function(){
            var sid=$('#sid option:selected').val();
            if(sid!='')
            {
     
             var full_url = window.location.origin+"/itswe_sms_app";
       $.ajax({
                        url: full_url+'/controller/bulk_sms_function.php',
                        type: 'post',
                        cache: false, 
                        data:"act=load_template_with_sid&sid="+sid,
                        success: function(data){
                     // console.log(data);
                         if(data!=0)
                         {
    
                           $('#template').empty();
                           $('#template').html(data);
                           // $("#template").chosen(); 
                           //  $("#template").trigger('chosen:updated');
    
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
    
    
    
              /* $('#sender_id').multiselect({
        columns: 1,
        placeholder: 'Select Sender Id',
        search: true,
        selectAll: true
    });
    */
       $('.add-variable').on('click', function(){
                var txtData  = $("#add_mbl1");
                var caretPos = txtData[0].selectionStart;
                var tempmsg = document.getElementById("add_mbl1").value;
                var v = tempmsg.substring(0, caretPos) + '{#var#}' + tempmsg.substring(caretPos);
                $('#add_mbl1').val(v);
            });
    
        $("#vsms").change(function(event){
            if($('#vsms').is(':checked')) { 
                
        }
        else
            {
                //alert('unchecked');
            }
        });
    
    $("#send_sms").click(function(){
    
        
        var btn_val=$(this).val();
        setSubmitBtnValue(btn_val);
        
        var schedule_date = $("#datepicker").val();
    
        // if(schedule_date!='')
        // {
        //     $("#is_schedule").val('1');
        // }
    
        if($('#chk_track').is(":checked")){ 
            var original_url = $("#original_url").val();
            if(original_url=='')
            {
                 swal.fire({
                                  icon: 'error',
                                  title: 'Oops...',
                                  text: 'When the tracking url button is enabled, the field original url should not be blank.',
                                  footer: ''
                                })
    
                 return false;
            }
        }
    
    
    
            $( "#sendSMSForm" ).validate( {
                rules: {
                    az_routeid: "required",
                    sid: "required",
                    // template: "required",
                    numbers: "required",
                    mbl1: "required",
                   
    
    
                },
                messages: {
                    az_routeid: "Please select Route",
                    sid: "Please select sender is",
                    // template: "Please select template",
                    numbers: "Please Enter Mobile Number",
                    mbl1: "Please enter message"
                    
                    
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
                text: "You want to send this message!",
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
                        url: full_url+'/controller/sending_test.php',
                        type: 'post',
                        cache: false, 
                        data:$("#sendSMSForm").serialize()+"&btn_send=send_sms",
                         beforeSend: function(){
                         $("#loading_modal").modal('show');
                       },
                       complete: function(){
                        $("#loading_modal").modal('hide');
                       },
                        success: function(data){
                           // alert(data);
                           /* console.log(data);
                            swal.fire('',data,'success').then((value) => {
                    
                                });*/
                            console.log(data);
    
                            var msg=data.split("|");
                           if(msg[0].trim()=='Message Successfully Send' || msg[0].trim()=='Message Successfully Scheduled')
                           {
                            
                           // window.location.reload();
                                if(msg[1]!='0'||msg[1]!=0)
                                {
                                    //alert('wrong');
                                    swal.fire('',msg[0]+"<br/>"+msg[1],'success').then((value) => {
                                       // console.log('reload_test');
                                      window.location.reload();
                                      $("#sendSMSForm").trigger('reset');
                                    });
                                }
                                else
                                {
                                    swal.fire('',msg[0],'success').then((value) => {
                                      window.location.reload();
                                      $("#sendSMSForm").trigger('reset');
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
    
                           /* swal(data, "", "success").then((value) => {
                            location.reload();
                                });*/
                            //swal("Click on either the button or outside the modal.")
    
                           // location.reload();
                         
                            
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                            alert(errorMsg);
                            //$('#content').html(errorMsg);
                          }
                    });
               
    
                     }
                })
            
            }
    
            } );
    });
    
    
    
    ///schedule for later
    
    $("#schedule_now_btn").click(function(){
    
        
        var btn_val=$(this).val();
        setSubmitBtnValue(btn_val);
        
        var schedule_date = $("#datepicker").val();
    
        if(schedule_date!='')
        {
            $("#is_schedule").val('1');
        }
    
        if($('#chk_track').is(":checked")){ 
            var original_url = $("#original_url").val();
            if(original_url=='')
            {
                 swal.fire({
                                  icon: 'error',
                                  title: 'Oops...',
                                  text: 'When the tracking url button is enabled, the field original url should not be blank.',
                                  footer: ''
                                })
    
                 return false;
            }
        }
    
    
    
            $( "#sendSMSForm" ).validate( {
                rules: {
                    az_routeid: "required",
                    sid: "required",
                    // template: "required",
                    numbers: "required",
                    mbl1: "required",
                   
    
    
                },
                messages: {
                    az_routeid: "Please select Route",
                    sid: "Please select sender is",
                    // template: "Please select template",
                    numbers: "Please Enter Mobile Number",
                    mbl1: "Please enter message"
                    
                    
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
                text: "You want to send this message!",
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
                        url: full_url+'/controller/sending_test.php',
                        type: 'post',
                        cache: false, 
                        data:$("#sendSMSForm").serialize()+"&btn_send=send_sms",
                         beforeSend: function(){
                         $("#loading_modal").modal('show');
                       },
                       complete: function(){
                        $("#loading_modal").modal('hide');
                       },
                        success: function(data){
                           
    
                            data=data.trim();
                           // alert(data);
                           /* console.log(data);
                            swal.fire('',data,'success').then((value) => {
                    
                                });*/
                            console.log(data);
    
                            var msg=data.split("|");
                           if(msg[0].trim()=='Message Successfully Send' || msg[0].trim()=='Message Successfully Scheduled')
                           {
    
                            console.log(msg);
                            $("#schedule_later_form").modal('hide');
                          //  window.location.reload();
                                if(msg[1]!='0'||msg[1]!=0)
                                {
                                    //alert('wrong');
                                    swal.fire('',msg[0]+"<br/>"+msg[1],'success').then((value) => {
                                       // console.log('reload_test');
                                    //   window.location.reload();
                                    $("#sendSMSForm").trigger('reset');
                                    window.location.href=full_url+"/dashboard.php?page=scheduled_report";
                                     
                                    });
                                }
                                else
                                {
                                    swal.fire('',msg[0],'success').then((value) => {
                                    //   window.location.reload();
                                   
                                      $("#sendSMSForm").trigger('reset');
                                      window.location.href=full_url+"/dashboard.php?page=scheduled_report";
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
    
                           /* swal(data, "", "success").then((value) => {
                            location.reload();
                                });*/
                            //swal("Click on either the button or outside the modal.")
    
                           // location.reload();
                         
                            
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                            alert(errorMsg);
                            //$('#content').html(errorMsg);
                          }
                    });
               
    
                     }
                })
            
            }
    
            } );
    });
    
    
    
    $("#send_test_msg").click(function(){
    
        var btn_val=$(this).val();
        setSubmitBtnValue(btn_val);
    
        
        var schedule_date = $("#datepicker").val();
    
        if(schedule_date!='')
        {
            $("#is_schedule").val('1');
        }
    
        if($('#chk_track').is(":checked")){ 
            var original_url = $("#original_url").val();
            if(original_url=='')
            {
                 swal.fire({
                                  icon: 'error',
                                  title: 'Oops...',
                                  text: 'When the tracking url button is enabled, the field original url should not be blank.',
                                  footer: ''
                                })
    
                 return false;
            }
        }
    
    
        var test_numbers=$("#test_numbers").val();
    
        if(test_numbers=='')
        {
            swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please enter test number',
                footer: ''
              })
        }
    
    
            $( "#sendSMSForm" ).validate( {
                rules: {
                    az_routeid: "required",
                    sid: "required",
                    template: "required",
                    // test_numbers: "required",
                    
                   
    
    
                },
                messages: {
                    az_routeid: "Please select Route",
                    sid: "Please select sender is",
                    template: "Please select template",
                   // test_numbers: "Please Enter Mobile Number",
                   
                    
                    
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
                text: "You want to send this message!",
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
                    //console.log($("#sendSMSForm").serialize());
    
                  
                $.ajax({
                        url: full_url+'/controller/sending_test.php',
                        type: 'post',
                        cache: false, 
                        data:$("#sendSMSForm").serialize()+"&test_btn_send=test_numbers",
                         beforeSend: function(){
                         $("#loading_modal").modal('show');
                       },
                       complete: function(){
                        $("#loading_modal").modal('hide');
                       },
                        success: function(data){
                           // alert(data);
                           /* console.log(data);
                            swal.fire('',data,'success').then((value) => {
                    
                                });*/
                            console.log(data);
    
                            var msg=data.split("|");
                           if(msg[0].trim()=='Message Successfully Send' || msg[0].trim()=='Message Successfully Scheduled')
                           {
                            $("#test_numbers").val("");
    
                                if(msg[1]!='0'||msg[1]!=0)
                                {
                                    //alert('wrong');
                                    swal.fire('',msg[0]+"<br/>"+msg[1],'success').then((value) => {
                                        $("#test_numbers").val("");
                                      //window.location.reload();
                                     // $("#sendSMSForm").trigger('reset');
                                    });
                                }
                                else
                                {
                                    $("#test_numbers").val();
                                    swal.fire('',msg[0],'success').then((value) => {
                                        $("#test_numbers").val("");
                                      //window.location.reload();
                                     // $("#sendSMSForm").trigger('reset');
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
                            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                            alert(errorMsg);
                            //$('#content').html(errorMsg);
                          }
                    });
               
    
                     }
                })
            
            }
    
            });
    });
    
    
    function setSubmitBtnValue(value) {
        document.getElementById('submitBtnValue').value = value;
    }
    
    
    $("#create_template_modal_btn").click(function(){
        load_sender_id();
        $("#create_template_modal").modal('show');
    
    });
    
    $("#schedule_sms").click(function(){
    
    
        $("#is_schedule").val('1');
        if($('#chk_track').is(":checked")){ 
            var original_url = $("#original_url").val();
            if(original_url=='')
            {
                 swal.fire({
                                  icon: 'error',
                                  title: 'Oops...',
                                  text: 'When the tracking url button is enabled, the field original url should not be blank.',
                                  footer: ''
                                })
    
                 return false;
            }
        }
    
        
            $( "#sendSMSForm" ).validate( {
                rules: {
                    az_routeid: "required",
                    sid: "required",
                    template: "required",
                    numbers: "required",
                    mbl1: "required",
                    scheduleDateTime:"required",
                   
                   
    
    
                },
                messages: {
                    az_routeid: "Please select Route",
                    sid: "Please select Route",
                    template: "Please select Route",
                    numbers: "Please select Route",
                    mbl1: "Please select Route",
                    scheduleDateTime:"Please select Date",
                    
                    
                    
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
      text: "You want to schedule this message!",
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
    }).then((result1) => {
      if (result1.isConfirmed) {
         var full_url = window.location.origin+"/itswe_sms_app";
        
       $.ajax({
                        url: full_url+'/controller/sending_test.php',
                        type: 'post',
                        cache: false, 
                        data:$("#sendSMSForm").serialize()+"&btn_send=schedule_sms",
                         beforeSend: function(){
                         $("#loading_modal").modal('show');
                       },
                       complete: function(){
                        $("#loading_modal").modal('hide');
                       },
                        success: function(data){
    
                            var msg=data.split("|");
                           if(msg[0].trim()=='Message Successfully Scheduled')
                           {
    
                            if(msg[1]!='0'||msg[1]!=0)
                                {
                                    //alert('wrong');
                                    swal.fire('',msg[0]+"<br/>"+msg[1],'success').then((value) => {
                                      window.location.reload();
                                      $("#sendSMSForm").trigger('reset');
                                    });
                                }
                                else
                                {
                                    swal.fire('',msg[0],'success').then((value) => {
                                      window.location.reload();
                                      $("#sendSMSForm").trigger('reset');
                                    });
                                }
    
                                
                               /* swal.fire('',msg[0]+"<br/>"+msg[1],'success').then((value) => {
                            window.location.reload();
                              $("#sendSMSForm").trigger('reset');
                                });*/
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
                            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                            alert(xhr);
                            //$('#content').html(errorMsg);
                          }
                    });
               
    
      }
    })
            
            }
    
            } );
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
    
    
        /*$("#add_sender_btn").click(function(){
            window.location.href='dashboard.php?page=senderid';
        })
    
        $("#add_group_btn").click(function(){
            window.location.href='dashboard.php?page=group';
        })
    
        $("#add_template_btn").click(function(){
            window.location.href='dashboard.php?page=template';
        })
    */
    
        $("#group_id").change(function(){
    
            var group_id=$("#group_id").val();
            //alert(group_id);
            var full_url = window.location.origin+"/itswe_sms_app";
        
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
    
        
    
    
        $("#template").change(function(){
    
            var template_id=$("#template").val();
             var full_url = window.location.origin+"/itswe_sms_app";
            //alert(group_id);
           
    
        
                $.ajax({
                    url: full_url+'/controller/template_function.php',
                    type: 'post',
                    data:'type=get_msg_data&temp_id='+template_id,
                    dataType:'json',
                    cache:false,
                    success: function(data){
    
                        
                    var res = JSON.parse(JSON.stringify(data));
                     // console.log(res);
    
                    var template_id=res['template_id'];
                    $("#dlt_template").val(template_id);
                    $("#dlt_template").prop('readonly','readonly');
    
    
                      if(res['msg_data']!='')
                      {
                        var char_type=res['char_type'];
                        if(char_type=='Unicode')
                        {
                            $('input:radio[name="char_set"][value="Unicode"]').prop('checked',true);
                            $('input:radio[name="char_set"][value="Text"]').prop('checked',false);
                           // $("#success-outlined").attr('checked','checked');
                        }
                        else
                        {
                             $('input:radio[name="char_set"][value="Unicode"]').prop('checked',false);
                             $('input:radio[name="char_set"][value="Text"]').prop('checked',true);
                        }
                        $("#mbl1").val(res['msg_data']);
                        checkChar();
                      }
                      else{
                        alert('Message Content Not available');
                      }
    
                     /* if(data!='')
                      {
                          $("#mbl1").val(data);
                          checkChar();
                      }
                      else{
                          alert('Message Content Not available');
                      }*/
                        
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(data);
                        //$('#content').html(errorMsg);
                      }
                });	
    
        })
    
    });
    
    
    
    function addTemplate() {
           
            if ($('#template_name').val().trim() == '') {
                 
            action_message1('Please enter template name', 'error');
            return false;
        }
    
        if ($('#PE_ID1').val().trim() == '') {
             
            action_message1('Please enter Principle Entity Id', 'error');
            return false;
        }
        if ($('#Template_ID').val().trim() == '') {
             
            action_message1('Please enter Template Id', 'error');
            return false;
        }
        
        if ($('#content_type').val() == '') {
           
            action_message1('Please select Content Type', 'error');
            return false;
        }
        
        if ($('#category_type').val().trim() == '') {
            
            action_message1('Please select Category Type', 'error');
            return false;
        }
    /*
        if (parseInt($('input[name="chkSnd[]"]:checked').length) == 0) {
            action_message('Please select At Least One SenderId', 'error');
            return false;
        }*/
    
        if ($('#template_data').val().trim() == '') {
            
            action_message1('Please enter template data', 'error');
            return false;
        }
       
        var full_url = window.location.origin+"/itswe_sms_app";
        $.ajax({
            type: "POST",
            url: full_url+"/controller/template_function.php",
            data: $('#templateForm').serialize(),
            beforeSend: function () {
               // $('.addTemplateLoader').html('<img src="system-icon/i32x32/loading.png" />');
            },
            success: function (data)
            {
               
               // $('.addTemplateLoader').html('<input name="" type="button" onclick="addTemplate();" value="Save" />');
                if (data == 'FALSE') {
                    action_message1('failed! Contact Administrator', 'error');
                } else {
                   // alert(data);
                    $('a.close').trigger('click');
                    var form_name=$("#form_name").val();
                    
                    $('#templateForm')[0].reset();
                    if(form_name=='bulk_sms')
                    {
                        $("#template").empty();
                        $("#addtemplateForm").trigger('reset');
    
                        load_template_dropdown();
                    }
                    alert('Template succesfully created.');
                   
                    $('#create_template_modal').modal('hide');
                    //load_data();
                }
            }
        });
    }
    
    function load_route_dropdown()
    {
    
     var full_url = window.location.origin+"/itswe_sms_app";
        
                $.ajax({
                    url: full_url+'/controller/manage_gateway_controller.php',
                    type: 'post',
                    cache: false, 
                    data:'list_type=route_dropdown&page=compose',
                    success: function(data){
                        //alert(data);
                       if(data!=0)
                       {
                        $('#az_routeid').empty();
                       empty_data="<option value=''>Select Route</option>";
                       data=empty_data+data;
                        $('#az_routeid').html(data);
                       }
                        
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(data);
                        //$('#content').html(errorMsg);
                      }
                });
    }
    
    function load_sender_id_dropdown()
    {
    
         var full_url = window.location.origin+"/itswe_sms_app";
               $.ajax({
                    url: full_url+'/controller/sender_id_function.php',
                    type: 'post',
                    cache: false, 
                    data:'type=sender_id_dropdown',
                    success: function(data){
                        //alert(data);
                       if(data!=0)
                       {
                        $('#sid').empty();
                        $('#sid').html(data);
                        // $('#sid').chosen(data);
    
                       }
                        
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(data);
                        //$('#content').html(errorMsg);
                      }
                });
    }
    
    function load_sender_id()
    {
    /*alert('test load senderids');*/
            var full_url = window.location.origin+"/itswe_sms_app";
         $.ajax({
                    url: full_url+'/controller/template_function.php',
                    type: 'post',
                    cache: false, 
                    data:'template_type=load_sender_dropdown',
                    success: function(data){
                       /* alert('test load senderids');*/
                        console.log(data);
                       if(data!=0)
                       {
                        /*$('#sender_id').append('<option value="">Select Sender</option>');*/
                        $('#sender_id').empty();
                        $('#sender_id').html(data);
                         $('#sender_id').multiselect('destroy');
                        $('#sender_id').multiselect({
                            columns: 1,
                            placeholder: 'Select Sender Id',
                            search: true,
                            selectAll: true
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
    
    
    $("#addSenderId").click(function(){
                   $( "#senderidsForm" ).validate({
    
                rules: {
                    senderid: "required",
                    PE_ID: "required",
                    Header_ID: "required",
                    descript: "required",
                    
                   
                
    
    
                },
                messages: {
                    senderid: "Please enter Route name",
                    PE_ID: "Please select route",
                    Header_ID: "Please enter rate",
                    descript: "Please select sender id",
                   
                  
                    
                    
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
                    url: full_url+'/controller/sender_id_function.php',
                    type: 'post',
                    cache: false, 
                    data:$("#senderidsForm").serialize(),
                    success: function(data){
                        if(data=='Success')
                            {
                                 swal.fire('','Sender Id Added Successfully!!','success').then((value) => {
                                    $('#exampleModal').modal('hide');
                                      $("#senderidsForm").trigger('reset');
    
                                    load_sender_id_dropdown();
                                   // load_sender_id();
                                });
                      
                            }
                            else
                            {
                                 swal.fire({
                                  icon: 'error',
                                  title: 'Oops...',
                                  text: 'Failed to Add Sender Details!'
                                  
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
    
    
    $('#create_template_modal').on('shown', function(){
     load_sender_id();
    });
      $("#save_template").click(function(){
    
        
    
                $( "#addtemplateForm" ).validate( {
                rules: {
                    template_name: "required",
                    PE_ID: "required",
                    Template_ID: "required",
                    content_type: "required",
                    category_type: "required",
                    sender_id: "required",
                    mbl1: "required", 
                   
    
    
                },
                messages: {
                    template_name: "Please enter Username",
                    PE_ID:"enter password",
                    Template_ID: "Please enter your mobile number",
                    content_type: "Please enter your full name",
                    category_type: "Please enter your full name",
                    sender_id: "Please enter your full name",
                    mbl1: "Please enter your full name",
                    
                    
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
    
                    if ($('#sender_id').val()== '') {
                       swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Please Select Sender ID!'            
                                        });
                    }
                   else
                   {
    
                     var full_url = window.location.origin+"/itswe_sms_app";
                        $.ajax({
                                url: full_url+'/controller/template_function.php',
                                type: 'post',
                                cache: false, 
                                data:$("#addtemplateForm").serialize(),
                                success: function(data){
    
    
                                    if(data!=0)
                                    {
                                        swal.fire("Successfull!", 'Template Details Added Successfully', "success");
                                            $("#create_template_modal").modal('hide');
                                            load_template_dropdown();
                                    }
                                    else
                                    {
                                        swal.fire({
                                                    icon: 'error',
                                                    title: 'Oops...',
                                                    text: 'Failed to add template details!'            
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
    
                return false;
            }
    
            } );
    
        });
    
    
    
    
    function addSenderIds() {
        
        if ($('#senderid_id').val().trim() == '') {
            action_message('Please enter senderid', 'error');
            return false;
        }
        if ($('#senderid_id').val().trim().length != 6) {
            action_message('Senderid must be 6 character only.', 'error');
            return false;
        }
    
         var full_url = window.location.origin+"/itswe_sms_app";
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
    
                    alert('SenderId succesfully created.');
                   
                    if(form_name=='bulk_sms')
                    {
                        $("#sid").empty();
    
                        load_sender_id_dropdown();
                        load_sender_id();
                    }
                   
    
                    $('#exampleModal').modal('hide');
    
                   // load_data();
                }
            }
        });
    }
    
    
    
    function valueChanged(){
        var trackingurl='vap1.in/xyz/xxxxxxx';
        if($('#chk_track').is(":checked")){  
            $(".div_track").css('display','inline');
            var $txt = jQuery("#mbl1");
            var caretPos = $txt[0].selectionStart;
            var textAreaTxt = $txt.val();
            // var txtToAdd = "{" + placeholder + "}";
            $txt.val(textAreaTxt.substring(0, caretPos) + trackingurl + textAreaTxt.substring(caretPos) );
            //$("#mbl1").val($("#mbl1").val() + '\n'+trackingurl);
            checkChar();
        }else{
            $(".div_track").css('display','none');
            //alert($("#mbl1").val());
            $("#mbl1").val($("#mbl1").val().replace(trackingurl, ''));
            checkChar();
        }
    };
    
    
    function load_template_dropdown()
    {
        var senderid=$("#sid").val();
        if(senderid=="")
        {
            alert("Please Select Sender ID");
            return false;
        }
        else
        {
    
    
         var full_url = window.location.origin+"/itswe_sms_app";
               $.ajax({
                    url: full_url+'/controller/template_function.php',
                    type: 'post',
                    cache: false, 
                    data:'template_type=load_template_dropdown_userid&senderid='+senderid,
                    success: function(data){
                        //alert(data);
                       if(data!=0)
                       {
    
                        $('#template').empty();
                        $('#template').html(data);
                        // $('#template').chosen(data);
                       }
                        
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(data);
                        //$('#content').html(errorMsg);
                      }
                });
           }
    }
    
    
    
    function load_group_dropdown()
    {
         var full_url = window.location.origin+"/itswe_sms_app";
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
    
                         $('#group_id').multiselect({
    
                            columns: 1,
                            placeholder: 'Select Group Name',
                            search: true,
                            selectAll: true
                        });
    
                         $('#muliselect_div').css('display','none');  
                        
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(data);
                        //$('#content').html(errorMsg);
                      }
                });
    }
    
    $("#schedule_later_btn").click(function(){
        $("#schedule_later_form").modal('show');
    })
    
    
    
    
    $("#chk_track").change(function() {
        if($('#chk_track').is(":checked")){ 
            $("#original_url_txt").val('');
    
            $("#add_url_tracking").modal('show');
    
        }
        else
        {
           
            $("#add_url_tracking").modal('hide');
            $("#original_url").val('');
            valueChanged();
        }
        
        //valueChanged();
    })
    
    $("#btn_txt_url").click(function() {
        // body...
        var txt_url=$("#original_url_txt").val();
        $("#original_url").val(txt_url);
        valueChanged();
    })
    
    
    $("#btn_img_url").click(function() {
        // body...
        
                var file_data = $('#original_url_img').prop('files')[0];
                var list_type="upload_url";
                if(file_data != undefined) {
                    var full_url = window.location.origin+"/itswe_sms_app";
                    var form_data = new FormData();     
                    
                    form_data.append('original_url', file_data);
                    form_data.append('act', list_type);
                   
                    $.ajax({
                        type: 'POST',
                        url: full_url+"/controller/bulk_sms_function.php",
                        contentType: false,
                        processData: false,
                        cache: false, 
                        data: form_data,
                        success:function(response) {
                            
                            if(response < 0 ) {
    
                                if(response==-2)
                                {
    
                                 Swal.fire({icon: 'error',title: 'Sorry... ',text: 'File already exists!!'});
                                }
                                else if(response==-3)
                                {
                                    Swal.fire({icon: 'error',title: 'Sorry... ',text: 'Failed to upload an image!!'});
                                }
                                else if(response==-1)
                                {
                                    Swal.fire({icon: 'error',title: 'Sorry... ',text: 'File extention should be .png,.jpg,jpeg,gif!!'});
                                }
                                return false;
                               
                               
                            } else {
    
    
                                 Swal.fire("Successful !", "Image URL uploaded successfully", "success").then((value) => {
                                     $("#original_url").val(response);
                                     valueChanged();
                                 
                                   
                                });
                               
                               // alert('Something went wrong. Please try again.');
                            }
      
                            $('#original_url_img').val('');
                        }
                    });
                }
                return false;
      /*  $("#original_url").val('');
        valueChanged();*/
    })
    