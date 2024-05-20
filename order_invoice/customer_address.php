<?php

require_once("../inc/db_connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // get state 
    $new_exp_s = $_POST['State'];
    $exp_state_s = explode(",",$new_exp_s); // exopt state
    $customer_state_code =  $exp_state_s[0]; //state code
    $State =  $exp_state_s[1]; // state name
  

    $customer_id = $_POST['Customer_Id'];
    $first_name = $_POST['First_Name'];
    $Last_Name = $_POST['Last_Name'];
    $Address = $_POST['Address'];
    $Address2 = $_POST['Address2'];
    $City = $_POST['City'];
    $Zip_Code = $_POST['Zip_Code'];
    $Country = $_POST['Country'];
    $Phone_No = $_POST['Phone_No'];
    $Email = $_POST['Email'];
    
    $sql = "SELECT id from cutomer_address where customer_id=$customer_id";
    $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $sql_update = "UPDATE cutomer_address SET customer_id='$customer_id',customer_fname='$first_name',customer_lname='$Last_Name',customer_email='$Email',customer_phone='$Phone_No',customer_zip='$Zip_Code',customer_address1='$Address',customer_address2='$Address2',customer_city='$City',customer_state='$State',customer_state_code='$customer_state_code',customer_counrty='$Country' WHERE customer_id=$customer_id";

            if ($conn->query($sql_update) === TRUE) {
              echo "Record updated successfully";
            } 
        } else {
            
          $sql_insert_address = "INSERT INTO cutomer_address (customer_id, customer_fname, customer_lname,customer_email,customer_phone,customer_zip,customer_address1,customer_address2,customer_city,customer_state,customer_state_code,customer_counrty)
            VALUES ('$customer_id', '$first_name', '$Last_Name','$Email','$Phone_No','$Zip_Code','$Address','$Address2','$City','$State','$customer_state_code','$Country')";
            
            if ($conn->query($sql_insert_address) === TRUE) {
              echo "New record created successfully";
            }
        }
}

?>