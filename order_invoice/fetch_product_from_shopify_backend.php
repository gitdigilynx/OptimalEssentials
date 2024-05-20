<?php

require_once("../inc/db_connect.php");
require_once("../inc/functions.php");
require_once("../inc/store_credential.php");

$output = '';
$product_id = $_GET['product_id'];
$index_val = $_GET['index_val'];
$count_id = $index_val;
$product_qty = $_GET['product_qty'];
$varient_id = $_GET['varient_id'];
$check_varient = $_GET['check_varient'];
$shopify_check = $_GET['shopify_check'];


    





if($check_varient)
{
   
    $recurring_week = $_GET['recurring_week'];
    
    $output_array =[];
    $varient_option = '';
    $recurring_week_value = '';
    $product_id_for_v = $_GET['product_id_for_v'];
    $recurring_week = $recurring_week.'_weeks';
    
    
    
     $products = shopify_call($acess_token, $shop, "/admin/api/2022-10/products/$product_id_for_v.json", array(), 'GET');
            $products = json_decode($products['response'], JSON_PRETTY_PRINT);
                foreach ($products as $product){
                   
                    if($product != 'Not Found' && !is_string($product['id'])){
                        
                        $varient_products_all = $product['variants'];
                    }
                }
                 $varient_option = '  <option value="0">Select Vareint</option>';
                foreach($varient_products_all as $varient_products_al)
                {
                    $varient_id = $varient_products_al['id'];
                    $varient_title = $varient_products_al['title'];
                    $varient_option .= '<option value="'.$varient_id.'" >'.$varient_title.'</option>';
                    
                }
                
    //   get recring base quantity for add product start
    
                $sql_week_qty = "SELECT $recurring_week FROM Products WHERE product_id=$product_id_for_v";
                $result_week_qty = $conn->query($sql_week_qty);
                if($result_week_qty->num_rows > 0)
                {
                    $value_week_qty = $result_week_qty->fetch_assoc();
                    $week_qty = $value_week_qty[$recurring_week];
                    
                }
 
    //   get recring base quantity for add product end
    
    
    $output_array[0] = $varient_option;
    $output_array[1] = $week_qty;
    
    echo json_encode($output_array);
}else{
    
            $products = shopify_call($acess_token, $shop, "/admin/api/2022-10/products/$product_id.json", array(), 'GET');
            $products = json_decode($products['response'], JSON_PRETTY_PRINT);
                foreach ($products as $product){
                   
                    if($product != 'Not Found' && !is_string($product['id'])){
                        
                        $product_id = $product['id'];
                        $product_title = $product['title'];
                        
                        $variant_checks = $product['variants'];
                        foreach($variant_checks as $variant_check)
                        {
                            if($variant_check['id'] == $varient_id)
                            {
                               $product_price = $variant_check['price'];
                            }
                        }
                        
                        $product_inventory_quantity = $product['variants'][0]['inventory_quantity'];
                        $product_src = $product['image']['src'];
                        $product_handle = $product['handle'];
                        $product_total_price = $product_price *$product_qty;

if($shopify_check == true)
{
    $output .= '<tr id="row_'.$count_id.'" >
                <td>
                  <div class="CartItem__ImageWrapper AspectRatio">
                    <div class="AspectRatio" style="--aspect-ratio: 0.8717660292463442">
                      <img class="CartItem__Image" src="' . $product_src . '" alt="' . $product_title . '">
                        <input type="text" class="order_inputf" value="'.$product_src.'" name="product_img['.$count_id.']" placeholder="product_img_url">
                        <input type="text" class="order_inputf product_id_c" value="'.$product_id.'" name="product_id['.$count_id.']" placeholder="product_id">
                        <input type="text" class="order_inputf varient_id_c" value="'.$varient_id.'" name="variant_id['.$count_id.']" placeholder="varient_id">
                    </div>
                  </div>

                  <div class="CartItem__Info">
                    <h2 class="CartItem__Title Heading">
                      <a>' . $product_title . '</a>
                      <input type="text" class="order_inputf" value="'.$product_title.'" name="product_title['.$count_id.']" placeholder="Product title">
                     </h2>

                    <div class="CartItem__Meta Heading Text--subdued">
                    <div class="CartItem__PriceList">
                    <span class="CartItem__Price Price">$' . $product_price . '</span></div>
                     <input type="text" class="order_inputf prodtct_p_'.$count_id.'" value="'.$product_price.'" name="product_price['.$count_id.']" placeholder="Product Price">
                    </div>
                  </div>
                </td>

                <td class="Text--alignCenter Heading Text--subdued hidden-phone"><div class="CartItem__QuantitySelector">
							<div class="QuantitySelector">
								<a class="QuantitySelector__Button Link Link--primary button-minus" id="'.$count_id.'" title="Set quantity">
									<svg class="Icon Icon--minus" role="presentation" viewBox="0 0 16 2">
										<path d="M1,1 L15,1" stroke="currentColor" fill="none" fill-rule="evenodd" stroke-linecap="square"></path>
									</svg>
								</a>
								
                            <input type="text" id="qty_'.$count_id.'" class="quantity-field QuantitySelector__CurrentQuantity" value="'.$product_qty.'" name="quantity['.$count_id.']" placeholder="Product Qty" readonly>
								<a class="QuantitySelector__Button Link Link--primary button-plus" id="'.$count_id.'" title="Set quantity">
									<svg class="Icon Icon--plus" role="presentation" viewBox="0 0 16 16">
										<g stroke="currentColor" fill="none" fill-rule="evenodd" stroke-linecap="square">
											<path d="M8,1 L8,15"></path>
											<path d="M1,8 L15,8"></path>
										</g>
									</svg>
								</a>
							</div>
						</div> 
				</td>

                <td class="Text--alignRight Heading Text--subdued">
                    <span class="CartItem__Price Price prodtct_total_text_'.$count_id.'">$' . $product_total_price . '</span>
                    <input type="text" class="total_find order_inputf prodtct_total_val_'.$count_id.'" value="'.$product_total_price.'" name="total_price['.$count_id.']" placeholder="Product title">
                
                </td>
                <td class="Text--alignRight Heading Text--subdued">
                <button id="'.$count_id.'" class="Button Button--primary delete_item_order">Delete</button></td>
              </tr>';
    

    echo $output;
}else{
$output.='<div class="row" id="row_'.$index_val.'">
                        
                        <div class="col-md-8">
                            <div class="row mt-1 mb-4">
                                <div class="col-2">
                                    <img class="CartItem__Image" class="img-fluid" style="width:100%; height:100%;" src="'.$product_src.'" alt="'.$product_src.'">
                                    <input type="text" class="order_inputf" value="'.$product_src.'" name="product_img['.$index_val.']" placeholder="product_img_url">
                                     <input type="text" class="order_inputf product_id_c" value="'.$product_id.'" name="product_id['.$index_val.']" placeholder="product_id">
                                    <input type="text" class="order_inputf varient_id_c" value="'.$varient_id.'" name="variant_id['.$index_val.']" placeholder="varient_id">
                                </div>
                                <div class="col-10 mt-4">
                                    <p>'.$product_title.'</p>
                                    <input type="text" class="order_inputf" value="'.$product_title.'" name="product_title['.$index_val.']" placeholder="Product title">
                               
                                    <p class="text-muted">$'.$product_price.'</p>
                                    <input type="text" class="order_inputf prodtct_p_'.$index_val.'" value="'.$product_price.'" name="product_price['.$index_val.']" placeholder="Product Price">
                               
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 text-center mt-4">
                            <input type="button" id="'.$index_val.'" value="-" class="button-minus border rounded-circle  icon-shape icon-sm mx-1 " data-field="quantity">
                            <input type="text" id="qty_'.$index_val.'"  class="quantity-field border-0 text-center w-25 " value="'.$product_qty.'" name="quantity['.$index_val.']" placeholder="Product Qty" readonly>
                            <input type="button" id="'.$index_val.'" value="+" class="button-plus border rounded-circle icon-shape icon-sm lh-0" data-field="quantity"> 
                        </div>
                        <div class="col-md-1">
                            <p class="text-muted text-center mt-4 prodtct_total_text_'.$index_val.'">$'.$product_total_price.'</p>
                            <input type="text" class="total_find order_inputf prodtct_total_val_'.$index_val.'" value="'.$product_total_price.'" name="total_price['.$index_val.']" placeholder="Product title">
                               
                        </div>
                        <div class="col-md-1">
                            <button id="'.$index_val.'" class="btn btn-danger float-end delete_item_order mt-4" >
                                <i class="fa fa-trash" aria-hidden="true">
                                </i>
                            </button>
                        </div>
                    </div>';
                    
                    
    echo $output;
}
                    
                }
                    
}
}