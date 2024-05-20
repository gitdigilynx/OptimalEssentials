<?php


require_once("../inc/functions.php");

require_once("../inc/store_credential.php");



if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $customer_email = $_GET['customerEmail'];
    
    $customer = shopify_call($acess_token, $shop, "/admin/api/2022-10/customers/search.json?query=email:$customer_email", array(), 'GET');
              $customer = json_decode($customer['response'], JSON_PRETTY_PRINT);
                
                foreach ($customer as $customer){
                    if($customer){
                        echo 'true';
                    }else{
                        echo 'false';
                    }
                }
}

?>