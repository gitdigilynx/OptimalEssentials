<?php
require_once("../inc/db_connect.php");
require_once("../inc/functions.php");
require_once("../inc/store_credential.php");
// /admin/api/2022-07/customers/search.json
$customer1 = shopify_call($acess_token, $shop, "/admin/api/2022-07/customers.json?limit=100", array(), 'GET');
// echo '<pre>';
// var_dump($customer1);die();
$customer1 = json_decode($customer1['response'], JSON_PRETTY_PRINT);



foreach ($customer1 as $customer) :
    foreach ($customer as $key => $value) :
         
        $select_sql = "SELECT * FROM Customers WHERE customer_id=$value[id] OR email='$value[email]'";

        $select_sql_result = $conn->query($select_sql);

        if ($select_sql_result->num_rows > 0) {

            // output data of each row
            while ($row = $select_sql_result->fetch_assoc()) {
                
                if ($row['customer_id'] == $value['id'] ||  $row['email'] == $value['email']) {
                //     echo '<pre>';
                // var_dump($row);

                $first_name = mysqli_real_escape_string($conn,$value['first_name']);
                $last_name = mysqli_real_escape_string($conn,$value['last_name']);
                $email = mysqli_real_escape_string($conn,$value['email']);
                $tags = mysqli_real_escape_string($conn,$value['tags']);
                $note = mysqli_real_escape_string($conn,$value['note']);
                    $sql = "UPDATE Customers SET customer_id='$value[id]',first_name='$first_name',last_name='$last_name',email='$email',tags='$tags' ,sec_notes='$note' WHERE customer_id=$value[id] OR email='$value[email]'";
                    if ($conn->query($sql) === TRUE) {
                        // echo "<pre>New record updated successfully";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }
        } else {
            // echo 'inside create';
            
                 // explode the HCP id from client start
                $arr = explode("Customer-HCP: ",$value['note']);
                $new = $arr[1];
                $compony=  explode("H",$new);
               
                $customer_hcp = $compony[0];
                $first_name = mysqli_real_escape_string($conn,$value['first_name']);
                $last_name = mysqli_real_escape_string($conn,$value['last_name']);
                $email = mysqli_real_escape_string($conn,$value['email']);
                $tags = mysqli_real_escape_string($conn,$value['tags']);
                $note = mysqli_real_escape_string($conn,$value['note']);
                 echo '<br>';
                if(!($customer_hcp === ''))
                {
                    $sql = "INSERT INTO Customers (customer_id, first_name, last_name,email,tags,assigned_check,hcp_id,sec_notes,assign_nutritionist)
                VALUES ('$value[id]', '$first_name', '$last_name','$email','$tags','1','$customer_hcp','$note','22334455')";
                }else{
                     $sql = "INSERT INTO Customers (customer_id, first_name, last_name,email,tags,sec_notes,assign_nutritionist)
                VALUES ('$value[id]', '$first_name', '$last_name','$email','$tags','$note','22334455')";
                }
            // explode the HCP id from client end
           
            if ($conn->query($sql) === TRUE) {
                // echo "New record created successfully";
            } else {
                echo "Error insert: " . $sql . "<br>" . $conn->error;
            }
        }



    endforeach;

endforeach;

        $select_sql_customer = "SELECT * FROM Customers";
        $result_sql_customer = $conn->query($select_sql_customer);
        
        if ($result_sql_customer->num_rows > 0) {
            
                  while ($row_sql_customer = $result_sql_customer->fetch_assoc()) {
                      $id_check = $row_sql_customer['id'];
                      $check_customer_id = $row_sql_customer['customer_id'];
                      
                      
                    //    update customer id in all table where id equal start
                    
                    // update survey 
                        $sql_customer_servey_table_update = "UPDATE servey_table SET customer_id='$check_customer_id' WHERE customer_id=$id_check";
                        $conn->query($sql_customer_servey_table_update);
                        
                    // update cart
                        $sql_customer_cartproduct_ids_update = "UPDATE customer_cartproduct_ids SET customer_id='$check_customer_id' WHERE customer_id=$id_check";
                        $conn->query($sql_customer_cartproduct_ids_update);
                    
                    // update order
                        $sql_customer_order_update = "UPDATE customer_order SET customer_id='$check_customer_id' WHERE customer_id=$id_check";
                        $conn->query($sql_customer_order_update);
                    
                    // update address
                        $sql_cutomer_address_update = "UPDATE cutomer_address SET customer_id='$check_customer_id' WHERE customer_id=$id_check";
                        $conn->query($sql_cutomer_address_update);
                    
                    // update address
                        $sql_customer_invoice_update = "UPDATE customer_invoice SET customer_id='$check_customer_id' WHERE customer_id=$id_check";
                        $conn->query($sql_customer_invoice_update);
                    //    update customer id in all table where id equal end
                      
                  }
        }
    

$conn->close();

?>