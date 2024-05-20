<?php

require_once("../inc/db_connect.php");

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
 
                        $product_ids = '';
                        $variant_id = '';
                        $product_title = '';
                        $product_img = '';
                        $quantity = '';
                        $product_price = '';
    $updated_date_time = date('d-m-Y h:i:s:A');
    $order_id = $_POST['order_id'];
    $order_recurring =  $_POST['recurring_week_input']; 
    $sub_total = $_POST['sub_total'];
    
    $sql = "SELECT order_id FROM customer_order where order_id=$order_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      // output data of each row
      $row = $result->fetch_assoc();
        
            $sql_update_order = "UPDATE customer_order SET product_sub_total='$sub_total',order_recurring='$order_recurring',order_updated_at='$updated_date_time' WHERE order_id=$order_id";

            if ($conn->query($sql_update_order) === TRUE) {
            //   echo "Record updated successfully";
                $sql_order_item = "DELETE FROM customer_order_item WHERE order_id=$order_id";
    
                if ($conn->query($sql_order_item) === TRUE) {
                
                        $product_ids = $_POST['product_id'];
                        $variant_id = $_POST['variant_id'];
                        $product_title = $_POST['product_title'];
                        $product_img = $_POST['product_img'];
                        $quantity = $_POST['quantity'];
                        $product_price = $_POST['product_price'];
                        $total_price = $_POST['total_price'];
                        // $count = 1;
                        
                        foreach( $product_ids as $count => $code ) {
                            $sql_order_items = "INSERT INTO customer_order_item ( order_id, product_id, variant_id, product_title,product_src,product_qty,product_price,product_total)
                                     VALUES ('$order_id', '$product_ids[$count]', '$variant_id[$count]','$product_title[$count]','$product_img[$count]','$quantity[$count]','$product_price[$count]','$total_price[$count]')";
                            if ($conn->query($sql_order_items) === TRUE) {
                                $success = 'success';
                            } else {
                                $success = 'failed';
                                echo "Error: " . $sql . "<br>" . $conn->error;
                            }
                            
                            }
                            
                } else {
                  echo "Error deleting record order items: " . $conn->error;
                }
            
            } else {
              echo "Error updating Order: " . $conn->error;
            }
                    
    } else {
      echo "0 results";
    }
    if($success == 'success')
    {
        echo $order_id;
    }else{
        echo 'error updating';
    }
    $conn->close();

}

?>