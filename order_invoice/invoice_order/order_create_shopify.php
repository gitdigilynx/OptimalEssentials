<?php

require_once("../../inc/db_connect.php");
require_once("../../inc/functions.php");
require_once("../../inc/store_credential.php");



 $draft_order = '{"draft_order":
     {"line_items":[{"variant_id":43453909631232, "quantity":1}],
     "billing_address":{"first_name":"Mansoor","last_name":"Mahmood","address1":"320B Bluff Road","address2":"3RD FLOOR, VIP ARCADE, I-8 MARKAZ","phone":"+613476534566","company":"DIGILYNX","city":"Sandringham","province":"Victoria","country":"Australia","zip":"3191"},
     "shipping_address":{"first_name":"mohsin","last_name":"hcp","address1":"Sandringham Beach","address2":"office 8, 3rd floor , VIP Plaza","phone":"+923420556446","company":"","city":"Sandringham","province":"Victoria","country":"Australia","zip":"3191"},
     "email":"mansoor@digilynx.net",
     "note":"app-order-id_10022"
     }
     }';

$create_draft_order = curl_init();
     curl_setopt($create_draft_order, CURLOPT_URL, "https://optimal-essentials-dev.myshopify.com/admin/api/2022-10/draft_orders.json");
     curl_setopt($create_draft_order, CURLOPT_CUSTOMREQUEST, 'POST');
     curl_setopt($create_draft_order, CURLOPT_POSTFIELDS, $draft_order);
     curl_setopt($create_draft_order, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($create_draft_order, CURLOPT_SSL_VERIFYPEER, 0);
     curl_setopt($create_draft_order, CURLOPT_HTTPHEADER, array(
              'X-Shopify-Access-Token: '.$acess_token.'',
              'Content-Type: application/json'));

     $response_draft_order = curl_exec($create_draft_order);
     $response_draft_order = json_decode($response_draft_order,true);
     
    $draft_order_id = $response_draft_order['draft_order']['id'];
    $draft_order_invoice_url = $response_draft_order['draft_order']['invoice_url'];
    
     echo '<pre>';
     print_r($response_draft_order);
     
     
     
    $draft_order_invoice = '{"draft_order_invoice":{}}';
    
    $create_draft_order_invoice = curl_init();
         curl_setopt($create_draft_order_invoice, CURLOPT_URL, "https://optimal-essentials-dev.myshopify.com/admin/api/2022-10/draft_orders/$draft_order_id/send_invoice.json");
         curl_setopt($create_draft_order_invoice, CURLOPT_CUSTOMREQUEST, 'POST');
         curl_setopt($create_draft_order_invoice, CURLOPT_POSTFIELDS, $draft_order_invoice);
         curl_setopt($create_draft_order_invoice, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($create_draft_order_invoice, CURLOPT_SSL_VERIFYPEER, 0);
         curl_setopt($create_draft_order_invoice, CURLOPT_HTTPHEADER, array(
                  'X-Shopify-Access-Token: '.$acess_token.'',
                  'Content-Type: application/json'));
    
         $response_draft_order_invoice = curl_exec($create_draft_order_invoice);
         $response_draft_order_invoice = json_decode($response_draft_order_invoice,true);
         
        
         echo '<pre>';
         print_r($response_draft_order_invoice);
         exit;
     
    
   
  
                ///loop
?>
          

   