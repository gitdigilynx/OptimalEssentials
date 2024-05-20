<?php
require_once('set_token.php');
require_once('get_set_token.php');


$credentials_details= GetToken();
$access_token = $credentials_details["access_token"];
$talend_id = $credentials_details["talent_id"];

$headers_query_email = [
    "Authorization: Bearer " . $access_token,
    "Accept:application/json",
    "Content-Type: application/json",
    "Xero-tenant-id: $talend_id"
];


// var_dump(CreateInvoice('ll','lo'));die();

$ch = curl_init();
$email = $hcp_details['hcp_email'];

curl_setopt($ch, CURLOPT_URL, 'https://api.xero.com/api.xro/2.0/Contacts?where=EmailAddress=="'.$email.'"');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers_query_email);

$response = curl_exec($ch);
// var_dump($response);
curl_close($ch);

$response = json_decode($response, true);
$contacts = $response['Contacts'];
if(count($contacts) > 0){
// var_dump($contacts[0]['ContactID']);die();
$contact_id =$contacts[0]['ContactID'];

$invoice_xero_reponse = CreateInvoice($contact_id,$line_item_xero_array);
if($invoice_xero_reponse['Status']=== 'OK'){
    $invoice_xero_invoice_res =  'OK';
}else{
    $output_array[0] = 'xero_failed';
    $output_array[1] = 'Failed to create invoice on xero';
    echo json_encode($output_array);die();
}
}else{
    $customer_create_xero_res = CreateCustomer($hcp_details);
    if($customer_create_xero_res['Status']){
        $invoice_xero_reponse = CreateInvoice($contact_id,$line_item_xero_array);
        if($invoice_xero_reponse['Status']=== 'OK'){
            $invoice_xero_invoice_res =  'OK';
        }else{
            $output_array[0] = 'xero_failed';
            $output_array[1] = 'Failed to create invoice on xero';
            echo json_encode($output_array);die();
        }
    }else{
        $output_array[0] = 'xero_failed';
        $output_array[1] = 'Failed to create Contact on xero';
        echo json_encode($output_array);die();
    }
}
?>