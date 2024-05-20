<?php

 // include the required files
    require_once("../inc/db_connect.php");
    require_once("../inc/functions.php");
    require_once("../inc/store_credential.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    //  var_dump($_POST);die();
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $tags = $_POST['tags'];
        $hcp_question = $_POST['hcp_question'];
        $output_array = [];
        
     
        if($email === 'guest')
        {
                    if($hcp_question)
                        {
                            $Select_Company = $_POST['Select_Company'];
                            
                            if($Select_Company == '0')
                            {
                                $company_name = $_POST['company_name'];
                                $company_email = $_POST['company_email'];
                                $to = $company_email;
                                // create hcp on shopify start
                                
                                // create random password start
                                    function rand_passwd( $length = 8, $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789' ) {
                                        return substr( str_shuffle( $chars ), 0, $length );
                                    }
                                    
                                    $hcp_password = rand_passwd();
                                
                                // create random password end
                                
                                
                                       // add data to array 
                                            $modify_data = array(
                                        	"customer" => array(
                                        		"first_name" => $company_name,
                                        		"email" => $company_email,
                                        		"note" => 'Secondary-FirstName: 
Secondary-LastName: 
Secondary-Email: 
Secondary-PhoneNumber: 
HCP-Company: '.$company_name.'',
                                        		"tags" => 'HCP',
                                        		"password" => $hcp_password,
                                        		"password_confirmation" => $hcp_password
                                        	)
                                        );
                                        
                                        $hcp_creates = shopify_call($acess_token, $shop, "/admin/api/2022-07/customers.json", $modify_data, 'POST');
                                        $hcp_creates = json_decode($hcp_creates['response'], JSON_PRETTY_PRINT);
                                        
                                        foreach($hcp_creates as $hcp_create)
                                        {
                                            $Select_Company = $hcp_create['id'];
                                        }
                                // create hcp on shopify end
                                
                                // send mail ti hcp start
                                
                                
                                require_once("../send_mail/create_home_care_provider_email.php");
                                
                                // send mail ti hcp end
                                 
                            }
                            $sql = "INSERT INTO Customers (email,tags,assigned_check,hcp_id)
                            VALUES ('$email','$tags','1','$Select_Company')";
                            
                        }else{
                        $sql = "INSERT INTO Customers (email,tags)
                            VALUES ('$email','$tags')";  
                        }
                          if ($conn->query($sql) === TRUE) {
                                $last_id = $conn->insert_id;
                                $sql_update = "UPDATE Customers SET customer_id='$last_id' WHERE id=$last_id";
                
                                    if ($conn->query($sql_update) === TRUE) {
                                        
                                      $output_array[0] = 'Client';
                                      $output_array[1] = $last_id;
                                      
                                      echo json_encode($output_array);
                                    } else {
                                      echo "Error updating record: " . $conn->error;
                                    }
                            } else {
                              echo "Error: " . $sql . "<br>" . $conn->error;
                            }
                    
                
                            
        }else{
            
        
        // check for guest client start
        
        $sql_select = "SELECT id,customer_id,email FROM Customers WHERE tags='Client' AND email LIKE '%$email%'";
        $result_select = $conn->query($sql_select);
        
        if ($result_select->num_rows > 0) {
          // output data of each row
            $row = $result_select->fetch_assoc();
            $output_array[0] = 'exsists';
            $output_array[1] = $row['customer_id'];
            $output_array[2] = $row['email'];
          echo json_encode($output_array);
          
        } else{
        
                    // check for HCPclient start
                    
                    $sql_hcpclient = "SELECT id,customer_id,email,tags FROM Customers WHERE tags='HCPClient' AND email LIKE '%$email%'";
                    $result_hcpclient  = $conn->query($sql_hcpclient);
                    
                    if ($result_hcpclient->num_rows > 0) {
                      // output data of each row
                        $rowhcpclient  = $result_hcpclient->fetch_assoc();
                        $output_array[0] = $rowhcpclient['tags'];
                      echo json_encode($output_array);
                      
                    } 
                    
                    // check for HCPclient end
                    else {
                       
                    }
                }
    }
}
?>