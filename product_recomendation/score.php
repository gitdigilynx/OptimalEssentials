<?php
$score = 0;
$sqlScore = "SELECT * FROM servey_table where customer_id=".$customer_id;
$resultScore = $conn->query($sqlScore);
  
if ($resultScore->num_rows > 0){
    while ($valueScore = $resultScore->fetch_assoc()){
         if(is_string($valueScore['score'])){
            $score2 = explode(',',$valueScore['score']);   
            for($is=0; $is < count($score2); $is++){
                if($score2[$is] != ''){
                    $score = $score + $score2[$is];
                }
            } 
         } else {
            $score = $score + $valueScore['score'];
         }
    }
}

$score_title = '';
// if($score >= 12 && $score <= 14){
//     $score_title = 'Normal nutritional status';
// } else if($score >=8 && $score < 12){
//     $score_title = 'At risk of malnutrition';
// } else if($score < 8){
//     $score_title = 'Malnourished';
// }

if($score >= 11 && $score <= 14){
    $score_title = 'Normal nutritional status';
} else if($score >=7 && $score < 11){
    $score_title = 'At risk of malnutrition';
} else if($score < 7){
    $score_title = 'Malnourished';
}
?>