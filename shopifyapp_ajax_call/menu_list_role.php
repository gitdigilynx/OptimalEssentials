

<?php

require_once("../inc/functions.php");
require_once("../inc/store_credential.php");

$customerId = $_GET['customerId'];



// https://your-development-store.myshopify.com/admin/api/2022-07/customers/207119551.json

  $customer1 = shopify_call($acess_token, $shop, "/admin/api/2022-07/customers/". $customerId.".json", array(), 'GET');
  $customer1 = json_decode($customer1['response'], JSON_PRETTY_PRINT);

  foreach ($customer1 as $customer) :
      
      if($customer['tags'] == 'HCP'){
          $output .=
            '<div class="Linklist"  >
                    <div class="Linklist__Item" style="display: flex;justify-content: space-between;" >
                        <div>
                            <a style="cursor: pointer;" class="PageHeader__Back Heading Text--subdued Link Link--primary u-h7" onclick="GetHCPClientList()" >MY CLIENTS</a><br>
                            <a style="cursor: pointer;" class="PageHeader__Back Heading Text--subdued Link Link--primary u-h7" onclick="GetInvoiceList()" >MY INVOICES</a><br>
                            <a style="cursor: pointer;" class="PageHeader__Back Heading Text--subdued Link Link--primary u-h7" onclick="GetHCPStaffList()" >MY STAFF </a><br>
                      
                            <a  class="PageHeader__Back Heading Text--subdued Link Link--primary u-h7" href="/pages/hcp-billing-address" >Billing Address</a><br>
                        </div>
                        
                        <div style="width: 80%;" >
                            
                            <div id="HcpStaffList" >
                            </div>
                            
                        </div>
                    </div>
            </div>';
      }
      else if($customer['tags'] == 'HCPClient'){
          $output .=
            '<div class="Linklist" >';
               // include the required files
            require_once("../inc/db_connect.php");
            $sql = "SELECT id FROM servey_table WHERE customer_id=$customerId";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
               $output .='<a class="PageHeader__Back Heading Text--subdued Link Link--primary u-h7" href="pages/product-recomendation" >Questionnaire</a><br>';
            } else {
               $output .='<a class="PageHeader__Back Heading Text--subdued Link Link--primary u-h7" href="/pages/questionnaire" >Questionnaire</a><br>';
            }
             $output .=
            '<a class="PageHeader__Back Heading Text--subdued Link Link--primary u-h7" href="/pages/my-order" >My Orders</a><br>
            <a style="cursor: pointer;" class="PageHeader__Back Heading Text--subdued Link Link--primary u-h7" >Messages</a><br>
            </div>';
          
      }
       else if($customer['tags'] == 'Nutritionists'){
           $output .=
            '<div  class="Linklist" >
               
                <a style="cursor: pointer;" class="PageHeader__Back Heading Text--subdued Link Link--primary u-h7" >Orders</a><br>
                <a style="cursor: pointer;" class="PageHeader__Back Heading Text--subdued Link Link--primary u-h7">Messages</a><br>
            </div>';
      }
      
      else if($customer['tags'] == 'HCPStaff'){
           $output .=
            '<div>
                <div  class="Linklist"  style="display:flex;justify-content: space-between;" >
                    <div  >
                        
                        <a style="cursor: pointer;" class="PageHeader__Back Heading Text--subdued Link Link--primary u-h7" onClick="GetHcpStaffClientList()" >My Clients</a><br>
                    </div>
                    <div style="width: 80%;" id="HcpStaffList" >
                    </div>
                </div>
            </div>';
      }
      else if($customer['tags'] == 'Client'){
           $output .=
            '<div  class="Linklist" >
            <h1 style="cursor: pointer;" >Dashboard</h1>
            
            </div>';
      }
      
    endforeach;

  echo($output);


?>



