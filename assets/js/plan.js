$(function(){
load_all_plan();
		$("#save_plan").click(function(){

			var p_name=$("#p_name").val();

            if(p_name!='')
            {
    var full_url = window.location.origin+"/itswe_sms_app";

			$.ajax({
                url: full_url+'/controller/plan_controller.php',
                type: 'post',
                cache: false, 
                data:$("#create_plan_form").serialize(),
                success: function(data){

                    if(data==1)
                    {
                        swal.fire('','Plan Details Added Successfully','success').then((value) => {

                                $("#add_plan").modal('hide');
                                load_all_plan();
                            });  
                    }
                    else if(data==2)
                    {
                        swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Failed To Create Plan Details!'
                          
                        }).then((value) => {
                              return false;
                                    });
                    }
                    else if(data==0)
                    {
                        swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Plan Name Already Exists!'
                          
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
                          text: 'Please Enter Plan Name!'
                          
                        }).then((value) => {
                              return false;
                                    });
    }


		});


        $("#edit_plan_btn").click(function(){

            var p_name=$("#edit_p_name").val();

             if (p_name.trim() == '') {
               swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Please Enter Plan name!'
                  
                }).then((value) => {
                      return false;
                            });
                
            }
            else
            {   

    var full_url = window.location.origin+"/itswe_sms_app";
                $.ajax({
                    url: full_url+'/controller/plan_controller.php',
                    type: 'post',
                    cache: false, 
                    data:$("#edit_plan_form").serialize(),
                    success: function(data){

                        if(data==1)
                        {
                             swal.fire('','Plan Details Updated Successfully!!','success').then((value) => {
                                $('#edit_plan').modal('hide');
                                load_all_plan();
                            });
                  
                        }
                        else
                        {
                             swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Failed to Update Plan Details!'
                              
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

        $(document).on( "click", '.edit_plan',function(e) {
  
            var id = $(this).data('id');
            var plan_name=$(this).data('plan');
            var status=$(this).data('status');
            $(`#edit_plan_status option[value='${status}']`).prop('selected', true);
          
           
            $("#pid").val(id);
            $("#edit_p_name").val(plan_name);
          
   
        });


        $(document).on( "click", '.delete_plan_btn',function(e) {
  
    var id = $(this).data('id');

           swal.fire({
  title: 'Are you sure?',
  text: "You want to delete this plan!",
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
                                        url: full_url+'/controller/plan_controller.php',
                                        type: 'post',
                                        cache: false, 
                                        data:'list_type=delete_plan&pid='+id,
                                        success: function(data){
                                           
                                           if(data==1)
                                           {
                                                swal.fire('','Plan Details Deleted Successfully!!','success').then((value) => {
                                                load_all_plan();
                                                    });
                                           }
                                           else
                                           {
                                                swal.fire({
                                                  icon: 'error',
                                                  title: 'Oops...',
                                                  text: 'Failed to delete plan details!'
                                                  
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

});

function load_all_plan()
{
        var full_url = window.location.origin+"/itswe_sms_app";
            $.ajax({
                url: full_url+'/controller/plan_controller.php',
                type: 'post',
                cache: false, 
                data:'list_type=all_plan',
                success: function(data){
                
                   if(data!=0)
                   {

                    $('#plan').html(data);
                    $("#plan_tbl").DataTable({
                      info: true
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