<?php

require_once("../inc/db_connect.php");
require_once("../inc/functions.php");
require_once("../inc/store_credential.php");

$customer_id = $_GET['customer_id'];



$sql_address = "SELECT * FROM cutomer_address where customer_id=".$customer_id;
 
  $result_address = $conn->query($sql_address);

    if ($result_address->num_rows > 0){
        while ($value = $result_address->fetch_assoc()){
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
                <input type="text" class="Form__Input" id="Phone_No" name="Phone_No"  placeholder="Phone No" value="'.$customer_phone.'" autofocus>
                <label class="Form__FloatingLabel">Phone No</label>
                </div>
                
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Email" name="Email"  placeholder="Email" value="'.$customer_email.'" autofocus>
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
                
                if($customer_shopify['errors'] == 'Not Found')
                {
                    $sql_customer_data = "SELECT first_name,last_name,email FROM Customers WHERE customer_id=$customer_id";
                    $result_customer_data = $conn->query($sql_customer_data);
                    if($result_customer_data->num_rows > 0)
                    {
                        $value_customer_data = $result_customer_data->fetch_assoc();
                        $first_name_customer_data = $value_customer_data['first_name'];
                        $last_name_customer_data = $value_customer_data['last_name'];
                        $email_customer_data = $value_customer_data['email'];
                    }
                    $output.='
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Customer_Id" name="Customer_Id"  placeholder="Customer_Id" value="'.$customer_id.'" autofocus hidden>
                <input type="text" class="Form__Input" id="First_Name" name="First_Name"  placeholder="First Name" value="'.$first_name_customer_data.'" autofocus >
                <label class="Form__FloatingLabel">First Name</label>
                </div>
                
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Last_Name" name="Last_Name"  placeholder="Last Name" value="'.$last_name_customer_data.'" autofocus>
                <label class="Form__FloatingLabel">Last Name</label>
                </div>
                
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Address" name="Address"  placeholder="Address" value="" autofocus>
                <label class="Form__FloatingLabel">Address</label>
                </div>
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Address2" name="Address2"  placeholder="Apartment, suite, etc. (optional)" value="" autofocus>
                <label class="Form__FloatingLabel">Apartment, suite, etc. (optional)</label>
                </div>
                
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="City" name="City"  placeholder="City" value="" autofocus>
                <label class="Form__FloatingLabel">City</label>
                </div>
                
                <div class="Form__Item">
                
                <select class="Form__Input" id="State" name="State">
                        <option value="0" selected="" disabled="">State/territory</option>
                        <option value="ACT,Australian Capital Territory">Australian Capital Territory </option>
                        <option value="NSW,New South Wales">New South Wales</option>
                        <option value="NT,Northern Territory">Northern Territory</option>
                        <option value="QLD,Queensland">Queensland</option>
                        <option value="SA,South Australia">South Australia</option>
                        <option value="TAS,Tasmania">Tasmania</option>
                        <option value="TAS,Tasmania">Tasmania</option>
                        <option value="VIC,Victoria">Victoria</option>
                        <option value="WA,Western Australia">Western Australia</option>
                </select>
                <label class="Form__FloatingLabel">State</label>
                </div>
                
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Zip_Code" name="Zip_Code"  placeholder="Zip Code" value="" autofocus>
                <label class="Form__FloatingLabel">Zip Code</label>
                </div>
                
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Country" name="Country"  placeholder="Country" value="" autofocus>
                <label class="Form__FloatingLabel">Country</label>
                </div>
                
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Phone_No" name="Phone_No"  placeholder="Phone No" value="" autofocus>
                <label class="Form__FloatingLabel">Phone No</label>
                </div>
                
                <div class="Form__Item">
                <input type="text" class="Form__Input" id="Email" name="Email"  placeholder="Email" value="'.$email_customer_data.'" autofocus readonly>
                <label class="Form__FloatingLabel">Email</label>
                </div>
                
                
                
                ';
                }else{
                    
                
                
                foreach ($customer_shopify as $customer){
                    if($customer != 'Not Found' && !is_string($customer['id'])){
                        
                        $customer_id = $customer['id'];
                        $customer_fname = $customer['first_name'];
                        $customer_lastname = $customer['last_name'];
                        $customer_email = $customer['email'];
                        $customer_phone = $customer['default_address']['phone'];
                        $customer_zip = $customer['default_address']['zip'];
                        $customer_address1 = $customer['default_address']['address1'];
                        $customer_addres2 = $customer['default_address']['address2'];
                        $customer_city = $customer['default_address']['city'];
                        $customer_province = $customer['default_address']['province'];
                        $customer_country = $customer['default_address']['country'];
                
                     
                        
         
            
            
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
  }
            
            echo $output;    
               
                ///loop
?>