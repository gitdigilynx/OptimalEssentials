

<?php
$output = '';

require_once("../inc/functions.php");
require_once("../inc/store_credential.php");

$customerId = $_GET['customerId'];
$store_url = 'https://optimal-essentials-dev.myshopify.com';


// https://your-development-store.myshopify.com/admin/api/2022-07/customers/207119551.json

  $customer1 = shopify_call($acess_token, $shop, "/admin/api/2022-07/customers/". $customerId.".json", array(), 'GET');
    $customer1 = json_decode($customer1['response'], JSON_PRETTY_PRINT);



  foreach ($customer1 as $customer) :
      
      if($customer['tags'] == 'HCP'){
          $output .=
            '<div class="Linklist"  >
                <h1 style="font-weight: 900 !important;text-align: center;padding-left: 20%;" class="Heading u-h1" >Welcome to Home Care Provider Dashboard</h1>
                
                <p style="font-size: 12px !important;" class="client_deatils_n_e SectionHeader--center"></p>
                <p  style="font-size: 12px !important;display:none;" class="custom_alert Form__Alert Alert Alert--success SectionHeader--center"></p>
                    <div class="Linklist__Item" style="display: flex;justify-content: space-between;margin-top:4%" >
                        <div class="menu_list_items">
                            <a style="cursor: pointer;" class="PageHeader__Back Heading Text--subdued Link Link--primary u-h7 my_menu my_client" onclick="GetHCPClientList()" >MY CLIENTS</a><br>
                            <a style="cursor: pointer;" class="PageHeader__Back Heading Text--subdued Link Link--primary u-h7 my_menu my_invoice" onclick="GetInvoiceList()" >MY INVOICES</a><br>
                            <a style="cursor: pointer;" class="PageHeader__Back Heading Text--subdued Link Link--primary u-h7 my_menu my_staff" onclick="GetHCPStaffList()" >MY STAFF </a><br>
                      
                            <a  class="PageHeader__Back Heading Text--subdued Link Link--primary u-h7 my_menu my_billing" href="'.$store_url.'/pages/hcp-billing-address " >Billing Address</a><br>
                            <a  style="cursor: pointer;" class="PageHeader__Back Heading Text--subdued Link Link--primary u-h7 my_menu my_password" onclick="GetHCPPassword()" >Reset Password</a><br>
                            
                        </div>
                        
                        <div style="width: 80%;" >
                            <div align="right" id="AddHcpStaff" style="display:none;" >
                                <a href="https://optimal-essentials-dev.myshopify.com/pages/add-staff" type="button" ><button class="Form__Submit Button Button--primary " >Add Staff</button></a><br>
                            </div>
                            <div id="HcpStaffList" >
                            </div>
                            
                        </div>
                        
                    </div>
            </div>';
      }
      else if($customer['tags'] == 'HCPClient'){
          $output .=
            '<div class="Linklist"  >
                <h1 style="font-weight: 900 !important;text-align: center;padding-left: 20%;" class="Heading u-h1" >Home Care Package Client Dashboard</h1>
                    <div class="Linklist__Item" style="display: flex;justify-content: space-between;" >
                        <div class="menu_list_items">';
                            // include the required files
                            require_once("../inc/db_connect.php");
                            $sql = "SELECT id FROM servey_table WHERE customer_id=$customerId";
                            $result = $conn->query($sql);
                
                            if ($result->num_rows > 0) {
                               $output .='<a class="PageHeader__Back Heading Text--subdued Link Link--primary u-h7" href="'.$store_url.'/pages/product-recomendation" >Recommendation</a><br>';
                            } else {
                               $output .='<a class="PageHeader__Back Heading Text--subdued Link Link--primary u-h7 " href="'.$store_url.'/pages/questionnaire" >Questionnaire</a><br>';
                            }
                           $output.=' 
                           <a class="PageHeader__Back Heading Text--subdued Link Link--primary u-h7  my_menu my_order" href="/pages/my-order" >My Orders</a><br>
                            <a style="cursor: pointer;" class="PageHeader__Back Heading Text--subdued Link Link--primary u-h7 my_menu my_message" href="/pages/chats"  >
                                Messages
                            <span class="new_msg_unread"style="position: absolute;margin: -10px 0px 0px -2px;background-color: red;border-radius: 57%;width: auto;text-align: center;color: white;">
                            
                            </span>
                            </a><br>
                        </div>
                        
                        <div style="width: 80%;" >
                        <br>
                            <div id="HcpStaffList" >
                            </div>
                            
                        </div>
                    </div>
            </div>';
          
      }
       else if($customer['tags'] == 'Nutritionists'){
            // <a style="cursor: pointer;" class="PageHeader__Back Heading Text--subdued Link Link--primary u-h7 " >Orders</a><br>
            //     <a style="cursor: pointer;" class="PageHeader__Back Heading Text--subdued Link Link--primary u-h7 ">Messages</a><br>
           $output .=
            '<div class="Linklist">
                <h1 style="font-weight: 900 !important;text-align: center;padding-left: 20%;" class="Heading u-h1" >Welcome to ' . $customer['tags'] . ' Dashboard</h1>
                 <p style="font-size: 12px !important;" class="client_deatils_n_e SectionHeader--center"></p>
                <p  style="font-size: 12px !important;display:none;" class="custom_alert Form__Alert Alert Alert--success SectionHeader--center"></p>
                <div  class="Linklist__Item"  style="display:flex;justify-content: space-between;margin-top:4%" >
                    <div class="menu_list_items" >
                        
                        <a style="cursor: pointer;" class="PageHeader__Back Heading Text--subdued Link Link--primary u-h7 my_menu my_client" onclick="GetAllClientList()" >My Clients</a><br>
                    </div>
                    <div style="width: 83%;" id="HcpStaffList" >
                    </div>
                </div>
            </div>';
      }
      
      else if($customer['tags'] == 'HCPStaff'){
           $output .=
            '<div class="Linklist">
                <h1 style="font-weight: 900 !important;text-align: center;padding-left: 20%;" class="Heading u-h1" >Welcome to ' . $customer['tags'] . ' Dashboard</h1>
                 <p style="font-size: 12px !important;" class="client_deatils_n_e SectionHeader--center"></p>
                <p  style="font-size: 12px !important;display:none;" class="custom_alert Form__Alert Alert Alert--success SectionHeader--center"></p>
                <div  class="Linklist__Item"  style="display:flex;justify-content: space-between;margin-top:4%" >
                    <div class="menu_list_items" >
                        
                        <a style="cursor: pointer;" class="PageHeader__Back Heading Text--subdued Link Link--primary u-h7 my_menu my_h_client" onClick="GetHcpStaffClientList()" >My Clients</a><br>
                    
                            <a style="cursor: pointer;" class="PageHeader__Back Heading Text--subdued Link Link--primary u-h7 my_menu my_invoice" onclick="GetInvoiceList()" >MY INVOICES</a><br>
                            
                    </div>
                    <div style="width: 80%;" id="HcpStaffList" >
                    </div>
                </div>
            </div>';
      }
      else if($customer['tags'] == 'Client'){
           $output .=
            '<div  class="Linklist menu_list_items" >
            <h1 style="cursor: pointer;" >Dashboard</h1>
            
            </div>';
      }
      
    endforeach;

  echo($output);


?>



