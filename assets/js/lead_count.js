var table;

$(function() {
    // Initialize DataTable on page load
    table = $("#click_analytics_tbl").DataTable();

    // Load click details on page load
    load_count_details();


    $(document).on('click','#download_url_tracking_btn',function(){
            var full_url = window.location.origin;
            var job_id = $("#job_id").val();

                 $.ajax({
                    url: full_url+"/controller/click_analytics_controller.php",
                    type: 'post',
                    data:'type=download_report&job_id='+job_id,
                    cache: false,
                    success: function(data){
                        full_url = full_url+"/controller/click_analytics_controller.php?type=download_report&job_id="+job_id;
                        console.log(full_url);
                        window.open(full_url);
                        alert('Download Successfully!!!!');
    
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errorMsg = 'Ajax request failed: ' + xhr.responseText;
                        alert(errorMsg);
                        //$('#content').html(errorMsg);
                      }
                });

    })


});



function load_count_details() {
    var full_url = window.location.origin;
    var job_id = $("#job_id").val();

    $.ajax({
        url: full_url + '/controller/click_analytics_controller.php',
        type: 'post',
        cache: false,
        data: 'type=load_lead_dtls&job_id='+job_id,
        success: function(data) {
            // Log the received data to check if it is in the correct format
            console.log(data);

            if (data !== '0') {
                // Clear the existing DataTable
                table.clear();

                // Append the new data directly to the DataTable
                table.rows.add($(data)).draw();
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            alert(errorMsg);
        }
    });
}
