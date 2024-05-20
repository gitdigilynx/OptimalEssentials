<?php

require_once("../Customers/header.php");
require_once("../inc/db_connect.php");
require_once("../inc/functions.php");
require_once("../inc/store_credential.php");

$order_id = $_GET['order_id'];
$customer_id = $_GET['customer_id'];
$product_sub_total = '';
$cound_id = 1;
$sql_gethcp_id = "SELECT * FROM Customers where customer_id=" . $customer_id;

$result_gethcp_id = $conn->query($sql_gethcp_id);

if ($result_gethcp_id->num_rows > 0) {
    while ($value = $result_gethcp_id->fetch_assoc()) {
        $customer_id_hcp = $value['hcp_id'];
    }
}

?>
<style>
    .order_inputf {
        display: none;
    }

    .form-select {
        padding: 1.2rem 2.25rem .375rem .75rem
    }

    .form-control {
        padding: 0.75rem 0.75rem;
    }

    .loader_msg {
        display: none;
        margin-top: 18%;
        margin-bottom: 18%;
    }

    .text_design {
        margin-top: -0.8%;
        position: absolute;
        background: white;
        margin-left: 1%;
        color: #5c6064;
    }

    .width_select {

        width: 67%;
        height: 113%;
    }

</style>


<div class="card">
    <div class="card-body mx-4">
        <div class="loader_msg"></div>
        <div class="container mt-5">
            <h3 class="text-center mb-4">Eidt Order</h3>
            <div class="row">
                <div class="mb-4" style="text-align:right;">
                    <a href="my_order_backend.php"><button type="button" class="btn btn-primary"><i class="fa fa-chevron-circle-left"></i>Back</button></a>
                </div>



                <div class="col-md-6">

                    <ul class="list-unstyled mb-5">
                        <li class="text-muted ">
                            Shipping Address
                        </li>
                        <hr>
                        <?php
                        $sql_address = "SELECT * FROM cutomer_address where customer_id=" . $customer_id;

                        $result_address = $conn->query($sql_address);

                        if ($result_address->num_rows > 0) {
                            while ($value = $result_address->fetch_assoc()) {
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
                                $customer_province = $value['customer_state'];
                                $customer_counrty = $value['customer_counrty'];
                        ?>

                                <form id="address_info_form" name="address_info_form">
                                    <li class="mt-4">
                                        <div class="form-row ">
                                            <div class="form-group mt-3">
                                                <label class="text_design" for="inputEmail4">First Name</label>
                                                <input type="text" class="form-control" value="<?= $customer_id ?>" id="Customer_Id" name="Customer_Id" placeholder="Customer_Id" hidden>
                                                <input type="text" class="form-control" value="<?= $customer_fname ?>" id="First_Name" name="First_Name" placeholder="First Name">
                                            </div>
                                            <div class="form-group  mt-4">
                                                <label class="text_design" for="inputPassword4">Last Name</label>
                                                <input type="text" class="form-control" value="<?= $customer_lname ?>" id="Last_Name" name="Last_Name" placeholder="Last Name">
                                            </div>
                                        </div>
                                        <div class="form-group mt-4">
                                            <label class="text_design" for="inputPassword4">Address</label>
                                            <input type="text" class="form-control" value="<?= $customer_address1 ?>" id="Address" name="Address" placeholder="Address">
                                        </div>
                                        <div class="form-group  mt-4">
                                            <label class="text_design" for="inputPassword4">Apartment, suite, etc. (optional)</label>
                                            <input type="text" class="form-control" value="<?= $customer_address2 ?>" id="Address2" name="Address2" placeholder="Apartment, suite, etc. (optional)">
                                        </div>
                                        <div class="form-group  mt-4">
                                            <label class="text_design" for="inputPassword4">City</label>
                                            <input type="text" class="form-control" value="<?= $customer_city ?>" id="City" name="City" placeholder="City">
                                        </div>
                                        <div class="form-group  mt-4">
                                            <label class="text_design" for="inputPassword4">State</label>
                                            <select name="State" class="form-select">

                                                <option value="0" disabled="">State/territory</option>
                                                <?php if ($customer_province == 'Australian Capital Territory') {
                                                ?>
                                                    <option value="ACT,Australian Capital Territory" selected>Australian Capital Territory </option>
                                                <?php
                                                } else {
                                                ?>
                                                    <option value="ACT,Australian Capital Territory">Australian Capital Territory </option>
                                                <?php

                                                }
                                                if ($customer_province == 'New South Wales') { ?>
                                                    <option value="NSW,New South Wales" selected>New South Wales</option>
                                                <?php
                                                } else {
                                                ?><option value="NSW,New South Wales">New South Wales</option>
                                                <?php

                                                }
                                                if ($customer_province == 'Northern Territory') {
                                                ?>
                                                    <option value="NT,Northern Territory" selected>Northern Territory</option>
                                                <?php
                                                } else {
                                                ?>
                                                    <option value="NT,Northern Territory">Northern Territory</option>
                                                <?php
                                                }
                                                if ($customer_province == 'Queensland') {
                                                ?>
                                                    <option value="QLD,Queensland" selected>Queensland</option>
                                                <?php
                                                } else {
                                                ?>
                                                    <option value="QLD,Queensland">Queensland</option>
                                                <?php
                                                }
                                                if ($customer_province == 'South Australia') {
                                                ?>
                                                    <option value="SA,South Australia" selected>South Australia</option>
                                                <?php
                                                } else {
                                                ?>
                                                    <option value="SA,South Australia">South Australia</option>
                                                <?php
                                                }
                                                if ($customer_province == 'Tasmania') {
                                                ?>
                                                    <option value="TAS,Tasmania" selected>Tasmania</option>
                                                <?php
                                                } else {
                                                ?>
                                                    <option value="TAS,Tasmania">Tasmania</option>
                                                <?php
                                                }

                                                if ($customer_province == 'Victoria') {
                                                ?>
                                                    <option value="VIC,Victoria" selected>Victoria</option>
                                                <?php
                                                } else {
                                                ?>
                                                    <option value="VIC,Victoria">Victoria</option>
                                                <?php
                                                }
                                                if ($customer_province == 'Western Australia') {
                                                ?>
                                                    <option value="WA,Western Australia" selected>Western Australia</option>
                                                <?php
                                                } else {
                                                ?>
                                                    <option value="WA,Western Australia">Western Australia</option>
                                                <?php

                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group  mt-4">
                                            <label class="text_design" for="inputPassword4">Zip</label>
                                            <input type="text" class="form-control" value="<?= $customer_zip ?>" id="Zip_Code" name="Zip_Code" placeholder="Last Name">
                                        </div>
                                        <div class="form-group  mt-4">
                                            <label class="text_design" for="inputPassword4">Country</label>
                                            <input type="text" class="form-control" value="<?= $customer_counrty ?>" id="Country" name="Country" placeholder="Country">
                                        </div>
                                        <div class="form-group  mt-4">
                                            <label class="text_design" for="inputPassword4">Phone</label>
                                            <input type="text" class="form-control" value="<?= $customer_phone ?>" id="Phone_No" name="Phone_No" placeholder="Phone Number">
                                        </div>
                                        <div class="form-group  mt-4">
                                            <label class="text_design" for="inputPassword4">Email</label>
                                            <input type="text" class="form-control" value="<?= $customer_email ?>" id="Email" name="Email" placeholder="Email">
                                        </div>



                                <?php
                            }
                        }
                                ?>

                    </ul>
                    </form>

                </div>




                <div class="col-md-6">

                    <ul class="list-unstyled">
                        <li class="text-muted">
                            Order
                        </li>
                        <hr>
                        <?php

                        $sql_order = "SELECT * FROM customer_order where order_id=" . $order_id;

                        $result_order = $conn->query($sql_order);

                        if ($result_order->num_rows > 0) {
                            while ($value = $result_order->fetch_assoc()) {
                                $customer_id    = $value['customer_id'];
                                $order_id    = $value['order_id'];
                                $order_shipping_status    = $value['order_shipping_status'];
                                $order_created_date = $value['order_created_date'];
                                $order_recurring = $value['order_recurring'];
                                $product_sub_total    = $value['product_sub_total'];
                        ?>
                                <li class="mt-4">
                                    <h3>Order Id #<?php echo $order_id; ?></h3>
                                </li>
                                <li class="mt-3">
                                    <span>Order placed on </span><?php echo $order_created_date; ?>
                                </li>
                                <li class="mt-4">
                                    <h3>Recurring order</h3>
                                </li>
                                <li class="mt-3">
                                    <div class="w-100">
                                        <label class="text_design">Recurring order for every</label>
                                        <select class="form-select recurring_week" name="recurring_week">
                                            <?php
                                            $recuring_value = 0;
                                            for ($i = 0; $i < 3; $i++) {
                                                $recuring_value += 4;
                                                if ($order_recurring == $recuring_value) {
                                            ?>
                                                    <option value="<?= $recuring_value ?>" <?= 'selected' ?>><?= $recuring_value ?> week</option>
                                                <?php
                                                } else {
                                                ?>
                                                    <option value="<?= $recuring_value ?>"><?= $recuring_value ?> week</option>
                                            <?php
                                                } {
                                                }
                                            }

                                            ?>

                                        </select>
                                    </div>
                                </li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                </div>



                <div class="text-center mb-4">
                    <h1> Add Product </h1>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <p class="text-muted">Product</p>
                    </div>
                    <div class="col-md-4   varient_div">
                        <p class="text-muted">Varient
                        </p>
                    </div>
                    <div class="col-md-2  text-center">
                        <p class="text-muted">Quantity
                        </p>
                    </div>
                    

                    <div class="col-md-2">
                        <p class="text-muted float-end">Action
                        </p>
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-md-4">
                        <label class="text_design">Select Product</label>
                        <select class="form-select width_select dropdown_list_p" name="select_product">
                            <option value="0">Select Product</option>
                            <?php
                            $sql_product = "SELECT * FROM Products";
                            $result_product = $conn->query($sql_product);
                            if ($result_product->num_rows > 0) {
                                while ($row_product = $result_product->fetch_assoc()) {
                            ?>
                                    <option value="<?= $row_product['product_id'] ?>"><?= $row_product['title'] ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>

                    </div>
                    <div class="col-md-4 ">

                          <label class="text_design">Select Vareint</label>
                        <select class="form-select width_select dropdown_list_v" name="select_vareint">
                            <option value="0">Select Vareint</option>
                            
                        </select>
                    </div>
                    <div class="col-md-2 text-center varient_div" >

                        <div>
                            <input type="button" id="a_p_q" value="-" class="button-minus border rounded-circle  icon-shape icon-sm mx-1 " data-field="quantity">
                            <input type="text" id="qty_a_p_q" class="quantity-field border-0 text-center w-25 " value="1"  placeholder="Product Qty" readonly>
                            <input type="button" id="a_p_q" value="+" class="button-plus border rounded-circle icon-shape icon-sm lh-0" data-field="quantity">
                        </div>
                    </div>
                    <div class="col-md-2 float-end">
                        <button class="btn btn-primary float-end" onclick="add_prdoduct_from_shpify()">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </button>
                    </div>

                </div>
            </div>


            <div class="text-center mt-5 mb-5">
                <h1> Line Item </h1>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <p class="text-muted">Product</p>
                </div>
                <div class="col-md-2">
                    <p class="text-muted text-center">Quantity
                    </p>
                </div>
                <div class="col-md-1">
                    <p class="text-muted text-center">Total
                    </p>
                </div>
                <div class="col-md-1">
                    <p class="text-muted float-end">Action
                    </p>
                </div>
            </div>
            <hr>
    <form id="order_item_submit" name="order_item_form"  >
        <input type="text" class="order_inputf recurring_week_input" value="" id="recurring_week_input" name="recurring_week_input" placeholder="recurring_week_input">
        <input type="text" class="order_inputf order_id" value="<?=$order_id?>" id="order_id" name="order_id" placeholder="order_id">
            <?php
            $sql_item = "SELECT * FROM customer_order_item where order_id=" . $order_id;

            $result_item = $conn->query($sql_item);

            if ($result_item->num_rows > 0) {
                while ($value = $result_item->fetch_assoc()) {

                    $product_id = $value['product_id'];
                    $variant_id = $value['variant_id'];
                    $product_src    = $value['product_src'];
                    $product_title = $value['product_title'];
                    $product_price = $value['product_price'];
                    $product_qty = $value['product_qty'];
                    $product_total = $value['product_total'];

            ?>
                    <div class="row" id="row_<?= $cound_id ?>">

                        <div class="col-md-8">
                            <div class="row mt-1 mb-4">
                                <div class="col-2">
                                    <img class="CartItem__Image" class="img-fluid" style="width:100%; height:100%;" src="<?php echo $product_src; ?>" alt="<?php echo $product_title; ?>">
                                    <input type="text" class="order_inputf" value="<?= $product_src ?>" name="product_img[<?= $cound_id ?>]" placeholder="product_img_url">
                                    <input type="text" class="order_inputf product_id_c" value="<?= $product_id ?>" name="product_id[<?= $cound_id ?>]" placeholder="product_id">
                                    <input type="text" class="order_inputf varient_id_c" value="<?= $variant_id ?>" name="variant_id[<?= $cound_id ?>]" placeholder="varient_id">
                                </div>
                                <div class="col-10 mt-4">
                                    <p><?php echo $product_title; ?></p>
                                    <input type="text" class="order_inputf" value="<?= $product_title ?>" name="product_title[<?= $cound_id ?>]" placeholder="Product title">

                                    <p class="text-muted">$<?php echo $product_price; ?></p>
                                    <input type="text" class="order_inputf prodtct_p_<?= $cound_id ?>" value="<?= $product_price ?>" name="product_price[<?= $cound_id ?>]" placeholder="Product Price">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 text-center mt-4">
                            <input type="button" id="<?= $cound_id ?>" value="-" class="button-minus border rounded-circle  icon-shape icon-sm mx-1 " data-field="quantity">
                            <input type="text" id="qty_<?= $cound_id ?>" class="quantity-field border-0 text-center w-25 " value="<?= $product_qty ?>" name="quantity[<?= $cound_id ?>]" placeholder="Product Qty" readonly>
                            <input type="button" id="<?= $cound_id ?>" value="+" class="button-plus border rounded-circle icon-shape icon-sm lh-0" data-field="quantity">
                        </div>
                        <div class="col-md-1">
                            <p class="text-muted text-center mt-4 prodtct_total_text_<?= $cound_id ?>">$<?php echo $product_total; ?></p>
                            <input type="text" class="total_find order_inputf prodtct_total_val_<?= $cound_id ?>" value="<?= $product_total ?>" name="total_price[<?= $cound_id ?>]" placeholder="Product title">

                        </div>
                        <div class="col-md-1">
                            <button id="<?= $cound_id ?>" class="btn btn-danger float-end mt-4 delete_item_order">
                                <i class="fa fa-trash" aria-hidden="true">
                                </i>
                            </button>
                        </div>
                    </div>

            <?php

                    $cound_id++;
                }
            }
            ?>

            <hr>
            <div class="row ">


                <div class="col-md-12">
                    <input type="text" class="order_inputf coun_value" value="<?= $cound_id - 1 ?>" name="coun_value" placeholder="count">
                    <p class="text-muted float-end fw-bold sub_total_text">Subtotal: $<?php echo $product_sub_total; ?>
                    </p>
                    <input type="text" class="order_inputf sub_total_val" value="<?= $product_sub_total ?>" name="sub_total" placeholder="Product sub total">
                </div>

            </div>
            <hr>
            <div class="row ">


                <div class="text-center">
                    <button type="button" class="btn btn-success order_submit">Update</button>
                </div>

            </div>
        </form>
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