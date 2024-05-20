<?php
require_once("../inc/db_connect.php");
$customerId = $_GET['customer_id'];
$response = [];
$output = '';
$recommendationArry =[];
$recommendation_unique_ids = [];
$sql = "SELECT question_id,answer_id FROM servey_table WHERE customer_id=$customerId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $output .='<div style="box-shadow: 0px 0px 8px;margin:12px auto;padding: 13px;background:#454545;">
                  <div class="Container" style="">
                    <div class="SectionHeader SectionHeader--center">
                      <h4 class="SectionHeader__Heading Heading Heading_apna u-h1" style="font-weight: bold;color:white;">Question Answer</h4></div>
                  </div>
                  </div>';
    $count = 1;
  // output data of each row
  while($row = $result->fetch_assoc()) {
      
     
     $answerrs = $row['answer_id'];
        
        // $final_answer = 'Height '.$height.' Weight '.$weight;
        if (preg_match('/~/', $answerrs)) {
            $answerr = explode("~",$answerrs);
        $height = $answerr[0];
        $weight = $answerr[1];
        $bmi = $answerr[2];
        $final_answer = 'Height '.$height.', Weight '.$weight;
        }
        else{
         $final_answer = $answerrs;
        }
    
        
      
    $output .='<div style="box-shadow: 0px 0px 8px;margin:12px auto;padding: 13px;"><p style="font-weight: bold;">Qestion'.$count.': '.$row['question_id'].'</p><h5>Answer'.$count.': '.$final_answer.'</h5></div>';
    $count++;
  }
} else {
  $output = "<h1 style='color: red;text-align: center;'class='SectionHeader__Heading Heading u-h1'> No QUESTIONNAIRE Submitted </h1>";
}
//  array_push($response,$output);
$sql2 = "SELECT first_name,last_name,email FROM Customers WHERE customer_id=$customerId";
$result2 = $conn->query($sql2);
if ($result2->num_rows > 0) {
    $row2 = $result2->fetch_assoc();
    $first_name = $row2['first_name'];
    $last_name = $row2['last_name'];
    $emailuser = $row2['email'];
    $full_detail = "$first_name $last_name ($emailuser)";
    
    // array_push($response,$full_detail);
}

$output .='<div style="box-shadow: 0px 0px 8px;margin:12px auto;padding: 13px;background:#454545;">
                  <div class="Container" style="">
                    <div class="SectionHeader SectionHeader--center">
                      <h4 class="SectionHeader__Heading Heading Heading_apna u-h1" style="font-weight: bold;color:white;">Recommendation</h4></div>
                  </div>
                  </div>';

$sql_recommedation = "SELECT recommendation_id  FROM servey_table where customer_id=$customerId";
$result_recommedation = $conn->query($sql_recommedation);
// echo $result_recommedation;
if ($result_recommedation->num_rows > 0) {
  // output data of each row
  while($row_recommedation = $result_recommedation->fetch_assoc()) {
    $recommendation_id = $row_recommedation['recommendation_id'];
     if(is_string($recommendation_id)){
                $recommendationids = explode(',',$recommendation_id);   
                for($id=0; $id < count($recommendationids); $id++){
                    if($recommendationids[$id] != ''){
                        $recommendation_id = $recommendationids[$id];
                        
                        array_push($recommendationArry,$recommendation_id);
                    }
                } 
                
             } else {
                 
                array_push($recommendationArry,$recommendation_id);
             }
    
  }
} else {
  $output .= "Recommendation 0 results";
}
$recommendation_unique_ids = array_unique($recommendationArry);

$checkquestionanswerlist_file = true;

 foreach($recommendation_unique_ids as $recommendation_unique_id){
    
     $recommendation_id = $recommendation_unique_id;
     if($recommendation_id != 0){
        $output .='<div style="box-shadow: 0px 0px 8px;margin:12px auto;padding: 13px;">';
            include("../product_recomendation/fetch_recommendation_from_table.php");
        $output .='</div>';
     }
      
      
 }

 
 $response[0] = $output;
 $response[1] = $full_detail;

echo json_encode($response);
$conn->close();
?>