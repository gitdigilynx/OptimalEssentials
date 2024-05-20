<?php
    
    
    require_once("../inc/db_connect.php");
    
 
        $hcp_id = $_GET['customerId'];
        $bold_th_for_staff_data ='style="font-weight: 900 !important;"';
                    
     $sql2 = "SELECT * FROM Customers WHERE  tags= 'HCPStaff' AND hcp_id='$hcp_id'  ORDER BY id DESC";
     
    $result2 = $conn->query($sql2);
    $output .='<div class="TableWrapper">
    <table class="AccountTable Table Table--large">
  <thead class="Text--subdued">
    <tr>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email</th>
      <th>Role</th>
    </tr>
  </thead>
  <tbody class="Heading u-h7">
  
      <div class="scrollit">';
    if ($result2->num_rows > 0) {
        // output data of each row
        while ($value = $result2->fetch_assoc()) {
            
            $output .=
                '<tr>
                          <td>' . $value['first_name'] . '</td>
                          <td>' . $value['last_name'] . '</td>
                          <td>' . $value['email'] . '</td>
                          <td>' . $value['tags'] . '</td> 
                          <td>' . $value['sec_notes'] . '</td> 
                </tr>';

                    
             
            
        }
      
    } else {
        $output .=
                '<tr style="text-align:center;" >
                          <td   style="color: red;font-weight: 600;text-align: center;" colspan="4"> No Staff Added </td>
                </tr>';
    }
      $output .=' 
      </div>
        </tbody>
</table>
</div>';
    
    echo $output;
    
    
    

  

    
    
    
    
?>