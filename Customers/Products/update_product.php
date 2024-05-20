<?php




require_once("../../inc/db_connect.php");
$product_id = $_GET['product_id'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    

    $four_weeks = $_POST['4_weeks'];
    $eight_weeks = $_POST['8_weeks'];
    $twelve_weeks = $_POST['12_weeks'];

    $sql = "UPDATE Products SET 4_weeks='$four_weeks', 8_weeks='$eight_weeks', 12_weeks='$twelve_weeks'  WHERE product_id=$product_id";
    if ($conn->query($sql) === TRUE) {
        
               echo 'Record Updated';
    }
    else {
                  echo "Error updating record: " . $conn->error;
                }
    
}




?>