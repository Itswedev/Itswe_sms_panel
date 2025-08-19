var table;

$(function() {
    // Initialize DataTable on page load
    table = $("#click_analytics_tbl").DataTable();

    // Load click details on page load
    load_bitly_details();
});



function load_bitly_details() {
    var full_url = window.location.origin+"/itswe_sms_app";
    var job_id = $("#job_id").val();

    $.ajax({
        url: full_url + '/controller/click_analytics_controller.php',
        type: 'post',
        cache: false,
        data: 'type=load_bitly_dtls&job_id='+job_id,
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
