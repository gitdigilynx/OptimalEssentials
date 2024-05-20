<?php

$admin_id = 1122334455; // this is hard code id of admin
$group_id = $_GET['group_id'];

include('../Customers/header.php');
?>
<style>
    .btndesigndiv {
        margin: 3%;
    }

    .buttondesign {
        padding: 8px;
    }

    a {
        color: inherit;
        text-decoration: none;
    }

    .vh-100 {
        min-height: 100vh;
    }

    .fs-xs {
        font-size: 1rem;
    }

    .w-10 {
        width: 10%;
    }

    .fs-big {
        font-size: 5rem !important;
    }

    .online {
        width: 10px;
        height: 10px;
        background: green;
        border-radius: 50%;
    }

    .w-15 {
        width: 15%;
    }

    .fs-sm {
        font-size: 1.4rem;
    }

    small {
        color: #bbb;
        font-size: 0.7rem;
        text-align: right;
    }

    .chat-box {
        height: 57vh;
        overflow-y: auto;
        overflow-x: hidden;
        max-height: 57vh;
    }

    .rtext {
        width: 65%;
        background: #f8f9fa;
        color: #444;
    }

    .ltext {
        width: 65%;
        background: #3289c8;
        color: #fff;
    }

    /* width */
    *::-webkit-scrollbar {
        width: 3px;
    }

    /* Track */
    *::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    /* Handle */
    *::-webkit-scrollbar-thumb {
        background: #aaa;
    }

    /* Handle on hover */
    *::-webkit-scrollbar-thumb:hover {
        background: #3289c8;
    }

    textarea {
        resize: none;
    }

    /*message_status*/
</style>

<div class="container-fluid mt-5">
    <div class="mb-2" style="text-align:right;">
    <a href="/optimalessentials/shopifyapp_ajax_call/client_list_msg.php"><button type="button" class="btn btn-primary"><i class="fa fa-chevron-circle-left"></i> Back</button></a>
</div>
    <hr>
</div>


<div id="HcpStaffList">
    <div class="p-3 loder_show" style="margin-top: 10%;">
                 
                                        <div class="row text-center">
                                             <div class="col-12 fw-bold">
                                             <div class="spinner-border" style="color:#454545"></div><br><br>
                                              <h4 class="Heading Heading_apna text-center">Please wait...</h4>
                                                  
                                             </div>
                                         </div>
                                 
                             </div>
</div>

<?php include('../Customers/footer.php'); ?>
<script>
    $(document).ready(function() {
        var base_url = 'https://app.optimalessentials.com.au/optimalessentials';
        var customerId = '<?= $admin_id ?>';
        var group_id = '<?= $group_id ?>';

        function scrollDown() {
            let chatBox = document.getElementById('chatBox');
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        function get_chat_dashboard() {
            $.ajax({
                url: base_url + '/chats/chat.php',
                data: {
                    customerId: customerId,
                    group_id: group_id

                },
                type: "GET",
                /* or type:"GET" or type:"PUT" */
                success: function(result) {
                    // console.log(result);
                        $('#HcpStaffList').html(result);
                        scrollDown();
                   
                },
                error: function() {
                    console.log("error");
                }
            });
        }
        get_chat_dashboard();
        
        $(document).on('click', '.sendBtn', function() {
            var msg_for = $('.to_msg_frp').val();

           if (msg_for == null) {
                alert('Please select receiver');
                exit;
            }
            var message = $("#message").val();
            if (message === '') {
                alert('Please enter text');
                exit;
            }
            $.ajax({
                url: base_url + '/chats/save_chat.php',
                data: {
                    customerId: customerId,
                    message:message,
                    msg_for:msg_for,
                    group_id:group_id
                },
                type: "GET",
                /* or type:"GET" or type:"PUT" */
                success: function(result) {
                    // console.log(result);
                    $('.infor_empty_msg').hide();
                    $("#message").val("");
                    $("#chatBox").append(result);
                    scrollDown();
                },
                error: function() {
                    console.log("error");
                }
            });
        });
        
                // auto refresh / reload
      let fechData = function(){
      	 $.ajax({
                url: base_url + '/chats/get_new_chat.php',
                data: {
                    customerId: customerId,
                    group_id:group_id
                    
                },
                type: "GET",
                /* or type:"GET" or type:"PUT" */
                success: function(result) {
                   if(result)
                  {
                     $('.infor_empty_msg').hide();
                  }
                    // console.log(result);
                    $("#chatBox").append(result);
                  if (result != "") scrollDown();
                 
                },
                error: function() {
                    console.log("error");
                }
            });
      }
      /** 
      auto update last seen 
      every 0.5 sec
      **/
      setInterval(fechData, 500);
    });
</script>
<?php

?>