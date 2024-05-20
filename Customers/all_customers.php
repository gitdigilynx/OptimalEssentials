<?php
$NewValue = [];
$count = 1;
$output = '';
$role = $_GET['role'];

if ($role == "hcp") {
  $role_value = "HCP";
} else if ($role == "hcp_client") {
  $role_value = "HCPClient";
} else if ($role == "nutri") {
  $role_value = "Nutritionists";
} else if ($role == "un") {
  $role_value = "HCPClient";
} else if ($role == "all") {
  $role_value = "all";
}

require_once("../inc/functions.php");
require_once("../inc/store_credential.php");
if ($role_value == "all") {

  $customers = shopify_call($acess_token, $shop, "/admin/api/2022-07/customers.json", array(), 'GET');
  $customers = json_decode($customers['response'], JSON_PRETTY_PRINT);
  foreach ($customers as $customer) :
    foreach ($customer as $key => $value) :
      $output .=
        '<tr>
                  <td>' . $value['first_name'] . '</td>
                  <td>' . $value['last_name'] . '</td>
                  <td>' . $value['email'] . '</td>
                  <td>' . $value['tags'] . '</td>
              </tr>';
    endforeach;

  endforeach;

  echo ($output);
} else {
  $customer1 = shopify_call($acess_token, $shop, "/admin/api/2022-07/customers/search.json?query=tag:" . $role_value, array(), 'GET');
  $customer1 = json_decode($customer1['response'], JSON_PRETTY_PRINT);

  // print_r($customer1);
  // exit();

  foreach ($customer1 as $customer) :
    foreach ($customer as $key => $value) :
      $output .=
        '<tr>
        <td>' . $value['first_name'] . '</td>
        <td>' . $value['last_name'] . '</td>
        <td>' . $value['email'] . '</td>
        <td>' . $value['tags'] . '</td>
              </tr>';
    endforeach;

  endforeach;

  echo ($output);
}
