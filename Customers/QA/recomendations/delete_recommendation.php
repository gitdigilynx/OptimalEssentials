<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    require_once("../../../inc/db_connect.php");
    
    $id = $_GET['recommendation_id'];
    
    $sql = "DELETE FROM product_recommendation WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
      echo "success";
    } else {
      echo "Error deleting record: " . $conn->error;
    }
    
    
}


?>