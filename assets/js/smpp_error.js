$(function(){




load_gateway_dropdown();

load_smpp_error_details();

	$("#save_empp_error").click(function(){

			    var full_url = window.location.origin;

			$.ajax({
                url: full_url+'/controller/manage_gateway_controller.php',
                type: 'post',
                cache: false,
                data:$("#smpp_error_form").serialize(),
                success: function(data){

                    alert(data);
                    // console.log(data);
                    location.reload();
                 
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });



		});


        $("#upload_empp_error").click(function(){

     //console.log("Event triggered");
     var file_input = $('#upload_error_code');
     // console.log("File input element:", file_input);
      var file_data = file_input.prop('files');
     // console.log("File data:", file_data);
          var file_data = $('#upload_error_code').prop('files')[0];
          var gateway_id=$("#upload_gateway_id").val();

    
            if(file_data != undefined) {
                var full_url = window.location.origin;
                var form_data = new FormData();     
                    
                form_data.append('upload_error_code', file_data);
                form_data.append('gateway_id', gateway_id);
                
                form_data.append('type','upload_error_code');
                $.ajax({
                    type: 'POST',
                     url: full_url+"/controller/manage_gateway_controller.php",
                    contentType: false,
                    processData: false,
                    cache: false,
                    data: form_data,
                    success:function(response) {
                       response=response.trim();
                       console.log(response);
                      if(response == 'success') {
                             
                            Swal.fire("Successful !", 'File uploaded successfully', "success").then((value) => {
                                 $('#upload_smpp_error_modal').modal('hide');
                              window.location.href="dashboard.php?page=smpp_error_code";
                            });

                            
                        }
                        else if(response==0)
                        {
                             Swal.fire({icon: 'error',title: 'Oops...Something went wrong. ',text: 'Failed to upload error code'})
                            return false;
                        }
                         else {
                            Swal.fire({icon: 'error',title: 'Oops...Something went wrong. ',text: response})
                            return false;
                           // alert('Something went wrong. Please try again.');
                        }
  
                        $('#upload_error_code').val('');
                    }
                });
            }
            return false;



    });



})


function load_gateway_dropdown()
{
    

    var full_url = window.location.origin;
            $.ajax({
                url: full_url+'/controller/manage_gateway_controller.php',
                type: 'post',
                cache: false,
                dataType:'json',
                data:'list_type=load_gateway_dropdown',
                success: function(data){
                console.log(data);
                   if(data!=0)
                   {

                        var input1 = document.querySelector("input[name=upload_gateway_id_dropdown]");
                        console.log(input1);
                        var whitelist1 = [];
                        data.forEach(function(item) {
                        // Create an object with both sid and senderid properties
                        var whitelistItem1 = {
                            value: item.gateway_name,
                            uid: item.gateway_id
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
                   document.getElementById('upload_gateway_id').value = firstSelectedSid1;
                  
                   
                   // $('.gateway_id').append(data);
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}

function load_smpp_error_details()
{
    

    var full_url = window.location.origin;
            $.ajax({
                url: full_url+'/controller/manage_gateway_controller.php',
                type: 'post',
                cache: false,
                data:'list_type=load_smpp_error_details',
                success: function(data){
                    $('#smpp_error_code_list').empty();
                   if(data!=0)
                   {
                   
                    $('#smpp_error_code_list').append(data);
                    // $.fn.dataTable.moment('DD-MMM-YYYY hh:mm a');
                    $("#smpp_error_code").DataTable({
                        "order": [[4, "desc"]] // Assuming "created date" is the 5th column (index 4)
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