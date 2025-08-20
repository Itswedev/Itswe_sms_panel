$(function(){


   var page_name=$("#page_name").html();
   var table;

   if(page_name=='URL Tracking')
   {
      load_url_tracking_summary();
   }
   else if(page_name=='url_tracking_dtls')
   {
      load_url_tracking_dtls();
   }

   $("#user_dropdown").change(function(){
       
    load_url_tracking_summary();
    

    })

   $(document).on("change","#user_role_dropdown", function (e) {

    var user_role=$("#user_role_dropdown").val();

    if(user_role!='All')
    {
        load_users();
    }
    else
    {

       
        // if(page_name=='Today Summary Report')
        // {
        //     load_today_summary_report();
        // }
        // else if(page_name=='Scheduled Report')
        // {
        //     load_scheduled_report();
        // }
        
    }
    
});


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

                 $(`#user_dropdown_chosen`).trigger("chosen:updated");
                   $("#user_dropdown_chosen").css('width','100%');

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
}




   $(document).on('click','#download_url_tracking_btn',function(){
            
      
            //var full_url = window.location.origin;


                 $.ajax({
                    url: full_url+"/controller/url_tracking_controller.php",
                    type: 'post',
                    data:'list_type=download_report',
                    cache: false,
                    success: function(data){
                    
                        window.open(full_url+"/controller/url_tracking_controller.php?list_type=download_report");
    
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(errorMsg);
                        //$('#content').html(errorMsg);
                      }
                });



})


   $(document).on('click','#download_url_tracking_dtls_btn',function(){      
            //var full_url = window.location.origin;
            var frmDate = $("#frmDate").val();
            var toDate = $("#toDate").val();
                 $.ajax({
                    url: full_url+"/controller/url_tracking_controller.php",
                    type: 'post',
                    data:'list_type=download_dtls_report' + "&frmDate=" + frmDate + "&toDate=" + toDate,
                    cache: false,
                    success: function(data){
                        full_url = full_url+"/controller/url_tracking_controller.php?list_type=download_dtls_report"+ "&frmDate=" + frmDate + "&toDate=" + toDate;
                        console.log(full_url);
                        window.open(full_url);
    
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(errorMsg);
                        //$('#content').html(errorMsg);
                      }
                });
    })




   $(document).on( "click", '.url_tracking_dtls_btn',function(e) {
  
    var msg_job_id = $(this).data('msgid');
         //var full_url = window.location.origin;

       $.ajax({
                url: full_url+'/controller/url_tracking_controller.php',
                type: 'post',
                data:'list_type=save_msgid&msg_job_id='+msg_job_id,
                cache:false,
                success: function(data){
                
                   if(data!=0)
                   {
                     window.location.href=full_url+'/dashboard.php?page=url_tracking_dtls';
                        
                   }
                    
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });
    });
})



function load_url_tracking_summary()
{
	//var full_url = window.location.origin;
    var user_role= $("#user_role").val();
    var selected_role=$("#user_role_dropdown").val();

    var u_id=$("#user_dropdown").val();
    var dataString="";
    var frmDate = $("#frmDate").val();
    var toDate = $("#toDate").val();
    if(user_role=='mds_rs' || user_role=='mds_ad')
    {
        dataString='list_type=url_tracking_summary'+'&user_role='+user_role+'&u_id='+u_id+'&selected_role='+selected_role+ "&frmDate=" + frmDate + "&toDate=" + toDate;
    }
    else if(user_role=='mds_adm')
    {
        dataString='list_type=url_tracking_summary'+'&user_role='+user_role+'&u_id='+u_id+'&selected_role='+selected_role+ "&frmDate=" + frmDate + "&toDate=" + toDate;
    }
    else
    {
       dataString= 'list_type=url_tracking_summary'+'&user_role='+user_role;
    }
       $.ajax({
                url: full_url+'/controller/url_tracking_controller.php',
                type: 'post',
                data:dataString,
                cache: false,
                success: function(data){
                   
                   if(data!=0)
                   {

                    $('#url_tracking_data').html(data);
                   
                    /* $.fn.dataTable.moment( 'DD/MM/YYYY' );*/
                    if(user_role=='mds_adm')
                    {
                        table=$("#url_tracking_list").DataTable({
                            order: [[4, 'asc']],
                        });


                        // Add date filtering logic after DataTable initialization
                        $.fn.dataTable.ext.search.push(
                        function (settings, rowData, dataIndex) {
                    
                        var fromDate = $('#frmDate').val();
                        var toDate = $('#toDate').val();
                        var dateColumnIndex = table.column($('thead th:contains("Date")')).index();

                              // If both fromDate and toDate are empty, no filtering is required
                        // If both fromDate and toDate are empty, no filtering is required
                            if (fromDate === '' && toDate === '') {
                                return true;
                            }

                            // Parse the date string from rowData into a Date object
                            var dateString = rowData[dateColumnIndex];
                            var date = parseDate(dateString);
                            console.log(date);
                            // Parse the fromDate and toDate strings into Date objects
                            var fromDateObj = fromDate === '' ? null : new Date(fromDate);
                            var toDateObj = toDate === '' ? null : new Date(toDate);

                            // If fromDate is empty, include all records
                            if (fromDate === '') {
                                return true;
                            }

                            // Set the time portion of both dates to midnight (00:00:00)
                            var newDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());
                            var newFromDateObj = new Date(fromDateObj.getFullYear(), fromDateObj.getMonth(), fromDateObj.getDate());

                            // If toDate is empty, include records greater than or equal to fromDate
                            if (toDate === '') {
                                return newDate >= newFromDateObj;
                            }

                            // Set the time portion of toDate to end of day (23:59:59)
                            var newToDateObj = new Date(toDateObj.getFullYear(), toDateObj.getMonth(), toDateObj.getDate(), 23, 59, 59);

                            // Include records within the selected date range
                            return newDate >= newFromDateObj && newDate <= newToDateObj;

                    }
                );

                // Apply the date range filter on date input change
                $('#frmDate, #toDate').change(function () {
                    table.draw();
                });

                    }else
                    {


                    table=$("#url_tracking_list").DataTable({
                             columnDefs: [{
                                targets: 0,
                                type: "date"
                            }]
                        });


                        // Add date filtering logic after DataTable initialization
                        $.fn.dataTable.ext.search.push(
                            function (settings, rowData, dataIndex) {
                            
                                var fromDate = $('#frmDate').val();
                                var toDate = $('#toDate').val();
                                var dateColumnIndex = table.column($('thead th:contains("Date")')).index();
        
                                      // If both fromDate and toDate are empty, no filtering is required
                                // If both fromDate and toDate are empty, no filtering is required
                                    if (fromDate === '' && toDate === '') {
                                        return true;
                                    }
        
                                    // Parse the date string from rowData into a Date object
                                    var dateString = rowData[dateColumnIndex];
                                    var date = parseDate(dateString);
                                    console.log(date);
                                    // Parse the fromDate and toDate strings into Date objects
                                    var fromDateObj = fromDate === '' ? null : new Date(fromDate);
                                    var toDateObj = toDate === '' ? null : new Date(toDate);
        
                                    // If fromDate is empty, include all records
                                    if (fromDate === '') {
                                        return true;
                                    }
        
                                    // Set the time portion of both dates to midnight (00:00:00)
                                    var newDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());
                                    var newFromDateObj = new Date(fromDateObj.getFullYear(), fromDateObj.getMonth(), fromDateObj.getDate());
        
                                    // If toDate is empty, include records greater than or equal to fromDate
                                    if (toDate === '') {
                                        return newDate >= newFromDateObj;
                                    }
        
                                    // Set the time portion of toDate to end of day (23:59:59)
                                    var newToDateObj = new Date(toDateObj.getFullYear(), toDateObj.getMonth(), toDateObj.getDate(), 23, 59, 59);
        
                                    // Include records within the selected date range
                                    return newDate >= newFromDateObj && newDate <= newToDateObj;
        
                            }
                        );

                // Apply the date range filter on date input change
                $('#frmDate, #toDate').change(function () {
                    table.draw();
                });

                        

                    }
                    
                    
                    
                   }
                    
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });



}


function load_url_tracking_dtls()
{

 
   //var full_url = window.location.origin;

       $.ajax({
                url: full_url+'/controller/url_tracking_controller.php',
                type: 'post',
                data:'list_type=all_url_tracking',
                cache:false,
                success: function(data){
                  //alert(data);
                
                   if(data!=0)
                   {

                    $('#url_tracking_dtls_data').html(data);

                    $("#url_tracking_dtls_list").DataTable();

                  
                   }
                    
                    
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                    alert(errorMsg);
                    //$('#content').html(errorMsg);
                  }
            });



}

// function searchData_report() {
// 	/*alert('sdf');*/
//     frmDate = ($("#frmDate").val()) ? $("#frmDate").val() : '';
   
//     toDate = ($("#toDate").val()) ? $("#toDate").val() : '';
//     table.draw();
// }

// $('#frmDate, #toDate').change(function() {
//     var fromDate = $('#frmDate').val();
//     var toDate = $('#toDate').val();

//     // Perform filtering
//     console.log('test');
//     table.draw();
// });

// $.fn.dataTable.ext.search.push(
//     function(settings, data, dataIndex) {
//         var fromDate = $('#frmDate').val();
//         var toDate = $('#toDate').val();
//         var headers = $('#url_tracking_list thead th').map(function() {
//             return $(this).text();
//         }).get();

//         // Find the index of the date column
//         var dateColumnIndex = headers.indexOf("Date"); // Change "Date" to your actual TH value
//         console.log(dateColumnIndex);
//         if (dateColumnIndex !== -1) {
//             var dateString = data[dateColumnIndex];
//             var date = parseDate(dateString);
//             var fromDateObj = new Date(fromDate);
//             var toDateObj = new Date(toDate);

           

//             if ((fromDate === '' || toDate === '') ||
//                 (fromDateObj <= date && date <= toDateObj)) {
//                 return true;
//             }
//         }
//         return false;
//     }
// );

// Function to parse a date string in 'YYYY-MM-DD' format into a Date object
function parseDate(dateString) {
    // Ensure dateString is not empty or null
    if (!dateString) {
        console.error("Invalid dateString:", dateString);
        return null; // Or you can return a default value or handle the error in another way
    }

    // Split the dateString into its components
    var parts = dateString.split(/[- :]/);

    // Parse the components into integers
    var day = parseInt(parts[0], 10);
    var monthIndex = getMonthIndex(parts[1]);
    var year = parseInt(parts[2], 10);
    var hour = parseInt(parts[3], 10);
    var minute = parseInt(parts[4], 10);
    var meridiem = parts[5];

    // Adjust hour for meridiem (AM/PM)
    if (meridiem.toLowerCase() === 'pm' && hour < 12) {
        hour += 12;
    }

    // Create a new Date object
    var date = new Date(year, monthIndex, day, hour, minute);

    // Validate the Date object
    if (isNaN(date.getTime())) {
        console.error("Invalid Date:", dateString);
        return null; // Or handle the error accordingly
    }

    return date;
}


// Function to convert month abbreviation to month number
function getMonthIndex(monthName) {
    var months = [
        "Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
    ];
    return months.indexOf(monthName);
}