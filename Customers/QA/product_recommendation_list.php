<?php
$output ='';
require_once("../../inc/db_connect.php");
// $value_product_table='';
$sql_recommendation_table = "SELECT * FROM product_recommendation";
$result_recommendation_table = $conn->query($sql_recommendation_table);
if ($result_recommendation_table->num_rows > 0) {
    $output .= ' <option value="" hidden>Select Recommendation</option>';
    while ($value_recommendation_table = $result_recommendation_table->fetch_assoc()) {



     $output .='<option value='.$value_recommendation_table['id'].'>'.$value_recommendation_table['name'].'</option>';

    }
}
echo $output;
?>