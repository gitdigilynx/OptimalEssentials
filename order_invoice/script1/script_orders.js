//////// update status of order////

var base_url = 'https://app.optimalessentials.com.au/optimalessentials';
var ship_order;
var shipbuttontext;
var shipunshipb;
//  delete order variable
var Delete_order;
var add_prdoduct_from_shpify;
$(".dropdown_list_p").prop("disabled", true);
$(document).ready(function () {
$(".dropdown_list_p").prop("disabled", false);


    // the URL of the current page
    var url_string = window.location.href;
    var url = new URL(url_string);
    var shipped_url = url.searchParams.get("shipped");
    var delete_order = url.searchParams.get("delete_order");
    if (shipped_url) {
        $('.success_alert').show();
        $('.success_alert').html('Order no #<strong>' + shipped_url + '</strong> shipping status updated successfully <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>');

        setInterval(ship_msg_h, 3000);
    }
    if (delete_order) {
        $('.success_alert').show();
        $('.success_alert').html('Order no #<strong>' + delete_order + '</strong> deleted successfully <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>');

        setInterval(ship_msg_h, 3000);
    }
    ship_order = function (order_id) {

        $.ajax({
            url: base_url + "/order_invoice/ship_order.php?order_id=" + order_id,
            async: false,
            type: "GET",
            success: function (data) {
                // console.log(data);

                window.location.href = "https://app.optimalessentials.com.au/optimalessentials/order_invoice/my_order_backend.php?shipped=" + order_id;

            },
            error: function (result) {
                console.log(["error order listing", result]);
            }
        });

    }
    function ship_msg_h() {
        $('.success_alert').hide();
    }

    //   order shipping status script start
    shipunshipb = function () {
        var order_staus = $('#shipping_status').val();
        var order_id_p = $('#shipping_status').children(":selected").attr("id");
        if (order_id_p == 0) {
            alert('Please select status.')
        } else {
            $.ajax({
                url: base_url + "/order_invoice/ship_order.php",
                data: {
                    order_id: order_id_p,
                    order_status: order_staus
                },
                async: false,
                type: "GET",
                success: function (data) {
                    // console.log(data);  
                    if (order_staus == 'Shipped') {

                        loaderr_show(order_id_p, order_staus);


                    } else {
                        window.location.href = base_url + "/order_invoice/my_order_backend.php?shipped=" + order_id_p;

                    }



                },
                error: function (result) {
                    console.log(["error order listing", result]);
                }
            });
        }

    }
    function loaderr_show(order_id_p, order_staus) {
        var messagee = `<div class="p-3 m_top-body body_servey hide_message">
           
                                  <div class="row text-center">
                                       <div class="col-12 fw-bold">
                                       <div class="spinner-border style="color:#454545"></div><br><br>
                                        <h4 class="Heading Heading_apna text-center">Order status updating...</h4>
                                            
                                       </div>
                                   </div>
                           
                       </div>`;


        $(".container").hide();
        
        $(".loader_msg").show();
        $(".loader_msg").append(messagee);
        $(window).scrollTop(0);
        setTimeout(function () {
            ship_order_mail(order_id_p, order_staus);
        }, 400);


    }

    // send mail function call start
    function ship_order_mail(order_id_p, order_staus) {

        $.ajax({
            url: base_url + "/send_mail/ship_mail.php",
            data: {
                order_id: order_id_p
            },
            async: false,
            type: "GET",

            success: function (data) {
                // console.log(data);
                window.location.href = base_url + "/order_invoice/my_order_backend.php?shipped=" + order_id_p;

            },
            error: function (result) {
                console.log(["error order listing", result]);
            }
        });
    }

    // send mail function call end


    // delete order ajax call start
    Delete_order = function (order_id) {
        var result = confirm('Are you Sure , want to delete order');
        if(result)
        {
            $.ajax({
            url: base_url + "/order_invoice/delete_order_backend.php",
            data: {
                order_id: order_id
            },
            async: false,
            type: "GET",

            success: function (data) {
                // console.log(data);
                // window.location.href = base_url + "/order_invoice/my_order_backend.php?delete_order=" + order_id;
                
                $('#tr_'+order_id).fadeOut(1000);
                
                $('.success_alert').show();
                $('.success_alert').html('Order no #<strong>' + order_id + '</strong> deleted successfully <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>');
    
                setInterval(ship_msg_h, 3000);

            },
            error: function (result) {
                console.log(["error order listing", result]);
            }
        });
        }
         
    }
    
    
    // order edit page script
      $(document).on('click', '.button-plus', function(e) {
        
        var id= $(this).attr("id");
        var old_val = parseInt($('#qty_'+id).val());
        var new_val = parseInt(old_val+1);
        
        $('#qty_'+id).val(new_val);
        
        var get_p_price = parseFloat($('.prodtct_p_'+id).val());
       
        var new_total_p1 = get_p_price * new_val;
        var new_total_p = new_total_p1.toFixed(2);
        $('.prodtct_total_val_'+id).val(new_total_p);
        $('.prodtct_total_text_'+id).text('$'+new_total_p);
        sub_total();
    });

    $(document).on('click', '.button-minus', function(e) {
        var id= $(this).attr("id");
        var old_val = parseFloat($('#qty_'+id).val());
        var new_val = parseFloat(old_val-1);
        if(new_val < 1)
        {
            new_val =1;
        }
        $('#qty_'+id).val(new_val);
        
        var get_p_price = $('.prodtct_p_'+id).val();
        var new_total_p1 = get_p_price * new_val;
        var new_total_p = new_total_p1.toFixed(2);
        $('.prodtct_total_val_'+id).val(new_total_p);
        $('.prodtct_total_text_'+id).text('$'+new_total_p);
        
        
        sub_total();
    });
    $(document).on('click', '.delete_item_order', function(e) {
        e.preventDefault();
        
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
              
              var id= $(this).attr("id");
                $('#row_'+id).fadeOut(1000);
                var total_val_p_del = parseFloat($('.prodtct_total_val_'+id).val());
                var subtotal_old_val = parseFloat($(".sub_total_val").val());
                $(".sub_total_text").text('Subtotal: $'+ (subtotal_old_val-total_val_p_del).toFixed(2));
                $(".sub_total_val").val((subtotal_old_val-total_val_p_del).toFixed(2));
                 setTimeout(function(){
                     $('#row_'+id).html('');
                     sub_total();
                 },2000);
              
            Swal.fire(
              'Removed!',
              'Your item has been removed.',
              'success'
            )
          }
        })
                
        
      
        
       
    });
    
    
    var total_val;
    function sub_total(){
        total_val =0;
        $('.total_find').each(function(){
          total_val = parseFloat(total_val) + parseFloat($(this).val());
        })
        var sub_total = total_val.toFixed(2);
         $(".sub_total_text").text('Subtotal: $'+sub_total);
         $(".sub_total_val").val(sub_total);
    }
    sub_total();
    
    var index_val = parseInt($(".coun_value").val());
    add_prdoduct_from_shpify = function ()
    {
        //  $(".dropdown_list_p").prop("disabled", true);
        var product_id =  $(".dropdown_list_p").val();
        var varient_id =  $(".dropdown_list_v").val();
        if(product_id == 0)
        {
            Swal.fire({
              icon: 'info',
              title: 'Oops...',
              text: 'Please select product!'
            });
            exit;
        }else if(varient_id == 0){
            Swal.fire({
              icon: 'info',
              title: 'Oops...',
              text: 'Please select varient!'
            });
            exit;
        }else if(varient_id){
            $('.varient_id_c').each(function(){
                var all_varient_id = $(this).val();
                if(varient_id == all_varient_id ){
                    
                    Swal.fire({
                      icon: 'info',
                      title: 'Oops...',
                      text: 'Product varient already exists!'
                    });
                    exit;
                }


                });
            
        }
        
            var qty_a_p_q = $('#qty_a_p_q').val();
            
            
            var new_index_val =parseInt(index_val++); 
           var old_value = new_index_val;
           new_index_val++;
            
             $.ajax({
                url: base_url + "/order_invoice/fetch_product_from_shopify_backend.php",
                data: {
                    product_id: product_id,
                    product_qty: qty_a_p_q,
                    index_val: index_val,
                    varient_id:varient_id
                },
                async: false,
                type: "GET",
                success: function (data) {
                    // console.log(data);  
                    Swal.fire({
                      position: 'center',
                      icon: 'success',
                      title: 'Product Added successfully',
                      showConfirmButton: false,
                      timer: 1500
                    })
                    $('#row_'+old_value).after(data);
                    sub_total();
                    $(".dropdown_list_p").prop("disabled", false);
                },
                error: function (result) {
                    console.log(["error order listing", result]);
                }
            });
        
       
       
      
        
    }
    
    
    function submitfromaddress(){
      var address_from = document.address_info_form;
      
                  var dataString = $(address_from).serialize();
      
                  $.ajax({
                      method: "POST",
                      url: base_url + '/order_invoice/customer_address.php',
                      data: dataString,
                      success: function (data) {
                        //   console.log(data);
                        // $(this).prop("disabled", true);
                        //   Swal.fire(
                        //       'Saved!',
                        //       'Order Updated Successfully!',
                        //       'success'
                        //     )
                         
                      }
                  });

    }
    
    // submit order item start
    function submit_order_items()
    {
        var recurring_week = $('.recurring_week').val();
        $('.recurring_week_input').val($('.recurring_week').val());
        var order_items = document.order_item_form;
        var dataString_order = $(order_items).serialize();
        
            $.ajax({
                      method: "POST",
                      url: base_url + '/order_invoice/update_order_items.php',
                      data: 
                          dataString_order,
                      success: function (data) {
                        //   console.log(data);
                        // $(this).prop("disabled", true);
                          Swal.fire(
                              'Updated!',
                              'Order NO#'+data+' Updated Successfully!',
                              'success'
                            )
                         
                      }
                  });
    }
    // submit order item end
    
    $(document).on('click', '.order_submit', function(e) {
  if($("#First_Name").val()==''){
      
             alert("First name is required.");
             }
  else if($("#Last_Name").val()==''){
             alert("Last name is required.");
             }
   else if($("#Address").val()==''){
             alert("Address is required.");
             }
   else if($("#Address2").val()==''){
             alert("Appartment is required.");
             }
   else if($("#City").val()==''){
             alert("City is required.");
             }
   else if($("#State").val()==''){
             alert("State is required.");
             }
   else if($("#Zip_Code").val()==''){
             alert("Zip code is required.");
             }
  else if($("#Country").val()==''){
             alert("Country is required.");
             }
  else if($("#Phone_No").val()==''){
             alert("Phone no is required.");
             }
  else if($("#Email").val()==''){
             alert("Email is required.");
             }
  else{
    // $(this).prop("disabled", true);
    // $(this).css({"opacity": ".2", "cursor": "progress"});
    // loaderr_show();
     submitfromaddress();
    submit_order_items();
   
  }
 
  
});

$('.dropdown_list_v').prop("disabled", true);
$('.readonly_class').prop('readonly', true);

        $(".dropdown_list_p").change(function(){
            var check_varient = true;
            var product_id =  $(this).val();
            var recurring_week_qty = $('.recurring_week').val();
            if(product_id == 0)
            {
                
            }else{
                  $.ajax({
                        url: base_url + "/order_invoice/fetch_product_from_shopify_backend.php",
                        data: {
                            check_varient: check_varient,
                            recurring_week: recurring_week_qty,
                            product_id_for_v: product_id
                        },
                        async: false,
                        type: "GET",
                        success: function (data) {
                           var data = $.parseJSON(data);
                        //   console.log(data);
                           $(".dropdown_list_v").html(data[0]);
                           $("#qty_a_p_q").val(data[1]);
                            $(".dropdown_list_v").prop("disabled", false);
                        },
                        error: function (result) {
                            console.log(["error order listing", result]);
                        }
                    });
            }
          });
  
  
    

    
    
    

});





