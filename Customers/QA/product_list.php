<?php
$output ='';
require_once("../../inc/db_connect.php");
// $value_product_table='';
$sql_product_table = "SELECT * FROM Products";
$result_product_table = $conn->query($sql_product_table);
if ($result_product_table->num_rows > 0) {
    $output .= ' <option value="" hidden>Select Product</option>';
    while ($value_product_table = $result_product_table->fetch_assoc()) {



     $output .='<option value='.$value_product_table['product_id'].'>'.$value_product_table['title'].'</option>';

    }
}
echo $output;
?>