<?php
$servername = "localhost";
$username = "admin988";
$password = "w=i6O)TZ~qKU";
$dbname = "elderlysupplements2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// set time zone
date_default_timezone_set("Asia/Karachi");
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>