<?php
require_once("../inc/db_connect.php");
$output = '';
$nutril_assign_check = '';
$sql2 = "SELECT * FROM Customers WHERE assigned_check=1 AND tags= 'HCPClient' ORDER BY id DESC";
    $result2 = $conn->query($sql2);

    if ($result2->num_rows > 0) {
        // output data of each row
        $index = 1;
        while ($value = $result2->fetch_assoc()) {
            $nutril_assign_check = $value['assign_nutritionist'];
            
            $select_hcp_for_client = "SELECT * FROM Customers WHERE tags='Nutritionists' ORDER BY id DESC;";
            $result_of_hcp_for_client = $conn->query($select_hcp_for_client);
            $client_id = 'client_'.$value['customer_id'];
            $output .=
                '<tr id="nutritionists_tr_'.$client_id.'">     <td>' . $index . '</td>
                          <td>' . $value['first_name'] . '</td>
                          <td>' . $value['last_name'] . '</td>
                         <td>' . $value['email'] . '</td>
                         <td>' . $value['tags'] . '</td>
                          <td> 
                          <select class="form-select w-100 " id=nutritionists_select_'. $value['customer_id'] .'  aria-label="Default select example">';
                          if ($result_of_hcp_for_client->num_rows > 0) {
                              $output .='<option disabled selected >Select option below</option>' ;
                                   
                          while ($value_result_of_hcp_for_client = $result_of_hcp_for_client->fetch_assoc()) {
                              
                              $nuti_first_name = $value_result_of_hcp_for_client['first_name'];
                              $nuti_last_tname = $value_result_of_hcp_for_client['last_name'];
                              $nuti_email_tname = $value_result_of_hcp_for_client['email'];
                              $nuti_id = $value_result_of_hcp_for_client['customer_id'];
                            
                                if($nutril_assign_check == $nuti_id){
                                    $output .='<option value='.$nuti_id.' selected >'. $nuti_first_name .' ' .$nuti_last_tname.'('.$nuti_email_tname.')</option>' ;
                                }else{
                                    $output .='<option value='.$nuti_id.' label="" >'. $nuti_first_name .' ' .$nuti_last_tname.'('.$nuti_email_tname.')</option>' ;
                                }
                          }
                          }
                           $output .= '</select>
                          </td>
                          <td> 
                            <div class="d-flex">
                                <button type="button" class="btn btn-primary" title="Update" onClick ="update_nutritionist_to_client('. $value['customer_id'] .')">
                                    Update <i class="fa fa-chevron-circle-right"></i>
                                </button> 
                            </div>
                          </td>';
                          

                    
             
            
           $output .= '</tr>';
           
           $index++;
        }
        
    }else{
        $output = 'error';
    }
echo $output;
?>