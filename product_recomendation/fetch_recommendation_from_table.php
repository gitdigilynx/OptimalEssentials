<?php

$sql_recdat = "SELECT * FROM product_recommendation where id=".$recommendation_id;
 
  $result_recdat = $conn->query($sql_recdat);

    if ($result_recdat->num_rows > 0){
        while ($value = $result_recdat->fetch_assoc()){
              $name = $value['name'];
              $product_benefits = $value['product_benefits'];
              if($checkquestionanswerlist_file){
                      $output .='
                  <div class=""  style="margin-top: 2%;">
                    <div class="SectionHeader SectionHeader--center">
                      <h4 class="SectionHeader__Heading Heading Heading_apna u-h1" >'.$name.'</span>.</h4></div>
                  </div>
                  <div class="">
                    <div class="SectionHeader SectionHeader--center">
                      <p style="text-align: left;" >'.$product_benefits.'</p>
                      </div>
                  </div>';
                  }else{
                       $recommendation_content_from_table .='
                  <div class=""  style="margin-top: 2%;">
                    <div class="SectionHeader SectionHeader--center">
                      <h4 class="SectionHeader__Heading Heading Heading_apna u-h1" >'.$name.'</span>.</h4></div>
                  </div>
                  <div class="">
                    <div class="SectionHeader SectionHeader--center">
                      <p style="text-align: left;" >'.$product_benefits.'</p>
                      </div>
                  </div>'; 
                  }
             
                  
                  
    }
  }    

?>