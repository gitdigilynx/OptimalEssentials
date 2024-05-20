<?php

require_once("../../inc/db_connect.php");
require_once("../../inc/functions.php");
require_once("../../inc/store_credential.php");

$customer_id = $_GET['customer_id'];
$order_id = $_GET['order_id'];
$invoice_id = $_GET['invoice_id'];
 
$product_sub_total='';



$sql_hcp = "SELECT hcp_id FROM Customers where customer_id=".$customer_id;
 
  $result_hcp = $conn->query($sql_hcp);

    if ($result_hcp->num_rows > 0){
        while ($value = $result_hcp->fetch_assoc()){
              $hcp_id = $value['hcp_id'];
          
        }
    }
    



  $sql_address_hcp = "SELECT * FROM cutomer_address where customer_id=".$hcp_id;
 
  $result_address_hcp = $conn->query($sql_address_hcp);

    if ($result_address_hcp->num_rows > 0){
        while ($value = $result_address_hcp->fetch_assoc()){
              $customer_id_hcp = $value['customer_id'];
              $customer_fname_hcp = $value['customer_fname'];
              $customer_lname_hcp = $value['customer_lname'];
              $customer_email_hcp = $value['customer_email'];
              $customer_phone_hcp = $value['customer_phone'];
              $customer_zip_hcp = $value['customer_zip'];
              $customer_address1_hcp = $value['customer_address1'];
              $customer_address2_hcp = $value['customer_address2'];
              $customer_city_hcp = $value['customer_city'];
              $customer_state_hcp = $value['customer_state'];
              $customer_state_code_hcp = $value['customer_state_code'];
              $customer_counrty_hcp = $value['customer_counrty'];
              $customer_compony_hcp = $value['compony'];
    }
   
  }
  
  $sql_address = "SELECT * FROM cutomer_address where customer_id=".$customer_id;
 
  $result_address = $conn->query($sql_address);

    if ($result_address->num_rows > 0){
        while ($value = $result_address->fetch_assoc()){
              $customer_id = $value['customer_id'];
              $customer_fname = $value['customer_fname'];
              $customer_lname = $value['customer_lname'];
              $customer_email = $value['customer_email'];
              $customer_phone = $value['customer_phone'];
              $customer_zip = $value['customer_zip'];
              $customer_address1 = $value['customer_address1'];
              $customer_address2 = $value['customer_address2'];
              $customer_city = $value['customer_city'];
              $customer_state = $value['customer_state'];
              $customer_state_code = $value['customer_state_code'];
              $customer_counrty = $value['customer_counrty'];
              $customer_compony = $value['compony'];
   
          
    }
   
  }
    
 
      
  $sql_item = "SELECT * FROM customer_order_item where order_id=$order_id";
  
 
  $result_item = $conn->query($sql_item);

    if ($result_item->num_rows > 0){
        
        $length_products12 = $result_item->num_rows;
        $count_increment =1 ;
        
        while ($value = $result_item->fetch_assoc()){
              $product_id	= $value['product_id'];
              $variant_id	= $value['variant_id'];
              $product_src	= $value['product_src'];
              $product_title= $value['product_title'];
              $product_price = $value['product_price'];
              $product_qty = $value['product_qty'];
              $product_total = $value['product_total'];
            
               
        
                        
                /////////////////////shipping and checkout start///////////////////////
                 
                   $array_products12 .= '{"variant_id":'.$variant_id.', "quantity":'.$product_qty.'}';
                    if($length_products12 == $count_increment){
                    
                    }else{
                    $array_products12.=',';
                    }
                  
                
                /////////////////////shipping and checkout end///////////////////////
                        
         
             
        $count_increment++;
    }
    
  } 
  

if($hcp_id == '')
{
        
    $draft_order = '{"draft_order":
     {"line_items":['.$array_products12.'],
     
     "billing_address":{
     "first_name":"'.$customer_fname.'",
     "last_name":"'.$customer_lname.'",
     "address1":"'.$customer_address1.'",
     "address2":"'.$customer_address2.'",
     "phone":"'.$customer_phone.'",
     "company":"'.$customer_compony.'",
     "city":"'.$customer_city.'",
     "province":"'.$customer_state.'",
     "country":"'.$customer_counrty.'",
     "zip":"'.$customer_zip.'"},
     "shipping_address":{
     "first_name":"'.$customer_fname.'",
     "last_name":"'.$customer_lname.'",
     "address1":"'.$customer_address1.'",
     "address2":"'.$customer_address2.'",
     "phone":"'.$customer_phone.'",
     "company":"'.$customer_compony.'",
     "city":"'.$customer_city.'",
     "province":"'.$customer_state.'",
     "country":"'.$customer_counrty.'",
     "zip":"'.$customer_zip.'"},
     "email":"'.$customer_email.'",
     "note":"app-order-id_'.$order_id.'"
     }
     }';
     
}else{
    
    $draft_order = '{"draft_order":
     {"line_items":['.$array_products12.'],
     "billing_address":{
     "first_name":"'.$customer_fname_hcp.'",
     "last_name":"'.$customer_lname_hcp.'",
     "address1":"'.$customer_address1_hcp.'",
     "address2":"'.$customer_address2_hcp.'",
     "phone":"'.$customer_phone_hcp.'",
     "company":"'.$customer_compony_hcp.'",
     "city":"'.$customer_city_hcp.'",
     "province":"'.$customer_state_hcp.'",
     "country":"'.$customer_counrty_hcp.'",
     "zip":"'.$customer_zip_hcp.'"},
     "shipping_address":{
     "first_name":"'.$customer_fname.'",
     "last_name":"'.$customer_lname.'",
     "address1":"'.$customer_address1.'",
     "address2":"'.$customer_address2.'",
     "phone":"'.$customer_phone.'",
     "company":"'.$customer_compony.'",
     "city":"'.$customer_city.'",
     "province":"'.$customer_state.'",
     "country":"'.$customer_counrty.'",
     "zip":"'.$customer_zip.'"},
     "email":"'.$customer_email_hcp.'",
     "note":"app-order-id_'.$order_id.'"
     }
     }';
}

     
    
    
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
        
        
         
         
         
         
       
             
            
            //  echo '<pre>';
            //  var_dump($response_draft_order_invoice);
             
            //  echo '<pre>';
            //  var_dump($response_draft_order);
             $draft_order_invoice_url = $response_draft_order['draft_order']['invoice_url'];
             $draft_order_invoice_id = $response_draft_order['draft_order']['id'];
           
             if($hcp_id === '')
                {
                    echo $draft_order_invoice_url;
                }else{
                    
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
                     
                             
                             
                             $sql = "UPDATE customer_invoice SET draft_order_invoice_url='$draft_order_invoice_url' WHERE invoice_id=$invoice_id";
                                if ($conn->query($sql) === TRUE) {
                                    
                                    // insert record into invoice table start
                                    $sql_shopify_draft_and_order_ids = "INSERT INTO shopify_draft_and_order_ids (invoice_id, draft_order_id)
                                                VALUES ('$invoice_id', '$draft_order_invoice_id')";
                                    $conn->query($sql_shopify_draft_and_order_ids);
                                    // insert record into invoice table end
                                  echo "Record updated successfully";
                                } else {
                                  echo "Error updating record: " . $conn->error;
                                }
                }
             
            
             exit;
      
  
        
                ///loop
?>