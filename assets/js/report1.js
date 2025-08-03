(function ($) {
    "use strict";
    $(document).ready(function () {
        var frmDate = "";
        var toDate = "";
        var table="";
     
    var today_report_type="";   
           //today_report_type="total";
           var list_type="today_report_test";
           var today_report=$("#report_type").val();
            var selected_role=$("#selected_role").val();
  
    var user_role=$("#user_role").val();
  
    var uid=$("#uid").val();
    var full_url = window.location.origin;
      
    // var table = $("#today_report_tbl").DataTable({
    //     paging: false, // Disable pagination
    //     dom: "Bfrtip",
    //     buttons: [{
    //         extend: 'excelHtml5',
    //         text: 'Download',
    //         title: 'Today Report',
    //         exportOptions: {
    //             modifier: {
    //                 page: 'all'
    //             }
    //         },
    //         customize: function (xlsx) {
    //             var sheet = xlsx.xl.worksheets['sheet1.xml'];
    //             $('row c[r^="A"]', sheet).attr('s', '2');
    //         }
    //     }]
    // });
   
        

        // $.ajax({
        //     url: full_url+"/controller/report_controller.php",
        //     type: 'post',
        //     data:'list_type='+list_type+"&report_type="+today_report+"&user_role="+user_role+"&uid="+uid+"&selected_role="+selected_role,
        //     cache: false,
        //     success: function(data){
        //         // console.log(data);

        //         // $("#today_report_list").empty();
        //         // $("#today_report_list").append(data);
        //         // Enable pagination after fetching data
        //         //table.page.len(-1).draw();

        //         $("#today_report_tbl").DataTable({
        //             dom: "Bfrtip",
        //             buttons: [ {
        //                             extend: 'excelHtml5',
        //                             text: 'Download',
        //                             title: 'Today Report',
        //                             exportOptions: {
        //                                 modifier: {
        //                                     page: 'all'
        //                                 }
        //                             },
        //                             customize: function (xlsx) {
        //                                 var sheet = xlsx.xl.worksheets['sheet1.xml'];
        //                                 $('row c[r^="A"]', sheet).attr('s', '2');
        //                             }
        //                         }],
        //           });

                                        
        //         // $("#today_report_list").
        //     },
        //     error: function (xhr, ajaxOptions, thrownError) {
        //         var errorMsg = 'Ajax request failed: ' + xhr.responseText;
        //         alert(errorMsg);
        //         //$('#content').html(errorMsg);
        //       }
        // });
    
     
      table= $("#today_report_tbl").DataTable({
       
        "ajax": {
                    "type": "POST",
                    "url": full_url + "/controller/report_controller.php",
                    "data": function(post) {
                        
                        post.list_type = list_type;
                        post.report_type = today_report;
                        post.user_role = user_role;
                        post.uid = uid;
                        post.selected_role = selected_role;
        
                        if (frmDate !== "" && toDate !== "") {
                            post.frmDate = frmDate;
                            post.toDate = toDate;
                        }
                        
                    },
                    "dataSrc": function(json) {
                        // Extract the data from the response and return it
                        return json.data;
                    }
                },
                "processing": true,
                "serverSide": true,
                "responsive": true,
                
                dom: "Bfrtip",
                buttons: [
                    {
                        // Export All to Excel button configuration
                        text: 'Export All to Excel',
                        action: (e, dt, button, config) => {
                            dt.processing(true);
                            dt.one('preXhr', function (e, s, data) {
                                // Set length to -1 to fetch all records
                                data.length = -1;
                            }).one('draw', function (e, settings, json, xhr) {
                                // Call excelHtml5 button action directly
                                $.fn.DataTable.ext.buttons.excelHtml5.action.call(this, e, dt, button, config);
                            }).draw();
                        }
                    }
                ]

      });


// Function to temporarily disable pagination



    // // After download is successful, re-enable pagination
    // table.on('xhr.dt', function () {
    //     // Re-enable pagination
    //     table.one('preDraw', function () {
    //         table.paging.enable(true);
    //     });
    // });
    

    

    });
  })(jQuery);
  