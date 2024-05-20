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
            
            <div class="row">
                <div class="" style="text-align:right;">
                    <a href="/optimalessentials/Customers/customer_list.php"><button type="button" class="btn btn-primary"><i class="fa fa-chevron-circle-left"></i>Back</button></a>
                </div>
                <h3 class="text-center mb-4">Add Nutritionists</h3>



                <div class="col-md-12 w-50 m-auto">

                    <ul class="list-unstyled">
                        <li class="text-muted text-center">
                            Please fill in the information below:
                        </li>
                        <form id="add_nutritionists" name="add_nutritionists"action="https://app.optimalessentials.com.au/optimalessentials/shopifyapp_ajax_call/save_hcp_staff.php" method="POST">
                                    <li class="mt-4">
                                        <div class="form-row ">
                                            <div class="form-group mt-3">
                                                <label class="text_design" for="First_Name">First Name</label>
                                                <input type="text" class="form-control"  id="Customer_Id" name="Customer_Id" placeholder="Customer_Id" hidden>
                                                <input type="text" class="form-control" value="" id="First_Name" name="customer[first_name]" placeholder="First Name" required>
                                            </div>
                                            <div class="form-group  mt-4">
                                                <label class="text_design" for="Last_Name">Last Name</label>
                                                <input type="text" class="form-control" value="" id="Last_Name" name="customer[last_name]" placeholder="Last Name" required>
                                            </div>
                                        </div>
                                        <div class="form-group mt-4">
                                            <label class="text_design" for="email">Email</label>
                                            <input type="email" class="form-control" value="" id="email" name="customer[email]" placeholder="Email" required>
                                        </div>
                                        <div class="form-group mt-4" style="display:none;">
                                            <label class="text_design" for="tags">tags</label>
                                            <input type="text" class="form-control" value="Nutritionists" id="tags" name="customer[tags]" placeholder="tags" >
                                        </div>
                                        <div class="form-group  mt-4">
                                            <label class="text_design" for="Password">Password</label>
                                            <input type="password" class="form-control" value="" id="Password" name="customer[password]" minlength="5" placeholder="Password" required>
                                        </div>
                                        <div class="form-group mt-4 w-100">
                                            <button class="btn btn-primary w-100" >Add Nutritionists</button>
                                        </div>
                                       
                        
                                </form>

                    </ul>
                    

                </div>
    </div>
</div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="../Customers/script/script.js"></script>
