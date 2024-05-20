<?php

require_once("../inc/db_connect.php");

$customer_id = $_GET['customer_id'];
$Login_customer_id = $_GET['Login_customer_id'];


if($customer_id)
{
    $sql = "SELECT first_name FROM Customers WHERE customer_id=$customer_id AND hcp_id=$Login_customer_id" ;
    
    $result = $conn->query($sql);
        if ($result->num_rows > 0) {
      // output data of each row
      echo 'success';
      
    } else {
      echo 0;
    }
}

?>