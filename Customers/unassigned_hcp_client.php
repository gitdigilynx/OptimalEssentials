<?php
$NewValue = [];
$count = 1;
$output = '';

$role = $_GET['Role'];


if ($role == "hcp") {
    $role_value = "HCP";
} else if ($role == "hcp_client") {
    $role_value = "HCPClient";
} else if ($role == "nutri") {
    $role_value = "Nutritionists";
} else if ($role == "un") {
    $role_value = "UnAssigned";
} else if ($role == "all") {
    $role_value = "all";
}


require_once("../inc/db_connect.php");





if ($role_value == "all") {

    $sql1 = "SELECT * FROM Customers ORDER BY id DESC;";
    $result1 = $conn->query($sql1);

    if ($result1->num_rows > 0) {
        // output data of each row
        $index = 1;
        while ($value = $result1->fetch_assoc()) {
            $output .=
                '<tr>     <td>' . $index . '</td>
                          <td>' . $value['first_name'] . '</td>
                          <td>' . $value['first_name'] . '</td>
                          <td>' . $value['email'] . '</td>
                      </tr>';
            $index++;
        }
    } else {
        echo "0 results";
    }

    echo $output;
} else if ($role_value == "UnAssigned") {

    $sql2 = "SELECT * FROM Customers WHERE assigned_check=0 AND tags= 'HCPClient' OR tags= 'Client' ORDER BY id DESC;";
    $result2 = $conn->query($sql2);

    if ($result2->num_rows > 0) {
        // output data of each row
        $index = 1;
        while ($value = $result2->fetch_assoc()) {
            
            $select_hcp_for_client = "SELECT * FROM Customers WHERE tags= 'HCP' ORDER BY id DESC;";
            $result_of_hcp_for_client = $conn->query($select_hcp_for_client);
            $client_id = 'client_'.$value['customer_id'];
            $output .=
                '<tr id="unassign_tr_'.$client_id.'">     <td>' . $index . '</td>
                          <td>' . $value['first_name'] . '</td>
                          <td>' . $value['last_name'] . '</td>
                         <td>' . $value['email'] . '</td>
                         <td>' . $value['tags'] . '</td>
                          <td> 
                          <select class="form-select w-100 " id='. $value['customer_id'] .'  aria-label="Default select example">
                          <option selected disabled > Please select an Home Care Provide (HCP)';
                          if ($result_of_hcp_for_client->num_rows > 0) {
                          while ($value_result_of_hcp_for_client = $result_of_hcp_for_client->fetch_assoc()) {
                              
                    //   add company other wise first name and secound name
                              $getcompony_notes = $value_result_of_hcp_for_client['sec_notes'];
                                  $arr = explode("HCP-Company: ",$getcompony_notes);
                                  $compony=  $arr[1];
                                  
                                  
                                  if($compony == null){
                                     
                                      
                                    $compony =  $value_result_of_hcp_for_client['first_name'].' '.$value_result_of_hcp_for_client['last_name'];
                                    
                                  }
                                  $compony_email = $compony.' ('. $value_result_of_hcp_for_client['email'].')';
                                  
                             //   end
                                  
                                $output .='<option value='.$value_result_of_hcp_for_client['customer_id'].' label="'. $compony_email .'" ></option>' ;
                                
                        // select staff 
                                $hcp_id_for_staff = $value_result_of_hcp_for_client['customer_id'];
                                $select_staff_from_hcp = "SELECT * FROM Customers WHERE tags= 'HCPStaff' AND hcp_id='$hcp_id_for_staff' ORDER BY id DESC";
                                $result_of_select_staff_from_hcp = $conn->query($select_staff_from_hcp);
                        // ----staff ---
                                // $output .='<option > --Staff-- </option>';
                                if ($result_of_select_staff_from_hcp->num_rows > 0) {
                                    
                          while ($value_result_of_select_staff_from_hcp = $result_of_select_staff_from_hcp->fetch_assoc()) {
                              
                              $output .='<option value='. $value_result_of_select_staff_from_hcp['customer_id'].'>Staff > ' . $value_result_of_select_staff_from_hcp['first_name'] . '</option>';
                          }
                                    
                                }
                                   
                          }
                          }
                           $output .= '</select>
                          </td>
                          <td> 
                            <div class="d-flex">
                                <button type="button" class="btn btn-primary" title="Update" onClick ="myFunction('. $value['customer_id'] .')">
                                    Update <i class="fa fa-chevron-circle-right"></i>
                                </button> 
                                <button type="button" class="btn btn-danger ms-2" title="Delete" onClick ="delete_customer('. $value['customer_id'] .')">
                                    Delete <i class="fa fa-trash"></i>
                                </button> 
                            </div>
                          </td>';
                          

                    
             
            
           $output .= '</tr>';
           
           $index++;
        }
    } else {
        echo "0 results";
    }

    echo $output;
} else {

    $sql2 = "SELECT * FROM Customers WHERE tags= '{$role_value}' ORDER BY id DESC;";
    $result2 = $conn->query($sql2);

    if ($result2->num_rows > 0) {
        // output data of each row
        $index = 1;
        while ($value = $result2->fetch_assoc()) {
           
           
                          
                          if($role_value == 'HCPClient')
                          {
                              $assigned_check_value = $value['assigned_check'];
                              if($assigned_check_value == 1){
                              $assign_role = 0;
                              $HCPClient_name_query = "SELECT * FROM Customers WHERE (assigned_check='$assign_role') AND (customer_id='{$value['hcp_id']}')";
                              
                                    $result_HCPClient_name_query = $conn->query($HCPClient_name_query);
                                    
                            if($result_HCPClient_name_query->num_rows > 0)
                            {
                            $result_HCPClient_fetct_data = $result_HCPClient_name_query->fetch_assoc();
                           
                               
                                $getcompony_notes = $result_HCPClient_fetct_data['sec_notes'];
                                  $arr = explode("HCP-Company: ",$getcompony_notes);
                                  $compony=  $arr[1];
                                  
                                  
                                  if($compony == null){
                                     
                                      
                                    $compony =  $result_HCPClient_fetct_data['first_name'].' '.$result_HCPClient_fetct_data['last_name'];
                                    
                                  }
                                  $compony_email = $compony.' ('. $result_HCPClient_fetct_data['email'].')';
                                  
                                  $first_lst_email = $value['first_name'].' '.$value['last_name'].' ('. $result_HCPClient_fetct_data['email'].')';
                                  
                              
                             $output .=  ' <tr>     <td>' . $index . '</td>
                          <td>' . $value['first_name'] . '</td>
                          <td>' . $value['last_name'] . '</td>
                          <td>' . $value['email'] . '</td>
                             <td>' . $compony_email . '</td>
                             <td><a href="edit_client_hcp.php?customer_id=' . $value['customer_id']. '&customer_email=' . $first_lst_email. '&type=Edit"><button type="button" class="btn btn-primary" ><i class="fa fa-edit" aria-hidden="true"></i> Edit</button></a> </td>';
                             
                            }
                            // else{
                            //     $output .=  '
                            //     <td>Not yet</td>
                            //  <td><a href="edit_client_hcp.php?customer_id=' . $value['customer_id']. '&customer_email=' . $value['email']. '&type=Add"><button type="button" class="btn btn-primary" ><i class="fa fa-chevron-circle-right"></i> Add</button></a> </td>';
                            // }
                          }
                           
                          }
                          
                          
                          if($role_value == 'HCP')
                          {
                              $getcompony_notes = $value['sec_notes'];
                                  $arr = explode("HCP-Company: ",$getcompony_notes);
                                  $compony=  $arr[1];
                                  $compony_with_name=  $arr[1];
                                  
                                  
                                  if($compony == null){
                                     
                                      
                                    $compony1 =  $value['first_name'].' '.$value['last_name'];
                                    
                                  }
                                  if($compony_with_name == null){
                                     
                                      
                                   $compony_with_name =  $value['first_name'].' '.$value['last_name'];
                                    
                                  }
                                  $compony_email = $compony;
                                  $compony_with_name = $compony_with_name.' ('. $value['email'].')';
                              
                             $output .=  '<tr>     <td>' . $index . '</td>
                          <td>' . $value['first_name'] . '</td>
                          <td>' . $value['last_name'] . '</td>
                          <td>' . $value['email'] . '</td>
                             <td>' . $compony_email . '</td>';
                                    $output .= '
                                    <td><a href="hcp_staffs_clients.php?customer_id=' . $value['customer_id']. '&customer_role=HCPClient&customer_email=' . $compony_with_name.' "><button type="button" class="btn btn-primary" ><i class="fa fa-eye" aria-hidden="true"></i> View</button></a> </td>
                                    <td><a href="hcp_staffs_clients.php?customer_id=' . $value['customer_id']. '&customer_role=HCPStaff &customer_email=' . $compony_with_name.'"><button type="button" class="btn btn-primary" ><i class="fa fa-eye" aria-hidden="true"></i> View</button></a> </td>';
                          }
                        //   Nutritionists
                        if($role_value == 'Nutritionists')
                          {
                              
                             $output .=  '<tr>     <td>' . $index . '</td>
                          <td>' . $value['first_name'] . '</td>
                          <td>' . $value['last_name'] . '</td>
                          <td>' . $value['email'] . '</td>
                             ';
                          }
                          
                     $output .='</tr>';
                     $index++;
        }
    } else {
        echo "0 results";
    }

    echo $output;
}
