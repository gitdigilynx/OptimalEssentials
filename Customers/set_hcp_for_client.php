<?php

// $hcp_id = $_GET['id_hcp'];
    $id_from_dropdown = $_GET['staff_id'];
    $client_id = $_GET['id_client'];
    
    require_once("../inc/functions.php");
    require_once("../inc/store_credential.php");
    require_once("../inc/db_connect.php");
    
    $modify_data = array(
    	"customer" => array(
    		"id" => $client_id,
    		"tags" => "HCPClient"
    	)
    );

 

    //  $sql = "UPDATE Customers SET assigned_check='1',hcp_id='$hcp_id',tags='HCPClient' WHERE customer_id=$client_id";

// find hcp if exist then add it to client
    $sql_for_hcp_check = "SELECT tags FROM Customers WHERE tags='HCP' AND customer_id=$id_from_dropdown";
    // var_dump($sql_for_hcp_check);
        $result_sql_for_hcp_check = $conn->query($sql_for_hcp_check);
        // var_dump($result_sql_for_hcp_check);
        if($result_sql_for_hcp_check->num_rows > 0)
        {
            $value_result_sql_for_hcp_check = $result_sql_for_hcp_check->fetch_assoc();
            
             $assigne_hcp_to_client = "UPDATE Customers SET assigned_check='1',hcp_id='$id_from_dropdown',tags='HCPClient',staff_id='' WHERE customer_id=$client_id";
             
                if ($conn->query($assigne_hcp_to_client) === TRUE) 
                {
                     echo 'HCP Updated';
                     $customer1 = shopify_call($acess_token, $shop, "/admin/api/2022-07/customers/" . $client_id.".json", $modify_data, 'PUT');
                    $customer1 = json_decode($customer1['response'], JSON_PRETTY_PRINT);
                }
                
                else
                {
                    echo 'error';
                }
            
        }else{
            $sql = "UPDATE Customers SET staff_id='$id_from_dropdown' WHERE customer_id=$client_id";
                    if ($conn->query($sql) === TRUE) {
                        
                        // serach hcp of that staff
                             $search_hcp_id = "SELECT hcp_id FROM Customers WHERE customer_id=$id_from_dropdown";
                                $result_of_search_hcp_id = $conn->query($search_hcp_id);
                            
                                if ($result_of_search_hcp_id->num_rows > 0) {
                                    
                                    $value_of_search_hcp_id = $result_of_search_hcp_id->fetch_assoc();
                                    $hcp_id = $value_of_search_hcp_id['hcp_id'];
                                    
                                     $assigne_hcp_to_client = "UPDATE Customers SET assigned_check='1',hcp_id='$hcp_id',tags='HCPClient' WHERE customer_id=$client_id";
                                        if ($conn->query($assigne_hcp_to_client) === TRUE) {
                                            echo 'Staff Update';
                                        }else{
                                            echo 'error';
                                        }
                                    
                                } else {
                                    echo "0 results";
                                }
                        
                        
                       $customer1 = shopify_call($acess_token, $shop, "/admin/api/2022-07/customers/" . $client_id.".json", $modify_data, 'PUT');
                        $customer1 = json_decode($customer1['response'], JSON_PRETTY_PRINT);
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
        }

    
    




$conn->close();



?>