<?php



                    
                   
///loop
              $products = shopify_call($acess_token, $shop, "/admin/api/2022-10/products/$product_id.json", array(), 'GET');
              $products = json_decode($products['response'], JSON_PRETTY_PRINT);
                
                
                foreach ($products as $product){
                   
                    if($product != 'Not Found' && !is_string($product['id'])){
                        
                        $product_id = $product['id'];
                        $product_title = $product['title'];
                        $variant_checks = $product['variants'];
                        foreach($variant_checks as $variant_check)
                        {
                            if($variant_check['id'] == $variant_id)
                            {
                               $product_price = $variant_check['price'];
                               $product_sku = $variant_check['sku'];
                            }
                        }
                        $product_inventory_quantity = $product['variants'][0]['inventory_quantity'];
                        $product_src = $product['image']['src'];
                        $product_handle = $product['handle'];
                        
                        
                        $sql_reccur = "SELECT 4_weeks, 8_weeks, 12_weeks FROM Products where product_id=".$product_id;
            
                        $result_reccur = $conn->query($sql_reccur);
                          
                            if ($result_reccur->num_rows > 0){
                                while ($value = $result_reccur->fetch_assoc()){
                                      $four_weeks = $value['4_weeks'];
                                      $eight_weeks = $value['8_weeks'];
                                      $twelve_weeks = $value['12_weeks'];
                                      
                                } 
                            }
                        
                        if($reccuring_val === '4'){
                            $reccur_qty = $four_weeks;
                        }
                        else if($reccuring_val === '8'){
                            $reccur_qty = $eight_weeks;
                        }
                        else if($reccuring_val === '12'){
                           $reccur_qty = $twelve_weeks;
                        }else if($reccuring_val === '0')
                        {
                            $reccur_qty = 1;
                        }
                        $product_total = $reccur_qty*$product_price;
                        
             
                        


$output.='<div class="CartItem cart_row_'.$count.'">
                    <div class="CartItem__ImageWrapper AspectRatio">
						<div class="AspectRatio" style="--aspect-ratio: 0.8717660292463442">
						<input type="text" name="variant_id['.$count.']" class="product_img_+'.$product_id.' form_submit_input "  value="'.$variant_id.'" readonly>
						<input type="text" name="sku_id['.$count.']" class="product_img_+'.$product_id.' form_submit_input "  value="'.$product_sku.'" readonly>
						  <input type="text" name="product_id['.$count.']" class="product_img_+'.$product_id.' form_submit_input"  value="'.$product_id.'" readonly>
						  <input type="text" name="product_img['.$count.']" class="product_img_+'.$product_id.' form_submit_input"  value="'.$product_src.'" readonly>
                          <img class="CartItem__Image product_img_+'.$product_id.'" src="'.$product_src.'" alt=""> 
                   </div>
					</div>
					<div class="CartItem__Info">
						<h2 class="CartItem__Title Heading">
						<input type="text" name="product_title['.$count.']" class="product_title_+'.$product_id.' form_submit_input"  value="'.$product_title.'" readonly>
                        <a class="product_title_+'.$product_id.'">'.$product_title.'</a>
                        </h2>
						<div class="CartItem__Meta Heading Text--subdued">
							<div class="CartItem__PriceList">
                              <span class="CartItem__Price Price" data-money-convertible="">
                                <input type="text" name="product_price['.$count.']" class="product_price_val'.$count.' form_submit_input"  value="'.$product_price.'" readonly>
                                <div class="wn-price-item product_price_text'.$count.'">'.$product_price.'</div>
                              </span>
                            </div>
						</div>
					</div>
					<div class="CartItem__Actions Heading Text--subdued" style="text-align: center">
						<div class="CartItem__QuantitySelector">
							<div class="QuantitySelector">
								<a class="QuantitySelector__Button Link Link--primary quantity_minus" id="'.$count.'" title="Set quantity">
									<svg class="Icon Icon--minus" role="presentation" viewBox="0 0 16 2">
										<path d="M1,1 L15,1" stroke="currentColor" fill="none" fill-rule="evenodd" stroke-linecap="square"></path>
									</svg>
								</a>
								<input type="text" name="quantity['.$count.']" id="quantity" class="QuantitySelector__CurrentQuantity" value="'.$reccur_qty.'" readonly>
								<a class="QuantitySelector__Button Link Link--primary quantity_plus" id="'.$count.'" title="Set quantity">
									<svg class="Icon Icon--plus" role="presentation" viewBox="0 0 16 16">
										<g stroke="currentColor" fill="none" fill-rule="evenodd" stroke-linecap="square">
											<path d="M8,1 L8,15"></path>
											<path d="M1,8 L15,8"></path>
										</g>
									</svg>
								</a>
							</div>
						</div> 
                   
                    </div>
					<div class="CartItem__LinePriceList Heading Text--subdued" style="text-align: right">
                      <span class="CartItem__Price Price" data-money-convertible="">
                        <input type="text" name="total_price['.$count.']" class="total_find total_price_val'.$count.' form_submit_input"  value="'.$product_total.'" readonly>
                      	<div class="wn-total-line-item total_price_text'.$count.'">'.$product_total.'</div>
                      </span>
                    </div>
                    <div class="CartItem__LinePriceList Heading Text--subdued" style="text-align: right">
                        <button id="'.$count.'" class=" Button Button--primary remove_item_cart">Remove</button>
                    </div>
            </div>';
                    
                    
                    }  
                    
                }
        

                
               
                ///loop
?>