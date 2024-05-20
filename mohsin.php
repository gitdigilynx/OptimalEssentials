<?php
echo 'hi';die();
require_once("inc/db_connect.php");
$recommendationArry =[];
$recommendation_unique_ids = [];
$customer_id = 6510687224064;
$sql = "SELECT recommendation_id  FROM servey_table where customer_id=6510687224064";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $recommendation_id = $row['recommendation_id'];
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
  echo "0 results";
}

 $recommendation_unique_ids = array_unique($recommendationArry);
 
 foreach($recommendation_unique_ids as $recommendation_unique_id){
     $recommendation_id = $recommendation_unique_id;
     if($recommendation_id != 0)
      include("product_recomendation/fetch_recommendation_from_table.php");
      
 }
echo $output;

?>