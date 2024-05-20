<?php


require_once("../inc/db_connect.php");
require_once("../inc/functions.php");
require_once("../inc/store_credential.php");



if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $customer_id = $_GET['customer_id'];
    
    $customer = shopify_call($acess_token, $shop, "/admin/api/2022-10/customers/$customer_id.json", array(), 'GET');
              $customer = json_decode($customer['response'], JSON_PRETTY_PRINT);
                
                foreach ($customer as $value){
                    if($value){
                        
                        $shopify_email = $value['email'];
                        $shopify_customer_id = $value['id'];
                        $first_name = mysqli_real_escape_string($conn,$value['first_name']);
                        $last_name = mysqli_real_escape_string($conn,$value['last_name']);
                        $email = mysqli_real_escape_string($conn,$value['email']);
                        $tags = mysqli_real_escape_string($conn,$value['tags']);
                        $note = mysqli_real_escape_string($conn,$value['note']);
                         // explode the HCP id from client start
                        $arr = explode("Customer-HCP: ",$value['note']);
                        $new = $arr[1];
                        $compony=  explode("H",$new);
                       
                        $customer_hcp = $compony[0];
                        $select_sql = "SELECT * FROM Customers WHERE email='$shopify_email'";
                        $select_sql_result = $conn->query($select_sql);
                        
                        if($select_sql_result->num_rows > 0){
                            
                            $value_select_customer = $select_sql_result->fetch_assoc();
                            $id_check = $value_select_customer['customer_id'];
                            
                            
                            
                                // update customer 
                                $sql_customer_update = "UPDATE Customers SET customer_id='$shopify_customer_id',first_name='$first_name',last_name='$last_name',email='$email',tags='$tags' ,sec_notes='$note' WHERE customer_id=$shopify_customer_id OR email='$email'";
                                if($conn->query($sql_customer_update)){
                                     // update survey 
                                        $sql_customer_servey_table_update = "UPDATE servey_table SET customer_id='$shopify_customer_id' WHERE customer_id=$id_check";
                                        $conn->query($sql_customer_servey_table_update);
                                        
                                    // update cart
                                        $sql_customer_cartproduct_ids_update = "UPDATE customer_cartproduct_ids SET customer_id='$shopify_customer_id' WHERE customer_id=$id_check";
                                        $conn->query($sql_customer_cartproduct_ids_update);
                                    
                                    // update order
                                        $sql_customer_order_update = "UPDATE customer_order SET customer_id='$shopify_customer_id' WHERE customer_id=$id_check";
                                        $conn->query($sql_customer_order_update);
                                    
                                    // update address
                                        $sql_cutomer_address_update = "UPDATE cutomer_address SET customer_id='$shopify_customer_id' WHERE customer_id=$id_check";
                                        $conn->query($sql_cutomer_address_update);
                                    
                                    // update address
                                        $sql_customer_invoice_update = "UPDATE customer_invoice SET customer_id='$shopify_customer_id' WHERE customer_id=$id_check";
                                        $conn->query($sql_customer_invoice_update);
                                    //    update customer id in all table where id equal end
                                }else{
                                    echo 'error Updating Customer'.$sql_customer_update;
                                }
                        }else{
                            if(!($customer_hcp === ''))
                            {
                                $sql = "INSERT INTO Customers (customer_id, first_name, last_name,email,tags,assigned_check,hcp_id,sec_notes,assign_nutritionist)
                            VALUES ('$value[id]', '$first_name', '$last_name','$email','$tags','1','$customer_hcp','$note','22334455')";
                            }else{
                                 $sql = "INSERT INTO Customers (customer_id, first_name, last_name,email,tags,sec_notes,assign_nutritionist)
                            VALUES ('$value[id]', '$first_name', '$last_name','$email','$tags','$note',,'22334455')";
                            }
                            // explode the HCP id from client end
                           
                            if ($conn->query($sql) === TRUE) {
                                // echo "New record created successfully";
                            } else {
                                echo "Error insert: " . $sql . "<br>" . $conn->error;
                            }
                        }
                        
                    }else{
                        echo 'false';
                    }
                }
}


?>