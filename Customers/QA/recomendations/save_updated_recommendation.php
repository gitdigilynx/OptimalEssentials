<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

require_once("../../../inc/db_connect.php");

    $id = $_POST['recommednation_id'];
    $Name = mysqli_real_escape_string($conn,$_POST['Name']);
    $Detail = mysqli_real_escape_string($conn,$_POST['Detail']);;
    $output_array = [];
    
    
    
    if($id === ''){
        $sql = "INSERT INTO product_recommendation (name, product_benefits)
        VALUES ('$Name', '$Detail')";
        
        $message = 'New record created successfully';
        $message2 = 'create';
    }else{
        $sql = "UPDATE product_recommendation SET name='$Name',product_benefits='$Detail' WHERE id=$id";
        $message = 'Record updated successfully';
        $message2 = 'update';
    }
    
    if ($conn->query($sql) === TRUE) {
        $output_array[0] = 'success';
        $output_array[1] = $message;
        echo json_encode($output_array);
        } else {
          echo "Error '.$message2.' record: " . $conn->error;
        }
    
    
}

?>