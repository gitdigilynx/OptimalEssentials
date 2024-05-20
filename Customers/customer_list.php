<?php 


require_once("tab.php");

?>
<div class="container-fluid mt-3 display_table_info">
  <!--<h2>Users</h2>          -->
  <div class="table-responsive">
    <table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>Firstname</th>
        <th>Lastname</th>
        <th id="width_email">Email</th>
        <th id="role_th" style="display:none;">Role</th>
        <th id="Assigned_componey" style="display:none;" >
        <!--<th>Secondary</th>-->
        <th id="Assigned_th" style="display:none;" >
            <!--Assigned-->
            </th>
        <th id="Assigned_hcpstaff_th" style="display:none;" >
            <!--Assigned-->
            </th>
        <th id="update_th" style="display:none;" >Action</th>
        <th id="Assigned_hcp_update" style="display:none;" >
      </tr>
    </thead>
    <tbody id="output" >

    </tbody>
  </table>
</div>
</div>

<?php require_once("footer.php") ?>;
<script>
var base_url2 = 'https://app.optimalessentials.com.au/optimalessentials';
     function delete_customer(customer_id) {
   
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

                    
                    $.ajax({
                        url: base_url2 + '/Customers/delete/delete_customer.php',
                        data: {
                            customer_id: customer_id
                        },
                        type: "GET",
                        /* or type:"GET" or type:"PUT" */
                        success: function(result) {
                            // console.log(result);
                            if (result == 'success') {
                                $("#unassign_tr_client_"+customer_id).fadeOut(1000);
                                check_delete = true;
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                );
                            }
                        },
                        error: function() {
                            console.log("error");
                        }
                    });



                }
            });

         

        }
 
</script>


