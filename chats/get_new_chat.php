<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {


require_once("../inc/db_connect.php");

    $customerId = $_GET['customerId'];
    $group_id = $_GET['group_id'];
    $staff_check = '';
    $tage_check_hcp ='';
    $output = '';
    $tag_value = '';
    $sql_update_check ='';

    $sql_udapted_check = "SELECT tags,first_name,last_name,staff_id FROM Customers where customer_id=$customerId";
        $result_udapted_check = $conn->query($sql_udapted_check);
       
        if ($result_udapted_check->num_rows > 0) {
            $value_udapted_check = $result_udapted_check->fetch_assoc();
               $tage_check_hcp = $value_udapted_check['tags'];
               
            
            if($tage_check_hcp === 'HCPClient'){
                
                $tag_value = 'Home Care Provider Client';
                $sql_update_check = 'customer_check';
            }else if($tage_check_hcp === 'Nutritionists'){
                $tag_value = 'Nutritionists';
                $sql_update_check = "nutritionists__check";
                
            }else if($tage_check_hcp === 'HCP'){
                $tag_value = 'Home Care Provider (HCP)';
                $sql_update_check = "hcp_check";
                // $sql_update_check = "UPDATE chats SET hcp_check='1' WHERE group_id=$group_id";
            }else if($tage_check_hcp === 'HCPStaff'){
                $sql_update_check = "hcpstaff_check";
                $tag_value = "Home Care Provider Staff";
            }else if($tage_check_hcp === 'Admin'){
                $tag_value = 'OE Support';
                 $sql_update_check = "admin_check";
            }
            
            
            // now check the unread messages in same group start
            
                $sql ="SELECT 
                chat.id,
                customers_reciver.first_name as letname,
                chat.message,
                chat.msg_for,
                chat.date_time,
                customers.first_name,
                customers.last_name,
                customers.tags
                FROM 
                chats as chat 
                LEFT JOIN Customers as customers
                ON chat.customer_id=customers.customer_id
                
                LEFT JOIN Customers as customers_reciver
                ON chat.msg_for_id = customers_reciver.customer_id
                
                WHERE chat.group_id=$group_id AND chat.$sql_update_check=0 AND chat.msg_for='$tag_value'";
               
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()){
                        $chat_id = $row['id'];
                        $message = $row['message'];
                        $msg_for = $row['msg_for'];
                        $msg_for_id = $row['letname'];
                        $date_time = $row['date_time'];
                        $name_user = $row['first_name'];
                        $last_user = $row['last_name'];
                        $tage_check = $row['tags'];
                        $output .='<div class="ltext align-self-start border  rounded p-2 mb-1 w-auto">';
                        if($tage_check === 'Admin'){
                            
                            $output .='<p style="margin-bottom: 0px; !important" class="text-dark fw-bolder" >OE Support</p>';
                        }else{
                            $output .='<p style="margin-bottom: 0px; !important" class="text-dark fw-bolder" >'.$name_user.' '.$last_user.' - '.$tage_check.'</p>';
                        }
                       $output .='<p class="">
                        '.$message.'
                        <small class="d-block">
                            '.$date_time.'
                        </small>
                        <small class="text-dark">
                        Attention! 
                    </small>
                    '.$msg_for_id.'
                    </p>
                    </div>';
                    if($tage_check_hcp != ''){
                        
                    
                        if($tage_check_hcp === 'Admin'){
                            $sql_update_check = "UPDATE chats SET $sql_update_check='1' WHERE id=$chat_id AND msg_for='$tag_value'";
                        }else{
                            $tage_check_hcp = $tage_check_hcp.'_email';
                            $sql_update_check = "UPDATE chats SET $sql_update_check='1',$tage_check_hcp='1' WHERE id=$chat_id AND msg_for='$tag_value'";
                        }
                        
                         if ($conn->query($sql_update_check) === TRUE) {
         
                                echo $output;
                            } else {
                              echo "Error updating record: " . $conn->error;
                            }
                    }
                    }
                }
            
            // now check the unread messages in same group end
            
            
            
}
}else{
    echo 'error';
}


?>