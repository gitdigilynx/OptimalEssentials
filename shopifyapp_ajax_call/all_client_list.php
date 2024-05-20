<?php

require_once("../inc/db_connect.php");

$customer_id = $_GET['customer_id'];
$output = '';
// sql for all Client
$sql = "SELECT DISTINCT
st.customer_id,
customer.first_name,
customer.last_name,
customer.email
FROM 

servey_table as st

LEFT JOIN Customers as customer
ON st.customer_id=customer.customer_id

WHERE customer.tags='HCPClient' AND assign_nutritionist=$customer_id
ORDER BY customer.id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    


        // output data of each row
        $output .= '<div class="TableWrapper">
                            <table style="white-space:nowrap !important;" class="AccountTable Table Table--large" id="All_client_table">
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
        $count = 1;
        while ($value = $result->fetch_assoc()) {
            $output .=
                '<tr>
                          <td>' . $count++ . '</td>
                          <td>' . $value['first_name'] . '</td>
                          <td>' . $value['last_name'] . '</td>
                          <td>' . $value['email'] . '</td>
                           <td>
                                <div style="display:flex;">
                                    <div class="btndesigndiv" >
                                        <a href="/pages/customer-qa-view?client_id=' . $value['customer_id'] . '" class="Link Link--underline" >Questionnaire</a>
                                    </div>
                                        <div class="btndesigndiv">
                                        <a href="/pages/my-order?client_id_s=' . $value['customer_id'] . '"  class="Link Link--underline" >View Orders</a>
                                    </div>
                                        <div class="btndesigndiv" >
                                        <a  class="Link Link--underline" href="/pages/chats?group_id=' . $value['customer_id'] . '"  >
                                            Messages
                                            <span class="new_msg_unread_hcp" id="unread_'.$value['customer_id'].'" group_id="'.$value['customer_id'].'" style="position: absolute;margin: -10px 0px 0px -2px;background-color: red;border-radius: 57%;width: auto;text-align: center;color: white;">
                                          
                                            </span>
                                            </span>
                                        </a>
                                    </div>
                                   
                                </div>
                            </td> 
                          
                </tr>';
        }
    
    echo $output;
} else {
    echo 'No record found';
}




?>