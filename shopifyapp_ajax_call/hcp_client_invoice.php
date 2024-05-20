<?php
    $output = '';
    
    require_once("../inc/db_connect.php");
    
    $count =0;
 
        $hcp_id = $_GET['customerId'];
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
     
     FROM Customers as customers
     LEFT JOIN  customer_invoice as cusstomerinvoice
     on
      customers.customer_id =  cusstomerinvoice.customer_id  
     WHERE  customers.tags= 'HCPClient' AND (customers.hcp_id=$hcp_id OR customers.staff_id=$hcp_id ) AND  cusstomerinvoice.invoice_id IS NOT NULL 
     ORDER BY cusstomerinvoice.id DESC;";
     
    $result2 = $conn->query($sql2);
    $output .='<div>
    
    <div class="Form__Item" style="text-align: right;">
            <button style="width:100%" class="Button Button--primary mark_invoices">MarK invoices as paid</button>
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
            $count++;
            $check_checkBox = '';
            if($value['invoice_status'] === 'Paid'){
                $check_checkBox = 'disabled title="Paid"';
            }
            $output .=
                '<tr>
                          <td><input name="invice_check_box" class="label_iput invoice_select_status" type="checkbox" value="'.$value['invoice_id'].'" '.$check_checkBox.'></td>
                          <td> <a href="/pages/invoice-details?customer_id='.$value['client_id'].'&invoice_id='.$value['invoice_id'].'" class="Link Link--underline" >#'.$value['invoice_id'].'</a></td>
                          <td><a href="/pages/order-details?customer_id='.$value['client_id'].'&order_id='.$value['order_id'].'" class="Link Link--underline">#'.$value['order_id'].'</a></td>
                          <td>' . $value['invoice_created_date'] . '</td>
                          <td>' . $value['first_name'] .' '.$value['last_name'] . '</td>
                          <td>'. $value['invoice_status'].'</td> 
                          <td>$'. $value['sub_total'].'</td> 
                </tr>';

                    
             
            
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
</table>
</div>

</div>
';
 echo $output;
        // <header style="margin-bottom: 4%;margin-top: 4%;" class="Segment">
    //           <h2 class="Segment__Title Heading u-h2">Payment Section</h2>
    // </header>
    // <div >
    
    //     <div class="Form__Item">
    //         <select class="Form__Input hcpstaff_2" id="hcpstaff" name="hcpstaff" style="/*! width: 20%; */">
    //           <option selected disabled>Select Payment Method</option>
    //           <option value="xero">xero</option>
    //           </select>
    //           <label class="Form__FloatingLabel">Paid By</label>
    //     </div>
    //     <div class="Form__Item">
    //         <textarea class="Form__Input">helo</textarea>
    //          <label class="Form__FloatingLabel"></label>
    //     </div>
    //     <div class="Form__Item">
    //         <button class="Button Button--primary">Update</button>
    //     </div>
    // </div>
    // <hr class="Segment">
   
    
    
    

  

    
    
    
    
?>