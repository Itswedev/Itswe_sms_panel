$(function(){

	var user_role=$("#user_role").val();
	var userid="";
	if(user_role=='mds_usr')
	{
		daily_mis_report(userid);
	}
	else if(user_role=='mds_rs' || user_role=='mds_ad')
	{
		 $("#user_dropdown_mis").chosen(); 
         $("#user_dropdown_mis_chosen").css('width','100%');
         $(`#user_dropdown_mis`).trigger("chosen:updated");

		$("#user_role_dropdown_mis").change(function(){

			var user_role=$("#user_role_dropdown_mis").val();

			if(user_role!='All')
			{
				load_users_mis();
			}
			else
			{
				daily_mis_report(userid=null);
			}
			

			/* userid=$("#user_dropdown_list").val();
			daily_mis_report(userid);
*/
		});

		$("#user_dropdown_mis").change(function(){


			userid=$("#user_dropdown_mis").val();
			daily_mis_report(userid);

		});
	}
	else
	{
		load_username_dropdown();
		$("#user_dropdown_list").change(function(){

			 userid=$("#user_dropdown_list").val();
			daily_mis_report(userid);

		});
	}

	  $(document).on('click','#search_custom_submit',function(){
            
       
               //var full_url = window.location.origin;
               var userid=$("#user_dropdown_mis").val();
               if(userid=='' || userid==undefined)
               	{
               		userid=$("#user_dropdown_list").val();
               	}
               $("#selected_userid_dt").val(userid);
               var selected_user_role=$("#user_role_dropdown_mis").val();
               console.log(selected_user_role);
               $("#selected_user_role_dt").val(selected_user_role);

               var frm_date=$("#frmDate").val();
               var to_date=$("#toDate").val();
               /*alert(frmdt);*/
          
               $.ajax({
                    url: full_url+'/controller/voice_mis_report_controller.php',
                    type: 'post',
                    cache: false, 
                    data:$("#custom_mis_form").serialize(),
                    dataType:'json',
                    async:true,
                     beforeSend: function(){
                         $('.ajax-loader').css("visibility", "visible");
                       },
                       complete: function(){
                        $('.ajax-loader').css("visibility", "hidden");
                       },
                    success: function(data){
                        console.log(data);
                    var res = JSON.parse(JSON.stringify(data));

                   
                    $('#daily_mis_report').html(res['daily']);
		        	$('#monthly_mis_report').html(res['monthly']);
		        	$('#senderid_mis_report').html(res['senderid']);
		        	$('#custom_mis_report').html(res['custom']);
		        	$('#yearly_mis_report').html(res['yearly']);
                       // console.log(data);
                 
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        /*alert(errorMsg);*/
                        //$('#content').html(errorMsg);
                      }
                });
            
            })
	
	/*monthly_mis_report();
	yearly_mis_report();
*/
});
	function daily_mis_report(userid){
		var selected_user_role=$("#user_role_dropdown_mis").val();
		//var full_url = window.location.origin;
		$.ajax({
		    url: full_url+'/controller/voice_mis_report_controller.php',
		    type: 'post',
		    cache: false, 
		    data:'list_type=mis_report&selected_userid='+userid+'&selected_user_role='+selected_user_role,
		    dataType:'json',
		    success: function(data){
		    
		    		
		    		 var res = JSON.parse(JSON.stringify(data));
                   /* console.log(res['yearly']);*/
		        	$('#daily_mis_report').html(res['daily']);
		        	$('#monthly_mis_report').html(res['monthly']);
		        	$('#senderid_mis_report').html(res['senderid']);
		        	$('#custom_mis_report').html(res['custom']);
		        	$('#yearly_mis_report').html(res['yearly']);
		       	
		    },
		    error: function (xhr, ajaxOptions, thrownError) {
		        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
		        console.log(errorMsg);
		        /*alert("error"+errorMsg);*/
		        //$('#content').html(errorMsg);
		    }
		});
	}


function load_username_dropdown()
{
        //var full_url = window.location.origin;
            $.ajax({
                url: full_url+'/controller/user_controller.php',
                type: 'post',
                cache: false, 
                data:'list_type=dropdown_user&page=add_credit',
                success: function(data){
                
                   if(data!=0)
                   {
                    $('#user_dropdown_list').empty();
                    
                    $('#user_dropdown_list').append(data);

                   $("#user_dropdown_list").chosen(); 
                   $("#user_dropdown_list_chosen").css('width','100%');

                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
}


function load_users_mis()
{
	
        //var full_url = window.location.origin;
        var selected_user_role=$("#user_role_dropdown_mis").val();
       
            $.ajax({
                url: full_url+'/controller/user_controller.php',
                type: 'post',
                cache: false, 
                data:'list_type=dropdown_user&page=add_credit&selected_user_role='+selected_user_role,
                success: function(data){
                
                   if(data!=0)
                   {
                    $('#user_dropdown_mis').empty();
                    $('#user_dropdown_mis').html(data);

                   $("#user_dropdown_mis").chosen(); 
                   $("#user_dropdown_mis_chosen").css('width','100%');
                    $(`#user_dropdown_mis`).trigger("chosen:updated");

                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
}

