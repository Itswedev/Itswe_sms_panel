$(function(){
load_username_dropdown();
load_credit_details();
/*load_route_dropdown();*/

$("#username").change(function(){

    var u_id=$("#username").val();
    var full_url = window.location.origin+"/itswe_sms_app";
           $.ajax({
                    url: full_url+'/controller/credit_controller.php',
                    type: 'post',
                    data: 'type=fetch_route&u_id='+u_id,
                    success: function(data){
                       // console.log(data);
                        //alert(data);
                       $("#route").empty();
                       $('#route').html(data);
                     
                        
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(data);
                        //$('#content').html(errorMsg);
                      }
                });
});


        $("#save_credit").click(function(){

          

             var credit =  $.trim( $('#add_credit_form input[type=number]').val() );
             var username =  $.trim( $('#add_credit_form select[name=username]').val() );
              var credit_type =  $.trim( $('#add_credit_form select[name=credit_type]').val() );
               var remark =  $.trim( $('#add_credit_form textarea[name=remark]').val() );
            if (credit == "" || username == "" ||credit_type == "" ||remark == ""  ) {
                alert("Complete Form values");
            }
            else if(credit==0)
            {
                alert("Please do not enter 0 for cerdit value");
            }
            else
            {
                    var full_url = window.location.origin+"/itswe_sms_app";
                    $.ajax({
                    url: full_url+'/controller/credit_controller.php',
                    type: 'post',
                    data:$("#add_credit_form").serialize(),
                    success: function(data){
                       //console.log(data);
                       if(data==0)
                       {
                             Swal.fire({icon: 'error',title: 'Oops..',text: 'Failed to add credit details'})
                       }
                       else if(data==1)
                       {
                             Swal.fire("Successful !", "Credit Details added successfully", "success").then((value) => {
                                  window.location.href="dashboard.php?page=add_remove_credits";
                                });
                       }
                       else if(data==-1)
                       {
                             Swal.fire({icon: 'error',title: 'Oops..',text: 'Available balance less than your debit count'})
                       }
                        else if(data==2)
                       {
                             Swal.fire({icon: 'error',title: 'Oops..',text: 'Less Parent Balance!! Please Check!!'})
                       }

                       
                       /* alert(data);
                        location.reload();*/
                     
                        
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


function load_username_dropdown()
{
        var full_url = window.location.origin+"/itswe_sms_app";
            $.ajax({
                url: full_url+'/controller/user_controller.php',
                type: 'post',
                data:'list_type=dropdown_user&page=add_credit',
                success: function(data){
                
                   if(data!=0)
                   {
                    $('#username').empty();
                    $('#username').html(data);


           $('#username').multiselect({
    columns: 1,
    placeholder: 'Select Username',
    search: true,
    selectAll: true
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

function load_credit_details()
{
        var full_url = window.location.origin+"/itswe_sms_app";
            $.ajax({
                url: full_url+'/controller/credit_controller.php',
                type: 'post',
                data:'type=load_table_dtls',
                success: function(data){
                
                   if(data!=0)
                   {

                    $('#credit_list').html(data);
                   }
                    
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}



function load_route_dropdown()
{
    var full_url = window.location.origin+"/itswe_sms_app";
    
            $.ajax({
                url: full_url+'/controller/manage_gateway_controller.php',
                type: 'post',
                data:'list_type=route_dropdown&page=compose',
                success: function(data){
                    //alert(data);
                   if(data!=0)
                   {
                    $('#route').empty();
                    $('#route').html(data);
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}