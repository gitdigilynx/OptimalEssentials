<?php




require_once("../../inc/db_connect.php");
$question_id = $_GET['question_id'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    

    $question = $_POST['question'];

    $sql = "UPDATE question_hard SET questions='$question' WHERE id=$question_id";
    if ($conn->query($sql) === TRUE) {
                            // find all question of that id
                $sql_answers = "SELECT * FROM answers WHERE question_id=$question_id";
               
               $result = $conn->query($sql_answers);
                
                if($result->num_rows > 0)
                {
                    
                    while($value = $result->fetch_assoc())
                    {
                        $product = '';
                        $recomendation = '';
                        $id_answer = $value['id'];
                        $answer =  mysqli_real_escape_string($conn,$_POST[ "answer_$id_answer"]);
                        $score = mysqli_real_escape_string($conn,$_POST[ "score_$id_answer"]);
                        // get multiple product array
                        $products = $_POST[ "product_$id_answer"];
                        foreach($products as $prodducts)
                        {
                             
                            $product .=mysqli_real_escape_string($conn,$prodducts).',';
                        }
                        // $product = mysqli_real_escape_string($conn,$_POST[ "product_$id_answer"]);
                   
                        // get multiple recomendation array
                        $recomendations = $_POST[ "recommendation_$id_answer"];
                        foreach($recomendations as $recomenddations)
                        {
                             

                            $recomendation .=mysqli_real_escape_string($conn,$recomenddations).',';
                        }
                        
                        $sql_update_answer = "UPDATE answers SET answer='$answer', score='$score', product='$product',recommendation_id='$recomendation' WHERE id=$value[id]";
                        if ($conn->query($sql_update_answer) === TRUE) {
                               
                            } else {
                              echo "Error updating record: " . $conn->error;
                            }
                        
                    }
                     
                }
               echo 'Record Updated';
    }
    else {
                  echo "Error updating record: " . $conn->error;
                }
    
}




?>