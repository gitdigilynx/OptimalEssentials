<?php



require_once("../inc/db_connect.php");
require_once("../inc/functions.php");
require_once("../inc/store_credential.php");

$customer_id = $_GET['customer_id'];
$reccuring_val = $_GET['reccuring'];



$sql_variants = "SELECT variants_id FROM customer_cartproduct_ids where customer_id=".$customer_id;
            
              $result_variants = $conn->query($sql_variants);
              
              
              $variantsArry = array();
                if ($result_variants->num_rows > 0){
                    while ($value = $result_variants->fetch_assoc()){
                          $variants_id = $value['variants_id'];
                          
                          if(is_string($variants_id)){
                            $variantsids = explode(',',$variants_id);   
                            for($id=0; $id < count($variantsids); $id++){
                                if($variantsids[$id] != ''){
                                    $variants_id = $variantsids[$id];
                                    array_push($variantsArry,$variants_id);
                                }
                            } 
                            
                         } else {
                             
                         }
                         //$conn->close();
                    } 
                }
            
             
            
            



$sql_product = "SELECT products_ids FROM customer_cartproduct_ids where customer_id=".$customer_id;
// $sql = "SELECT products_ids FROM customer_cartproduct_ids where customer_id=6419716178176";
  $result = $conn->query($sql_product);
  $productArry = array();
    if ($result->num_rows > 0){
        while ($value = $result->fetch_assoc()){
              $product_id = $value['products_ids'];
              
              if(is_string($product_id)){
                $productids = explode(',',$product_id);   
                for($id=0; $id < count($productids); $id++){
                    if($productids[$id] != ''){
                        $product_id = $productids[$id];
                        array_push($productArry,$product_id);
                    }
                } 
                
             } else {
                 
             }
             //$conn->close();
        } 
    }

$count = 0;  
$pv_arr = array();
$p = 0;
foreach($productArry as $products_ids) {
    $v = 0;
    foreach($variantsArry as $variants_ids) {
        if($v == $p){         
            $pv_arr[] = $products_ids.' '.$variants_ids;
        }
        $v++;
    }
       $p++;             
     
        
        }
        
        $output .= '<div class="Cart__Head hidden-phone"> 
                  <span class="Cart__HeadItem Heading Text--subdued u-h7">Product</span> 
                  <span class="Cart__HeadItem"></span> <span class="Cart__HeadItem Heading Text--subdued u-h7" style="text-align: center">Quantity</span> 
                  <span class="Cart__HeadItem Heading Text--subdued u-h7 " style="text-align: right">Total</span> 
                  <span class="Cart__HeadItem Heading Text--subdued u-h7 " style="text-align: right">Action</span> 
                   
                  
                </div>';
        
    foreach($pv_arr as $pv_arr2) {
         $pv_arr3 = explode(' ',$pv_arr2);
         $product_id = $pv_arr3[0];
         $variant_id = $pv_arr3[1];
         
         ++$count;
        
         include('fetch_product_from_shopify_cart.php');
        
        }
$output.='<input type="text" name="customer_id_p" class="form_submit_input" value="'.$customer_id.'" readonly>';
         
        
        // echo '<pre>';
        // print_r($pv_arr);exit;
 
 echo $output;
           
?>