<?php


require_once("../inc/functions.php");
require_once("../inc/store_credential.php");


$store_url = 'https://optimal-essentials-dev.myshopify.com';

$draft_order_id ='1109685666048';
// $data = array(
//     'draft_order' => array(
//         'id' => $draft_order_id,
//         'payment_gateway_id' => 'gid://shopify/PaymentGateway/85665906944',
        
//     )
// );

$data = array(
  'draft_order' => array(
    'id' => $draft_order_id,
    'note' => 'Mark as paid by Xero.com',
  )
);
$data2 = array(
  'draft_order' => array(
    'id' => $draft_order_id,
  )
);



    $update_draft_order_note = shopify_call($acess_token, $shop, "/admin/api/2022-07/draft_orders/" . $draft_order_id . ".json", $data,'PUT');
    $update_draft_order_note = json_decode($update_draft_order_note['response'], JSON_PRETTY_PRINT);

    // if($update_draft_order_note['errors']){
    //     $output[0] = 0;
    //     $output[1] = 'Unable to updating draft order notes';
    // }else{
         $update_draft_order_note2 = shopify_call($acess_token, $shop, "/admin/api/2022-07/draft_orders/" . $draft_order_id . "/complete.json", $data2,'PUT');
        $update_draft_order_note2 = json_decode($update_draft_order_note2['response'], JSON_PRETTY_PRINT);
        echo '<pre>';
        var_dump($update_draft_order_note2);
        // if($update_draft_order_note2['errors']){
        //     $output[0] = 0;
        //     $output[1] = 'Unable to mark draft as complete';
        // }
    // }
    
    

?>