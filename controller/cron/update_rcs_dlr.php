<?php




include_once('/var/www/html/itswe_panel/include/connection.php');

global $dbc;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


while(true)
{
	$result = mysqli_query($dbc,"call update_rcs_dlr();") or die(mysqli_error($dbc));


	 // Fetch all results (if any)
    if ($result) {
        // If the stored procedure returns results, fetch them (optional)
        while ($row = mysqli_fetch_assoc($result)) {
            // Handle the row if needed
            print_r($row);
        }
        
        // Free the result set to avoid "commands out of sync" error
        mysqli_free_result($result);
    }

    // Ensure that there are no more result sets left to be processed
    while (mysqli_more_results($dbc) && mysqli_next_result($dbc)) {
        // Free additional result sets, if any
        if ($extra_result = mysqli_store_result($dbc)) {
            mysqli_free_result($extra_result);
        }
    }
	sleep(2);

}


?>
