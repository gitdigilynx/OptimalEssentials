<?php


require_once("../inc/db_connect.php");
require_once("../inc/functions.php");
require_once("../inc/store_credential.php");

$customer_id = $_GET['customer_id'];
$order_id = $_GET['order_id'];
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
<h1 class="Segment__Title Heading u-h1" style="font-weight: 900 !important;text-align: center; margin-bottom: 4%;color: black;">Order Detail</h1>
<div align="right" class="Cart__Recap my_order_button" style="margin-bottom: 5%;">
                      
          </div>
<div class="PageLayout PageLayout--breakLap" style="margin-bottom: 4%;">
<div class="PageLayout__Section">
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
            <h2 class="Segment__Title Heading u-h7">Order</h2>

            <div class="Segment__Content">';
            $sql_order = "SELECT * FROM customer_order where order_id=".$order_id;
 
  $result_order = $conn->query($sql_order);

    if ($result_order->num_rows > 0){
        while ($value = $result_order->fetch_assoc()){
              $customer_id	= $value['customer_id'];
              $order_id	= $value['order_id'];
              $order_created_date = $value['order_created_date'];
              $order_updated_at = $value['order_updated_at'];
              $order_shipping_status = $value['order_shipping_status'];
              $order_approval_status = $value['order_approval_status'];
               $product_sub_total	= $value['product_sub_total'];
    
             
            $output.='
                <h1 class="SectionHeader__Heading Heading u-h1">Order id #'.$order_id.'</h1>
                <h5 class="SectionHeader__Description">Order placed on:</h5>
                <p class="SectionHeader__Description">'.$order_created_date.'</p>
                '; 
                if($order_updated_at)
                {
                    $output.='
                    <h5 class="SectionHeader__Description">Order updated on:</h5>
                    <p class="SectionHeader__Description">'.$order_updated_at.'</p>
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
          
  $sql_item = "SELECT * FROM customer_order_item where order_id=".$order_id;
 
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

// if($order_approval_status == 'Unshipped')
//     {
//                       $output.='';
//     }else{ 
                  $output.='<tr>
                          <td class="hidden-phone"></td>
                          <td class="Heading Text--subdued u-h7">Subtotal</td>
                          <td class="Heading Text--subdued Text--alignRight u-h7">$'.$product_sub_total.'</td>
                        </tr>
                        <tr id="tr_accept_reject" style="display:none;" >
                          <td class="hidden-phone"></td>
                          <td class="Heading u-h7">
                            <div class="Form__Item" style="margin-bottom:0px !important;" >
                                    <select id="approval_status" class="Form__Input">';
                                      if($order_approval_status == 'pending')
                                      {
                                          $output.='<option id="'.$order_id.'" value="pending" selected>Pending</option>';
                                      }else{
                                         $output.='<option id="'.$order_id.'" value="pending" >Pending</option>';   
                                      }
                                      if($order_approval_status == 'accepted')
                                      {
                                          $output.='<option id="'.$order_id.'" value="Accepted" selected>Accepted</option>';
                                      }else{
                                         $output.='<option id="'.$order_id.'" value="accept">Accept</option>';   
                                      }
                                      if($order_approval_status == 'rejected')
                                      {
                                          $output.='<option id="'.$order_id.'" value="Rejected" selected>Rejected</option>';
                                      }else{
                                         $output.='<option id="'.$order_id.'" value="cancel">Reject</option>';   
                                      }
                                        
                    $output.='      </select>
                                <label class="Form__FloatingLabel">Approval</label>
                            </div>
                          </td>
                          <td class="Heading Text--alignRight u-h7"><button class="Button Button--primary" id="shipunshipb_id"  onclick="acceptreject()" title="order approval button">Update</button></td>
                        </tr>';
            // }
        
 $output.='</tfoot>
        </table>
      </div>
    </div>
  </div>';
  
  echo ($output);

   