<?php

require_once("../inc/db_connect.php");

$group_id='';
$total_unread ='';
$output = '';
// sql for all Client
$sql = "SELECT DISTINCT
st.customer_id,
customer.first_name,
customer.last_name,
customer.email
FROM 

servey_table as st

LEFT JOIN Customers as customer
ON st.customer_id=customer.customer_id

WHERE customer.tags='HCPClient'
ORDER BY customer.id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

        include('../Customers/header.php');
?>

        <div class="container-fluid mt-5">
            <h3 class="text-center mb-4">Messages</h3>
            <hr>
        </div>
        <div class="table-responsive col-10 m-auto">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    while ($value = $result->fetch_assoc()) {
                        $group_id = $value['customer_id'];
                        $role = 'admin_check'; // this is hard role for admin as we know this is admin page
                        include("../chats/get_unread_chats.php"); // check the unread messages of user
                    ?>
                        <tr>
                            <th scope="row"><?= $count++ ?></th>
                            <td><?= $value['first_name']  ?></td>
                            <td><?= $value['last_name']  ?></td>
                            <td><?= $value['email']  ?></td>
                            <td>
                                <a href="/optimalessentials/chats/admin_chat.php?group_id=<?= $value['customer_id'] ?>">
                                    <button class="btn btn-primary" title="messages">
                                        <i class="fa fa-envelope">
                                            <span class="new_msg" id="unread_<?=$value['customer_id']?>" group_id="<?=$value['customer_id']?>" style="position: absolute;margin: -11px 0px 0px 3px;background-color: red;border-radius: 42%;font-size: 14px;width: auto;">
                                               <?php if($total_unread != 0) echo $total_unread?>
                                            </span>
                                        </i>
                                        
                                    </button>
                                    <i class="bi bi-dot"></i>

                                </a>
                            </td>
                        </tr>
                    <?php
                    }


                    ?>


                </tbody>
            </table>
        </div>
<?php
    
} else {
    echo 'No record found';
}

 include('../Customers/footer.php');


?>
<script>
    $(document).ready(function(){
      var base_url = 'https://app.optimalessentials.com.au/optimalessentials';
      var value_add;
      let get_unread_msg = function(){
        $('.new_msg').each(function() {
        var group_id = $(this).attr('group_id');
        value_add = '';
        var result;
                $.ajax({
                            url: base_url + '/chats/ajax_call_unread_msg.php',
                            data: {
                                customer_id: 1122334455,
                                group_id:group_id
                                
                            },
                            type: "GET",
                            /* or type:"GET" or type:"PUT" */
                            success: function(result) {
                                // console.log(result); 
                                if(result !=0){
                                    
                                 $('#unread_'+group_id).text(result);
                                }
                            },
                            error: function() {
                                console.log("error");
                            }
                        });
                       
                       
         
            });
}
setInterval(get_unread_msg, 5000);
  
  });
</script>