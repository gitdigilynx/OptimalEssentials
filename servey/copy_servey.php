<html lang="en">

<head>
    <title>User</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <style>
        a {
            color: inherit;
            text-decoration: none;
        }

        .header_servey {
            color: #36393e;
            background-color: #fcfaf7;
        }

        .footer_servey {
            color: #36393e;
            background-color: #fcfaf7;
            margin-bottom: -11%;
        }

        .body_servey {
            color: #36393e;
        }

        .progress_bar {
            height: 12%;
        }

        .m_top-body {
            margin-top: 5% !important;
            margin-bottom: 12% !important;
        }

        .btn_check {
            white-space: normal;
            width: 20%;
            word-wrap: break-word;
        }

        .multi_question {
            margin: 2%;
        }

        .btn_label {
            display: initial !important;
        }

        /*.label_iput {*/
        /*    display: none;*/
        /*}*/
    </style>

</head>

<body>

    <div class="p-3 pb-5 header_servey ">

        <div class="row text-center">
            <div class="col-12">
                <h5>Questionnaire</h5>
            </div>
        </div>

        <div class="row text-center mt-3">

            <div class="col-3">
                <button type="button" class="btn btn-outline-warning" title="Update" onclick="preveButton()"
                    id="prevBtn" disabled>
                    <i class="fa fa-chevron-circle-left"></i> Previous question
                </button>
            </div>

            <div class="col-6">
                <div class="progress mt-3 progress_bar">
                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="75" aria-valuemin="0"
                        aria-valuemax="100"></div>
                </div>
            </div>

            <div class="col-3">
                <button type="button" class="btn btn-outline-warning" title="Update" onclick="nextButton()" id="nextBtn"
                    disabled>
                    Next question <i class="fa fa-chevron-circle-right"></i>
                </button>
            </div>

        </div>
    </div>

    <form id="myform" class="myform" method="post" name="myform">
        <div class="servey_append">

        </div>
    </form>

    <script>
        var for_next_check = 1;
        var progress_bar_length = 0;
        var progress_bar_length_add = 0;
        var i;



        $(document).ready(function () {



            function Apppend_Question_Ans(customer_id) {
                $.ajax({
                    url: "https://app.optimalessentials.com.au/servey/get_servey.php?customer_id=" + customer_id,
                    async: false,
                    type: "GET",
                    success: function (data) {
                        var servey_list = data;
                        $(".servey_append").append(servey_list);
                        $(".tab1").show();

                    },
                    error: function (result) {
                        console.log(["error question anwser", result]);
                    }
                });
            }
            Apppend_Question_Ans(10101010);



        //   for multiple check start
        var name = '';
        var product_id ='';
        var score = '';
        var customer_id = '';
         $(document).on('click', '#calculate_multiple_check', function (e) {
            var checkedVals = $('.total_chekbox_cheked:checkbox:checked').map(function() {
                                return this.value;
                              }).get();
                              
            var all_checked_val = checkedVals.join("~");
            var answerArr =  all_checked_val.split('~');
            var answerlength = answerArr.length;
            
            for(y=0; y < answerlength; y++ ){
                var answercheck1 = answerArr[y];
                
                
                 var answerArr1 =  answercheck1.split('_');
                 name += answerArr1[0] +',';
                 product_id += answerArr1[1] +',';
                 score += answerArr1[2] +',';
                 customer_id = answerArr1[3];
               
                 
            }
            
            var input_modify = name+'_'+product_id+'_'+score+'_'+customer_id;
            console.log(input_modify);
         $("#all_checkbox_value").val(input_modify);
            
         });
         
         
         $(document).on('click', '.total_chekbox_button', function (e) {
             if($(this).hasClass('active'))
             {
                 $(this).removeClass("active");
             }else{
                $(this).addClass("active");
             }
         });
         
         //   for multiple check end


            // for Bmi calculation start
            $(document).on('click', '#calculate_BMI', function (e) {
                var weight_user = $('#BMI_weight').val();

                var height_user = $('#BMI_height').val();

                //convert cm to meter start
                var user_h_meter = height_user / 100;
                //convert cm to meter end

                //meter square m2 start
                var user_h_m2 = user_h_meter * user_h_meter;
                //meter square m2 end

                //Final BMI start
                var bmi_user = weight_user / user_h_m2;
                //Final BMI m2 end

                //   alert(bmi_user);
                if (bmi_user < 19) {
                    $(".class81").addClass("active");
                    $("#id81").prop("checked", true);
                }
                else {
                    $(".class81").removeClass("active");
                    $("#id81").prop("checked", false);
                }


                if (bmi_user > 19 && bmi_user < 21) {
                    $(".class82").addClass("active");
                    $("#id82").prop("checked", true);
                }
                else {
                    $(".class82").removeClass("active");
                    $("#id82").prop("checked", false);
                }


                if (bmi_user > 21 && bmi_user < 23) {
                    $(".class83").addClass("active");
                    $("#id83").prop("checked", true);
                }
                else {
                    $(".class83").removeClass("active");
                    $("#id83").prop("checked", false);
                }


                if (bmi_user > 23) {
                    $(".class84").addClass("active");
                    $("#id84").prop("checked", true);
                }
                else {
                    $(".class84").removeClass("active");
                    $("#id84").prop("checked", false);
                }


            });

            //  for Bmi calculation end


            // for multiple question start

            $(document).on('click', '#option1', function (e) {
                $("#option2").removeClass("active");
                $("#option1").addClass("active");
                $("#multi_2").prop("checked", false);

            });

            $(document).on('click', '#option2', function (e) {
                $("#option1").removeClass("active");
                $("#option2").addClass("active");
                $("#multi_1").prop("checked", false);

            });

            $(document).on('click', '#option3', function (e) {
                $("#option4").removeClass("active");
                $("#option3").addClass("active");
                $("#multi_4").prop("checked", false);

            });

            $(document).on('click', '#option4', function (e) {
                $("#option3").removeClass("active");
                $("#option4").addClass("active");
                $("#multi_3").prop("checked", false);

            });


            $(document).on('click', '#option5', function (e) {
                $("#option6").removeClass("active");
                $("#option5").addClass("active");
                $("#multi_6").prop("checked", false);

            });

            $(document).on('click', '#option6', function (e) {
                $("#option5").removeClass("active");
                $("#option6").addClass("active");
                $("#multi_5").prop("checked", false);

            });


            $(document).on('click', '#calculate_yes_no', function (e) {
                var countforchecked = 0;

                $(".count_yes").each(function (index, elem) {

                    if ($(elem).is(":checked")) {
                        var questionchecked = $(elem).val();
                        if (questionchecked == 'Yes') {
                            countforchecked++;
                        }
                    }

                });

                if (countforchecked == 1) {
                    $("#id131").prop("checked", true);
                    $("#id132").prop("checked", false);
                    $("#id133").prop("checked", false);
                }
                else if (countforchecked == 2) {
                    $("#id131").prop("checked", false);
                    $("#id132").prop("checked", true);
                    $("#id133").prop("checked", false);
                }
                else if (countforchecked == 3) {
                    $("#id131").prop("checked", false);
                    $("#id132").prop("checked", false);
                    $("#id133").prop("checked", true);
                }
                else {
                    $("#id131").prop("checked", true);
                    $("#id132").prop("checked", false);
                    $("#id133").prop("checked", false);
                }


            });


            // for multiple question start


            // add class when skip
             $(document).on('click', '#calculate_BMI_skip', function (e) {
                $("#calculate_BMI").removeClass("active");
                $("#calculate_BMI_skip").addClass("active");
                 

               
            });

            i = 1; //increment i



            $(document).on('click', '.btn_conform', function (e) {



                // var check_class_status = $(this).hasClass('active');
                // // console.log(this);
                // if (check_class_status) {                                //code for active remove class
                //     $(this).removeClass('active');
                // } else {
                // }


                $("#idcol8").hide();
                $("#idcol13").hide();
                $(this).addClass('active');

                var div_col = document.getElementById("idcol" + i);
                // console.log(div_col);
                if (div_col != null) {
                    var input = div_col.getElementsByTagName("input");
                    for (var insideI = 0; insideI < input.length; insideI++) {
                        input[insideI].onclick = function () {
                            $(this).prop("checked", true);
                            for (var insideI = 0; insideI < input.length; insideI++) {
                                if (input[insideI] != this && this.checked) {
                                    input[insideI].checked = false;
                                }
                            }
                        }
                    }

                    var span = div_col.getElementsByTagName("span");
                    for (var insideI = 0; insideI < span.length; insideI++) {
                        if ($(span[insideI]).hasClass('active')) {
                            for (var inside2 = 0; inside2 < span.length; inside2++) {
                                $(span[inside2]).removeClass('active');
                            }
                            $(this).addClass('active');
                        }
                    }
                }

                if ($(this).hasClass('active')) {
                    var next_tab_click = ++i;
                } else {
                    var next_tab_click = i;
                }

                var numItems = $('.box').length;
                if (next_tab_click == 1) {
                    $("#prevBtn").prop('disabled', true);
                } else {
                    $("#prevBtn").prop('disabled', false);
                }
                if (next_tab_click == numItems + 1) {
                    $("#nextBtn").prop('disabled', true);
                    setTimeout(function () {
                        submit_form();
                    }, 3000);
                }
                if (i < for_next_check) {

                    $("#nextBtn").prop('disabled', false);
                }
                //   else {
                //   $("#nextBtn").prop('disabled', false);
                //   }

                if (i == 3) {
                    var user_age = $('.user_age').val();
                    if (user_age == '') {
                        alert('Age is required.');
                        --i;
                        --next_tab_click;
                        $(this).removeClass('active');
                    } else {
                        for_next_check++; // incremeent for latest answer
                    }
                }
                else if (i == 9) {

                } else {
                    for_next_check++; // incremeent for latest answer
                }

                if (i == 9) {
                    if ($('#calculate_BMI').hasClass('active')) //check if the confirm button click
                    {
                        var BMI_height = $('#BMI_height').val();
                        var BMI_weight = $('#BMI_weight').val();

                        // condition
                        if (BMI_height === '' || BMI_weight === '') {
                            alert('Height and weight is required...');
                            --i;
                            --next_tab_click;
                            $(this).removeClass('active');
                            $('#calculate_BMI').removeClass('active'); //remove skip class
                        } else {
                            for_next_check++; // incremeent for latest answer
                            $('#calculate_BMI_skip').removeClass('active');  //remove skip class
                            $('#questiontextarea8').prop('disabled', false);  //enable question8
                            $('#questiontextarea19').prop('disabled', true);  //disbale question19
                            $('#questiontextarea20').prop('disabled', true);  //disable question20
                        }
                    } else if ($('#calculate_BMI_skip').hasClass('active')) {
                        for_next_check++; // incremeent for latest answer
                        $('#calculate_BMI').removeClass('active'); //remove cnfrm class
                        $('#questiontextarea8').prop('disabled', true);  //disbale question8 if skip
                        $('#questiontextarea19').prop('disabled', false);  //enable question19
                        $('#questiontextarea20').prop('disabled', false);  //enable question20
                    }
                }
               

                if (i == 19) // if i is 19 and skip button is clicked
                {
                    if ($('#calculate_BMI').hasClass('active')) {
                        i += 2;
                        next_tab_click += 2;
                        for_next_check += 2;
                        // start  set progress-bar length
                        progress_bar_length = 100 / numItems;
                        progress_bar_length_add += 100 / numItems;
                        progress_bar_length_add += 100 / numItems;
                        $(".progress-bar").css("width", progress_bar_length_add + "%");
                        // end  set progress-bar length
                    }

                }

                if ($(this).hasClass('active')) {
                    // start  set progress-bar length
                    progress_bar_length = 100 / numItems;
                    progress_bar_length_add += 100 / numItems;
                    $(".progress-bar").css("width", progress_bar_length_add + "%");
                    // end  set progress-bar length

                }

                $(".box").hide();
                $(".hide_message").hide();
                $(".tab" + next_tab_click).show();

                // for debugging
                // console.log('btn click i'+i);//+=3;
                // console.log('btn click for necxt check = '+for_next_check);//+=3;
                //console.log('btn click for next_tab'+next_tab_click);
                //  $("#nextBtn").prop('disabled', true);
            });
        });



        function nextButton() {

                // start  set progress-bar length
            progress_bar_length_add = progress_bar_length_add + progress_bar_length;
            $(".progress-bar").css("width", progress_bar_length_add + "%");
            // end  set progress-bar length
            

            var next_tab = ++i;

            // applying condtion if height weight is not enterd
            if ( i == 19 ) // if i is 19 and skip button is clicked
            {
                if ($('#calculate_BMI').hasClass('active')) {
                    i += 2;
                    next_tab = i;
                    if (for_next_check < 21) {    //condtion if check next is less 
                        for_next_check = i;
                    }
                      // start  set progress-bar length
                         progress_bar_length_add = progress_bar_length_add + progress_bar_length;
                         progress_bar_length_add = progress_bar_length_add + progress_bar_length;
                        $(".progress-bar").css("width", progress_bar_length_add + "%");
                        // end  set progress-bar length

                }
               

            }
            // check the inputr fields
            if( i==20 )
            {
                 if($('#calculate_BMI_skip').hasClass('active'))
                {
                   
                        var MAC1 = $('#id191').is(':checked');
                        var MAC2 = $('#id192').is(':checked');
                        var MAC3 = $('#id193').is(':checked');
                        console.log(MAC1);
                        console.log(MAC2);
                        console.log(MAC3);
                        // condition
                        if (MAC1 === true || MAC2 === true || MAC3===true) {
                           
                        }else{
                            --i;
                            next_tab=i;
                        
                        }
                }
            }else if(i==21){
                        var CC1 = $('#id201').is(':checked');
                        var CC2 = $('#id202').is(':checked');
                       
                        // condition
                        if (CC1 === true || CC2 === true ) {
                           
                        }else{
                            alert(i);
                            --i;
                            next_tab=i;
                        
                        }
            }

            var numItems = $('.box').length;
            if (next_tab == 1) {
                $("#prevBtn").prop('disabled', true);
            } else {
                $("#prevBtn").prop('disabled', false);
            }
            if (next_tab == numItems) {
                $("#nextBtn").prop('disabled', true);
            }
            if (i == for_next_check) {
                $("#nextBtn").prop('disabled', true);
            }
            if (i < for_next_check) {
                $("#nextBtn").prop('disabled', false);
            }
            else {
                $("#nextBtn").prop('disabled', true);
            }

            $(".box").hide();
            $(".hide_message").hide();
            $(".tab" + next_tab).show();

            // for debugging
            // console.log('next i = '+i);//+=3;
            // console.log('next for_next_check = '+for_next_check);//+=3;
            // console.log('next next_tab = '+next_tab);
        }

        function preveButton() {


            // start  set progress-bar length
            progress_bar_length_add = progress_bar_length_add - progress_bar_length;
            $(".progress-bar").css("width", progress_bar_length_add + "%");
            // end  set progress-bar length

            var preve_tab = --i;

            // applying condtion if height weight is not enterd
            if (i == 20) // if i is 19 and skip button is clicked 
            {
                if ($('#calculate_BMI').hasClass('active')) {
                    i -= 2;
                    preve_tab -= 2;
                    if (for_next_check < 21) // check if the next value is less
                    {
                        for_next_check -= 2;
                    }
                    progress_bar_length_add = progress_bar_length_add - progress_bar_length;
                    progress_bar_length_add = progress_bar_length_add - progress_bar_length;
                    $(".progress-bar").css("width", progress_bar_length_add + "%");
                }

            }

            var numItems = $('.box').length;
            if (preve_tab == 1) {
                $("#prevBtn").prop('disabled', true);
            } else {
                $("#prevBtn").prop('disabled', false);
            }
            if (preve_tab == numItems) {
                $("#nextBtn").prop('disabled', true);

            } else if (i < for_next_check) {
                $("#nextBtn").prop('disabled', false);
            }

            $(".box").hide();
            $(".hide_message").hide();
            $(".tab" + preve_tab).show();

            // previous code for else
            //   else {
            //   $("#nextBtn").prop('disabled', false);
            //   }

            // for debugging
            //  console.log('pre i = '+i);//+=3;
            // console.log('pre for_next_check = '+for_next_check);//+=3;
            // console.log('pre next_tab = '+next_tab);

        }

        function submit_form() {

            var form = document.myform;

            var dataString = $(form).serialize();

            $.ajax({
                method: "POST",
                url: "https://app.optimalessentials.com.au/servey/insert_servey.php",
                data: dataString,
                success: function (data) {
                    console.log(data);
                    var messagee = `<div class="p-3 m_top-body body_servey hide_message">
         
                                <div class="row text-center">
                                     <div class="col-12 fw-bold">
                                          <h5>Thank you for completing the questionnaire. You are recommended with these products:</h5><br><br>
                                          <p>Product 1</p>   <p>Product 2</p>   <p>Product 3</p>
                                     </div>
                                 </div>
                         
                     </div>`;
                    if (data == "sucess") {
                        $(".servey_append").append(messagee);
                    }
                }
            });


        }

    </script>

</body>

</html>