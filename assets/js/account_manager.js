$(function(){
    load_acct_manager_dtls();
/*
load_route_dropdown();
load_acct_manager_dropdown();
load_role_dropdown();*/

//Swal.fire('Any fool can use a computer');


// Fetch all the forms we want to apply custom Bootstrap validation styles to


$("#api_key_btn").click(function(){
    
    var api_key=makeid();
    $("#api_key").val(api_key);
   
});
$("#save_user_btn").click(function(){

        $( "#add_user_form" ).validate({
            rules: {
                username: "required",
                password: "required",
                mobile: "required",
                f_name: "required", 
                company_name: "required", 
                email: "required",
                city: "required", 
                pincode: "required",
                role: "required",
                route: "required",

               


            },
            messages: {
                username: "Please enter Username",
                password: "Please enter a valid password",
                mobile: "Please enter your mobile number",
                f_name: "Please enter your full name",
                company_name: "Please enter company name",
                email: "Please enter email",
                city: "Please enter city",
                pincode: "Please enter pincode",
                role: "Please select Role",
                route: "Please select Route",
                

                
                
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
            var full_url = window.location.origin;
            var user_role=$("#selected_user_role").val();
           

            if(user_role!='mds_acc') {
                var acct_manager=$("#acct_manager").val();
                if(acct_manager=='')
                {
                    Swal.fire({icon: 'error',title: 'Oops....',text: 'Please Select Account Manager!!!!'})
                   
                }
                else
                {
                        $.ajax({
                        url: full_url+'/controller/user_controller.php',
                        type: 'post',
                    cache: false,
                        data:$("#add_user_form").serialize(),
                        success: function(data){
                            alert(data);
                            if(data==0)
                            {
                                Swal.fire({icon: 'error',title: 'Oops...',text: 'Failed to add user details'});
                            }
                            else if(data==1)
                            {
                                Swal.fire("Successfull!", "New User Added!", "success").then((value) => {
                                   $("#add_user_form").trigger('reset');
                                  location.reload();
                                });
                            }
                            else if(data==2)
                            {
                                Swal.fire({icon: 'error',title: 'Oops...',text: 'User Already Exists!!!'});
                            }
                            //alert(data);
                           /* Swal.fire("Successfull!", "New User Added!", "success").then((value) => {
                                  location.reload();
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


            }
            else
            {
           $.ajax({
                    url: full_url+'/controller/user_controller.php',
                    type: 'post',
                    cache: false,
                    data:$("#add_user_form").serialize(),
                    success: function(data){

                        //alert(data);
                        Swal.fire("Successfull!", "New User Added!", "success").then((value) => {
                             $("#add_user_form").trigger('reset');
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
            }
            return false;
        }

        } );
});


$("#role").change(function(){
 var full_url = window.location.origin;
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

$("#save_acct_manager_btn").click(function(){

        $( "#add_acct_form" ).validate({
            rules: {
                username: "required",
                password: "required",
                mobile: "required",
                f_name: "required", 
                email: "required",
            },
            messages: {
                username: "Please enter Username",
                password: "Please enter a valid password",
                mobile: "Please enter your mobile number",
                f_name: "Please enter your full name",
                email: "Please enter email",
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
            var full_url = window.location.origin;
         
         
           $.ajax({
                    url: full_url+'/controller/user_controller.php',
                    type: 'post',
                    cache: false,
                    data:$("#add_acct_form").serialize(),
                    success: function(data){

                       //alert(data);
                        if(data==1)
                        {
                            Swal.fire("Successfull!", "New Account Manager Added!", "success").then((value) => {
                                 $("#add_acct_form").trigger('reset');
                              location.reload();
                            });
                        }
                        else
                        {
                             Swal.fire({icon: 'error',title: 'Oops...',text: 'Something went wrong!!!!'});
                        }
                        
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


$("#update_acct_manager_btn").click(function(){

        $( "#edit_acct_form" ).validate({
            rules: {
                edit_username: "required",
             
                edit_mobile: "required",
                edit_f_name: "required", 
                edit_email: "required",
                 edit_status: "required",
            },
            messages: {
                edit_username: "Please enter Username",
                
                edit_mobile: "Please enter your mobile number",
                edit_f_name: "Please enter your full name",
                edit_email: "Please enter email",
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
            console.log('Form submitted');
            var full_url = window.location.origin;
         
                      swal.fire({
                          title: 'Are you sure?',
                          text: "You wish to change the account manager's information!",
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
                    url: full_url+'/controller/user_controller.php',
                    type: 'post',
                    cache: false,
                    data:$("#edit_acct_form").serialize(),
                    success: function(data){

                       //alert(data);
                        if(data==1)
                        {
                            Swal.fire("Successfull!", "Account manager information was successfully updated.!", "success").then((value) => {
                                 $("#edit_acct_form").trigger('reset');
                              location.reload();
                            });
                        }
                        else
                        {
                             Swal.fire({icon: 'error',title: 'Oops...',text: 'Something went wrong!!!!'});
                        }
                        
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
            
            return false;
        }

        } );
});

$(document).on( "click", '.edit_acct_manager_btn',function(e) {
  
    var id = $(this).data('id');
    var user_name = $(this).data('user_name');
     var fname = $(this).data('fname');
    
    var mobile_no=$(this).data('mobile_no');
    var email_id=$(this).data('email_id');
    var status=$(this).data('status');
   
    $("#acct_manager_id").val(id);
    $("#edit_username").val(user_name);

    $("#edit_mobile").val(mobile_no);
    $("#edit_email").val(email_id);
   
    $("#edit_f_name").val(fname);
  
    $(`#edit_status option[value='${status}']`).prop('selected', true);

   
});

        $(document).on( "click", '.delete_acct_manager_btn',function(e) {
  
    var id = $(this).data('id');

   
           swal.fire({
  title: 'Are you sure?',
  text: "You want to delete this Account manager's information!",
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
                                        url: full_url+'/controller/user_controller.php',
                                        type: 'post',
                                        cache: false,
                                        data:'list_type=delete_acct_manager&acct_manager_id='+id,
                                        success: function(data){
                                           
                                           if(data==1)
                                           {
                                                swal.fire('Success','Account manager Details Deleted Successfully!!','success').then((value) => {

                                                 window.location.reload(full_url+'/dashboard.php?page=account_manager');
                                                    });
                                           }
                                           else
                                           {
                                                swal.fire({
                                                  icon: 'error',
                                                  title: 'Oops...',
                                                  text: 'Failed to delete Account Manager details!'
                                                  
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





});


function makeid() {
  var text = "";
  var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

  for (var i = 0; i < 12; i++)
    text += possible.charAt(Math.floor(Math.random() * possible.length));

  return text;
}
function load_route_dropdown()
{
      var full_url = window.location.origin;
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
                    $('#route').html(data);


                                   $('#route').multiselect({
                            columns: 1,
                            placeholder: 'Select Route Id',
                            search: true,
                            selectAll: true
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


function load_acct_manager_dtls()
{
    var full_url = window.location.origin;

    $('#acct_manager_tbl').DataTable( {
        "processing": true,
        "serverSide": true,
        "responsive": true,
         "ajax": {
                    "type":"POST",
                    "url":full_url+"/controller/user_controller.php",
                    "data":function (post) {
                            post.list_type='load_acct_manager';
      
                        }
                  
         },
         "order": [[ 0, "desc" ]],
         "columnDefs": [
                        {"className": "dt-center", "targets": "_all"}
            ]

        } );

}

function load_acct_manager_dropdown()
{
      var full_url = window.location.origin;
            $.ajax({
                url: full_url+'/controller/manage_gateway_controller.php',
                type: 'post',
                    cache: false,
                data:'list_type=acct_manager_dropdown',
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
                        Swal.fire({icon: 'error',title: 'Oops...',text: 'Please add account manager first!!!!'});
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




function load_role_dropdown()
{
    
      var full_url = window.location.origin;
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