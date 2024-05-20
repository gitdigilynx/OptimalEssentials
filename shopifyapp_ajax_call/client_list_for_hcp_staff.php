<?php
    $output1 = '';
    $output = '';
    
    require_once("../inc/db_connect.php");
    
 $output1 .='
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
';
        $staff_id = $_GET['customerId'];
        $bold_th_for_staff_data ='style="font-weight: 900 !important;"';
                    
     $sql2 = "SELECT * FROM Customers WHERE  staff_id='$staff_id'  ORDER BY id DESC";
     $sql_for_client = "SELECT * FROM Customers WHERE tags='HCPClient'AND hcp_id='$staff_id'  ORDER BY id DESC";
     
    $result2 = $conn->query($sql2);
    $result_for_client = $conn->query($sql_for_client);
   
    if ($result2->num_rows > 0) {
        // output data of each row
         $output .='<div class="TableWrapper">
    <table style="white-space:nowrap !important;" class="AccountTable Table Table--large">
  <thead  class="Text--subdued">
    <tr>
      <th>No</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email</th>
      <th style="width: 38%;" >Action</th>
    </tr>
  </thead>
  <tbody class="Heading u-h7">';
        $count=1;
        while ($value = $result2->fetch_assoc()) {
            
            $customer_id_user = $value['customer_id'];
            $output .=
                '<tr>
                          <td>' . $count++ . '</td>
                          <td>' . $value['first_name'] . '</td>
                          <td>' . $value['last_name'] . '</td>
                          <td>' . $value['email'] . '</td>
                           <td>
                                <div style="display:flex;">
                                    <div class="btndesigndiv" >
                                        <a href="/pages/customer-qa-view?client_id='.$value['customer_id'].'" class="Link Link--underline" >Questionnaire</a>
                                    </div>
                                        <div class="btndesigndiv">';
                                        
                                        $sql_check_order ="SELECT id,order_approval_status FROM customer_order WHERE customer_id='$customer_id_user' AND order_approval_status='pending' ORDER BY id DESC LIMIT 1";
                                        $result__check_order = $conn->query($sql_check_order);
                                        if($result__check_order->num_rows > 0){
                                            $output .='<a style="color: red;" href="/pages/my-order?client_id_s='.$value['customer_id'].'"  class="Link Link--underline" >View Orders</a>';
                                        }else{
                                            $output .='<a href="/pages/my-order?client_id_s='.$value['customer_id'].'"  class="Link Link--underline" >View Orders</a>';
                                        }
                                        
                                    $output .='</div>
                                        <div class="btndesigndiv" >
                                        <a  class="Link Link--underline" href="/pages/chats?group_id='.$value['customer_id'].'"  >Messages</a>
                                    </div>
                                   
                                </div>
                            </td> 
                          
                </tr>';

                    
             
            
        }
      
    } else if($result_for_client->num_rows > 0){
         $count=1;
          $output .='<div class="TableWrapper">
    <table style="white-space:nowrap !important;" class="AccountTable Table Table--large">
  <thead  class="Text--subdued">
    <tr>
      <th>No</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email</th>
      <th style="width: 38%;">Assign Staff</th>
      <th >Action</th>
    </tr>
  </thead>
  <tbody class="Heading u-h7">';
        while ($value = $result_for_client->fetch_assoc()) {
           $customer_id =  $value['customer_id'];
            $output .=
                '<tr>
                          <td>' . $count++ . '</td>
                          <td>' . $value['first_name'] . '</td>
                          <td>' . $value['last_name'] . '</td>
                          <td>' . $value['email'] . '</td>
                          
                          
                          <td >
                            <select class="Form__Input hcpstaff_'.$count.'" id="hcpstaff" name="hcpstaff">
                                <option value="0" selected="" disabled="">Select staff</option>';
                            
                            $sql_for_staff = "SELECT * FROM Customers WHERE  tags='HCPStaff' AND hcp_id='$staff_id'  ORDER BY id DESC";
                            $result_hcp_staff = $conn->query($sql_for_staff);
                             if ($result_hcp_staff->num_rows > 0) {
                                 while ($value_hcp_staff = $result_hcp_staff->fetch_assoc()) {
                                     $hcp_staff_id = $value_hcp_staff['customer_id'];
                                     $hcp_staff_first_name =  $value_hcp_staff['first_name'];
                                     $hcp_staff_last_name =   $value_hcp_staff['last_name'];
                                     if($hcp_staff_id == $value['staff_id']){
                                         $output .= '<option value="'.$hcp_staff_id.'_'.$customer_id.'" selected >'.$hcp_staff_first_name.' '.$hcp_staff_last_name.'</option>';
                                     }else{
                                         $output .= '<option value="'.$hcp_staff_id.'_'.$customer_id.'">'.$hcp_staff_first_name.' '.$hcp_staff_last_name.'</option>';
                                     }
                                 }
                             }else{
                                 
                             }
                            $group_id = $value['customer_id'];
                            $role = 'hcp_check'; // this is hard role for admin as we know this is admin page
                            include("../chats/get_unread_chats.php"); // check the unread messages of user
                            
                            $output .='
                            </select>
                            </td>
                          
                           <td>
                                <div style="display:flex;">
                                    <div class="btndesigndiv" >
                                        <a href="/pages/customer-qa-view?client_id='.$value['customer_id'].'" class="Link Link--underline" >Questionnaire</a>
                                    </div>
                                          <div class="btndesigndiv">';
                                        
                                        $sql_check_order ="SELECT id,order_approval_status FROM customer_order WHERE customer_id='$customer_id' AND order_approval_status='pending' ORDER BY id DESC LIMIT 1";
                                        $result__check_order = $conn->query($sql_check_order);
                                        if($result__check_order->num_rows > 0){
                                            $output .='<a style="color: red;" href="/pages/my-order?client_id_s='.$value['customer_id'].'"  class="Link Link--underline" >View Orders</a>';
                                        }else{
                                            $output .='<a href="/pages/my-order?client_id_s='.$value['customer_id'].'"  class="Link Link--underline" >View Orders</a>';
                                        }
                                        
                                    $output .='</div>
                                        <div class="btndesigndiv" >
                                        <a  class="Link Link--underline btn_msg_hcp" href="/pages/chats?group_id='.$value['customer_id'].'" >
                                            Messages
                                            <span class="new_msg_unread_hcp" id="unread_'.$value['customer_id'].'" group_id="'.$value['customer_id'].'" style="position: absolute;margin: -10px 0px 0px -2px;background-color: red;border-radius: 57%;width: auto;text-align: center;color: white;">
                                            ';if($total_unread != 0) $output.= $total_unread;
                                $output.='</span>
                                            </span>
                                        </a>
                                    </div>
                                        <div class="btndesigndiv" >
                                        
                                            <a style="cursor: pointer; " id="'.$count.'" class="Link Link--underline assigned_staff_click" >Assign Staff</a>
                                    </div>
                                   
                                </div>
                            </td> 
                            
                          
                </tr>';

                    
             
            
        }
        
    }else {
        $output .=
                '<div class="TableWrapper">
    <table style="white-space:nowrap !important;" class="AccountTable Table Table--large">
  <thead  class="Text--subdued">
    <tr>
      <th>No</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email</th>
      <th>Assign Staff</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody class="Heading u-h7"><tr style="text-align:center;" >
                          <td   style="color: red;font-weight: 600;text-align: center;" colspan="6"> No Client Assigned </td>
                </tr>';
    }
      $output .='  
        </tbody>
</table>
</div>';
    
    echo $output;
    
    
    

  

    
    
    
    
?>