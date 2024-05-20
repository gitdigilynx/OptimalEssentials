<?php
require_once("../inc/db_connect.php");
require_once("../inc/functions.php");
require_once("../inc/store_credential.php");



if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $customer_id = $_GET['customer_id'];
    
    $customer = shopify_call($acess_token, $shop, "/admin/api/2022-10/customers/$customer_id.json", array(), 'GET');
              $customer = json_decode($customer['response'], JSON_PRETTY_PRINT);
                
                foreach ($customer as $customer){
                    if($customer){
                        
                        $shopify_email = $customer['email'];
                        $shopify_customer_id = $customer['id'];
                        
                        $select_sql = "SELECT * FROM Customers WHERE email='$shopify_email'";
                        $select_sql_result = $conn->query($select_sql);
                        
                        if($select_sql_result->num_rows > 0){
                            $value_select_customer = $select_sql_result->fetch_assoc();
                            
                            $dataBase_user_id = $value_select_customer['customer_id'];
                            
                            if($dataBase_user_id == $shopify_customer_id){
                                echo 'matched';
                            }else{
                                
                                // update customer 
                                $sql_customer_update = "UPDATE Customers SET customer_id='$shopify_customer_id' WHERE id=$dataBase_user_id";
                                if($conn->query($sql_customer_update)){
                                    echo 'Customer Updated';
                                }else{
                                    echo 'error Updating Customer'.$sql_customer_update;
                                }
                                // update survey 
                                $sql_customer_servey_table_update = "UPDATE servey_table SET customer_id='$shopify_customer_id' WHERE customer_id=$dataBase_user_id";
                                if($conn->query($sql_customer_servey_table_update)){
                                    echo 'Survery Updated';
                                }else{
                                    echo 'error Updating Survery '.$sql_customer_update;
                                }
                                // update address
                                // $sql_cutomer_address_update = "UPDATE cutomer_address SET customer_id='$shopify_customer_id' WHERE customer_id=$dataBase_user_id";
                                // $conn->query($sql_cutomer_address_update);
                            }
                        }
                        
                    }else{
                        echo 'false';
                    }
                }
}

?>