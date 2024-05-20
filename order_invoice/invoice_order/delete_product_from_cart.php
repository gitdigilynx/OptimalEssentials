<?php
require_once("../../inc/db_connect.php");


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    

    
    $customer_id = $_GET['customer_id'];
    $check_product_ids = $_GET['remove_product_id'];
    $check_varient_ids = $_GET['remove_varient_id'];
   
     $sql = "SELECT products_ids,variants_id FROM customer_cartproduct_ids where customer_id=".$customer_id;
      $result = $conn->query($sql);
      $productArrys = array();
      $new_product_ids;
      $new_varient_ids;
      
      
        if ($result->num_rows > 0){
            
            while ($value = $result->fetch_assoc()){
                    $new_product_ids = '';
                    $new_varient_ids = '';
                
                  $product_id = $value['products_ids'];
                  $variants_id = $value['variants_id'];
                  
                //   get values with commas
                  if(is_string($product_id)){
                    //   explode the product and varient id
                    $productids = explode(',',$product_id);   
                    $variants_ids = explode(',',$variants_id);   
                    
                    // get separate the values with comma
                    for($id=0; $id < count($productids); $id++){
                        
                        // check if not string
                        if($productids[$id] != ''){
                            $product_id = $productids[$id];
                            $variants_id = $variants_ids[$id];
                            // check the id for delete
                            if($product_id == $check_product_ids)
                            {
                            }else{ // crate a new array after deletion
                                $new_product_ids .= $product_id;
                                $new_varient_ids .= $variants_id;
                                $lengthcheck = count($productids);
                                $lengthcheck--;
                                if(!($id == $lengthcheck)){
                                    $new_product_ids .=',';
                                    $new_varient_ids .=',';
                                }
                            }
                        }
                    } 
                    
                 }
                
                //store new array in data base 
                // if($new_product_ids > 0){
                    $sql_update_cart = "UPDATE customer_cartproduct_ids SET products_ids='$new_product_ids',variants_id='$new_varient_ids' WHERE customer_id=$customer_id";
   
                    if ($conn->query($sql_update_cart) === TRUE) {
                      echo "deleted";
                    } else {
                      echo "Error updating record: " . $conn->error;
                    }
                // }
                 
            } 
           
        }else{
            echo 'error'. $conn->error;
        }
}
?>