<?php



$sql_update_check ='';
   $sql_udapted_check = "SELECT tags FROM Customers where customer_id=$customerId";
        $result_udapted_check = $conn->query($sql_udapted_check);
        if($result_udapted_check){
            
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
            if($tage_check != ''){
                $chemailtag = $tage_check.'_email';
                if($tage_check === 'Admin'){
                    
                $sql_update_check = "UPDATE chats SET $sql_update_check='1' WHERE group_id=$group_id";
                }else{
                    
                $sql_update_check = "UPDATE chats SET $sql_update_check='1',$chemailtag='1' WHERE group_id=$group_id";
                }
           
             if ($conn->query($sql_update_check) === TRUE) {
      
                } else {
                  echo "Error updating record: " . $conn->error;
                }
            }
            
}
        }

    
    
   


?>