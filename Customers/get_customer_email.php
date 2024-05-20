<?php


require_once("../inc/db_connect.php");

$customer_id = $_GET['customerId'];

$sql = "SELECT email FROM Customers WHERE customer_id=$customer_id";

$result = $conn->query($sql);

if($result->num_rows > 0)
{
    $value = $result->fetch_assoc();
    $email = $value['email'];
}
echo $email;

?>