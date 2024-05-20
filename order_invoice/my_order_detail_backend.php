<?php

require_once("../Customers/header.php");
require_once("../inc/db_connect.php");
require_once("../inc/functions.php");
require_once("../inc/store_credential.php");

    $order_id = $_GET['order_id'];
    $customer_id =$_GET['customer_id'];
    $product_sub_total='';
    
    $sql_gethcp_id = "SELECT * FROM Customers where customer_id=".$customer_id;
 
  $result_gethcp_id = $conn->query($sql_gethcp_id);

    if ($result_gethcp_id->num_rows > 0){
        while ($value = $result_gethcp_id->fetch_assoc()){
              $customer_id_hcp = $value['hcp_id'];
            
    }
   
  }

?>
<style>
    .loader_msg{
            display:none;
            margin-top: 18%;
            margin-bottom: 18%;
    }
</style>


<div class="card">
  <div class="card-body mx-4">
  <div class="loader_msg"></div>
    <div class="container mt-5">
      <h3 class="text-center mb-4">Order Details</h3>
      <div class="row">
          <div class="mb-4" style="text-align:right;">
          <a href="my_order_backend.php"><button type="button" class="btn btn-primary"><i class="fa fa-chevron-circle-left"></i>Back</button></a>
         </div>
          
          
 
  <div class="col-md-4">
          
  <ul class="list-unstyled mb-5">
    <li class="text-muted ">
           Shipping Address
    </li>
        <hr> 
        <?php 
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
        ?>
          
          <li class="mt-4">
          <?php echo $customer_fname;?> <?php echo $customer_lname;?>
          </li>
          <li class="mt-3">
          <?php echo $customer_email;?>
          </li>
          <li class="mt-3">
          <?php echo $customer_phone;?>
          </li>
          <li class="mt-3 ">
           <?php echo $customer_address2;?>, <?php echo $customer_address1;?> <?php echo $customer_city;?> <?php echo $customer_state;?> <?php echo $customer_zip;?> <?php echo $customer_counrty;?>
          </li>
          
        <?php 
         }
    
        } 
        ?>
          
        </ul>
         '
         
       </div>
       
       
        <div class="col-md-4">
          
  <ul class="list-unstyled mb-5">
    <li class="text-muted ">
           Billing Address
    </li>
        <hr> 
        <?php 
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
        ?>
          
          <li class="mt-4">
          <?php echo $customer_fname;?> <?php echo $customer_lname;?>
          </li>
          <li class="mt-3">
          <?php echo $customer_email;?>
          </li>
          <li class="mt-3">
          <?php echo $customer_phone;?>
          </li>
          <li class="mt-3 ">
           <?php echo $customer_address2;?>, <?php echo $customer_address1;?> <?php echo $customer_city;?> <?php echo $customer_state;?> <?php echo $customer_zip;?> <?php echo $customer_counrty;?>
          </li>
          
        <?php 
         }
    
        } 
        ?>
          
        </ul>
         '
         
       </div>
          
     <div class="col-md-4">
         
        <ul class="list-unstyled">
        <li class="text-muted">
           Order
        </li>
        <hr> 
        <?php 
            
            $sql_order = "SELECT * FROM customer_order where order_id=".$order_id;
             
              $result_order = $conn->query($sql_order);
            
                if ($result_order->num_rows > 0){
                    while ($value = $result_order->fetch_assoc()){
                          $customer_id	= $value['customer_id'];
                          $order_id	= $value['order_id'];
                          $order_shipping_status	= $value['order_shipping_status'];
                          $order_created_date = $value['order_created_date'];
                           $product_sub_total	= $value['product_sub_total'];
          ?>    
          <li class="mt-4">
            <h3>Order Id #<?php echo $order_id;?></h3>
          </li>
          <li class="mt-3">
           <span>Order placed on </span><?php echo $order_created_date;?>
          </li>
        <?php 
         }
    
        } 
        ?>
        </ul>
      </div>
      
       
        
       
        
        <div class="col-md-8">
        <p class="text-muted">Product</p>
        </div>
        <div class="col-md-2">
          <p class="text-muted text-center">Quantity
          </p>
        </div>
         <div class="col-md-2">
          <p class="text-muted float-end">Total
          </p>
        </div>
        <hr>
        
    <?php 
      $sql_item = "SELECT * FROM customer_order_item where order_id=".$order_id;
 
      $result_item = $conn->query($sql_item);
    
        if ($result_item->num_rows > 0){
            while ($value = $result_item->fetch_assoc()){
                  $product_src	= $value['product_src'];
                  $product_title= $value['product_title'];
                  $product_price = $value['product_price'];
                  $product_qty = $value['product_qty'];
                  $product_total = $value['product_total'];
              
    ?>
        <div class="col-md-8">
            <div class="row mt-1 mb-4">
            <div class="col-2">
            <img class="CartItem__Image" class="img-fluid" style="width:100%; height:100%;"src="<?php echo $product_src;?>" alt="<?php echo $product_title;?>">
            </div>
            <div class="col-10 mt-4">
            <p><?php echo $product_title;?></p>
            <p class="text-muted"><?php echo $product_price;?></p>
            </div>
            </div>
        </div>
        <div class="col-md-2">
          <p class="text-muted text-center mt-4"><?php echo $product_qty;?></p>
        </div>
        <div class="col-md-2">
          <p class="text-muted float-end mt-4">$<?php echo $product_total;?></p>
        </div>
        
        <?php 
         }
    
        } 
        ?>
        
        <hr>
      </div>
      
      <div class="row ">

       
        <div class="col-md-12">
          <p class="text-muted float-end fw-bold">Subtotal: $<?php echo $product_sub_total;?>
          </p>
        </div>
        
      </div>
      <hr>
      <div class="row ">
          <div class="col-md-9">
            </div>
           <div class="col-md-2">
              <select id="shipping_status"  class="form-select" aria-label="Default select example">
                  <?php if($order_shipping_status == 'Shipped')
                  {
                  ?>
                  <option id="<?= $order_id;?>" value="Shipped" <?= 'selected' ?> ><?=$order_shipping_status?></option>
                  <?php
                  }else{
                      ?>
                  <option id="<?= $order_id;?>" value="Shipped"  >Ship</option>
                      <?php
                  }
                  if($order_shipping_status == 'Unshipped')
                  {
                  ?>
                  <option id="<?= $order_id;?>" value="Unshipped" <?= 'selected' ?> ><?=$order_shipping_status?></option>
                  <?php
                  }else{
                      ?>
                  <option id="<?= $order_id;?>" value="Unshipped"  >Unship</option>
                      <?php
                  }
                  ?>
                </select>
            </div>
            <div class="col-md-1">
                <button  type="button" onclick="shipunshipb()" class="btn btn-success shipunship">Update</button>
            </div>
        
        </div>
      <!--  <hr>-->
      <!--  <div class="row ">-->

       
      <!--  <div class="col-md-12 text-end">-->
      <!--    <button class="btn btn-primary" ><i class="fa fa-edit" aria-hidden="true"></i></button>-->
          
      <!--        <button class="btn btn-danger">-->
      <!--            <i class="fa fa-trash" aria-hidden="true">-->
                      
      <!--            </i>-->
      <!--      </button>-->
            
      <!--  </div>-->
       
        
      <!--</div>-->
      

    </div>
  </div>
</div>


<?php
require_once("../Customers/footer.php");


?>
<script src="script1/script_orders.js"></script>