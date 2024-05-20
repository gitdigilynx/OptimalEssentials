<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $output = '';
   require_once("../inc/db_connect.php");
   
    $customerId =$_GET['customerId'];
    $message =$_GET['message'];
    $msg_customer_id =$_GET['msg_for'];
    
    // explode msg for and id
    $msg_customer_id =  explode("_",$msg_customer_id);
    $msg_for = $msg_customer_id[0];
    $msg_for_id = $msg_customer_id[1];
    
    $group_id =$_GET['group_id'];
    $created_date_time = date('d-m-Y h:i:A');
    // $date_current_exp = explode(" ",$created_date_time);
    // $time_of_current_date = $date_current_exp[1];
        $sql_udapted_check = "SELECT tags FROM Customers where customer_id=$customerId";
        $result_udapted_check = $conn->query($sql_udapted_check);
        
        if ($result_udapted_check->num_rows > 0) {
            $value_udapted_check = $result_udapted_check->fetch_assoc();
            $tage_check = $value_udapted_check['tags'];
            
            
            if($tage_check === 'HCPClient'){
                $sql_update_check = "customer_check";
            }else if($tage_check === 'Nutritionists'){
                $sql_update_check = "nutritionists__check";
                
            }else if($tage_check === 'HCP'){
                $sql_update_check = "hcp_check";
                
            }else if($tage_check === 'HCPStaff'){
                 $sql_update_check = "hcpstaff_check";
            }else if($tage_check === 'Admin'){
                 $sql_update_check = "admin_check";
            }
        
        if($tage_check === 'Admin'){
            $sql = "INSERT INTO chats (customer_id, message,msg_for, group_id,date_time,$sql_update_check,msg_for_id)
                VALUES ('$customerId', '$message','$msg_for', '$group_id','$created_date_time','1','$msg_for_id')";
        }else{
            $tage_check_mail = $tage_check.'_email';
            $sql = "INSERT INTO chats (customer_id, message,msg_for, group_id,date_time,$sql_update_check,$tage_check_mail,msg_for_id)
                VALUES ('$customerId', '$message','$msg_for', '$group_id','$created_date_time','1','1','$msg_for_id')";
        }
        
                 
            
            if ($conn->query($sql) === TRUE) {
              $output = '<div class="rtext align-self-end border rounded p-2 mb-1 w-auto">
                  <p style="margin-bottom: 0px; !important" class="text-danger">To - '.$msg_for.'</p>
                  <p class="">
    		    '.$message.' 
    		    <small class="d-block">'.$created_date_time.'</small>      	
    		</p>
		</div>';
		echo $output;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
        }
    
   
    
    
    
}





?>