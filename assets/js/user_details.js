$(function(){

load_route_dropdown();
//load_acct_manager_dropdown();
load_role_dropdown();

    $(".user_access").css('display','none');

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
                routes: "required",

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
                routes: "Please select Route",
                
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
             /*   if(acct_manager=='')
                {
                    Swal.fire({icon: 'error',title: 'Oops....',text: 'Please Select Account Manager!!!!'})
                   
                }
                else
                {*/
                        $.ajax({
                        url: full_url+'/controller/user_controller.php',
                        type: 'post',
                        cache: false,
                        data:$("#add_user_form").serialize(),
                        success: function(data){
                            // alert(data);
                            // console.log(data);
                            if(data==0)
                            {
                                Swal.fire({icon: 'error',title: 'Oops...',text: 'Failed to add user details'});
                            }
                            else if(data==1)
                            {
                                Swal.fire("Successfull!", "New User Added!", "success").then((value) => {
                                  window.location.href=full_url+"/dashboard.php?page=manage_user";
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
                //}


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
                        var selected_role=$("#selected_user_role").val().trim();
                        
                        if(selected_role=='mds_sub_usr')
                        {
                            $(".user_access").css('display','block');
                        }
                        else
                        {
                            $(".user_access").css('display','none');
                        }
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

                       
                        if(data==1)
                        {
                            Swal.fire("Successfull!", "New Account Manager Added!", "success").then((value) => {
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
                data:'list_type=add_route_dropdown',
                dataType:'json',
                success: function(data){
             
                   if(data!=0)
                   {
                    var res = JSON.parse(JSON.stringify(data));
                    // console.log(data);
                    var whitelist = [];

                    data.forEach(function(item) {
                        // Create an object with both sid and senderid properties
                        var whitelistItem = {
                            value: item.route_name,
                            sid: item.route_id
                        };
                        // Add the object to the whitelist array
                        whitelist.push(whitelistItem);
                    });
                    
                    // Whitelist now contains the desired values
                    console.log(whitelist);
                    
                    // Select the input field for Tagify
                    var input = document.querySelector('input[name="routes"]');
                    
                // Check if Tagify is already initialized on the input field
                    if (input.tagify) {
                        input.tagify.removeAllTags();
                        // Update whitelist and show dropdown
                        input.tagify.settings.whitelist = whitelist;
                       
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

                        //  var preselectedValues = whitelist2.map(function(item) {
                        //     return { value: item.value, sid: item.sid };
                        // });
                        // input.tagify.addTags(preselectedValues);

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
                    updateSelectedSids();

                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}

// function load_acct_manager_dropdown()
// {
//       var full_url = window.location.origin;
//             $.ajax({
//                 url: full_url+'/controller/manage_gateway_controller.php',
//                 type: 'post',
//                 cache: false,
//                 data:'list_type=add_form_acct_manager_dropdown',
//                 success: function(data){
//                // alert(data);
//                    if(data!=0)
//                    {
//                     //$('#route').empty();
//                     $('#acct_manager').html(data);

// /*
//                                    $('#acct_manager').multiselect({
//                             columns: 1,
//                             placeholder: 'Select Account Manager',
//                             search: true,
//                             selectAll: true
//                         });*/
//                    }
//                   /* else
//                    {
//                         Swal.fire({icon: 'error',title: 'Oops...',text: 'Please add account manager first!!!!'});
//                         $('#acct_manager').multiselect({
//                             columns: 1,
//                             placeholder: 'Select Account Manager',
//                             search: true,
//                             selectAll: true
//                         });
//                    }*/
                    
//                 },
//                 error: function (xhr, ajaxOptions, thrownError) {
//                     var errorMsg = 'Ajax request failed: ' + xhr.responseText;
//                     alert(errorMsg);
//                     //$('#content').html(errorMsg);
//                   }
//             });
// }




function load_role_dropdown()
{
    
      var full_url = window.location.origin;
            $.ajax({
                url: full_url+'/controller/user_controller.php',
                type: 'post',
                cache: false,
                data:'list_type=role_dropdown',
                success: function(data){
                //alert(data);
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