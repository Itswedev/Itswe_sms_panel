var table;
var frmDate = "";
var toDate = ""; 
var today_report_type="";


			
$(function() {
 
		
		$(document).on('click', '.view_delivery_count', function() {
			//var full_url = window.location.origin;
 		 var itemId = $(this).data('item-id');
 		 var span_id = "#delivery_count_"+itemId;

 		  var frmDate = $("#frmDate").val();
         var toDate = $("#toDate").val();

        var month = 0;
        month = new Date(frmDate).getMonth();

        month = month + 1 ;

        console.log(month);

        
 		 $.ajax({
                    url: full_url+"/controller/report_controller.php",
                    type: 'post',
                    data:'job_id='+itemId+"&list_type=show_api_delivery_count"+"&month="+month,
                    cache: false,
                    success: function(data){
												$(span_id).text(data);
 		 										//$("#delivery_count").show();
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(errorMsg);
                        //$('#content').html(errorMsg);
                      }
                });
 		
});

$(document).on('click', '.btn-close', function() {
			$("#delivery_count").hide();
});


	    $(document).on("change","#user_role_dropdown", function (e) {
        load_users();
});


   
$("#user_dropdown").change(function(){
       
            load_send_jobs_report();

            })


	var page_name=$("#page_name").html();
	if(page_name=="API Job"){
		load_send_job_data();

		$(document).on('click','#download_report_btn',function(){
			
			var job_id=$("#job_id").text();
			var job_date=$("#job_date").text();
			var table_name=$("#table_name").text();
			//var full_url = window.location.origin;


				 $.ajax({
                    url: full_url+"/controller/download_report_controller.php",
                    type: 'post',
                    data:'job_id='+job_id+"&list_type=download_report&job_date="+job_date+"&table_name="+table_name,
                    cache: false,
                    success: function(data){
                    	console.log(data);
					window.open(full_url+"/controller/download_report_controller.php?job_id="+job_id+"&list_type=download_report&job_date="+job_date+"&table_name="+table_name);
    
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(errorMsg);
                        //$('#content').html(errorMsg);
                      }
                });



})


	    //load_user_chart();
	}

	if(page_name=='API Jobs'){

		load_send_jobs_report();






		$(document).on('click','#download_report_btn',function(){
			
			var list_type="send_job_summary_report"; 
			//var full_url = window.location.origin;

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


			
			})
	}




});




function load_send_jobs_report()
{
    

		 var user_role=$("#user_role").val();
		 var selected_role="";
		 var uid="";
		 selected_role=$("#user_role_dropdown").val();
		 uid=$("#user_dropdown").val();

		var list_type="api_job_summary_report"; 
		//var full_url = window.location.origin;
		table= $('#send_report_tbl').DataTable({
        	"processing": true,
        	"serverSide": true,
        	"cache":false,
        	"ajax":{
         			"type":"POST",
         			"url":full_url+"/controller/report_controller.php",
         			"data":function (post) {

 						post.list_type=list_type;

 						post.user_role=user_role;
 						post.selected_role=selected_role;
 						post.uid=uid;
 						if(frmDate!="" && toDate!=""){
 							post.frmDate = frmDate;
                    		post.toDate = toDate;
 						}
 					}	
 				},
 			
         	"order": [[ 1, "desc" ]],
         	"columnDefs": [
        				{"className": "dt-center", "targets": "_all"},
        				/*{ 'visible': false, 'targets': [8] },*/
        				/*{ 'visible': false, 'targets': [9] }*/
      		],
      		"bDestroy": true
    	});
}


function load_send_job_data()
{

		var job_id=$("#job_id").text();
		var table_name=$("#table_name").text();
		var dtlstable=$("#dtlstable").text();
		var job_date=$("#job_date").text();
		//var full_url = window.location.origin;
		/*alert(job_date);*/
	    $.ajax({
        url: full_url+'/controller/report_controller.php',
        type: 'post',
        cache: false,
        data:'list_type=api_job_data&job_id='+job_id+"&table_name="+table_name+"&job_date="+job_date,
        dataType:'json',
        success: function(data){
        	var res = JSON.parse(JSON.stringify(data));

			console.log(data);

			$("#sender_id").html(res[0]['senderid_name']);
			$("#download").html("<a href='#'>download_send_job_"+job_id+"</a>");
			if(res[0]['campaign_name']!='')
			{
				$("#campaign_name").html(res[0]['campaign_name']);
			}
			else
			{
				$("#campaign_name").html('NA');
			}
			//var msg=decodeURI(res[0]['message']);
			$("#text").html(res[1]['msg']);
			$("#ip_address").html(res[0]['ip_address']);
			var text_type="";
			if(res[0]['unicode_type']==0)
			{
				text_type="Text";
			}
			else
			{
				text_type="Unicode";
			}
			$("#text_type").html(text_type);
			// $("#timestamp").html(res[0]['sent_at']);
			var timestamp = res[0]['sent_at'];
			// Convert timestamp to Date object
			var dateObj = new Date(timestamp);

			// Convert to desired format 'Y-m-d H:i:s a'
			var options = { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };
			var formattedDateTime = dateObj.toLocaleString('en-US', options);

			// Output the result to the element with id 'timestamp'
			$("#timestamp").html(formattedDateTime);
			$("#method").html(res[0]['method']);
			$("#sent_through").html(res[0]['form_type']);
			$("#gvsms").html(res[0]['gvsms']);

			
			var sub=0,deli=0,rej=0,fail=0,null_stat=0;
			var send_job_dtls="";
			var charset="";
			var total_bill=0;
			var dlr_status="";
			var status_credit=0;
			var status_data="";
			var credit_count=0;
			var chart_data="";
			var chart_status="";
			var series1 = [];
			for(var i=2;i<res.length;i++)
			{
				total_bill+=parseInt(res[i]['sum_msgcredit']);
				//console.log(total_bill);
				dlr_status=res[i]['status'];
				status_credit=parseInt(res[i]['sum_msgcredit']);
				credit_count=parseInt(res[i]['msgcredit']);
				status_data+="<tr><td>"+dlr_status+"</td><td>"+status_credit+"</td></tr>";
				if(i==(res.length-1))
				{
					chart_data+="{name:'"+dlr_status+"',y:"+status_credit+"},";
					chart_status="['"+dlr_status+"',"+parseInt(10)+"]";
				}
				else
				{
					chart_data+="{name:'"+dlr_status+"',y:"+status_credit+"},";
					chart_status="['"+dlr_status+"',"+parseInt(10)+"]";

				}

					
				series1.push({
			        name: dlr_status,
			        y:status_credit
			    });
				

				/*if(res[i]['unicode_type']==0)
				{
					charset="Text";
				}
				else
				{
					charset="Unicode";
				}*/


			}
			//console.log(series1);
			$("#msg_status").append(status_data);
			$("#total_bill").html(total_bill);
			
Highcharts.chart('container', {
  chart: {
    type: 'pie',
    options3d: {
      enabled: true,
      alpha: 45,
      beta: 0
    }
  },
  title: {
    text: 'Job Status'
  },
  accessibility: {
    point: {
      valueSuffix: '%'
    }
  },
  tooltip: {
    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      depth: 35,
      dataLabels: {
        enabled: true,
        format: '{point.name}'
      }
    }
  },
  series: [{
    type: 'pie',
    name: 'Job Status',
    data: 
    	series1
    }]
});


			/*$("#msg_credit").html(res[0]['msgcredit']);
			$("#msg_status").html(res[0]['msgcredit']);*/
			
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            alert(errorMsg);
            
        }
    });


	    var list_type="api_job_table_dtls"; 
		//var full_url = window.location.origin;
		table= $('#send_job_details_tbl').DataTable({
        	"processing": true,
        	"serverSide": true,

        	"ajax":{
         			"type":"POST",
         			"url":full_url+"/controller/report_controller.php",
         			"data":function (post) {
 						post.list_type=list_type;
 						post.job_id=job_id;
 						post.job_date=job_date;
 						/*if(frmDate!="" && toDate!=""){
 							post.frmDate = frmDate;
                    		post.toDate = toDate;
 						}*/
 					}
 				},
          /*	"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, 75]],*/
          /*	"dom": 'Blfrtip',
        	"buttons":[{
					extend: 'collection',
	        		className: 'exportButton btn btn-primary',
	        		text: 'Data Export',
	        		titleAttr: 'Send Job Report',
	        		buttons: [{ extend: 'csv', className: 'btn btn-primary',title:'Send Job Report',exportOptions: { modifier: { page: 'all', search: false } } },
						{ extend: 'excel', className: 'btn btn-primary',title:'Send Job Report' },
						{ extend: 'pdf', className: 'btn btn-primary',title:'Send Job Report' },
						{ extend: 'print', className: 'btn btn-primary',title:'Send Job Report' },],
				
				}],
          	stateSave: false,*/
         	"order": [[ 0, "desc" ]],
         	"columnDefs": [
        				{"className": "dt-center", "targets": "_all"},
        				{ /*'visible': false, 'targets': [3]*/ }
      		]
    	});



}

function load_users()
{
    //var full_url = window.location.origin;

    var role=$("#user_role_dropdown").val();
    $(".role_name").text(role);
           $.ajax({
                url: full_url+'/controller/user_controller.php',
                type: 'post',
                cache: false,
                data:'list_type=load_userslist&role='+role,
                async:true,

                success: function(data){
                  /*alert(data);*/
                  $("#user_dropdown").empty();
                  $("#user_dropdown").append(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}

function test()
{
	alert('test');
}
function load_user_chart(){
	//var full_url = window.location.origin;
    $.ajax({
        url: full_url+'/controller/report_controller.php',
        type: 'post',
        cache: false,
        data:'list_type=user_chart',
        dataType:'json',
        success: function(data){
        	var res = JSON.parse(JSON.stringify(data));
			// alert(data);
    		const data1 = {
	      		labels: ['Submitted', 'Delivered', 'Undelivered', 'Rejected', 'Failed', 'Null'],
	      		datasets: [{
	        		label: 'Today Record',
	        		backgroundColor: 'rgb(255, 99, 132)',
	        		borderColor: 'rgb(255, 99, 132)',
	        		// data: [res['submitted'], res['DELIVRD'], res['undelivered'],res['Rejected'], res['Failed'], res['null_stat']],
	        		data: [res['submitted'], res['DELIVRD'], res['undelivered'],res['Rejected'], res['Failed'], res['null_stat']],
	      		}]
	    	};
		    const config = {
	  			type: 'doughnut',
	  			data: data,
			};
    		const myChart = new Chart(document.getElementById('myChart'),config);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            alert(data);
            //$('#content').html(errorMsg);
        }
    });
}

function searchData_report() {
	/*alert('sdf');*/
    frmDate = ($("#frmDate").val()) ? $("#frmDate").val() : '';
   
    toDate = ($("#toDate").val()) ? $("#toDate").val() : '';
    table.draw();
}