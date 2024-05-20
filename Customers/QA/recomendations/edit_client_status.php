<?php
require_once("../../../inc/db_connect.php");
include('../../../Customers/header.php');
$templete_id = $_GET['id'];
$template_for = $_GET['template_for'];

// variables 
$status = '';
$status = '';


$sql = "SELECT * FROM client_status WHERE id=$templete_id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $status =  $row['status'];
    $product_ids =  $row['product_ids'];
    $template =  $row['template'];
}
?>

<div class="container-fluid mt-5">
    <h3 class="text-center mb-4">For: <?= $template_for ?></h3>
    <div class="mb-2" style="text-align:right;">
        <a href="client_status_list.php"><button type="button" class="btn btn-primary"><i class="fa fa-chevron-circle-left"></i> Back</button></a>
    </div>
    <hr>
</div>

<div class="w-75 m-auto">

    <div id="emailbodydiv">
        <form id="client_status_form" action="save_ckemail_temp.php" method="POST">
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <input type="text" class="form-control" value="<?= $status ?>" name="status" id="status" readonly>
            </div>
            <div class="mb-3 ">
                <label for="subject_ck" class="form-label">Products</label>
                <select class="selectpicker select_multiple_products form-control" name="product_ids[]" multiple>
                    <option value="">Select Product</option>
                    <?php
                    $sql_product_table = "SELECT * FROM Products";
                    $result_product_table = $conn->query($sql_product_table);
                    if ($result_product_table->num_rows > 0) {

                        while ($value_product_table = $result_product_table->fetch_assoc()) {

                    ?>

                            <option value="<?= $value_product_table['product_id'] ?>" <?php
                                                                                        $str_of_p =  $product_ids;
                                                                                        $producd_id_exp = explode(",", $str_of_p);
                                                                                        // var_dump($producd_id_exp);
                                                                                        // $prodct_array_val = $value_product['product'];
                                                                                        foreach ($producd_id_exp as $producd_id_exp_2) {
                                                                                            if ($producd_id_exp_2 == $value_product_table['product_id']) {
                                                                                                echo 'selected="selected"';
                                                                                            }
                                                                                        }
                                                                                        ?>>
                                <?= $value_product_table['title'] ?>
                            </option>

                    <?php
                        }
                    }
                    ?>


                </select>
            </div>
            <div class=" mb-3">
                <label for="Artical_Editor" class="form-label">Email Template</label>
                <textarea name="ArticalContent" id="Artical_Editor"><?= $template ?></textarea>
            </div>
            <div class="mb-3">
                <input id="status_id" name="status_id" value="<?= $templete_id ?>" type="text" hidden>

            </div>
            <div class="mb-3 text-center">
                <button onclick="saveFormdata()" type="submit" class="w-100 btn btn-primary">Update <i class="fa fa-chevron-circle-right"></i></button>
            </div>

        </form>
    </div>
</div>
<?php include('../../../Customers/footer.php'); ?>
<script src="../../../send_mail/ck_editor/ckeditor/ckeditor.js"></script>
<!-- ajax link -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<script>
    // get data on load start
    var templete_id = <?= $templete_id ?>;

    $(document).ready(function() {
        // $('#emailbodydiv').css("display", "none");
        // get the data on cahge
        CKEDITOR.replace('Artical_Editor');
    });
    // post form
    function saveFormdata() {
        $('#client_status_form').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'save_client_status.php',
                data: $('#client_status_form').serialize(),
                success: function(response) {
                    console.log(response);
                    Swal.fire({

                        icon: 'success',
                        title: response,
                        showConfirmButton: false,
                        timer: 1500
                    });

                    // redirect
                    setTimeout(function() {

                        // location.href = "/optimalessentials/send_mail/ck_editor/mail_temp_view.php";
                    }, 2000);

                }
            });
        });
    }
</script>
</body>

</html>