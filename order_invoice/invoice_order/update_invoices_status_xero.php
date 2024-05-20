<?php

require_once("../../inc/db_connect.php");
require_once("../../inc/functions.php");
require_once("../../inc/store_credential.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    $output = '';
    $output_array = [];
    
    $invoice_numbers = $_GET['invoice_numbers'];
    $title_name =$_GET['title_name'];
    $notes_for_invoice =$_GET['notes_for_invoice'];
    
    foreach($invoice_numbers as $invoice_number){
        
                $sql = "SELECT invoice_id,order_id FROM customer_invoice where invoice_id=$invoice_number";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    
                    // updated_draft_order_status_on_shopify($invoice_number); // mark as paid by zero
                    
                        $sql_select_draft_order = "SELECT draft_order_id FROM shopify_draft_and_order_ids where invoice_id=$invoice_number";
                        $result_select_draft_order = $conn->query($sql_select_draft_order);
                
                        if ($result_select_draft_order->num_rows > 0) {
                          // output data of each row
                          $row_select_draft_order = $result_select_draft_order->fetch_assoc();
                          $draft_order_id = $row_select_draft_order['draft_order_id'];
                        }else{
                            echo 'error'.$sql_select_draft_order;
                        }
                        $data = array(
                          'draft_order' => array(
                            'id' => $draft_order_id,
                            'note' => 'Paid by Xero.com',
                          )
                        );
                
                
                
                        $update_draft_order_note = shopify_call($acess_token, $shop, "/admin/api/2022-07/draft_orders/" . $draft_order_id . ".json", $data,'PUT');
                        $update_draft_order_note = json_decode($update_draft_order_note['response'], JSON_PRETTY_PRINT);
                       
                        if($update_draft_order_note['errors']){
                            $output_array[0] = 0;
                            $output_array[1] = 'Unable to updating draft order notes';
                        }else{
                            $response = true;
                            $update_draft_order_note = shopify_call($acess_token, $shop, "/admin/api/2022-07/draft_orders/" . $draft_order_id . "/complete.json", $data,'PUT');
                            $update_draft_order_note = json_decode($update_draft_order_note['response'], JSON_PRETTY_PRINT);
                            if($update_draft_order_note['errors']){
                                $output_array[0] = 0;
                                $output_array[1] = 'Unable to mark draft as complete';
                            }else{
                                $row = $result->fetch_assoc();
                              $order_id = $row['order_id'];
                              
                            //   update invoice payment status 
                              $sql_update_invoice = "UPDATE customer_invoice SET invoice_status='Paid' WHERE invoice_id=$invoice_number";
                    
                                if ($conn->query($sql_update_invoice) === TRUE) {
                                    
                                    
                                    
                                    // update order payment status
                                  $sql_update_order = "UPDATE customer_order SET order_payment_status='Paid' WHERE order_id=$order_id";
                                  if ($conn->query($sql_update_order) === TRUE) {
                                  }
                                  
                                  $sql = "INSERT INTO customer_invoice_details (invoice_id, notes)
                                    VALUES ('$invoice_number', '$notes_for_invoice')";
                                    
                                    if ($conn->query($sql) === TRUE) {
                                      $output_array[0] = 'success';
                                    } else {
                                      echo "Error: " . $sql . "<br>" . $conn->error;
                                    }
                                  
                                } else {
                                  echo "Error updating record: " . $conn->error;
                                }
                                
                                 echo json_encode($output_array);
                            }
                        }
            
            
            
          
          
        } else {
          echo "0 results";
        }
    }
    
    
   
    
    
   
    
}


 function updated_draft_order_status_on_shopify($invoice_number){
     global $conn;
     $draft_order_id = '';
     $response = false;
        $sql_select_draft_order = "SELECT draft_order_id FROM shopify_draft_and_order_ids where invoice_id=$invoice_number";
        $result_select_draft_order = $conn->query($sql_select_draft_order);
        
        if ($result_select_draft_order->num_rows > 0) {
          // output data of each row
          $row_select_draft_order = $result_select_draft_order->fetch_assoc();
          $draft_order_id = $row_select_draft_order['draft_order_id'];
        }else{
            echo 'error'.$sql_select_draft_order;
        }
        $data = array(
          'draft_order' => array(
            'id' => $draft_order_id,
            'note' => 'Paid by Xero.com',
          )
        );



        $update_draft_order_note = shopify_call($acess_token, $shop, "/admin/api/2022-07/draft_orders/" . $draft_order_id . ".json", $data,'PUT');
        $update_draft_order_note = json_decode($update_draft_order_note['response'], JSON_PRETTY_PRINT);
       
        if($update_draft_order_note['errors']){
            $output_array[0] = 0;
            $output_array[1] = 'Unable to updating draft order notes';
        }else{
            $response = true;
            $update_draft_order_note = shopify_call($acess_token, $shop, "/admin/api/2022-07/draft_orders/" . $draft_order_id . "/complete.json", $data,'PUT');
            $update_draft_order_note = json_decode($update_draft_order_note['response'], JSON_PRETTY_PRINT);
            if($update_draft_order_note['errors']){
                $output_array[0] = 0;
                $output_array[1] = 'Unable to mark draft as complete';
            }
        }
        
    }

?>