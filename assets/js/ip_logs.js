var table;
var frmDate = "";
var toDate = ""; 
var today_report_type="";


			
$(function() {
		var list_type="load_ip_logs"; 
		var full_url = window.location.origin+"/itswe_sms_app";
		table= $('#ip_logs_tbl').DataTable({
        	"processing": true,
        	"serverSide": true,
        	"ajax":{
         			"type":"POST",
         			"cache":false,
         			"url":full_url+"/controller/iplogs_controller.php",
         			"data":function (post) {
 						post.list_type=list_type;
 						if(frmDate!="" && toDate!=""){
 							post.frmDate = frmDate;
                    		post.toDate = toDate;
 						}
 					}
 				},
          	"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, 75]],
          	stateSave: true,
         	"order": [[ 0, "desc" ]],
         	"columnDefs": [
        				{"className": "dt-center", "targets": "_all"}
        				
      		],
      		"bDestroy": true
    	});





		$(document).on('click','#download_report_btn',function(){
			
			var list_type="ip_logs_report"; 
			var full_url = window.location.origin+"/itswe_sms_app";

			var data_string="list_type="+list_type+"&frmDate="+frmDate+"&toDate="+toDate;
				 $.ajax({
                    url: full_url+"/controller/download_report_controller.php",
                    type: 'post',
                   	data: data_string,
                    cache: false,
                    success: function(data){
					window.open(full_url+"/controller/download_report_controller.php?"+data_string);
    
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(errorMsg);
                        //$('#content').html(errorMsg);
                      }
                });


			
			});
	




});


function searchData() {
    frmDate = ($("#frmDate").val()) ? $("#frmDate").val() : '';
    toDate = ($("#toDate").val()) ? $("#toDate").val() : '';
    table.draw();
}