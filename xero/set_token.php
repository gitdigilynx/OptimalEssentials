<?php

require_once('get_set_token.php');
$check_token_valid = true;
$credentials_details= GetToken();
$access_token = $credentials_details["access_token"];
$talent_id = $credentials_details["talent_id"];

session_start();

$headers = [
    "Authorization: Bearer " . $access_token,
    "Accept:application/json",
    "Content-Type: application/json",
    "Xero-tenant-id: $talent_id"
];

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.xero.com/api.xro/2.0/Contacts",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => $headers,
]);
$response = curl_exec($curl);
$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);
if ($status != 200) {
    $status_accesstoken_update = SetNewToken();
    if($status_accesstoken_update != 'updated'){

        echo 'Failed Updating access Token of Xero.com';
        die();
    }
} 
?>