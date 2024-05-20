<?php 
session_start();
require_once("../inc/db_connect.php");

// echo var_export($_POST);
// exit();
$customer_id = $_GET['customer_id'];
// echo $customer_id;
// exit();


// get data from query
$customer_id_check = "SELECT customer_id FROM servey_table WHERE customer_id=$customer_id";
$result_customer_id_check = $conn->query($customer_id_check);

if ($result_customer_id_check->num_rows > 0) {
  $delete_cutomer_data = "DELETE FROM servey_table WHERE customer_id=$customer_id";
    if ($conn->query($delete_cutomer_data) === TRUE) {
        
        // insert record
            // if customer id doesnt exist
    $i = 0;
foreach($_POST as $datas){
    $data = mysqli_real_escape_string($conn,$datas);
    if( $i%2==0){
        $sql_question = "INSERT INTO `servey_table`( `question_id`) VALUES ('$data')";
        
            if ($conn->query($sql_question) === TRUE) {
                $last_id = $conn->insert_id;
                $_SESSION["lastid"] = $last_id;
                //  echo "question inserted.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
    }
    else{
         $lastid_session =  $_SESSION["lastid"];
         
       $dataa = explode("_",$data);
         
        $sql_answer = "UPDATE servey_table SET answer_id='$dataa[0]', product_id='$dataa[1]' , recommendation_id='$dataa[2]', score='$dataa[3]', customer_id='$customer_id' WHERE id = $lastid_session";
        
            if ($conn->query( $sql_answer) === TRUE) {
                //  echo "sucess";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
    }
    
    $i++;
}
        
        
} else {
  echo "Error deleting record: " . $conn->error;
}
  
  
} else {
    
    // if customer id doesnt exist
    $i = 0;
foreach($_POST as $datas){
    $data = mysqli_real_escape_string($conn,$datas);
    if( $i%2==0){
        $sql_question = "INSERT INTO `servey_table`( `question_id`) VALUES ('$data')";
        
            if ($conn->query($sql_question) === TRUE) {
                $last_id = $conn->insert_id;
                $_SESSION["lastid"] = $last_id;
                //  echo "question inserted.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
    }
    else{
         $lastid_session =  $_SESSION["lastid"];
         
       $dataa = explode("_",$data);
         
        $sql_answer = "UPDATE servey_table SET answer_id='$dataa[0]', product_id='$dataa[1]', recommendation_id='$dataa[2]', score='$dataa[3]', customer_id='$customer_id' WHERE id = $lastid_session";
        // $sql_answer = "UPDATE servey_table SET answer_id='$dataa[0]', product_id='$dataa[1]', recommendation_id='$dataa[2]', score='$dataa[3]', customer_id='$dataa[4]' WHERE id = $lastid_session";
        
            if ($conn->query( $sql_answer) === TRUE) {
                //  echo "sucess";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
    }
    
    $i++;
}
  
}


 echo "sucess";
?>