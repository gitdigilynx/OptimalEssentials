<?php include('../../../Customers/header.php')?>

<div class="container-fluid mt-5">
    <h3 class="text-center mb-4">Recommendations</h3>
    <hr>
</div>

<div class="table-responsive col-10 m-auto">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php require_once("../../../inc/db_connect.php");
            $sql = "SELECT * FROM product_recommendation";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $count = 1;
                while ($value = $result->fetch_assoc()) {
                    
                    $type_name = $value['name'];
            ?>
                    <tr>
                        <th scope="row"><?= $count++ ?></th>
                        <td><?= $type_name ?></td>
                        <td>
                            <a href="maildashboard_ck.php?templete_id=<?=$value['id']?>&template_for=<?= str_replace("_", " ", "$type_name") ?>">
                                <button class="btn btn-primary"><i class="fa fa-edit" aria-hidden="true"></i></button>

                            </a>
                        </td>
                    </tr>
            <?php
                }
            }

            ?>


        </tbody>
    </table>
</div>

<?php include('../../../Customers/footer.php') ?>