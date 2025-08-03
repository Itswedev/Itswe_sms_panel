
    var table;
    var frmDate = "";
    var toDate = "";
 
var today_report_type="";
            
$(function() {


	
	function formatValue(value) {
		// Your formatting logic here
		// Example: If value is a date, format it accordingly
		// Example: If value is a number, format it with commas, decimals, etc.
		// Example: If value is a string, format it as needed
		return value; // Return the formatted value
	}
	
	// Re-draw the DataTable when the search input changes
   


    // $.fn.dataTable.ext.search.push(
	// 	function(settings, searchData, index, rowData, counter) {
	// 		// Get the cell element containing the formatted data
	// 		var cell = table.cell({ row: index, column: 2 }).node(); // Assuming you want to search the third column (index 2)

	// 		// Get the formatted value
	// 		var formattedValue = $(cell).html().toLowerCase();

	// 		// Get the search term
	// 		var searchTerm = table.search().toLowerCase();

	// 		// Perform case-insensitive search
	// 		return formattedValue.includes(searchTerm);
	// 	}
	// );


	// // Trigger search on input in the DataTables search box
	// $('#archive_report_tbl input').on('keyup', function() {
	// 	table.draw();
	// });

    $(document).on('click', '#download_today_report_btn', function() {



        var list_type = "today_report_download";
        var today_report = $("#report_type").val();
        var selected_role = $("#selected_role").val();
        var user_role = $("#user_role").val();
        var uid = $("#uid").val();
        var full_url = window.location.origin;
        
        // Construct the URL with query parameters
        var url = full_url + "/controller/report_controller.php?";
        url += "list_type=" + list_type;
        url += "&report_type=" + today_report;
        url += "&selected_role=" + selected_role;
        url += "&user_role=" + user_role;
        url += "&uid=" + uid;
    
        // Redirect to the URL
        window.location.href = url;

        $.ajax({
            url: url,
            method: 'get',
            success: function(response) {
                console.log(response);
                window.open(url);

            },
            error: function(xhr, status, error) {
                // Hide loading image in case of error
                $('#loading_image').hide();
                console.error(xhr.responseText);
            }
        });
    });

        $(document).on('click', '.view_delivery_count', function() {
            var full_url = window.location.origin;
         var itemId = $(this).data('item-id');

         var frmDate = $("#frmDate").val();
         var toDate = $("#toDate").val();

        var month = 0;
        month = new Date(frmDate).getMonth();

        month = month + 1 ;

       
         var span_id = "#delivery_count_"+itemId;
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

    /*$("#user_role_dropdown").chosen();
     $("#user_role_dropdown_chosen").css('width','80%');*/
         /*$("#user_dropdown").chosen();
         $(`#user_dropdown_chosen`).trigger("chosen:updated");
     $("#user_dropdown_chosen").css('width','80%');*/

    var page_name=$("#page_name").html();
   
    if(page_name=='Today Summary Report')
    {
        var user_role=$("#user_role").val();
        if(user_role=="mds_rs" || user_role=="mds_ad" || user_role=="mds_adm")
        {
            $("#user_dropdown").change(function(){
       
            load_today_summary_report();

            })
        }
        else
        {
            load_today_summary_report();
            
        }


    
        
    }
    else if(page_name=='Today Summary Report test')
    {
        var user_role=$("#user_role").val();
        if(user_role=="mds_rs" || user_role=="mds_ad" || user_role=="mds_adm")
        {
            $("#user_dropdown_test").change(function(){
       
            load_today_summary_report_test();

            })
        }
        else
        {
            load_today_summary_report_test();
            
        }
        
    }
    else if(page_name=='Today Report')
    {

         //today_report_type="total";
         var list_type="today_report";
         var today_report=$("#report_type").val();
          var selected_role=$("#selected_role").val();

 var user_role=$("#user_role").val();

 var uid=$("#uid").val();
         var full_url = window.location.origin;
    
         
         table= $('#today_report_tbl').DataTable( {
        "processing": true,
        "serverSide": true,
        "responsive": true,
      
         "ajax": {
                    "type":"POST",
                    "url":full_url+"/controller/report_controller.php",
                    "data":function (post) {
                                post.list_type=list_type;
                                post.report_type=today_report;
                                post.user_role=user_role; 
                                post.uid=uid; 
                                post.selected_role=selected_role; 
                               
                               
                                if(frmDate!="" && toDate!="")
                                {
                                     post.frmDate = frmDate;
                                    post.toDate = toDate;
                                }
                        }
         },
         "order": [[10, 'desc']]
        });

       

    }
    else if(page_name=='Today Report test')
    {



 //today_report_type="total";
         var list_type="today_report_test";
         var today_report=$("#report_type").val();
          var selected_role=$("#selected_role").val();

 var user_role=$("#user_role").val();

 var uid=$("#uid").val();
         var full_url = window.location.origin;
         table= $('#today_report_tbl').DataTable( {
        "processing": true,
        "serverSide": true,
        "responsive": true,
         "ajax": {
                    "type":"POST",
                    "url":full_url+"/controller/report_controller.php",
                    "data":function (post) {
                                post.list_type=list_type;
                                post.report_type=today_report;
                                post.user_role=user_role; 
                                post.uid=uid; 
                                post.selected_role=selected_role; 
                               
                               
                                if(frmDate!="" && toDate!="")
                                {
                                     post.frmDate = frmDate;
                                    post.toDate = toDate;
                                }
                        

                           
                        }
         },
        /* "footerCallback": function ( row, data, start, end, display ) {
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
        },*/
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, 500]],
         /* "dom": 'Blfrtip',
        "buttons":[{
                  extend: 'collection',
                  className: 'exportButton btn btn-primary',
                  text: 'Data Export',
                  titleAttr: 'Today Report',
                  buttons: [{ extend: 'csv', className: 'btn btn-primary',title:'Today Report' },
                  { extend: 'excel', className: 'btn btn-primary',title:'Today Report' },
                  { extend: 'pdf', className: 'btn btn-primary',title:'Today Report' },
                  { extend: 'print', className: 'btn btn-primary',title:'Today Report' },],
                  exportOptions: {
                  modifer: {
                  page: 'all',
                     }
                  },

                }],
          stateSave: true,*/
         "order": [[ 8, "desc" ]],
          "columnDefs": [
                        {"className": "dt-center", "targets": "_all"}
            ]

        } );
       


    }
    else if(page_name=='Archive Report')
    {

       
       
    



 var user_role=$("#user_role").val();
        if(user_role=="mds_rs" || user_role=='mds_ad')
        {
            $("#user_dropdown").change(function(){
       
            load_archive_report();
            

            })
        }
        else if(user_role=='mds_adm')
        {
           // load_username_dropdown();
           
            load_archive_report();
        }
        else
        {

           load_archive_report();
        }

      



        /*download archive report*/
            $(document).on('click','#download_report_btn',function(){
            
            var list_type="archive_report"; 
            var full_url = window.location.origin;

            var data_string="list_type="+list_type+"&frmDate="+frmDate+"&toDate="+toDate;
                 $.ajax({
                    url: full_url+"/controller/download_report_controller.php",
                    type: 'post',
                    data: data_string,
                    cache: false,
                    beforeSend: function(){
                     $('.ajax-loader').css("visibility", "visible");
                   },
                   complete: function(){
                    $('.ajax-loader').css("visibility", "hidden");
                   },
                    success: function(data){
                        //alert(data);
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
     else if(page_name=='download report')
    {

         $(document).on('click','#search_submit',function(){
            
       
                var full_url = window.location.origin;
                var user_role=$("#user_role").val();

                var frmDate=$("#frmDate").val();
                var toDate=$("#toDate").val();

                if((frmDate=="" || frmDate==undefined) || (toDate=="" || toDate==undefined))
                {
                    swal.fire(''," Please select from date and to date ",'error');
                    return false;
                }
                
                if(user_role=='mds_adm')
                {
                    var selected_role=$("#user_role_dropdown").val();
                    var select_user_id=$("#user_dropdown").val();
                    //alert(select_user_id);
                    if((selected_role=="" || selected_role==undefined))
                    {
                        
                        swal.fire(''," Please select Role ",'error');
                        return false;
                    } 
                    else if((select_user_id=="" || select_user_id==undefined))
                    {
                        swal.fire(''," Please select User ",'error');
                        return false;
                    }
                }
                
                 
            
                $.ajax({
                    url: full_url+'/controller/report_controller.php',
                    type: 'post',
                    cache: false, 
                    data:$("#download_report_form").serialize(),
                    async:true,
                     beforeSend: function(){
                         $('.ajax-loader').css("visibility", "visible");
                       },
                       complete: function(){
                        $('.ajax-loader').css("visibility", "hidden");
                       },
                    success: function(data){
                        console.log(data);
                        $(".download_archive_report_list").empty();
                        $(".download_archive_report_list").append(data);
                       
                       // console.log(data);
                 
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(errorMsg);
                        //$('#content').html(errorMsg);
                      }
                });
            
            })


              $(document).on('click','#download_count_report',function(){
            
       
                var full_url = window.location.origin;
          
               $.ajax({
                    url: full_url+'/controller/download_report_controller.php',
                    type: 'post',
                    cache: false, 
                    data:$("#download_report_form").serialize(),
                    async:true,
                     beforeSend: function(){
                         $('.ajax-loader').css("visibility", "visible");
                       },
                       complete: function(){
                        $('.ajax-loader').css("visibility", "hidden");
                       },
                    success: function(){
                      
                       
                       // console.log(data);
                 
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(errorMsg);
                        //$('#content').html(errorMsg);
                      }
                });
            
            })


 var user_role=$("#user_role").val();
        if(user_role=="mds_rs" || user_role=='mds_ad')
        {
            $("#user_dropdown").change(function(){
       
           // load_downlaod_report();

            })
        }
        else if(user_role=='mds_adm')
        {
           // load_username_dropdown();
           
          //  load_downlaod_report();
        }
        else
        {

          // load_downlaod_report();
        }

        /*download archive report*/
     /*       $(document).on('click','#download_report_btn',function(){
            
            var list_type="download_report"; 
            var full_url = window.location.origin;

            var data_string="list_type="+list_type+"&frmDate="+frmDate+"&toDate="+toDate;
                 $.ajax({
                    url: full_url+"/controller/download_report_controller.php",
                    type: 'post',
                    data: data_string,
                    cache: false,
                    beforeSend: function(){
                     $('.ajax-loader').css("visibility", "visible");
                   },
                   complete: function(){
                    $('.ajax-loader').css("visibility", "hidden");
                   },
                    success: function(data){
                        //alert(data);
                    window.open(full_url+"/controller/download_report_controller.php?"+data_string);
    
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(errorMsg);
                        //$('#content').html(errorMsg);
                      }
                });


            
            })*/
        
    }
    else if(page_name=='Scheduled Report')
    {
        var user_role=$("#user_role").val();
        if(user_role=="mds_rs" || user_role=='mds_ad' || user_role=='mds_adm')
        {
            $("#user_dropdown").change(function(){
       
            load_scheduled_report();

            })
        }
        else
        {
            load_scheduled_report();
        }
        



         $(document).on( "click", '.delete_message_job_btn',function(e) {

            
            var msg_id = $(this).data('id');
            var table_name = $(this).data('tblname');
            
        /*  alert(table_name);*/

        swal.fire({
            title: 'Are you sure?',
            text: "You want to delete this schedule!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#2c7be5',
            cancelButtonColor: '#748194',
            confirmButtonText: 'Yes',
            showClass: {
                popup: 'animate__animated animate__heartBeat'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
            }).then((result) => {
            if (result.isConfirmed) {
                var full_url = window.location.origin;
                        $.ajax({
                            url: full_url+'/controller/report_controller.php',
                            type: 'post',
                            cache: false, 
                            data:'list_type=delete_schedule&msg_id='+msg_id+'&table_name='+table_name,
                            success: function(data){
                            swal.fire('',data,'success').then((value) => {
                                        location.reload();
                                        });
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                                alert(errorMsg);
                                //$('#content').html(errorMsg);
                            }
                        });

                    }
        });


          
        });



        $(document).on( "click", '.reschedule_message_job_btn',function(e) {
            var msg_id = $(this).data('job_id');
            var old_date = $(this).data('old_date');
            var table_name = $(this).data('tblname');
            $("#msg_job_id").val(msg_id);
            $("#old_date").val(old_date);
            $("#reschedule_form").modal('show');
          
        });


        $(document).on( "click", '#reschedule_now_btn',function(e) {
            var msg_id = $("#msg_job_id").val();
            var old_date = $("#old_date").val();
            var schedule_date = $("#datepicker").val();

            if(schedule_date=='')
                {
                    swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please select reschedule date',
                        footer: ''
                      })

                    return false;
                }
                else{
                    swal.fire({
                        title: 'Are you sure?',
                        html: "You want to Reschedule this campaign!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#2c7be5',
                        cancelButtonColor: '#748194',
                        confirmButtonText: 'Yes',
                        showClass: {
                            popup: 'animate__animated animate__heartBeat'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                        }).then((result) => {
                        if (result.isConfirmed) {

                            var full_url = window.location.origin;
                            $.ajax({
                                url: full_url+'/controller/report_controller.php',
                                type: 'post',
                                cache: false, 
                                data:'list_type=reschedule_campaign&msg_id='+msg_id+'&schedule_date='+schedule_date+'&old_date='+old_date,
                                success: function(data){
                                    console.log(data);

                                swal.fire('',data,'success').then((value) => {
                                    location.reload();
                                            });
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                                    alert(errorMsg);
                                    //$('#content').html(errorMsg);
                                }
                            });
    
                        }


                        
                    });
                }
     
          
        });


        
        

        
    }




//     $(document).on("click",".report_type", function (e) {
//         var report_status=$(this).attr('name');
//         var user_role = $(this).data('role');
//         var selected_role = $(this).data('selected_role');

//         var uid = $(this).data('uid');
//         //sessionStorage.setItem("report_type",report_status);
//         window.location.href="dashboard.php?page=today_report&report_type="+report_status+"&user_role="+user_role+"&uid="+uid+"&selected_role="+selected_role;
// });


$(document).on("click", ".report_type", function (e) {
    e.preventDefault(); // Prevent default action if needed

    var report_status = $(this).attr('name');
    var user_role = $(this).data('role');
    var selected_role = $(this).data('selected_role');
    var uid = $(this).data('uid');

    // Create a form dynamically
    var form = document.createElement("form");
    form.method = "POST";
    form.action = "dashboard.php?page=today_report";

    // Add hidden input fields for each data parameter
    var inputs = {
        report_type: report_status,
        user_role: user_role,
        uid: uid,
        selected_role: selected_role
    };

    for (var key in inputs) {
        if (inputs.hasOwnProperty(key)) {
            var input = document.createElement("input");
            input.type = "hidden";
            input.name = key;
            input.value = inputs[key];
            form.appendChild(input);
        }
    }

    // Append the form to the body and submit it
    document.body.appendChild(form);
    form.submit();
});


    function base64url_encode(data) {
    return encodeURIComponent(btoa(data))
        .replace(/%([0-9A-F]{2})/g, function(match, p1) {
            return String.fromCharCode('0x' + p1);
        });
}


     $(document).on("click",".report_type_test", function (e) {
        var report_status=$(this).attr('name');
        var user_role = $(this).data('role');
        var selected_role = $(this).data('selected_role');

        var uid = $(this).data('uid');

        var encoded_params = {
            'report_type': report_status,
            'user_role': user_role,
            'uid': uid,
            'selected_role': selected_role
        };
        var encoded_url_params = base64url_encode(JSON.stringify(encoded_params));

        // Construct the URL with encoded parameters
        var url = "dashboard.php?page=today_report_test&params=" + encoded_url_params;

        // Redirect to the new URL
        window.location.href = url;

        //sessionStorage.setItem("report_type",report_status);
       // window.location.href="dashboard.php?page=today_report_test&report_type="+report_status+"&user_role="+user_role+"&uid="+uid+"&selected_role="+selected_role;
});


    $(document).on("change","#user_role_dropdown", function (e) {

        var user_role=$("#user_role_dropdown").val();

        if(user_role!='All')
        {
            load_users();
        }
        else
        {
            if(page_name=='Today Summary Report')
            {
                load_today_summary_report();
            }
            else if(page_name=='Scheduled Report')
            {
                load_scheduled_report();
            }
            
        }
        
});


     $(document).on("change","#user_role_dropdown_test", function (e) {

        var user_role=$("#user_role_dropdown_test").val();

        if(user_role!='All')
        {
            load_users_test();
        }
        else
        {
            if(page_name=='Today Summary Report test')
            {
                load_today_summary_report_test();
            }
            else if(page_name=='Scheduled Report')
            {
                load_scheduled_report();
            }
            
        }
        
});


         
});


function searchData_report() {
	/*alert('sdf');*/
    frmDate = ($("#frmDate").val()) ? $("#frmDate").val() : '';
   
    toDate = ($("#toDate").val()) ? $("#toDate").val() : '';
    table.draw();
}



function load_username_dropdown()
{
        var full_url = window.location.origin;
            $.ajax({
                url: full_url+'/controller/user_controller.php',
                type: 'post',
                cache: false, 
                data:'list_type=archive_dropdown_user',
                success: function(data){
                
                   if(data!=0)
                   {
                    $('#user_dropdown').empty();
                    $('#user_dropdown').html(data);

                      $(`#user_dropdown_chosen`).trigger("chosen:updated");
                   $("#user_dropdown_chosen").css('width','100%');

                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
}

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

function load_archive_report()
{
    
        var list_type="archive_report";
        var full_url = window.location.origin;
        var selected_role=$("#user_role_dropdown").val();
        var user_role=$("#user_role").val();
        var u_id=$("#user_dropdown").val();

     /*   $('#archive_report_tbl thead th').each(function(){
            var title =$(this).text();
            $(this).html(title+"<input type='text' class='col-search-input form-control' placeholder='Search "+title+"'>");
        });
*/

         table= $('#archive_report_tbl').DataTable({
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "cache":false,
        language: {
            paginate: {
                next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
              previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>' 
            }
        },
         "ajax": {
                    "type":"POST",
                    "url":full_url+"/controller/report_controller.php",
                    "data":function (post) {
                           post.list_type=list_type;
                            post.user_role=user_role;
                            post.uid=u_id; 
                            post.selected_role=selected_role; 

                          
                            if(frmDate!="" && toDate!="")
                            {
                                 post.frmDate = frmDate;
                                post.toDate = toDate;
                            }
                           
                        }
         },
      
         "order": [[ 1, "desc" ]],
        
         "columnDefs": [
                        {"className": "dt-center", "targets": "_all","width":"20%"},
                        /*{ 'visible': false, 'targets': [8] }*/
            ]

        });

          
        // Define the custom search function
    $.fn.dataTable.ext.search.push(
        function(settings, searchData, index, rowData, counter) {
            console.log('Custom search function called');
            var searchTerm = $('#archive_report_tbl_filter input').val(); // Get the search term from the search input field
            var columnIndex = 2; // Index of the "Username" column

            // Format the value from the table (if necessary)
            var formattedValue = rowData[columnIndex]; // Assuming the value is already formatted

            // Perform search based on the formatted value
            if (formattedValue.toLowerCase().includes(searchTerm.toLowerCase())) {
                return true; // Match found
            }
            return false; // No match
        }
    );

    // Re-draw the DataTable when the search input changes
    $(document).on('keyup', '#archive_report_tbl_filter input', function() {
        table.draw();
    });

 
}



function load_downlaod_report()
{
    
        var list_type="download_archive_report";
        var full_url = window.location.origin;
        var selected_role=$("#user_role_dropdown").val();
        var user_role=$("#user_role").val();
        var u_id=$("#user_dropdown").val();
        var full_url = window.location.origin;
        var data_string="";
        var role=$("#user_role_dropdown").val();
        data_string='list_type='+list_type+'&role='+role;
        if(frmDate!="" && toDate!="")
            {
                                
                                data_string+="&frmDate="+frmDate+"&toDate="+toDate;

            }

     
    $(".role_name").text(role);
           $.ajax({
                url: full_url+'/controller/report_controller.php',
                type: 'post',
                cache: false, 
                data:data_string,
                async:true,
                 beforeSend: function(){
                     $('.ajax-loader').css("visibility", "visible");
                   },
                   complete: function(){
                    $('.ajax-loader').css("visibility", "hidden");
                   },
                success: function(data){
                    console.log(data);
                 $(".download_archive_report_list").empty();
                 $(".download_archive_report_list").append(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });

     /*   $('#archive_report_tbl thead th').each(function(){
            var title =$(this).text();
            $(this).html(title+"<input type='text' class='col-search-input form-control' placeholder='Search "+title+"'>");
        });
*/

/*         table= $('#download_archive_report_tbl').DataTable({
        "processing": true,
        "serverSide": true,
        "responsive": true,
         "ajax": {
                    "type":"POST",
                    "url":full_url+"/controller/report_controller.php",
                    "data":function (post) {
                           post.list_type=list_type;
                            post.user_role=user_role;
                            post.uid=u_id; 
                            post.selected_role=selected_role; 
                            if(frmDate!="" && toDate!="")
                            {
                                 post.frmDate = frmDate;
                                post.toDate = toDate;
                            }
                           
                        }
         },
          stateSave: false,
         "order": [[ 0, "desc" ]],
         "bDestroy": true,
         "columnDefs": [
                        {"className": "dt-center", "targets": "_all","orderable": false,"width":"20%"}
                        
            ]

        });*/

          /* table.columns.every(function(){
                var table2=this;

                $('input',this.header()).on('keyup change',function (){
                if(table2.search()!=this.value)
                {
                    table2.search(this.value).draw();
                }
                });
           })*/

          /*  $('#download_archive_report_tbl thead th').each(function () {
            var title = $(this).text();
            $(this).html(title+' <br><input type="text" id="input' + $(this).index() + '" class="col-search-input" placeholder="Search ' + title + '"  style="width:100%;"/>');
        });
        */
       /* table.columns().every(function () {
            var table = this;
             var val;
                val = $('#input' + $(this).index()).val();

                var title = $(this).text();
                console.log('titre =' + title);
            $('input', this.header()).on('keyup change', function () {
                if (table.search() !== this.value) {
                       table.search(this.value).draw();
                }
            });
        });*/
}
function load_scheduled_report()
{
        var list_type="schedule_report";
        var full_url = window.location.origin;
        var selected_role=$("#user_role_dropdown").val();
        var user_role=$("#user_role").val();
        var u_id=$("#user_dropdown").val();
         table= $('#scheduled_report_tbl').DataTable({
        "processing": true,
        "serverSide": true,
        "responsive": true,
			language: {
				paginate: {
					next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
				  previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>' 
				}
			},
         "ajax": {
                    "type":"POST",
                    "url":full_url+"/controller/report_controller.php",
                    "data":function (post) {
                            post.list_type=list_type;
                            post.user_role=user_role;
                            post.u_id=u_id; 
                            post.selected_role=selected_role; 

                            if(frmDate!="" && toDate!="")
                            {
                                 post.frmDate = frmDate;
                                post.toDate = toDate;
                            }
                           
                        },
                        "beforeSend": function(){
                            $("#loading_modal").modal('show');
                          },
                          "complete": function(){
                           $("#loading_modal").modal('hide');
                          }
         },
          "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, 500]],
          stateSave: false,
         "order": [[ 0, "desc" ]],
         "bDestroy": true
        

        });

        //table.column(11).visible(false);
}

function load_users()
{
    var full_url = window.location.origin;

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

                //  $(`#user_dropdown_chosen`).trigger("chosen:updated");
                //    $("#user_dropdown_chosen").css('width','100%');

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
}

function load_users_test()
{
    var full_url = window.location.origin;

    var role=$("#user_role_dropdown_test").val();
    $(".role_name").text(role);
           $.ajax({
                url: full_url+'/controller/user_controller.php',
                type: 'post',
                cache: false, 
                data:'list_type=load_userslist&role='+role,
                async:true,

                success: function(data){
                  /*alert(data);*/
                  $("#user_dropdown_test").empty();
                  $("#user_dropdown_test").append(data);

                //  $(`#user_dropdown_chosen`).trigger("chosen:updated");
                //    $("#user_dropdown_chosen").css('width','100%');

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
}
    function searchData() {
                frmDate = ($("#frmDate").val()) ? $("#frmDate").val() : '';
                toDate = ($("#toDate").val()) ? $("#toDate").val() : '';
                table.draw();
            }

function searchData_archive_report() {

    frmDate = ($("#frmDate").val()) ? $("#frmDate").val() : '';
   
    toDate = ($("#toDate").val()) ? $("#toDate").val() : '';
    table.draw();
}
function searchData_download_report() {

    frmDate = ($("#frmDate").val()) ? $("#frmDate").val() : '';
   
    toDate = ($("#toDate").val()) ? $("#toDate").val() : '';
   //load_downlaod_report();
}
function load_today_report()
{


    var full_url = window.location.origin;
    $.ajax({
                url: full_url+'/controller/report_controller.php',
                type: 'post',
                cache: false, 
                data:'list_type=load_today_report',
                /*dataType:'json',*/
                success: function(data){
                    //var res = JSON.parse(JSON.stringify(data));
                    console.log(data);
                   $("#today_report_list").html(data);
                    
                   
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });



  
}

function load_today_summary_report()
{
    //alert('summary');
    var full_url = window.location.origin;
    var selected_role=$("#user_role_dropdown").val();
    var user_role=$("#user_role").val();
    var u_id=$("#user_dropdown").val();
    var dataString="";
    if(user_role=='mds_rs' || user_role=='mds_ad' || user_role=='mds_adm')
    {
        dataString='list_type=load_today_summary'+'&user_role='+user_role+'&u_id='+u_id+'&selected_role='+selected_role;
    }
    else
    {
       dataString= 'list_type=load_today_summary'+'&user_role='+user_role;
    }


     $.ajax({
                url: full_url+'/controller/report_controller.php',
                type: 'post',
                data:dataString,
                cache: false,
                beforeSend: function(){
                    $("#loading_modal").modal('show');
                  },
                  complete: function(){
                   $("#loading_modal").modal('hide');
                  },
                success: function(data){
                    // alert('test');
                    // console.log(data);
                   if(data!=0)
                   {
                    $('#today_summary_list').empty();
                    $('#today_summary_list').html(data);
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}



function load_today_summary_report_test()
{
    //alert('summary');
    var full_url = window.location.origin;
    var selected_role=$("#user_role_dropdown_test").val();
    var user_role=$("#user_role").val();
    var u_id=$("#user_dropdown_test").val();
    var dataString="";
    if(user_role=='mds_rs' || user_role=='mds_ad' || user_role=='mds_adm')
    {
        dataString='list_type=load_today_summary_test'+'&user_role='+user_role+'&u_id='+u_id+'&selected_role='+selected_role;
    }
    else
    {
       dataString= 'list_type=load_today_summary_test'+'&user_role='+user_role;
    }


     $.ajax({
                url: full_url+'/controller/report_controller.php',
                type: 'post',
                data:dataString,
                cache: false,
                beforeSend: function(){
                    $("#loading_modal").modal('show');
                  },
                  complete: function(){
                   $("#loading_modal").modal('hide');
                  },
                success: function(data){
                    /*console.log(data);*/
                   if(data!=0)
                   {
                    $('#today_summary_list').empty();
                    $('#today_summary_list').html(data);
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}


function load_today_voice_summary_report()
{
    //alert('summary');
    var full_url = window.location.origin;
    var selected_role=$("#user_role_dropdown").val();
    var user_role=$("#user_role").val();
    var u_id=$("#user_dropdown").val();
    var dataString="";
    if(user_role=='mds_rs' || user_role=='mds_ad' || user_role=='mds_adm')
    {
        dataString='list_type=load_today_summary'+'&user_role='+user_role+'&u_id='+u_id+'&selected_role='+selected_role;
    }
    else
    {
       dataString= 'list_type=load_today_summary'+'&user_role='+user_role;
    }


     $.ajax({
                url: full_url+'/controller/report_controller.php',
                type: 'post',
                data:dataString,
                cache: false,
                    beforeSend: function(){
                     $('.ajax-loader').css("visibility", "visible");
                   },
                   complete: function(){
                    $('.ajax-loader').css("visibility", "hidden");
                   },
                success: function(data){
                    /*console.log(data);*/
                   if(data!=0)
                   {
                    $('#today_summary_list').empty();
                    $('#today_summary_list').html(data);
                   }
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(data);
                    //$('#content').html(errorMsg);
                  }
            });
}