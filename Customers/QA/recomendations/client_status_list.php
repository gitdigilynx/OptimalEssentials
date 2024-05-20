<?php include('../../../Customers/header.php') ?>

<div class="container-fluid mt-5">
    <h3 class="text-center mb-4">Client Status</h3>
    <div class="col-12 d-flex">
      <div  class="col-11">
          
      </div>
      
      <div class="ms-2">
       <a href="../question_answer_list.php">   
        <button class="btn btn-primary">
            <i class="fa fa-chevron-circle-left"></i>
            Back
        </button>
      </a>
      </div>
     
  </div>
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
            $sql = "SELECT * FROM client_status";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $count = 1;
                while ($value = $result->fetch_assoc()) {

                    $id = $value['id'];
                    $status = $value['status'];
                    $product_ids = $value['product_ids'];
                    $template = $value['template'];
            ?>
                    <tr class="tr_class_<?= $id ?>">
                        <th scope="row"><?= $count++ ?></th>
                        <td><?= $status ?></td>
                        <td>
                            <a href="edit_client_status.php?id=<?= $id ?>&template_for=<?=$status?>">
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
<script>
    $(document).ready(function() {

        $(document).on('click', '.delete_button', function() {
            var id_value = this.id;
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'GET',
                        url: 'delete_recommendation.php',
                        data: {
                            recommendation_id: id_value
                        },
                        success: function(response) {
                            if (response === 'success') {

                                $('.tr_class_' + id_value).fadeOut(1000);
                                setTimeout(function() {
                                    $('.tr_class_' + id_value).remove();
                                }, 1100);

                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                );

                            } else {
                                Swal.fire({

                                    title: 'failed to delete',
                                    showConfirmButton: true
                                });
                            }

                        }

                    });
                }
            });
        });

    });
</script>