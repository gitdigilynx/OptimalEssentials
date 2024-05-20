<?php


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    require_once("../inc/db_connect.php");
    $customer_email = $_GET['customerEmail'];
    
    $sql = "SELECT id FROM Customers WHERE email='$customer_email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      // output data of each row
      echo 'exists';
    } else {
      echo 'not-exists';
    }
    
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
   
   
    
    // include the required files
        require_once("../inc/db_connect.php");
        require_once("../inc/functions.php");
        require_once("../inc/store_credential.php");
        


    // get the hcp staff
        $get_hcp_staff_data1 = $_POST;
        // var_dump($get_hcp_staff_data1);die();
        $get_hcp_staff_data = $_POST['customer'];
        $get_hcp_id = $get_hcp_staff_data['hcp_id'];
        
        
        // var_dump($get_hcp_staff_data['last_name']);die();
        
    // add data to array 
    $modify_data = array(
	"customer" => array(
		"first_name" => $get_hcp_staff_data['first_name'],
		"last_name" => $get_hcp_staff_data['last_name'],
		"email" => $get_hcp_staff_data['email'],
		"tags" => $get_hcp_staff_data['tags'],
		"password" => $get_hcp_staff_data['password'],
		"password_confirmation" => $get_hcp_staff_data['password']
	)
);
       


    // save data into shopify api
    // https://your-development-store.myshopify.com/admin/api/2022-01/customers.json

        $hcp_staff = shopify_call($acess_token, $shop, "/admin/api/2022-07/customers.json", $modify_data, 'POST');
        $hcp_staff = json_decode($hcp_staff['response'], JSON_PRETTY_PRINT);
            
            if($hcp_staff)
            {
                if($get_hcp_id)  // condition for add the Nutritionists
                {
                    
                
                        // add staff start
                foreach ($hcp_staff as $value) :
                    
                        
                $first_name = mysqli_real_escape_string($conn,$value['first_name']);
                $last_name = mysqli_real_escape_string($conn,$value['last_name']);
                $email = mysqli_real_escape_string($conn,$value['email']);
                $tags = mysqli_real_escape_string($conn,$value['tags']);
                $note = mysqli_real_escape_string($conn,$value['note']);
                           $sql = "INSERT INTO Customers (customer_id, first_name, last_name,email,tags,sec_notes,hcp_id)
                            VALUES ('$value[id]', '$first_name', '$last_name','$email','$tags','$note','$get_hcp_id')";
                             
                            if ($conn->query($sql) === TRUE) {
                                // echo "New record created successfully";
                                header("Location: https://optimal-essentials-dev.myshopify.com/account?menu=my_staff");
                            }else {
                                echo "Error: " . $sql . "<br>" . $conn->error;
                            }
                    endforeach;
                            // add staff ennd
                }else{
                    
                    // condition to add the Nutritionists start
                     foreach ($hcp_staff as $value) :
                        
                        
              
                           $sql = "INSERT INTO Customers (customer_id, first_name, last_name,email,tags,sec_notes)
                            VALUES ('$value[id]', '$value[first_name]', '$value[last_name]','$value[email]','$value[tags]','$value[note]')";
                             
                            if ($conn->query($sql) === TRUE) {
                                // echo "New record created successfully";
                                header("Location: https://app.optimalessentials.com.au/optimalessentials/Customers/customer_list.php?check_nutritionists=nutritionists");
                            }else {
                                echo "Error: " . $sql . "<br>" . $conn->error;
                            }
                    endforeach;
                    // condition to add the Nutritionists start
                }
            }
        
        

}

?>