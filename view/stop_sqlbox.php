<?php
// Command to execute the expect script
$command = '/home/typwqra/run_sqlbox.sh 2>&1';

// Execute the command
$output = shell_exec($command);

// Output the result
echo "<pre>$output</pre>";
?>
