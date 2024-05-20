<?php

require_once("../../inc/db_connect.php");
require_once("../../inc/functions.php");
require_once("../../inc/store_credential.php");

$customer_id = $_GET['customer_id'];
$invoice_id = $_GET['invoice_id'];
//  echo $customer_id;
//  echo $order_id;
//  exit;

$product_sub_total='';


$sql_gethcp_id = "SELECT * FROM Customers where customer_id=".$customer_id;
 
  $result_gethcp_id = $conn->query($sql_gethcp_id);

    if ($result_gethcp_id->num_rows > 0){
        while ($value = $result_gethcp_id->fetch_assoc()){
              $customer_id_hcp = $value['hcp_id'];
            
    }
   
  }


  
  $output.='
<div align="right" class="Cart__Recap my_order_button" style="margin-bottom: 5%;">
                      
          </div>
<div class="PageLayout PageLayout--breakLap" style="margin-bottom: 4%;">
<div class="PageLayout__Section ">
  <div class="Segment">
      <h2 class="Segment__Title Heading u-h7">Shipping address </h2>

          <div class="Segment__Content">';


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
              $customer_counrty = $value['customer_counrty'];
              
           
             
            $output.='
                 <p class="AccountAddress">
                 <span>'.$customer_fname.' '.$customer_lname.'</span><br>
                 <span>'.$customer_email.'</span><br>
                 <span>'.$customer_phone.'</span><br>
                 '.$customer_address2.', '.$customer_address1.' '.$customer_city.' '.$customer_state.' '.$customer_zip.' '.$customer_counrty.'
              </p>'; 
    }
   
  }
  
  
 $output.='
 </div>
</div>
</div> 
 <div class="PageLayout__Section ">
  <div class="Segment">
      <h2 class="Segment__Title Heading u-h7">Billing address </h2>

          <div class="Segment__Content">';


  $sql_address = "SELECT * FROM cutomer_address where customer_id=".$customer_id_hcp;
 
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
              $customer_counrty = $value['customer_counrty'];
              
           
             
            $output.='
                 <p class="AccountAddress">
                 <span>'.$customer_fname.' '.$customer_lname.'</span><br>
                 <span>'.$customer_email.'</span><br>
                 <span>'.$customer_phone.'</span><br>
                 '.$customer_address2.', '.$customer_address1.' '.$customer_city.' '.$customer_state.' '.$customer_zip.' '.$customer_counrty.'
              </p>'; 
    }
   
  }
    
 $output.='
 </div>
</div>
</div> 
<div class="PageLayout__Section">
          <div class="Segment">
            <h2 class="Segment__Title Heading u-h7">Invoice</h2>

            <div class="Segment__Content">';
            $sql_order = "SELECT
            customerinvoice.order_id,
            customerinvoice.invoice_id,
            customerinvoice.invoice_created_date,
            customerinvoice.sub_total,
            customerinvoice.invoice_status,
            customer_invoicedetails.notes
            
            FROM
            customer_invoice as customerinvoice
            
             LEFT JOIN  customer_invoice_details as customer_invoicedetails
             on
              customerinvoice.invoice_id =  customer_invoicedetails.invoice_id  
            
            where customerinvoice.invoice_id=".$invoice_id;
 
  $result_order = $conn->query($sql_order);

    if ($result_order->num_rows > 0){
        while ($value = $result_order->fetch_assoc()){
             
             
              $order_id	= $value['order_id'];
              $invoice_id	= $value['invoice_id'];
              $invoice_created_date = $value['invoice_created_date'];
              $product_sub_total	= $value['sub_total'];
              $invoice_status	= $value['invoice_status'];
              $invoice_notes	= $value['notes'];
    
             
            $output.='
                <h1 class="SectionHeader__Heading Heading u-h1">Invoice Id #'.$invoice_id.'</h1>
                <p class="SectionHeader__Description">Invoice created on '.$invoice_created_date.'</p>';
                if($invoice_notes){
                    
                
                 $output.='
                <h1 class="SectionHeader__Heading Heading u-h1">Invoice Notes</h1>
                <p class="SectionHeader__Description">'.$invoice_notes.'</p>
                '; 
                }
    }
    
  } 
  
            

  
 $output.='
</div>
</div>
</div>
</div>
 
 <div class="PageLayout PageLayout--breakLap">
    <div class="PageLayout__Section">
      <div class="TableWrapper">
        <table class="AccountTable Table Table--noBorder">
          <thead class="Text--subdued">
            <tr>
              <th>Product</th>
              <th class="Text--alignCenter hidden-phone">Quantity</th>
              <th class="Text--alignRight">Total</th>
            </tr>
          </thead>

          <tbody class ="customer_address_items">';
          
  $sql_item = "SELECT * FROM customer_order_item where  order_id=".$order_id;
 
  $result_item = $conn->query($sql_item);

    if ($result_item->num_rows > 0){
        while ($value = $result_item->fetch_assoc()){
              $product_src	= $value['product_src'];
              $product_title= $value['product_title'];
              $product_price = $value['product_price'];
              $product_qty = $value['product_qty'];
              $product_total = $value['product_total'];
              
    
             
            $output.='<tr>
                <td>
                  <div class="CartItem__ImageWrapper AspectRatio">
                    <div class="AspectRatio" style="--aspect-ratio: 0.8717660292463442">
                      <img class="CartItem__Image" src="'.$product_src.'" alt="'.$product_title.'">
                    </div>
                  </div>

                  <div class="CartItem__Info">
                    <h2 class="CartItem__Title Heading">
                      <a>'.$product_title.'</a>
                    </h2>

                    <div class="CartItem__Meta Heading Text--subdued">
                    <div class="CartItem__PriceList">
                    <span class="CartItem__Price Price">$'.$product_price.'</span></div>
                    </div>
                  </div>
                </td>

                <td class="Text--alignCenter Heading Text--subdued hidden-phone">'.$product_qty.'</td>

                <td class="Text--alignRight Heading Text--subdued">
                <span class="CartItem__Price Price">$'.$product_total.'</span></td>
              </tr>';
    }
    
  } 
          
 


 $output.='</tbody>

          <tfoot>';


             
$output.='<tr>
              <td class="hidden-phone"></td>
              <td class="Heading Text--subdued u-h7">Subtotal</td>
              <td class="Heading Text--subdued Text--alignRight u-h7">$'.$product_sub_total.'</td>
            </tr>';
  
            
$output.='</tfoot>
         </table>
         </div>
         <footer class="Cart__Footer">
         <div align="right" class="Cart__Recap">';
            if($invoice_status === 'Paid'){
             $output.='<button class="Cart__Checkout Button Button--primary" disabled>'.$invoice_status.'</button>';
            }  
            else{
             $output.='<button class="Cart__Checkout Button Button--primary pay_now">Pay Now</button>';
            }
$output.='</div>
    	 </footer>
    	 </div>
         </div>';
  
  echo ($output);

   