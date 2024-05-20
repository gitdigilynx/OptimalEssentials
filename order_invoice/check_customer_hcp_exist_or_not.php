<?php

require_once("../inc/db_connect.php");
require_once("../inc/functions.php");
require_once("../inc/store_credential.php");

$customer_id = $_GET['customer_id'];



$sql_check_hcp = "SELECT assigned_check,hcp_id FROM Customers WHERE tags='HCPClient' AND customer_id=".$customer_id;
 
  $result_check_hcp = $conn->query($sql_check_hcp);

    if ($result_check_hcp->num_rows > 0){
        while ($value = $result_check_hcp->fetch_assoc()){
              $assigned_check = $value['assigned_check'];
              $hcp_id = $value['hcp_id'];
              echo $assigned_check;   
     
    }
   
  }else{
      $sql_check_client = "SELECT id FROM Customers WHERE tags='Client' AND customer_id=".$customer_id;
      $result_check_client = $conn->query($sql_check_client);
       if ($result_check_client->num_rows > 0){
           echo 'client';
       }
        
    }
  
 
?>