<?php


require_once("../inc/db_connect.php");

$order_id = $_GET['order_id'];
$order_stautus = $_GET['order_stautus'];

if($order_stautus == 'unsubscribe')
{
    $sql = "UPDATE customer_order SET order_recurring=0 WHERE order_id=$order_id";
    
    if ($conn->query($sql) === TRUE) {
      echo "reccuring updated successfully";
    } else {
      echo "Error updating record: " . $conn->error;
    }
}else if($order_stautus == 'cancel')
{
      $sql = "UPDATE customer_order SET order_approval_status='rejected' WHERE order_id=$order_id";
    
    if ($conn->query($sql) === TRUE) {
        
                $sql_delete_invoice = "DELETE FROM customer_invoice WHERE order_id=$order_id";

                if ($conn->query($sql_delete_invoice) === TRUE) {
                   if(mysqli_affected_rows($conn) > 0 ){
                         echo "cancelled";
                    }else{
                        echo "cancelled_already";
                    }
                } else {
                  echo "Error deleting record: " . $conn->error;
                }
     
    } else {
      echo "Error updating record: " . $conn->error;
    }
}else if($order_stautus == 'accept')
{
      $sql = "UPDATE customer_order SET order_approval_status='accepted' WHERE order_id=$order_id";
    
    if ($conn->query($sql) === TRUE) {
      echo "accepted";
    } else {
      echo "Error updating record: " . $conn->error;
    }
}else if($order_stautus == 'pending')
{
     $sql = "UPDATE customer_order SET order_approval_status='pending' WHERE order_id=$order_id";
    
    if ($conn->query($sql) === TRUE) {
      echo "pending";
    } else {
      echo "Error updating record: " . $conn->error;
    }
}

$conn->close();


?>