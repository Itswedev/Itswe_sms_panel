$(function(){
	load_number_block_dtls();

load_username_dropdown();

	$("#single_btn").click(function(){

		$("#multiple_section").addClass('d_none');
		$("#single_section").removeClass('d_none');
		$("#upload_type").val('single');
	});

	$("#multiple_btn").click(function(){

		$("#multiple_section").removeClass('d_none');
		$("#single_section").addClass('d_none');
		$("#upload_type").val('multiple');
	});







});



        $(document).on( "click", '.delete_btn',function(e) {
  
    var id = $(this).data('id');

   
           swal.fire({
  title: 'Are you sure?',
  text: "You want to delete this Mobile Number!",
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
        //var full_url = window.location.origin;

                            $.ajax({
                                        url: full_url+'/controller/number_block_controller.php',
                                        type: 'post',
                                        cache: false, 
                                        data:'list_type=delete_number&id='+id,
                                        success: function(data){
                                           
                                           if(data==1)
                                           {
                                                swal.fire('Success','Mobile Number Deleted Successfully!!','success').then((value) => {

                                                 window.location.reload(full_url+'/dashboard.php?page=number_block');
                                                    });
                                           }
                                           else
                                           {
                                                swal.fire({
                                                  icon: 'error',
                                                  title: 'Oops...',
                                                  text: 'Failed to delete details!'
                                                  
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




        $(document).on( "click", '.whitelist_btn',function(e) {
  
    var id = $(this).data('id');

   
           swal.fire({
  title: 'Are you sure?',
  text: "You want to whitelist this Mobile Number!",
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
        //var full_url = window.location.origin;

                            $.ajax({
                                        url: full_url+'/controller/number_block_controller.php',
                                        type: 'post',
                                        cache: false, 
                                        data:'list_type=whitelist_number&id='+id,
                                        success: function(data){
                                           
                                           if(data==1)
                                           {
                                                swal.fire('Success','Mobile Number Whitelisted Successfully!!','success').then((value) => {

                                                 window.location.reload(full_url+'/dashboard.php?page=number_block');
                                                    });
                                           }
                                           else
                                           {
                                                swal.fire({
                                                  icon: 'error',
                                                  title: 'Oops...',
                                                  text: 'Failed to whitelist details!'
                                                  
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




             $(document).on( "click", '.block_btn',function(e) {
  
    var id = $(this).data('id');

   
           swal.fire({
  title: 'Are you sure?',
  text: "You want to block this Mobile Number!",
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
        //var full_url = window.location.origin;

                            $.ajax({
                                        url: full_url+'/controller/number_block_controller.php',
                                        type: 'post',
                                        cache: false, 
                                        data:'list_type=block_number&id='+id,
                                        success: function(data){
                                           
                                           if(data==1)
                                           {
                                                swal.fire('Success','Mobile Number Blocked !!','success').then((value) => {

                                                 window.location.reload(full_url+'/dashboard.php?page=number_block');
                                                    });
                                           }
                                           else
                                           {
                                                swal.fire({
                                                  icon: 'error',
                                                  title: 'Oops...',
                                                  text: 'Failed to block mobile number!'
                                                  
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



function load_number_block_dtls()
{
	 //var full_url = window.location.origin;
	$('#number_block_tbl').DataTable( {
        "processing": true,
        "serverSide": true,
        "responsive": true,
         "ajax": {
                    "type":"POST",
                    "url":full_url+"/controller/number_block_controller.php",
                    "data":function (post) {
                            post.list_type='all_block_numbers';
      
                        }
                  
         },
         "order": [[ 0, "desc" ]],
         "columnDefs": [
                        {"className": "dt-center", "targets": "_all"}
            ]

        } );

}

function load_username_dropdown()
{
        //var full_url = window.location.origin;
            $.ajax({
                url: full_url+'/controller/user_controller.php',
                type: 'post',
                cache: false, 
                data:'list_type=dropdown_user&page=number_block',
                success: function(data){
                /*alert(data);*/
                   if(data!=0)
                   {
                    $('#username').empty();
                   
                    $('#username').append(data);

                  //  $("#username").chosen(); 
                   $("#username_chosen").css('width','100%');
 /*          $('#username').multiselect({
    columns: 1,
    placeholder: 'Select Username',
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
$("#save_btn").click(function(){

             

				$( "#addblocknumberForm" ).validate( {
		            rules: {
		                status: "required",
		            },
		            messages: {
		                status: "Please select status",
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
						  text: "You want to save this block number details!",
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


		  						 //var full_url = window.location.origin;

		       var file_data = $('#mobile_file').prop('files')[0];
            
                var form_data = new FormData();     
               /* var reseller_dropdown=$("#reseller_dropdown").val();*/
                var status=$("#status").val();
             	var upload_type=$("#upload_type").val();
                var username=$("#username").val();
		  					
             	if(upload_type=='single')
             	{
             		var mobile_number=$("#mobile").val();
             		if(mobile_number=='')
             		{
             			swal.fire({
		                              icon: 'error',
		                              title: 'Error',
		                              text: 'Mobile Field should not be an empty',
		                              footer: 'Please check!!'
		                            })
             			return false;
             		}
             		else
             		{
             			form_data.append('mobile_number',mobile_number);
             		}
             		
             	}
             	else if(upload_type=='multiple')
             	{
             		form_data.append('mobile_file', file_data);
             	}
                	form_data.append('status',status);
                	form_data.append('upload_type',upload_type);
                    form_data.append('username',username);
                	form_data.append('list_type','add_block_numbers');



                	 $.ajax({
		                    url: full_url+'/controller/number_block_controller.php',
		                    type: 'POST',
                            cache: false, 
		                    data:form_data,
		                    contentType: false,
                    		processData: false,
		                     beforeSend: function(){
		                     /*$("#loading_modal").modal('show');*/
		                   },
		                   complete: function(){
		                    /*$("#loading_modal").modal('hide');*/
		                   },
		                    success: function(data){
		                  	//console.log(data);
		                       if(data==1)
		                       {
		                            swal.fire('Success','Mobile Number details added successfully','success').then((value) => {
		                            /*	load_branding_dtls();*/
		                             /* window.location.reload();*/
		                              $("#addblocknumberForm").trigger('reset');
		                              $('#addblocknumberModel').modal('hide');
                                
                                 window.location.reload(full_url+'/dashboard.php?page=number_block');
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
