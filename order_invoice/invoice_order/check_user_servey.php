<?php

require_once("../../inc/db_connect.php");

    $customerId = $_GET['customer_Id'];
    $out_put = [];
    $sql_checkcustomer = "SELECT tags FROM Customers WHERE customer_id=$customerId";
    $result_checkcustomer = $conn->query($sql_checkcustomer);
                    
    if ($result_checkcustomer->num_rows > 0) {
        $value = $result_checkcustomer->fetch_assoc();
        $tag = $value['tags'];
        
        if($tag === 'HCP' || $tag === 'HCPStaff' || $tag === 'Nutritionists' ){
            $out_put[0] = 'false';
            $out_put[1] = $tag;
            
        }else{
             $sql = "SELECT id FROM servey_table WHERE customer_id=$customerId";
            $result = $conn->query($sql);
                            
            if ($result->num_rows > 0) {
                $out_put[0] ='/pages/product-recomendation';
            } else {
                $out_put[0] ='/pages/questionnaire';
            }
        }
    }
    
   

echo json_encode($out_put);
?>