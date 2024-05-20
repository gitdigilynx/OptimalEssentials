var id = 1; //define for the add question
var productList;
var productRecommendationList;
var base_url = 'https://app.optimalessentials.com.au/optimalessentials/';
product_list();
product_recommendation();

// get the list of products
function product_list() {
    $.ajax({
        url: base_url+ "/Customers/QA/product_list.php",
        type: "GET",
        success: function (data) {
            productList = data;
            $("#product-input-select").append(productList);

        },
        error: function (result) {
            console.log(["error getting product", result]);
        }
    });
}
// get the list of products recomendation
function product_recommendation() {
    $.ajax({
        url: base_url + "/Customers/QA/product_recommendation_list.php",
        type: "GET",
        success: function (data) {
            productRecommendationList = data;
            $("#recommendation-input-select").append(productRecommendationList);

        },
        error: function (result) {
            console.log(["error getting product", result]);
        }
    });
}




// delete question 
function deletequestions(formId, q_id) {



    $('#' + formId).on('submit', function (e) {



        e.preventDefault();
 var result = confirm('Are you Sure');

       if(result){
            $.ajax({

                    type: 'GET',

                    url: base_url+'/Customers/QA/delete_qa.php?question_id=' + q_id,

                    success: function (response) {



                        // alert(response);
                        var alertt =

                            `<div class="alert alert-success alert-dismissible fade show" role="alert">
    
                        <strong>Success!</strong> ${response}
    
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    
                      </div>`;

                        // Swal.fire(
                        //     'Deleted!',
                        //     'Your file has been deleted.',
                        //     'success'
                        // )

                        $('#tr_' + formId).fadeOut(1000, function () {
                            $('#tr_' + formId).remove();
                        });

                        document.getElementById("msg_alert2").innerHTML = alertt;
                        alertt = '';

                    }
                });
       }


    });

}


// update Question Answer
function updateProducts(formId, productid) {

 var newval = $('#' + formId).serialize();




    $('#' + formId).on('submit', function (e) {

        e.preventDefault();
        $.ajax({
            type: 'post',
            url:  base_url+'/Customers/Products/update_product.php?product_id=' + productid,
            data: $('#' + formId).serialize(),
            success: function (response) {
                // alert(response);
                var alertt =
                    `<div class="alert alert-success alert-dismissible fade show" role="alert">
                      <strong>Success!</strong> ${response}
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;

                    document.getElementById("msg_alert").innerHTML = alertt;

            }
        });

    });

}



// update Question Answer
function updatequestions(formId, q_id) {

 var newval = $('#' + formId).serialize();




    $('#' + formId).on('submit', function (e) {

        e.preventDefault();

        $.ajax({
            type: 'post',
            url:  base_url+'/Customers/QA/update_qa.php?question_id=' + q_id,
            data: $('#' + formId).serialize(),
            success: function (response) {
                    console.log(response);
                var alertt =
                    `<div class="alert alert-success alert-dismissible fade show" role="alert">
                      <strong>Success!</strong> ${response}
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;

                

                if (q_id <= 24) {
                //     Swal.fire(
                //     'Updated!',
                //     'Hard Section Updated Successfully!',
                //     'success'
                // );

                    document.getElementById("msg_alert").innerHTML = alertt;
                } else {
                        // Swal.fire(
                        //     'Updated!',
                        //     'Dynamic Section Updated Successfully!',
                        //     'success'
                        //         );
                    document.getElementById("msg_alert2").innerHTML = alertt;
                }
                
                 alertt = '';

                // document.getElementById("msg_alert").innerHTML = alertt;


            }
        });

    });




}


function newinput() {

    var select_id = document.getElementById("product-input-select");
    var select2 = select_id;
    // console.log(select_id);

    if (id == 1) {
        var parent = document.getElementById("section_" + id);
    } else {
        var parent = document.getElementById("section_" + id);
    }

    // console.log(parent);

    id += 1;

    // design section

    var section_div = document.createElement("div");
    section_div.id = "section_" + id;
    parent.after(section_div);



    // add heading

    var sectionHeading = document.createElement("h2");
    sectionHeading.innerHTML = "Option" + id;
    sectionHeading.className = "text-center";
    section_div.appendChild(sectionHeading);





    // design answer div

    var answerdiv = document.createElement("div");
    answerdiv.id = "answer-input-div-" + id;
    answerdiv.className = "mb-3";
    section_div.appendChild(answerdiv);

    // score div

    var scorediv = document.createElement("div");
    scorediv.id = "score-input-div-" + id;
    scorediv.className = "mb-3";
    section_div.appendChild(scorediv);

    // product div

    var productdiv = document.createElement("div");
    productdiv.id = "product-input-div-" + id;
    productdiv.className = "mb-3";
    section_div.appendChild(productdiv);

    // recommendation div

    var recommendationdiv = document.createElement("div");
    recommendationdiv.id = "recommendation-input-div-" + id;
    recommendationdiv.className = "mb-3";
    section_div.appendChild(recommendationdiv);

    // create hr

    // var hrdiv = document.createElement("hr");

    // section_div.appendChild(hrdiv);







    // design label

    var answerlabel = document.createElement("label");
    answerlabel.className = "form-label";
    answerlabel.innerHTML = "Answer" + id;
    answerdiv.appendChild(answerlabel);



    // design input

    var answerfield = document.createElement("input");
    answerfield.className = "form-control";
    //   answerfield.style = "display:block;";
    answerfield.id = "answer" + id;
    // answerfield.setAttribute('required', '');
    answerfield.name = "answer[" + id + "]";
    answerdiv.appendChild(answerfield);



    // design score

    // score label 

    var score_label = document.createElement("label");
    score_label.className = "form-label";
    score_label.innerHTML = "Score" + id;
    scorediv.appendChild(score_label);

    // score enter

    var scoreinput = document.createElement("input");
    scoreinput.className = "form-control";
    scoreinput.style = "display:block;"
    scoreinput.id = "input" + id;
    scoreinput.type = "number";
    // scoreinput.setAttribute('required', '');
    scoreinput.name = "score[" + id + "]";
    scorediv.appendChild(scoreinput);



    // design product // design product // desig // design product

    // product label 

    var product_label = document.createElement("label");
    product_label.className = "form-label";
    product_label.innerHTML = "Product" + id;
    productdiv.appendChild(product_label);

    // score enter

    var productinput = document.createElement("select");
    productinput.className = "form-select";
    productinput.style = "display:block;"
    productinput.id = "product-input-select" + id;
    // productinput.setAttribute('required', '');
    productinput.name = "product[" + id + "]";
    productinput.innerHTML = select2;

    productdiv.appendChild(productinput);
    $('#product-input-select' + id).append(productList);

    // product label 

    var recommendation_label = document.createElement("label");
    recommendation_label.className = "form-label";
    recommendation_label.innerHTML = "Recommendation" + id;
    recommendationdiv.appendChild(recommendation_label);

    // score enter

    var recommendationinput = document.createElement("select");
    recommendationinput.className = "form-select";
    recommendationinput.style = "display:block;";
    recommendationinput.id = "recommendation-input-select" + id;
    // productinput.setAttribute('required', '');
    recommendationinput.name = "recommendation[" + id + "]";
    recommendationinput.innerHTML = select2;

    recommendationdiv.appendChild(recommendationinput);
    $('#recommendation-input-select' + id).append(productRecommendationList);





}