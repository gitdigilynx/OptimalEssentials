<?php 

include('../../../Customers/header.php');

require_once("../../../inc/db_connect.php");

$id = '';
$name = '';
$details = '';
$buttonText = 'Save';

if (count($_GET) > 0) {
    $recommendation_id = $_GET['recommendation_id'];
     $sql = "SELECT * FROM product_recommendation where id=$recommendation_id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $value = $result->fetch_assoc();
                $id = $value['id'];
                $name = $value['name'];
                $details = $value['product_benefits'];
                $buttonText = 'Update';
            }
}else{
    
}



                


?>

<div class="container-fluid mt-5">
    <h3 class="text-center mb-4">Recommendation</h3>
    <div class="mb-2" style="text-align:right;">
    <a href="recomendation_list.php"><button type="button" class="btn btn-primary"><i class="fa fa-chevron-circle-left"></i> Back</button></a>
</div>
    <hr>
</div>

<div class="w-75 m-auto">

    <div id="emailbodydiv">
        <form id="save_recommendation">
            <div class="mb-3">
                <label for="Name" class="form-label">Name</label>
                <input type="text" value="<?=$name?>" class="form-control" name="Name" id="Name">
            </div>
            <div class="mb-3">
                <label for="Detail" class="form-label">Detail</label>
                <textarea style="height:200px;" class="form-control" name="Detail" id="Detail"><?=$details?></textarea>
            </div>
            <div class="mb-3">
                <input id="recommednation_id" name="recommednation_id" value="<?=$id?>" type="text" hidden>
               
            </div>
            <div class="mb-3 text-center">
                <button onclick="saveFormdata()" type="submit" class="w-100 btn btn-primary btn_submit"><?=$buttonText?> <i class="fa fa-chevron-circle-right"></i></button>
            </div>

        </form>
    </div>
</div>

<!-- ajax link -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>


     
   // post form
    function saveFormdata() {
        $('#save_recommendation').on('submit', function(e) {
            if($('#Name').val() === ''){
                e.preventDefault();
                 Swal.fire({
                       
                        icon: 'warning',
                        title: 'Please Enter Name',
                        showConfirmButton: false,
                        timer: 1000
                    });
            }else if($('#Detail').val() === ''){
                    e.preventDefault();
                      Swal.fire({
                           
                            icon: 'warning',
                            title: 'Please Enter detail',
                            showConfirmButton: false,
                            timer: 1000
                        });
            }else{
                
            
            $('.btn_submit').prop('disabled', true);
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'save_updated_recommendation.php',
                data: $('#save_recommendation').serialize(),
                success: function(response) {
                    response = $.parseJSON(response);
                    if(response[0] === 'success'){
                     
                     Swal.fire({
                       
                        icon: 'success',
                        title: response[1],
                        showConfirmButton: false,
                        timer: 1000
                    });
                    
                    
                    // redirect
                    setTimeout(function() { 
     
                        location.href = "recomendation_list.php";
                    }, 500);
                        
                    }else{
                        $('.btn_submit').prop('disabled', true);
                        Swal.fire({
                       
                        icon: 'error',
                        title: 'Failed to create/update record. Please try again',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    }
                    
                }
            });
            }
        });
    }
</script>
</body>

</html>