$(function(){
load_branding_dtls();
load_resellers();


			$("#save_btn").click(function(){
		        $( "#addbrandingForm" ).validate( {
		            rules: {
		            	
		                company_name: "required",
		                tag_line: "required",
		                web_url: "required",
		                uploadfile: "required",
		                support_url: "required",
		                support_mobile: "required",
		                support_email: "required",
		                login_desc: "required",
		               


		            },
		            messages: {
		          
		                company_name: "Please select Route",
		                tag_line: "Please select sender is",
		                web_url: "Please select template",
		                uploadfile: "Please Enter Mobile Number",
		                support_url: "Please enter message",
		                support_mobile: "Please enter message",
		                support_email: "Please enter message",
		                login_desc: "Please enter message"
		                
		                
		                
		                
		                
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
						  text: "You want to save this branding details!",
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

		       var file_data = $('#uploadfile').prop('files')[0];

            if(file_data != undefined) {
              
                var form_data = new FormData();     
                 form_data.append('company_logo', file_data);

               /* var reseller_dropdown=$("#reseller_dropdown").val();*/
                var company_name=$("#company_name").val();
                var tag_line=$("#tag_line").val();
                var web_url=$("#web_url").val();
                var support_url=$("#support_url").val();
                var support_mobile=$("#support_mobile").val();
                   var support_email=$("#support_email").val();
                var login_desc=$("#login_desc").val();

              
               /* form_data.append('reseller_dropdown',reseller_dropdown);*/
                form_data.append('company_name',company_name);
                form_data.append('tag_line',tag_line);
                form_data.append('web_url',web_url);
                form_data.append('support_url',support_url);
                form_data.append('support_mobile',support_mobile);
                form_data.append('support_email',support_email);
                form_data.append('login_desc',login_desc);

 form_data.append('type','add_branding');
                        // alert(form_data);
		   $.ajax({
		                    url: full_url+'/controller/branding.php',
		                    type: 'POST',
		                    data:form_data,
		                    cache: false, 
		                     contentType: false,
                    		processData: false,
		                     beforeSend: function(){
		                     /*$("#loading_modal").modal('show');*/
		                   },
		                   complete: function(){
		                    /*$("#loading_modal").modal('hide');*/
		                   },
		                    success: function(data){
		                  	//alert(data);
		                       if(data==1)
		                       {
		                            swal.fire('Success','Branding details added successfully','success').then((value) => {
		                            /*	load_branding_dtls();*/
		                              /*window.location.reload();*/
		                              $("#addbrandingForm").trigger('reset');
		                              $('#brandingModel').modal('hide');
                                
                                 window.location.reload(full_url+'/dashboard.php?page=branding');
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
		           

		  }
		})
		        
		        }

		        } );






/*edit Section*/

			

		        /*edit sec end*/
		});

$("#edit_brand_btn").click(function(){
	 //var full_url = window.location.origin;
				        $( "#editbrandingForm" ).validate( {
		            rules: {
		            	
		                company_name: "required",
		                tag_line: "required",
		                web_url: "required",
		                
		                support_url: "required",
		                support_mobile: "required",
		                support_email: "required",
		                login_desc: "required",
		               


		            },
		            messages: {
		          
		                company_name: "Please select Route",
		                tag_line: "Please select sender is",
		                web_url: "Please select template",
		                
		                support_url: "Please enter message",
		                support_mobile: "Please enter message",
		                support_email: "Please enter message",
		                login_desc: "Please enter message"
		             
		                
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
						  text: "You want to update this branding details!",
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

		        var file_data = $('#uploadfile_edit').prop('files')[0];
 				var form_data = new FormData();
            		if(file_data != undefined) {
              
                 		form_data.append('company_logo', file_data);
                 	}
               /* var reseller_dropdown=$("#reseller_dropdown").val();*/
                var company_name=$("#company_name_edit").val();
                 var brand_id=$("#brand_id").val();
                var tag_line=$("#tag_line_edit").val();
                var web_url=$("#web_url_edit").val();
                var support_url=$("#support_url_edit").val();
                var support_mobile=$("#support_mobile_edit").val();
                var support_email=$("#support_email_edit").val();
                var login_desc=$("#login_desc_edit").val();

              
               /* form_data.append('reseller_dropdown',reseller_dropdown);*/
                form_data.append('company_name',company_name);
                form_data.append('brand_id',brand_id);
                form_data.append('tag_line',tag_line);
                form_data.append('web_url',web_url);
                form_data.append('support_url',support_url);
                form_data.append('support_mobile',support_mobile);
                form_data.append('support_email',support_email);
                form_data.append('login_desc',login_desc);

 				form_data.append('list_type','edit_branding');

 					$.ajax({
		                    url: full_url+'/controller/branding.php',
		                    type: 'POST',
		                    data:form_data,
		                    cache: false, 
		                     contentType: false,
                    		processData: false,
		                     beforeSend: function(){
		                     /*$("#loading_modal").modal('show');*/
		                   },
		                   complete: function(){
		                    /*$("#loading_modal").modal('hide');*/
		                   },
		                    success: function(data){
		                  	//alert(data);
		                       if(data==1)
		                       {
		                            swal.fire('Success','Branding details updated successfully','success').then((value) => {
		                            /*	load_branding_dtls();*/
		                              /*window.location.reload();*/
		                              $("#editbrandingForm").trigger('reset');
		                              $('#editbrandingModel').modal('hide');
                                
                                window.location.reload(full_url+'/dashboard.php?page=branding');
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

        $(document).on( "click", '.delete_branddtls_btn',function(e) {
  
    var id = $(this).data('id');

   
           swal.fire({
  title: 'Are you sure?',
  text: "You want to delete this Branding Details!",
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
                                        url: full_url+'/controller/branding.php',
                                        type: 'post',
                                        cache: false, 
                                        data:'list_type=delete_brand&brandid='+id,
                                        success: function(data){
                                           
                                           if(data==1)
                                           {
                                                swal.fire('Success','Branding Details Deleted Successfully!!','success').then((value) => {

                                                 window.location.reload(full_url+'/dashboard.php?page=branding');
                                                    });
                                           }
                                           else
                                           {
                                                swal.fire({
                                                  icon: 'error',
                                                  title: 'Oops...',
                                                  text: 'Failed to delete Branding details!'
                                                  
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







})

$(document).on( "click", '.edit_branddtls_btn',function(e) {
  
    var id = $(this).data('id');
    var company_name = $(this).data('company_name');
    
    var tagline=$(this).data('company_tagline');
    var web_addr=$(this).data('web_addr');
    var support_url=$(this).data('support_url');
    var support_mobile=$(this).data('support_mobile');
    var support_email=$(this).data('support_email');

    var login_desc=$(this).data('login_desc');
  
    $("#brand_id").val(id);
    $("#company_name_edit").val(company_name);

    $("#tag_line_edit").val(tagline);
    $("#web_url_edit").val(web_addr);
     $("#support_url_edit").val(support_url);
      $("#support_mobile_edit").val(support_mobile);
       $("#support_email_edit").val(support_email);
       $("#login_desc_edit").text(login_desc);
  

   
});
function load_resellers()
{
    //var full_url = window.location.origin;

    var role=$("#reseller_dropdown").val();
   
           $.ajax({
                url: full_url+'/controller/user_controller.php',
                type: 'post',
                data:'list_type=load_resellerslist',
                async:true,
                cache: false, 

                success: function(data){
                  
                  $("#reseller_dropdown").empty();
                  $("#reseller_dropdown").append(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}


function load_branding_dtls()
{
	//var full_url = window.location.origin;


           $.ajax({
                url: full_url+'/controller/branding.php',
                type: 'post',
                cache: false, 
                data:'list_type=count_branding',
                async:true,

                success: function(data){
                  
                 if(data!=0)
                 {
                 	$("#add_new_branding_btn").css('display','none');
                 }
                 else
                 {
                 	$("#add_new_branding_btn").css('display','');
                 }

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });


	$('#brand_tbl').DataTable( {
        "processing": true,
        "serverSide": true,
        "responsive": true,
         "ajax": {
                    "type":"POST",
                    "url":full_url+"/controller/branding.php",
                    "data":function (post) {
                            post.list_type='all_branding';
      
                        }
                  
         },
         "order": [[ 0, "desc" ]],
         "columnDefs": [
                        {"className": "dt-center", "targets": "_all"}
            ]

        } );

}