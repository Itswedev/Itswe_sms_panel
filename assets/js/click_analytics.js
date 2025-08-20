var table;

$(function() {
    // Initialize DataTable on page load
    table = $("#click_analytics_tbl").DataTable();

    // Load click details on page load
    load_click_details();
});

$("#toDate").change(function() {
    load_click_details();
});

function load_click_details() {
    //var full_url = window.location.origin;
    var frmDate = $("#frmDate").val();
    var toDate = $("#toDate").val();

    $.ajax({
        url: full_url + '/controller/click_analytics_controller.php',
        type: 'post',
        cache: false,
        data: 'type=load_click_dtls' + "&frmDate=" + frmDate + "&toDate=" + toDate,
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
