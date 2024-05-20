<?php

require_once("../inc/db_connect.php");
require_once("../inc/functions.php");
require_once("../inc/store_credential.php");

$products = shopify_call($acess_token, $shop, "/admin/api/2022-10/products.json", array(), 'GET');

$products = json_decode($products['response'], JSON_PRETTY_PRINT);



foreach ($products as $product) :
    foreach ($product as $key => $value) :
            
        $select_sql = "SELECT * FROM Products WHERE product_id=$value[id]";

        $select_sql_result = $conn->query($select_sql);

        if ($select_sql_result->num_rows > 0) {

            // output data of each row
            while ($row = $select_sql_result->fetch_assoc()) {
                
                if ($row['product_id'] == $value['id']) {
                //     echo '<pre>';
                // var_dump($row);

                    $sql = "UPDATE Products SET title='$value[title]' WHERE product_id=$value[id]";
                    if ($conn->query($sql) === TRUE) {
                        echo "New record updated successfully";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }
        } else {
            // echo 'inside create';
            $sql = "INSERT INTO Products (product_id, title)
                VALUES ('$value[id]', '$value[title]')";
            if ($conn->query($sql) === TRUE) {
                // echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }


    endforeach;

endforeach;
$conn->close();

?>