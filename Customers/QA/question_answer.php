<?php
require_once("../../inc/db_connect.php");
require_once("../header.php");
$sql = "SELECT * FROM question_type";
$result = $conn->query($sql);
?>


<div id="question_asnwer_div" class="col-5 m-auto">
    <div class="mt-1 d-flex justify-content-between ">

        <a href="question_answer_list.php"><button class="btn btn-primary">Back</button></a>
        <a onclick="newinput()" class="btn btn-primary">Add Answer</a>
    </div>
    <form action="save_dynamic_question.php" method="POST">
       
           
            <!--<div align="right" class="mt-1">-->

            <!--    <a onclick="newinput()" class="btn btn-primary">Add Answer</a>-->

            <!--</div>-->
            <div class="mb-3">
                <label for="question-input" class="form-label">Question</label>
                <input type="text" name="question-input" class="form-control" id="question-input" aria-describedby="emailHelp" required>

            </div>
            <div id="section_1">
                <h2 class="text-center" >Option 1</h2>
                <div id="answer-input-div-1" class="mb-3">
                    <label for="answer-input" class="form-label">Answer</label>
                    <input type="text" name="answer[1]" class="form-control" id="answer-input" required>
                </div>
                <div id="score-input-div-1" class="mb-3">
                    <label for="score-input" class="form-label">Score</label>
                    <input type="number" name="score[1]" class="form-control" id="score-input" required>
                </div>
                <div id="product-input-div-1" class="mb-3">
                    <label for="product-input" class="form-label">Product</label>
                     <select class="form-select" name="product[1]" id="product-input-select" aria-label="Select Product ">
                    </select>
                </div>
                <div id="recommendation-input-div-1" class="mb-3">
                    <label for="recommendation-input" class="form-label">Recommendation</label>
                     <select class="form-select" name="recommendation[1]" id="recommendation-input-select" aria-label="Select Recommendation ">
                    </select>
                </div>
                <!-- <hr> -->
            </div>

            <div align="center" class="mb-3">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>



    </form>
</div>


<?php
require_once("../footer.php");
?>
