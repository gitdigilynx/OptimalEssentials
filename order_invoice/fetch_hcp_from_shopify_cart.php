<?php

require_once("../inc/db_connect.php");
require_once("../inc/functions.php");
require_once("../inc/store_credential.php");

$customer_id = $_GET['customer_id'];
$output = '';

 $output.='
        <div class="Segment">
            <h2 class="Segment__Title Heading u-h7">Billing address</h2>
              <div class="Segment__Content">
              
                <form id="address_info_form" name="address_info_form" class="Cart Cart--expanded" >';
$sql_address = "SELECT * FROM cutomer_address where customer_id=".$customer_id;
 
  $result_address = $conn->query($sql_address);

    if ($result_address->num_rows > 0){
       
        while ($value = $result_address->fetch_assoc()){
              $customer_id = $value['customer_id'];
              $customer_fname = $value['customer_fname'];
              $customer_compony = $value['compony'];
              $customer_lastname = $value['customer_lname'];
              $customer_email = $value['customer_email'];
              $customer_phone = $value['customer_phone'];
              $customer_zip = $value['customer_zip'];
              $customer_address1 = $value['customer_address1'];
              $customer_addres2 = $value['customer_address2'];
              $customer_city = $value['customer_city'];
              $customer_province = $value['customer_state'];
              $customer_country = $value['customer_counrty'];
              
              
              
             
           
             
            $output.='
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Customer_Id" name="Customer_Id"  placeholder="First Name" value="'.$customer_id.'" autofocus hidden>
                <input type="text" class="Form__Input" id="First_Name" name="First_Name"  placeholder="First Name" value="'.$customer_fname.'" autofocus >
                <label class="Form__FloatingLabel">First Name</label>
                </div>
                
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Last_Name" name="Last_Name"  placeholder="Last Name" value="'.$customer_lastname.'" autofocus>
                <label class="Form__FloatingLabel">Last Name</label>
                </div>
                
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Address" name="Address"  placeholder="Address" value="'.$customer_address1.'" autofocus>
                <label class="Form__FloatingLabel">Address</label>
                </div>
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Address2" name="Address2"  placeholder="Apartment, suite, etc. (optional)" value="'.$customer_addres2.'" autofocus>
                <label class="Form__FloatingLabel">Apartment, suite, etc. (optional)</label>
                </div>
                
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="City" name="City"  placeholder="City" value="'.$customer_city.'" autofocus>
                <label class="Form__FloatingLabel">City</label>
                </div>
                
                <div class="Form__Item">
                
                <select  class="Form__Input"  id="State" name="State"  >
                        <option value ="0" disabled="">State/territory</option>';
                        if($customer_province == 'Australian Capital Territory')
                        {
                           $output .='<option value="ACT,Australian Capital Territory" selected>Australian Capital Territory </option>';
                        }else{
                             $output .='<option value="ACT,Australian Capital Territory" >Australian Capital Territory </option>';
                        }
                        if($customer_province == 'New South Wales')
                        {
                           $output .='<option value="NSW,New South Wales" selected>New South Wales</option>';
                        }else{
                             $output .='<option value="NSW,New South Wales">New South Wales</option>';
                        }
                        if($customer_province == 'Northern Territory')
                        {
                           $output .='<option value="NT,Northern Territory" selected >Northern Territory</option>';
                        }else{
                             $output .='<option value="NT,Northern Territory">Northern Territory</option>';
                        }
                        if($customer_province == 'Queensland')
                        {
                           $output .='<option value="QLD,Queensland" selected>Queensland</option>';
                        }else{
                             $output .='<option value="QLD,Queensland">Queensland</option>';
                        }
                        if($customer_province == 'South Australia')
                        {
                           $output .='<option value="SA,South Australia" selected>South Australia</option>';
                        }else{
                             $output .='<option value="SA,South Australia">South Australia</option>';
                        }
                        if($customer_province == 'Tasmania')
                        {
                           $output .='<option value="TAS,Tasmania" selected>Tasmania</option>';
                        }else{
                             $output .='<option value="TAS,Tasmania">Tasmania</option>';
                        }
                        $output .=
                        '<option value="TAS,Tasmania">Tasmania</option>';
                        if($customer_province == 'Victoria')
                        {
                           $output .='<option value="VIC,Victoria" selected>Victoria</option>';
                        }else{
                             $output .='<option value="VIC,Victoria">Victoria</option>';
                        }
                        if($customer_province == 'Western Australia')
                        {
                           $output .='<option value="WA,Western Australia" selected>Western Australia</option>';
                        }else{
                             $output .='<option value="WA,Western Australia">Western Australia</option>';
                        }
                        $output .=
                        '
                </select>
                <label class="Form__FloatingLabel">State</label>
                </div>
                
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Zip_Code" name="Zip_Code"  placeholder="Zip Code" value="'.$customer_zip.'" autofocus>
                <label class="Form__FloatingLabel">Zip Code</label>
                </div>
                
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Country" name="Country"  placeholder="Country" value="'.$customer_country.'" autofocus>
                <label class="Form__FloatingLabel">Country</label>
                </div>
                
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Compony" name="Compony"  placeholder="Compony" value="'.$customer_compony.'" autofocus>
                <label class="Form__FloatingLabel">Compony</label>
                </div>
                
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Phone_No" name="Phone_No"  placeholder="Phone No" value="'.$customer_phone.'" autofocus>
                <label class="Form__FloatingLabel">Phone No</label>
                </div>
                
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Email" name="Email"  placeholder="Email" value="'.$customer_email.'" autofocus readonly>
                <label class="Form__FloatingLabel">Email</label>
                </div>';
    }
   
  }
  
  else{



///loop
              
              
              $customer_shopify = shopify_call($acess_token,$shop, "/admin/api/2022-10/customers/$customer_id.json", array(), 'GET');
              $customer_shopify = json_decode($customer_shopify['response'], JSON_PRETTY_PRINT);
             
            //  echo '<pre>';
            //  print_r( $customer_shopify );
            //  exit();
                
                foreach ($customer_shopify as $customer){
                    if($customer != 'Not Found' && !is_string($customer['id'])){
                        
                        $customer_id = $customer['id'];
                        $customer_fname = $customer['first_name'];
                        $customer_lastname = $customer['last_name'];
                        $customer_note = $customer['note'];
                        $customer_email = $customer['email'];
                        $customer_phone = $customer['default_address']['phone'];
                        $customer_zip = $customer['default_address']['zip'];
                        $customer_address1 = $customer['default_address']['address1'];
                        $customer_addres2 = $customer['default_address']['address2'];
                        $customer_city = $customer['default_address']['city'];
                        $customer_province = $customer['default_address']['province'];
                        $customer_country = $customer['default_address']['country'];
                        
                                  $getcompony_notes = $customer_note;
                                  $arr = explode("HCP-Company: ",$getcompony_notes);
                                  $compony=  $arr[1];
                
                     
                        
         
            
            
              $output.='
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Customer_Id" name="Customer_Id"  placeholder="First Name" value="'.$customer_id.'" autofocus hidden>
                <input type="text" class="Form__Input" id="First_Name" name="First_Name"  placeholder="First Name" value="'.$customer_fname.'" autofocus >
                <label class="Form__FloatingLabel">First Name</label>
                </div>
                
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Last_Name" name="Last_Name"  placeholder="Last Name" value="'.$customer_lastname.'" autofocus>
                <label class="Form__FloatingLabel">Last Name</label>
                </div>
                
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Address" name="Address"  placeholder="Address" value="'.$customer_address1.'" autofocus>
                <label class="Form__FloatingLabel">Address</label>
                </div>
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Address2" name="Address2"  placeholder="Apartment, suite, etc. (optional)" value="'.$customer_addres2.'" autofocus>
                <label class="Form__FloatingLabel">Apartment, suite, etc. (optional)</label>
                </div>
                
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="City" name="City"  placeholder="City" value="'.$customer_city.'" autofocus>
                <label class="Form__FloatingLabel">City</label>
                </div>
                
                <div class="Form__Item">
                
                <select  class="Form__Input"  id="State" name="State"  >
                        <option value ="0" disabled="">State/territory</option>';
                        if($customer_province == 'Australian Capital Territory')
                        {
                           $output .='<option value="ACT,Australian Capital Territory" selected>Australian Capital Territory </option>';
                        }else{
                             $output .='<option value="ACT,Australian Capital Territory" >Australian Capital Territory </option>';
                        }
                        if($customer_province == 'New South Wales')
                        {
                           $output .='<option value="NSW,New South Wales" selected>New South Wales</option>';
                        }else{
                             $output .='<option value="NSW,New South Wales">New South Wales</option>';
                        }
                        if($customer_province == 'Northern Territory')
                        {
                           $output .='<option value="NT,Northern Territory" selected >Northern Territory</option>';
                        }else{
                             $output .='<option value="NT,Northern Territory">Northern Territory</option>';
                        }
                        if($customer_province == 'Queensland')
                        {
                           $output .='<option value="QLD,Queensland" selected>Queensland</option>';
                        }else{
                             $output .='<option value="QLD,Queensland">Queensland</option>';
                        }
                        if($customer_province == 'South Australia')
                        {
                           $output .='<option value="SA,South Australia" selected>South Australia</option>';
                        }else{
                             $output .='<option value="SA,South Australia">South Australia</option>';
                        }
                        if($customer_province == 'Tasmania')
                        {
                           $output .='<option value="TAS,Tasmania" selected>Tasmania</option>';
                        }else{
                             $output .='<option value="TAS,Tasmania">Tasmania</option>';
                        }
                        $output .=
                        '<option value="TAS,Tasmania">Tasmania</option>';
                        if($customer_province == 'Victoria')
                        {
                           $output .='<option value="VIC,Victoria" selected>Victoria</option>';
                        }else{
                             $output .='<option value="VIC,Victoria">Victoria</option>';
                        }
                        if($customer_province == 'Western Australia')
                        {
                           $output .='<option value="WA,Western Australia" selected>Western Australia</option>';
                        }else{
                             $output .='<option value="WA,Western Australia">Western Australia</option>';
                        }
                        $output .=
                        '
                </select>
                <label class="Form__FloatingLabel">State</label>
                </div>
                
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Zip_Code" name="Zip_Code"  placeholder="Zip Code" value="'.$customer_zip.'" autofocus>
                <label class="Form__FloatingLabel">Zip Code</label>
                </div>
                
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Country" name="Country"  placeholder="Country" value="'.$customer_country.'" autofocus>
                <label class="Form__FloatingLabel">Country</label>
                </div>
                
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Compony" name="Compony"  placeholder="Compony" value="'.$compony.'" autofocus>
                <label class="Form__FloatingLabel">Compony</label>
                </div>
                
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Phone_No" name="Phone_No"  placeholder="Phone No" value="'.$customer_phone.'" autofocus>
                <label class="Form__FloatingLabel">Phone No</label>
                </div>
                
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Email" name="Email"  placeholder="Email" value="'.$customer_email.'" autofocus>
                <label class="Form__FloatingLabel">Email</label>
                </div>
                
                
                
                ';


          
                    
                    }        
                }
  }
  $output .= '</form>
   </div>
        
</div>
<footer class="Cart__Footer">
    				<div align="right" class="Cart__Recap">
                      <button  class="Cart__Checkout Button Button--primary order_submit">Update</button>
                      </div>
    			</footer>';
            
            echo $output;    
               
                ///loop
?>