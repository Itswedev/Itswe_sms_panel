var table;
var frmDate = "";
var toDate = ""; 
var today_report_type="";


			
$(function() {
	var page_name=$("#page_name").html();
	if(page_name=="RCS Job"){
		load_send_job_data();

// 		$(document).on('click','#download_report_btn',function(){
// 			//exportToExcel('rcs_job_details_tbl', 'RCS_Job_Report');
			
// 			// $("#rcs_job_details_tbl").table2excel({

// 			//     // exclude CSS class

// 			//     exclude:".noExl",

// 			//     name:"Worksheet Name",

// 			//     filename:"RCS Job Report",//do not include extension

// 			//     fileext:".xls" ,// file extension
// 			// 	exclude_img: true,
// 			// 	exclude_links: true,
// 			// 	exclude_inputs: true

// 			//   });


// 			 table = $("#rcs_job_details_tbl").DataTable();

// // Wait for the DataTable to finish loading all data
// table.one('draw', function () {
//     // Disable pagination to ensure all rows are visible
//     table.page.len(-1).draw();

//     // Export all data to Excel
//     $("#rcs_job_details_tbl").table2excel({
//         exclude: ".noExl",
//         name: "Worksheet Name",
//         filename: "RCS Job Report", // do not include extension
//         fileext: ".xls", // file extension
//         exclude_img: true,
//         exclude_links: true,
//         exclude_inputs: true
//     });

//     // Re-enable pagination (if needed)
//     table.page.len(10).draw(); // Set back to your desired page length
// });

// // Trigger a redraw to ensure the DataTable finishes loading all data
// table.draw();

// })

$(document).on('click', '#download_report_btn', function () {
    var table = $("#rcs_job_details_tbl").DataTable();

    // Store the current page info
    var pageInfo = table.page.info();

    // Disable pagination to ensure all rows are visible
    table.page.len(-1).draw();

    // Wait for the DataTable to finish loading all data
    table.one('draw', function () {
        // Export all data to Excel
        $("#rcs_job_details_tbl").table2excel({
            exclude: ".noExl",
            name: "Worksheet Name",
            filename: "RCS Job Report", // do not include extension
            fileext: ".xls", // file extension
            exclude_img: true,
            exclude_links: true,
            exclude_inputs: true,
            onComplete: function() {
				console.log('download completed');
                // Re-enable pagination after export
                table.page.len(pageInfo.length).page(pageInfo.page).draw('page');
            }
        });
    });

    // Trigger a redraw to ensure the DataTable finishes loading all data
    table.draw();
});


 	}




	function exportToExcel(tableId, filename) {
		// Select the DataTable
		var table = $('#' + tableId).DataTable();
	
		// Get all data from the DataTable
		var data = table.rows().data().toArray();
	
		// Create a new Excel file
		var wb = XLSX.utils.book_new();
	
		// Convert data to a worksheet
		var ws = XLSX.utils.aoa_to_sheet(data);
	
		// Add the worksheet to the workbook
		XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
	
		// Save the workbook as an Excel file
		XLSX.writeFile(wb, filename + '.xlsx');
	}


	if(page_name=='RCS Jobs'){




		var list_type="rcs_job_summary_report"; 
		//var full_url = window.location.origin;
		table= $('#rcs_report_tbl').DataTable({
        	"processing": true,
        	"serverSide": true,

        	"ajax":{
         			"type":"POST",
         			"url":full_url+"/controller/report_controller.php",
         			"data":function (post) {
 						post.list_type=list_type;
 						if(frmDate!="" && toDate!=""){
 							post.frmDate = frmDate;
                    		post.toDate = toDate;
 						}
 					}
 				},
 			  "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 5 ).footer() ).html(total);
        },
          	"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, 75]],
          	"dom": 'Blfrtip',
        	"buttons":[{
					extend: 'collection',
	        		className: 'exportButton btn btn-primary',
	        		text: 'Data Export',
	        		titleAttr: 'Job Summary Report',
	        		buttons: [{ extend: 'csv', className: 'btn btn-primary',title:'Send Job Summary Report1',exportOptions: { modifier: { page: 'all', search: 'none' } } },
						{ extend: 'excel', className: 'btn btn-primary',title:'Send Job Summary Report' },
						{ extend: 'pdf', className: 'btn btn-primary',title:'Send Job Summary Report' },
						{ extend: 'print', className: 'btn btn-primary',title:'Send Job Summary Report' },],
				
				}],
          	stateSave: true,
         	"order": [[ 0, "desc" ]],
         	"columnDefs": [
        				{"className": "dt-center", "targets": "_all"},
        				/*{ 'visible': false, 'targets': [5] }*/
      		],
      		"bDestroy": true
    	});
	}

});


function searchData_report() {
	//alert('sdf');
    frmDate = ($("#frmDate").val()) ? $("#frmDate").val() : '';
   
    toDate = ($("#toDate").val()) ? $("#toDate").val() : '';
    table.draw();
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
        data:'list_type=rcs_job_data&job_id='+job_id+"&table_name="+table_name+"&job_date="+job_date,
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
			
			$("#text").html(res[0]['message']);
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
			$("#timestamp").html(res[0]['sent_at']);
			$("#method").html(res[0]['method']);
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
			for(var i=1;i<res.length;i++)
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
			console.log(series1);
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


	    var list_type="rcs_job_table_dtls"; 
		//var full_url = window.location.origin;
		table= $('#rcs_job_details_tbl').DataTable({
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

function searchData() {
    frmDate = ($("#frmDate").val()) ? $("#frmDate").val() : '';
    toDate = ($("#toDate").val()) ? $("#toDate").val() : '';
    table.draw();
}