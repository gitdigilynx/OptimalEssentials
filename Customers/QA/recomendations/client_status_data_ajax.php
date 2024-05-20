<?php
$array_value = array();
$output_select = '';
require_once("../../../inc/db_connect.php");
$id = $_GET['id'];
$sql = "SELECT * FROM client_status WHERE id=$id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    $row = $result->fetch_assoc();
    $array_value[0] = $row['status'];
    // if (!$row['product_ids']) {
    // $array_value[1] = $row['product_ids']; 

    $output_select .= '<select class="selectpicker select_multiple_products" multiple>
        <option value="">Select Product</option>';

    $sql_product_table = "SELECT * FROM Products";
    $result_product_table = $conn->query($sql_product_table);
    if ($result_product_table->num_rows > 0) {
        while ($value_product_table = $result_product_table->fetch_assoc()) {
            $output_select .= '<option value="' . $value_product_table['product_id'] . '" >' . $value_product_table['title'] . '</option>';
        }
    }
    $output_select .= '</select>';
    $array_value[1] = $output_select;
    // }


    $array_value[2] = $row['template'];
} else {
    echo "0 results";
    die();
}

echo json_encode($array_value);
