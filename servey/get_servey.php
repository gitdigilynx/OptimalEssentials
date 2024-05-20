<?php

require_once("../inc/db_connect.php");

$customer_id = $_GET['customer_id'];
$output = '';
$sql = "SELECT * FROM question_hard";
$result = $conn->query($sql);

if ($result->num_rows > 0) :

    $count_q = 1;

    while ($value = $result->fetch_assoc()) :


        $output .= '<div class="tab' . $count_q . ' box" style="display:none;">
                    <div class="p-3 m_top-body body_servey">';


        if ($value['id'] == 15) {
            $multi_gues = explode("Y/N", $value['questions']);
            $output .= '<div class="row">
                                     <div class="col-12 fw-bold text-center">
                                          <textarea  type="text" class="label_iput" name="question' . $count_q . '">' . $value['questions'] . '</textarea>
                                          
                                           <h2 class="Heading Heading_apna text-center">' . $multi_gues[0] . '</h2>
                                           
                                         <div class = "multi_question">
                                           <input id="multi_1" class="label_iput count_yes" type="radio" value="Yes">
                                            <label for="multi_1" class="btn_label">
                                            <span class="input-group-text rounded-pill btn btn-lg btn-outline-warning  btn_check btn_margin" id="option1">Yes</span>
                                           </label>
                                           <input id="multi_2" class="label_iput count_yes" type="radio" value="No">
                                            <label for="multi_2" class="btn_label">
                                            <span class="input-group-text rounded-pill btn btn-lg btn-outline-warning btn_check btn_margin" id="option2" >No</span>
                                           </label>
                                          </div>
                                            
                                          <h2 class="Heading Heading_apna text-center">' . $multi_gues[1] . '</h2>
                                          
                                          <div class = "multi_question">
                                          <input id="multi_3" class="label_iput count_yes" type="radio" value="Yes">
                                            <label for="multi_3" class="btn_label">
                                            <span class="input-group-text rounded-pill btn btn-lg btn-outline-warning  btn_check btn_margin" id="option3">Yes</span>
                                           </label>
                                           <input id="multi_4" class="label_iput count_yes" type="radio" value="No">
                                            <label for="multi_4" class="btn_label">
                                            <span class="input-group-text rounded-pill btn btn-lg btn-outline-warning btn_check btn_margin" id="option4">No</span>
                                           </label>
                                          </div>
                                           
                                          <h2 class="Heading Heading_apna text-center">' . $multi_gues[2] . '</h2>
                                         
                                         <div class = "multi_question" style="margin-bottom: -6%;">
                                          <input id="multi_5" class="label_iput count_yes" type="radio" value="Yes">
                                            <label for="multi_5" class="btn_label">
                                            <span class="input-group-text rounded-pill btn btn-lg btn-outline-warning  btn_check btn_margin" id="option5">Yes</span>
                                           </label>
                                           <input id="multi_6" class="label_iput count_yes" type="radio" value="No">
                                            <label for="multi_6" class="btn_label">
                                            <span class="input-group-text rounded-pill btn btn-lg btn-outline-warning btn_check btn_margin" id="option6">No</span>
                                           </label>
                                          </div>
                                           
                                     </div>
                                 </div>';
        } else {
            $question_text_area = $value['questions'];
            $output .= '<div class="row text-center">
                                     <div class="col-12 fw-bold">
                                          <textarea  type="text" class="label_iput" id="questiontextarea' . $count_q . '" name="question' . $count_q . '">' . $value['questions'] . '</textarea>
                                          <h2 class="Heading Heading_apna text-center">' . $value['questions'] . '</h2>
                                     </div>
                                 </div>';
        }

        $output .= '</div>';



        $sql_for_answer = "SELECT * FROM answers WHERE question_id=$value[id]";
        $result_sql_for_answer = $conn->query($sql_for_answer);



        $output .= '<div class="p-5 footer_servey">
         
                                     <div class="row text-center">';
        $count_a = 1;
        if ($value['id'] == 10) {
            
            $sql_height_weight = "SELECT answer_id FROM servey_table WHERE customer_id=$customer_id AND question_id='$question_text_area'";
            $result_height_weight = $conn->query($sql_height_weight);
            if($result_height_weight->num_rows > 0 )
            {
                $value_height_weight = $result_height_weight->fetch_assoc();
                $answer_bmi_cal = $value_height_weight['answer_id'];
                
                $my_array_h_w = explode("~",$answer_bmi_cal);
                $height = $my_array_h_w[0];
                $weight = $my_array_h_w[1];
                
                 $output .= '
                                                <div class="row">
                                                 <div class="col-1">
                                                    
                                                 </div>
                                                 <div class="col-4">
                                                     <label class="text_design" for="inputPassword4" >Height in cm</label>
                                                      <input type="number" class=" Form__Input shadow-none" id="BMI_height" value="'.$height.'" placeholder="Height in cm">
                                                    
                                                 </div>
                                                 <div class="col-4">
                                                     <label class="text_design" for="inputPassword4" >Weight in kg</label>
                                                      <input type="number" class="Form__Input shadow-none" id="BMI_weight"  value="'.$weight.'" placeholder="Weight in kg">
                                                    
                                                 </div>
                                                 <div class="col-3" style="text-align: left; padding-left: 1px;">
                                                     
                                                      <span class="Button Button--primary btn_conform" id ="calculate_BMI">Confirm</span>&nbsp&nbsp
                                                       <span class="Button Button--primary btn_conform" id="calculate_BMI_skip">Skip</span>
                                                    
                                                 </div>
                                                 
                                                 </div>';
                
            }else{
                
           


            $output .= '
                                                <div class="row">
                                                 <div class="col-1">
                                                    
                                                 </div>
                                                 <div class="col-4">
                                                     <label class="text_design" for="inputPassword4" >Height in cm</label>
                                                      <input type="number" class=" Form__Input shadow-none" id="BMI_height"  placeholder="Height in cm">
                                                    
                                                 </div>
                                                 <div class="col-4">
                                                     <label class="text_design" for="inputPassword4" >Weight in kg</label>
                                                      <input type="number" class="Form__Input shadow-none" id="BMI_weight" placeholder="Weight in kg">
                                                    
                                                 </div>
                                                 <div class="col-3" style="text-align: left; padding-left: 1px;">
                                                     
                                                      <span class="Button Button--primary btn_conform" id ="calculate_BMI">Confirm</span>&nbsp&nbsp
                                                       <span class="Button Button--primary btn_conform" id="calculate_BMI_skip">Skip</span>
                                                    
                                                 </div>
                                                 
                                                 </div>';
            }
        }

        if ($value['id'] == 15) {

            $output .= '
                                                     <div class="input-group  input-group-lg">
                                                      <span class="Button Button--primary btn_conform btn_check btn_margin" 
                                                      id ="calculate_yes_no" style="margin: auto;">Confirm</span>
                                                    </div>';
        }

        if ($result_sql_for_answer->num_rows > 0) {
            $output .= '<div class="col-12" id="idcol' . $count_q . '" >';
            while ($value_result_sql_for_answer = $result_sql_for_answer->fetch_assoc()) :

                $sql_select_survey = "SELECT * FROM servey_table WHERE customer_id=$customer_id AND question_id='$question_text_area'";
                $result_select_survey = $conn->query($sql_select_survey);
                if ($value['id'] == 23) {
                    
                    if ($result_select_survey->num_rows > 0) {
                         $value_select_survey = $result_select_survey->fetch_assoc();
                         $multiple_ans_check = $value_select_survey['answer_id'];
                         $multiple_ans_check_exps = explode(",",$multiple_ans_check); // explode answer
                         $check_loop_status = false; 
                        //  now check the matching answer
                         foreach($multiple_ans_check_exps as $multiple_ans_check_exp)
                         {
                             if($multiple_ans_check_exp == $value_result_sql_for_answer['answer'])
                             {
                                 $check_loop_status = true;
                             }
                             
                         }
                         
                         if($check_loop_status)
                         {
                              $output .=  '<input id="id' . $count_q . '' . $count_a . '" class="label_iput total_chekbox_cheked" type="checkbox" 
                                             value="' . $value_result_sql_for_answer['answer'] . '_' . $value_result_sql_for_answer['product'] . '_' . $value_result_sql_for_answer['recommendation_id'] . '_' . $value_result_sql_for_answer['score'] . '_' . $customer_id . '" checked>
                                             
                                             <label for="id' . $count_q . '' . $count_a . '" class="btn_label" style = "vertical-align: middle;">
                                             <span class="active Button Button--primary  btn_check btn_margin total_chekbox_button  class' . $count_q . '' . $count_a . '" attr ="' . $value_result_sql_for_answer['answer'] . '" >' . $value_result_sql_for_answer['answer'] . '</span>
                                             </label>';
                         }else{
                             $output .=  '<input id="id' . $count_q . '' . $count_a . '" class="label_iput total_chekbox_cheked" type="checkbox" 
                                             value="' . $value_result_sql_for_answer['answer'] . '_' . $value_result_sql_for_answer['product'] . '_' . $value_result_sql_for_answer['recommendation_id'] . '_' . $value_result_sql_for_answer['score'] . '_' . $customer_id . '" >
                                             
                                             <label for="id' . $count_q . '' . $count_a . '" class="btn_label" style = "vertical-align: middle;">
                                             <span class="Button Button--primary  btn_check btn_margin total_chekbox_button  class' . $count_q . '' . $count_a . '" attr ="' . $value_result_sql_for_answer['answer'] . '" >' . $value_result_sql_for_answer['answer'] . '</span>
                                             </label>';
                         }
                        
                    }else{
                        
                    $output .=  '<input id="id' . $count_q . '' . $count_a . '" class="label_iput total_chekbox_cheked" type="checkbox" 
                                             value="' . $value_result_sql_for_answer['answer'] . '_' . $value_result_sql_for_answer['product'] . '_' . $value_result_sql_for_answer['recommendation_id'] . '_' . $value_result_sql_for_answer['score'] . '_' . $customer_id . '" >
                                             
                                             <label for="id' . $count_q . '' . $count_a . '" class="btn_label" style = "vertical-align: middle;">
                                             <span class="Button Button--primary  btn_check btn_margin total_chekbox_button  class' . $count_q . '' . $count_a . '" attr ="' . $value_result_sql_for_answer['answer'] . '" >' . $value_result_sql_for_answer['answer'] . '</span>
                                             </label>';
                    }
                } else {

                    //   check if the question and user exsists in the servey table
                    //   check if the question and user exsists in the servey table query

                    $sql_select_survey = "SELECT * FROM servey_table WHERE customer_id=$customer_id AND question_id='$question_text_area'";
                    $result_select_survey = $conn->query($sql_select_survey);
                    if ($result_select_survey->num_rows > 0) {
                        $value_select_survey = $result_select_survey->fetch_assoc();
                        if ($value_result_sql_for_answer['answer'] == $value_select_survey['answer_id']) {
                            $output .=  '<input id="id' . $count_q . '' . $count_a . '" class="label_iput" type="checkbox" 
                                                     value="' . $value_result_sql_for_answer['answer'] . '_' . $value_result_sql_for_answer['product'] . '_' . $value_result_sql_for_answer['recommendation_id'] . '_' . $value_result_sql_for_answer['score'] . '_' . $customer_id . '" 
                                                     name="answer' . $count_q . '' . $count_a . '" checked>
                                                     
                                                     <label for="id' . $count_q . '' . $count_a . '" class="btn_label" style = "vertical-align: middle;">
                                                     <span class="Button Button--primary btn_conform btn_check btn_margin btn_margin class' . $count_q . '' . $count_a . ' active" attr ="' . $value_result_sql_for_answer['answer'] . '" >' . $value_result_sql_for_answer['answer'] . '</span>
                                                     </label>
                                                     &nbsp&nbsp';
                        } else {



                            $output .=  '<input id="id' . $count_q . '' . $count_a . '" class="label_iput" type="checkbox" 
                                             value="' . $value_result_sql_for_answer['answer'] . '_' . $value_result_sql_for_answer['product'] . '_' . $value_result_sql_for_answer['recommendation_id'] . '_' . $value_result_sql_for_answer['score'] . '_' . $customer_id . '" 
                                             name="answer' . $count_q . '' . $count_a . '">
                                             
                                             <label for="id' . $count_q . '' . $count_a . '" class="btn_label" style = "vertical-align: middle;">
                                             <span class="Button Button--primary btn_conform btn_check btn_margin btn_margin class' . $count_q . '' . $count_a . '" attr ="' . $value_result_sql_for_answer['answer'] . '" >' . $value_result_sql_for_answer['answer'] . '</span>
                                             </label>
                                             &nbsp&nbsp';
                        }
                    } else {
                        $output .=  '<input id="id' . $count_q . '' . $count_a . '" class="label_iput" type="checkbox" 
                                             value="' . $value_result_sql_for_answer['answer'] . '_' . $value_result_sql_for_answer['product'] . '_' . $value_result_sql_for_answer['recommendation_id'] . '_' . $value_result_sql_for_answer['score'] . '_' . $customer_id . '" 
                                             name="answer' . $count_q . '' . $count_a . '">
                                             
                                             <label for="id' . $count_q . '' . $count_a . '" class="btn_label" style = "vertical-align: middle;">
                                             <span class="Button Button--primary btn_conform btn_check btn_margin btn_margin class' . $count_q . '' . $count_a . '" attr ="' . $value_result_sql_for_answer['answer'] . '" >' . $value_result_sql_for_answer['answer'] . '</span>
                                             </label>
                                             &nbsp&nbsp';
                    }
                }

                $count_a++;

            endwhile;
            $output .=  '</div>';
        } else {

            $sql_age_input = "SELECT * FROM servey_table WHERE customer_id=$customer_id AND question_id='$question_text_area'";
            $result_age_input = $conn->query($sql_age_input);
            if ($result_age_input->num_rows > 0) {
                $value_age_input = $result_age_input->fetch_assoc();
                $value_age_value = $value_age_input['answer_id'];
            }

            $output .= '
                                                <div class="col-3">
                                                 </div>
                                                 
                                                 <div class="col-5">
                                                     <input type="number" class="Form__Input  shadow-none user_age" id="get_data_age1"  value="' . $value_age_value . '" placeholder="Enter your age">
                                                      <input type="text" class="form-control rounded-pill  shadow-none" id="get_data_age2" name="answer' . $count_q . '' . $count_a . '" value="" hidden>&nbsp&nbsp
                                                    
                                                 </div>
                                                 
                                                 <div class="col-1" style="text-align: left; padding-left: 1px;">
                                                 <span class="Button Button--primary btn_conform conform_age" attr ="' . $count_q . '">Confirm</span>
                                                 </div>
                                                 
                                                  <div class="col-2">
                                                 </div>';
        };

        if ($value['id'] == 23) {
            $output .= '<div classs="text-center" style="margin: 2% 0% 2%;">
                                              <h4 class="Heading Heading_apna text-center Heading_override">Please select all options that applies and then click on confirm button</h4>
                                              </div>
                                                     <div class="input-group  input-group-lg">
                                                     <input type="text" class="form-control rounded-pill  shadow-none " id = "all_checkbox_value" name = "answer" value="" style="display:none;">
                                                      <span class="Button Button--primary btn_conform btn_check " 
                                                      id ="calculate_multiple_check" style="margin: auto;!important;">Confirm</span>
                                                    </div>';
        }


        $output .=  '</div>
                                         
                                     
                                 </div>
                                 
                            </div>';

        $count_q++;
    endwhile;
endif;
echo ($output);

//   foreach ($customer1 as $customer) :
//     foreach ($customer as $key => $value) :
//       $output .=
//         '<tr>
//         <td>' . $value['first_name'] . '</td>
//         <td>' . $value['last_name'] . '</td>
//         <td>' . $value['email'] . '</td>
//         <td>' . $value['tags'] . '</td>
//               </tr>';
  

//   echo ($output);
