$(function(){

var page_name=$("#page_name").html();

 $(".rcs_key_section").css('display','none');
if(page_name=="manage_user")
{
/*    loadUserData();*/
 var full_url = window.location.origin+"/itswe_sms_app";
           $('#user_tbl').DataTable( {
        "processing": true,
        "serverSide": true,
        "responsive": true,
         "ajax": {
                    "type":"POST",
                    "cache": false,
                    "url":full_url+"/controller/utility_controller.php",
                    "data":function (post) {
                            post.type='all_user';
                    

                           
                           
                        }
                  
         },
         "order": [[ 0, "desc" ]],
         "columnDefs": [
                        {"className": "dt-center", "targets": "_all"}
            ]

        } );



    



  $(document).on('click', '.inactive_user_btn', function(){
   var id = $(this).data('id');
    var full_url = window.location.origin+"/itswe_sms_app";
                   swal.fire({
  title: 'Are you sure?',
  text: "You want to make this user account inactive!",
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
                    url: full_url+"/controller/utility_controller.php",
                    type: 'post',
                    cache: false,
                    data:'u_id='+id+"&type=inactive_user",
                    success: function(data){

                        if(data==1)
                        {
                            Swal.fire("Successful !", "Successfully deactivated user", "success").then((value) => {

                                  window.location.href="dashboard.php?page=manage_user";
                                });
                        }
                        else
                        {
                             Swal.fire({icon: 'error',title: 'Oops...Something went wrong',text: 'Please Check!!!!'})
                            
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



  $(document).on('click', '.active_user_btn', function(){
   var id = $(this).data('id');
    var full_url = window.location.origin+"/itswe_sms_app";
                          swal.fire({
  title: 'Are you sure?',
  text: "You want to make this user account active!",
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
                    url: full_url+"/controller/utility_controller.php",
                    type: 'post',
                    cache: false,
                    data:'u_id='+id+"&type=active_user",
                    success: function(data){

                        if(data==1)
                        {
                            Swal.fire("Successful !", "The User has been activated successfully", "success").then((value) => {
                                  window.location.href="dashboard.php?page=manage_user";
                                });
                        }
                        else
                        {
                             Swal.fire({icon: 'error',title: 'Oops...Something went wrong',text: 'Please Check!!!!'})
                            
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


    $(document).on('click', '.login_to_acct', function(){
   var id = $(this).data('id');
    var full_url = window.location.origin+"/itswe_sms_app";

             $.ajax({
                    url: full_url+"/controller/utility_controller.php",
                    type: 'post',
                    cache: false,
                    data:'u_id='+id+"&type=login_to_acct",
                    success: function(data){

                        if(data==1)
                        {
                           window.location.href="dashboard.php";
                        }
                        else
                        {
                             Swal.fire({icon: 'error',title: 'Oops...Something went wrong',text: 'Please Check!!!!'})
                            
                        }
    
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(errorMsg);
                        //$('#content').html(errorMsg);
                      }
                });
        
    });



    $(document).on('click', '.user_edit_btn', function(){
   var id = $(this).data('id');
    var full_url = window.location.origin+"/itswe_sms_app";
    $.post(full_url+'/controller/store_session.php', {uid:id});
    var page_name=encodeURIComponent('page=edit_user');
    var edit_url=full_url+'/dashboard.php?page=edit_user';

   // const complete_url=encodeURI(edit_url);
    //alert(complete_url);
     window.location.href=edit_url;
        
    });





}
else if(page_name=="inactive_user")
{
/*    loadUserData();*/
 var full_url = window.location.origin+"/itswe_sms_app";
           $('#user_tbl').DataTable( {
        "processing": true,
        "serverSide": true,
        "responsive": true,
         "ajax": {
                    "type":"POST",
                    "url":full_url+"/controller/utility_controller.php",
                    "data":function (post) {
                            post.type='all_inactive_user';
                    

                           
                           
                        }
                  
         },
         "order": [[ 0, "desc" ]],
         "columnDefs": [
                        {"className": "dt-center", "targets": "_all"}
            ]

        } );


  $(document).on('click', '.active_user_btn', function(){
   var id = $(this).data('id');
    var full_url = window.location.origin+"/itswe_sms_app";
                          swal.fire({
  title: 'Are you sure?',
  text: "You want to make this user account active!",
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
                    url: full_url+"/controller/utility_controller.php",
                    type: 'post',
                    cache: false,
                    data:'u_id='+id+"&type=active_user",
                    success: function(data){

                        if(data==1)
                        {
                            Swal.fire("Successful !", "The User has been activated successfully", "success").then((value) => {
                                  window.location.href="dashboard.php?page=inactive_user";
                                });
                        }
                        else
                        {
                             Swal.fire({icon: 'error',title: 'Oops...Something went wrong',text: 'Please Check!!!!'})
                            
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
else if(page_name=='edit_user')
{
   $(".rcs_key_section").css('display','none');

    var login_user_role=$("#login_user_role").val();
    if(login_user_role=='mds_rs')
    {
        $(".settings").css('display','none');
    }
    else
    {
         $(".settings").css('display','');
    }

    load_credit_route();
    load_role_dropdown();
    load_edit_route_dropdown();
   
    load_acct_manager_dropdown();
     load_overview();
     load_cutoff_dtls();

    $("#edit_api_key_btn").click(function(){
    
    var api_key=makeid();
    $("#edit_api_key").val(api_key);
   
});

    $("#rcs").change(function(argument) {
        if($(this).is(':checked')) { 
            $(".rcs_key_section").css('display','');
        }
        else
        {
            $(".rcs_key_section").css('display','none');
        }
    })



    
    $("#save_credit").click(function(){

        var credit =  $.trim( $('#credit').val() );
       //  var username =  $.trim( $('#add_credit_form select[name=username]').val() );
       var username =  $.trim( $('#add_credit_form input[name=username]').val() );
        var credit_type =  $.trim( $('#add_credit_form select[name=credit_type]').val() );
        var remark =  $.trim( $('#add_credit_form textarea[name=remark]').val() );
       // alert(credit+" - "+username+" - "+credit_type+" - "+remark);
       if (credit == "" || username == "" ||credit_type == "" ||remark == ""  ) {
           alert("Complete Form values");
       }
       else if(credit==0)
       {
           alert("Please do not enter 0 for cerdit value");
       }
       else
       {
               var full_url = window.location.origin+"/itswe_sms_app";
               $.ajax({
               url: full_url+'/controller/credit_controller.php',
               type: 'post',
               cache:false,
               data:$("#add_credit_form").serialize(),
               success: function(data){
                 // alert(data);
                  if(data==0)
                  {
                        Swal.fire({icon: 'error',title: 'Oops..',text: 'Failed to add transaction details'})
                  }
                  else if(data==1)
                  {

                       if(credit_type=='1')
                       {
                           Swal.fire("Successful !", "Credit Details added successfully", "success").then((value) => {
                             window.location.href="dashboard.php?page=add_remove_credits";
                           });
                       }
                       else if(credit_type=='2')
                       {
                           Swal.fire("Successful !", "Credit refund successfully", "success").then((value) => {
                             window.location.href="dashboard.php?page=add_remove_credits";
                           });
                       }
                       else if(credit_type=='0')
                       {
                           Swal.fire("Successful !", "Amount Debited successfully", "success").then((value) => {
                             window.location.href="dashboard.php?page=add_remove_credits";
                           });
                       }
                        
                  }
                  else if(data==-1)
                  {
                        Swal.fire({icon: 'error',title: 'Oops..',text: 'Available balance less than your debit count'})
                  }
                   else if(data==2)
                  {
                        Swal.fire({icon: 'error',title: 'Oops..',text: 'Less Parent Balance!! Please Check!!'})
                  }
                  else if(data==3)
                  {
                        Swal.fire({icon: 'error',title: 'Oops..',text: 'The limit of overselling has been exceeded.!! Please contact with admin!!'})
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

    //     $("#gvsms").change(function(argument) {
    //     if($(this).is(':checked')) { 
    //         $(".vsms_key_section").css('display','');
    //     }
    //     else
    //     {
    //         $(".vsms_key_section").css('display','none');
    //     }
    // })
    $("#add_rcs_rate").click(function(){
          /*var file_data = $('#rcs_key_file').prop('files')[0];*/

           /* if(file_data != undefined) {*/
                var full_url = window.location.origin+"/itswe_sms_app";
                /*var form_data = new FormData(); */    
                var userid=$("#rcs_userid").val();  
                var text_rate=$("#text_rate").val();  
                var rich_card_rate=$("#rich_card_rate").val(); 
                var a2p_rate=$("#a2p_rate").val();
                var p2a_rate=$("#p2a_rate").val();             
               /* form_data.append('rcs_key_file', file_data);
                form_data.append('userid',userid);*/
                $.ajax({
                    type: 'POST',
                    cache: false,
                     url: full_url+"/controller/user_controller.php",
                   
                    data: "userid="+userid+"&text_rate="+text_rate+"&rich_card_rate="+rich_card_rate+"&a2p_rate="+a2p_rate+"&p2a_rate="+p2a_rate+"&list_type=update_rcs_rate",
                    success:function(response) {
                        response=response.trim();
                        if(response == 'success') {
                             Swal.fire("Successful !", "RCS rate updated successfully", "success");

                            
                        } else {
                            Swal.fire({icon: 'error',title: 'Oops...Something went wrong. ',text: response})
                            return false;
                           // alert('Something went wrong. Please try again.');
                        }
  
                       /* $('#rcs_key_file').val('');*/
                    }
                });
            //}
            return false;
    });


    $("#submit_vsms_key_file").click(function(){
          var public_key_file = $('#public_key_file').prop('files')[0];
           var private_key_file = $('#private_key_file').prop('files')[0];
            var service_key_file = $('#service_key_file').prop('files')[0];
            var agent_id=$("#agent_id").val();

            if(public_key_file != undefined && private_key_file != undefined && service_key_file != undefined) {
                var full_url = window.location.origin+"/itswe_sms_app";
                var form_data = new FormData();     
                var userid=$("#userid").val();             
                form_data.append('public_key_file', public_key_file);
                form_data.append('private_key_file', private_key_file);
                form_data.append('service_key_file', service_key_file);
                form_data.append('userid',userid);
                form_data.append('agent_id',agent_id);
                $.ajax({
                    type: 'POST',
                    cache: false,
                     url: full_url+"/controller/upload_vsms_key_files.php",
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success:function(response) {
                        
                        if(response == 'success') {
                             Swal.fire("Successful !", "File uploaded successfully", "success");

                            
                        } else {
                            Swal.fire({icon: 'error',title: 'Oops...Something went wrong. ',text: response})
                            return false;
                           // alert('Something went wrong. Please try again.');
                        }
  
                        $('#rcs_key_file').val('');
                    }
                });
            }
            return false;
    });
    $(".user_access").change(function(event){
        var access_name=$(this).attr('name');
        var userid=$("#userid").val();
        if($(this).is(':checked')) { 
               var full_url = window.location.origin+"/itswe_sms_app";
           $.ajax({
                    url: full_url+'/controller/user_controller.php',
                    type: 'post',
                    cache: false,
                    data:"access_name="+access_name+"&list_type=update_access&val=Yes&userid="+userid,
                    success: function(data){

                        console.log(data);
                       /* Swal.fire("Successful !", data, "success").then((value) => {
                              //window.location.href="dashboard.php?page=manage_user";
                            });*/
                        //swal("Click on either the button or outside the modal.")

                       // location.reload();
                     
                        
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
                var full_url = window.location.origin+"/itswe_sms_app";
           
                 $.ajax({
                    url: full_url+'/controller/user_controller.php',
                    type: 'post',
                    cache: false,
                    data:"access_name="+access_name+"&list_type=update_access&val=No&userid="+userid,
                    success: function(data){

                        console.log(data);
                       /* Swal.fire("Successful !", data, "success").then((value) => {
                              //window.location.href="dashboard.php?page=manage_user";
                            });*/
                        //swal("Click on either the button or outside the modal.")

                       // location.reload();
                     
                        
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(data);
                        //$('#content').html(errorMsg);
                      }
                });
          
        }
    });
  
  $(document).on('click', '.edit_cut_off_btn', function(){
  
    var cut_off_id = $(this).data('cut_off_id');
    var routeid = $(this).data('routeid');
    var cut_off_status = $(this).data('cut_off_status');
    var c_throughput = $(this).data('c_throughput');
    var min_cut_value = $(this).data('min_cut_value');
        $("#old_route").val(routeid);
         $(`#edit_route_cutoff option[value='${routeid}']`).prop('selected', true);
          $(`#edit_cut_off_status option[value='${cut_off_status}']`).prop('selected', true);
          $("#edit_c_throughput").val(c_throughput);
          $("#edit_c_min_val").val(min_cut_value);
            $("#edit_cut_off_id").val(cut_off_id);
    });


 


  $(document).on('click', '.delete_cut_off_btn', function(){
  
    var cut_off_id = $(this).data('cut_off_id');

  swal.fire({
  title: 'Are you sure?',
  text: "You want to delete this cut off details!",
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
                                        url: full_url+'/controller/user_controller.php',
                                        type: 'post',
                                        cache: false,
                                        data:'list_type=delete_cutoff&cut_off_id='+cut_off_id,
                                        success: function(data){
                                           
                                           if(data==1)
                                           {
                                                swal.fire('','Cut-Off Details Deleted Successfully!!','success').then((value) => {
                                                    
                                               window.location.href="dashboard.php?page=edit_user";
                                                    });
                                           }
                                           else
                                           {
                                                swal.fire({
                                                  icon: 'error',
                                                  title: 'Oops...',
                                                  text: 'Failed to delete cut-off details!'
                                                  
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



    $("#save_plan_btn").click(function(){

            var full_url = window.location.origin+"/itswe_sms_app";
              $.ajax({
                    url: full_url+'/controller/user_controller.php',
                    type: 'post',
                    cache: false,
                    data:$("#update_plan_form").serialize(),
                    success: function(data){
                       // alert(data);
                       
                        Swal.fire("Successful !", data, "success").then((value) => {
                              window.location.href="dashboard.php?page=manage_user";
                            });
                        //swal("Click on either the button or outside the modal.")

                       // location.reload();
                     
                        
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(errorMsg);
                        //$('#content').html(errorMsg);
                      }
                });
        

    });



        $("#save_sender_id").click(function(){

    

            $( "#senderidsForm" ).validate( {
            rules: {
                senderid: "required",
                PE_ID: "required",
                Header_ID: "required",
                descript: "required", 
               


            },
            messages: {
                senderid: "Please enter Username",
                PE_ID:"enter password",
                Header_ID: "Please enter your mobile number",
                descript: "Please enter your full name",
                
                
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
    if ($('#senderid_id').val() == '') {
       Swal.fire({icon: 'error',title: 'Oops...',text: 'Please Enter Sender ID'})
        return false;
    }
    if ($('#senderid_id').val().length != 6) {
        Swal.fire({icon: 'error',title: 'Oops...',text: 'Sender ID must be 6 characters only!'})
        return false;
    }

        var full_url = window.location.origin+"/itswe_sms_app";
       $.ajax({
                    url: full_url+'/controller/sender_id_function.php',
                    type: 'post',
                    cache: false,
                    data:$("#senderidsForm").serialize(),
                    success: function(data){

                        //console.log(data);
                        swal.fire("Sender Details Added Successfully !", data, "success").then((value) => {
                                $("#senderidsForm").trigger('reset');
                                location.reload();
                            });
                        //swal("Click on either the button or outside the modal.")

                       // location.reload();
                     
                        
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(data);
                        //$('#content').html(errorMsg);
                      }
                });
            return false;
        }

        } );

    });


$("#role").change(function(){
 var full_url = window.location.origin+"/itswe_sms_app";
 var user_role=$("#role").val();
     $.ajax({
                    url: full_url+'/controller/user_controller.php',
                    type: 'post',
                    cache: false,
                    data:'role='+user_role+'&list_type=check_role',
                    success: function(data){

                        $("#selected_user_role").val(data);
                        //location.reload();
                     
                        
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(data);
                        //$('#content').html(errorMsg);
                    }
            });
});

    $("#save_user_btn").click(function(){

    

            $( "#save_profile_form" ).validate( {
            rules: {
                username: "required",
                
                mobile: "required",
                f_name: "required", 
                company_name: "required", 
                email: "required",
                city: "required", 
                pincode: "required",
                role: "required",
                route: "required"


            },
            messages: {
                username: "Please enter Username",
              
                mobile: "Please enter your mobile number",
                f_name: "Please enter your full name",
                company_name: "Please enter company name",
                email: "Please enter email",
                city: "Please enter city",
                pincode: "Please enter pincode",
                role: "Please select Role",
                route: "Please select Route"
                
                
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
                var full_url = window.location.origin+"/itswe_sms_app";

                 var user_role=$("#selected_user_role").val();
           

            if(user_role!='mds_acc') {
               /* var acct_manager=$("#acct_manager").val();
                if(acct_manager=='')
                {
                    Swal.fire({icon: 'error',title: 'Oops....',text: 'Please Select Account Manager!!!!'})
                   
                }
                else
                {*/

                   $.ajax({
                            url: full_url+'/controller/user_controller.php',
                            type: 'post',
                            cache: false,
                            data:$("#save_profile_form").serialize(),
                            success: function(data){

                                console.log(data);
                                Swal.fire("Successful !", data, "success").then((value) => {
                                      window.location.href="dashboard.php?page=manage_user";
                                    });
                                //swal("Click on either the button or outside the modal.")

                               // location.reload();
                             
                                
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                                alert(data);
                                //$('#content').html(errorMsg);
                              }
                        });
            return false;
            //}

       
        }
    }

    });
        });



    $("#save_cut_off").click(function(){

    

            $( "#cut_off_form" ).validate( {
            rules: {
                route_cutoff: "required",
                
                cut_off_status: "required",
                c_throughput: "required",
                c_min_val: "required"



            },
            messages: {
               route_cutoff: "Select Route",
               
                cut_off_status: "Cut Off Status",
                c_throughput: "Enter Throughput",
                c_min_val: "Enter Minimum value"
                
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
            //console.log('Form submitted');
                var full_url = window.location.origin+"/itswe_sms_app";
           $.ajax({
                    url: full_url+'/controller/user_controller.php',
                    type: 'post',
                    cache: false,
                    data:$("#cut_off_form").serialize(),
                    success: function(data){

                    //  alert(data);
                        if(data=='1')
                        {
                            Swal.fire("Successful !", 'Cut Off Details Added successfully', "success").then((value) => {
                              window.location.href="dashboard.php?page=edit_user";
                            });
                        }
                        else if(data=='0')
                        {
                            Swal.fire({icon: 'error',title: 'Oops...',text: 'Something went wrong!'}).then((value) => {
                              //window.location.href="dashboard.php?page=manage_user";
                            });
                        }
                       else if(data==2)
                        {
                            Swal.fire({icon: 'error', title: 'Oops...', text: 'Cut Off details already exists'}).then((value) => {
                              //window.location.href="dashboard.php?page=manage_user";
                            });
                        }
                        
                        load_cutoff_dtls();
                        //swal("Click on either the button or outside the modal.")

                       // location.reload();
                     
                        
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(errorMsg);
                        //$('#content').html(errorMsg);
                      }
                });
            return false;
        }

        } );

    });



    $("#edit_cut_off").click(function(){

            $( "#edit_cut_off_form" ).validate({
            rules: {
                edit_route_cutoff: "required",
                edit_cut_off_status: "required",
                edit_c_throughput: "required",
                edit_c_min_val: "required"
            },
            messages: {
                edit_route_cutoff: "Select Route",
                edit_cut_off_status: "Cut Off Status",
                edit_c_throughput: "Enter Throughput",
                edit_c_min_val: "Enter Minimum value"
                
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
            //console.log('Form submitted');
           var full_url = window.location.origin+"/itswe_sms_app";
           $.ajax({
                    url: full_url+'/controller/user_controller.php',
                    type: 'post',
                    cache: false,
                    data:$("#edit_cut_off_form").serialize(),
                    success: function(data){
                        alert(data);
                        if(data=='1')
                        {
                            Swal.fire("Successful !", 'Cut Off Details updated successfully', "success").then((value) => {
                            window.location.href="dashboard.php?page=edit_user";
                            });
                        }
                        else if(data=='0')
                        {
                            Swal.fire({icon: 'error',title: 'Oops...',text: 'Something went wrong!'}).then((value) => {
                              //window.location.href="dashboard.php?page=manage_user";
                            });
                        }
                       else if(data==2)
                        {
                            Swal.fire({icon: 'error', title: 'Oops...', text: 'Cut Off details already exists'}).then((value) => {
                              //window.location.href="dashboard.php?page=manage_user";
                            });
                        }
                        
                        load_cutoff_dtls();
                        //swal("Click on either the button or outside the modal.")

                       // location.reload();
                     
                        
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(data);
                        //$('#content').html(errorMsg);
                      }
                });
            return false;
        }

        } );

    });



}
else if(page_name=='Recharge History')
{
    loadData();
}

	//loadData();



});


function load_cutoff_dtls()
{
     var full_url = window.location.origin+"/itswe_sms_app";
            $.ajax({
                url: full_url+'/controller/user_controller.php',
                type: 'post',
                cache: false,
                data:'list_type=load_cutoff_dtls',
                success: function(data){
               // alert(data);
                   if(data!=0)
                   {
                   // $('#role').empty();
                    $('#cut_off_list').html(data);
            
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}


function load_role_dropdown()
{
        var full_url = window.location.origin+"/itswe_sms_app";
            $.ajax({
                url: full_url+'/controller/user_controller.php',
                type: 'post',
                cache: false,
                data:'list_type=role_dropdown',
                success: function(data){
               // alert(data);
                   if(data!=0)
                   {
                   // $('#role').empty();
                    $('#role').append(data);
            
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}


function load_credit_route()
{
    
    var u_id=$("#userid").val();
  
    var full_url = window.location.origin+"/itswe_sms_app";
           $.ajax({
                    url: full_url+'/controller/credit_controller.php',
                    type: 'post',
                    cache: false, 
                    data: 'type=fetch_route&u_id='+u_id,
                    success: function(data){
                        console.log(data);
                        //alert(data);
                       $("#credit_route").empty();
                       $('#credit_route').html(data);
                     
                        
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(errorMsg);
                        //$('#content').html(errorMsg);
                      }
                });
}

function edit_user(form_id)
{
    //alert(form_id);
    $("#"+form_id).submit();
}
function loadData()
{
        var full_url = window.location.origin+"/itswe_sms_app";

var table="";
	$.ajax({
                url: full_url+'/controller/utility_controller.php',
                type: 'post',
                cache: false,
                data:'type=all_recharge_history',
                success: function(data){
                    //console.log(data);
                   if(data!=0)
                   {
                    $('.recharge_history_list').html(data);
                    table=$('#recharge_history_tbl').DataTable({
                        order: [[0, 'desc']],
                        stateSave: false,
                    });

                // $('#recharge_history_tbl thead th').each(function () {
                //     var title = $(this).text();
                //     $(this).html(title+' <br><input type="text" id="input' + $(this).index() + '" class="col-search-input" placeholder="Search ' + title + '"  style="width:100%;"/>');
                // });
        
                            // table.columns().every(function () {
                            //      var table = this;
                            //      var val;
                            //         val = $('#input' + $(this).index()).val();

                            //         var title = $(this).text();
                            //         console.log('title =' + title);
                            //     $('input', this.header()).on('keyup change', function () {
                            //         if (table.search() !== this.value) {
                            //                table.search(this.value).draw();
                            //         }
                            //     });
                            // });
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });


    $.ajax({
                url: full_url+'/controller/utility_controller.php',
                type: 'post',
                cache: false,
                data:'type=self_recharge_history',
                success: function(data){
                    //console.log(data);
                   if(data!=0)
                   {
                    $('.recharge_history_list_self').html(data);
                    table=$('#recharge_history_self_tbl').DataTable({
                        order: [[0, 'desc']],
                        stateSave: false,
                    });

                $('#recharge_history_self_tbl thead th').each(function () {
                    var title = $(this).text();
                    $(this).html(title+' <br><input type="text" id="input' + $(this).index() + '" class="col-search-input" placeholder="Search ' + title + '"  style="width:100%;"/>');
                });
        
                            // table.columns().every(function () {
                            //      var table = this;
                            //      var val;
                            //         val = $('#input' + $(this).index()).val();

                            //         var title = $(this).text();
                            //         console.log('title =' + title);
                            //     // $('input', this.header()).on('keyup change', function () {
                            //     //     if (table.search() !== this.value) {
                            //     //            table.search(this.value).draw();
                            //     //     }
                            //     // });
                            // });
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}
function load_overview()
{

    var userid=$("#userid").val();
    var full_url = window.location.origin+"/itswe_sms_app";
    $.ajax({
                url: full_url+'/controller/utility_controller.php',
                type: 'post',
                cache: false,
                data:'type=overview&userid='+userid,
                dataType:'json',
                success: function(data){
                    var res = JSON.parse(JSON.stringify(data));
                    console.log(data);
                    //alert(res['id'][0]);
                    
                 if(data!=0)
                   {


                        $("#username").val(res[0]['user_name']);
                        $("#pasword").val(res[0]['user_name']);
                        $("#mobile").val(res[0]['mobile_no']);
                        $("#f_name").val(res[0]['client_name']);
                        $("#email_id").val(res[0]['email_id']);
                        $("#city").val(res[0]['city']);
                        $("#pincode").val(res[0]['pincode']);
                        $("#edit_api_key").val(res[0]['api_key']);
                        $("#company_name").val(res[0]['company_name']);
                        
                        var user_role=res['role'];
                        /* alert(res['id'][0]);*/
                        var role_hash=res['role_hash'];
                        var acct_manager=res[0]['acct_manager'];
                        $(`#acct_manager option[value='${acct_manager}']`).prop('selected', true);
                        var rcs_access=res[0]['rcs'];
                        //$(`#role option:contains('${user_role}')`).prop('selected', true);
                        // alert(user_role);
                        $(`#role option[data-name='${user_role}']`).prop('selected', true);
                        //$(`#role option:contains('${user_role}')`).prop('selected', true);
                         
                        /*$('#role').append('<option value='+role_hash+' selected>'+user_role+'</option>');*/

                        //var route_ids=res[0]['route_ids'];
                        var route_ids=res[0]['route_ids'];
                        var route_all_ids=res['all_route']['id'];
                        var route_name=res['all_route']['name'];
                    
                               if (route_ids.indexOf(',') != -1) {
                                        var route_id_arr = route_ids.split(',');
                                        for(var i=0;i<route_id_arr.length;i++)
                                        {

                                         $(`#route option[value='${route_id_arr[i]}']`).prop('selected', true);
                                        } 


                                    }
                                    else
                                    {
                                        $(`#route option[value='${route_ids}']`).prop('selected', true);
                                    }


                                $("#route_cutoff").empty();
                                $("#edit_route_cutoff").empty();
                                if(route_ids.indexOf(',') != -1) {

                                        var route_id_arr2 = route_ids.split(',');

                                        $("#route_cutoff").append("<option value=''>Select Route</option>");
                                         $("#edit_route_cutoff").append("<option value=''>Select Route</option>");
                                        for(var i=0;i<route_id_arr2.length;i++)
                                        {
                                            var cutoff_indx=$.inArray(route_id_arr2[i],route_all_ids);
                                            var cut_off_route_id=route_all_ids[cutoff_indx];
                                            var cut_off_route_name=route_name[cutoff_indx];
                                            $("#route_cutoff").append("<option value='"+cut_off_route_id+"'>"+cut_off_route_name+"</option>");
                                            $("#edit_route_cutoff").append("<option value='"+cut_off_route_id+"'>"+cut_off_route_name+"</option>");
                                        } 


                                    }
                                    else
                                    {
                                       
                                        $("#route_cutoff").append("<option value=''>Select Route</option>");
                                        $("#edit_route_cutoff").append("<option value=''>Select Route</option>");
                                        for(var i=0;i<route_ids.length;i++)
                                        {
                                            var cutoff_indx=$.inArray(route_ids[i],route_all_ids);
                                            var cut_off_route_id=route_all_ids[cutoff_indx];
                                            var cut_off_route_name=route_name[cutoff_indx];
                                            $("#route_cutoff").append("<option value='"+cut_off_route_id+"'>"+cut_off_route_name+"</option>");
                                            $("#edit_route_cutoff").append("<option value='"+cut_off_route_id+"'>"+cut_off_route_name+"</option>");
                                        } 
                                        
                                    }


                                    if(rcs_access=='No')
                                    {
                                         $(`#route option[value='5']`).remove();
                                    }


                        //     $('#route').multiselect({
                        //     columns: 1,
                        //     placeholder: 'Select Route Id',
                        //     search: true,
                        //     selectAll: true
                        // });
                       
         /*                       for(var i=0;i<route_id_arr.length;i++)
                                {
                                    match_id=res['id'][i];
                                  
                                    
                                    if($.inArray(match_id, route_id_arr[$i]) != -1)
                                    {
                                       
                                       
                                        $("#route").append('<option value='+res['all_route']['id'][i]+' selected>'+res['all_route']['name'][i]+'</option>');
                                        //continue;
                                    }
                                    else
                                    {
                                        $("#route").append('<option value='+res['all_route']['id'][i]+'>'+res['all_route']['name'][i]+'</option>');

                                    }
                                   
                                    
                                }*/
                               var cutofroute_id='';
                           
                             
                
                        if(res[0]['cutting_apply']=='Yes')
                        {
                            $("#cutting").empty();
                            $("#cutting").append('<option value="Yes" selected>Yes</option>');
                            $("#cutting").append('<option value="No">No</option>');
                        }
                        else
                        {
                            $("#cutting").empty();
                            $("#cutting").append('<option value="No" selected>No</option>');
                            $("#cutting").append('<option value="Yes">Yes</option>');
                        }

                        if(res[0]['throughput']!=0)
                        {
                            $("#c_throughput").val(res[0]['throughput']);
                        }
                        
                        if(res[0]['min_cut_value']!=0)
                        {
                            $("#c_min_val").val(res[0]['min_cut_value']);
                        }
                        

                        if(res[0]['restricted_report']=='Yes')
                        {
                            $("#restricted_report").prop('checked','checked');
                            //$("#restricted_report").val('Yes');

                           // $(".reports").css('display','none');
                        }
                        else
                        {
                             $("#restricted_report").prop('checked','');
                            //$("#restricted_report").val('No');
                           // $(".reports").css('display','');
                        }



                         if(res[0]['restricted_tlv']=='Yes')
                        {
                            $("#restricted_tlv").prop('checked','checked');
                            //$("#restricted_report").val('Yes');

                           // $(".reports").css('display','none');
                        }
                        else
                        {
                             $("#restricted_tlv").prop('checked','');
                            //$("#restricted_report").val('No');
                           // $(".reports").css('display','');
                        }

                        

                        if(res[0]['miscall_report']=='Yes')
                        {
                            $("#miscall_report").prop('checked','checked');
                            //$("#miscall_report").val('Yes');

                           // $(".reports").css('display','none');
                        }
                        else
                        {
                             $("#miscall_report").prop('checked','');
                            //$("#restricted_report").val('No');
                           // $(".reports").css('display','');
                        }


                        if(res[0]['gvsms']=='Yes')
                        {
                            $("#gvsms").prop('checked','checked');
                            /* $("#vsms_sec").css('display','');*/

                             $(".vsms_key_section").css('display','');
                            //$("#gvsms").val('Yes');
                        }
                        else
                        {
                             $("#gvsms").prop('checked','');
                             $(".vsms_key_section").css('display','none');
                            /* $("#vsms_sec").css('display','none');
                             $(".vsms_key_section").css('display','none');*/
                           // $("#gvsms").val('');
                        }


                         if(res[0]['voice_call']=='Yes')
                        {
                            $("#voice_call").prop('checked','checked');
                            /*$("#voice_call_sec").css('display','');*/
                        }
                        else
                        {
                             $("#voice_call").prop('checked','');
                            /*$("#voice_call_sec").css('display','none');*/
                        }

                        if(res[0]['rcs']=="Yes")
                        {
                            $("#rcs").prop('checked','checked');
                            $("#rcs_sec").css('display','');

                            $(".rcs_key_section").css('display','');


                             var rcs_sms_rate=res['rcs_rate']['rcs_sms_rate'];
                            var rich_card_rate=res['rcs_rate']['rcs_rich_card_rate'];
                            var a2p_rate=res['rcs_rate']['a2p_rate'];
                            var p2a_rate=res['rcs_rate']['p2a_rate'];


                            $("#text_rate").val(rcs_sms_rate);
                            $("#rich_card_rate").val(rich_card_rate);
                            $("#a2p_rate").val(a2p_rate);
                            $("#p2a_rate").val(p2a_rate);
        
            
        
                            //$("#rcs").val('Yes');
                        }
                        else
                        {
                             $("#rcs").prop('checked','');
                             //$("#rcs_sec").css('display','none');
                             //$(".rcs_key_section").css('display','none');
                           // $("#rcs").val('No');
                        }
                       
                       // $("#agent_id").val(res['vsms'][1]);
                      var pid,pname,selected_pid;

                           for(var j=0;j<res['all']['p_id'].length;j++)
                           {
                             pid=res['all']['p_id'][j];
                             pname=res['all']['p_name'][j];

                            
                                $("#plan").append('<option value='+pid+'>'+pname+'</option>');
                             
                             
                           }

                           if(res['selected']['p_id']!='')
                            {

                                 selected_pid=res['selected']['p_id'];
                            $(`#plan option[value='${selected_pid}']`).prop('selected', true);
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

function load_route_dropdown()
{
      var full_url = window.location.origin+"/itswe_sms_app";
            $.ajax({
                url: full_url+'/controller/manage_gateway_controller.php',
                type: 'post',
                cache: false,
                data:'list_type=route_dropdown',
                success: function(data){
               // alert(data);
                   if(data!=0)
                   {
                    //$('#route').empty();

                    $('#route').append(data);
                   


                                 /*  $('#route').multiselect({
                            columns: 1,
                            placeholder: 'Select Route Id',
                            search: true,
                            selectAll: true
                        });*/
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}




function load_edit_route_dropdown()
{

      var full_url = window.location.origin+"/itswe_sms_app";
      var edit_userid=$("#userid").val();
            $.ajax({
                url: full_url+'/controller/manage_gateway_controller.php',
                type: 'post',
                cache: false,
                dataType:'json',
                data:'list_type=edit_route_dropdown&edit_userid='+edit_userid,
                    
                success: function(data){
                    var res = JSON.parse(JSON.stringify(data));
                    console.log(data[1]);
                    var whitelist = [];
                    var whitelist2 = [];
                    data[0].forEach(function(item) {
                        // Create an object with both sid and senderid properties
                        var whitelistItem2 = {
                            value: item.route_name,
                            sid: item.route_id
                        };
                        // Add the object to the whitelist array
                        whitelist2.push(whitelistItem2);
                    });


                    data[1].forEach(function(item) {
                        // Create an object with both sid and senderid properties
                        var whitelistItem = {
                            value: item.route_name,
                            sid: item.route_id
                        };
                        // Add the object to the whitelist array
                        whitelist.push(whitelistItem);
                    });
                    
                    // Select the input field for Tagify
                    var input = document.querySelector('input[name="routes"]');
                    
                // Check if Tagify is already initialized on the input field
                    if (input.tagify) {
                        input.tagify.removeAllTags();
                        // Update whitelist and show dropdown
                        input.tagify.settings.whitelist = whitelist;
                        var preselectedValues = whitelist2.map(function(item) {
                            return { value: item.value, sid: item.sid };
                        });
                        input.tagify.addTags(preselectedValues);
                       // input.tagify.dropdown.showDropdown(); // Corrected method name
                    } else {
                        // Initialize Tagify
                        var tagify = new Tagify(input, {
                            whitelist: whitelist,
                            maxTags: 10,
                            dropdown: {
                                maxItems: 20,
                                classname: "tags-look",
                                enabled: 0,
                                closeOnSelect: false
                            }
                        });




                        

                        // // Store Tagify instance in input.tagify
                         input.tagify = tagify;

                         var preselectedValues = whitelist2.map(function(item) {
                            return { value: item.value, sid: item.sid };
                        });
                        input.tagify.addTags(preselectedValues);

                        // Listen for 'add' event on Tagify to update selected sids
                        tagify.on('add', function(e) {
                            updateSelectedSids();
                        });

                        // Listen for 'remove' event on Tagify to update selected sids
                        tagify.on('remove', function(e) {
                            updateSelectedSids();
                        });

                        
                    }

                    function updateSelectedSids() {
                        var selectedSids = input.tagify.value.map(function(tagData) {
                            return tagData.sid;
                        });
                        document.getElementById('route').value = selectedSids;
                    }

                    // var preSelectedRoutes = data.map(function(item) {
                    //     return item.route_name;
                    // }).join(',');
                    
                    // input.value = preSelectedRoutes;

                    // // Update Tagify with pre-selected values
                    // input.tagify.loadOriginalValues();

                
                    updateSelectedSids();
                    
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}

function makeid() {
  var text = "";
  var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

  for (var i = 0; i < 12; i++)
    text += possible.charAt(Math.floor(Math.random() * possible.length));

  return text;
}

function load_acct_manager_dropdown()
{


      var full_url = window.location.origin+"/itswe_sms_app";
      var userid=$("#userid").val();
            $.ajax({
                url: full_url+'/controller/manage_gateway_controller.php',
                type: 'post',
                cache: false,
                data:'list_type=acct_manager_dropdown&edit_userid='+userid,
                success: function(data){
               // alert(data);
                   if(data!=0)
                   {
                    //$('#route').empty();
                    $('#acct_manager').html(data);

/*
                                   $('#acct_manager').multiselect({
                            columns: 1,
                            placeholder: 'Select Account Manager',
                            search: true,
                            selectAll: true
                        });*/
                   }
                   else
                   {
                        /*Swal.fire({icon: 'error',title: 'Oops...',text: 'Please add account manager first!!!!'});*/
                        /*$('#acct_manager').multiselect({
                            columns: 1,
                            placeholder: 'Select Account Manager',
                            search: true,
                            selectAll: true
                        });*/
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
}


function loadUserData()
{

        var full_url = window.location.origin+"/itswe_sms_app";
    $.ajax({
                url: full_url+'/controller/utility_controller.php',
                type: 'post',
                cache: false,
                data:'type=all_user',
                success: function(data){
                   // console.log(data);
                   if(data!=0)
                   {
                    $('#user_list').html(data);

                  
                   
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}