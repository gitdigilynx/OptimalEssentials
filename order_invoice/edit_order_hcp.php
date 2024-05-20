<?php

require_once("../inc/db_connect.php");
require_once("../inc/functions.php");
require_once("../inc/store_credential.php");

$order_id = $_GET['order_id'];
$customer_id = $_GET['customer_id'];
$product_sub_total = '';
$cound_id = 1;


//  echo $customer_id;
//  echo $order_id;
//  exit;

$product_sub_total = '';

$sql_gethcp_id = "SELECT * FROM Customers where customer_id=" . $customer_id;

$result_gethcp_id = $conn->query($sql_gethcp_id);

if ($result_gethcp_id->num_rows > 0) {
    while ($value = $result_gethcp_id->fetch_assoc()) {
        $customer_id_hcp = $value['hcp_id'];
    }
}



$output .= '

<h1  class="Segment__Title Heading u-h1" style="font-weight: 900 !important;text-align: center; margin-bottom: 4%;color: black;">Edit Order</h1>
<div align="right" class="Cart__Recap my_order_button" style="margin-bottom: 5%;">
                      
          </div>
<div class="PageLayout PageLayout--breakLap" style="margin-bottom: 4%;">
<div class="PageLayout__Section">
  <div class="Segment">
      <h2 class="Segment__Title Heading u-h7">Shipping address </h2>

          <div class="Segment__Content">';


$sql_address = "SELECT * FROM cutomer_address where customer_id=" . $customer_id;

$result_address = $conn->query($sql_address);





if ($result_address->num_rows > 0) {
    while ($value = $result_address->fetch_assoc()) {
        $customer_id = $value['customer_id'];
        $customer_fname = $value['customer_fname'];
        $customer_lastname = $value['customer_lname'];
        $customer_email = $value['customer_email'];
        $customer_phone = $value['customer_phone'];
        $customer_zip = $value['customer_zip'];
        $customer_address1 = $value['customer_address1'];
        $customer_addres2 = $value['customer_address2'];
        $customer_city = $value['customer_city'];
        $customer_province = $value['customer_state'];
        $customer_country = $value['customer_counrty'];




        $output .= '
        <form id="address_info_form" name="address_info_form">
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Customer_Id" name="Customer_Id"  placeholder="First Name" value="' . $customer_id . '" autofocus hidden>
                <input type="text" class="Form__Input" id="First_Name" name="First_Name"  placeholder="First Name" value="' . $customer_fname . '" autofocus >
                <label class="Form__FloatingLabel">First Name</label>
                </div>
                
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Last_Name" name="Last_Name"  placeholder="Last Name" value="' . $customer_lastname . '" autofocus>
                <label class="Form__FloatingLabel">Last Name</label>
                </div>
                
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Address" name="Address"  placeholder="Address" value="' . $customer_address1 . '" autofocus>
                <label class="Form__FloatingLabel">Address</label>
                </div>
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Address2" name="Address2"  placeholder="Apartment, suite, etc. (optional)" value="' . $customer_addres2 . '" autofocus>
                <label class="Form__FloatingLabel">Apartment, suite, etc. (optional)</label>
                </div>
                
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="City" name="City"  placeholder="City" value="' . $customer_city . '" autofocus>
                <label class="Form__FloatingLabel">City</label>
                </div>
                
                <div class="Form__Item">
                
                <select  class="Form__Input"  id="State" name="State"  >
                        <option value ="0" disabled="">State/territory</option>';
        if ($customer_province == 'Australian Capital Territory') {
            $output .= '<option value="ACT,Australian Capital Territory" selected>Australian Capital Territory </option>';
        } else {
            $output .= '<option value="ACT,Australian Capital Territory" >Australian Capital Territory </option>';
        }
        if ($customer_province == 'New South Wales') {
            $output .= '<option value="NSW,New South Wales" selected>New South Wales</option>';
        } else {
            $output .= '<option value="NSW,New South Wales">New South Wales</option>';
        }
        if ($customer_province == 'Northern Territory') {
            $output .= '<option value="NT,Northern Territory" selected >Northern Territory</option>';
        } else {
            $output .= '<option value="NT,Northern Territory">Northern Territory</option>';
        }
        if ($customer_province == 'Queensland') {
            $output .= '<option value="QLD,Queensland" selected>Queensland</option>';
        } else {
            $output .= '<option value="QLD,Queensland">Queensland</option>';
        }
        if ($customer_province == 'South Australia') {
            $output .= '<option value="SA,South Australia" selected>South Australia</option>';
        } else {
            $output .= '<option value="SA,South Australia">South Australia</option>';
        }
        if ($customer_province == 'Tasmania') {
            $output .= '<option value="TAS,Tasmania" selected>Tasmania</option>';
        } else {
            $output .= '<option value="TAS,Tasmania">Tasmania</option>';
        }
        $output .=
            '<option value="TAS,Tasmania">Tasmania</option>';
        if ($customer_province == 'Victoria') {
            $output .= '<option value="VIC,Victoria" selected>Victoria</option>';
        } else {
            $output .= '<option value="VIC,Victoria">Victoria</option>';
        }
        if ($customer_province == 'Western Australia') {
            $output .= '<option value="WA,Western Australia" selected>Western Australia</option>';
        } else {
            $output .= '<option value="WA,Western Australia">Western Australia</option>';
        }
        $output .=
            '
                </select>
                <label class="Form__FloatingLabel">State</label>
                </div>
                
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Zip_Code" name="Zip_Code"  placeholder="Zip Code" value="' . $customer_zip . '" autofocus>
                <label class="Form__FloatingLabel">Zip Code</label>
                </div>
                
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Country" name="Country"  placeholder="Country" value="' . $customer_country . '" autofocus>
                <label class="Form__FloatingLabel">Country</label>
                </div>
                
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Phone_No" name="Phone_No"  placeholder="Phone No" value="' . $customer_phone . '" autofocus>
                <label class="Form__FloatingLabel">Phone No</label>
                </div>
                
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Email" name="Email"  placeholder="Email" value="' . $customer_email . '" autofocus readonly>
                <label class="Form__FloatingLabel">Email</label>
                </div>
            </form>';
    }
}

$output .= '
 </div>
</div>
</div> 

    
 
 
<div class="PageLayout__Section">
          <div class="Segment">
            <h2 class="Segment__Title Heading u-h7">Order</h2>

            <div class="Segment__Content">';
$sql_order = "SELECT * FROM customer_order where order_id=" . $order_id;

$result_order = $conn->query($sql_order);

if ($result_order->num_rows > 0) {
    while ($value = $result_order->fetch_assoc()) {
        $customer_id    = $value['customer_id'];
        $order_id    = $value['order_id'];
        $order_created_date = $value['order_created_date'];
        $order_recurring = $value['order_recurring'];
        $order_shipping_status = $value['order_shipping_status'];
        $product_sub_total    = $value['product_sub_total'];


        $output .= '
                <h1 class="SectionHeader__Heading Heading u-h1">Order id #' . $order_id . '</h1>
                <p class="SectionHeader__Description">Order placed on ' . $order_created_date . '</p>
                <h1 class="SectionHeader__Heading Heading u-h1" style="margin-bottom: 4%;">Recurring Order</h1>
                
                <div class="Form__Item">
                <select  class="Form__Input recurring_week"  id="recurring_week" name="recurring_week"  >';
                
                                            $recuring_value = 0;
                                            for ($i = 0; $i < 3; $i++) {
                                                $recuring_value += 4;
                                                if ($order_recurring == $recuring_value) {
                                            
                                                   $output .=' <option value="'.$recuring_value .'" selected>'.$recuring_value .' week</option>';
                                                
                                                } else {
                                              
                                                    $output .=' <option value="'.$recuring_value.'">'.$recuring_value.' week</option>';
                                            
                                                } {
                                                }
                                            }

                 $output .='</select> 
                <label class="Form__FloatingLabel">Recurring order for every</label>
                </div>
                ';
    }
}




$output .= '
</div>
</div>
</div>
</div>
<h1 style="font-weight: 900 !important;text-align: center; margin-bottom: 4%;" class="Heading u-h1">Add Product</h1>
<p style="font-size: 12px !important;display:none;" class="product_alert Form__Alert Alert Alert--error SectionHeader--center"></p>
<div class="PageLayout PageLayout--breakLap" style="margin-bottom: 6%;" >
    <div class="PageLayout__Section">
      <div class="TableWrapper">
        <table class="AccountTable Table Table--noBorder">
          <thead class="Text--subdued">
            <tr>
              <th>Product</th>
              <th >Varient</th>
              <th >Quantity</th>
              <th >Action</th>
            </tr>
          </thead>

          <tbody >
          <td>
          <div class="Form__Item" style="margin: 0px !important;">
          <select  class="Form__Input dropdown_list_p"  name="select_product">
           <option value="0" >Select Product</option>';
                            
                            $sql_product = "SELECT * FROM Products";
                            $result_product = $conn->query($sql_product);
                            if ($result_product->num_rows > 0) {
                                while ($row_product = $result_product->fetch_assoc()) {
                            $product_id_s_p = $row_product['product_id'];
                            $product_title_s_p = $row_product['title'];
                                   $output .=' <option value="'.$product_id_s_p.'">'.$product_title_s_p.'</option>';
                            
                                }
                            }
                            
          $output .='
          </select>
          <label class="Form__FloatingLabel">Select Product</label>
          </div>
          </td>
           <td>
          <div class="Form__Item" style="margin: 0px !important;" >
          <select  class="Form__Input dropdown_list_v" name="select_vareint">
          <option value="0">Select Vareint</option>
          </select>
          <label class="Form__FloatingLabel">Select Varient</label>
          </div>
          </td>
          <td>
            <div class="QuantitySelector">
								<a class="QuantitySelector__Button Link Link--primary button-minus" id="a_p_q" title="Set quantity">
									<svg class="Icon Icon--minus" role="presentation" viewBox="0 0 16 2">
										<path d="M1,1 L15,1" stroke="currentColor" fill="none" fill-rule="evenodd" stroke-linecap="square"></path>
									</svg>
								</a>
								<input type="text" id="qty_a_p_q"  class="quantity-field QuantitySelector__CurrentQuantity" value="1" placeholder="Product Qty" readonly>
								<a class="QuantitySelector__Button Link Link--primary button-plus" id="a_p_q" title="Set quantity">
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
          <td>
          <button class="Button Button--primary" onclick="add_prdoduct_from_shpify()" >Add</button>
          </td>
          </tbody>

          </table>
          </div>
          </div>
          </div>
          
          <h1 style="font-weight: 900 !important;text-align: center; margin-bottom: 4%;" class="Heading u-h1">Line Item</h1>
 <form id="order_item_submit" name="order_item_form">
    <input type="text" class="order_inputf recurring_week_input" value="" id="recurring_week_input" name="recurring_week_input" placeholder="recurring_week_input">
    <input type="text" class="order_inputf order_id" value="'.$order_id.'" id="order_id" name="order_id" placeholder="order_id">
 <div class="PageLayout PageLayout--breakLap">
    <div class="PageLayout__Section">
      <div class="TableWrapper">
        <table class="AccountTable Table Table--noBorder">
        
          <thead class="Text--subdued">
            <tr>
              <th>Product</th>
              <th>Quantity</th>
              <th>Total</th>
              <th>Action</th>
            </tr>
          </thead>

          <tbody class ="customer_address_items">
          ';

$sql_item = "SELECT * FROM customer_order_item where order_id=" . $order_id;

$result_item = $conn->query($sql_item);

if ($result_item->num_rows > 0) {
    $count_id = 1;
    
   
    while ($value = $result_item->fetch_assoc()) {
        $product_src    = $value['product_src'];
        $product_id    = $value['product_id'];
        $varient_id    = $value['variant_id'];
        $product_title = $value['product_title'];
        $product_price = $value['product_price'];
        $product_qty = $value['product_qty'];
        $product_total = $value['product_total'];



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
                    <span class="CartItem__Price Price prodtct_total_text_'.$count_id.'">$' . $product_total . '</span>
                    <input type="text" class="total_find order_inputf prodtct_total_val_'.$count_id.'" value="'.$product_total.'" name="total_price['.$count_id.']" placeholder="Product title">
                </td>
                <td class="Text--alignRight Heading Text--subdued">
                <button id="'.$count_id.'" class="Button Button--primary delete_item_order">Delete</button></td>
              </tr>';
    
        $count_id++;
    }
    $newcount_id =$count_id-1;
     $output .=' <input type="text" class="coun_value order_inputf" value="'.$newcount_id.'" name="coun_value" placeholder="count">';
}




$output .= '</tbody>

          <tfoot>';



$output .= '<tr class="Segment" >
              <td class="Heading Text--subdued"></td>
             <td class="Heading Text--subdued u-h7">Subtotal</td>
             <td class="Heading Text--subdued Text--alignRight u-h7 sub_total_text">$' . $product_sub_total . '</td>
             <td class="Heading Text--subdued"><input type="text" class="order_inputf sub_total_val" value="'.$product_sub_total.'" name="sub_total" placeholder="Product sub total"></td>
              
             
            </tr>';
$output .= '<tr>
            <td></td>
            <td></td>
            <td> </td>
              <td class="Heading Text--alignRight u-h7">
                <button class="Button Button--primary order_submit"  >Update</button>
              </td>
            </tr>';


$output .= '</tfoot>
        </table>
      </div>
    </div>
  </div>
  </form>';

echo ($output);
