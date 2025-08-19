(function ($) {
    "use strict";
    $(document).ready(function () {
     
        var full_url = window.location.origin+"/itswe_sms_app";
        
        $("#sender_id_tbl").DataTable({
            dom: "Bfrtip",
            buttons: [
                {
                    extend: 'excelHtml5',
                    action: function (e, dt, button, config) {
                        $.ajax({
                            url: full_url + "/controller/sender_id_function1.php",
                            type: 'POST',
                            data: {
                                sender_type: 'all_senderid_download',
                                export: 'excel',
                                draw: 1 // Pass the draw counter from DataTables
                            },
                            success: function (response) {
                                var blob = new Blob([response]);
                                if (window.navigator.msSaveOrOpenBlob) {
                                    window.navigator.msSaveBlob(blob, 'filename.xls');
                                } else {
                                    var downloadUrl = URL.createObjectURL(blob);
                                    var a = document.createElement("a");
                                    a.href = downloadUrl;
                                    a.download = 'filename.xls';
                                    document.body.appendChild(a);
                                    a.click();
                                    URL.revokeObjectURL(downloadUrl);
                                    $(a).remove();
                                }
                            }
                        });
                    }
                }
            ],
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "info": true,
            "ajax": {
                "type": "POST",
                "url": full_url + "/controller/sender_id_function1.php",
                "data": function (post) {
                    post.sender_type = 'all_senderid';
                }
                
            }
        });
      
    });
})(jQuery);
  

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