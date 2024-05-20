<?php

require_once("../inc/db_connect.php");

$customer_id = $_GET['customer_id'];
$Login_customer_id = $_GET['Login_customer_id'];
if($_GET['order_details_page']){
    
$order_details_page = $_GET['order_details_page'];
}
$output_array = [];


if($customer_id)
{
    $sql = "SELECT tags FROM Customers WHERE customer_id=$customer_id AND hcp_id=$Login_customer_id" ;
    
    $sql_staff_check = "SELECT tags FROM Customers WHERE customer_id=$customer_id AND staff_id=$Login_customer_id" ;
    
    $result = $conn->query($sql);
    $result_staff = $conn->query($sql_staff_check);
        if ($result->num_rows > 0) {
      
          echo 'success';
      
    }else if ($result_staff->num_rows > 0) {
        echo 'staff';
        }else {
      echo 0;
    }
}

?>