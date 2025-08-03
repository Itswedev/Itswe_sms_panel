<?php
// MySQL database connection details
$servername = "localhost";  // Change this if your MySQL server is not local
$username = "itswe";         // Your MySQL username
$password = "NcbagqPkhdt#^98ajtd";             // Your MySQL password (add root password if needed)
$dbname = "itswe_client";  // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

// Close the connection
$conn->close();
?>
