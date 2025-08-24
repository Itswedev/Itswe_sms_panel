$(function(){

load_username_dropdown();

    
function load_username_dropdown()
{
        //var full_url = window.location.origin;
            $.ajax({
                url: full_url+'/controller/user_controller.php',
                type: 'post',
                cache: false,
                dataType:'json', 
                data:'list_type=dropdown_user_search&page=add_credit',
                success: function(data){
                
                   if(data!=0)
                   {
                    var input = document.querySelector("input[name=usernames]");
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
                        updateSelectedSids();
                    });

                    // Listen for 'remove' event on Tagify to update selected sids
                    tagify.on('remove', function(e) {
                        updateSelectedSids();
                    });
             
                   }
                   updateSelectedSids();
                   function updateSelectedSids() {
                    var selectedSids = tagify.value.map(function(tagData) {
                        return tagData.uid;
                    });
                    // Get the first element of the array (if exists)
                    var firstSelectedSid = selectedSids.length > 0 ? selectedSids[0] : null;
                    document.getElementById('username').value = firstSelectedSid;
                }
                   

                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}

		$("#save_hash").click(function(){

			var userid=$("#username").val();
            var hash_val=$("#hash_value").val();
            

            if(userid!='' && hash_val!='')
            {
    

			$.ajax({
                url: full_url+'/controller/hash_controller.php',
                type: 'post',
                cache: false, 
                data:$("#create_hash_form").serialize(),
                success: function(data){

                    if(data==1)
                    {
                        swal.fire('','Hash Details Added Successfully','success').then((value) => {

                                $("#add_plan").modal('hide');
                               // load_all_plan();
                            });  
                    }
                    else if(data==2)
                    {
                        swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Failed To Create Hash Details!'
                          
                        }).then((value) => {
                              return false;
                                    });
                    }
                    else if(data==0)
                    {
                        swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Hash Name Already Exists!'
                          
                        }).then((value) => {
                              return false;
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
    else
    {
         swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Please Enter Hash Value!'
                          
                        }).then((value) => {
                              return false;
                                    });
    }


		});


//         $("#edit_plan_btn").click(function(){

//             var p_name=$("#edit_p_name").val();

//              if (p_name.trim() == '') {
//                swal.fire({
//                   icon: 'error',
//                   title: 'Oops...',
//                   text: 'Please Enter Plan name!'
                  
//                 }).then((value) => {
//                       return false;
//                             });
                
//             }
//             else
//             {   

//     //var full_url = window.location.origin;
//                 $.ajax({
//                     url: full_url+'/controller/plan_controller.php',
//                     type: 'post',
//                     cache: false, 
//                     data:$("#edit_plan_form").serialize(),
//                     success: function(data){

//                         if(data==1)
//                         {
//                              swal.fire('','Plan Details Updated Successfully!!','success').then((value) => {
//                                 $('#edit_plan').modal('hide');
//                                 load_all_plan();
//                             });
                  
//                         }
//                         else
//                         {
//                              swal.fire({
//                               icon: 'error',
//                               title: 'Oops...',
//                               text: 'Failed to Update Plan Details!'
                              
//                             });
//                         }
                       
                     
                        
//                     },
//                     error: function (xhr, ajaxOptions, thrownError) {
//                         var errorMsg = 'Ajax request failed: ' + xhr.responseText;
//                         alert(data);
//                         //$('#content').html(errorMsg);
//                       }
//                 });

//             }




//         });

//         $(document).on( "click", '.edit_plan',function(e) {
  
//             var id = $(this).data('id');
//             var plan_name=$(this).data('plan');
//             var status=$(this).data('status');
//             $(`#edit_plan_status option[value='${status}']`).prop('selected', true);
          
           
//             $("#pid").val(id);
//             $("#edit_p_name").val(plan_name);
          
   
//         });


//         $(document).on( "click", '.delete_plan_btn',function(e) {
  
//     var id = $(this).data('id');

//            swal.fire({
//   title: 'Are you sure?',
//   text: "You want to delete this plan!",
//   icon: 'warning',
//   showCancelButton: true,
//   confirmButtonColor: '#2c7be5',
//   cancelButtonColor: '#748194',
//   confirmButtonText: 'Yes',
//   showClass: {
//     popup: 'animate__animated animate__heartBeat'
//   },
//   hideClass: {
//     popup: 'animate__animated animate__fadeOutUp'
//   }
// }).then((result) => {
//   if (result.isConfirmed) {
//     //var full_url = window.location.origin;
//                             $.ajax({
//                                         url: full_url+'/controller/plan_controller.php',
//                                         type: 'post',
//                                         cache: false, 
//                                         data:'list_type=delete_plan&pid='+id,
//                                         success: function(data){
                                           
//                                            if(data==1)
//                                            {
//                                                 swal.fire('','Plan Details Deleted Successfully!!','success').then((value) => {
//                                                 load_all_plan();
//                                                     });
//                                            }
//                                            else
//                                            {
//                                                 swal.fire({
//                                                   icon: 'error',
//                                                   title: 'Oops...',
//                                                   text: 'Failed to delete plan details!'
                                                  
//                                                 });
//                                            }
                                         
                                          
                                            
//                                         },
//                                         error: function (xhr, ajaxOptions, thrownError) {
//                                             var errorMsg = 'Ajax request failed: ' + xhr.responseText;
//                                             alert(data);
//                                             //$('#content').html(errorMsg);
//                                           }
//                                     });
//                         }
//                 });

   
//     });

});

