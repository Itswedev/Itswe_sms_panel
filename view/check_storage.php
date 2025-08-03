<?php
// Path to check
$directory = "/"; // Root directory

// Get the total space of the directory
$totalSpace = disk_total_space($directory);

// Get the free space of the directory
$freeSpace = disk_free_space($directory);

// Convert the values to more readable formats
$totalSpaceGB = $totalSpace / 1024 / 1024 / 1024; // Convert to GB
$freeSpaceGB = $freeSpace / 1024 / 1024 / 1024;   // Convert to GB
$usedSpaceGB = $totalSpaceGB - $freeSpaceGB;      // Used space in GB

// Display the results

?>

        
 
          <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                  </div>
                  <div class="card-body">
                    <?php
                  echo "<h1>Server Storage Information</h1><br>";
                  echo "<p>Total Space: " . round($totalSpaceGB, 2) . " GB</p>";
                  echo "<p>Used Space: " . round($usedSpaceGB, 2) . " GB</p>";
                  echo "<p>Free Space: " . round($freeSpaceGB, 2) . " GB</p>";
                  ?>
                  </div>
                </div>
              </div>
              <!-- Zero Configuration  Ends-->
            </div>

        <!-- footer start-->
       <?php include('../include/footer.php'); ?>
