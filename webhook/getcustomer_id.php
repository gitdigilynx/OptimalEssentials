<?php  
require_once("../inc/db_connect.php");

$customerid = $_REQUEST['customerid'];
if(isset($customerid)){
  
$sql = "INSERT INTO webhook_res (customer_id)
VALUES ('$customerid')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
}
?>