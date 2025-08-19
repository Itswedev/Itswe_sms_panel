$(function(){

	var user_role=$("#user_role").val();
	var userid="";
	if(user_role=='mds_usr')
	{
		daily_mis_report(userid);
	}
	else if(user_role=='mds_rs' || user_role=='mds_ad')
	{
		//  $("#user_dropdown_mis").chosen(); 
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
            
       
               var full_url = window.location.origin+"/itswe_sms_app";
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
                    url: full_url+'/controller/mis_report_controller.php',
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
                    $('#template_mis_report').html(res['templateid']);
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




// DOWNLOAD SCRIPT START

function extractTableData(tableId) {
    let table = document.getElementById(tableId);
    let rows = table.querySelectorAll("tr");
    let tableData = [];

    rows.forEach(row => {
        let rowData = [];
        let cells = row.querySelectorAll("th, td");
        cells.forEach(cell => {
            rowData.push(cell.innerText);
        });
        tableData.push(rowData);
    });

    return tableData;
}

function convertToCSV(tableData) {
    return tableData.map(row => row.map(cell => `"${cell}"`).join(",")).join("\n");
}


function downloadCSV(csv, filename) {
    let csvFile = new Blob([csv], { type: "text/csv" });
    let downloadLink = document.createElement("a");
    downloadLink.download = filename;
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}

function downloadTableAsCSV(tableId, filename) {
    let tableData = extractTableData(tableId);
    let csv = convertToCSV(tableData);
    downloadCSV(csv, filename);
}


// Download script end
	function daily_mis_report(userid){
		var selected_user_role=$("#user_role_dropdown_mis").val();
		var full_url = window.location.origin+"/itswe_sms_app";
		$.ajax({
		    url: full_url+'/controller/mis_report_controller.php',
		    type: 'post',
		    cache: false, 
		    data:'list_type=mis_report&selected_userid='+userid+'&selected_user_role='+selected_user_role,
		    dataType:'json',
		    success: function(data){
		    
		    		
		    		 var res = JSON.parse(JSON.stringify(data));
                    // console.log(res['daily']);
		        	$('#daily_mis_report').html(res['daily']);
		        	$('#monthly_mis_report').html(res['monthly']);
		        	$('#senderid_mis_report').html(res['senderid']);
                    $('#template_mis_report').html(res['templateid']);
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
        var full_url = window.location.origin+"/itswe_sms_app";
            $.ajax({
                url: full_url+'/controller/user_controller.php',
                type: 'post',
                cache: false, 
                data:'list_type=dropdown_user&page=mis',
                success: function(data){
                
                   if(data!=0)
                   {
                    $('#user_dropdown_list').empty();
                    
                    $('#user_dropdown_list').append(data);

                //    $("#user_dropdown_list").chosen(); 
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
	
        var full_url = window.location.origin+"/itswe_sms_app";
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

