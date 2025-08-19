var data_upload;
var select_val="sss";
var table;

$(document).ready(function(){

$('.ms-options-wrap').css('display','block');

	load_group_list();
	load_group_dropdown();
    
    $('#importBtn_group').click(function() {
        data_upload=$("#select_group_contact").val();
        select_val=data_upload.toString();
      //  console.log(select_val);

            var btnUpload=$('#importBtn_group');
            var full_url = window.location.origin+"/itswe_sms_app";
            new AjaxUpload(btnUpload, {
                action:full_url+'/controller/group_function.php',
                name: 'import_contact',
                data: {'select_group_import':select_val,'mod':'groupWithContacts'},
                onSubmit: function(file, ext) {
                    if (! (ext && /^(txt|xls|csv|xlsx)$/.test(ext))) {
                      alert("Only txt,xls,xlsx,csv format files are allowed.");
                      return false;
                    }
                /* $("#import").css('display','block');*/
            },
            onComplete: function(file, data) {
                data = data.trim();
                
                    alert(data);
                    $("#group_with_contacts").modal('hide');
                     location.reload();
               
                
                
            }});

    })

    $("#importBtn_bulk1").click(function(){
        /*  e.preventDefault();*/
            var full_url = window.location.origin+"/itswe_sms_app";
            var file_data = $('#uploadfile').prop('files')[0];
        
            var group = $("#select_group_contact").val();
        
             if(file_data != undefined) {
                var form_data = new FormData();   
                form_data.append('uploadfile', file_data); 
                form_data.append('select_group_import', group); 
                form_data.append('act','import3');
             $.ajax({
                        url: full_url+'/controller/group_function.php',
                        type: 'post',
                        data:form_data,
                        cache: false,             // To unable request pages to be cached
                        contentType: false,
                         processData: false,        // To send DOMDocument or non processed data file it is set to false
                        beforeSend: function(){
                         
                        
                           },
                         
                        //},
                        complete: function(){
                           // $("#loading_modal").modal('hide');
                           },
                        success: function(data){
                            //console.log(data);
                            data = data.trim();
                            swal.fire('Successfull!!',data,'success').then((value) => {
                                            window.location.reload();
        
                                            
                                        });
                          
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                            alert(errorMsg);
                            //$('#content').html(errorMsg);
                          }
                    });
            }
        })
        



        $(document).on( "click", '.contact_link',function(e) {
  
            var gid = $(this).data('id');
            var full_url = window.location.origin+"/itswe_sms_app";

                     /*$("#tbl_contact_list").empty();*/

                     if ($.fn.DataTable.isDataTable('#tbl_contact_list')) {
                        $('#tbl_contact_list').DataTable().destroy();
                    }

                          table= $('#tbl_contact_list').DataTable( {
                        "processing": true,
                        "serverSide": true,
                         "ajax": {
                                    "type":"POST",
                                    "url":full_url+"/controller/group_function.php",
                                    "data":function (post) {
                                            post.group_id=gid;
                                            post.list_type='show_contact_list';
                                    
                                            
                                            
                                        }
                         },
                         order: [0, 'asc'],

                        } );
          
        });



        

       $('#uploadBtn_group').click(function() {
       
        var gid=$("#single_gid").val();
      //  console.log(select_val);

            var btnUpload=$('#uploadBtn_group');
    var full_url = window.location.origin+"/itswe_sms_app";
            new AjaxUpload(btnUpload, {
                action:full_url+'/controller/group_function.php',
                name: 'upload_contact',
                data: {'select_group_import':gid,'mod':'singleGroup'},
                onSubmit: function(file, ext) {
                    if (! (ext && /^(txt|xls|csv|xlsx)$/.test(ext))) {
                      alert("Only txt,xls,xlsx,csv format files are allowed.");
                      return false;
                    }
                /* $("#import").css('display','block');*/
            },
            onComplete: function(file, data) {
                data = data.trim();
                    alert(data);
                    $("#upload_with_contacts").modal('hide');
                     location.reload();
               
                
                
            }});

    })


   $("#editGroupData").click(function(){

            
 $( "#grp_edit_form" ).validate({

            rules: {
                edit_descript: "required",
                edit_g_name: "required",
              
              
            },
            messages: {
                edit_descript: "Please enter description",
                edit_g_name: "Please select group name",
             
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
     
        if($("#edit_g_name").val()!='')
        {

    var full_url = window.location.origin+"/itswe_sms_app";
                    $.ajax({
                    url: full_url+'/controller/group_function.php',
                    type: 'post',
                    cache: false, 
                    data:$("#grp_edit_form").serialize(),
                    success: function(data){
                        data = data.trim();

                       if(data==1)
                            {
                                 swal.fire('Successfull!!','Group Details Updated Successfully!!','success').then((value) => {
                                    $('#edit_group').modal('hide');
                                    load_group_list();
                                });
                      
                            }
                            else
                            {
                                 swal.fire({
                                  icon: 'error',
                                  title: 'Oops...',
                                  text: 'Failed to Update Group Details!'
                                  
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
                                  text: 'Please Enter Group Name!!'
                                  
                                });
            }

             }

        });



        });
	

        $(document).on( "click", '.edit_group_btn',function(e) {
  
            var id = $(this).data('id');
            var group_name=$(this).data('gname');
            var description=$(this).data('desc');
            $("#edit_descript").val(description);
            $("#gid").val(id);
            $("#edit_g_name").val(group_name);   
        });


	        $(document).on( "click", '.delete_group_btn',function(e) {
  
    var id = $(this).data('id');

           swal.fire({
  title: 'Are you sure?',
  text: "You want to delete this group details!",
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
                                        url: full_url+'/controller/group_function.php',
                                        type: 'post',
                                        cache: false, 
                                        data:'type=delete_group&gid='+id,
                                        success: function(data){
                                            data = data.trim();
                                           
                                           if(data==1)
                                           {
                                                swal.fire('','Group Details Deleted Successfully!!','success').then((value) => {
                                                load_group_list();
                                                    });
                                           }
                                           else
                                           {
                                                swal.fire({
                                                  icon: 'error',
                                                  title: 'Oops...',
                                                  text: 'Failed To Delete Group Details!'
                                                  
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
	
    $("#add_contact_btn").click(function(){
        load_group_dropdown();
        
        $("#select_group").multiselect({
                            columns: 1,
                            placeholder: 'Select Group',
                            search: true,
                            selectAll: true
                        });
    });

    
    $("#group_with_contact_btn").click(function(){
        load_group_dropdown();

            $('#select_group_contact').multiselect({
            columns: 1,
            placeholder: 'Select Group',
            search: true,
            selectAll: true
        });

    });

   

});

function upload_data(btn_gid)
{
    var btn_val=btn_gid.split("_");
    var gid=btn_val[1];
    $("#single_gid").val(gid);
    $("#upload_with_contacts").modal('show');



}



function action_message(msg, type,form_name) {
    if (type == 'success') {
        var message = '<span class="asm">' + msg + '</span>';
        $('#action_message').html(message);
        $('#action_message').show();
        $("#action_message").fadeOut(5000);
        // return false;
    }

    if (type == 'error') {
	    if(form_name=='add_group')
	    {
	    	
	        var message = '<span class="awm">' + msg + '</span>';
	        $('#action_message_error_addgroup').html(message);
	        $('#action_message_error_addgroup').show();
	        $("#action_message_error_addgroup").fadeOut(5000);
	        // return false;
	    	
	    }
	    else if(form_name=='add_contact')
	    {
	    	var message = '<span class="awm">' + msg + '</span>';
	        $('#action_message_error_add_contact').html(message);
	        $('#action_message_error_add_contact').show();
	        $("#action_message_error_add_contact").fadeOut(5000);
	    }
	}
    
}
function load_group_list()
{
    var full_url = window.location.origin+"/itswe_sms_app";
             $.ajax({
                url: full_url+'/controller/group_function.php',
                type: 'post',
                cache: false, 
                data:'list_type=all',
                success: function(data){
                    data = data.trim();
                
                   if(data!=0)
                   {

                    $('#group_list').html(data);
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}

function load_group_dropdown()
{
    
    var full_url = window.location.origin+"/itswe_sms_app";

             $.ajax({
                url: full_url+'/controller/group_function.php',
                type: 'post',
                cache: false, 
                data:'list_type=dropdown',
                success: function(data){
                    data = data.trim();
                   if(data!=0)
                   {
                    $('.select_group').empty();
                    $('.select_group').append(data);
                    
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}

function add_group()
	{
        var gname=$.trim( $('#g_name').val() );
		if (gname == '')
        {
            //alert('Enter group name');
            action_message('Enter group name', 'error','add_group');
            return false;
        }
    var full_url = window.location.origin+"/itswe_sms_app";
             $.ajax({
            type: 'POST',
            cache: false, 
            url: full_url+'/controller/group_function.php',
            data: $('#grp_crt_Form').serialize(),
            beforeSend: function () {
                //$('.saveGroupDataLoader').html('<img src="system-icon/i32x32/loading.png" />');
            },
            success: function (data)
            {
                data = data.trim();
            	/*console.log(data);
                alert(data);*/
                //$('.saveGroupDataLoader').html('<input name="" type="button" class="saveGroupData" value="Save" />');
                if (data == 'FALSE') {
                    action_message('failed! Contact Administrator', 'error','add_group');
                }
                else if(data==2)
                {
                     swal.fire({
                                                icon: 'error',
                                                title: 'Sorry...',
                                                text: 'Group name already exists!'            
                                            });
                }else {


                    $('a.close').trigger('click');
                    $('#grp_crt_Form')[0].reset();
                    $('#group_list').html(data);
                    $('#action_message').css('display', 'block');
                    $('#create_group').modal('hide');
                    Swal.fire("Successful !",'Group name created successfully','success').then((value) => {
                                    location.reload();
                                    });
                    

                }
            }
        });

	}

function addIndNumber()
{
    var select_group=$.trim( $('#select_group').val() );
	if (select_group == '')
        {
           // alert('Please select group name');
            action_message('Please select group name', 'error','add_contact');
            return false;
        }

        if ($('#person_name').val().trim() == '')
        {
            //alert('Please enter person name');
            action_message('Please enter person name', 'error','add_contact');
            return false;
        }
       
        if ($('#contactno').val().trim() == '')
        {
            action_message('Please enter contact number', 'error','add_contact');
            return false;
        }
    var full_url = window.location.origin+"/itswe_sms_app";
                $.ajax({
            type: 'POST',
            cache: false, 
            url: full_url+'/controller/group_function.php',
            data: $('#IndContactForm').serialize(),
            //data: $('#IndContactForm').serialize(),
            beforeSend: function () {
               // $('.addIndNumberLoder').html('<img src="system-icon/i32x32/loading.png" />');
            },
            success: function (data)
            {
              data = data.trim();
               console.log(data);
                if (data == '1') {
                    alert('Contact Details Added Successfully');
                    location.reload();
                 }
                   else{

                    alert('Contact detail already exist in group :- '+data);
                    location.reload();
                 }

            }
        });
}