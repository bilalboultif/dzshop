<?php
// Include your database connection file here
include 'connection.php';

// Check if the connection is successful
if ($conn) {
    echo "Connected to the database successfully!";
} else {
    echo "Failed to connect to the database.";
}
?>
