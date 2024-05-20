<?php

require_once("../inc/db_connect.php");
require_once("../inc/functions.php");
require_once("../inc/store_credential.php");



echo $acess_token;






  
// $array = array(
//      'checkout' =>array(
//         'line_items' => array(
//             array(
//                 'product_id' => 7993465962752, 'quantity' => 1
//             )
//             )
//             )
//             );
            
            

  
  

    

// $order_invoice = shopify_call($acess_token,$shop, "/admin/api/2022-10/checkouts.json", $array, 'POST');


// $order_invoice = json_decode($order_invoice['response'], JSON_PRETTY_PRINT);
// print_r( $order_invoice );
$che ='{
     "checkout":{
         "line_items":[
             {"variant_id":43307848958208, "quantity":1},{"variant_id":43453909631232, "quantity":1}
             ]
         }
     }    ';
//  $checkout = '{
//      "checkout":{
//          "line_items":[
//              {"variant_id":43307848958208, "quantity":1},{"variant_id":43453909631232, "quantity":5}
//              ]
//          }
//      }';


 $create_checkout = curl_init();
     curl_setopt($create_checkout, CURLOPT_URL, "https://optimal-essentials-dev.myshopify.com/admin/api/2022-10/checkouts.json");
     curl_setopt($create_checkout, CURLOPT_CUSTOMREQUEST, 'POST');
     curl_setopt($create_checkout, CURLOPT_POSTFIELDS, $che);
     curl_setopt($create_checkout, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($create_checkout, CURLOPT_SSL_VERIFYPEER, 0);
     curl_setopt($create_checkout, CURLOPT_HTTPHEADER, array(
              'X-Shopify-Access-Token: '.$acess_token.'',
              'Content-Type: application/json'));

     $response_checkout = curl_exec($create_checkout);
     $response_checkout = json_decode($response_checkout,true);
     $token_checkout = $response_checkout['checkout']['token'];
   
     
     
    $shipping_address = '{"checkout":
        {
            "token":"'.$token_checkout.'",
            "shipping_address":{
                "first_name":"Nasir ALI ALI",
                "last_name":"Hussain",
                "address1":"320B Bluff Road",
                 "address2": "i8 markaz vip plaza",
                "city":"Sandringham",
                "province_code":"VIC",
                "country_code":"AU",
                "phone":"(123)456-7890",
                "zip":"3191"
            
            }
        }
    }';
    
 $Update_address = curl_init();
     curl_setopt($Update_address, CURLOPT_URL, "https://optimal-essentials-dev.myshopify.com/admin/api/2022-10/checkouts/$token_checkout.json");
     curl_setopt($Update_address, CURLOPT_CUSTOMREQUEST, 'PUT');
     curl_setopt($Update_address, CURLOPT_POSTFIELDS, $shipping_address);
     curl_setopt($Update_address, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($Update_address, CURLOPT_SSL_VERIFYPEER, 0);
     curl_setopt($Update_address, CURLOPT_HTTPHEADER, array(
              'X-Shopify-Access-Token: '.$acess_token.'',
              'Content-Type: application/json'));

     $response_address = curl_exec($Update_address);
     $response_address = json_decode($response_address,true);
     echo '<pre>';
     print_r($response_address);
   
     

          
?>