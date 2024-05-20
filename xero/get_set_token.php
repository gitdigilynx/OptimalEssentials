<?php

include('../inc/db_connect.php');
function GetToken()
{
    global $conn;
    $sql_getData = "SELECT * FROM xero_token";
    $result_getData = $conn->query($sql_getData);

    if ($result_getData->num_rows > 0) {
        $value_getData = $result_getData->fetch_assoc();

        return ($value_getData);
    }
}

function SetNewToken()
{
    global $conn;
    $client_id = '252C68F7D6B24048BC8F15510AC17706';
    $client_secret = 'IcquOAqW4S2upRKiciv6TuU4lfVJ66wGibIeaolOagZLbh4p';
    $credentials_details = GetToken();
    $access_token = $credentials_details["access_token"];
    $talend_id = $credentials_details["talent_id"];
    $refresh_token = $credentials_details["refresh_token"];
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://identity.xero.com/connect/token",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "grant_type=refresh_token&refresh_token=" . $refresh_token . "&client_id=" . $client_id . "&client_secret=" . $client_secret,
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/x-www-form-urlencoded"
        ),
    ));

    $response = curl_exec($curl);
    $data =  json_decode($response, true);
    curl_close($curl);
    $new_asscess_token = $data['access_token'];
    $new_refresh_token = $data['refresh_token'];
    $sql_update = "UPDATE xero_token SET access_token='$new_asscess_token',refresh_token='$new_refresh_token' WHERE id=1";
    if ($conn->query($sql_update) === TRUE) {
        return "updated";
    } else {
        echo "Error: " . $sql_update . "<br>" . mysqli_error($conn);
    }
}


function CreateCustomer($hcp_details)
{
    // get access_token From DB
    $credentials_details = GetToken();
    $access_token = $credentials_details["access_token"];
    $talend_id = $credentials_details["talent_id"];


    $headers_query_email = [
        "Authorization: Bearer " . $access_token,
        "Accept:application/json",
        "Content-Type: application/json",
        "Xero-tenant-id: $talend_id"
    ];

        $data = [
        'Contacts' => [
            [
                
                'Name' => $hcp_details['hcp_email'], // Required
                'EmailAddress' => $hcp_details['hcp_email'], // Required
                'FirstName' => $hcp_details['first_name'], // Optional
                'LastName' => $hcp_details['hcp_lname'], // Optional
                "IsCustomer" => 'true',
                "Phones"=> [
                    [
                      "PhoneType"=> "MOBILE",
                      "PhoneNumber" => $hcp_details['hcp_customer_phone']
                    ]
                  ],
                  "Addresses"=> [
                    [
                      "AddressType"=> "STREET",
                      "AddressLine1"=> $hcp_details['hcp_address1'].' '.$hcp_details['hcp_address2'],
                      "City" => $hcp_details['hcp_city'],
                      "Region" => $hcp_details['region'],
                      "PostalCode"=> $hcp_details['hcp_zip'],
                      "Country"=> $hcp_details['hcp_country']
                    ]
                  ]
            ]
        ]
    ];
    

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.xero.com/api.xro/2.0/Contacts");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers_query_email);

    $result = curl_exec($ch);
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($statusCode == 200) {
        // success
        $response_data = json_decode($result, true);
        return $response_data;
    } else {
        // failure
        echo "Error posting data: " . $result;
    }
}


function CreateInvoice($contact_id, $line_item_array)
{
    $credentials_details = GetToken();
    $access_token = $credentials_details["access_token"];
    $talend_id = $credentials_details["talent_id"];

    // Set the request URL
    $url = 'https://api.xero.com/api.xro/2.0/Invoices';

    // Set the request method
    $method = 'POST';

    // Set the request headers
    $headers = [
        'Authorization: Bearer ' . $access_token,
        'Accept: application/json',
        'Content-Type: application/json',
        "Xero-tenant-id: $talend_id"
    ];

    $invoice_data = array(
        'Type' => 'ACCREC',
        'Contact' => array(
            'ContactID' => $contact_id
        ),
        'LineAmountTypes' => 'Inclusive',
        'LineItems' => $line_item_array
    );
    // Set the request body
    $body = json_encode($invoice_data);

    // Initialize curl
    $curl = curl_init();

    // Set curl options
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POSTFIELDS => $body,
    ]);

    // Execute the curl request
    $response = curl_exec($curl);

    // Check for errors
    if (curl_errno($curl)) {
        $error = curl_error($curl);
        // Handle the error
    } else {
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $response_data = json_decode($response, true);
        return $response_data;
        // Handle the response
    }

    // Close curl
    curl_close($curl);
}
