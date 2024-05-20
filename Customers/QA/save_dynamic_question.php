<?php
// db connection
require_once("../../inc/db_connect.php");

// check server request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $answer = [];
    $count = 0;
    $question = $_POST['question-input'];

    echo '<pre>';
    var_dump($_POST['answer']);

    $answer = $_POST['answer'];
    $score = $_POST['score'];
    $product = $_POST['product'];
    $recommendation = $_POST['recommendation'];
    //  foreach ($answer as $answers) {
    //             $count++;
    //            echo  $answer[$count];

    //         }
    // die();
    $insert_question_sql = "INSERT INTO question_hard (questions,type) VALUES ('$question','1')";
    if ($conn->query($insert_question_sql) === TRUE) {
        echo 'quesrion inserr';
        $question_id = $conn->insert_id;

        foreach ($answer as $answers) {
            $count++;
            $insert_answer = "INSERT INTO answers (question_id,answer,score,product,recommendation_id) VALUES ('$question_id','$answer[$count]','$score[$count]','$product[$count]','$recommendation[$count]')";
            if ($conn->query($insert_answer) === TRUE) {
                header("Location: question_answer_list.php");
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
