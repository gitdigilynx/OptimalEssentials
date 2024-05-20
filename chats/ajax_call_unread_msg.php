<?php
// if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    require_once("../inc/db_connect.php");
    $customer_id = $_GET['customer_id'];
    $group_id = $_GET['group_id'];
    $tag_value = '';
    $sql_update_check = '';
    $total_unread ='';
    $sql = "
    SELECT 
    tags
    FROM 
    Customers
    WHERE customer_id=$customer_id";
    // var_dump($sql);die();
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        
        $value = $result->fetch_assoc();
        $tage_check =  $value['tags'];
        
         if($tage_check === 'HCPClient'){
                $sql_update_check = "customer_check";
                $tag_value = 'Home Care Provider Client';
            }else if($tage_check === 'Nutritionists'){
                $sql_update_check = "nutritionists__check";
                $tag_value = 'Nutritionists';
                
            }else if($tage_check === 'HCP'){
                $sql_update_check = "hcp_check";
                $tag_value = 'Home Care Provider (HCP)';
                
            }else if($tage_check === 'HCPStaff'){
                
                 $sql_update_check = "hcpstaff_check";
                 $tag_value = 'Home Care Provider Client';
                 
            }else if($tage_check === 'Admin'){
                $tag_value = 'OE Support';
                 $sql_update_check = "admin_check";
            }
            if($tage_check != ''){
                $sql_check_unread = "
                SELECT 
                id
                FROM 
                chats
                WHERE group_id=$group_id AND $sql_update_check=0 AND msg_for='$tag_value'";
           
                $result_unread = $conn->query($sql_check_unread);
                if($result_unread->num_rows > 0){
                    $total_unread = $result_unread->num_rows;
                }else{
                    $total_unread = 0;
                }
                
            }
        echo $total_unread;
    }
?>