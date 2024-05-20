<?php


require_once("../inc/db_connect.php");
require_once("../inc/functions.php");
require_once("../inc/store_credential.php");

$customer_id = $_GET['customer_id'];
$resultout = [];

$sql_order = "SELECT * FROM customer_order where customer_id=".$customer_id." ORDER BY id DESC";
 
  $result_order = $conn->query($sql_order);

    if ($result_order->num_rows > 0){
        while ($value = $result_order->fetch_assoc()){
              $customer_id = $value['customer_id'];
              $order_id = $value['order_id'];
              $order_created_date = $value['order_created_date'];
              $order_payment_status = $value['order_payment_status'];
              $order_shipping_status = $value['order_shipping_status'];
              $order_approval_status = $value['order_approval_status'];
              $product_sub_total = $value['product_sub_total'];
             
             
            $output.='
                  <tr>
                    <td><a href="/pages/order-details?order_page=true&customer_id='.$customer_id.'&order_id='.$order_id.'" class="Link Link--underline">#'.$order_id.'</a></td>
                    <td>'.$order_created_date.'</td>
                    <td>'.$order_payment_status.'</td>
                    <td>'.$order_shipping_status.'</td>
                    <td class="">'.$product_sub_total.'</td>
                    <td class="order_status_td_'.$order_id.'" style="">
                        '.$order_approval_status.'';
                        
                        if($order_approval_status === 'pending'){
                             $output .=' <button style="padding: 6%;margin-top: 6%;display:none;" class="Button Button--primary order_accept_button"  onclick="Accept_order('.$order_id.',this)">Accept</button>';
                        }
                      
                     $output .='</td>
                    <td style="display:none;" class="actiontd"  > <button class="Button Button--primary edit_order_hcp" customer_id="'.$customer_id.'" order_id ="'.$order_id.'" >Edit</button> </td>
                    
                  </tr>'; 
    }
    
  } else{
       $output.='
                  <tr>
                    <td colspan="5" style="text-align: center;color: red;font-weight: 600;" >No Order Found.</td>
                  </tr>'; 
        
    }
    
$sql_client_detail = "SELECT first_name,last_name,email FROM Customers where customer_id=$customer_id";
$result_client_detail = $conn->query($sql_client_detail);
if($result_client_detail->num_rows > 0)
{
    $user_deatils_value = $result_client_detail->fetch_assoc();
    $user_fname = $user_deatils_value['first_name'];
    $user_lname = $user_deatils_value['last_name'];
    $user_email =$user_deatils_value['email'];
    $userDetails = $user_fname.' '.$user_lname.' ('.$user_email.')';
}
$resultout[0] = $output;
$resultout[1] = $userDetails;

echo json_encode($resultout);