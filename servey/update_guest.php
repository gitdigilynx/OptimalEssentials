<?php

 // include the required files
    require_once("../inc/db_connect.php");

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $customer_id = $_GET['customer_id'];
        $guest_first_name = $_GET['guest_first_name'];
        $guest_last_name = $_GET['guest_last_name'];
        $customer_email = $_GET['customer_email'];
        
        $output_array = [];
       
        // check for guest client start
        
        $sql_select = "SELECT id,tags,customer_id,email FROM Customers WHERE email LIKE '%$customer_email%'";
        $result_select = $conn->query($sql_select);
        
        if ($result_select->num_rows > 0) {
          // output data of each row
            $row = $result_select->fetch_assoc();
            $output_array[0] = 'exsists';
            $output_array[1] = $row['tags'];
            $output_array[2] = $row['customer_id'];
            $output_array[3] = $row['email'];
          echo json_encode($output_array);
          
        } else {
        
        //  update the guest or client customer start
        $sql = "UPDATE Customers SET first_name='$guest_first_name',last_name='$guest_last_name',email='$customer_email' WHERE customer_id=$customer_id";

        if ($conn->query($sql) === TRUE) {
            $output_array[0] = 'success';
            echo json_encode($output_array);
        } else {
          echo "Error updating record: " . $conn->error;
        }
        //  update the guest or client customer start
        }
    }