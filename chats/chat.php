<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    require_once("../inc/db_connect.php");
    
    
$output = '';
$customer_tag='';
$tag_value = '';
$staff_check = '';
if($_GET['customerId']){
    
$customerId = $_GET['customerId'];

$sql_tag_customer = "SELECT tags,staff_id,assign_nutritionist FROM Customers WHERE customer_id=$customerId";
$result_tag_customer = $conn->query($sql_tag_customer);
if($result_tag_customer->num_rows > 0){
    $value_tag_customer = $result_tag_customer->fetch_assoc();
    $customer_tag = $value_tag_customer['tags'];
}


}
 if($customer_tag === 'HCP'){
     $tag_value = 'Home Care Provider (HCP)';
          }else if($customer_tag === 'HCPClient'){
            //   $staff_check = $value_tag_customer['staff_id'];
            //   $assign_nutritionist = $value_tag_customer['assign_nutritionist'];
              $tag_value = 'Home Care Provider Client';
          }else if($customer_tag === 'Admin'){
              $tag_value = 'OE Support';
          }else if($customer_tag === 'Nutritionists'){
              $tag_value = 'Dietician';
          }else if($customer_tag === 'HCPStaff'){
              $tag_value = 'Home Care Provider Staff';
          }
          
$group_id = $_GET['group_id'];

$sql = "SELECT
DISTINCT
chat.message,
customers_reciver.first_name as letname,
chat.msg_for,
chat.msg_for_id,
chat.customer_id,
chat.date_time,
customers.first_name,
customers.last_name,
customers.tags
FROM 
chats  as chat
LEFT JOIN Customers as customers
ON customers.customer_id = chat.customer_id

LEFT JOIN Customers as customers_reciver
ON chat.msg_for_id = customers_reciver.customer_id

WHERE (chat.group_id=$group_id) 
AND (chat.msg_for = '$tag_value' OR  chat.customer_id =$customerId)
ORDER BY chat.id ASC"; 
$result = $conn->query($sql);

?>
<div class="w-400 shadow p-4 rounded">

    <div>
        <h3 class="text-center">Messages</h3>
    </div>
    <div class="d-flex align-items-center">

    </div>

    <div class="shadow p-4 rounded d-flex flex-column mt-2 chat-box" id="chatBox">
        <?php
        if($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['customer_id'] == $customerId) { 
                // $date_current_exp = explode(" ",$row['date_time']);
                // $time_of_current_date = $date_current_exp[1];
                ?>
                <div class="rtext align-self-end border rounded p-2 mb-1 w-auto">
                    <p style="margin-bottom: 0px; !important" class="text-danger">To - <?= $row['msg_for']?></p>
                    <p class="">
                        <?= $row['message'] ?>
                        <small class="d-block">
                            <?=$row['date_time'] ?>
                        </small>
                    </p>
                </div>
                <?php } else { ?>
                <div class="ltext align-self-start border  rounded p-2 mb-1 w-auto">
                    <?php
                     if($row['tags'] === 'Admin'){
                         ?>   
                             <p style="margin-bottom: 0px; !important" class="text-dark fw-bolder" >OE Support</p>
                        <?php
                         
                     }else{
                         ?>
                            <p style="margin-bottom: 0px; !important" class="text-dark fw-bolder" ><?=$row['first_name'].' '.$row['last_name'].' - '.$row['tags']?></p>
                        <?php
                         
                     }
                     ?>
                   
                    <p >
                        <?= $row['message'] ?>
                        <small class="d-block">
                            <?=$row['date_time'] ?>
                        </small>
                        
                        <small class="text-dark">
                        Attention! 
                    </small>
                    <?=$row['letname']?>
                    </p>
                    
                    </div>
            <?php }
            }
        } else { ?>
            <div class="alert alert-info text-center m-auto w-50 infor_empty_msg">
                <i class="fa fa-comments d-block fs-big"></i>
                No messages yet, Start the conversation
            </div>
        <?php } ?>
    </div>
    <div class="mb-3 d-flex">
         <select aria-label="Default select example" class="form-select w-25 to_msg_frp">
          <option disabled selected>To</option>
          <?php 
          if($customer_tag === 'HCP'){
              ?>
            <option value="OE Support_1122334455">OE Support</option>
            <option value="Home Care Provider Client_<?=$group_id?>">Home Care Provider Client</option>
              <?php
          }else if($customer_tag === 'HCPClient'){
              ?>
            <option value="OE Support_1122334455">OE Support</option>
              <?php
          }else if($customer_tag === 'Admin'){
              ?>
            
            <option value="Home Care Provider Client_<?=$group_id?>">Home Care Provider Client</option>
              <?php
          }else if($customer_tag === 'Nutritionists'){
              ?>
            <option value="OE Support_1122334455">OE Support</option>
            <option value="Home Care Provider Client_<?=$group_id?>">Home Care Provider Client</option>
            
              <?php
          }else if($customer_tag === 'HCPStaff'){
              ?>
            <option value="OE Support_1122334455">OE Support</option>
            <option value="Home Care Provider Client_<?=$group_id?>">Home Care Provider Client</option>
              <?php
          }
          
          $sql_check_staff_nutri = "SELECT staff_id,assign_nutritionist,hcp_id FROM Customers WHERE customer_id=$group_id";
            $result_check_staff_nutri = $conn->query($sql_check_staff_nutri);
            if($result_check_staff_nutri->num_rows > 0){
                $value_check_staff_nutri = $result_check_staff_nutri->fetch_assoc();
                $staff_check = $value_check_staff_nutri['staff_id'];
                $assign_nutritionist = $value_check_staff_nutri['assign_nutritionist'];
                $hcp_id = $value_check_staff_nutri['hcp_id'];
                
            }
          
           if($hcp_id != ''){
            if(!($customer_tag === 'HCP')){
            ?>
              <option value="Home Care Provider (HCP)_<?=$hcp_id?>">Home Care Provider (HCP)</option>
            <?php
                
            }
          }
          if($staff_check != ''){
             if(!($customer_tag === 'HCPStaff')){
            ?>
              <option value="Home Care Provider Staff_<?=$staff_check?>">Home Care Provider Staff</option>
            <?php
             }
            
          }
          if($assign_nutritionist != ''){
            if(!($customer_tag === 'Nutritionists')){
            ?>
              <option value="Dietician_<?=$assign_nutritionist?>">Dietician</option>
            <?php
                
            }
          }
          
         
          ?>
          
          
          
        </select>
        <textarea cols="3" id="message" class="form-control"></textarea>
        <button class="btn btn-primary sendBtn" id="sendBtn">
            <i class="fa fa-paper-plane"></i>
        </button>
    </div>

</div>

<?php
}
require_once("update_chat.php");
?>