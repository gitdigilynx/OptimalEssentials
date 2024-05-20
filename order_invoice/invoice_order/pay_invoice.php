<?php

require_once("../../inc/db_connect.php");
require_once("../../inc/functions.php");
require_once("../../inc/store_credential.php");

// $customer_id = $_GET['customer_id'];
$invoice_id = $_GET['invoice_id'];

 $sql_invoice = "SELECT draft_order_invoice_url FROM customer_invoice where invoice_id=$invoice_id";
 
  $result_invoice = $conn->query($sql_invoice);

    if ($result_invoice->num_rows > 0){
        while ($value = $result_invoice->fetch_assoc()){
             
              $draft_order_invoice_url	= $value['draft_order_invoice_url'];
              echo $draft_order_invoice_url;
    }
    
  } 
 
 





//   $product_sub_total='';
//   $sql_address = "SELECT * FROM cutomer_address where customer_id=".$customer_id;
 
//   $result_address = $conn->query($sql_address);

//     if ($result_address->num_rows > 0){
//         while ($value = $result_address->fetch_assoc()){
//               $customer_id = $value['customer_id'];
//               $customer_fname = $value['customer_fname'];
//               $customer_lname = $value['customer_lname'];
//               $customer_email = $value['customer_email'];
//               $customer_phone = $value['customer_phone'];
//               $customer_zip = $value['customer_zip'];
//               $customer_address1 = $value['customer_address1'];
//               $customer_address2 = $value['customer_address2'];
//               $customer_city = $value['customer_city'];
//               $customer_state = $value['customer_state'];
//               $customer_state_code = $value['customer_state_code'];
//               $customer_counrty = $value['customer_counrty'];
//               $customer_compony = $value['compony'];
   
          
//     }
   
//   }
    
 
//  $sql_order = "SELECT * FROM customer_invoice where invoice_id=".$invoice_id;
 
//   $result_order = $conn->query($sql_order);

//     if ($result_order->num_rows > 0){
//         while ($value = $result_order->fetch_assoc()){
             
//               $order_id	= $value['order_id'];
//               $invoice_id	= $value['invoice_id'];
//               $invoice_created_date = $value['invoice_created_date'];
//               $product_sub_total	= $value['sub_total'];
//     }
    
//   } 
  
            

  
      
//   $sql_item = "SELECT * FROM customer_order_item where  order_id=".$order_id;
 
//   $result_item = $conn->query($sql_item);

//     if ($result_item->num_rows > 0){
        
//         $length_products12 = $result_item->num_rows;
//         $count_increment =1 ;
        
//         while ($value = $result_item->fetch_assoc()){
//               $product_id	= $value['product_id'];
//               $variant_id	= $value['variant_id'];
//               $product_src	= $value['product_src'];
//               $product_title= $value['product_title'];
//               $product_price = $value['product_price'];
//               $product_qty = $value['product_qty'];
//               $product_total = $value['product_total'];
            
               
        
                        
//                 /////////////////////shipping and checkout start///////////////////////
                 
//                   $array_products12 .= '{"variant_id":'.$variant_id.', "quantity":'.$product_qty.'}';
//                     if($length_products12 == $count_increment){
                    
//                     }else{
//                     $array_products12.=',';
//                     }
                  
                
//                 /////////////////////shipping and checkout end///////////////////////
                        
         
             
//         $count_increment++;
//     }
    
//   } 
  

//  $checkout = '{
//      "checkout":{
//          "line_items":[
//              '.$array_products12.'
//              ]
//          }
//      }';

// $create_checkout = curl_init();
//      curl_setopt($create_checkout, CURLOPT_URL, "https://optimal-essentials-dev.myshopify.com/admin/api/2022-10/checkouts.json");
//      curl_setopt($create_checkout, CURLOPT_CUSTOMREQUEST, 'POST');
//      curl_setopt($create_checkout, CURLOPT_POSTFIELDS, $checkout);
//      curl_setopt($create_checkout, CURLOPT_RETURNTRANSFER, true);
//      curl_setopt($create_checkout, CURLOPT_SSL_VERIFYPEER, 0);
//      curl_setopt($create_checkout, CURLOPT_HTTPHEADER, array(
//               'X-Shopify-Access-Token: '.$acess_token.'',
//               'Content-Type: application/json'));

//      $response_checkout = curl_exec($create_checkout);
//      $response_checkout = json_decode($response_checkout,true);
     
//      $token_checkout = $response_checkout['checkout']['token'];
     
    
   
     
     
//      $shipping_address = '{"checkout":
//         {
//                 "token":"'.$token_checkout.'",
//                 "note": "app-order-id_'.$order_id.'",
//                 "email":"'.$customer_email.'",
//                 "shipping_address":{
//                 "first_name":"'.$customer_fname.'",
//                 "last_name":"'.$customer_lname.'",
//                 "address1":"'.$customer_address1.'",
//                 "address2": "'.$customer_address2.'",
//                 "city":"'.$customer_city.'",
//                 "province_code":"'.$customer_state_code.'",
//                 "country_code":"AU",
//                 "phone":"'.$customer_phone.'",
//                 "company":"'.$customer_compony.'",
//                 "zip":"'.$customer_zip.'"
                
            
//             }
//         }
//     }';
    
    
    
//  $Update_address = curl_init();
//      curl_setopt($Update_address, CURLOPT_URL, "https://optimal-essentials-dev.myshopify.com/admin/api/2022-10/checkouts/$token_checkout.json");
//      curl_setopt($Update_address, CURLOPT_CUSTOMREQUEST, 'PUT');
//      curl_setopt($Update_address, CURLOPT_POSTFIELDS, $shipping_address);
//      curl_setopt($Update_address, CURLOPT_RETURNTRANSFER, true);
//      curl_setopt($Update_address, CURLOPT_SSL_VERIFYPEER, 0);
//      curl_setopt($Update_address, CURLOPT_HTTPHEADER, array(
//               'X-Shopify-Access-Token: '.$acess_token.'',
//               'Content-Type: application/json'));

//      $response_address = curl_exec($Update_address);
//      $response_address = json_decode($response_address,true);
//     //  echo '<pre>';
//     //  print_r($response_address);
//     //  exit;
    
//      $web_url = $response_checkout['checkout']['web_url'];
    
//      echo $web_url;
  
  
        
                ///loop
?>
          

   