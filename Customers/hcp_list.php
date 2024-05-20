<?php
require_once("../inc/db_connect.php");

$check_exists = $_GET['check_exists'];
    $output = '';
    $sql = "SELECT customer_id,sec_notes,first_name FROM Customers WHERE tags='HCP'";
    //  var_dump($sql);die();
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $output = '<div class="Form__Item compnay_slect_div">';
        if($check_exists === null){
        $output .='<select class="Form__Input Select_Company" id="Select_Company" name="Select_Company">';
      }else{
          $output .='<select class="Form__Input Select_Company" id="Select_Company" name="customer[note][Customer-HCP]">';
      }
        $output .=' <option selected disabled>Please select a Home Care provider</option>';
        
      while($row = $result->fetch_assoc()) {
         
            $hcp_id = $row['customer_id'];
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $getcompony_notes = $row['sec_notes'];
            $arr = explode("HCP-Company: ",$getcompony_notes);
            $compony=  $arr[1];
            if($compony == '')
            {
                $compony = $first_name.' '.$last_name;
            }
            if($hcp_id === '1357911'){
                
            }else{
                $output .='<option value="'.$hcp_id.'" >'.$compony.'</option>';
            }
       
      }
      
      if($check_exists === null)
      {
       $output .=' <option value="0" >Doesnot exist</option>';   
      }else{
          $output .=' <option value="1357911" >My Home Care Provider is not listed</option>'; 
      }
      $output .='</select>
                    <label class="Form__FloatingLabel">Select Company</label>
                </div>';
      
    } else {
      echo "0 results";
    }

echo $output;

?>