<?php


require_once("../inc/functions.php");
require_once("../inc/store_credential.php");


  $customers = shopify_call($acess_token, $shop, "/admin/api/2022-07/customers/6373374591232.json", array(), 'GET');
//   $customers = json_decode($customers['response'], JSON_PRETTY_PRINT);
  
  var_dump( $customers);
  ?>