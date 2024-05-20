<?php



require_once("../inc/db_connect.php");
require_once("../inc/functions.php");
require_once("../inc/store_credential.php");


             $customer_shopify = shopify_call($acess_token,$shop, "/admin/api/2022-10/customers/6419716178176.json", array(), 'GET');
             $customer_shopify = json_decode($customer_shopify ['response'], JSON_PRETTY_PRINT);
             
             echo '<pre>';
             print_r( $customer_shopify );
             exit();
             
            //   $products = shopify_call($acess_token, $shop, "/admin/api/2022-10/products/$product_id.json", array(), 'GET');
            //   $products = json_decode($products['response'], JSON_PRETTY_PRINT);
                
            //   ///loop_product start
            //     foreach ($products as $product){
            //         if($product != 'Not Found' && !is_string($product['id'])){
                        
            //             $product_id = $product['id'];
            //             $product_title = $product['title'];
            //             $product_price = $product['variants'][0]['price'];
            //             $product_src = $product['image']['src'];
            //             $product_handle = $product['handle'];
                        
            //             $output.='';
            //         }        
            //     }
            //   ///loop_product end
?>