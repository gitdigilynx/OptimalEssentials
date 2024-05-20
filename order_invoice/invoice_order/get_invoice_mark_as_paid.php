<?php

require_once("../../inc/db_connect.php");


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
   
   $invoice_numbers = $_GET['invoices_numbers'];
   
   $total_amount = 0;
   
    $bold_th_for_staff_data ='style="font-weight: 900 !important;"';
                    
    $sql2 = "SELECT
    cusstomerinvoice.invoice_id,
     cusstomerinvoice.order_id,
     customers.customer_id as client_id,
     cusstomerinvoice.invoice_status,
     cusstomerinvoice.sub_total,
     cusstomerinvoice.invoice_created_date,
     customers.first_name,
     customers.last_name
    FROM
    customer_invoice AS cusstomerinvoice
    
     LEFT JOIN  Customers as customers
     on
      cusstomerinvoice.customer_id = customers.customer_id   
    ORDER BY cusstomerinvoice.id DESC";
     
    $result2 = $conn->query($sql2);
    $output .='<div>
     <div class="Form__Item" style="text-align: right;">
            <h1 class="Segment__Title Heading u-h1" style="font-weight: 900 !important;text-align: center; margin-bottom: 4%;color: black;">Mark as paid invoices</h1>
        </div>
    <div class="TableWrapper">
    <table class="AccountTable Table Table--large">
  <thead class="Text--subdued">
    <tr>
      <th>Select</th>
      <th>Invoice ID</th>
      <th>Order ID</th>
      <th>Date</th>
      <th>Customer</th>
      <th>Status</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody class="Heading u-h7">
  
      <div class="scrollit">';
    if ($result2->num_rows > 0) {
        // output data of each row
        while ($value = $result2->fetch_assoc()) {
            foreach($invoice_numbers as $invoice_number){
                
            if($value['invoice_id'] == $invoice_number){
                
              
                $count++;
                $output .=
                    '<tr>
                              <td><input name="invice_check_box" subTotal="'.$value['sub_total'].'" class="label_iput invoice_select_status_pg" type="checkbox" checked value="'.$value['invoice_id'].'"></td>
                              <td> <a href="/pages/invoice-details?customer_id='.$value['client_id'].'&invoice_id='.$value['invoice_id'].'" class="Link Link--underline" >#'.$value['invoice_id'].'</a></td>
                              <td><a href="/pages/order-details?customer_id='.$value['client_id'].'&order_id='.$value['order_id'].'" class="Link Link--underline">#'.$value['order_id'].'</a></td>
                              <td>' . $value['invoice_created_date'] . '</td>
                              <td>' . $value['first_name'] .' '.$value['last_name'] . '</td>
                              <td>'. $value['invoice_status'].'</td> 
                              <td>$'. $value['sub_total'].'</td> 
                    </tr>';
                    
                    $total_amount +=$value['sub_total'];
    
                }
            }
            
        }
      
    } else {
        $output .=
                '<tr style="text-align:center;" >
                          <td   style="color: red;font-weight: 600;text-align: center;" colspan="6"> No invoice found!</td>
                </tr>';
    }
      $output .=' 
      </div>
        </tbody>
        <tfoot><tr>
                          <td class="hidden-phone"></td>
                          <td class="hidden-phone"></td>
                          <td class="hidden-phone"></td>
                          <td class="hidden-phone"></td>
                          <td class="hidden-phone"></td>
                          <td class="Heading u-h7">Subtotal</td>
                          <input value="'.$total_amount.'" class="subtotalimput" hidden >
                          <td class="Heading Text--alignLeft  u-h7 subtotaltd">$'.$total_amount.'</td>
                        </tr>
                        <tr id="tr_accept_reject" style="display:none;"></tr></tfoot>
</table>
</div>
<div >
    
        <div class="Form__Item">
            <input name="title" class="title_name" value="xero" hidden>
        </div>
        <div class="Form__Item">
            <textarea name="notes_for_invoice" class="Form__Input notes_for_invoice" placeholder="Write notes.."></textarea>
             <label class="Form__FloatingLabel">Notes</label>
        </div>
        <div class="Form__Item">
            <button class="Button Button--primary updated_status_xero">Update</button>
        </div>
    </div>
</div>
';
 echo $output;
   
}


?>