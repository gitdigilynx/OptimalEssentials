<?php

require_once("../inc/db_connect.php");
require_once("../inc/functions.php");
require_once("../inc/store_credential.php");

$variant_id = $_GET['variant_id'];

 $varients = shopify_call($acess_token, $shop, "/admin/api/2022-10/variants/$variant_id.json", array(), 'GET');
              $varients = json_decode($varients['response'], JSON_PRETTY_PRINT);
                
                foreach ($varients as $varient){
                    if($varient != 'Not Found' && !is_string($varient['id'])){
                        
                        $varient_price = $varient['price'];
                        
                       echo $varient_price;
                    }
                }

?>