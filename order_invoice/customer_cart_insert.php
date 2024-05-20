



<?php

require_once("../inc/db_connect.php");


$products_id = $_GET['products_id'];
$variants_id = $_GET['variants_id'];

$customer_id = $_GET['customer_id'];

        $select_sql = "SELECT * FROM customer_cartproduct_ids WHERE customer_id=$customer_id";

        $select_sql_result = $conn->query($select_sql);

        if ($select_sql_result->num_rows > 0) {

            // output data of each row
            // while ($row = $select_sql_result->fetch_assoc()) {
                
                    $sql = "UPDATE customer_cartproduct_ids SET customer_id='$customer_id',products_ids='$products_id',variants_id='$variants_id' WHERE customer_id=$customer_id";
                    if ($conn->query($sql) === TRUE) {
                        // echo "New record updated successfully";
                        
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
            // }
        } else {
            $sql = "INSERT INTO customer_cartproduct_ids (customer_id, products_ids, variants_id)
                VALUES ('$customer_id', '$products_id', '$variants_id')";
            if ($conn->query($sql) === TRUE) {
                // echo "New record created successfully";
                 
                
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }



?>