<?php
// var_dump($_POST);die();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    require_once("../../../inc/db_connect.php");

    $status_id = $_POST['status_id'];
    $status = $_POST['status'];
    $product_ids = $_POST['product_ids'];
    $product_ids_string = '';
    $ArticalContent = $_POST['ArticalContent'];

    $total_product_array = count($product_ids);
    $count = 0;
    foreach ($product_ids as $product_id) {
        $count++;
        $product_ids_string .= $product_id;
        if (!($total_product_array === $count)) {
            $product_ids_string .= ',';
        }
    }

    $sql = "UPDATE client_status SET product_ids='$product_ids_string',template='$ArticalContent' WHERE id=$status_id";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
$conn->close();
?>