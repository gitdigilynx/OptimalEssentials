<?php


$sql_product12 = "SELECT * FROM customer_cartproduct_ids where customer_id=".$customer_id;
// $sql = "SELECT * FROM customer_cartproduct_ids where customer_id=97";
  $result12 = $conn->query($sql_product12);
  $productArrys = array();
  $variantsArrys = array();
    if ($result12->num_rows > 0){
        while ($value12 = $result12->fetch_assoc()){
              $product_id12 = $value12['products_ids'];
              $variants_id12 = $value12['variants_id'];
              if(is_string($product_id12)){
                $productids12 = explode(',',$product_id12);   
                $variantsids12 = explode(',',$variants_id12);  
                for($id=0; $id < count($productids12); $id++){
                    if($productids12[$id] != ''){
                        
                        // for varient
                        $variants_id12 = $variantsids12[$id];
                        array_push($variantsArrys,$variants_id12);
                        
                        // for product
                        $product_id12 = $productids12[$id];
                        array_push($productArrys,$product_id12);
                    }
                } 
                
             }
        } 
    }

                         
    // var_dump($productArrys);die();
                        // check the product is added in the cart start
                            foreach($productArrys as $productArr)
                            {
                                if($productArr == $product_id)
                                {
                                    $check_product_cartp = 'true';
                                    
                                }
                            }
                        // check the product is added in the cart end
    
///loop


              $products = shopify_call($acess_token, $shop, "/admin/api/2022-10/products/$product_id.json", array(), 'GET');
              $products = json_decode($products['response'], JSON_PRETTY_PRINT);
                
                foreach ($products as $product){
                    if($product != 'Not Found' && !is_string($product['id'])){
                        
                        $product_id = $product['id'];
                       
                        $product_title = $product['title'];
                        $product_price = $product['variants'][0]['price'];
                        $variant_id = $product['variants'][0]['id'];
                        $variant_title = $product['variants'][0]['title'];
                        if($product['image'] == null)
                        {
                        $product_src = '';
                        }else{
                            $product_src = $product['image']['src'];
                        }
                        $product_handle = $product['handle'];
                        
                        $output.='
        <div class="Grid__Cell 1/2--phone 1/3--tablet-and-up 1/4--lap-and-up">
            <div class="ProductItem ">
                <div class="ProductItem__Wrapper">
          
                                <a href="/collections/all/products/'.$product_handle.'?cart_area=true" class="ProductItem__ImageWrapper" target="_blank">
                                  <div class="AspectRatio AspectRatio--square" style="max-width: 3100px;  --aspect-ratio: 0.8717660292463442">
                                        <img class="ProductItem__Image" src="'.$product_src.'" alt="Age-Less 200G">
                                        
                                  </div>
                                </a>
                                <div class="ProductItem__Info ProductItem__Info--center">
                                  <h2 class="ProductItem__Title Heading">
                                    <a href="/collections/all/products/'.$product_handle.'" target="_blank">'.$product_title.'</a>
                                  </h2>
                                    
                                  <div class="ProductItem__PriceList ProductItem__PriceList--showOnHover Heading">
                                    <span class="ProductItem__Price Price Text--subdued price_lable_'.$count_lable_check.'" data-money-convertible="">'.$product_price.'</span>
                                    
                                  </div>
                                </div>
                                
                                <div class="ProductItem__Info ProductItem__Info--center"><input id="id_'.$product_id.'" class="label_iput select_product_checkbox" type="checkbox" value="'.$product_id.'" >
                                <label for="id_'.$product_id.'" class="btn_label" style="vertical-align: middle;">
                                <div class="checkdisbaleclick" id_dis_check="'.$product_id.'"  style="margin-bottom: 10%;">
                                ';
                                // if($check_product_cartp === 'true')
                                // {
                                    $output .='<select class="Form__Input product_variants product_id_l_'.$product_id.'">';
                                // }else{
                                // $output .='<select class="Form__Input product_variants product_id_l_'.$product_id.'" style="opacity: 0.5;cursor: no-drop;"   disabled>';
                                // }
                                
                                
$products_variants = shopify_call($acess_token, $shop, "/admin/api/2022-10/products/$product_id/variants.json", array(), 'GET');
              $products_variants = json_decode($products_variants['response'], JSON_PRETTY_PRINT);
                
                foreach ($products_variants as $variant){
                   $count_varient = 0;
                   foreach($variant as $varients)
                   {
                       $check_varient_cartp = 'false';
                       $variant_id = $variant[$count_varient]['id'];
                        $variant_title = $variant[$count_varient]['title'];
                         // check the varient is added in the cart start
                         
                         
                            foreach($variantsArrys as $variantsArr)
                            {
                                if($variantsArr == $variant_id)
                                {
                                    $check_varient_cartp = 'true';
                                }
                            }
                        // check the varient is added in the cart end
                        if($check_varient_cartp === 'true')
                        {
                            $output.='<option id="'.$count_lable_check.'" value="'.$variant_id.'" selected>'.$variant_title.'</option>';
                        }else{
                        $output.='<option id="'.$count_lable_check.'" value="'.$variant_id.'">'.$variant_title.'</option>';
                        }
                        $count_varient++;
                   }
                        
                       
                        
            
                              
                    }
$output.='
</select>
<div class="invisible_div">
   </div>
</div>';
 if($check_product_cartp === 'true')
                                {
                                    $output .='<span class="Button Button--primary Select_products active" attr_ids_p="'.$product_id.'" attr="Select">Select</span>';
                                }else{
                                $output .='<span class="Button Button--primary Select_products" attr_ids_p="'.$product_id.'" attr="Select">Select</span>';
                                }

$output.='
                                </label>
                                </div>
</div>
</div>
</div>';
                    }        
                     $check_product_cartp = false;
                }
                ///loop
               
?>