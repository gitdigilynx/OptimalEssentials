<?php

require_once("../Customers/header.php");
require_once("../inc/db_connect.php");
require_once("../inc/functions.php");
require_once("../inc/store_credential.php");


$resultout = [];


?>
    
 <div class="container-fluid mt-5">
<h3 class="text-center mb-4">Customer Orders</h3>
<hr>

<div style="display: none;" class="alert alert-success alert-dismissible fade show success_alert" role="alert">
  
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

  <div class="table-responsive">
    <table class="table table-bordered">
    <thead>
      <tr>
        <th>Order Id</th>
        <th>Date</th>
        <th>Customer Name</th>
        <th>HCP</th>
        <th>Payment Status</th>
        <th>Shipping Status</th>
        <th>Total</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    
<?php
$sql_order = "SELECT * FROM customer_order ORDER BY id DESC";

   $result_order = $conn->query($sql_order);

    if ($result_order->num_rows > 0){
        while ($value = $result_order->fetch_assoc()){
              $customer_id = $value['customer_id'];
              $order_id = $value['order_id'];
              $order_created_date = $value['order_created_date'];
              $order_payment_status = $value['order_payment_status'];
              $order_shipping_status = $value['order_shipping_status'];
              $product_sub_total = $value['product_sub_total'];
              
            //customer detail query start
              $sql_client_detail = "SELECT
                    customer.first_name as customer_first_name,
                    customer.last_name as customer_lastname,
                    customer.hcp_id as customer_hcp,
                    customerhcp.first_name as hcp_first,
                    customerhcp.last_name as hcp_lastname,
                    customerhcp.email as hcp_email
                FROM
                    Customers as customer
                    LEFT JOIN Customers as customerhcp
                    ON  customerhcp.customer_id = customer.hcp_id
                WHERE
                    customer.customer_id =$customer_id";
                $result_client_detail = $conn->query($sql_client_detail);
                if($result_client_detail->num_rows > 0)
                {
                    
                    $user_deatils_value = $result_client_detail->fetch_assoc();
                    $user_fname = $user_deatils_value['customer_first_name'];
                    $user_lname = $user_deatils_value['customer_lastname'];
                    $userDetails = $user_fname.' '.$user_lname;
                    
                    if($user_deatils_value['customer_hcp'] === '')
                    {
                        $hcp_detail = 'No HCP Assigned';
                    }else{
                    $hcp_fname = $user_deatils_value['hcp_first'];
                    $hcp_lname = $user_deatils_value['hcp_lastname'];
                    $hcp_email = $user_deatils_value['hcp_email'];
                    $hcp_detail = $hcp_fname.' '.$hcp_lname.' ('.$hcp_email.') ';
                    }
                    
                    
                }
            //customer detail query end
 ?>
           
                <tr id="tr_<?=$order_id?>">      <td><a href="https://app.optimalessentials.com.au/optimalessentials/order_invoice/my_order_detail_backend.php?order_id=<?php echo $order_id;?>&customer_id=<?php echo $customer_id;?>">#<?php echo $order_id;?></a></td>
                          <td><?php echo $order_created_date;?></td>
                          <td><?php echo $userDetails;?></td>
                          <td><?php echo $hcp_detail;?></td>
                          <td><?php echo $order_payment_status;?></td>
                          <td><?php echo $order_shipping_status;?></td>
                          <td>$<?php echo $product_sub_total;?></td>
                          <td class="d-flex" > 
                            <a href="https://app.optimalessentials.com.au/optimalessentials/order_invoice/edit_order.php?customer_id=<?=$customer_id?>&order_id=<?=$order_id?>">
                                <button class="btn btn-sm btn-primary" >
                                <i class="fa fa-edit" aria-hidden="true">
                                    
                                </i>
                                </button>
                            </a>
                            <button class="btn btn-sm btn-danger ms-1"  onclick="Delete_order(<?=$order_id?>)" >
                                <i class="fa fa-trash" aria-hidden="true">
                                    
                                </i>
                            </button>
                            
                            </td>
                          <!--<td><a  onclick="ship_order(this.id)"  class=>ship</a></td>-->
                </tr>

                    
  <?php
      
    } 
        
    }
    else {
        
  ?>
        <tr style="text-align:center;" >
                          <td colspan ="5"> No Order Found.</td>
        </tr>
 <?php
  }
  
  

// $resultout[0] = $output;
// $resultout[1] = $userDetails;

// echo json_encode($resultout);


?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

<script src="script1/script_orders.js"></script>