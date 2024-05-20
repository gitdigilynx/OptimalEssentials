<?php

require_once("../inc/db_connect.php");
require_once("../inc/functions.php");
require_once("../inc/store_credential.php");


$webhook = shopify_call($acess_token, $shop, "/admin/api/2022-07/webhooks/1189268127989.json", array(), 'DELETE');
$webhook = json_decode($webhook['response'], JSON_PRETTY_PRINT);

echo print_r($webhook );




?>