<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    require_once("../inc/db_connect.php");
    $customer_id = $_GET['cutomer_id'];
    $nutitionist_id = $_GET['nutitionist_id'];
    $output = '';
    
    $sql = "SELECT id,assign_nutritionist FROM Customers WHERE customer_id=$customer_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      // output data of each row
      
        $row = $result->fetch_assoc();
        $check_nutri = $row['assign_nutritionist'];
        if($check_nutri === ''){
            
            $sql_update = "UPDATE Customers SET assign_nutritionist='$nutitionist_id' WHERE customer_id=$customer_id";
            $output = "Record inserted successfully";
              
        }else{
            
            $sql_update = "UPDATE Customers SET assign_nutritionist='$nutitionist_id' WHERE customer_id=$customer_id";
            $output = "Record updated successfully";
            
        }
        
        if ($conn->query($sql_update) === TRUE) {
            echo $output;
        }
      
    } else {
      echo "0 results";
    }
    
    
}

?>