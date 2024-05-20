<?php

$webhook_content = '';
$webhook = fopen('php://input' , 'rb');
while(!feof($webhook)){ //loop through the input stream while the end of file is not reached
$webhook_content .= fread($webhook, 4096); //append the content on the current iteration
}
fclose($webhook); //close the resource

$customer = json_decode($webhook_content, true); //convert the json to array
// error_log('Webhook verified: '.var_export($customer , true));


$customerid = $customer['id'];


require_once("../inc/db_connect.php");


// sql to delete a customer record webhook..
$sql_del = "DELETE FROM Customers WHERE customer_id = $customerid";

if ($conn->query($sql_del) === TRUE) {
  echo "Record deleted successfully";
} else {
  echo "Error deleting record: " . $conn->error;
}

$conn->close();


?>