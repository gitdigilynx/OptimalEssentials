<?php

require_once("../inc/functions.php");
require_once("../inc/store_credential.php");


$customer_id = $_GET['customer_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $new_password = $_POST['password12'];
    $cnfirm_password = $_POST['confirm_password12'];

  
    
   $password = array(
          "customer"=>array(
              'id'=>$customer_id,
              'password'=> $new_password,
              'password_confirmation'=>$cnfirm_password    

          )
      );
    
    
    $customer1 = shopify_call($acess_token, $shop, "/admin/api/2022-07/customers/" . $customer_id.".json", $password, 'PUT');
    $customer1 = json_decode($customer1['response'], JSON_PRETTY_PRINT);
    
   echo 'success';
}

// $customer_id = '6481666900224';

//  $new_password = 'nasbalty01@gmail.com';
//     $cnfirm_password = 'nasbalty01@gmail.com';

  
    
//   $password = array(
//           "customer"=>array(
//               'id'=>$customer_id,
//               'password'=> $new_password,
//               'password_confirmation'=>$cnfirm_password    

//           )
//       );
    
    
//     $customer1 = shopify_call($acess_token, $shop, "/admin/api/2022-07/customers/" . $customer_id.".json", $password, 'PUT');
//     $customer1 = json_decode($customer1['response'], JSON_PRETTY_PRINT);
?>
