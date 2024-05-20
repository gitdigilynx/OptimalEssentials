<?php

require_once("../inc/db_connect.php");

$customer_id = $_GET['customer_id'];

$output = false;
$sql = "SELECT * FROM customer_cartproduct_ids where customer_id=$customer_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  $output = true;
} else {
  $output = false;
}

echo $output;

?>