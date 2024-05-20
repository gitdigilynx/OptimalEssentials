<?php

 
    if($role === 'customer_check'){
                
                $msg_for = 'Home Care Provider Client';
                
            }else if($role === 'nutritionists__check'){
                
                $msg_for = 'Nutritionists';
                
            }else if($role === 'hcp_check'){
                
                $msg_for = 'Home Care Provider (HCP)';
                
            }else if($role === 'hcpstaff_check'){
                
                 $msg_for = 'Home Care Provider Client';
                 
            }else if($role === 'admin_check'){
                
                 $msg_for = "OE Support";
                 
            }
    $sql_check_unread = "
    SELECT 
    id
    FROM 
    chats
    WHERE group_id=$group_id AND $role=0 AND msg_for='$msg_for'";
    $result_unread = $conn->query($sql_check_unread);
    if($result_unread->num_rows > 0){
        
        $total_unread = $result_unread->num_rows;
    }else{
        $total_unread = 0;
    }
?>