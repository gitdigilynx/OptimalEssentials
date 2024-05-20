<?php
require_once("../inc/db_connect.php");
$order_id = $_GET['order_id'];


// sql to delete a record order
$sql_order = "DELETE FROM customer_order WHERE order_id=$order_id";

if ($conn->query($sql_order) === TRUE) {
 // sql to delete a record invoice
    $sql_invoice = "DELETE FROM customer_invoice WHERE order_id=$order_id";
    
    if ($conn->query($sql_invoice) === TRUE) {
     $sql_order_item = "DELETE FROM customer_order_item WHERE order_id=$order_id";
    
    if ($conn->query($sql_order_item) === TRUE) {
    
    } else {
      echo "Error deleting record order items: " . $conn->error;
    }
    } else {
      echo "Error deleting record order invoice: " . $conn->error;
    }
} else {
  echo "Error deleting record order: " . $conn->error;
}

?>