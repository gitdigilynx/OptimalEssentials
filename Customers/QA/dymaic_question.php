<?php

$sql = "SELECT * FROM question_hard WHERE type='1'";
$result = $conn->query($sql);
?>

<div class="table-responsive">
<div id="msg_alert2" class="m-2">

</div>
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
                $count_dynamic = 1;
                while ($value = $result->fetch_assoc()) {
                    $count++;

            ?>
                    <form class="m-auto" id="update_form<?= $count ?>">
                        <tr id="tr_update_form<?= $count ?>">

                            <th scope="row"><?= $count_dynamic++ ?></th>
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

                            <td class="">
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


                                         <select class="selectpicker form="update_form<?= $count ?>" name="product_<?= $value_product['id'] ?>[]"  aria-label="Products" multiple>
                                            <option value="">Select Product</option>
                                        <?php 
                                        $sql_product_table = "SELECT * FROM Products";
                                        $result_product_table = $conn->query($sql_product_table);
                                        if ($result_product_table->num_rows > 0) {
                                
                                            while ($value_product_table = $result_product_table->fetch_assoc()) {
                                                
                                        ?>
                                        
                                            <option value="<?= $value_product_table['product_id'] ?>"" 
                                            <?php
                                            $str_of_p =  $value_product['product'];  // get data from database 
                                            $producd_id_exp = explode(",",$str_of_p); // seperate data
                                            foreach($producd_id_exp as $producd_id_exp_2)
                                            {
                                                if ($producd_id_exp_2 == $value_product_table['product_id']){
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
                              
                                        
                                        <select class="selectpicker form="update_form<?= $count ?>" name="recommendation_<?= $value_recommendation['id'] ?>[]"  aria-label="Recomendation" multiple>
                                            <option value="">Select Recomendation</option>
                                        <?php 
                                        $sql_recomendation_table = "SELECT * FROM product_recommendation";
                                        $result_recommendation_table = $conn->query($sql_recomendation_table);
                                        if ($result_recommendation_table->num_rows > 0) {
                                
                                            while ($value_recommendation_table = $result_recommendation_table->fetch_assoc()) {
                                                
                                        ?>
                                        
                                            <option value="<?= $value_recommendation_table['id'] ?>"" 
                                            <?php
                                                  $str_of_reco =  $value_recommendation['recommendation_id'];
                                            $recommendation_id_exp = explode(",",$str_of_reco);
                                            foreach($recommendation_id_exp as $recommendation_id_exp_2)
                                            {
                                                if ($recommendation_id_exp_2 == $value_recommendation_table['id']){
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
                         <td class="col-1">
                                                        <?php
                                                        $form_name = 'update_form';
                                                        $form_name .= $count;

                                                        ?>
                                                        <button onclick="updatequestions('<?php echo $form_name ?>','<?php echo $value['id'] ?>')" class="btn btn-sm btn-primary" title="Update" ><i class="fa fa-edit" aria-hidden="true"></i></button>
                                                        <button onclick="deletequestions('<?php echo $form_name ?>','<?php echo $value['id'] ?>')" class="btn btn-sm btn-danger" title="Delete" ><i class="fa fa-trash" aria-hidden="true"></i></button>

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