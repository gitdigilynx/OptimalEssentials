<?php

$servername = "localhost";
$username = "admin988";
$password = "w=i6O)TZ~qKU";
$dbname = "elderlysupplements2";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
 
//Fetching Values from URL
$zone=$_POST['zone'];
$type=$_POST['type'];
$style=$_POST['style'];
$bounds=$_POST['bounds'];
$paths=$_POST['paths'];
$center=$_POST['center'];
$radius=$_POST['radius'];

//Insert query
$query = "insert into geo_json(zone, type, style, bounds, paths, center, radius) values ('$zone', '$type', '$style','$bounds', '$paths', '$center','$radius')";

if (mysqli_query($conn, $query)) {
  echo "Zone created successfully!";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}


?>