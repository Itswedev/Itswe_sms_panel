var $ = jQuery.noConflict();
$( document ).ready(function(){
            //Perform Ajax request.
              load_username_dropdown();
              load_username_dropdown2();
              load_sender_id();
              $("#username_sender").change(function(){
                load_sender_id();
              });
              $("#edit_username_sender").change(function(){
                var edit_userid=$("#edit_username_senderid").val();
                
                load_sender_id2(edit_userid);
              });
          
            load_template_list();
            /*$('#sender_id').multiselect({
                columns: 1,
                placeholder: 'Select Sender Id',
                search: true,
                selectAll: true
            });*/


        $('.add-variable').on('click', function(){
            var txtData  = $("#add_mbl1");
            var caretPos = txtData[0].selectionStart;
            var tempmsg = document.getElementById("add_mbl1").value;
            var v = tempmsg.substring(0, caretPos) + '{#var#}' + tempmsg.substring(caretPos);
            $('#add_mbl1').val(v);
        });


        
    $("#download_temp").click(function(){

        var full_url = window.location.origin+"/itswe_sms_app";
        $.ajax({
            url: full_url + "/controller/template_function.php",
            type: 'POST',
            data: {
                type: 'all_template_download',
                export: 'excel',
                draw: 1 // Pass the draw counter from DataTables
            },
            success: function (response) {
                var blob = new Blob([response]);
                if (window.navigator.msSaveOrOpenBlob) {
                    window.navigator.msSaveBlob(blob, 'template.xls');
                } else {
                    var downloadUrl = URL.createObjectURL(blob);
                    var a = document.createElement("a");
                    a.href = downloadUrl;
                    a.download = 'template.xls';
                    document.body.appendChild(a);
                    a.click();
                    URL.revokeObjectURL(downloadUrl);
                    $(a).remove();
                }
            }
        });

    });


$(document).on( "click", '.delete_template_btn',function(e) {
  
    var id = $(this).data('id');


           swal.fire({
  title: 'Are you sure?',
  text: "You want to delete this template!",
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
                                        url: full_url+'/controller/template_function.php',
                                        type: 'post',
                                        cache: false,
                                        data:'type=delete_template&tempid='+id,
                                        success: function(data){
                                           data=data.trim();
                                           if(data==1)
                                           {
                                                swal.fire('','Template Details Deleted Successfully!!','success').then((value) => {

                                                load_template_list();
                                                    });
                                           }
                                           else
                                           {
                                                swal.fire({
                                                  icon: 'error',
                                                  title: 'Oops...',
                                                  text: 'Failed to delete template details!'
                                                  
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



$(document).on( "click", '.edit_template_btn',function(e) {
   
  
    var id = $(this).data('id');
    var temp_name = $(this).data('tempname');
    var sender_id=$(this).data('senderid');
    var peid=$(this).data('peid');
    var templateid=$(this).data('templateid');
   /* var templatecontent=$(this).data('templatecontent');*/
    var content_type=$(this).data('contenttype');

    var category_type=$(this).data('categorytype');
    var senderids=sender_id.toString().split(',');
    var edit_userid=$(this).data('edit_userid');
    load_edit_username_dropdown(edit_userid);
    //alert(sender_id);
    $("#tempid").val(id);
    $("#edit_template_name").val(temp_name);
/*    $("#edit_PE_ID").val(peid);*/
    $("#edit_Template_ID").val(templateid);
/*    $("#edit_mbl1").val(templatecontent);*/
    $(`#edit_content_type option[value='${content_type}']`).prop('selected', true);
    $(`#edit_category_type option[value='${category_type}']`).prop('selected', true);
    load_sender_id2(edit_userid,senderids);
    // $(`#edit_sender_id option:selected`).prop('selected', false); 
    // for(var i=0;i<senderids.length;i++)
    // {
    //    $(`#edit_sender_id option[value='${senderids[i]}']`).prop('selected', true); 
    // }

//  $('#edit_sender_id').multiselect({
//                             columns: 1,
//                             placeholder: 'Select Sender Id',
//                             search: true,
//                             selectAll: true
//                         });
 var full_url = window.location.origin+"/itswe_sms_app";

                        $.ajax({
                            url: full_url+'/controller/template_function.php',
                            type: 'post',
                            cache: false,
                            data:'type=display_content&tempid='+id,
                            success: function(data){

                                data=data.trim();
                               if(data!=0)
                                {
                                    
                                   $("#edit_mbl1").val(data);
                                }
                                else
                                {
                                    swal.fire({
                                                icon: 'error',
                                                title: 'Oops...',
                                                text: 'Template Not available!'            
                                            });
                                }
                             
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                                alert(data);
                                //$('#content').html(errorMsg);
                              }
                        });
/*
    $('#edit_sender_id').multiselect({
    columns: 1,
    placeholder: 'Select Sender Id',
    search: true,
    selectAll: true
});*/

    
   
});

    $("#save_template").click(function(){

    

            $( "#addtemplateForm" ).validate( {
            rules: {
                template_name: "required",
               
                Template_ID: "required",
                content_type: "required",
                category_type: "required",
                sender_id: "required",
                mbl1: "required", 
               


            },
            messages: {
                template_name: "Please enter Username",
               
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
                                    data=data.trim();
                               /*console.log(data);*/
                               if(data==1)
                                {
                                    Swal.fire("Successful !",'Template details added successfully','success').then((value) => {
                                     $("#create_template_modal").modal('hide');

                                                 $("#addtemplateForm").trigger('reset');
                                         window.location.reload(full_url+'/view/include/modal_forms/template_modal.php');
                                                load_template_list();
                                    });
                                        
                                }
                                else if(data==2)
                                {
                                    swal.fire({
                                                icon: 'error',
                                                title: 'Sorry...',
                                                text: 'Template name already exists!'            
                                            });
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
                                alert(errorMsg);
                                //$('#content').html(errorMsg);
                              }
                        });
               }

            return false;
        }

        } );

    });



    $("#update_template").click(function(){

    

            $( "#updatetemplateForm" ).validate( {
            rules: {
                edit_template_name: "required",
                
                edit_Template_ID: "required",
                edit_content_type: "required",
                edit_category_type: "required",
                edit_sender_id: "required",
                edit_mbl1: "required", 
               


            },
            messages: {
                edit_template_name: "Please enter Username",
               
                edit_Template_ID: "Please enter your mobile number",
                edit_content_type: "Please enter your full name",
                edit_category_type: "Please enter your full name",
                edit_sender_id: "Please enter your full name",
                edit_mbl1: "Please enter your full name",
                
                
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

                if ($('#edit_sender_id').val()== '') {
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
                            data:$("#updatetemplateForm").serialize(),
                            success: function(data){
                                data=data.trim();

                                if(data!=0)
                                {
                                    swal.fire("Successfull!", 'Template Details Updated Successfully', "success");
                                        $("#edit_template_modal").modal('hide');
                                        $("#updatetemplateForm").trigger('reset');
                                 window.location.reload(full_url+'/view/include/modal_forms/template_modal.php');
                                        load_template_list();
                                }
                                else
                                {
                                    swal.fire({
                                                icon: 'error',
                                                title: 'Oops...',
                                                text: 'Failed to update template details!'            
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


        $("#upload_template_btn").click(function(){
          var file_data = $('#upload_template').prop('files')[0];

            if(file_data != undefined) {
                var full_url = window.location.origin+"/itswe_sms_app";
                var form_data = new FormData();     
                    
                form_data.append('upload_template', file_data);
                form_data.append('type','upload_template');
                var userid=$("#username_senderid2").val();
                form_data.append('selected_userid', userid);
                $.ajax({
                    type: 'POST',
                     url: full_url+"/controller/template_function.php",
                    contentType: false,
                    processData: false,
                    cache: false,
                    data: form_data,
                    success:function(response) {
                       response=response.trim();
                       console.log(response);
                      if(response == 'success') {
                             
                            Swal.fire("Successful !", 'File uploaded successfully', "success").then((value) => {
                                 $('#upload_template_modal').modal('hide');
                              window.location.href="dashboard.php?page=template";
                            });

                            
                        }
                        else if(response==0)
                        {
                             Swal.fire({icon: 'error',title: 'Oops...Something went wrong. ',text: 'Failed to upload template'})
                            return false;
                        }
                         else {
                            Swal.fire({icon: 'error',title: 'Oops...Something went wrong. ',text: response})
                            return false;
                           // alert('Something went wrong. Please try again.');
                        }
  
                        $('#upload_template').val('');
                    }
                });
            }
            return false;
    });

});

function load_username_dropdown()
{
   


        var full_url = window.location.origin+"/itswe_sms_app";
            $.ajax({
                url: full_url+'/controller/user_controller.php',
                type: 'post',
                cache: false,
                dataType:'json',
                data:'list_type=dropdown_user_search&page=add_credit',
                success: function(data){
                   
                
                   if(data!=0)
                   {
                     //console.log(data);

                    var input1 = document.querySelector("input[name=username_sender]");
                     console.log(input1);
                    var whitelist1 = [];
                    data.forEach(function(item) {
                        // Create an object with both sid and senderid properties
                        var whitelistItem1 = {
                            value: item.user_name,
                            uid: item.userid
                        };
                        // Add the object to the whitelist array
                        whitelist1.push(whitelistItem1);
                    });

                   console.log(whitelist1);
                   

                    tagify1 = new Tagify(input1, {
                        enforceWhitelist: true,
                        mode: "select",
                        whitelist: whitelist1,
                        blacklist: ["foo", "bar"],
                      });

                      tagify1.on('add', function(e) {
                        updateSelectedSids();
                    });

                    // Listen for 'remove' event on Tagify to update selected sids
                    tagify1.on('remove', function(e) {
                        updateSelectedSids();
                    });
             
                   }
                   updateSelectedSids();

                   function updateSelectedSids() {
                    // console.log('call update');
                    // console.log(tagify1);
                    var selectedSids1 = tagify1.value.map(function(tagData1) {
                       
                       // console.log(tagData1.uid);
                        return tagData1.uid;
                    });
                    // Get the first element of the array (if exists)
                    var firstSelectedSid1 = selectedSids1.length > 0 ? selectedSids1[0] : null;
                    document.getElementById('username_senderid').value = firstSelectedSid1;
                    
                }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
}


// function load_username_dropdown()
// {
//         var full_url = window.location.origin+"/itswe_sms_app";
//             $.ajax({
//                 url: full_url+'/controller/user_controller.php',
//                 type: 'post',
//                 cache: false,
//                 data:'list_type=dropdown_user&page=add_credit',
//                 success: function(data){
//                    data=data.trim();
//                    if(data!=0)
//                    {
//                     $('#username_senderid').empty();
//                     $('#username_senderid').html(data);

//                 //    $("#username_senderid").chosen(); 
//                    $("#username_senderid_chosen").css('width','100%');


                 

//                    }
                    
//                 },
//                 error: function (xhr, ajaxOptions, thrownError) {
//                     var errorMsg = 'Ajax request failed: ' + xhr.responseText;
//                     alert(errorMsg);
//                     //$('#content').html(errorMsg);
//                   }
//             });
// }



function load_username_dropdown2()
{
   


        var full_url = window.location.origin+"/itswe_sms_app";
            $.ajax({
                url: full_url+'/controller/user_controller.php',
                type: 'post',
                cache: false,
                dataType:'json',
                data:'list_type=dropdown_user_search&page=add_credit',
                success: function(data){
                    //console.log(data);
                
                   if(data!=0)
                   {
                    // console.log(data);

                    var input1 = document.querySelector("input[name=username_senderids2]");
                    var whitelist1 = [];
                    data.forEach(function(item) {
                        // Create an object with both sid and senderid properties
                        var whitelistItem1 = {
                            value: item.user_name,
                            uid: item.userid
                        };
                        // Add the object to the whitelist array
                        whitelist1.push(whitelistItem1);
                    });
                  

                    var tagify1 = new Tagify(input1, {
                        enforceWhitelist: true,
                        mode: "select",
                        whitelist: whitelist1,
                        blacklist: ["foo", "bar"],
                      });

                      tagify1.on('add', function(e) {
                        updateSelectedSids2();
                    });

                    // Listen for 'remove' event on Tagify to update selected sids
                    tagify1.on('remove', function(e) {
                        updateSelectedSids2();
                    });
             
                   }
                   updateSelectedSids2();

                   function updateSelectedSids2() {
                    // Check if the element with ID 'username_senderid2' exists
                    var usernameSenderid2Input = document.getElementById('username_senderid2');
                    if (usernameSenderid2Input) {
                        // Continue with setting its value if it exists
                        if (Array.isArray(tagify1.value)) {
                            var selectedSids = tagify1.value.map(function(tagData) {
                                return tagData.uid;
                            });
                            // Get the first element of the array (if exists)
                            var firstSelectedSid = selectedSids.length > 0 ? selectedSids[0] : null;
                            // Set the value of the element
                            usernameSenderid2Input.value = firstSelectedSid;
                        } else {
                            // Handle the case where tagify1.value is not an array (e.g., no tags selected)
                            usernameSenderid2Input.value = null;
                        }
                    } else {
                        // Handle the case where the element with ID 'username_senderid2' does not exist
                        console.error("Element with ID 'username_senderid2' not found.");
                    }
                }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
}


function load_edit_username_dropdown(edit_userid)
{
   
// console.log(edit_userid);

        var full_url = window.location.origin+"/itswe_sms_app";
            $.ajax({
                url: full_url+'/controller/user_controller.php',
                type: 'post',
                cache: false,
                dataType:'json',
                data:'list_type=dropdown_user_search&page=add_credit',
                success: function(data){
                    //console.log(data);
                
                   if(data!=0)
                   {
                    // console.log(data);

                    var input1 = document.querySelector("input[name=edit_username_sender]");
                    var whitelist1 = [];
                    var preselectedTags = [];
                    data.forEach(function(item) {
                        // Create an object with both sid and senderid properties
                        var whitelistItem1 = {
                            value: item.user_name,
                            uid: item.userid
                        };
                        // Add the object to the whitelist array
                        whitelist1.push(whitelistItem1);
                        // console.log('edit_userid:', edit_userid);
                        // console.log('item.userid:', item.userid+" "+item.user_name);

                        if (item.userid == edit_userid) {
                           // console.log('true edit');
                            // Mark this item as selected by adding a 'selected' property
                            //whitelistItem1.selected = true;
                            preselectedTags.push(whitelistItem1);

                           // console.log(preselectedTags);
                        }
                    });
                  

                    var tagify1 = new Tagify(input1, {
                        enforceWhitelist: true,
                        mode: "select",
                        whitelist: whitelist1,
                        blacklist: ["foo", "bar"],
                      });

                    
                        // Add pre-selected tags after Tagify is initialized
                        if (preselectedTags.length > 0) {

                            //console.log('inside preselected');
                            tagify1.addTags(preselectedTags);
                        }
                    

                      tagify1.on('add', function(e) {
                        updateSelectedSids2();
                    });

                    // Listen for 'remove' event on Tagify to update selected sids
                    tagify1.on('remove', function(e) {
                        updateSelectedSids2();
                    });
             
                   }
                   updateSelectedSids2();

                   function updateSelectedSids2() {
                    // Check if the element with ID 'username_senderid2' exists
                    var usernameSenderid2Input = document.getElementById('edit_username_senderid');
                    if (usernameSenderid2Input) {
                        // Continue with setting its value if it exists
                        if (Array.isArray(tagify1.value)) {
                            var selectedSids = tagify1.value.map(function(tagData) {
                                return tagData.uid;
                            });
                            // Get the first element of the array (if exists)
                            var firstSelectedSid = selectedSids.length > 0 ? selectedSids[0] : null;
                            // Set the value of the element
                            usernameSenderid2Input.value = firstSelectedSid;
                        } else {
                            // Handle the case where tagify1.value is not an array (e.g., no tags selected)
                            usernameSenderid2Input.value = null;
                        }
                    } else {
                        // Handle the case where the element with ID 'username_senderid2' does not exist
                        console.error("Element with ID 'edit_username_senderid' not found.");
                    }
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

    var userid=$("#username_senderid").val();
    var full_url = window.location.origin+"/itswe_sms_app";


    $.ajax({
                url: full_url+'/controller/template_function.php',
                type: 'post',
                cache: false,
                dataType:'json',
                data:'template_type=load_sender_values&selected_userid='+userid,
                success: function(data){
                    var res = JSON.parse(JSON.stringify(data));
                    console.log(res);

                    // Initialize an empty array to store the whitelist data
                    var whitelist = [];


                    data.forEach(function(item) {
                        // Create an object with both sid and senderid properties
                        var whitelistItem = {
                            value: item.senderid,
                            sid: item.sid
                        };
                        // Add the object to the whitelist array
                        whitelist.push(whitelistItem);
                    });
                    
                    // Select the input field for Tagify
                    var input = document.querySelector('input[name="senderids"]');
                    
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

                        // Store Tagify instance in input.tagify
                        input.tagify = tagify;

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
                        var selectedSids = tagify.value.map(function(tagData) {
                            return tagData.sid;
                        });
                        document.getElementById('sender_id').value = JSON.stringify(selectedSids);
                    }

                
                    updateSelectedSids();
                    
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
}


function load_sender_id2(edit_userid,senderids)
{
    
    var userid=edit_userid;
    var full_url = window.location.origin+"/itswe_sms_app";


    $.ajax({
                url: full_url+'/controller/template_function.php',
                type: 'post',
                cache: false,
                dataType:'json',
                data:'template_type=load_sender_values&selected_userid='+userid,
                success: function(data){

                 
                    var res = JSON.parse(JSON.stringify(data));
                   
                    // Initialize an empty array to store the whitelist data
                    var whitelist = [];
                    var preselectedValues = [];
                    var tagify;
                   // preselectedValues=senderids;
                    // console.log(preselectedValues);

                    data.forEach(function(item) {
                        // Create an object with both sid and senderid properties
                        var whitelistItem = {
                            value: item.senderid,
                            sid: item.sid
                        };
                        // Add the object to the whitelist array
                        whitelist.push(whitelistItem);


                        if (senderids.includes(item.sid)) {
                            // Add this item to the preselected values array
                            preselectedValues.push(whitelistItem);
                        }


                    });


            
                    
                    // Select the input field for Tagify
                    var input = document.querySelector('input[name="edit_sender_id"]');
                    
                // Check if Tagify is already initialized on the input field
                    if (input.tagify) {
                        input.tagify.removeAllTags();
                        // Update whitelist and show dropdown
                        input.tagify.settings.whitelist = whitelist;
                        input.tagify.addTags(preselectedValues);
                       // input.tagify.dropdown.showDropdown(); // Corrected method name
                    } else {
                        // Initialize Tagify
                        tagify = new Tagify(input, {
                            whitelist: whitelist,
                            maxTags: 10,
                            dropdown: {
                                maxItems: 20,
                                classname: "tags-look",
                                enabled: 0,
                                closeOnSelect: false
                            }
                        });

                        // Store Tagify instance in input.tagify
                        input.tagify = tagify;
                        // var preselectedValues = whitelist.map(function(item) {
                        //     return { value: item.value, sid: item.sid };
                        // });
                        // console.log('preseelcted');
                        // console.log(preselectedValues);
                        if (preselectedValues.length > 0) {

                            console.log('inside preselected');
                            console.log(preselectedValues);
                            tagify.addTags(preselectedValues);
                        }
                        
                        // console.log('edit senderid');
                        // console.log(whitelist);
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

                        
                        document.getElementById('edit_sender_id_hidden').value = JSON.stringify(selectedSids);
                    }

                
                    updateSelectedSids();
                    
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
}
function load_template_list()
{

var full_url = window.location.origin+"/itswe_sms_app";
var user_role=$("#user_role").val();

if(user_role!='mds_adm')
{
     $('#template_list_tbl').DataTable({
        "processing": true,
        "serverSide": true,
        "responsive": true,
         "ajax": {
                    "type":"POST",
                    "url":full_url+"/controller/template_function.php",
                    "data":function (post) {
                            post.type='list_all_template';
                        }          
         },
         "order": [[ 7, "desc" ]],
         language: {
			paginate: {
				next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
			  previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>' 
			}
		},
         "columnDefs": [
                        {"className": "dt-center", "targets": "_all"},
                        { targets: '_all', className: 'wrap' }
                       
                        
            ],
          "bDestroy": true

        });

}
else
{
     $('#template_list_tbl').DataTable({
        "processing": true,
        "serverSide": true,
        "responsive": true,
         "ajax": {
                    "type":"POST",
                    "url":full_url+"/controller/template_function.php",
                    "data":function (post) {
                            post.type='list_all_template';
                        }          
         },
         "order": [[ 6, "desc" ]],
         "columnDefs": [
                        {"className": "dt-center", "targets": "_all"},
                        { targets: '_all', className: 'wrap' },
                        
                        
            ],
            
          "bDestroy": true

        });

}

       


       /* var full_url = window.location.origin+"/itswe_sms_app";
     $.ajax({
                url: full_url+'/controller/template_function.php',
                type: 'post',
                data:'type=list_template',
                success: function(data){
                   // console.log(data);
                   if(data!=0)
                   {
                    $('#template_list').html(data);
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });*/

}

function addTemplate() {
       
        if ($('#template_name').val().trim() == '') {
             
        action_message1('Please enter template name', 'error');
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
            data=data.trim();
           
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

                    load_template_dropdown();
                }
                action_message('Template succesfully created.', 'success');
                $('#template_list').html(data);
                $('#create_template_modal').modal('hide');
                //load_data();
            }
        }
    });
}


function load_template_dropdown()
{

        var full_url = window.location.origin+"/itswe_sms_app";
     $.ajax({
                url: full_url+'/controller/template_function.php',
                type: 'post',
                cache: false,
                data:'template_type=load_template_dropdown',
                success: function(data){
                   // console.log(data);
                    data=data.trim();
                   if(data!=0)
                   {
                    $('#template').append('<option value="">Select Template</option>');
                    $('#template').append(data);
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });

}

function action_message1(msg, type) {
    if (type == 'success') {
        var message = '<span class="asm">' + msg + '</span>';
        $('#action_message').html(message);
        $('#action_message').show();
        $("#action_message").fadeOut(5000);
        // return false;
    }
    if (type == 'error') {
        var message = '<span class="awm">' + msg + '</span>';
        $('#action_message_error_temp').html(message);
        $('#action_message_error_temp').show();
        $("#action_message_error_temp").fadeOut(5000);
        // return false;
    }
}