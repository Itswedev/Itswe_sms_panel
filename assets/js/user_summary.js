$(function(){

load_user_dropdown();

$("#u_name").change(function(){

var u_id=$("#u_name").val();
    var full_url = window.location.origin;
	   $.ajax({
                url: full_url+'/controller/user_controller.php',
                type: 'post',
                cache: false,
                data:'list_type=user_summary&u_id='+u_id,
                success: function(data){
                	//alert(data);
                   if(data!=0)
                   {
                    $('#user_summary_tbl').empty();
                    $('#user_summary_tbl').html(data);
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
})


});

function load_user_dropdown()
{
       var full_url = window.location.origin;
	   $.ajax({
                url: full_url+'/controller/user_controller.php',
                type: 'post',
                cache: false,
                data:'list_type=dropdown_user',
                success: function(data){
                	//alert(data);
                   if(data!=0)
                   {
                    $('#u_name').empty();
                    $('#u_name').html(data);
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}