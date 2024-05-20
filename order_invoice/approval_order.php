<?php
require_once("../inc/db_connect.php");

$order_id = $_GET['order_id'];
$order_status = $_GET['order_status'];
// set timezone
$shipped_date_time = date('d-m-Y h:i:s:A');
$sql = "UPDATE customer_order SET order_approval_status='$order_status',order_shipped_date='$shipped_date_time' WHERE order_id=$order_id";

if ($conn->query($sql) === TRUE) {
        echo $order_status;
} else {
  echo "Error updating record: " . $conn->error;
}

?>