var table;
var frmDate = "";
var toDate = ""; 
var today_report_type="";


			
$(function() {

	$.fn.dataTable.ext.search.push(
		function(settings, searchData, index, rowData, counter) {
			var searchTerm = $('#send_report_tbl_filter input').val(); // Get the search term from the search input field
			var columnIndex = 2; // Assuming the column index of the formatted value is 2
	
			// Format the value from the table
			var formattedValue = formatValue(rowData[columnIndex]);
	
			// Perform search based on the formatted value
			if (formattedValue.toLowerCase().includes(searchTerm.toLowerCase())) {
				return true; // Match found
			}
			return false; // No match
		}
	);
	
	function formatValue(value) {
		// Your formatting logic here
		// Example: If value is a date, format it accordingly
		// Example: If value is a number, format it with commas, decimals, etc.
		// Example: If value is a string, format it as needed
		return value; // Return the formatted value
	}
	
	// Re-draw the DataTable when the search input changes
	$('#send_report_tbl_filter input').on('keyup', function() {
		table.draw();
	});

		
		$(document).on('click', '.view_delivery_count', function() {
			var full_url = window.location.origin+"/itswe_sms_app";
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
                    data:'job_id='+itemId+"&list_type=show_delivery_count"+"&month="+month,
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
	if(page_name=="Send Job"){
		load_send_job_data();

		$(document).on('click','#download_report_btn',function(){
			
			var job_id=$("#job_id").text();
			var job_date=$("#job_date").text();
			var table_name=$("#table_name").text();
			var full_url = window.location.origin+"/itswe_sms_app";


				 $.ajax({
                    url: full_url+"/controller/download_report_controller.php",
                    type: 'post',
                    data:'job_id='+job_id+"&list_type=download_report&job_date="+job_date+"&table_name="+table_name,
                    cache: false,
					beforeSend: function(){
						$("#loading_modal").modal('show');
					  },
					  complete: function(){
					   $("#loading_modal").modal('hide');
					  },
                    success: function(data){
                    	console.log(data);

						var link = document.createElement('a');
						link.href = full_url+"/controller/"+data;
						link.download = "Send_job_report.zip";
						document.body.appendChild(link);
						link.click();
						document.body.removeChild(link);
					//window.open(full_url+"/controller/download_report_controller.php?job_id="+job_id+"&list_type=download_report&job_date="+job_date+"&table_name="+table_name);
    
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

	if(page_name=='Send Jobs'){

		load_send_jobs_report();






		$(document).on('click','#download_report_btn',function(){
			
			var list_type="send_job_summary_report"; 
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


			
			})
	}




});




function load_send_jobs_report()
{

		 var user_role=$("#user_role").val();
		// alert(user_role);
		 var selected_role="";
		 var uid="";
		 selected_role=$("#user_role_dropdown").val();
		 uid=$("#user_dropdown").val();

		var list_type="send_job_summary_report"; 
		var full_url = window.location.origin+"/itswe_sms_app";
		table= $('#send_report_tbl').DataTable({
        	"processing": true,
        	"serverSide": true,
			"lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]] ,
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
						{"targets": [2], // Third column (index 2)
						"visible": function() {
							return user_role !== 'mds_usr'; // Hide if user_role is 'usr'
						}}
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
		var full_url = window.location.origin+"/itswe_sms_app";
		/*alert(job_date);*/
	    $.ajax({
        url: full_url+'/controller/report_controller.php',
        type: 'post',
        cache: false,
        data:'list_type=send_job_data&job_id='+job_id+"&table_name="+table_name+"&job_date="+job_date,
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
			var timestamp = res[0]['sent_at'];
			// Convert timestamp to Date object
			var dateObj = new Date(timestamp);

			// Convert to desired format 'Y-m-d H:i:s a'
			var options = { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true };
			var formattedDateTime = dateObj.toLocaleString('en-US', options);

			// Output the result to the element with id 'timestamp'
			$("#timestamp").html(formattedDateTime);
			$("#method").html(res[0]['method']);
			var sent_through="";
			if(res[0]['form_type']=='Bulk')
			{
				sent_through="Web";
			}
			else{
				sent_through=res[0]['form_type'];
			}
			$("#sent_through").html(sent_through);
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
			var status_label = [];
			let statuses = [];
let chartLabels = [];     // Array to hold the chart labels
let chartDataValues = [];  // Array to hold the chart data values
let backgroundColors = []; 
const colors = [
	"rgba(69, 43, 144, 1)", "rgba(43, 193, 85, 1)", "rgba(139, 199, 64, 1)", "rgba(255, 99, 132, 1)",
	"rgba(54, 162, 235, 1)", "rgba(255, 206, 86, 1)", "rgba(75, 192, 192, 1)", "rgba(153, 102, 255, 1)",
	"rgba(255, 159, 64, 1)", "rgba(199, 199, 199, 1)", "rgba(255, 87, 51, 1)", "rgba(160, 160, 160, 1)",
	"rgba(0, 128, 128, 1)", "rgba(255, 20, 147, 1)", "rgba(138, 43, 226, 1)"
];
				for (let i = 2; i < res.length; i++) {
					total_bill += parseInt(res[i]['sum_msgcredit']);
				}
			
			for(var i=2;i<res.length;i++)
			{
				 
				//console.log(total_bill);
				dlr_status=res[i]['status'];
				status_credit=parseInt(res[i]['sum_msgcredit']);
				let percentage = ((status_credit / total_bill) * 100).toFixed(2);
				credit_count=parseInt(res[i]['msgcredit']);
				//status_data+="<tr><td>"+dlr_status+"</td><td>"+status_credit+"</td></tr>";
				chartLabels.push(dlr_status);             // Adding each status as a label
				chartDataValues.push(percentage);       // Adding each credit as a data value
				// Cycle colors based on index

				// Push to statuses array (useful for other non-chart data manipulations)
				statuses.push({ dlr_status, status_credit });
				
				//statuses.push({'dlr_status':dlr_status,'status_credit':status_credit});
				// if(i==(res.length-1))
				// {
					
				// 	chart_data+="{name:'"+dlr_status+"',y:"+status_credit+"},";
				// 	chart_status="['"+dlr_status+"',"+parseInt(10)+"]";
				// }
				// else
				// {
					
				// 	chart_data+="{name:'"+dlr_status+"',y:"+status_credit+"},";
				// 	chart_status="['"+dlr_status+"',"+parseInt(10)+"]";

				// }
				backgroundColors.push(colors[i % colors.length]);
				status_data += `<li><i class='fa fa-circle' style='color: ${colors[i % colors.length]}; margin-right: 5px;'></i>${dlr_status} - ${status_credit}</li>`;

    		
				//status_data+="<li><i class='fa fa-circle text-primary me-1'></i>"+dlr_status+" - "+status_credit+"</li>";
				// series1.push({
			    //     name: dlr_status,
			    //     y:status_credit
			    // });

				series1.push(
					status_credit
					 );

				

				/*if(res[i]['unicode_type']==0)
				{
					charset="Text";
				}
				else
				{
					charset="Unicode";
				}*/


			}
			$(".chart-point-list").append(status_data);
			//console.log(series1);
			$("#msg_status").append(status_data);
			$("#total_bill").html(total_bill);
			
// Highcharts.chart('container', {
//   chart: {
//     type: 'pie',
//     options3d: {
//       enabled: true,
//       alpha: 45,
//       beta: 0
//     }
//   },
//   title: {
//     text: 'Job Status'
//   },
//   accessibility: {
//     point: {
//       valueSuffix: '%'
//     }
//   },
//   tooltip: {
//     pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
//   },
//   plotOptions: {
//     pie: {
//       allowPointSelect: true,
//       cursor: 'pointer',
//       depth: 35,
//       dataLabels: {
//         enabled: true,
//         format: '{point.name}'
//       }
//     }
//   },
//   series: [{
//     type: 'pie',
//     name: 'Job Status',
//     data: 
//     	series1
//     }]
// });

var doughnutChart = function(){
	console.log(series1);
	if(jQuery('#doughnut_chart').length > 0 ){
		//doughut chart
		const doughnut_chart = document.getElementById("doughnut_chart").getContext('2d');

		// Get the reference to the existing chart with ID 'doughnut_chart'
		var existingChart = Chart.getChart(doughnut_chart.canvas.id);

		// Check if the chart exists
		if (existingChart) {
			// Destroy the existing chart
			existingChart.destroy();
		}
		// doughnut_chart.height = 100;
		new Chart(doughnut_chart, {
			type: 'doughnut',
			data: {
				weight: 5,	
				defaultFontFamily: 'Poppins',
				datasets: [{
					data: chartDataValues,
					borderWidth: 3, 
					borderColor: "rgba(255,255,255,1)",
					backgroundColor:backgroundColors,
					hoverBackgroundColor: backgroundColors.map(color => color.replace(", 1)", ", 0.9)"))

				}],
				
				// labels: [
				//     "green",
				//     "green",
				//     "green",
				//     "green"
				// ]
			},
			options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: 30,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {callbacks: {
						label: function(context) {
							// Show the status and the raw percentage
							let label = context.label || '';
							let value = context.raw || 0;
							return `${label}: ${value}%`;
						}
					},
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderWidth: 0
                    }
                }
            }
		});
	}
}


doughnutChart(); 
			/*$("#msg_credit").html(res[0]['msgcredit']);
			$("#msg_status").html(res[0]['msgcredit']);*/
			
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            alert(errorMsg);
            
        }
    });




	    var list_type="send_job_table_dtls"; 

		var login_userrole=$("#login_userrole").val();
		var full_url = window.location.origin+"/itswe_sms_app";
		var columnDefs = [
			{"className": "dt-center", "targets": "_all"}
		];

	
		// Check if login_userrole is 'adm' and add visibility setting to columnDefs
		if (login_userrole != 'mds_adm') {
			columnDefs.push({ 'visible': false, 'targets': [11] }); // Change the index [3] to the column index you want to hide
		}
		table= $('#send_job_details_tbl').DataTable({
        	"processing": true,
        	"serverSide": true,
			responsive: true,
			language: {
				paginate: {
					next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
				  previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>' 
				}
			},

        	"ajax":{
         			"type":"POST",
         			"url":full_url+"/controller/report_controller.php",
         			"data":function (post) {
 						post.list_type=list_type;
 						post.job_id=job_id;
 						post.job_date=job_date;
 						
 					}
 				},
         	"order": [[ 0, "desc" ]],
         	"columnDefs": columnDefs
    	});



}

function load_users()
{
    var full_url = window.location.origin+"/itswe_sms_app";

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
	var full_url = window.location.origin+"/itswe_sms_app";
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