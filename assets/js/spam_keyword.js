$(function(){
	load_keyword_dtls();

load_route_dropdown();

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



$(document).on( "click", '.edit_spamkeyword_btn',function(e) {
  
    var id = $(this).data('id');
    var spamkeyword = $(this).data('spamkeyword');
    var route=$(this).data('route');
    var status=$(this).data('status');
   
    //alert(sender_id);
    $("#spam_keyword_id").val(id);
    $("#edit_keyword").val(spamkeyword);
/*    $("#edit_PE_ID").val(peid);*/
  
/*    $("#edit_mbl1").val(templatecontent);*/
    $(`#edit_status option[value='${status}']`).prop('selected', true);
    $(`#edit_route option[value='${route}']`).prop('selected', true);
   



   
                });

$(document).on( "click", '#update_spam_keyword_btn',function(e) {
  
                $( "#editspamkeywordForm" ).validate( {
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
                          text: "You want to update this spam keyword details!",
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

        /*       var file_data = $('#mobile_file').prop('files')[0];*/
            
                var form_data = new FormData();     
               /* var reseller_dropdown=$("#reseller_dropdown").val();*/
                var status=$("#edit_status").val();
                var upload_type=$("#edit_upload_type").val();
               
                var route=$("#edit_route").val();
                var spamkeyword_id=$("#spam_keyword_id").val();
                if(upload_type=='single')
                {
                    var keyword=$("#edit_keyword").val();

                    if(keyword=='')
                    {
                        swal.fire({
                                      icon: 'error',
                                      title: 'Error',
                                      text: 'Keyword Field should not be an empty',
                                      footer: 'Please check!!'
                                    })
                        return false;
                    }
                    else
                    {
                        form_data.append('keyword',keyword);
                    }
                    
                }
                else if(upload_type=='multiple')
                {
                    form_data.append('keyword', file_data);
                }
                    form_data.append('status',status);
                     form_data.append('spamkeyword_id',spamkeyword_id);
                    form_data.append('upload_type',upload_type);
                    form_data.append('route',route);
                    form_data.append('list_type','update_spam_keywords');

                     $.ajax({
                            url: full_url+'/controller/spam_keyword_controller.php',
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
                                    swal.fire('Success','Spam Keyword details updated successfully','success').then((value) => {
                                    /*  load_branding_dtls();*/
                                     /* window.location.reload();*/
                                      $("#editspamkeywordForm").trigger('reset');
                                      $('#editspamkeywordModel').modal('hide');
                                
                                 window.location.reload(full_url+'/dashboard.php?page=spam_keywrod');
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
                                alert(errorMsg);
                                //$('#content').html(errorMsg);
                              }
                        });



                        }
                    });
                }




            });
  



   
                });



});



        $(document).on( "click", '.delete_spam_keyword_btn',function(e) {
  
    var id = $(this).data('id');

   
           swal.fire({
  title: 'Are you sure?',
  text: "You want to delete this Spam Keyword",
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
                                        url: full_url+'/controller/spam_keyword_controller.php',
                                        type: 'post',
                                        cache: false,
                                        data:'list_type=delete_keyword&id='+id,
                                        success: function(data){
                                           
                                           if(data==1)
                                           {
                                                swal.fire('Success','Spam Keyword Deleted Successfully!!','success').then((value) => {

                                                 window.location.reload(full_url+'/dashboard.php?page=spam_keywrod');
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
                                            alert(errorMsg);
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
        var full_url = window.location.origin+"/itswe_sms_app";

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
        var full_url = window.location.origin+"/itswe_sms_app";

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



function load_keyword_dtls()
{
	 var full_url = window.location.origin+"/itswe_sms_app";
	$('#keyword_tbl').DataTable( {
        "processing": true,
        "serverSide": true,
        "responsive": true,
         "ajax": {
                    "type":"POST",
                    "url":full_url+"/controller/spam_keyword_controller.php",
                    "data":function (post) {
                            post.list_type='all_keywords';
      
                        }
                  
         },
         "order": [[ 0, "desc" ]],
         "columnDefs": [
                        {"className": "dt-center", "targets": "_all"}
            ]

        } );

}

function load_route_dropdown()
{
        var full_url = window.location.origin+"/itswe_sms_app";
            $.ajax({
                url: full_url+'/controller/spam_keyword_controller.php',
                type: 'post',
                cache: false,
                data:'list_type=dropdown_route',
                success: function(data){
                
                   if(data!=0)
                   {
                    $('#route').empty();
                   
                    $('#route').append(data);

                  //  $("#route").chosen(); 
                   $("#route_chosen").css('width','100%');


                   $('#edit_route').empty();
                   
                    $('#edit_route').append(data);

                 /*  $("#edit_route").chosen(); 
                   $("#edit_route_chosen").css('width','100%');*/
 /*          $('#route').multiselect({
    columns: 1,
    placeholder: 'Select route',
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

             

				$( "#addspamkeywordForm" ).validate( {
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
						  text: "You want to save this spam keyword details!",
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

		/*       var file_data = $('#mobile_file').prop('files')[0];*/
            
                var form_data = new FormData();     
               /* var reseller_dropdown=$("#reseller_dropdown").val();*/
                var status=$("#status").val();
             	var upload_type=$("#upload_type").val();
                var route=$("#route").val();
		  					
             	if(upload_type=='single')
             	{
             		var keyword=$("#keyword").val();
             		if(keyword=='')
             		{
             			swal.fire({
		                              icon: 'error',
		                              title: 'Error',
		                              text: 'Keyword Field should not be an empty',
		                              footer: 'Please check!!'
		                            })
             			return false;
             		}
             		else
             		{
             			form_data.append('keyword',keyword);
             		}
             		
             	}
             	else if(upload_type=='multiple')
             	{
             		form_data.append('keyword', file_data);
             	}
                	form_data.append('status',status);
                	form_data.append('upload_type',upload_type);
                    form_data.append('route',route);
                	form_data.append('list_type','add_spam_keywords');

                	 $.ajax({
		                    url: full_url+'/controller/spam_keyword_controller.php',
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
		                            swal.fire('Success','Spam Keyword details added successfully','success').then((value) => {
		                            /*	load_branding_dtls();*/
		                             /* window.location.reload();*/
		                              $("#addspamkeywordForm").trigger('reset');
		                              $('#addblocknumberModel').modal('hide');
                                
                                 window.location.reload(full_url+'/dashboard.php?page=spam_keywrod');
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
