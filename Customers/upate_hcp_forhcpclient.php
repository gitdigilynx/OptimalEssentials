<?php

  require_once("../inc/db_connect.php");
  
  $hcp_id = $_GET['hcp_id'];
  $customer_id = $_GET['customer_id'];

  
  $sql = "UPDATE Customers SET hcp_id=$hcp_id WHERE customer_id=$customer_id";

if ($conn->query($sql) === TRUE) {
  echo "Success";
} else {
//   echo "Error updating record: " . $conn->error;
}

?>