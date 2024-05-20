

<?php

require_once("../inc/functions.php");
require_once("../inc/store_credential.php");

$customerId = $_GET['customerId'];



// https://your-development-store.myshopify.com/admin/api/2022-07/customers/207119551.json

  $customer1 = shopify_call($acess_token, $shop, "/admin/api/2022-07/customers/". $customerId.".json", array(), 'GET');
  $customer1 = json_decode($customer1['response'], JSON_PRETTY_PRINT);


  foreach ($customer1 as $customer) :
     $output .=
        '<div>
                  <h1>' . $customer['first_name'] . '</h1>
                  <td>' . $customer['email'] . '</td>
                  <td>' . $customer['tags'] . '</td>
              </div>';
              
               endforeach;
               if($customer['tags'] == 'kkkk')
               $output .= '<h3> hcashc<h3> ';

  echo($output);

?>



