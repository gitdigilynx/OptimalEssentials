<?php

$webhook_content = '';
$webhook = fopen('php://input' , 'rb');
while(!feof($webhook)){ //loop through the input stream while the end of file is not reached
$webhook_content .= fread($webhook, 4096); //append the content on the current iteration
}
fclose($webhook); //close the resource

$customer = json_decode($webhook_content, true); //convert the json to array
error_log('Webhook verified: '.var_export($customer , true));
// exit;


$app_order_id= $customer['note'];
$explode_app_order_id = explode("_",$app_order_id);
$order_id = $explode_app_order_id[1];

// sql to update order and invoice status  webhook..
require_once("../inc/db_connect.php");

$sql = "UPDATE customer_order SET order_payment_status='Paid' WHERE order_id=$order_id";

if ($conn->query($sql) === TRUE) {
  echo "Record updated successfully";
} else {
  echo "Error updating record: " . $conn->error;
}

$sql = "UPDATE customer_invoice SET invoice_status='Paid' WHERE order_id=$order_id";

if ($conn->query($sql) === TRUE) {
  echo "Record updated successfully";
} else {
  echo "Error updating record: " . $conn->error;
}




$conn->close();


?>