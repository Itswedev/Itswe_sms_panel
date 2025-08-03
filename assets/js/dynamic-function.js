$(document).ready(function(){



	         
load_route_dropdown();






});





function load_route_dropdown()
{
        var full_url = window.location.origin;
             $.ajax({
                url: full_url+'/controller/manage_gateway_controller.php',
                type: 'post',
                cache: false, 
                data:'list_type=route_dropdown&page=compose',
                success: function(data){
                    //alert(data);
                   if(data!=0)
                   {
                    $('#az_routeid').empty();
                    $('#az_routeid').html(data);
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}