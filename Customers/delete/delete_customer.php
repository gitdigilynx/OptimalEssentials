<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    // include the required files
        require_once("../../inc/db_connect.php");
        require_once("../../inc/functions.php");
        require_once("../../inc/store_credential.php");
        $customers_id = $_GET['customer_id'];
        
        $customer1 = shopify_call($acess_token, $shop, "/admin/api/2022-07/customers/$customers_id.json", array(), 'DELETE');
        $customer1 = json_decode($customer1['response'], JSON_PRETTY_PRINT);
        // if($customer1['errors']){
        //   echo $customer1['errors'];
        // }else{
            
             $sql = "DELETE FROM Customers WHERE customer_id=$customers_id";

                if ($conn->query($sql) === TRUE) {
                  echo "success";
                } else {
                  echo "Error deleting record: " . $conn->error;
                }
        // }
        
}

?>