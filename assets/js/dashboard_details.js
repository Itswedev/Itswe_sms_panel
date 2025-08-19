$(function(){

	var page_name=$("#page_name").html();
	if(page_name=="User")
	{
			load_user_profile();
	}
})

function load_user_profile()
{

        var full_url = window.location.origin+"/itswe_sms_app";
	  $.ajax({
                url: full_url+'/controller/dashboard_controller.php',
                type: 'post',
                cache: false, 
                data:'list_type=load_user_profile',
                dataType: 'json',
                success: function(data){
                	//alert(data);
                 	var res = JSON.parse(JSON.stringify(data));
                	console.log(data);
                   
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}