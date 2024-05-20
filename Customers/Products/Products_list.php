<?php
require_once("../../inc/db_connect.php");
require_once("../header.php");
$sql = "SELECT * FROM Products";
$result = $conn->query($sql);
?>
<style>
    .table .action_td{
        vertical-align: middle;
        text-align: center;
    }
    .table th{
        vertical-align: middle;
          text-align: center;
    }
   .content {
      width: 500px !important;
      height: 500px !important;
      border: 1px solid blue !important;
    }
    
    textarea {
      width: 100% !important;
      height: calc(100% - 45px) !important;
      box-sizing: border-box !important;
    }
    
</style>
<div class="container-fluid mt-5">
  <h3 class="text-center mb-4" >Products</h3>
    <div id="msg_alert" class="m-2" >
        
    </div>
    <hr>
   <div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Product Name</th>
                <th scope="col">4 Weeks Quantity</th>
                <th scope="col">8 Weeks Quantity</th>
                <th scope="col">12 Weeks Quantity</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
             $count = 0;
                while ($value = $result->fetch_assoc()) {
                    $count++;

            ?>
             <form class="m-auto" id="update_form<?= $count ?>" >
                    <tr>
                       
                        <th scope="row"><?= $count ?></th>
                        <td class="col-4">
                            <?= $value['title'] ?>
                                    <textarea form="update_form<?= $count ?>" class="form-control" rows="3" name="title" id="title" style="display:none;"><?= $value['title'] ?></textarea>
                        </td>
                        
                        <td class="col-2">
                                    <input type="number" form="update_form<?= $count ?>" class="form-control" name="4_weeks" id="4_weeks" value = "<?= $value['4_weeks'] ?>">
                        </td>
                        
                        <td class="col-2">
                                    <input type="number" form="update_form<?= $count ?>" class="form-control" name="8_weeks" id="8_weeks" value = "<?= $value['8_weeks'] ?>">
                        </td>
                        
                        <td class="col-2">
                                    <input type="number" form="update_form<?= $count ?>" class="form-control" name="12_weeks" id="12_weeks" value = "<?= $value['12_weeks'] ?>">
                        </td>
                
                         <td class="col-1 action_td">
                        <?php 
                         $form_name = 'update_form';
                         $form_name .=$count;
                         $productid = $value['product_id'];
                        ?>
                        <button onclick="updateProducts('<?php echo $form_name ?>','<?= $productid  ?>')" class="btn btn-primary" title="Update" ><i class="fa fa-edit" aria-hidden="true"></i></button>
                         </td>
                    </tr>
                </form>
            <?php
                }
            }
            ?>
         
        </tbody>
    </table>
      
</div>

</div>
  <hr>

<?php require_once("../footer.php") ?>;