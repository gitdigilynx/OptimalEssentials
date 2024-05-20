<?php
require_once("../../inc/db_connect.php");
require_once("../header.php");
$sql = "SELECT * FROM question_hard where type='0'";
$result = $conn->query($sql);
?>
<style>
    .table td {
        vertical-align: middle;
        text-align: center;
    }

    .table th {
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
    <h3 class="text-center mb-4">Questionnaire</h3>
    <div class="col-12 d-flex">
        <div class="col-5">

        </div>
        <div class="col-3 text-end" >
            <a href="recomendations/client_status_list.php">
                <button class="btn btn-primary">Questionnaire result contents</button>
            </a>
        </div>
        <div class="col-4 text-end" >
            <a href="recomendations/recomendation_list.php">
                <button class="btn btn-primary">Product recommendation contents</button>
            </a>
        </div>

    </div>
    <div id="msg_alert" class="m-2">

    </div>
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Question</th>
                    <th scope="col">Answers</th>
                    <th scope="col">Score</th>
                    <th scope="col">Product</th>
                    <th scope="col">Recommendation</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $count = 0;
                    $answer_count = 1;
                    while ($value = $result->fetch_assoc()) {
                        $count++;

                ?>
                        <form class="m-auto" id="update_form<?= $count ?>">
                            <tr>

                                <th scope="row"><?= $count ?></th>
                                <td class="col-4">

                                    <textarea form="update_form<?= $count ?>" class="form-control" rows="3" name="question"><?= $value['questions'] ?></textarea>
                                    <!--<form class="m-auto" id="update_form<?= $count ?>" action="update_question_answer.php?question_id=<?= $value['id'] ?>" method="post">-->

                                    <!--    <div class="">-->
                                    <!--        <button onclick="updatequestions()" class="btn btn-primary">Update</button>-->
                                    <!--    </div>-->
                                    <!--</form>-->
                                </td>

                                <?php
                                $sql_for_answer = "SELECT * FROM answers WHERE question_id=$value[id]";
                                $result_sql_for_answer = $conn->query($sql_for_answer);
                                ?>
                                <td class="">
                                    <?php
                                    if ($result_sql_for_answer->num_rows > 0) {

                                        while ($value_result_sql_for_answer = $result_sql_for_answer->fetch_assoc()) {
                                    ?>
                                            <textarea class="form-control form=" update_form<?= $count ?>" rows="1" name="answer_<?= $value_result_sql_for_answer['id'] ?>"><?= $value_result_sql_for_answer['answer'] ?></textarea>
                                            <hr>
                                    <?php
                                        }
                                    }
                                    ?>

                                </td>

                                <?php
                                $sql_for_score = "SELECT * FROM answers WHERE question_id=$value[id]";
                                $result_score = $conn->query($sql_for_score);
                                ?>

                                <td class="col-1">
                                    <?php
                                    if ($result_score->num_rows > 0) {

                                        while ($value_score = $result_score->fetch_assoc()) {
                                    ?>
                                            <textarea class="form-control form=" update_form<?= $count ?>" rows="1" name="score_<?= $value_score['id'] ?>"><?= $value_score['score'] ?></textarea>
                                            <hr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </td>

                                <?php
                                $sql_for_product = "SELECT * FROM answers WHERE question_id=$value[id]";
                                $result_product = $conn->query($sql_for_product);
                                ?>

                                <td class="col-2">
                                    <?php
                                    if ($result_product->num_rows > 0) {

                                        while ($value_product = $result_product->fetch_assoc()) {
                                    ?>


                                            <select class="selectpicker form=" update_form<?= $count ?>" id="product_<?= $value_product['id'] ?>" name="product_<?= $value_product['id'] ?>[]" aria-label="Products" multiple>
                                                <option value="">Select Product</option>
                                                <?php
                                                $sql_product_table = "SELECT * FROM Products";
                                                $result_product_table = $conn->query($sql_product_table);
                                                if ($result_product_table->num_rows > 0) {

                                                    while ($value_product_table = $result_product_table->fetch_assoc()) {

                                                ?>

                                                        <option value="<?= $value_product_table['product_id'] ?>"" 
                                            <?php
                                                        $str_of_p =  $value_product['product'];
                                                        $producd_id_exp = explode(",", $str_of_p);
                                                        // var_dump($producd_id_exp);
                                                        // $prodct_array_val = $value_product['product'];
                                                        foreach ($producd_id_exp as $producd_id_exp_2) {
                                                            if ($producd_id_exp_2 == $value_product_table['product_id']) {
                                                                echo 'selected="selected"';
                                                            }
                                                        }
                                            ?> >
                                            <?= $value_product_table['title'] ?> 
                                            </option>
                                    
                                          <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    <hr>
                            <?php
                                        }
                                    }
                            ?>
                         </td>
                        <?php
                        $sql_for_recommendation = "SELECT * FROM answers WHERE question_id=$value[id]";
                        $result_recommendation = $conn->query($sql_for_recommendation);
                        ?>
                        
                         <td class="">
                         <?php
                            if ($result_recommendation->num_rows > 0) {

                                while ($value_recommendation = $result_recommendation->fetch_assoc()) {
                            ?>
                              
                                        
                                        <select class=" selectpicker form="update_form<?= $count ?>" name="recommendation_<?= $value_recommendation['id'] ?>[]" aria-label="Recomendation" multiple>
                                                        <option value="">Select Recomendation</option>
                                                        <?php
                                                        $sql_recomendation_table = "SELECT * FROM product_recommendation ORDER BY id DESC";
                                                        $result_recommendation_table = $conn->query($sql_recomendation_table);
                                                        if ($result_recommendation_table->num_rows > 0) {

                                                            while ($value_recommendation_table = $result_recommendation_table->fetch_assoc()) {

                                                        ?>

                                                                <option value="<?= $value_recommendation_table['id'] ?>"" 
                                            <?php

                                                                $str_of_reco =  $value_recommendation['recommendation_id'];
                                                                $recommendation_id_exp = explode(",", $str_of_reco);
                                                                foreach ($recommendation_id_exp as $recommendation_id_exp_2) {
                                                                    if ($recommendation_id_exp_2 == $value_recommendation_table['id']) {
                                                                        echo 'selected="selected"';
                                                                    }
                                                                }
                                            ?> >
                                            <?= $value_recommendation_table['name'] ?> 
                                            </option>
                                    
                                          <?php
                                                            }
                                                        }
                                            ?>
                                        </select>
                                    <hr>
                            <?php
                                }
                            }
                            ?>
                         </td>
                         <td class=" col-1">
                                                                    <?php
                                                                    $form_name = 'update_form';
                                                                    $form_name .= $count;

                                                                    ?>
                                                                    <button onclick="updatequestions('<?php echo $form_name ?>','<?php echo $value['id'] ?>')" class="btn btn-primary" title="Update"><i class="fa fa-edit" aria-hidden="true"></i></button>
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
    <div class="text-center ">
        <h1 class="text-decoration-underline">Questionnaire</h1>
        <h3>Dynamic Section</h3>
    </div>
    <div id="dynamic-div">
        <div class="m-3" align="right">
            <a href="question_answer.php"><button class="btn btn-primary" title="Add Questionnaire"><i class="fa fa-plus" aria-hidden="true"></i></button></a>
        </div>
        <div>

            <?php
            include('dymaic_question.php');

            ?>


        </div>

    </div>
</div>
<hr>

<?php require_once("../footer.php") ?>;