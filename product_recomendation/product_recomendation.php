<?php

require_once("../inc/db_connect.php");

require_once("../inc/functions.php");

require_once("../inc/store_credential.php");



$customer_id = $_GET['customer_id'];

// echo $customer_id;

// $customer_id = 6419716178176;

$output = '';



include('score.php');

// $output.='<header class="PageHeader">';

// $output.='

//           <div class="Container">

//             <div class="SectionHeader SectionHeader--center">

//               <h4 class="SectionHeader__Heading Heading Heading_apna u-h1">Thank you for completing the questionnaire.</h4></div>

//           </div>';

$sql_socre_template_products = "SELECT * FROM client_status WHERE status='$score_title'";
$result_socre_template_products = $conn->query($sql_socre_template_products);
if ($result_socre_template_products->num_rows > 0) {
  $value_socre_template_products = $result_socre_template_products->fetch_assoc();

  $content_from_client_status = $value_socre_template_products['template'];
  $product_id_from_client_status = $value_socre_template_products['product_ids'];

  $product_id_from_client_status_explodes = explode(',', $product_id_from_client_status);

  
}

$remove_variable_content = preg_replace('{{{score}}}', $score, $content_from_client_status);


// $output .= $dataa[0] . $score . $dataa[1] . $score_title . $dataa[2];





//  $output.='<div class="Container" style="margin-top: 2%;">

//                     <div class="SectionHeader SectionHeader--center">

//                       <p>Based on your answers below are your recommendations:</p>

//                       </div>

//                   </div>'; 



 $sql = "SELECT * FROM servey_table where customer_id=".$customer_id;

$sql_rec = "SELECT recommendation_id FROM servey_table where customer_id=".$customer_id;

$result_rec = $conn->query($sql_rec);

$recommendationArry = array();

  if ($result_rec->num_rows > 0){

      while ($value = $result_rec->fetch_assoc()){

            $recommendation_id = $value['recommendation_id'];

          //   echo  $recommendation_id;

            if(is_string($recommendation_id)){

              $recommendationids = explode(',',$recommendation_id);   

              for($id=0; $id < count($recommendationids); $id++){

                  if($recommendationids[$id] != ''){

                      $recommendation_id = $recommendationids[$id];



                      array_push($recommendationArry,$recommendation_id);

                  }

              } 



            } else {



              include('fetch_recommendation_from_table.php');

            }

            //$conn->close();

      } 

// export the elargic recommedation end

$sql_for_export_recomedation = "SELECT recommendation_id FROM servey_table where (question_id like '%Are you allergic to any of the following?%') AND (customer_id=$customer_id)";

$result_export_recomedation  = $conn->query($sql_for_export_recomedation);

$recomedationExportArry = array();

if ($result_export_recomedation->num_rows > 0) {

  $rows_export_recomedation = $result_export_recomedation->fetch_assoc();

  $value_export_recomedation = $rows_export_recomedation['recommendation_id'];

  if (is_string($value_export_recomedation)) {



    $export_recomedation_ids = explode(',', $value_export_recomedation);



    for ($id1 = 0; $id1 < count($export_recomedation_ids); $id1++) {



      if ($export_recomedation_ids[$id1] != '') {



        $value_export_recomedation = $export_recomedation_ids[$id1];



        array_push($recomedationExportArry, $value_export_recomedation);

      }

    }

  } else {

    array_push($recomedationExportArry, $value_export_recomedation);

  }

}







  $product_unique_ids = array_unique($productArry);

$recommendation_unique_ids = array_unique($recommendationArry);







for ($ipx1 = 0; $ipx1 < count($recommendation_unique_ids); $ipx1++) {



  for ($j1 = 0; $j1 < count($recomedationExportArry); $j1++) {

    if ($recommendation_unique_ids[$ipx1] == $recomedationExportArry[$j1]) {

      array_splice($recommendation_unique_ids, $ipx1, 1, []);

    }

  }

}



// export the elargic recommedation end

foreach($recommendation_unique_ids as $recommendation_unique_id) {

 $recommendation_id = $recommendation_unique_id;



 include('fetch_recommendation_from_table.php');

}





}else{

    echo 'empty';die();

}    


$remove_variable_content = preg_replace('{{{Product Recommendation}}}', $recommendation_content_from_table, $remove_variable_content); //s et recomendation to content

if($_GET['role_check']=== 'guest'){
    $chat_link ='<a class="new_window_open"  href="/pages/contact" target="_blank" rel="noopener noreferrer" style="color: RED;" >Message</a>';
    // $chat_link ='<a target="_blank" href="/pages/contact" class="Link Link--underline" style="color: RED;">Message</a>';
}else if($_GET['role_check'] === 'yes_customer'){
    $chat_link ='<a href="/account/register?product_recommend=true" class="Link Link--underline" style="color: RED;">Message</a>';
    }else{
    $chat_link ='<a href="/pages/chats" class="Link Link--underline" style="color: RED;">Message</a>';
}
$remove_variable_content = preg_replace('{{{LINK}}}', $chat_link, $remove_variable_content); // set chatting link

$output.='<div class="Container" style="margin-top: 2%;color: black;">

                    <div class="SectionHeader ">';

                     

                      


$output .= $remove_variable_content;   // add complete contend to out put
$output .= '</div></div>';  




$output .= '

          <div class="Container"style="margin-top: 2%;">

            <div class="SectionHeader SectionHeader--center">

              <h4 class="SectionHeader__Heading Heading Heading_apna u-h1">You are recommended with these products:</h4></div>

          </div>';

$output .= '</header>';



$output .= '<div class="Container"><div class="CollectionMain">

  <div class="CollectionInner">

  <div class="CollectionInner__Products">

  

                                <div style="text-align:center; margin-bottom: 5%;">

                                <input id="select_all" class="label_iput select_all_checkbox" type="checkbox" >

                                <label for="select_all" class="btn_label" style="/*! vertical-align: middle; */">

                                <span class="Button Button--primary" id="select_all" attr="Select All">Select All</span>

                                </label>

                                <span class="Button Button--primary add_to_cart" attr="add to cart">Add to cart</span>

                                <span class="Button Button--primary check_out_span" attr="add to cart" style="display:none;">Checkout</span>

                                </div>

                            

    <div class="ProductListWrapper">

      <div class="ProductList ProductList--grid  Grid" data-mobile-count="2" data-desktop-count="4">';



//  $sql = "SELECT * FROM servey_table where customer_id=".$customer_id;

$sql = "SELECT product_id FROM servey_table where customer_id=" . $customer_id;

$result = $conn->query($sql);

$productArry = array();

 foreach ($product_id_from_client_status_explodes as $product_id_from_client_status_explode) {
    array_push($productArry, $product_id_from_client_status_explode);
  }

if ($result->num_rows > 0) {



  while ($value = $result->fetch_assoc()) {







    $product_id = $value['product_id'];



    if (is_string($product_id)) {

      $productids = explode(',', $product_id);

      for ($id = 0; $id < count($productids); $id++) {

        if ($productids[$id] != '') {

          $product_id = $productids[$id];

          array_push($productArry, $product_id);
        }
      }
    } else {



      include('fetch_product_from_shopify.php');
    }

    //$conn->close();



  }



  // export the elargic product end

  $sql_for_export_product = "SELECT product_id FROM servey_table where (question_id like '%Are you allergic to any of the following?%') AND (customer_id=$customer_id)";

  $result_export_product  = $conn->query($sql_for_export_product);

  $productExportArry = array();

  if ($result_export_product->num_rows > 0) {

    $rows_export_product = $result_export_product->fetch_assoc();

    $value_export_product = $rows_export_product['product_id'];

    if (is_string($value_export_product)) {



      $export_product_ids = explode(',', $value_export_product);



      for ($id = 0; $id < count($export_product_ids); $id++) {



        if ($export_product_ids[$id] != '') {



          $value_export_product = $export_product_ids[$id];



          array_push($productExportArry, $value_export_product);
        }
      }
    } else {

      array_push($productExportArry, $value_export_product);
    }
  }




 

  $product_unique_ids = array_unique($productArry);



  $count_ceheckExport = 0;



  for ($ipx = 0; $ipx < count($product_unique_ids); $ipx++) {



    for ($j = 0; $j < count($productExportArry); $j++) {

      if ($product_unique_ids[$ipx] == $productExportArry[$j]) {

        array_splice($product_unique_ids, $ipx, 1, []);
      }
    }
  }





  // export the elargic product end

  $count_lable_check = 1;

  foreach ($product_unique_ids as $product_unique_id) {

    $product_id = $product_unique_id;

    $check_product_cartp = 'false';

    $check_varient_cartp = 'false';

    include('fetch_product_from_shopify.php');

    $count_lable_check++;
  }
}



$output .= '

     <div style="text-align:center;">

      <span class="Button Button--primary add_to_cart" attr="add to cart">Add to cart</span>

      <span class="Button Button--primary check_out_span" attr="add to cart" style="display:none;margin-left: 1%;">Checkout</span>

     </div>

</div>

</div>

</div>
</div>

</div>';

$conn->close();

echo ($output);
