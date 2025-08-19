var $ = jQuery.noConflict();
$( document ).ready(function(){
            //Perform Ajax request.
           load_data();
           load_username_dropdown();
           load_username_dropdown2();

$(document).on( "click", '.edit_senderid_btn',function(e) {
  
    var id = $(this).data('id');
    var sender_id=$(this).data('senderid');
    var peid=$(this).data('peid');
    var headerid=$(this).data('headerid');
    var descript=$(this).data('descript');
    var status=$(this).data('status');

    //alert(sender_id);
    $("#s_id").val(id);
    $("#edit_senderid_id").val(sender_id);
    $("#edit_PE_ID").val(peid);
    $("#edit_Header_ID").val(headerid);
    $("#edit_descript").val(descript);
      $(`#senderid_status option[value='${status}']`).prop('selected', true);
   
});

$(document).on( "click", '.delete_btn',function(e) {
  
    var id = $(this).data('id');
           swal.fire({
  title: 'Are you sure?',
  text: "You want to delete this sender!",
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
                url: full_url+'/controller/sender_id_function.php',
                type: 'post',
                cache: false,
                data:'type=delete_sender&sid='+id,
                success: function(data){
                   
                 swal.fire('',data,'success').then((value) => {
                        load_data();
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




$("#addSenderId").click(function(){

               $( "#senderidsForm" ).validate({
                
                rules: {
                    senderid: "required",
                    PE_ID: "required",

                },
                messages: {
                    senderid: "Please enter Route name",
                    PE_ID: "Please select route",
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
            // alert('test');
                
            var full_url = window.location.origin+"/itswe_sms_app";

            var page_name=$(".page_name").text();
            $.ajax({
                url: full_url+'/controller/sender_id_function.php',
                type: 'post',
                cache: false,
                data:$("#senderidsForm").serialize(),
                success: function(data){
                    data=data.trim();
                    console.log(data);
                    if(data=='Success')
                        {
                             swal.fire('Success','Sender Id Added Successfully!!','success').then((value) => {
                                $('#exampleModal').modal('hide');
                                 $("#senderidsForm").trigger('reset');
                                 window.location.reload(full_url+'/view/include/modal_forms/sender_id_modal.php');
                                load_data();
                               
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


        }

        });


    });


    $(document).on('click', '#download_report_btn', function () {
      
        var table = $("#sender_id_tbl").DataTable({
            
        });
    
        // Store the current page info
        // var pageInfo = table.page.info();
    
        // // Disable pagination to ensure all rows are visible
        // table.page.len(-1).draw();
    
        // // Wait for the DataTable to finish loading all data
        // table.one('draw', function () {
        //     // Export all data to Excel
        //     $("#sender_id_tbl").table2excel({
        //         exclude: ".noExl",
        //         name: "Worksheet Name",
        //         filename: "Senderid Report", // do not include extension
        //         fileext: ".xls", // file extension
        //         exclude_img: true,
        //         exclude_links: true,
        //         exclude_inputs: true,
        //         onComplete: function() {
        //             console.log('download completed');
        //             // Re-enable pagination after export
        //             table.page.len(pageInfo.length).page(pageInfo.page).draw('page');
        //         }
        //     });
        // });
    
        // // Trigger a redraw to ensure the DataTable finishes loading all data
        // table.draw();
    });

    $("#download_senderid").click(function(){

        var full_url = window.location.origin+"/itswe_sms_app";
        $.ajax({
            url: full_url + "/controller/sender_id_function.php",
            type: 'POST',
            data: {
                sender_type: 'all_senderid_download',
                export: 'excel',
                draw: 1 // Pass the draw counter from DataTables
            },
            success: function (response) {
                var blob = new Blob([response]);
                if (window.navigator.msSaveOrOpenBlob) {
                    window.navigator.msSaveBlob(blob, 'senderid.xls');
                } else {
                    var downloadUrl = URL.createObjectURL(blob);
                    var a = document.createElement("a");
                    a.href = downloadUrl;
                    a.download = 'senderid.xls';
                    document.body.appendChild(a);
                    a.click();
                    URL.revokeObjectURL(downloadUrl);
                    $(a).remove();
                }
            }
        });

    });

        $("#upload_sender_btn").click(function(){
            //console.log("Event triggered");
        var file_input = $('#upload_sender');
       // console.log("File input element:", file_input);
        var file_data = file_input.prop('files');
       // console.log("File data:", file_data);
            var file_data = $('#upload_sender').prop('files')[0];
            var userid=$("#username_senderid2").val();

            console.log(userid);
              if(file_data != undefined) {
                  var full_url = window.location.origin+"/itswe_sms_app";
                  var form_data = new FormData();     
                      
                  form_data.append('upload_sender', file_data);
                  form_data.append('selected_userid', userid);
                  form_data.append('type','upload_sender');
                  $.ajax({
                      type: 'POST',
                       url: full_url+"/controller/sender_id_function.php",
                      contentType: false,
                      processData: false,
                      cache: false,
                      data: form_data,
                      success:function(response) {
                         response=response.trim();
                         console.log(response);
                        if(response == 'success') {
                               
                              Swal.fire("Successful !", 'File uploaded successfully', "success").then((value) => {
                                   $('#upload_sender_modal').modal('hide');
                                window.location.href="dashboard.php?page=senderid";
                              });
  
                              
                          }
                          else if(response==0)
                          {
                               Swal.fire({icon: 'error',title: 'Oops...Something went wrong. ',text: 'Failed to upload senderid'})
                              return false;
                          }
                           else {
                              Swal.fire({icon: 'error',title: 'Oops...Something went wrong. ',text: response})
                              return false;
                             // alert('Something went wrong. Please try again.');
                          }
    
                          $('#upload_sender').val('');
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
                   
                    console.log(data);
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
                   
                
                   if(data!=0)
                   {
                    // console.log(data);

                    var input = document.querySelector("input[name=username_senderids2]");
                    var whitelist = [];
                    data.forEach(function(item) {
                        // Create an object with both sid and senderid properties
                        var whitelistItem = {
                            value: item.user_name,
                            uid: item.userid
                        };
                        // Add the object to the whitelist array
                        whitelist.push(whitelistItem);
                    });
                   

                    tagify = new Tagify(input, {
                        enforceWhitelist: true,
                        mode: "select",
                        whitelist: whitelist,
                        blacklist: ["foo", "bar"],
                      });

                      tagify.on('add', function(e) {
                        updateSelectedSids2();
                    });

                    // Listen for 'remove' event on Tagify to update selected sids
                    tagify.on('remove', function(e) {
                        updateSelectedSids2();
                    });
             
                   }
                   updateSelectedSids2();

                   function updateSelectedSids2() {
                    var selectedSids = tagify.value.map(function(tagData) {
                        return tagData.uid;
                    });
                    // Get the first element of the array (if exists)
                    var firstSelectedSid = selectedSids.length > 0 ? selectedSids[0] : null;
                    document.getElementById('username_senderid2').value = firstSelectedSid;
                    
                }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
}






function load_data()
{
        var full_url = window.location.origin+"/itswe_sms_app";

        $('#sender_id_tbl').DataTable( {
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "info":true,
        
         "ajax": {
                    "type":"POST",
                    "url":full_url+"/controller/sender_id_function.php",
                    "data":function (post) {
                            post.sender_type='all_senderid';
                    

                           
                           
                        }
                  
         },
         "order": [[ getColumnIndex('Created Date'), "desc" ]],
         "bDestroy": true,
         "columnDefs": [
                        {"className": "dt-center", "targets": "_all"}
            ],
            

        });


  /*   $.ajax({
                url: full_url+'/controller/sender_id_function.php',
                type: 'post',
                data:'sender_type=all',
                success: function(data){
                    //console.log(data);
                   if(data!=0)
                   {
                    $('.sender_list').html(data);
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });*/

}

function getColumnIndex(columnName) {
    var table = $('#sender_id_tbl').DataTable();
    var columnIndex = -1;
    table.columns().every(function() {
        var column = this.header();
        if ($(column).text() === columnName) {
            columnIndex = this.index();
            return false; // Break the loop
        }
    });
    return columnIndex;
}

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

                action_message('SenderId succesfully created.', 'success');
               
                if(form_name=='bulk_sms')
                {
                    $("#sid").empty();

                    load_senderid_dropdown(form_name);
                }
                var page = $('.pactive').attr('p');


                $('#exampleModal').modal('hide');

                load_data();
            }
        }
    });
}


function editSenderIds() {
    
    if ($('#edit_senderid_id').val().trim() == '') {
        alert('Please enter senderid');
        return false;
    }
    if ($('#edit_senderid_id').val().trim().length != 6) {
        alert('Senderid must be 6 character only.');
        return false;
    }

    var full_url = window.location.origin+"/itswe_sms_app";
    $.ajax({
        type: "POST",
        url: full_url+"/controller/sender_id_function.php",
        data: $('#senderidsEditForm').serialize(),
        beforeSend: function () {
           // $('#createsenderid').html('<img src="assets/images/loading.gif" style="width:30%;" />');
        },
        success: function (data)
        {
            
            if (data == 'Already Exists') {
                $('#edit_senderid_id').val('');
                $('#edit_senderid_id').focus()
                alert('Sender ID already in used, please enter another');
            } else if (data == 'FALSE') {
                alert('failed! Contact Administrator');
            } else {
                $('a.close').trigger('click');
                var form_name=$("#form_name").val();
               // $('#senderidsEditForm')[0].reset();

                alert('SenderId succesfully updated.');
               
               
               


                $('#edit_sender_id').modal('hide');

                load_data();
            }
        }
    });
}


function load_senderid_dropdown(form_name)
{
        var full_url = window.location.origin+"/itswe_sms_app";
     $.ajax({
                url: full_url+'/controller/sender_id_function.php',
                type: 'post',
                cache: false,
                data:'sender_type=load_sender_dropdown',
                success: function(data){
                   // console.log(data);
                   if(data!=0)
                   {
                    $('#sid').append('<option value="">Sender Id</option>');
                    $('#sid').append(data);
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });

}


function action_message(msg, type) {
    if (type == 'success') {
        var message = '<span class="asm">' + msg + '</span>';
        $('#action_message').html(message);
        $('#action_message').show();
        $("#action_message").fadeOut(5000);
        // return false;
    }
    if (type == 'error') {
        var message = '<span class="awm">' + msg + '</span>';
        $('#action_message_error').html(message);
        $('#action_message_error').show();
        $("#action_message_error").fadeOut(5000);
        // return false;
    }
}