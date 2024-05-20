<?php


require_once("../inc/db_connect.php");

$customer_id = $_GET['customer_id'];

$sql_gethcp_id = "SELECT tags FROM Customers where customer_id=" . $customer_id;

$result_gethcp_id = $conn->query($sql_gethcp_id);

if ($result_gethcp_id->num_rows > 0) {
    while ($value = $result_gethcp_id->fetch_assoc()) {
        $customer_tag = $value['tags'];
    }
}

echo $customer_tag;

?>