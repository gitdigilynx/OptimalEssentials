<?php include('header.php');

require_once("../inc/db_connect.php");
$customer_id= $_GET['customer_id'];
$customer_email= $_GET['customer_email'];
$type= $_GET['type'];

$select_hcp_for_client = "SELECT * FROM Customers WHERE customer_id=$customer_id";
$result_of_hcp_for_client = $conn->query($select_hcp_for_client);
// $result_of_hcp_for_client
if($result_of_hcp_for_client->num_rows > 0) {
  // output data of each row
 $row = $result_of_hcp_for_client->fetch_assoc() ;
    $hcp_id = $row['hcp_id'];
    $hcp_staff_id = $row['staff_id'];

    
    
} else {
}


?>

<div class="container-fluid mt-5">
    <h3 class="text-center mb-4"> <?=$type?> HCP for "<?=$customer_email?>"</h3>
    <div class="mb-2" style="text-align:right;">
    <a href="customer_list.php"><button type="button" class="btn btn-primary"><i class="fa fa-chevron-circle-left"></i> Back</button></a>
</div>
    <hr>
</div>

<div class="w-75 m-auto">

    <div id="emailbodydiv">
        <form id="email_temp_form" >
            <div class="mb-3">
                <label for="from_ck" class="form-label">Assign HCP</label>
                
                
                
               <select id="select_assign_hcp" name="assign_hcp_select" class="form-select" aria-label="Default select example">
                   <option value="0" hidden >Select HCP</option>
                   <?php
                     $select_hcp_for_client = "SELECT * FROM Customers WHERE tags= 'HCP' ORDER BY id DESC;";
                    $result_of_hcp_for_client = $conn->query($select_hcp_for_client);
                    if ($result_of_hcp_for_client->num_rows > 0) {
                          while ($value_result_of_hcp_for_client = $result_of_hcp_for_client->fetch_assoc()) {
                              
                    //   add company other wise first name and secound name
                              $getcompony_notes = $value_result_of_hcp_for_client['sec_notes'];
                                  $arr = explode("HCP-Company: ",$getcompony_notes);
                                  $compony=  $arr[1];
                                  
                                  
                                  if($compony == null){
                                     
                                      
                                    $compony =  $value_result_of_hcp_for_client['first_name'].' '.$value_result_of_hcp_for_client['last_name'];
                                    
                                  }
                                  $compony_email = $compony.'('. $value_result_of_hcp_for_client['email'].')';
                                  if( $hcp_staff_id == null)
                                    {
    
                                          if($value_result_of_hcp_for_client['customer_id'] == $hcp_id)
                                          {
                                          ?>
                                              <option selected value="<?=$value_result_of_hcp_for_client['customer_id']?>" label="<?=$compony_email ?>" ></option>
                                          <?php
                                              
                                          } 
                                    }
                    ?>
                    <option value="<?=$value_result_of_hcp_for_client['customer_id']?>" label="<?=$compony_email ?>" ></option>
                    <?php
                    // select staff 
                                $hcp_id_for_staff = $value_result_of_hcp_for_client['customer_id'];
                                $select_staff_from_hcp = "SELECT * FROM Customers WHERE tags= 'HCPStaff' AND hcp_id='$hcp_id_for_staff' ORDER BY id DESC";
                                $result_of_select_staff_from_hcp = $conn->query($select_staff_from_hcp);
                        // ----staff ---
                                // $output .='<option > --Staff-- </option>';
                                if ($result_of_select_staff_from_hcp->num_rows > 0) {
                                    
                          while ($value_result_of_select_staff_from_hcp = $result_of_select_staff_from_hcp->fetch_assoc()) {
                                
                                if($hcp_staff_id == $value_result_of_select_staff_from_hcp['customer_id'] )
                                          {
                                          ?>
                                             <option selected value="<?=$value_result_of_select_staff_from_hcp['customer_id']?>">Staff > <?=$value_result_of_select_staff_from_hcp['first_name']?></option>;
                         
                                          <?php
                                              
                                          }else{
                                               ?>
                         
                                              
                                             <option value="<?=$value_result_of_select_staff_from_hcp['customer_id']?>">Staff > <?=$value_result_of_select_staff_from_hcp['first_name']?></option>;
                                      <?php     }
                             
                          }
                                    
                                }
                                   
                          }
                          }
                          ?>
                          </select>
                    
                
                </select>
                
            </div>
            <!--<div class="mb-3">-->
            <!--    <label for="subject_ck" class="form-label">Subject</label>-->
            <!--    <input type="text" class="form-control" name="subject_ck" id="subject_ck">-->
            <!--</div>-->
            <!--<div class="mb-3">-->
            <!--    <label for="Artical_Editor" class="form-label">Body </label>-->
            <!--    <textarea name="ArticalContent" id="Artical_Editor"></textarea>-->
            <!--</div>-->
            <!--<div class="mb-3">-->
            <!--    <input id="email_type_i" name="email_type_n" type="text" hidden>-->
               
            <!--</div>-->
            <div class="mb-3 text-center">
                <button type="button" class="btn btn-primary" title="Update" onClick ="updatehcpclient(<?=$row['customer_id'] ?>)">Update <i class="fa fa-chevron-circle-right"></i></button>
            </div>

        </form>
    </div>
</div>

<?php include('footer.php');?>