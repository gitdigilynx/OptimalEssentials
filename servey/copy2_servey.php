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

        .btn_label {
            display: initial !important;
        }

        .label_iput {
            display: none;
        }
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

            i = 1; //increment i



            $(document).on('click', '.btn_conform', function (e) {

                $("#idcol8").hide();

                var check_class_status = $(this).hasClass('active');

                console.log(this);
                if (check_class_status) {
                    $(this).removeClass('active');
                } else {
                    $(this).addClass('active');
                }




                var div_col = document.getElementById("idcol" + i);
                // console.log(div_col);
                if (div_col != null) {
                    var input = div_col.getElementsByTagName("input");
                    // console.log(input);
                    for (var insideI = 0; insideI < input.length; insideI++) {
                        input[insideI].onclick = function () {
                            // console.log('input' +this);
                            for (var insideI = 0; insideI < input.length; insideI++) {

                                if (input[insideI] != this && this.checked) {

                                    input[insideI].checked = false;

                                }
                            }
                        }
                    }
                    var span = div_col.getElementsByTagName("span");
                    // console.log(span);
                    for (var insideI = 0; insideI < span.length; insideI++) {

                        // console.log(span[insideI]);
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
                    var BMI_height = $('#BMI_height').val();
                    var BMI_weight = $('#BMI_weight').val();

                    // condition
                    if (BMI_height === '' || BMI_weight === '') {
                        alert('Height and weight is required...');
                        --i;
                        --next_tab_click;

                        $(this).removeClass('active');
                    } else {
                        for_next_check++; // incremeent for latest answer
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

                //  $("#nextBtn").prop('disabled', true);
            });
        });



        function nextButton() {


            // start  set progress-bar length
            progress_bar_length_add = progress_bar_length_add + progress_bar_length;
            $(".progress-bar").css("width", progress_bar_length_add + "%");
            // end  set progress-bar length


            var next_tab = ++i;

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
            } else
                if (i < for_next_check) {
                    //   $("#nextBtn").prop('disabled', true);
                }
                else {
                    $("#nextBtn").prop('disabled', false);
                }

            $(".box").hide();
            $(".hide_message").hide();
            $(".tab" + next_tab).show();

        }

        function preveButton() {


            // start  set progress-bar length
            progress_bar_length_add = progress_bar_length_add - progress_bar_length;
            $(".progress-bar").css("width", progress_bar_length_add + "%");
            // end  set progress-bar length

            var preve_tab = --i;

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
            //   else {
            //   $("#nextBtn").prop('disabled', false);
            //   }

            $(".box").hide();

            $(".hide_message").hide();
            $(".tab" + preve_tab).show();

        }

        function submit_form() {

            var form = document.myform;

            var dataString = $(form).serialize();

            $.ajax({
                method: "POST",
                url: "https://app.optimalessentials.com.au/servey/insert_servey.php",
                data: dataString,
                success: function (data) {
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

</html>;